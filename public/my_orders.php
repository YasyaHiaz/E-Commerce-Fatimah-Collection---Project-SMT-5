<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/../app/config/database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: /fatimah-collection-clean1/auth/login.php");
    exit;
}

$db = new Database();
$conn = $db->conn;
$user_id = (int) $_SESSION['user_id'];

/* =========================
   AMBIL ORDER USER
========================= */
$stmt = $conn->prepare("
    SELECT id, total_price, status, created_at
    FROM orders
    WHERE user_id = ?
    ORDER BY created_at DESC
");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$orders = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>My Orders - Fatimah Collection</title>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

<style>
.order-card{
    border-radius:16px;
    box-shadow:0 8px 28px rgba(0,0,0,.08);
    transition:.3s;
}
.order-card:hover{transform:translateY(-4px)}
.order-status{
    font-size:12px;
    padding:6px 14px;
    border-radius:20px;
    font-weight:600;
}
.status-pending{background:#fff3cd;color:#856404}
.status-paid{background:#d1e7dd;color:#0f5132}
.status-process{background:#cff4fc;color:#055160}
.status-done{background:#e2e3e5;color:#41464b}
</style>
</head>

<body class="bg-light">

<?php include __DIR__ . '/../public/components/header_user.php'; ?>

<div class="container my-5">
<h4 class="mb-4 fw-bold">Riwayat Pesanan</h4>

<?php if ($orders->num_rows === 0): ?>
<div class="alert alert-info">
<i class="bi bi-info-circle"></i> Belum ada pesanan
</div>
<?php endif; ?>

<?php while ($order = $orders->fetch_assoc()): ?>

<?php
$statusClass = match($order['status']){
    'pending'=>'status-pending',
    'paid'=>'status-paid',
    'process'=>'status-process',
    'done'=>'status-done',
    default=>'status-pending'
};
?>

<div class="card order-card mb-4">
<div class="card-body">

<div class="d-flex justify-content-between align-items-center mb-2">
<div>
<strong>Order #<?= $order['id']; ?></strong><br>
<small class="text-muted">
<?= date('d M Y H:i', strtotime($order['created_at'])); ?>
</small>
</div>
<span class="order-status <?= $statusClass ?>">
<?= ucfirst($order['status']); ?>
</span>
</div>

<hr>

<?php
$itemStmt = $conn->prepare("
    SELECT p.name, p.image, oi.qty, oi.price
    FROM order_items oi
    JOIN products p ON oi.product_id = p.id
    WHERE oi.order_id = ?
");
$itemStmt->bind_param("i", $order['id']);
$itemStmt->execute();
$items = $itemStmt->get_result();
?>

<?php while ($item = $items->fetch_assoc()): ?>
<div class="d-flex align-items-center mb-3">
<img src="/fatimah-collection-clean1/public/assets/images/<?= htmlspecialchars($item['image']); ?>"
     width="70"
     class="rounded me-3"
     onerror="this.src='/fatimah-collection-clean1/public/assets/no-image.png'">

<div>
<div class="fw-semibold"><?= htmlspecialchars($item['name']); ?></div>
<small><?= $item['qty']; ?> x Rp <?= number_format($item['price'],0,',','.'); ?></small>
</div>
</div>
<?php endwhile; ?>

<hr>

<div class="d-flex justify-content-between fw-bold">
<span>Total</span>
<span>Rp <?= number_format($order['total_price'],0,',','.'); ?></span>
</div>

</div>
</div>

<?php endwhile; ?>

</div>

</body>
</html>
