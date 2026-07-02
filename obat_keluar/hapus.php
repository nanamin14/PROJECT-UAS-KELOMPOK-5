<?php
require '../config/Database.php';
require '../classes/ObatKeluar.php';

$db = new Database();
$conn = $db->connect();

$obatKeluar = new ObatKeluar($conn);

if (!isset($_GET['id'])) {
    header("Location:index.php");
    exit;
}

$id = $_GET['id'];
$obatKeluar->delete($id);

header("Location:index.php");
exit;
