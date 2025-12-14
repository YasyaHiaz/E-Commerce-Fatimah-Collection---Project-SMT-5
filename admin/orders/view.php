<?php
require_once '../../app/config/database.php';

$db = new Database();
$conn = $db->conn;

if (!isset($_GET['id'])) {
    die("ID pesanan tidak ditemukan.");
}

$order_id = intval($_GET['id']);

// Ambil data pesanan
$order = $conn->query("
    SELECT o.*, u.name AS customer_name
    FROM orders o
    LEFT JOIN users u ON u.id = o.user_id
    WHERE o.id = $order_id
")->fetch_assoc();

if (!$order) {
    die("Pesanan tidak ditemukan.");
}

// Ambil daftar item
$items = $conn->query("
    SELECT oi.*, p.name AS product_name
    FROM order_items oi
    LEFT JOIN products p ON p.id = oi.product_id
    WHERE oi.order_id = $order_id
");
?>

<?php include '../layout.php'; ?>

<style>
    .page-title {
        font-size: 28px;
        font-weight: 600;
        color: #4a331c;
        margin-bottom: 20px;
    }

    .card-custom {
        background: #ffffff;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 25px;
        box-shadow: 0 4px 14px rgba(0,0,0,0.08);
    }

    .table-custom {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
        font-size: 15px;
    }

    .table-custom th {
        background: #f0e4d7;
        padding: 12px;
        border-bottom: 2px solid #e3d5c3;
        text-align: left;
        font-weight: 600;
    }

    .table-custom td {
        padding: 10px;
        border-bottom: 1px solid #eee;
    }

    .back-btn {
        text-decoration: none;
        padding: 10px 15px;
        background: #4a331c;
        color: #fff;
        border-radius: 8px;
        font-size: 14px;
        margin-bottom: 20px;
        display: inline-block;
        transition: 0.2s;
    }

    .back-btn:hover {
        background: #2c1e12;
    }
</style>

<div class="content">

    <a href="index.php" class="back-btn">← Kembali ke Daftar Pesanan</a>

    <h2 class="page-title">Detail Pesanan #<?= $order['id'] ?></h2>

    <!-- Card Detail Pesanan -->
    <div class="card-custom">
        <h4 class="mb-3">Informasi Pesanan</h4>

        <p><strong>Pemesan:</strong> <?= $order['customer_name'] ?? 'Tidak diketahui' ?></p>
        <p><strong>Total Harga:</strong> Rp <?= number_format($order['total_price'], 0, ',', '.') ?></p>
        <p><strong>Status:</strong> <?= ucfirst($order['status']) ?></p>
        <p><strong>Metode Pembayaran:</strong> <?= ucfirst($order['payment_method']) ?></p>
        <p><strong>Tanggal:</strong> <?= date('d-m-Y H:i', strtotime($order['created_at'])) ?></p>
    </div>

    <!-- Card Item Pesanan -->
    <div class="card-custom">
        <h4 class="mb-3">Item Pesanan</h4>

        <div class="table-responsive">
            <table class="table-custom">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Qty</th>
                        <th>Harga Satuan</th>
                        <th>Total</th>
                    </tr>
                </thead>

                <tbody>
                    <?php while ($row = $items->fetch_assoc()): ?>
                        <tr>
                            <td><?= $row['product_name'] ?? 'Produk tidak ditemukan' ?></td>

                            <td><?= $row['quantity'] ?? $row['qty'] ?></td>

                            <td>Rp <?= number_format($row['price'], 0, ',', '.') ?></td>
                            <td>
                                Rp <?= number_format($row['price'] * ($row['quantity'] ?? $row['qty']), 0, ',', '.') ?>
                            </td>

                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>
