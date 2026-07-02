<?php

class ObatMasuk
{
    private $conn;
    private $table = "obat_masuk";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAll() {
        $sql = "SELECT om.*, o.nama_obat FROM obat_masuk om JOIN obat o ON om.obat_id = o.id ORDER BY om.tanggal DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM obat_masuk WHERE id=?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    //add transaksi
    public function create($data) {
        try {
            $this->conn->beginTransaction();
            //masukin transaksi
            $sql = " INSERT INTO obat_masuk (obat_id, jumlah, tanggal, keterangan) VALUES (?, ?, ?, ?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                $data['obat_id'],
                $data['jumlah'],
                $data['tanggal'],
                $data['keterangan']
            ]);
            //update stok obat
            $update = "UPDATE obat SET stok = stok + ? WHERE id = ?";
            $stmt2 = $this->conn->prepare($update);
            $stmt2->execute([
                $data['jumlah'],
                $data['obat_id']
            ]);
            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollBack();
            return false;
        }
    }

    //hapus transaksi
    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM obat_masuk WHERE id=?");
        return $stmt->execute([$id]);
    }

    //total obat masuk
    public function total() {
        $stmt = $this->conn->prepare("SELECT SUM(jumlah) AS total FROM obat_masuk");
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
