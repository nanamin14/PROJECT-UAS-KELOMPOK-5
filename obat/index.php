<?php
require '../config/Database.php';
require '../classes/Obat.php';
require '../middleware/AuthMiddleware.php';

AuthMiddleware::check();

$db = new Database();
$conn = $db->connect();

$obat = new Obat($conn);

if (isset($_GET['search'])) {
    $keyword = trim($_GET['search']);
    $dataObat = $obat->search($keyword);
} else {
    $dataObat = $obat->getAll();
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Data Obat</title>

    <style>
        body {
            font-family: Arial;
            background: #f5f5f5;
            margin: 30px;
        }

        h2 {
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }

        th {
            background: #0d6efd;
            color: white;
            padding: 10px;
        }

        td {
            padding: 10px;
            border: 1px solid #ddd;
        }

        a {
            text-decoration: none;
        }

        .btn {
            padding: 7px 12px;
            border-radius: 4px;
            color: white;
        }

        .tambah {
            background: green;
        }

        .detail {
            background: #0dcaf0;
        }

        .edit {
            background: orange;
        }

        .hapus {
            background: red;
        }

        .warning {
            color: red;
            font-weight: bold;
        }

        form {
            margin-bottom: 20px;
        }

        input[type=text] {
            padding: 8px;
            width: 250px;
        }

        button {
            padding: 8px 15px;
        }
    </style>
</head>

<body>

    <h2>Master Data Obat</h2>

    <a href="tambah.php" class="btn tambah">
        + Tambah Obat
    </a>

    <br><br>

    <form method="GET">
        <input 
            type="text" 
            name="search" 
            placeholder="Cari kode / nama / kategori" 
            value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>"
        >

        <button type="submit">
            Cari
        </button>

        <a href="index.php">
            Reset
        </a>
    </form>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Nama Obat</th>
                <th>Kategori</th>
                <th>Satuan</th>
                <th>Stok</th>
                <th>Stok Minimum</th>
                <th>Lokasi</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            if (count($dataObat) > 0) :
                foreach ($dataObat as $row) :
            ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= htmlspecialchars($row['kode_obat']) ?></td>
                        <td><?= htmlspecialchars($row['nama_obat']) ?></td>
                        <td><?= htmlspecialchars($row['kategori']) ?></td>
                        <td><?= htmlspecialchars($row['satuan']) ?></td>
                        <td><?= $row['stok'] ?></td>
                        <td><?= $row['stok_minimum'] ?></td>
                        <td><?= htmlspecialchars($row['lokasi']) ?></td>
                        <td>
                            <?php
                            if ($row['stok'] <= $row['stok_minimum']) {
                                echo "<span class='warning'>Stok Menipis</span>";
                            } else {
                                echo "Aman";
                            }
                            ?>
                        </td>
                        <td>
                            <a class="btn detail" href="detail.php?id=<?= $row['id'] ?>">Detail</a>
                            <a class="btn edit" href="edit.php?id=<?= $row['id'] ?>">Edit</a>
                            <a class="btn hapus" onclick="return confirm('Yakin ingin menghapus data?')" href="hapus.php?id=<?= $row['id'] ?>">Hapus</a>
                        </td>
                    </tr>
            <?php
                endforeach;
            else :
            ?>
                <tr>
                    <td colspan="10" align="center">
                        Tidak ada data obat.
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <br>

    <p>
        <b>Total Data :</b>
        <?= count($dataObat) ?>
    </p>

</body>
</html>
