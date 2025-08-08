<?php
include_once __DIR__ . '/../model/User.php';

class HomeController {
    private $userModel;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $this->userModel = new User();

        // Handle POST (register & login)
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['register'])) $this->handleRegister();
            if (isset($_POST['login'])) $this->handleLogin();
        }

        // Handle logout via GET
        if (isset($_GET['logout'])) {
            $this->handleLogout();
        }
    }

    private function handleRegister() {
        if (empty($_POST['email']) || empty($_POST['password']) || empty($_POST['fullname'])) {
            $_SESSION['notif_register'] = "<div class='alert alert-warning mt-2'>Isi semua field wajib diisi.</div>";
            return;
        }

        $email = trim($_POST['email']);
        $password = trim($_POST['password']);
        $fullname = trim($_POST['fullname']);
        $description = trim($_POST['description']);

        $result = $this->userModel->register($email, $password, $fullname, $description);

        if (str_contains($result, 'berhasil')) {
            $_SESSION['notif_register'] = "<div class='alert alert-success mt-2'><strong>Registrasi berhasil!</strong> Silakan login.</div>";
            $_SESSION['switch_to_login'] = true;
        } else {
            $_SESSION['notif_register'] = "<div class='alert alert-warning mt-2'><strong>Gagal!</strong> $result</div>";
        }
    }

    private function handleLogin() {
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);

        $user = $this->userModel->getByEmail($email);

        if (!$user || !password_verify($password, $user['user_password'])) {
            $_SESSION['notif_login'] = "Email atau password salah.";
            return;
        }

        if ($user['is_active'] !== '1') {
            $_SESSION['notif_login'] = "Akun Anda belum aktif.";
            return;
        }

        // Simpan data user ke session
        $_SESSION['user'] = $user;

        // Redirect ke dashboard
        header("Location: /emvisi/dashboard");
        exit;
    }

    private function handleLogout() {
        session_destroy();
        header("Location: /emvisi/");
        exit;
    }
}
