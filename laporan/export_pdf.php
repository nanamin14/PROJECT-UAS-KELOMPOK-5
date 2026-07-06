<?php
require '../vendor/autoload.php';

use Dompdf\Dompdf;

//ambi dr index 
$pdf = true;
ob_start();
include 'index.php';
$html = ob_get_clean();

$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

$dompdf->stream(
    "laporan_inventaris.pdf",
    ["Attachment" => false]
);
?>