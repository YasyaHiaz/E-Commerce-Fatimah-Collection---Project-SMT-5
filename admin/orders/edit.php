<?php
require_once '../../app/config/database.php';
include '../layout.php';

$db = new Database();
$conn = $db->conn;

if (!isset($_GET['id'])) {
    die("ID pesanan tidak ditemukan.");
}

$order_id = intval($_GET['id']);

$order = $conn->query("
    SELECT * FROM orders WHERE id = $order_id
")->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_status = $_POST['status'];

    $conn->query("
        UPDATE orders SET status = '$new_status' WHERE id = $order_id
    ");

    header("Location: index.php");
    exit;
}
?>


<style>
/* ==========================
    RESPONSIVE DASHBOARD STYLE
========================== */
.dashboard-container {
    padding: 30px;
    background: #faf7f3;
    min-height: 100vh;
    border-radius: 16px;
}

.update-card {
    background: #fff;
    padding: 28px;
    border-radius: 18px;
    border: 1px solid #e6d5c6;
    width: 100%;
    max-width: 580px;
    box-shadow: 0 8px 24px rgba(179,139,103,0.18);
    margin-top: 15px;
}

.update-card h2 {
    font-size: 28px;
    font-weight: 700;
    margin-bottom: 18px;
    color: #5a463f;
}

label {
    font-weight: 600;
    color: #5b4538;
    font-size: 15px;
}

select {
    width: 100%;
    padding: 12px;
    margin-top: 8px;
    margin-bottom: 15px;
    border-radius: 10px;
    border: 1px solid #cdb7a6;
}

button {
    width: 100%;
    padding: 14px;
    border: none;
    border-radius: 10px;
    background: #5e3d1d;
    color: #fff;
    cursor: pointer;
    font-size: 15px;
}

button:hover {
    background: #744c28;
}

.back-btn {
    text-decoration: none;
    padding: 10px 20px;
    color: #fff;
    background: #5e3d1d;
    border-radius: 10px;
    font-size: 15px;
    display: inline-block;
    margin-bottom: 25px;
}

.back-btn:hover {
    background: #744c28;
}
</style>

<div class="content">
    <div class="dashboard-container">

        <a href="index.php" class="back-btn">← Kembali</a>

        <div class="update-card">
            <h2>Update Status Pesanan #<?= $order['id'] ?></h2>

            <form method="POST">
                <label>Status Pesanan</label>
                <select name="status">
                    <option value="pending"   <?= $order['status']=='pending'?'selected':'' ?>>Pending</option>
                    <option value="paid"      <?= $order['status']=='paid'?'selected':'' ?>>Paid</option>
                    <option value="shipped"   <?= $order['status']=='shipped'?'selected':'' ?>>Shipped</option>
                    <option value="completed" <?= $order['status']=='completed'?'selected':'' ?>>Completed</option>
                    <option value="cancelled" <?= $order['status']=='cancelled'?'selected':'' ?>>Cancelled</option>
                </select>

                <button type="submit">Update Status</button>
            </form>
        </div>

    </div>
</div>
