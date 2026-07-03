<?php
require '../vendor/autoload.php';
require '../config/database.php';

use Dompdf\Dompdf;
$db = new Database();
$conn = $db->connect();

//ambil data
$stok = $conn->query("SELECT * FROM obat ORDER BY nama_obat");
$masuk = $conn->query("SELECT om.*, o.nama_obat FROM obat_masuk om JOIN obat o ON om.obat_id=o.id ORDER BY om.tanggal DESC");
$keluar = $conn->query("SELECT ok.*, o.nama_obat FROM obat_keluar ok JOIN obat o ON ok.obat_id=o.id ORDER BY ok.tanggal DESC");
$dompdf = new Dompdf();

//buat html laporan 
$html = "<h1>Laporan Inventaris Obat</h1>";

$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

$dompdf->stream(
    "laporan_inventaris.pdf",
    ["Attachment" => false]
);
?>