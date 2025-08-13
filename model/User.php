<?php
include_once __DIR__ . '/../db.php';

class User {
    private $conn;

    public function __construct() {
        global $conn;
        $this->conn = $conn;
    }

    public function getByEmail($email) {
    $stmt = $this->conn->prepare("SELECT * FROM user WHERE user_email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();
    return $user;
}

public function updateProfile($id, $fullname, $description) {
    $stmt = $this->conn->prepare("UPDATE user SET full_name = ?, user_description = ? WHERE id = ?");
    $stmt->bind_param("ssi", $fullname, $description, $id);
    return $stmt->execute();
}

public function getUserTaggingPhotos($userId) {
    $stmt = $this->conn->prepare("
        SELECT path_foto 
        FROM tag_belanja 
        WHERE user_id = ? 
        ORDER BY entri_at DESC
    ");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $photos = [];
    while ($row = $result->fetch_assoc()) {
        $photos[] = $row['path_foto'];
    }
    $stmt->close();
    return $photos;
}





    public function register($email, $password, $fullname, $description) {
        $stmt = $this->conn->prepare("SELECT * FROM user WHERE user_email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            return "Email sudah terdaftar.";
        }
        

        

        $stmt->close();

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->conn->prepare("INSERT INTO user (user_email, user_password, full_name, user_description) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $email, $hashedPassword, $fullname, $description);
        $success = $stmt->execute();
        $stmt->close();

        return $success ? "Registrasi berhasil! Silakan login." : "Gagal mendaftar.";
    }
}


