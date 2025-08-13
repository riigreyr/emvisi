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
    $nama = $_POST['nama_lokasi'] ?? '';
    $lat = $_POST['latitude'] ?? '';
    $lng = $_POST['longitude'] ?? '';
    $radius = $_POST['radius'] ?? '';

    // Validasi input lokasi
    if (!$nama || !$lat || !$lng) {
        $_SESSION['tagging_error'] = "Data lokasi tidak lengkap.";
        return;
    }

    $belanjaModel = new Belanja();
    $belanja = $belanjaModel->getByName($nama);

    if (!$belanja) {
        $_SESSION['tagging_error'] = "Lokasi tidak ditemukan di database.";
        return;
    }

    $belanjaId = $belanja['id'];

    // Dapatkan koneksi DB
    $conn = $belanjaModel->getConnection();

    // Cek duplikat berdasarkan user_id, belanja_id, latitude, longitude
    $stmt = $conn->prepare("SELECT COUNT(*) FROM tag_belanja WHERE user_id = ? AND belanja_id = ? AND latitude = ? AND longitude = ?");
    if (!$stmt) {
        $_SESSION['tagging_error'] = "Error database: " . $conn->error;
        return;
    }
    $stmt->bind_param("iidd", $userId, $belanjaId, $lat, $lng);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    if ($count > 0) {
        $_SESSION['tagging_error'] = "Anda sudah menandai lokasi ini sebelumnya.";
        return;
    }

    // Upload file
    $uploadDir = __DIR__ . '/../uploads/';
    $fileTmp = $_FILES['foto']['tmp_name'];
    $originalName = basename($_FILES['foto']['name']);
    $ext = pathinfo($originalName, PATHINFO_EXTENSION);
    $filename = uniqid('foto_', true) . '.' . $ext;

    if (!move_uploaded_file($fileTmp, $uploadDir . $filename)) {
        $_SESSION['tagging_error'] = "Gagal upload foto.";
        return;
    }

    // Simpan ke tag_belanja
    $success = $belanjaModel->insertTagBelanja($userId, $belanjaId, $lat, $lng, $filename);

    if ($success) {
        $_SESSION['tagging_success'] = "Berhasil menandai lokasi!";
    } else {
        $_SESSION['tagging_error'] = "Gagal menyimpan data tagging ke database.";
        // Kalau gagal simpan, hapus file yang sudah diupload agar tidak numpuk
        if (file_exists($uploadDir . $filename)) {
            unlink($uploadDir . $filename);
        }
    }
}
}
