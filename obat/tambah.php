<?php
require '../config/Database.php';
require '../classes/Obat.php';
require '../middleware/AuthMiddleware.php';

AuthMiddleware::check();

$db = new Database();
$conn = $db->connect();

$obat = new Obat($conn);

$pesan = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $kode_obat    = trim($_POST['kode_obat']);
    $nama_obat    = trim($_POST['nama_obat']);
    $kategori     = trim($_POST['kategori']);
    $satuan       = trim($_POST['satuan']);
    $stok         = trim($_POST['stok']);
    $stok_minimum = trim($_POST['stok_minimum']);
    $lokasi       = trim($_POST['lokasi']);

    // Validasi
    if (empty($kode_obat) || empty($nama_obat) || empty($kategori) || empty($satuan)) {
        $pesan = "Semua field wajib diisi.";
    } elseif ($stok < 0 || $stok_minimum < 0) {
        $pesan = "Stok tidak boleh bernilai negatif.";
    } else {
        $cek = $obat->checkKode($kode_obat);

        if ($cek['total'] > 0) {
            $pesan = "Kode obat sudah digunakan.";
        } else {
            $data = [
                "kode_obat"    => $kode_obat,
                "nama_obat"    => $nama_obat,
                "kategori"     => $kategori,
                "satuan"       => $satuan,
                "stok"         => $stok,
                "stok_minimum" => $stok_minimum,
                "lokasi"       => $lokasi
            ];

            if ($obat->create($data)) {
                header("Location: index.php");
                exit;
            } else {
                $pesan = "Data gagal disimpan.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Tambah Obat</title>
    <style>
        body {
            font-family: Arial;
            background: #f4f4f4;
            margin: 30px;
        }

        .container {
            width: 600px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
        }

        input, select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            box-sizing: border-box;
        }

        button {
            padding: 10px 20px;
            background: green;
            color: white;
            border: none;
            cursor: pointer;
        }

        a {
            text-decoration: none;
        }

        .error {
            color: red;
            margin-bottom: 15px;
        }
    </style>
</head>

<body>

    <div class="container">
        <h2>Tambah Data Obat</h2>

        <?php if ($pesan != "") : ?>
            <div class='error'><?= $pesan ?></div>
        <?php endif; ?>

        <form method="POST">
            <label>Kode Obat</label>
            <input type="text" name="kode_obat" required>

            <label>Nama Obat</label>
            <input type="text" name="nama_obat" required>

            <label>Kategori</label>
            <select name="kategori" required>
                <option value="">-- Pilih --</option>
                <option>Tablet</option>
                <option>Kapsul</option>
                <option>Sirup</option>
                <option>Salep</option>
                <option>Tetes</option>
                <option>Vitamin</option>
                <option>Antibiotik</option>
            </select>

            <label>Satuan</label>
            <select name="satuan" required>
                <option value="">-- Pilih --</option>
                <option>Box</option>
                <option>Strip</option>
                <option>Botol</option>
                <option>Tube</option>
                <option>Pcs</option>
            </select>

            <label>Stok</label>
            <input type="number" name="stok" required>

            <label>Stok Minimum</label>
            <input type="number" name="stok_minimum" required>

            <label>Lokasi Penyimpanan</label>
            <input type="text" name="lokasi" required>

            <button type="submit">Simpan</button>
            <a href="index.php">Kembali</a>
        </form>
    </div>

</body>
</html>