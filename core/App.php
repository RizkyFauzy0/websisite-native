<?php

class App {
    protected $controller = 'Home';
    protected $method = 'index';
    protected $params = [];
    
    public function __construct() {
        $url = $this->parseUrl();
        
        // Check if controller exists
        if (isset($url[0])) {
            // Check for admin prefix
            if ($url[0] === 'admin') {
                if (isset($url[1]) && file_exists('../app/controllers/Admin/' . ucfirst($url[1]) . '.php')) {
                    $this->controller = ucfirst($url[1]);
                    unset($url[0], $url[1]);
                    require_once '../app/controllers/Admin/' . $this->controller . '.php';
                } else {
                    // Default admin dashboard
                    $this->controller = 'Dashboard';
                    unset($url[0]);
                    require_once '../app/controllers/Admin/Dashboard.php';
                }
            } elseif (file_exists('../app/controllers/' . ucfirst($url[0]) . '.php')) {
                $this->controller = ucfirst($url[0]);
                unset($url[0]);
                require_once '../app/controllers/' . $this->controller . '.php';
            } else {
                // Controller not found, load 404 or home
                require_once '../app/controllers/' . $this->controller . '.php';
            }
        } else {
            require_once '../app/controllers/' . $this->controller . '.php';
        }
        
        // Instantiate controller
        $this->controller = new $this->controller;
        
        // Check for method
        if (isset($url[1])) {
            if (method_exists($this->controller, $url[1])) {
                $this->method = $url[1];
                unset($url[1]);
            }
        }
        
        // Get params
        $this->params = $url ? array_values($url) : [];
        
        // Call method with params
        call_user_func_array([$this->controller, $this->method], $this->params);
    }
    
    public function parseUrl() {
        if (isset($_GET['url'])) {
            return explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
        }
        return [];
    }
}
