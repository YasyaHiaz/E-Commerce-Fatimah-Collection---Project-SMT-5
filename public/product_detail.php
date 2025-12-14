<?php
session_start();
require_once __DIR__ . '/../app/config/database.php';

$db = new Database();
$conn = $db->conn;

// ===========================
// CEK ID PRODUK
// ===========================
if (!isset($_GET['id'])) {
    header("Location: shop.php");
    exit;
}

$id = intval($_GET['id']);

// Ambil data produk
$stmt = $conn->prepare("SELECT * FROM products WHERE id = ? LIMIT 1");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();
$stmt->close();

if (!$product) {
    echo "<h2 style='padding:30px;'>Produk tidak ditemukan.</h2>";
    exit;
}

// Header berdasarkan login
if (isset($_SESSION['users'])) {
    include 'components/header_user.php';
} else {
    include 'components/header_guest.php';
}
?>
<link rel="stylesheet" href="assets/css/product_detail.css">

<div class="product-detail-container">

    <!-- IMAGE -->
    <div class="image-section">
        <img src="assets/images/<?= htmlspecialchars($product['image']); ?>" 
             alt="<?= htmlspecialchars($product['name']); ?>">
    </div>

    <!-- INFO -->
    <div class="info-section">
        <h1><?= htmlspecialchars($product['name']); ?></h1>

        <p class="price">Rp <?= number_format($product['price'], 0, ',', '.'); ?></p>

        <p class="stock">
            Stok: <?= $product['stock'] > 0 ? $product['stock'] : "Habis"; ?>
        </p>

        <p class="description">
            <?= nl2br(htmlspecialchars($product['description'])); ?>
        </p>

        <div class="actions">

            <!-- BUTTON: ADD TO CART -->
            <button type="button" class="btn-cart" data-product="<?= $product['id']; ?>">
                Tambah ke Keranjang
            </button>

            <!-- BUTTON: BELI SEKARANG (DIRECT CHECKOUT) -->
            <form action="../checkout/checkout.php" method="POST" style="display:inline;">
                <input type="hidden" name="direct_buy" value="1">
                <input type="hidden" name="product_id" value="<?= $product['id']; ?>">
                <input type="hidden" name="qty" value="1">
                <button type="submit" class="btn-buy">Beli Sekarang</button>
            </form>

        </div>
    </div>
</div>

<!-- ========================
     SCRIPT: ADD TO CART AJAX
========================= -->
<script>
document.querySelector(".btn-cart")?.addEventListener("click", function() {

    const product_id = this.dataset.product;
    const formData = new FormData();
    formData.append("product_id", product_id);

    fetch("../cart/cart_add.php", {
        method: "POST",
        body: formData,
        credentials: "include"
    })
    .then(res => res.json())
    .then(data => {

        if (data.status === "success") {

            // Update cart counter
            const cartCounter = document.querySelector('.cart-btn .cart-count');
            if (cartCounter) {
                cartCounter.textContent = data.cart_count;
            }

            alert("Produk berhasil ditambahkan ke keranjang!");

        } else if (data.status === "not_login") {
            window.location.href = "/auth/login.php";
        } else {
            alert(data.message || "Terjadi kesalahan.");
        }
    })
    .catch(() => {
        alert("Terjadi kesalahan saat menambahkan ke keranjang.");
    });

});
</script>
