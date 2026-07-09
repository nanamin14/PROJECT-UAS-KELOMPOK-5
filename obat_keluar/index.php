<?php
session_start();

require '../config/database.php';
require '../classes/ObatKeluar.php';

$db = new Database();
$conn = $db->connect();

$obatKeluar = new ObatKeluar($conn);
$data = $obatKeluar->getAll();
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Obat Keluar</title>

    <link rel="stylesheet" href="../assets/style.css">
</head>

<body>
<div class="container">
    <h2>Data Obat Keluar</h2>
    <div class="action-bar">
        <a href="../dashboard.php" class="btn btn-secondary">
            Kembali
        </a>
        <a href="tambah.php" class="btn btn-primary">
            Tambah Obat Keluar
        </a>
    </div>
    <table>
        <thead>
            <tr>
                <th width="60">No</th>
                <th>Nama Obat</th>
                <th>Jumlah</th>
                <th>Tanggal</th>
                <th>Penerima</th>
                <th>Keterangan</th>
                <th width="180">Aksi</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $no = 1;
        foreach ($data as $row):
        ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= htmlspecialchars($row['nama_obat']) ?></td>
                <td><?= htmlspecialchars($row['jumlah']) ?></td>
                <td><?= htmlspecialchars($row['tanggal']) ?></td>
                <td><?= htmlspecialchars($row['penerima']) ?></td>
                <td><?= htmlspecialchars($row['keterangan']) ?></td>
                <td>
                    <a href="hapus.php?id=<?= $row['id'] ?>"
                       class="btn btn-danger"
                       onclick="return confirm('Yakin ingin menghapus data ini?')">
                        Hapus
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>

</html>