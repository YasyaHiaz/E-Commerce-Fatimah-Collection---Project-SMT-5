<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/../../app/config/database.php';

$db = new Database();
$conn = $db->conn;

/* =========================
   SESSION USER (DISAMAKAN)
========================= */
$user_id = $_SESSION['user_id'] ?? 0;

/* =========================
   CART COUNT
========================= */
$cart_count = 0;
if ($user_id) {
    $stmt = $conn->prepare("SELECT COALESCE(SUM(qty),0) FROM cart WHERE user_id=?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($cart_count);
    $stmt->fetch();
    $stmt->close();
}

/* =========================
   WISHLIST COUNT
========================= */
$wishlist_count = 0;
if ($user_id) {
    $stmt = $conn->prepare("SELECT COUNT(*) FROM wishlist WHERE user_id=?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($wishlist_count);
    $stmt->fetch();
    $stmt->close();
}
?>
<style>
/* =========================
   NAVBAR BASIC STYLE
========================= */
.navbar {
    transition: all 0.3s ease;
}

.navbar .nav-link {
    position: relative;
    font-weight: 500;
    color: #333;
}

.navbar .nav-link::after {
    content: "";
    position: absolute;
    left: 0;
    bottom: -5px;
    width: 0;
    height: 2px;
    background: #5e3d1d;
    transition: width 0.3s ease;
}

.navbar .nav-link:hover::after {
    width: 100%;
}

/* =========================
   ICON STYLE
========================= */
.icon-link {
    color: #333;
    cursor: pointer;
    transition: transform 0.25s ease, color 0.25s ease;
}

.icon-link:hover {
    color: #5e3d1d;
    transform: translateY(-2px);
}

/* =========================
   BADGE STYLE
========================= */
.badge {
    font-size: 11px;
    padding: 4px 6px;
}

/* =========================
   USER DROPDOWN ANIMATION
========================= */
.dropdown-menu {
    opacity: 0;
    transform: translateY(10px) scale(0.98);
    transition: all 0.25s ease;
    display: block;          /* wajib untuk animasi */
    visibility: hidden;
    pointer-events: none;
}

.dropdown-menu.show {
    opacity: 1;
    transform: translateY(0) scale(1);
    visibility: visible;
    pointer-events: auto;
}

/* =========================
   DROPDOWN ITEM EFFECT
========================= */
.dropdown-item {
    font-size: 14px;
    padding: 10px 18px;
    transition: background 0.2s ease, padding-left 0.2s ease;
}

.dropdown-item:hover {
    background: #f7f3ef;
    padding-left: 22px;
}

/* =========================
   MOBILE IMPROVEMENT
========================= */
@media (max-width: 768px) {
    .navbar-nav {
        text-align: center;
    }
}
</style>

<nav class="navbar navbar-expand-lg bg-white py-3 shadow-sm">
<div class="container">

<!-- LOGO -->
<a class="navbar-brand fw-bold" href="/fatimah-collection-clean1/public/home.php"
   style="font-family:'Playfair Display', serif; color:#5e3d1d;">
    FATIMAH<br>
    <small style="font-size:12px; letter-spacing:5px;">COLLECTION</small>
</a>

<button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#mainNav">
    <span class="navbar-toggler-icon"></span>
</button>

<!-- MENU -->
<div class="collapse navbar-collapse justify-content-center" id="mainNav">
<ul class="navbar-nav">
    <li class="nav-item mx-2"><a class="nav-link" href="/fatimah-collection-clean1/public/home.php">Home</a></li>
    <li class="nav-item mx-2"><a class="nav-link" href="/fatimah-collection-clean1/public/shop.php">Shop</a></li>
    <li class="nav-item mx-2"><a class="nav-link" href="/fatimah-collection-clean1/public/blog.php">Blog</a></li>
    <li class="nav-item mx-2"><a class="nav-link" href="/fatimah-collection-clean1/public/aboutus.php">About</a></li>
    <li class="nav-item mx-2"><a class="nav-link" href="/fatimah-collection-clean1/public/contact.php">Contact</a></li>
</ul>
</div>

<!-- ICON RIGHT -->
<div class="d-flex align-items-center gap-3">

<!-- WISHLIST -->
<div class="position-relative">
<a href="/fatimah-collection-clean1/wishlist/wishlist.php" class="icon-link">
    <i class="bi bi-heart fs-5"></i>
    <span id="wishlist-count"
          class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-dark"
          style="<?= $wishlist_count ? '' : 'display:none' ?>">
        <?= $wishlist_count ?>
    </span>
</a>
</div>

<!-- CART -->
<div class="position-relative">
<a href="/fatimah-collection-clean1/cart/cart.php" class="icon-link">
    <i class="bi bi-cart3 fs-5"></i>
    <span class="cart-badge position-absolute top-0 start-100 translate-middle badge rounded-pill bg-dark"
          style="<?= $cart_count ? '' : 'display:none' ?>">
        <?= $cart_count ?>
    </span>
</a>
</div>

<!-- USER DROPDOWN -->
<div class="dropdown">

    <a href="#"
       class="icon-link dropdown-toggle"
       id="userDropdown"
       role="button"
       data-bs-toggle="dropdown"
       aria-expanded="false">
        <i class="bi bi-person fs-5"></i>
    </a>

    <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 rounded-3"
        aria-labelledby="userDropdown">

        <li>
            <a class="dropdown-item" href="/fatimah-collection-clean1/my_account/index.php">
                <i class="bi bi-gear me-2"></i> Management Akun
            </a>
        </li>

        <li>
            <a class="dropdown-item" href="/fatimah-collection-clean1/public/my_orders.php">
                <i class="bi bi-clock-history me-2"></i> Riwayat Pesanan
            </a>
        </li>

        <li><hr class="dropdown-divider"></li>

        <li>
            <a class="dropdown-item text-danger" href="/fatimah-collection-clean1/auth/logout.php">
                <i class="bi bi-box-arrow-right me-2"></i> Logout
            </a>
        </li>

    </ul>
</div>


</div>
</div>
</nav>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll('.dropdown-toggle').forEach(el => {
        new bootstrap.Dropdown(el);
    });
});
</script>


