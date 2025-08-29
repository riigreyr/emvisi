<?php
class AdminController {
    public function __construct() {
        if (!isset($_SESSION['user']) || strtolower($_SESSION['user']['group_user']) !== 'admin') {
            header("Location: /emvisi/dashboard");
            exit;
        }

        // Load view admin
        include_once __DIR__ . '/../view/admin.php';
    }
}
