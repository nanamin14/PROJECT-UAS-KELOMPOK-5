<?php
require 'config/database.php';
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: ../auth/login.php");
    exit;
}

$db = new Database();
$conn = $db->connect();

$role = $_SESSION['role'];
$nama = $_SESSION['nama'];

$total_obat = $conn->query("SELECT COUNT(*) FROM obat")->fetchColumn();
$total_masuk = $conn->query("SELECT COUNT(*) FROM obat_masuk")->fetchColumn();
$total_keluar = $conn->query("SELECT COUNT(*) FROM obat_keluar")->fetchColumn();
$total_user = $conn->query("SELECT COUNT(*) FROM users")->fetchColumn();
$stok_menipis = $conn->query(
    "SELECT COUNT(*) FROM obat
    WHERE stok <= stok_minimum"
)->fetchColumn();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="assets/style.css">
</head>

<body>
   <div class="navbar">

<?php if ($role == 'Admin'): ?>

<a href="users/index.php">Kelola User</a>
<a href="obat/index.php">Data Obat</a>
<a href="obat_masuk/index.php">Obat Masuk</a>
<a href="obat_keluar/index.php">Obat Keluar</a>
<a href="laporan/index.php">Laporan</a>

<?php elseif ($role == 'Petugas'): ?>

<a href="obat/index.php">Data Obat</a>
<a href="obat_masuk/index.php">Obat Masuk</a>
<a href="obat_keluar/index.php">Obat Keluar</a>
<a href="laporan/index.php">Laporan</a>

<?php elseif ($role == 'Viewer'): ?>

<a href="laporan/index.php">Laporan</a>

<?php endif; ?>

<a href="auth/logout.php" class="logout">Logout</a>

</div>

    <div class="welcome-card">

    <div class="welcome-text">
        <h2>👋 Selamat Datang, <?= htmlspecialchars($nama) ?></h2>
        <p>Selamat datang di Sistem Inventaris Obat.</p>
    </div>

    <div class="role-badge">
        <?= ucfirst($role) ?>
    </div>

</div>

<?php if ($role == 'Admin'): ?>

<div class="card-container">

    <div class="card">
        <h3>Data Obat</h3>
        <p><?= $total_obat ?></p>
    </div>

    <div class="card">
        <h3>Obat Masuk</h3>
        <p><?= $total_masuk ?></p>
    </div>

    <div class="card">
        <h3>Obat Keluar</h3>
        <p><?= $total_keluar ?></p>
    </div>

    <div class="card">
        <h3>Total User</h3>
        <p><?= $total_user ?></p>
    </div>

</div>

<?php elseif ($role == 'Petugas'): ?>

<div class="card-container">

    <div class="card">
        <h3>Data Obat</h3>
        <p><?= $total_obat ?></p>
    </div>

    <div class="card">
        <h3>Obat Masuk</h3>
        <p><?= $total_masuk ?></p>
    </div>

    <div class="card">
        <h3>Obat Keluar</h3>
        <p><?= $total_keluar ?></p>
    </div>

</div>

<?php elseif ($role == 'Viewer'): ?>

<div class="card-container">

    <div class="card">
        <h3>Data Obat</h3>
        <p><?= $total_obat ?></p>
    </div>

    <div class="card">
        <h3>Stok Menipis</h3>
        <p><?= $stok_menipis ?></p>
    </div>

    <div class="card">
        <h3>Kontak Petugas</h3>
        <p style="font-size:20px;">081122334455</p>
    </div>

</div>

<?php endif; ?>
</body>

</html>