<?php
include_once __DIR__ . '/../model/Belanja.php';
include_once __DIR__ . '/../model/User.php';

class DashboardController {
    public function __construct() {
        $uri = $_SERVER['REQUEST_URI'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['fullname']) && isset($_POST['description'])) {
                $this->handleProfileUpdate();
            } elseif (isset($_FILES['foto'])) {
                $this->handleTagging();
            }
        }

        // Default: Tampilkan dashboard
        include_once __DIR__ . '/../view/dashboard.php';
    }

    private function handleProfileUpdate() {
        if (!isset($_SESSION['user'])) {
            header("Location: /emvisi/");
            exit;
        }

        $userId = $_SESSION['user']['id'];
        $fullname = $_POST['fullname'];
        $description = $_POST['description'];

        $userModel = new User();
        $success = $userModel->updateProfile($userId, $fullname, $description);

        if ($success) {
            $_SESSION['user']['full_name'] = $fullname;
            $_SESSION['user']['user_description'] = $description;
            $_SESSION['update_success'] = "Profil berhasil diperbarui.";
        } else {
            $_SESSION['update_error'] = "Gagal memperbarui profil.";
        }

        // Tetap tampilkan dashboard
    }

    private function handleTagging() {
    if (!isset($_SESSION['user'])) {
        $_SESSION['tagging_error'] = "Anda harus login.";
        return;
    }

    if (empty($_FILES['foto']['tmp_name'])) {
        $_SESSION['tagging_error'] = "Foto wajib diupload.";
        return;
    }

    $userId = $_SESSION['user']['id'];
    $nama = $_POST['nama_lokasi'];
    $lat = $_POST['latitude'];
    $lng = $_POST['longitude'];
    $radius = $_POST['radius'];

    // cari ID belanja berdasarkan nama
    $belanjaModel = new Belanja();
    $belanja = $belanjaModel->getByName($nama);
    if (!$belanja) {
        $_SESSION['tagging_error'] = "Lokasi tidak ditemukan di database.";
        return;
    }

    $belanjaId = $belanja['id'];

    // upload foto
    $uploadDir = __DIR__ . '/../uploads/';
    $filename = uniqid() . '_' . basename($_FILES['foto']['name']);
    move_uploaded_file($_FILES['foto']['tmp_name'], $uploadDir . $filename);

    // simpan ke tag_belanja
    $success = $belanjaModel->insertTagBelanja($userId, $belanjaId, $lat, $lng, $filename);
    if ($success) {
        $_SESSION['tagging_success'] = "Berhasil menandai lokasi!";
    } else {
        $_SESSION['tagging_error'] = "Gagal menyimpan ke database.";
    }
    }
}

