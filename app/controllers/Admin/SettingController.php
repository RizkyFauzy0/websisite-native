<?php

class SettingController extends Controller {
    
    public function __construct() {
        $this->requireLogin();
        $this->settingModel = $this->model('SettingModel');
    }
    
    public function index() {
        $data = [
            'title' => 'Pengaturan Sekolah',
            'active_menu' => 'setting',
            'settings' => $this->settingModel->getSettings()
        ];
        
        $this->view('admin/setting/index', $data);
    }
    
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $settings = $this->settingModel->getSettings();
            
            $data = [
                'nama_sekolah' => htmlspecialchars($_POST['nama_sekolah'] ?? ''),
                'alamat' => htmlspecialchars($_POST['alamat'] ?? ''),
                'no_telp' => htmlspecialchars($_POST['no_telp'] ?? ''),
                'email' => htmlspecialchars($_POST['email'] ?? ''),
                'website' => htmlspecialchars($_POST['website'] ?? ''),
                'koordinat_maps' => htmlspecialchars($_POST['koordinat_maps'] ?? ''),
                'facebook' => htmlspecialchars($_POST['facebook'] ?? ''),
                'instagram' => htmlspecialchars($_POST['instagram'] ?? ''),
                'youtube' => htmlspecialchars($_POST['youtube'] ?? '')
            ];
            
            // Handle logo upload if new file provided
            if (isset($_FILES['logo']) && $_FILES['logo']['error'] == 0) {
                $upload = $this->uploadFile($_FILES['logo'], 'uploads/logo/');
                if ($upload['success']) {
                    // Delete old logo
                    if ($settings && !empty($settings->logo)) {
                        $this->deleteFile($settings->logo, 'uploads/');
                    }
                    $data['logo'] = 'logo/' . $upload['filename'];
                }
            }
            
            if ($this->settingModel->update($data)) {
                $this->setFlash('success', 'Pengaturan berhasil disimpan');
            } else {
                $this->setFlash('error', 'Gagal menyimpan pengaturan');
            }
        }
        
        $this->redirect('admin/setting');
    }
}
