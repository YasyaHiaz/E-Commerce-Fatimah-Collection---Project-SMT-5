<?php 
include 'layout.php';
include '../app/config/database.php';

// Summary Queries
$total_users = $db->query("SELECT COUNT(*) AS total FROM users")->fetch_assoc()['total'];
$total_products = $db->query("SELECT COUNT(*) AS total FROM products")->fetch_assoc()['total'];
$total_orders = $db->query("SELECT COUNT(*) AS total FROM orders")->fetch_assoc()['total'];

$income = $db->query("
    SELECT SUM(total_price) AS total 
    FROM orders 
    WHERE status != 'pending'
")->fetch_assoc()['total'] ?? 0;
?>

<style>
.dashboard-container {
    padding: 30px;
    background: #faf7f3;
    min-height: 100vh;
    border-radius: 16px;
}

/* Cards */
.summary-cards {
    display: flex;
    gap: 25px;
    flex-wrap: wrap;
}

.card-box {
    flex: 1 1 240px;
    padding: 25px;
    background: #FFFFFF;
    border-radius: 18px;
    border: 1px solid #edd6c4;

    box-shadow: 0 8px 24px rgba(179, 139, 103, 0.2);
    transition: .25s;
}

.card-box:hover {
    transform: translateY(-6px);
    box-shadow: 0 12px 32px rgba(179, 139, 103, 0.28);
}

.card-title {
    font-size: 17px;
    color: #8E6E5D;
    margin-bottom: 8px;
    font-weight: 600;
}

.card-value {
    font-size: 32px;
    font-weight: bold;
    color: #5A4640;
}

.card-subtitle {
    font-size: 14px;
    color: #A0A0A0;
    margin-top: 5px;
}
</style>

<div class="content">
    <div class="dashboard-container">

        <div class="summary-cards">

            <div class="card-box">
                <div class="card-title">Total Users</div>
                <div class="card-value"><?= $total_users ?></div>
                <div class="card-subtitle">Jumlah user terdaftar</div>
            </div>

            <div class="card-box">
                <div class="card-title">Total Products</div>
                <div class="card-value"><?= $total_products ?></div>
                <div class="card-subtitle">Jumlah produk tersedia</div>
            </div>

            <div class="card-box">
                <div class="card-title">Total Orders</div>
                <div class="card-value"><?= $total_orders ?></div>
                <div class="card-subtitle">Jumlah pesanan selesai</div>
            </div>

            <div class="card-box">
                <div class="card-title">Total Income</div>
                <div class="card-value">Rp <?= number_format($income, 0, ',', '.') ?></div>
                <div class="card-subtitle">Pendapatan Kotor</div>
            </div>

        </div>

    </div>
</div>
