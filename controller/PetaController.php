<?php
include_once __DIR__ . '/../model/Belanja.php';

class PetaController {
    private $belanjaModel;

    public function __construct() {
        $this->belanjaModel = new Belanja();
    }

    public function getDataBelanja() {
        return $this->belanjaModel->getAll();
    }

    // Ambil data tagging (join tag_belanja, belanja, user)
    public function getDataTagging() {
        $conn = $this->belanjaModel->getConnection();
        $sql = "SELECT t.latitude, t.longitude, t.path_foto, b.nama AS nama_belanja, u.full_name AS nama_user
                FROM tag_belanja t 
                JOIN belanja b ON t.belanja_id = b.id
                JOIN user u ON t.user_id = u.id";
        $result = $conn->query($sql);
        if (!$result) return [];
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
