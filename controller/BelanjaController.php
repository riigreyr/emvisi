<?php
include_once __DIR__ . '/../model/Belanja.php';

class BelanjaController {
    public function __construct() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $input = json_decode(file_get_contents("php://input"), true);
            $lat = floatval($input['latitude']);
            $lng = floatval($input['longitude']);

            $model = new Belanja();
            $lokasiTerdekat = $model->findNearestWithinRadius($lat, $lng, 1000, 3); // ambil 3 lokasi

            if (!empty($lokasiTerdekat)) {
                $lokasi = $lokasiTerdekat[0]; // pakai lokasi terdekat
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
        