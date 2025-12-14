<?php
session_start();
require_once "../../app/config/database.php"; 

// Filter tanggal
$start = $_GET['start'] ?? '';
$end   = $_GET['end'] ?? '';

$where = "";
if ($start && $end) {
    $where = "WHERE DATE(o.created_at) BETWEEN '$start' AND '$end'";
}

// Query laporan penjualan
$query = "
    SELECT 
        o.id, 
        o.total_price, 
        o.status, 
        o.payment_method, 
        o.created_at,
        u.name AS customer_name
    FROM orders o
    LEFT JOIN users u ON u.id = o.user_id
    $where
    ORDER BY o.created_at DESC
";

$result = $db->query($query);

// Hitung total pemasukan
$totalQuery = "
    SELECT SUM(total_price) AS total
    FROM orders o
    $where
";
$total = $db->query($totalQuery)->fetch_assoc()['total'] ?? 0;

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Penjualan</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background: #f5f1eb;
            font-family: 'Poppins', sans-serif;
        }
        .card {
            border-radius: 12px;
            border: none;
        }
        th {
            background: #e8ded3;
        }
    </style>
</head>

<body>

<?php include "../layout.php"; ?> 

<div class="content">
    <h2>Laporan Penjualan</h2>
    <p class="text-muted">Menampilkan riwayat transaksi penjualan dari database.</p>

    <!-- ===== Filter Tanggal ===== -->
    <div class="card p-3 mb-4">
        <form class="row g-3" method="GET">
            <div class="col-md-4">
                <label class="form-label">Dari Tanggal</label>
                <input type="date" name="start" class="form-control" value="<?= $start ?>">
            </div>

            <div class="col-md-4">
                <label class="form-label">Sampai Tanggal</label>
                <input type="date" name="end" class="form-control" value="<?= $end ?>">
            </div>

            <div class="col-md-4 d-flex align-items-end">
                <button class="btn btn-dark w-100">
                    <i class="bi bi-funnel-fill"></i> Filter
                </button>
            </div>
        </form>
        <br>
        <!-- ===== Tombol Export ===== -->
        <div class="mb-3 d-flex gap-2">
            <a href="export_pdf.php?start=<?= $start ?>&end=<?= $end ?>" class="btn btn-danger">
            <i class="bi bi-file-earmark-pdf-fill"></i> Export PDF
            </a>

            <a href="export_excel.php?start=<?= $start ?>&end=<?= $end ?>" class="btn btn-success">
            <i class="bi bi-file-earmark-excel-fill"></i> Export Excel
            </a>
        </div>

    </div>

    <div class="alert alert-success">
        <strong>Total Pemasukan: </strong> Rp <?= number_format($total, 0, ',', '.') ?>
    </div>

    <div class="card p-4">
        <h5 class="mb-3">Data Penjualan</h5>

        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID Order</th>
                        <th>Pembeli</th>
                        <th>Total Harga</th>
                        <th>Status</th>
                        <th>Metode Pembayaran</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>

                <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= $row['customer_name'] ?? '-' ?></td>
                        <td>Rp <?= number_format($row['total_price'], 0, ',', '.') ?></td>
                        <td><?= ucfirst($row['status']) ?></td>
                        <td><?= ucfirst($row['payment_method']) ?></td>
                        <td><?= date('d-m-Y H:i', strtotime($row['created_at'])) ?></td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
        </div>

    </div>

</div>

</body>
</html>
