<?php

require '../config/Database.php';
require '../classes/User.php';

$db = new Database();
$conn = $db->connect();

$user = new User($conn);
$data = $user->getAll();

?>

<h2>Data User</h2>

<a href="tambah.php">Tambah User</a>

<table border="1" cellpadding="10">

<tr>
    <th>No</th>
    <th>Nama</th>
    <th>Email</th>
    <th>Role</th>
    <th>Aksi</th>
</tr>

<?php $no=1; foreach($data as $row): ?>

<tr>
    <td><?= $no++ ?></td>
    <td><?= $row['nama'] ?></td>
    <td><?= $row['email'] ?></td>
    <td><?= $row['nama_role'] ?></td>
    <td>
        <a href="edit.php?id=<?= $row['id'] ?>">Edit</a>
        <a href="hapus.php?id=<?= $row['id'] ?>"
        onclick="return confirm('Hapus?')">
        Hapus
        </a>
    </td>
</tr>

<?php endforeach; ?>

</table>