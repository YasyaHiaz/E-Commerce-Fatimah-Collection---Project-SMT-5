<?php
session_start();
require_once '../app/config/database.php';

$db = new Database();
$conn = $db->conn;

include 'components/auth_check.php';
include 'components/header_user.php';

// ===========================
// AMBIL DATA WISHLIST USER
// ===========================
$wishlist = [];
$wishlist_count = 0;

if (isset($_SESSION['user_id'])) {
    $user_id = (int) $_SESSION['user_id'];

    $w = $conn->query("SELECT product_id FROM wishlist WHERE user_id = $user_id");
    while ($row = $w->fetch_assoc()) {
        $wishlist[] = (int) $row['product_id'];
    }
    $wishlist_count = count($wishlist);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop - Fatimah Collection</title>

    <link rel="stylesheet" href="assets/css/shop.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>

<body>

<div class="shop-container">

    <h1 class="shop-title">Semua Produk</h1>

    <div class="products-grid">

        <?php
        $result = $conn->query("SELECT * FROM products ORDER BY created_at DESC");

        if ($result && $result->num_rows > 0):
            while ($p = $result->fetch_assoc()):
                $pid   = (int) $p['id'];
                $name  = htmlspecialchars($p['name']);
                $price = number_format($p['price'], 0, ',', '.');
                $image = htmlspecialchars($p['image']);

                $isWish = in_array($pid, $wishlist);
        ?>

        <div class="product-card">

            <!-- IMAGE + WISHLIST -->
            <div class="product-image-wrap">

                <img src="assets/images/<?= $image; ?>"
                     class="product-img"
                     alt="<?= $name; ?>">

                <button class="wishlist-btn add-wishlist" data-id="<?= $pid; ?>">
                    <i class="bi <?= $isWish ? 'bi-heart-fill text-danger' : 'bi-heart'; ?>"></i>
                </button>

            </div>

            <!-- INFOS -->
            <div class="product-info">
                <h3><?= $name; ?></h3>
                <p class="price">Rp <?= $price; ?></p>
            </div>

            <!-- ACTIONS -->
            <div class="product-actions">
                <a href="product_detail.php?id=<?= $pid; ?>" class="btn-detail">Detail</a>
                <button class="btn-add-cart" data-id="<?= $pid; ?>">+ Cart</button>
            </div>

        </div>

        <?php endwhile; else: ?>
            <p style="text-align:center;">Belum ada produk.</p>
        <?php endif; ?>

    </div>
</div>

<!-- TOAST -->
<div id="toast-box" class="position-fixed top-0 end-0 p-3" style="z-index:9999"></div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
// TOAST
function showToast(msg) {
    const toastBox = document.getElementById("toast-box");
    toastBox.innerHTML = `
        <div class="toast align-items-center text-bg-primary border-0" style="margin-top:10px">
            <div class="d-flex">
                <div class="toast-body">${msg}</div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>`;
    new bootstrap.Toast(toastBox.lastElementChild).show();
}

// WISHLIST
document.querySelectorAll('.add-wishlist').forEach(btn => {
    btn.addEventListener('click', function () {
        const pid  = this.dataset.id;
        const icon = this.querySelector('i');

        fetch("../wishlist/add_wishlist.php", {
            method: "POST",
            headers: {"Content-Type": "application/x-www-form-urlencoded"},
            body: "product_id=" + pid
        })
        .then(res => res.json())
        .then(res => {
            const counter = document.getElementById("wishlist-count");

            if (res.status === "added") {
                icon.classList.replace('bi-heart', 'bi-heart-fill');
                icon.classList.add('text-danger');
                if (counter) counter.innerText = res.total;
                showToast("Ditambahkan ke Wishlist!");
            }

            if (res.status === "removed") {
                icon.classList.replace('bi-heart-fill', 'bi-heart');
                icon.classList.remove('text-danger');
                if (counter) counter.innerText = res.total;
                showToast("Dihapus dari Wishlist!");
            }
        });
    });
});

// CART
document.querySelectorAll('.btn-add-cart').forEach(btn => {
    btn.addEventListener('click', async function () {

        const pid = this.dataset.id;

        const res = await fetch("../cart/cart_add.php", {
            method: "POST",
            headers: {"Content-Type": "application/x-www-form-urlencoded"},
            body: "product_id=" + pid
        });

        const data = await res.json();

        if (data.status === "success") {
            const badge = document.querySelector(".cart-badge");
            if (badge) badge.innerText = data.total_items;
            showToast("Berhasil ditambahkan ke keranjang!");
        }
    });
});
</script>

</body>
</html>
