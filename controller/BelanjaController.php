<?php
include_once __DIR__ . '/../model/Belanja.php';

class BelanjaController {
    public function __construct() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $input = json_decode(file_get_contents("php://input"), true);
            $lat = floatval($input['latitude']);
            $lng = floatval($input['longitude']);

            function hitungJarak($lat1, $lon1, $lat2, $lon2) {
    $R = 6371000000; // meter
    $dLat = deg2rad($lat2 - $lat1);
    $dLon = deg2rad($lon2 - $lon1);
    $a = sin($dLat/2) * sin($dLat/2) +
         cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
         sin($dLon/2) * sin($dLon/2);
    $c = 2 * atan2(sqrt($a), sqrt(1-$a));
    return $R * $c;
}

// misal di controller TaggingController.php atau file upload handler

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['foto'])) {
    $targetDir = __DIR__ . '/../uploads/';
    $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
    $fileName = 'foto_' . uniqid() . '.' . $ext;
    $targetFile = $targetDir . $fileName;

    if (move_uploaded_file($_FILES['foto']['tmp_name'], $targetFile)) {
        // Sukses upload, simpan $fileName ke DB di kolom path_foto
        // Contoh:
        // $modelBelanja->insertTagBelanja($user_id, $belanja_id, $lat, $lng, $fileName);
    } else {
        // Gagal upload, beri notifikasi error
    }
}



            $model = new Belanja();
            $lokasiTerdekat = $model->findNearestWithinRadius($lat, $lng, 3000, 4);

            if (!empty($lokasiTerdekat)) {
                $lokasi = $lokasiTerdekat[0]; // ambil lokasi terdekat
                echo json_encode([
                    'success' => true,
                    'nama' => $lokasi['nama'],
                    'jarak' => round($lokasi['distance'], 2),
                    'radius' => $lokasi['radius']
                ]);
                return;
            }

            echo json_encode(['success' => false]);
        }  
    }
}

        