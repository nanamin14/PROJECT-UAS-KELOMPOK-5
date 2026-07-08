<?php

class Obat
{
    private $conn;
    private $table = "obat";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getAll()
    {
        $query = "SELECT * FROM {$this->table}
                  ORDER BY nama_obat ASC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $query = "SELECT * FROM {$this->table}
                  WHERE id = ?";

        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data)
    {
        $query = "INSERT INTO {$this->table}
        (
            kode_obat,
            nama_obat,
            kategori,
            satuan,
            stok,
            stok_minimum,
            lokasi
        )
        VALUES
        (
            :kode_obat,
            :nama_obat,
            :kategori,
            :satuan,
            :stok,
            :stok_minimum,
            :lokasi
        )";

        $stmt = $this->conn->prepare($query);

        return $stmt->execute([
            ':kode_obat' => $data['kode_obat'],
            ':nama_obat' => $data['nama_obat'],
            ':kategori' => $data['kategori'],
            ':satuan' => $data['satuan'],
            ':stok' => $data['stok'],
            ':stok_minimum' => $data['stok_minimum'],
            ':lokasi' => $data['lokasi']
        ]);
    }

    public function update($id, $data)
    {
        $query = "UPDATE {$this->table}
                  SET
                    kode_obat = :kode_obat,
                    nama_obat = :nama_obat,
                    kategori = :kategori,
                    satuan = :satuan,
                    stok = :stok,
                    stok_minimum = :stok_minimum,
                    lokasi = :lokasi
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        return $stmt->execute([
            ':kode_obat' => $data['kode_obat'],
            ':nama_obat' => $data['nama_obat'],
            ':kategori' => $data['kategori'],
            ':satuan' => $data['satuan'],
            ':stok' => $data['stok'],
            ':stok_minimum' => $data['stok_minimum'],
            ':lokasi' => $data['lokasi'],
            ':id' => $id
        ]);
    }

    public function delete($id)
    {
        $query = "DELETE FROM {$this->table}
                  WHERE id = ?";

        $stmt = $this->conn->prepare($query);

        return $stmt->execute([$id]);
    }

    public function search($keyword)
    {
        $query = "SELECT *
                  FROM {$this->table}
                  WHERE
                        kode_obat LIKE ?
                     OR nama_obat LIKE ?
                     OR kategori LIKE ?
                  ORDER BY nama_obat";

        $stmt = $this->conn->prepare($query);

        $search = "%{$keyword}%";

        $stmt->execute([
            $search,
            $search,
            $search
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function checkKode($kode)
    {
        $query = "SELECT COUNT(*) as total
                  FROM {$this->table}
                  WHERE kode_obat=?";

        $stmt = $this->conn->prepare($query);
        $stmt->execute([$kode]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function totalObat()
    {
        $query = "SELECT COUNT(*) AS total
                  FROM {$this->table}";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function totalStok()
    {
        $query = "SELECT SUM(stok) AS total
                  FROM {$this->table}";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function stokMinimum()
    {
        $query = "SELECT *
                  FROM {$this->table}
                  WHERE stok <= stok_minimum
                  ORDER BY stok ASC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateStok($id, $stokBaru)
    {
        $query = "UPDATE {$this->table}
                  SET stok = ?
                  WHERE id = ?";

        $stmt = $this->conn->prepare($query);

        return $stmt->execute([
            $stokBaru,
            $id
        ]);
    }
}