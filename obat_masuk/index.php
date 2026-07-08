<?php
require '../config/database.php';
require '../classes/ObatMasuk.php';

$db = new Database();
$conn = $db->connect();

$obatMasuk = new ObatMasuk($conn);
$data = $obatMasuk->getAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Obat Masuk</title>
</head>

<body>
    <h2>Data Obat Masuk</h2>
    <a href="tambah.php">Tambah Obat Masuk</a>
    <a href="../dashboard.php">Kembali</a><br><br>
    <table border="1" cellpadding="10">
        <tr>
            <th>No</th>
            <th>Nama Obat</th>
            <th>Jumlah</th>
            <th>Tanggal</th>
            <th>Supplier</th>
            <th>User ID</th>
            <th>Aksi</th>
        </tr>
        <?php
        $no = 1;
        foreach ($data as $row):
        ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= $row['nama_obat'] ?></td>
                <td><?= $row['jumlah'] ?></td>
                <td><?= $row['tanggal'] ?></td>
                <td><?= $row['supplier'] ?></td>
                <td><?= $row['user_id'] ?></td>
                <td>
                    <a href="hapus.php?id=<?= $row['id'] ?>"
                        onclick="return confirm('Hapus data?')">
                        Hapus
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>

</html>