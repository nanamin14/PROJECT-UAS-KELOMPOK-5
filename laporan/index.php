<?php
require "../config/database.php";

$db = new Database();
$conn = $db->connect();

// Laporan stok obat
$stok = $conn->query("SELECT * FROM obat ORDER BY nama_obat");
// Laporan obat masuk
$masuk = $conn->query("SELECT om.*, o.nama_obat FROM obat_masuk om JOIN obat o ON om.obat_id = o.id ORDER BY om.tanggal DESC");
// Laporan obat keluar
$keluar = $conn->query("SELECT ok.*, o.nama_obat FROM obat_keluar ok JOIN obat o ON ok.obat_id = o.id ORDER BY ok.tanggal DESC");
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Inventaris Obat</title>

    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            margin: 30px;
        }

        .action-bar {
            display: flex;
            gap: 12px;
            margin-bottom: 25px;
        }

        .btn {
            display: inline-block;
            padding: 10px 18px;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
            transition: .3s;
        }

        .btn-primary {
            background: #4e73df;
            color: white;
        }

        .btn-primary:hover {
            background: #2e59d9;
        }

        .btn-secondary {
            background: #6c757d;
            color: white;
        }

        .btn-secondary:hover {
            background: #5a6268;
        }

        h1 {
            margin: 25px 0;
        }

        h2 {
            margin: 30px 0 15px;
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
            padding: 10px;
            text-align: center;
        }
    </style>

</head>

<body>

    <div class="action-bar">
        <?php if (!isset($pdf)): ?>
            <a href="export_pdf.php"
                target="_blank"
                class="btn btn-primary">
                Export PDF
            </a>
            <a href="../dashboard.php"
                class="btn btn-secondary">
                Kembali
            </a>
        <?php endif; ?>
    </div>
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
            <th>Lokasi</th>
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
                <td><?= $row['lokasi'] ?></td>
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
            <th>Supplier</th>
        </tr>

        <?php
        $no = 1;
        foreach ($masuk as $row):
        ?>

            <tr>
                <td><?= $no++ ?></td>
                <td><?= $row['nama_obat'] ?></td>
                <td><?= $row['jumlah'] ?></td>
                <td><?= $row['tanggal'] ?></td>
                <td><?= $row['supplier'] ?></td>
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
            <th>Penerima</th>
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
                <td><?= $row['tanggal'] ?></td>
                <td><?= $row['penerima'] ?></td>
                <td><?= $row['keterangan'] ?></td>
            </tr>

        <?php endforeach; ?>

    </table>
</body>

</html>