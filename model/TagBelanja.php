<?php
include_once __DIR__ . '/../db.php';

class TagBelanja {
    private $conn;

    public function __construct() {
        global $conn;
        $this->conn = $conn;
    }

    public function getRecentUserTaggingPhotos($limit = 5) {
        $sql = "SELECT tb.path_foto, b.nama, tb.entri_at 
                FROM tag_belanja tb 
                JOIN belanja b ON tb.belanja_id = b.id 
                ORDER BY tb.entri_at DESC 
                LIMIT ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $limit);
        $stmt->execute();
        $result = $stmt->get_result();
        $photos = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $photos;
    }
}
