<?php
require "../config/database.php";
$db = new Database();
$conn = $db->connect();

//laporan stok obatnya
$stok = $conn->query("SELECT * FROM obat ORDER BY nama_obat");
//laporan obat masuk
$masuk = $conn->query("SELECT om.*, o.nama_obat FROM obat_masuk om JOIN obat o ON om.obat_id = o.id ORDER BY om.tanggal_masuk DESC");
//obat keluar
$keluar = $conn->query("SELECT ok.*, o.nama_obat FROM obat_keluar ok JOIN obat o ON ok.obat_id = o.id ORDER BY ok.tanggal_keluar DESC");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Inventaris Obat</title>
    <style>
        body {
            font-family: Arial;
            margin: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 40px;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 8px;
            text-align: center;
        }

        h1,
        h2 {
            margin-top: 30px;
        }
    </style>
</head>

<body>
    <h1>LAPORAN INVENTARIS OBAT</h1>
    <h2>1. Laporan Stok Obat</h2>
    <table>
        <tr>
            <th>No</th>
            <th>Kode</th>
            <th>Nama Obat</th>
            <th>Kategori</th>
            <th>Satuan</th>
            <th>Stok</th>
            <th>Stok Minimum</th>
        </tr>
        <?php
        $no = 1;
        foreach ($stok as $row):
        ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= $row['kode_obat'] ?></td>
                <td><?= $row['nama_obat'] ?></td>
                <td><?= $row['kategori'] ?></td>
                <td><?= $row['satuan'] ?></td>
                <td><?= $row['stok'] ?></td>
                <td><?= $row['stok_minimum'] ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
    <h2>2. Laporan Obat Masuk</h2>
    <table>
        <tr>
            <th>No</th>
            <th>Nama Obat</th>
            <th>Jumlah</th>
            <th>Tanggal Masuk</th>
            <th>Keterangan</th>
        </tr>
        <?php
        $no = 1;
        foreach ($masuk as $row):
        ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= $row['nama_obat'] ?></td>
                <td><?= $row['jumlah'] ?></td>
                <td><?= $row['tanggal_masuk'] ?></td>
                <td><?= $row['keterangan'] ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
    <h2>3. Laporan Obat Keluar</h2>
    <table>
        <tr>
            <th>No</th>
            <th>Nama Obat</th>
            <th>Jumlah</th>
            <th>Tanggal Keluar</th>
            <th>Keterangan</th>
        </tr>
        <?php
        $no = 1;
        foreach ($keluar as $row):
        ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= $row['nama_obat'] ?></td>
                <td><?= $row['jumlah'] ?></td>
                <td><?= $row['tanggal_keluar'] ?></td>
                <td><?= $row['keterangan'] ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>

</html>