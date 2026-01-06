<?php

class Download extends Controller {
    
    public function __construct() {
        $this->downloadModel = $this->model('DownloadModel');
        $this->homeModel = $this->model('HomeModel');
    }
    
    public function index() {
        $data = [
            'title' => 'Download',
            'settings' => $this->homeModel->getSettings(),
            'downloads' => $this->downloadModel->getAllDownloads()
        ];
        
        $this->view('frontend/download', $data);
    }
    
    public function file($id) {
        $file = $this->downloadModel->getFileById($id);
        
        if ($file) {
            $this->downloadModel->incrementDownload($id);
            $filePath = '../public/uploads/downloads/' . $file->nama_file;
            
            if (file_exists($filePath)) {
                header('Content-Description: File Transfer');
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename="' . basename($file->nama_file) . '"');
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                header('Content-Length: ' . filesize($filePath));
                readfile($filePath);
                exit;
            }
        }
        
        $this->redirect('download');
    }
}
