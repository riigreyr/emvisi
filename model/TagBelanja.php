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

    
 // Top 5 Klasemen (user terbanyak tagging)
    public function getTopUsers($limit = 5) {
        $sql = "SELECT u.full_name, COUNT(tb.id) AS total 
                FROM tag_belanja tb
                JOIN user u ON tb.user_id = u.id
                GROUP BY u.id
                ORDER BY total DESC
                LIMIT ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $limit);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Top 5 Lokasi
    public function getTopLokasi($limit = 5) {
        $sql = "SELECT b.nama, COUNT(tb.id) AS total 
                FROM tag_belanja tb
                JOIN belanja b ON tb.belanja_id = b.id
                GROUP BY b.id
                ORDER BY total DESC
                LIMIT ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $limit);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Data summary
    public function getSummary() {
        $summary = [];

        // total user
        $summary['total_user'] = $this->conn->query("SELECT COUNT(*) as c FROM user")->fetch_assoc()['c'];

        // total lokasi
        $summary['total_lokasi'] = $this->conn->query("SELECT COUNT(*) as c FROM belanja")->fetch_assoc()['c'];

        // total tagging
        $summary['total_tagging'] = $this->conn->query("SELECT COUNT(*) as c FROM tag_belanja")->fetch_assoc()['c'];

        // latest user tagging
        $sqlUser = "SELECT u.full_name 
                    FROM tag_belanja tb 
                    JOIN user u ON tb.user_id = u.id 
                    ORDER BY tb.entri_at DESC LIMIT 1";
        $resUser = $this->conn->query($sqlUser)->fetch_assoc();
        $summary['latest_user'] = $resUser ? $resUser['full_name'] : '-';

        // latest lokasi tagging
        $sqlLokasi = "SELECT b.nama 
                      FROM tag_belanja tb 
                      JOIN belanja b ON tb.belanja_id = b.id 
                      ORDER BY tb.entri_at DESC LIMIT 1";
        $resLokasi = $this->conn->query($sqlLokasi)->fetch_assoc();
        $summary['latest_lokasi'] = $resLokasi ? $resLokasi['nama'] : '-';

        return $summary;
    }
}


