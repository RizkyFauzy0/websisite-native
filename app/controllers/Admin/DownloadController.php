<?php

class DownloadController extends Controller {
    
    public function __construct() {
        $this->requireLogin();
        $this->downloadModel = $this->model('DownloadModel');
    }
    
    public function index() {
        $data = [
            'title' => 'File Download',
            'active_menu' => 'download',
            'download_list' => $this->downloadModel->getAll()
        ];
        
        $this->view('admin/download/index', $data);
    }
    
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Handle file upload
            $namaFile = '';
            $ukuranFile = '';
            
            if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
                $targetDir = '../public/uploads/downloads/';
                
                if (!is_dir($targetDir)) {
                    mkdir($targetDir, 0777, true);
                }
                
                $fileName = time() . '_' . basename($_FILES['file']['name']);
                $targetFile = $targetDir . $fileName;
                $fileSize = $_FILES['file']['size'];
                
                // Check file size (max 10MB)
                if ($fileSize > 10000000) {
                    $this->setFlash('error', 'Ukuran file terlalu besar (max 10MB)');
                    $this->redirect('admin/download');
                    return;
                }
                
                // Upload file
                if (move_uploaded_file($_FILES['file']['tmp_name'], $targetFile)) {
                    $namaFile = 'downloads/' . $fileName;
                    $ukuranFile = round($fileSize / 1024, 2) . ' KB';
                } else {
                    $this->setFlash('error', 'Gagal mengupload file');
                    $this->redirect('admin/download');
                    return;
                }
            } else {
                $this->setFlash('error', 'File wajib diunggah');
                $this->redirect('admin/download');
                return;
            }
            
            $data = [
                'judul' => htmlspecialchars($_POST['judul'] ?? ''),
                'deskripsi' => htmlspecialchars($_POST['deskripsi'] ?? ''),
                'nama_file' => $namaFile,
                'ukuran_file' => $ukuranFile,
                'tanggal_upload' => $_POST['tanggal_upload'] ?? date('Y-m-d')
            ];
            
            if ($this->downloadModel->create($data)) {
                $this->setFlash('success', 'File berhasil ditambahkan');
            } else {
                $this->setFlash('error', 'Gagal menambahkan file');
            }
        }
        
        $this->redirect('admin/download');
    }
    
    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $download = $this->downloadModel->getById($id);
            
            if (!$download) {
                $this->setFlash('error', 'File tidak ditemukan');
                $this->redirect('admin/download');
                return;
            }
            
            $data = [
                'judul' => htmlspecialchars($_POST['judul'] ?? ''),
                'deskripsi' => htmlspecialchars($_POST['deskripsi'] ?? ''),
                'tanggal_upload' => $_POST['tanggal_upload'] ?? date('Y-m-d')
            ];
            
            // Handle file upload if new file provided
            if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
                $targetDir = '../public/uploads/downloads/';
                
                if (!is_dir($targetDir)) {
                    mkdir($targetDir, 0777, true);
                }
                
                $fileName = time() . '_' . basename($_FILES['file']['name']);
                $targetFile = $targetDir . $fileName;
                $fileSize = $_FILES['file']['size'];
                
                // Check file size (max 10MB)
                if ($fileSize > 10000000) {
                    $this->setFlash('error', 'Ukuran file terlalu besar (max 10MB)');
                    $this->redirect('admin/download');
                    return;
                }
                
                // Upload file
                if (move_uploaded_file($_FILES['file']['tmp_name'], $targetFile)) {
                    // Delete old file
                    if (!empty($download->nama_file)) {
                        $oldFile = '../public/uploads/' . $download->nama_file;
                        if (file_exists($oldFile)) {
                            unlink($oldFile);
                        }
                    }
                    
                    $data['nama_file'] = 'downloads/' . $fileName;
                    $data['ukuran_file'] = round($fileSize / 1024, 2) . ' KB';
                }
            }
            
            if ($this->downloadModel->update($id, $data)) {
                $this->setFlash('success', 'File berhasil diperbarui');
            } else {
                $this->setFlash('error', 'Gagal memperbarui file');
            }
        }
        
        $this->redirect('admin/download');
    }
    
    public function delete($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $download = $this->downloadModel->getById($id);
            
            if ($download) {
                // Delete file
                if (!empty($download->nama_file)) {
                    $file = '../public/uploads/' . $download->nama_file;
                    if (file_exists($file)) {
                        unlink($file);
                    }
                }
                
                if ($this->downloadModel->delete($id)) {
                    $this->setFlash('success', 'File berhasil dihapus');
                } else {
                    $this->setFlash('error', 'Gagal menghapus file');
                }
            } else {
                $this->setFlash('error', 'File tidak ditemukan');
            }
        }
        
        $this->redirect('admin/download');
    }
}
