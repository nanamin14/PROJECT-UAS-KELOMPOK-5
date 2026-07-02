<?php
require 'config/database.php';

$db = new Database();
$conn = $db->connect();

if ($conn) {
    echo "Koneksi database berhasil";
} else {
    echo "Koneksi database gagal";
}
?>