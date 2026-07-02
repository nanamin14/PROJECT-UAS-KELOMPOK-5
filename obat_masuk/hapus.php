<?php
require '../config/Database.php';
require '../classes/ObatMasuk.php';

$db = new Database();
$conn = $db->connect();

$obatMasuk = new ObatMasuk($conn);

if (!isset($_GET['id'])) {
    header("Location:index.php");
    exit;
}

$id = $_GET['id'];
$obatMasuk->delete($id);

header("Location:index.php");
exit;
