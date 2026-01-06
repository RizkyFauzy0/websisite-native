<?php

class SliderController extends Controller {
    
    public function __construct() {
        $this->requireLogin();
        $this->sliderModel = $this->model('SliderModel');
    }
    
    public function index() {
        $data = [
            'title' => 'Manajemen Slider',
            'active_menu' => 'slider',
            'sliders' => $this->sliderModel->getAll()
        ];
        
        $this->view('admin/slider/index', $data);
    }
    
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Handle file upload
            $gambar = '';
            if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
                $upload = $this->uploadFile($_FILES['gambar'], 'uploads/sliders/');
                if ($upload['success']) {
                    $gambar = 'sliders/' . $upload['filename'];
                } else {
                    $this->setFlash('error', $upload['message']);
                    $this->redirect('admin/slider');
                    return;
                }
            }
            
            $data = [
                'judul' => htmlspecialchars($_POST['judul'] ?? ''),
                'deskripsi' => htmlspecialchars($_POST['deskripsi'] ?? ''),
                'gambar' => $gambar,
                'urutan' => (int)($_POST['urutan'] ?? 0),
                'status' => $_POST['status'] ?? 'aktif'
            ];
            
            if ($this->sliderModel->create($data)) {
                $this->setFlash('success', 'Slider berhasil ditambahkan');
            } else {
                $this->setFlash('error', 'Gagal menambahkan slider');
            }
        }
        
        $this->redirect('admin/slider');
    }
    
    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $slider = $this->sliderModel->getById($id);
            
            if (!$slider) {
                $this->setFlash('error', 'Slider tidak ditemukan');
                $this->redirect('admin/slider');
                return;
            }
            
            $data = [
                'judul' => htmlspecialchars($_POST['judul'] ?? ''),
                'deskripsi' => htmlspecialchars($_POST['deskripsi'] ?? ''),
                'urutan' => (int)($_POST['urutan'] ?? 0),
                'status' => $_POST['status'] ?? 'aktif'
            ];
            
            // Handle file upload if new file provided
            if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
                $upload = $this->uploadFile($_FILES['gambar'], 'uploads/sliders/');
                if ($upload['success']) {
                    // Delete old file
                    if (!empty($slider->gambar)) {
                        $this->deleteFile($slider->gambar, 'uploads/');
                    }
                    $data['gambar'] = 'sliders/' . $upload['filename'];
                } else {
                    $this->setFlash('error', $upload['message']);
                    $this->redirect('admin/slider');
                    return;
                }
            }
            
            if ($this->sliderModel->update($id, $data)) {
                $this->setFlash('success', 'Slider berhasil diperbarui');
            } else {
                $this->setFlash('error', 'Gagal memperbarui slider');
            }
        }
        
        $this->redirect('admin/slider');
    }
    
    public function delete($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $slider = $this->sliderModel->getById($id);
            
            if ($slider) {
                // Delete file
                if (!empty($slider->gambar)) {
                    $this->deleteFile($slider->gambar, 'uploads/');
                }
                
                if ($this->sliderModel->delete($id)) {
                    $this->setFlash('success', 'Slider berhasil dihapus');
                } else {
                    $this->setFlash('error', 'Gagal menghapus slider');
                }
            } else {
                $this->setFlash('error', 'Slider tidak ditemukan');
            }
        }
        
        $this->redirect('admin/slider');
    }
}
