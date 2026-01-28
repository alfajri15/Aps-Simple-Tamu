<?php
require_once __DIR__ . '/../config/database.php';

class md_tamu {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function getAll() {
        return $this->conn->query("SELECT * FROM tamu ORDER BY id DESC");
    }

    public function getById($id) {
        return $this->conn->query("SELECT * FROM tamu WHERE id='$id'")->fetch_assoc();
    }

    public function insert($nama, $alamat) {
        return $this->conn->query("INSERT INTO tamu (nama, alamat) VALUES ('$nama','$alamat')");
    }

    public function update($id, $nama, $alamat) {
        return $this->conn->query("UPDATE tamu SET nama='$nama', alamat='$alamat' WHERE id='$id'");
    }

    public function delete($id) {
        return $this->conn->query("DELETE FROM tamu WHERE id='$id'");
    }
}
