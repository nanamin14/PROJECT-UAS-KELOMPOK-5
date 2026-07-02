<?php

class ObatKeluar
{
    private $conn;
    private $table = "obat_keluar";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getAll()
    {
        // Menampilkan data beserta nama obat dari kolom 'tanggal'
        $sql = "SELECT ok.*, o.nama_obat FROM obat_keluar ok JOIN obat o ON ok.obat_id = o.id ORDER BY ok.tanggal DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM obat_keluar WHERE id=?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data)
    {
        //cek stok
        $cek = $this->conn->prepare("SELECT stok FROM obat WHERE id=?");
        $cek->execute([$data['obat_id']]);
        $stok = $cek->fetch(PDO::FETCH_ASSOC);

        if (!$stok || $stok['stok'] < $data['jumlah']) {
            return false;
        }

        try {
            $this->conn->beginTransaction();
            //nambah data transaksi obat keluar
            $sql = "INSERT INTO obat_keluar (obat_id, jumlah, tanggal, penerima, keterangan, user_id) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                $data['obat_id'],
                $data['jumlah'],
                $data['tanggal'],
                $data['penerima'], 
                $data['keterangan'],
                $data['user_id']   
            ]);

            //ngurangin stok obat 
            $update = "UPDATE obat SET stok = stok - ? WHERE id = ?";
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

    public function delete($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM obat_keluar WHERE id=?");
        return $stmt->execute([$id]);
    }

    public function total()
    {
        $stmt = $this->conn->prepare("SELECT SUM(jumlah) AS total FROM obat_keluar");
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
