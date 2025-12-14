<?php
session_start();
require_once __DIR__ . '/../app/config/database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

$db = new Database();
$conn = $db->conn;
$user_id = intval($_SESSION['user_id']);

// ambil form
$payment_method = $conn->real_escape_string(trim($_POST['payment_method'] ?? 'manual'));
$total_price = intval($_POST['total_price'] ?? 0);

// validasi sederhana
if ($total_price <= 0) {
    $_SESSION['checkout_error'] = "Total harga tidak valid.";
    header("Location: checkout.php");
    exit;
}

$conn->begin_transaction();

try {

    // 1) insert ke orders
    $stmt = $conn->prepare("
        INSERT INTO orders (user_id, total_price, payment_method, status)
        VALUES (?, ?, ?, 'pending')
    ");
    $stmt->bind_param("iis", $user_id, $total_price, $payment_method);
    $stmt->execute();
    $order_id = $stmt->insert_id;
    $stmt->close();

    // 2) ambil cart items
    $stmt = $conn->prepare("
        SELECT c.product_id, c.qty, p.price 
        FROM cart c 
        JOIN products p ON c.product_id = p.id 
        WHERE c.user_id = ?
    ");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $res = $stmt->get_result();

    // 3) masukkan ke order_items
    $stmt_ins = $conn->prepare("
        INSERT INTO order_items (order_id, product_id, qty, price)
        VALUES (?, ?, ?, ?)
    ");

    while ($row = $res->fetch_assoc()) {
        $pid = intval($row['product_id']);
        $qty = intval($row['qty']);
        $price = floatval($row['price']);

        $stmt_ins->bind_param("iiid", $order_id, $pid, $qty, $price);
        $stmt_ins->execute();
    }

    $stmt_ins->close();
    $stmt->close();

    // 4) kosongkan cart
    $stmt = $conn->prepare("DELETE FROM cart WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->close();

    $conn->commit();

    // redirect ke success page
    header("Location: ../checkout/checkout_success.php?order_id=" . $order_id);
    exit;

} catch (Exception $e) {

    $conn->rollback();
    error_log("Checkout error: " . $e->getMessage());

    $_SESSION['checkout_error'] = "Terjadi kesalahan pada server. Silakan coba lagi.";
    header("Location: checkout.php");
    exit;
}
