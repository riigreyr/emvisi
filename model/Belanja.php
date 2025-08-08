<?php
include_once __DIR__ . '/../db.php';

class Belanja {
    private $conn;

    public function findNearestWithinRadius($latitude, $longitude, $radius = 1000, $limit = 3) {
    $stmt = $this->conn->prepare("
        SELECT *,
    (6371000 * ACOS(
        COS(RADIANS(:latitude)) * COS(RADIANS(latitude)) * COS(RADIANS(longitude) - RADIANS(:longitude)) +
        SIN(RADIANS(:latitude)) * SIN(RADIANS(latitude))
    )) AS distance
FROM warkop
HAVING distance < 1000
ORDER BY distance ASC
LIMIT 3;");
    $stmt->bind_param("dddii", $latitude, $longitude, $latitude, $radius, $limit);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}



// cari data belanja berdasarkan nama
public function getByName($nama) {
    $stmt = $this->conn->prepare("SELECT * FROM belanja WHERE nama = ? LIMIT 1");
    $stmt->bind_param("s", $nama);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

// insert ke tabel tag_belanja
public function insertTagBelanja($user_id, $belanja_id, $lat, $lng, $foto) {
    $stmt = $this->conn->prepare("INSERT INTO tag_belanja (user_id, belanja_id, latitude, longitude, path_foto) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("iidds", $user_id, $belanja_id, $lat, $lng, $foto);
    return $stmt->execute();
}




    public function __construct() {
        global $conn;
        $this->conn = $conn;
    }

    public function getAll() {
        $result = $this->conn->query("SELECT * FROM belanja");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function insertTagging($user_id, $nama, $lat, $lng, $radius, $filename) {
        $stmt = $this->conn->prepare("INSERT INTO belanja (user_id, nama, latitude, longitude, radius, foto) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("issdds", $user_id, $nama, $lat, $lng, $radius, $filename);
        return $stmt->execute();
    }

    public function getConnection() {
        return $this->conn;
    }
}
