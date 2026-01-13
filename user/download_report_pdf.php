<?php
session_start();
if(!isset($_SESSION['uid'])){
  exit;
}

require("../lib/fpdf.php");

// Generate image temporarily
ob_start();
include("generate_report_img.php");
$imageData = ob_get_clean();

$imagePath = "../uploads/report_".$_SESSION['uid'].".png";
file_put_contents($imagePath, $imageData);

// Create PDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->Image($imagePath, 10, 20, 190);
$pdf->Output("D", "Impact_Report.pdf");

// Cleanup
unlink($imagePath);
