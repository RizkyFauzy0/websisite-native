<?php

// Database parameters
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'sekolah_db');

// App Root
define('APPROOT', dirname(dirname(__FILE__)));

// URL Root - Update this to your site URL
define('BASE_URL', 'http://localhost/websisite-native/public');

// Site Name
define('SITENAME', 'School Website');

// Error reporting (set to 0 in production)
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);
