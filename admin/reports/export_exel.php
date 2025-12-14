<?php
require_once "../../app/config/database.php";

// Ambil filter
$start = $_GET['start'] ?? '';
$end   = $_GET['end'] ?? '';

$where = "";
if ($start && $end) {
    $where = "WHERE DATE(o.created_at) BETWEEN '$start' AND '$end'";
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

// Setting header Excel
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=laporan_penjualan.xls");
header("Pragma: no-cache");
header("Expires: 0");

echo "<table border='1'>";
echo "
<tr>
    <th>ID Order</th>
    <th>Pembeli</th>
    <th>Total Harga</th>
    <th>Status</th>
    <th>Metode Pembayaran</th>
    <th>Tanggal</th>
</tr>
";

while ($row = $result->fetch_assoc()) {
    echo "
    <tr>
        <td>{$row['id']}</td>
        <td>{$row['name']}</td>
        <td>Rp ".number_format($row['total_price'])."</td>
        <td>".ucfirst($row['status'])."</td>
        <td>".ucfirst($row['payment_method'])."</td>
        <td>".date('d-m-Y H:i', strtotime($row['created_at']))."</td>
    </tr>
    ";
}

echo "</table>";
exit;
