<?php
require_once "../../app/config/database.php";
require_once "../../fpdf/fpdf.php";

// Ambil filter
$start = $_GET['start'] ?? '';
$end   = $_GET['end'] ?? '';

$where = "";
$periode = "Semua Periode";

if ($start && $end) {
    $where = "WHERE DATE(o.created_at) BETWEEN '$start' AND '$end'";
    $periode = "$start s/d $end";
}

// Query laporan
$query = "
    SELECT o.id, o.total_price, o.status, o.payment_method, o.created_at, u.name
    FROM orders o
    LEFT JOIN users u ON u.id = o.user_id
    $where
    ORDER BY o.created_at DESC
";
$result = $db->query($query);

// ===== PDF =====
$pdf = new FPDF('P', 'mm', 'A4');
$pdf->AddPage();

// Judul
$pdf->SetFont('Arial','B',14);
$pdf->Cell(190, 10, 'LAPORAN PENJUALAN', 0, 1, 'C');

$pdf->SetFont('Arial','',11);
$pdf->Cell(190, 8, "Periode: " . $periode, 0, 1);
$pdf->Ln(4);

// ===== Header Tabel =====
$pdf->SetFont('Arial','B',10);
$pdf->Cell(15, 8, 'No', 1, 0, 'C');
$pdf->Cell(20, 8, 'ID', 1, 0, 'C');
$pdf->Cell(45, 8, 'Pembeli', 1, 0, 'C');
$pdf->Cell(30, 8, 'Total', 1, 0, 'C');
$pdf->Cell(25, 8, 'Status', 1, 0, 'C');
$pdf->Cell(25, 8, 'Bayar', 1, 0, 'C');
$pdf->Cell(30, 8, 'Tanggal', 1, 1, 'C');

// ===== Isi Tabel =====
$pdf->SetFont('Arial','',10);
$no = 1;

while ($row = $result->fetch_assoc()) {

    $pdf->Cell(15, 8, $no++, 1, 0, 'C');
    $pdf->Cell(20, 8, $row['id'], 1, 0, 'C');

    // Pembeli: auto-truncate biar gak berantakan
    $name = strlen($row['name']) > 22 ? substr($row['name'], 0, 22) . "..." : $row['name'];
    $pdf->Cell(45, 8, $name, 1, 0, 'L');

    // Total price rata kanan
    $pdf->Cell(30, 8, "Rp " . number_format($row['total_price'], 0, ',', '.'), 1, 0, 'R');

    $pdf->Cell(25, 8, ucfirst($row['status']), 1, 0, 'C');
    $pdf->Cell(25, 8, ucfirst($row['payment_method']), 1, 0, 'C');

    // Tanggal
    $tanggal = date('d-m-Y', strtotime($row['created_at']));
    $pdf->Cell(30, 8, $tanggal, 1, 1, 'C');
}

// Footer
$pdf->Ln(8);
$pdf->SetFont('Arial','I',9);
$pdf->Cell(190, 5, 'Dicetak pada: ' . date('d-m-Y H:i'), 0, 1, 'R');

$pdf->Output();
exit;
?>
