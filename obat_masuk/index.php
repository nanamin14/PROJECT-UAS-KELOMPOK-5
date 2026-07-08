<?php
require '../config/database.php';
require '../classes/ObatMasuk.php';

$db = new Database();
$conn = $db->connect();

$obatMasuk = new ObatMasuk($conn);
$data = $obatMasuk->getAll();
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Obat Masuk</title>

    <link rel="stylesheet" href="../assets/style.css">
</head>

<body>

<div class="container">

    <h2>Data Obat Masuk</h2>

    <div class="action-bar">

        <a href="../dashboard.php" class="btn btn-secondary">
            ← Kembali
        </a>

        <a href="tambah.php" class="btn btn-primary">
            + Tambah Obat Masuk
        </a>

    </div>

    <table>

        <thead>
            <tr>
                <th>No</th>
                <th>Nama Obat</th>
                <th>Jumlah</th>
                <th>Tanggal</th>
                <th>Supplier</th>
                <th>Petugas</th>
                <th width="160">Aksi</th>
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

                <td><?= htmlspecialchars($row['supplier']) ?></td>

                <td><?= htmlspecialchars($row['nama_user']) ?></td>

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