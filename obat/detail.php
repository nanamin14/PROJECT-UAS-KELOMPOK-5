<?php
require '../config/Database.php';
require '../classes/Obat.php';
require '../middleware/AuthMiddleware.php';

AuthMiddleware::check();

$db = new Database();
$conn = $db->connect();

$obat = new Obat($conn);

// Cek apakah ID dikirim
if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = $_GET['id'];

$dataObat = $obat->getById($id);

if (!$dataObat) {
    die("Data obat tidak ditemukan.");
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Detail Obat</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            background: #f4f4f4;
        }

        .container {
            width: 650px;
            margin: 30px auto;
            background: white;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, .1);
        }

        h2 {
            margin-bottom: 20px;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        .label {
            width: 180px;
            font-weight: bold;
            background: #f8f8f8;
        }

        .status-aman {
            color: green;
            font-weight: bold;
        }

        .status-warning {
            color: red;
            font-weight: bold;
        }

        .btn {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 15px;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        .kembali {
            background: #6c757d;
        }

        .edit {
            background: #ffc107;
            color: black;
        }
    </style>
</head>

<body>

    <div class="container">
        <h2>Detail Data Obat</h2>

        <table>
            <tr>
                <td class="label">ID</td>
                <td><?= $dataObat['id']; ?></td>
            </tr>
            <tr>
                <td class="label">Kode Obat</td>
                <td><?= htmlspecialchars($dataObat['kode_obat']); ?></td>
            </tr>
            <tr>
                <td class="label">Nama Obat</td>
                <td><?= htmlspecialchars($dataObat['nama_obat']); ?></td>
            </tr>
            <tr>
                <td class="label">Kategori</td>
                <td><?= htmlspecialchars($dataObat['kategori']); ?></td>
            </tr>
            <tr>
                <td class="label">Satuan</td>
                <td><?= htmlspecialchars($dataObat['satuan']); ?></td>
            </tr>
            <tr>
                <td class="label">Stok Saat Ini</td>
                <td><?= $dataObat['stok']; ?></td>
            </tr>
            <tr>
                <td class="label">Stok Minimum</td>
                <td><?= $dataObat['stok_minimum']; ?></td>
            </tr>
            <tr>
                <td class="label">Lokasi Penyimpanan</td>
                <td><?= htmlspecialchars($dataObat['lokasi']); ?></td>
            </tr>

            <?php if (isset($dataObat['created_at'])) : ?>
                <tr>
                    <td class="label">Tanggal Dibuat</td>
                    <td><?= $dataObat['created_at']; ?></td>
                </tr>
            <?php endif; ?>

            <?php if (isset($dataObat['updated_at'])) : ?>
                <tr>
                    <td class="label">Terakhir Diubah</td>
                    <td><?= $dataObat['updated_at']; ?></td>
                </tr>
            <?php endif; ?>

            <tr>
                <td class="label">Status Stok</td>
                <td>
                    <?php
                    if ($dataObat['stok'] <= $dataObat['stok_minimum']) {
                        echo "<span class='status-warning'>Stok Menipis</span>";
                    } else {
                        echo "<span class='status-aman'>Stok Aman</span>";
                    }
                    ?>
                </td>
            </tr>
        </table>

        <br>

        <a href="index.php" class="btn kembali">Kembali</a>
        <a href="edit.php?id=<?= $dataObat['id']; ?>" class="btn edit">Edit Data</a>
    </div>

</body>
</html>