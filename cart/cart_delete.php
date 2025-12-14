<?php
session_start();
require_once '../app/config/database.php';

// Pastikan user login
if (!isset($_SESSION['users']['id'])) {
    header("Location: ../auth/login.php");
    exit;
}

$user_id = intval($_SESSION['users']['id']);
$cart_id = intval($_GET['id'] ?? 0);

if ($cart_id) {
    $query = "DELETE FROM cart WHERE id = ? AND user_id = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param("ii", $cart_id, $user_id);
    $stmt->execute();
}

header("Location: cart.php");
exit;
