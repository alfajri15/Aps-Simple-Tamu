<?php
require_once __DIR__ . '/../models/md_tamu.php';

class TamuController {
    private $model;

    public function __construct() {
        $this->model = new md_tamu();
    }

    public function index() {
        return $this->model->getAll();
    }

    public function store($data) {
        return $this->model->insert($data['nama'], $data['alamat']);
    }

    public function edit($id) {
        return $this->model->getById($id);
    }

    public function update($data) {
        return $this->model->update($data['id'], $data['nama'], $data['alamat']);
    }

    public function destroy($id) {
        return $this->model->delete($id);
    }
}
