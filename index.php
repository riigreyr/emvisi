<?php
if (session_status() === PHP_SESSION_NONE) session_start();

include_once __DIR__ . "/controller/HomeController.php";
$controller = new HomeController();

// Ambil path dari URL
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Redirect root jika login
if (isset($_SESSION['user']) && ($uri === '/emvisi/' || $uri === '/emvisi')) {
    header("Location: /emvisi/dashboard");
    exit;
}

// Routing untuk dashboard dan logic-nya
if (str_starts_with($uri, '/emvisi/dashboard')) {
    include_once __DIR__ . "/controller/DashboardController.php";
    new DashboardController();
    exit;
}

// Routing check-radius
if ($uri === '/emvisi/check-radius') {
    include_once __DIR__ . '/controller/BelanjaController.php';
    new BelanjaController();
    exit;
}

// Routing peta
if ($uri === '/emvisi/peta' || $uri === '/emvisi/peta/') {
    include_once __DIR__ . "/view/peta.php";
    exit;
}

// Halaman default (home)
include_once __DIR__ . "/view/home.php";
