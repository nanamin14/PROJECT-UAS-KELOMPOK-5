<?php
require '../config/database.php';
require '../classes/ObatKeluar.php';

$db = new Database();
$conn = $db->connect();

$obatKeluar = new ObatKeluar($conn);
$data = $obatKeluar->getAll();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Obat Keluar</title>
</head>

<body>
    <h2>Data Obat Keluar</h2>
    <a href="tambah.php">Tambah Obat Keluar</a> <br><br>
    <table border="1" cellpadding="10">
        <tr>
            <th>No</th>
            <th>Nama Obat</th>
            <th>Jumlah</th>
            <th>Tanggal Keluar</th>
            <th>Keterangan</th>
            <th>Aksi</th>
        </tr>
        <?php $no = 1;
        foreach ($data as $row): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= $row['nama_obat'] ?></td>
                <td><?= $row['jumlah'] ?></td>
                <td><?= $row['tanggal_keluar'] ?></td>
                <td><?= $row['keterangan'] ?></td>
                <td>
                    <a
                        href="hapus.php?id=<?= $row['id'] ?>"
                        onclick="return confirm('Hapus data?')">
                        Hapus
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>

</html>