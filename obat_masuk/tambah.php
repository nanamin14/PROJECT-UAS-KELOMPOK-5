<?php
session_start();

require '../config/database.php';
require '../classes/ObatMasuk.php';

$db = new Database();
$conn = $db->connect();

$obatMasuk = new ObatMasuk($conn);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $data = [
        'obat_id'  => $_POST['obat_id'],
        'jumlah'   => $_POST['jumlah'],
        'tanggal'  => $_POST['tanggal'],
        'supplier' => $_POST['supplier'],
        'user_id'  => $_SESSION['user']
    ];

    if ($obatMasuk->create($data)) {
        header("Location:index.php");
        exit;
    } else {
        echo "Gagal menyimpan data.";
    }
}

$obat = $conn->query("SELECT * FROM obat ORDER BY nama_obat");
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Obat Masuk</title>

    <link rel="stylesheet" href="../assets/style.css">
</head>

<body>

<div class="container">

    <h2>Tambah Obat Masuk</h2>

    <div class="action-bar">

        <a href="index.php" class="btn btn-secondary">
            ← Kembali
        </a>

    </div>

    <form method="POST">

        <label>Nama Obat</label>

        <select name="obat_id" required>

            <option value="">Pilih Obat</option>

            <?php foreach ($obat as $o): ?>

                <option value="<?= $o['id'] ?>">
                    <?= htmlspecialchars($o['nama_obat']) ?>
                </option>

            <?php endforeach; ?>

        </select>

        <label>Jumlah</label>

        <input
            type="number"
            name="jumlah"
            min="1"
            placeholder="Masukkan jumlah obat..."
            required>

        <label>Tanggal Masuk</label>

        <input
            type="date"
            name="tanggal"
            value="<?= date('Y-m-d') ?>"
            required>

        <label>Supplier</label>

        <input
            type="text"
            name="supplier"
            placeholder="Masukkan nama supplier...">

        <button type="submit" class="btn btn-primary">
            Simpan Data
        </button>

    </form>

</div>

</body>

</html>