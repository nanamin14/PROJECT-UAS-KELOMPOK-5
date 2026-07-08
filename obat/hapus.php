<?php
require '../config/Database.php';
require '../classes/Obat.php';
require '../middleware/AuthMiddleware.php';

AuthMiddleware::check();

$db = new Database();
$conn = $db->connect();

$obat = new Obat($conn);

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = $_GET['id'];

$dataObat = $obat->getById($id);

if (!$dataObat) {
    die("Data obat tidak ditemukan.");
}

if ($obat->delete($id)) {
    echo "
    <script>
        alert('Data obat berhasil dihapus.');
        window.location='index.php';
    </script>
    ";
} else {
    echo "
    <script>
        alert('Data obat gagal dihapus.');
        window.location='index.php';
    </script>
    ";
}