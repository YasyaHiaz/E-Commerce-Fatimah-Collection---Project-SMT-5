<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Cek login
$isLoggedIn = isset($_SESSION['user']) || isset($_SESSION['users']) || isset($_SESSION['user_id']);

// Ambil user_id
$user_id = null;

if (isset($_SESSION['user']['id'])) {
    $user_id = $_SESSION['user']['id'];
} elseif (isset($_SESSION['users']['id'])) {
    $user_id = $_SESSION['users']['id'];
} elseif (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
}

// Hitung cart dari database jika login
$cartCount = 0;

if ($user_id) {
    require_once $_SERVER['DOCUMENT_ROOT'] . "/fatimah-collection-clean/app/config/database.php";
    $db  = new Database();
    $conn = $db->conn;

    $stmt = $conn->prepare("SELECT SUM(qty) AS total FROM cart WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $res = $stmt->get_result();
    $cartCount = $res->fetch_assoc()['total'] ?? 0;
}

// Wishlist tetap pakai session
$wishlistCount = isset($_SESSION['wishlist']) ? count($_SESSION['wishlist']) : 0;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fatimah Collection</title>

    <!-- CSS -->
    <link rel="stylesheet" href="/public/assets/css/globals.css">
    <link rel="stylesheet" href="/public/assets/css/layout.css">
    <link rel="stylesheet" href="/public/assets/css/header.css">
</head>

<body>
<div class="site-wrap">

<header class="header">
    <div class="container header__wrap">

        <!-- LOGO -->
        <a href="/index.php" class="logo">Fatimah<span>Collection</span></a>

        <!-- SEARCH -->
        <form action="/shop.php" method="GET" class="search-bar">
            <input type="text" name="q" placeholder="Cari produk...">
            <button type="submit">Cari</button>
        </form>

        <!-- ACTIONS -->
        <div class="header__actions">

            <!-- WISHLIST -->
            <a href="/wishlist.php" class="cart-btn">
                ❤️ Wishlist
                <?php if ($wishlistCount > 0): ?>
                    <span class="cart-count"><?= $wishlistCount ?></span>
                <?php endif; ?>
            </a>

            <!-- CART -->
            <a href="/cart.php" class="cart-btn">
                🛒 Keranjang
                <span class="cart-count"><?= $cartCount ?></span>
            </a>

            <!-- USER -->
            <?php if ($isLoggedIn): ?>

                <?php 
                $userName = $_SESSION['user']['name'] 
                    ?? $_SESSION['users']['name'] 
                    ?? 'User';
                ?>

                <div class="user-menu">
                    <button class="btn-secondary"><?= htmlspecialchars($userName) ?> ▼</button>
                    <div class="dropdown">
                        <a href="/account.php">Profil Saya</a><br>
                        <a href="/orders.php">Pesanan Saya</a><br>
                        <a href="/logout.php" style="color:#e53935;">Logout</a>
                    </div>
                </div>

            <?php else: ?>
                <a href="/login.php" class="btn-primary">Login</a>
            <?php endif; ?>

        </div>

    </div>
</header>
