<?php
require '../config/Database.php';
require '../classes/Obat.php';
require '../middleware/AuthMiddleware.php';

AuthMiddleware::check();

$db = new Database();
$conn = $db->connect();

$obat = new Obat($conn);

// Cek ID
if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = $_GET['id'];

$dataObat = $obat->getById($id);

if (!$dataObat) {
    die("Data obat tidak ditemukan.");
}

$pesan = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $kode_obat    = trim($_POST['kode_obat']);
    $nama_obat    = trim($_POST['nama_obat']);
    $kategori     = trim($_POST['kategori']);
    $satuan       = trim($_POST['satuan']);
    $stok         = trim($_POST['stok']);
    $stok_minimum = trim($_POST['stok_minimum']);
    $lokasi       = trim($_POST['lokasi']);

    if (empty($kode_obat) || empty($nama_obat) || empty($kategori) || empty($satuan)) {
        $pesan = "Semua field wajib diisi.";
    } elseif ($stok < 0 || $stok_minimum < 0) {
        $pesan = "Stok tidak boleh bernilai negatif.";
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

        if ($obat->update($id, $data)) {
            header("Location: index.php");
            exit;
        } else {
            $pesan = "Data gagal diubah.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Edit Data Obat</title>
    <style>
        body {
            font-family: Arial;
            background: #f5f5f5;
        }

        .container {
            width: 600px;
            margin: 30px auto;
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
            background: orange;
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
        <h2>Edit Data Obat</h2>

        <?php if ($pesan != "") : ?>
            <div class='error'><?= $pesan ?></div>
        <?php endif; ?>

        <form method="POST">
            <label>Kode Obat</label>
            <input type="text" name="kode_obat" value="<?= htmlspecialchars($dataObat['kode_obat']) ?>" required>

            <label>Nama Obat</label>
            <input type="text" name="nama_obat" value="<?= htmlspecialchars($dataObat['nama_obat']) ?>" required>

            <label>Kategori</label>
            <select name="kategori" required>
                <option <?= $dataObat['kategori'] == "Tablet" ? "selected" : "" ?>>Tablet</option>
                <option <?= $dataObat['kategori'] == "Kapsul" ? "selected" : "" ?>>Kapsul</option>
                <option <?= $dataObat['kategori'] == "Sirup" ? "selected" : "" ?>>Sirup</option>
                <option <?= $dataObat['kategori'] == "Salep" ? "selected" : "" ?>>Salep</option>
                <option <?= $dataObat['kategori'] == "Tetes" ? "selected" : "" ?>>Tetes</option>
                <option <?= $dataObat['kategori'] == "Vitamin" ? "selected" : "" ?>>Vitamin</option>
                <option <?= $dataObat['kategori'] == "Antibiotik" ? "selected" : "" ?>>Antibiotik</option>
            </select>

            <label>Satuan</label>
            <select name="satuan" required>
                <option <?= $dataObat['satuan'] == "Box" ? "selected" : "" ?>>Box</option>
                <option <?= $dataObat['satuan'] == "Strip" ? "selected" : "" ?>>Strip</option>
                <option <?= $dataObat['satuan'] == "Botol" ? "selected" : "" ?>>Botol</option>
                <option <?= $dataObat['satuan'] == "Tube" ? "selected" : "" ?>>Tube</option>
                <option <?= $dataObat['satuan'] == "Pcs" ? "selected" : "" ?>>Pcs</option>
            </select>

            <label>Stok</label>
            <input type="number" name="stok" value="<?= $dataObat['stok'] ?>" required>

            <label>Stok Minimum</label>
            <input type="number" name="stok_minimum" value="<?= $dataObat['stok_minimum'] ?>" required>

            <label>Lokasi</label>
            <input type="text" name="lokasi" value="<?= htmlspecialchars($dataObat['lokasi']) ?>" required>

            <button type="submit">Update</button>
            <a href="index.php">Kembali</a>
        </form>
    </div>

</body>
</html>