<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: ../auth/login.php");
    exit;
}

$role = $_SESSION['role'];
$nama = $_SESSION['nama'];
?>

<!DOCTYPE html>
<html>

<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="../assets/css/dashboard.css">
</head>

<body>

    <div class="sidebar">
        <h2>Inventaris Obat</h2>
        <?php if ($role == 'Admin'): ?>
            <a href="../PROJECT-UAS-KELOMPOK-5/users/index.php">Kelola User</a>
            <a href="../PROJECT-UAS-KELOMPOK-5/obat/index.php">Data Obat</a>
            <a href="../PROJECT-UAS-KELOMPOK-5/obat_masuk/index.php">Obat Masuk</a>
            <a href="../PROJECT-UAS-KELOMPOK-5/obat_keluar/index.php">Obat Keluar</a>
            <a href="../PROJECT-UAS-KELOMPOK-5/laporan/index.php">Laporan</a>
        <?php elseif ($role == 'Petugas'): ?>
            <a href="../PROJECT-UAS-KELOMPOK-5/obat/index.php">Data Obat</a>
            <a href="../PROJECT-UAS-KELOMPOK-5/obat_masuk/index.php">Obat Masuk</a>
            <a href="../PROJECT-UAS-KELOMPOK-5/obat_keluar/index.php">Obat Keluar</a>
            <a href="../PROJECT-UAS-KELOMPOK-5/laporan/index.php">Laporan</a>
        <?php elseif ($role == 'Viewer'): ?>
            <a href="../PROJECT-UAS-KELOMPOK-5/obat_masuk/index.php">Lihat Data Obat</a>
            <a href="../PROJECT-UAS-KELOMPOK-5/laporan/index.php">Laporan</a>
        <?php endif; ?>
        <a href="../auth/logout.php">Logout</a>
    </div>

    <div class="content">
        <h1>Selamat Datang, <?= $nama ?></h1>
        <p>Role: <?= ucfirst($role) ?></p>
        <?php if ($role == 'admin'): ?>
            <h2>Dashboard Admin</h2>
            <p>Kelola seluruh inventaris obat.</p>
        <?php elseif ($role == 'petugas'): ?>
            <h2>Dashboard Petugas</h2>
            <p>Kelola transaksi obat masuk dan keluar.</p>
        <?php elseif ($role == 'viewer'): ?>
            <h2>Dashboard Viewer</h2>
            <p>Silakan lihat stok obat dan laporan.</p>
            <div class="contact">
                <b>Kontak Petugas Logistik:</b><br>
                WA: 081122334455
            </div>
        <?php endif; ?>
    </div>
</body>

</html>