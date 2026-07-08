<?php

require '../config/Database.php';
require '../classes/User.php';

$db = new Database();
$conn = $db->connect();

$user = new User($conn);
$data = $user->getAll();

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Data User</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>

<body>

<div class="container">

    <div class="header-page">

        <h2>Data User</h2>

      <div class="action-bar">

    <a href="../dashboard.php" class="btn btn-secondary">
        ← Kembali
    </a>

    <a href="tambah.php" class="btn btn-primary">
        + Tambah User
    </a>

</div>

    </div>

    <table>

        <thead>
            <tr>
                <th width="70">No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Role</th>
                <th width="220">Aksi</th>
            </tr>
        </thead>

        <tbody>

        <?php $no=1; foreach($data as $row): ?>

            <tr>

                <td><?= $no++ ?></td>

                <td><?= htmlspecialchars($row['nama']) ?></td>

                <td><?= htmlspecialchars($row['email']) ?></td>

                <td><?= htmlspecialchars($row['nama_role']) ?></td>

                <td>

                    <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-warning">
                        Edit
                    </a>

                    <a href="hapus.php?id=<?= $row['id'] ?>"
                       class="btn btn-danger"
                       onclick="return confirm('Hapus user ini?')">

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