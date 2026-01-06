<?php

class App {
    protected $controller = 'Home';
    protected $method = 'index';
    protected $params = [];
    
    public function __construct() {
        $url = $this->parseUrl();
        
        // Check if controller exists
        if (isset($url[0]) && !empty($url[0])) {
            // Check for admin prefix
            if ($url[0] === 'admin') {
                if (isset($url[1]) && !empty($url[1])) {
                    // Convert hyphenated URL to PascalCase for controller name
                    $controllerName = $this->urlToControllerName($url[1]);
                    $controllerFile = '../app/controllers/Admin/' . $controllerName . '.php';
                    if (file_exists($controllerFile)) {
                        $this->controller = $controllerName;
                        unset($url[0], $url[1]);
                        require_once $controllerFile;
                    } else {
                        // Admin controller not found, load dashboard
                        $this->controller = 'Dashboard';
                        unset($url[0]);
                        require_once '../app/controllers/Admin/Dashboard.php';
                    }
                } else {
                    // No admin controller specified, load dashboard
                    $this->controller = 'Dashboard';
                    unset($url[0]);
                    require_once '../app/controllers/Admin/Dashboard.php';
                }
            } else {
                // Regular frontend controller
                $controllerFile = '../app/controllers/' . ucfirst($url[0]) . '.php';
                if (file_exists($controllerFile)) {
                    $this->controller = ucfirst($url[0]);
                    unset($url[0]);
                    require_once $controllerFile;
                } else {
                    // Controller not found, load home
                    require_once '../app/controllers/' . $this->controller . '.php';
                }
            }
        } else {
            // No controller specified, load home
            require_once '../app/controllers/' . $this->controller . '.php';
        }
        
        // Instantiate controller
        $this->controller = new $this->controller;
        
        // Check for method
        if (isset($url[1]) && !empty($url[1])) {
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
            $url = rtrim($_GET['url'], '/');
            // Sanitize URL manually to avoid deprecated FILTER_SANITIZE_URL
            $url = filter_var($url, FILTER_SANITIZE_SPECIAL_CHARS);
            $url = str_replace(['<', '>', '"', "'"], '', $url);
            return explode('/', $url);
        }
        return [];
    }
    
    // Convert URL format to Controller name (e.g., "galeri-foto" -> "GaleriFotoController")
    private function urlToControllerName($url) {
        // Split by hyphen and capitalize each word
        $parts = explode('-', $url);
        $parts = array_map('ucfirst', $parts);
        $controllerName = implode('', $parts) . 'Controller';
        return $controllerName;
    }
}
