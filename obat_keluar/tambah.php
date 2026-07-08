<?php
session_start();
require '../config/database.php';
require '../classes/ObatKeluar.php';

if (!isset($_SESSION['user'])) {
    die("Anda harus login terlebih dahulu!");
}

$db = new Database();
$conn = $db->connect();

$obatKeluar = new ObatKeluar($conn);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = [
        'obat_id'    => $_POST['obat_id'],
        'jumlah'     => $_POST['jumlah'],
        'tanggal'    => $_POST['tanggal'],
        'penerima'   => $_POST['penerima'],
        'keterangan' => $_POST['keterangan'],
        'user_id'    => $_SESSION['user']
    ];

    if ($obatKeluar->create($data)) {
        header("Location: index.php");
        exit;
    } else {
        echo "<script>
                alert('Stok tidak mencukupi atau data salah!');
              </script>";
    }
}

$obat = $conn->query("SELECT * FROM obat ORDER BY nama_obat");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Obat Keluar</title>
</head>

<body>
    <h2>Tambah Obat Keluar</h2>
    <form method="POST">
        <label>Nama Obat</label><br>
        <select name="obat_id" required>
            <option value="">Pilih Obat</option>
            <?php foreach ($obat as $o): ?>
                <option value="<?= $o['id'] ?>"><?= $o['nama_obat'] ?> (Stok: <?= $o['stok'] ?>)</option>
            <?php endforeach; ?>
        </select> <br><br>
        <label>Jumlah</label><br>
        <input type="number" name="jumlah" min="1" required> <br><br>
        <label>Tanggal</label><br>
        <input type="date" name="tanggal" value="<?= date('Y-m-d') ?>" required> <br><br>
        <label>Penerima</label><br>
        <input type="text" name="penerima" placeholder="Nama penerima obat..." required> <br><br>
        <label>Keterangan</label><br>
        <input type="text" name="keterangan" placeholder="Alasan keluar / keperluan..."> <br><br>
        <button type="submit">Simpan</button>
        <a href="index.php">Kembali</a>
    </form>
</body>

</html>