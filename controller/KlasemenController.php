<?php
include_once __DIR__ . '/../model/TagBelanja.php';

class KlasemenController {
    private $model;

    public function __construct() {
        $this->model = new TagBelanja();
    }

    public function getData() {
        return [
            'top_users' => $this->model->getTopUsers(),
            'top_lokasi' => $this->model->getTopLokasi(),
            'summary' => $this->model->getSummary()
        ];
    }
}
