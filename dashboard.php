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
    <link rel="stylesheet" href="../assets/css/dashboard.css">
</head>

<body>
    <h2>Inventaris Obat</h2>
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
    <a href="auth/logout.php">Logout</a>

    <h1>Selamat Datang, <?= $nama ?></h1>
    <p>Role: <?= ucfirst($role) ?></p>
    <?php if ($role == 'Admin'): ?>
        <h3>Data Obat</h3>
        <p><?= $total_obat ?></p>
        <h3>Obat Masuk</h3>
        <p><?= $total_masuk ?></p>
        <h3>Obat Keluar</h3>
        <p><?= $total_keluar ?></p>
        <h3>Total User</h3>
        <p><?= $total_user ?></p>
    <?php elseif ($role == 'Petugas'): ?>
        <h3>Data Obat</h3>
        <p><?= $total_obat ?></p>
        <h3>Obat Masuk</h3>
        <p><?= $total_masuk ?></p>
        <h3>Obat Keluar</h3>
        <p><?= $total_keluar ?></p>
    <?php elseif ($role == 'Viewer'): ?>
        <h3>Data Obat</h3>
        <p><?= $total_obat ?></p>
        <h3>Stok Menipis</h3>
        <p><?= $stok_menipis ?></p>
        <h3>Kontak Petugas Logistik:</h3>
        <p>WA: 081122334455</p>
    <?php endif; ?>
</body>

</html>