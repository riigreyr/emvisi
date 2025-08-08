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

    // Bisa tambahkan method lain sesuai kebutuhan
}
