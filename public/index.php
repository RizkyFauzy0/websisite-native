<?php

// Start session
session_start();

// Load config
require_once '../config/config.php';

// Load core classes
require_once '../core/App.php';
require_once '../core/Controller.php';
require_once '../core/Database.php';

// Initialize the app
$app = new App();
