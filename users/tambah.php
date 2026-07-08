<?php
require '../config/Database.php';
require '../classes/User.php';

$db = new Database();
$conn = $db->connect();

$user = new User($conn);

if ($_POST) {
    $user->create($_POST);
    header("Location:index.php");
    exit;
}

$roles = $conn->query("SELECT * FROM roles");
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah User</title>

    <link rel="stylesheet" href="../assets/style.css">
</head>

<body>

<div class="container">

    <h2>Tambah User</h2>

    <div class="action-bar">

        <a href="index.php" class="btn btn-secondary">
            ← Kembali
        </a>

    </div>

    <form method="POST">

        <label>Nama</label>
        <input
            type="text"
            name="nama"
            placeholder="Masukkan nama..."
            required>

        <label>Email</label>
        <input
            type="email"
            name="email"
            placeholder="Masukkan email..."
            required>

        <label>Password</label>
        <input
            type="password"
            name="password"
            placeholder="Masukkan password..."
            required>

        <label>Role</label>

        <select name="role_id">

            <?php foreach ($roles as $r): ?>

                <option value="<?= $r['id'] ?>">
                    <?= $r['nama_role'] ?>
                </option>

            <?php endforeach; ?>

        </select>

        <button type="submit" class="btn btn-primary">
            Simpan User
        </button>

    </form>

</div>

</body>
</html>