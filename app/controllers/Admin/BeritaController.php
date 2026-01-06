<?php

class BeritaController extends Controller {
    
    public function __construct() {
        $this->requireLogin();
        $this->beritaModel = $this->model('BeritaModel');
    }
    
    public function index() {
        $data = [
            'title' => 'Manajemen Berita',
            'active_menu' => 'berita',
            'berita_list' => $this->beritaModel->getAll()
        ];
        
        $this->view('admin/berita/index', $data);
    }
    
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Handle file upload
            $gambar = '';
            if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
                $upload = $this->uploadFile($_FILES['gambar'], 'uploads/berita/');
                if ($upload['success']) {
                    $gambar = 'berita/' . $upload['filename'];
                } else {
                    $this->setFlash('error', $upload['message']);
                    $this->redirect('admin/berita');
                    return;
                }
            }
            
            // Generate slug
            $judul = $_POST['judul'] ?? '';
            $slug = $this->generateSlug($judul);
            
            $data = [
                'judul' => htmlspecialchars($judul),
                'slug' => $slug,
                'isi_berita' => $_POST['isi_berita'] ?? '',
                'gambar' => $gambar,
                'penulis' => htmlspecialchars($_POST['penulis'] ?? $_SESSION['admin_nama']),
                'tanggal_publish' => $_POST['tanggal_publish'] ?? date('Y-m-d'),
                'status' => $_POST['status'] ?? 'draft'
            ];
            
            if ($this->beritaModel->create($data)) {
                $this->setFlash('success', 'Berita berhasil ditambahkan');
            } else {
                $this->setFlash('error', 'Gagal menambahkan berita');
            }
        }
        
        $this->redirect('admin/berita');
    }
    
    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $berita = $this->beritaModel->getById($id);
            
            if (!$berita) {
                $this->setFlash('error', 'Berita tidak ditemukan');
                $this->redirect('admin/berita');
                return;
            }
            
            // Generate slug
            $judul = $_POST['judul'] ?? '';
            $slug = $this->generateSlug($judul);
            
            $data = [
                'judul' => htmlspecialchars($judul),
                'slug' => $slug,
                'isi_berita' => $_POST['isi_berita'] ?? '',
                'penulis' => htmlspecialchars($_POST['penulis'] ?? $_SESSION['admin_nama']),
                'tanggal_publish' => $_POST['tanggal_publish'] ?? date('Y-m-d'),
                'status' => $_POST['status'] ?? 'draft'
            ];
            
            // Handle file upload if new file provided
            if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
                $upload = $this->uploadFile($_FILES['gambar'], 'uploads/berita/');
                if ($upload['success']) {
                    // Delete old file
                    if (!empty($berita->gambar)) {
                        $this->deleteFile($berita->gambar, 'uploads/');
                    }
                    $data['gambar'] = 'berita/' . $upload['filename'];
                }
            }
            
            if ($this->beritaModel->update($id, $data)) {
                $this->setFlash('success', 'Berita berhasil diperbarui');
            } else {
                $this->setFlash('error', 'Gagal memperbarui berita');
            }
        }
        
        $this->redirect('admin/berita');
    }
    
    public function delete($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $berita = $this->beritaModel->getById($id);
            
            if ($berita) {
                // Delete file
                if (!empty($berita->gambar)) {
                    $this->deleteFile($berita->gambar, 'uploads/');
                }
                
                if ($this->beritaModel->delete($id)) {
                    $this->setFlash('success', 'Berita berhasil dihapus');
                } else {
                    $this->setFlash('error', 'Gagal menghapus berita');
                }
            } else {
                $this->setFlash('error', 'Berita tidak ditemukan');
            }
        }
        
        $this->redirect('admin/berita');
    }
    
    private function generateSlug($text) {
        $text = strtolower($text);
        $text = preg_replace('/[^a-z0-9]+/', '-', $text);
        $text = trim($text, '-');
        return $text;
    }
}
