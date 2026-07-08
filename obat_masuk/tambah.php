<?php
session_start();
require '../config/database.php';
require '../classes/ObatMasuk.php';

$db = new Database();
$conn = $db->connect();

$obatMasuk = new ObatMasuk($conn);
echo $_SESSION['user'];
exit;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = [
        'obat_id' => $_POST['obat_id'],
        'jumlah' => $_POST['jumlah'],
        'tanggal' => $_POST['tanggal'],
        'supplier' => $_POST['supplier'],
        'user_id' => $_SESSION['user']
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
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Obat Masuk</title>
</head>

<body>
    <h2>Tambah Obat Masuk</h2>
    <form method="POST">
        <label>Nama Obat</label><br>
        <select name="obat_id" required>
            <option value="">Pilih Obat</option>
            <?php foreach ($obat as $o): ?>
                <option value="<?= $o['id'] ?>"><?= $o['nama_obat'] ?></option>
            <?php endforeach; ?>
        </select> <br><br>
        <label>Jumlah</label><br>
        <input type="number" name="jumlah" min="1" required> <br><br>
        <label>Tanggal Masuk</label><br>
        <input type="date" name="tanggal" value="<?= date('Y-m-d') ?>" required> <br><br>
        <label>Supplier</label><br>
        <input type="text" name="supplier"> <br><br>
        <button type="submit">Simpan</button>
        <a href="index.php">Kembali</a>
    </form>
</body>

</html>