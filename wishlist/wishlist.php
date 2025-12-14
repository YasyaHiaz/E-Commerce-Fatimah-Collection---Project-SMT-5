<?php
session_start();
require_once '../app/config/database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

$db = new Database();
$conn = $db->conn;

if (isset($_SESSION['users'])) {
    include '../public/components/header_user.php';
} else {
    include '../public/components/header_guest.php';
}

$user_id = $_SESSION['user_id'];

// AMBIL DATA WISHLIST USER
$q = $conn->query("
    SELECT w.id AS wishlist_id, p.id AS product_id, p.name, p.price, p.image
    FROM wishlist w
    JOIN products p ON w.product_id = p.id
    WHERE w.user_id = $user_id
");
?>



<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wishlist Saya</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        body {
            background: #ffffffff;
        }

        .wishlist-container {
            max-width: 1150px;
            margin: 40px auto;
            padding: 20px;
        }

        .wishlist-title {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 25px;
        }

        .wishlist-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(230px, 1fr));
            gap: 25px;
        }

        .wishlist-card {
            background: #ffffffff;
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0,0,0,0.06);
            transition: 0.3s ease;
            position: relative;
        }

        .wishlist-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 28px rgba(0,0,0,0.10);
        }

        .wishlist-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .wishlist-info {
            padding: 15px;
        }

        .wishlist-name {
            font-size: 18px;
            font-weight: 600;
        }

        .wishlist-price {
            font-size: 16px;
            color: #d43434;
            font-weight: bold;
        }

        .wishlist-actions {
            display: flex;
            justify-content: space-between;
            padding: 15px;
            border-top: 1px solid #eee;
        }

        .btn-cart {
            background: #1f1f1f;
            padding: 7px 14px;
            color: #fff;
            border-radius: 8px;
            border: none;
            font-size: 14px;
            transition: 0.2s;
        }

        .btn-cart:hover {
            background: #000;
        }

        .btn-remove {
            background: transparent;
            border: none;
            color: #d50000;
            font-size: 18px;
        }

        /* EMPTY STATE */
        .empty-box {
            text-align: center;
            padding: 90px 20px;
        }

        .empty-box img {
            width: 180px;
            opacity: 0.8;
        }

        .empty-box h3 {
            margin-top: 20px;
            font-weight: 600;
            color: #333;
        }

        .empty-box p {
            color: #777;
        }
    </style>
</head>
<body>

<div class="wishlist-container">
    <h1 class="wishlist-title">Wishlist Saya</h1>

    <?php if ($q->num_rows == 0): ?>
        <div class="empty-box">
            <img src="../public/assets/images/shopping-cart.gif" 
            alt="Empty Cart Animation" 
            style="width:180px; margin-bottom:20px;">
            <h3>Wishlist Kosong</h3>
            <p>Tambahkan produk favoritmu untuk disimpan di sini.</p>
            <a href="../public/shop.php" class="btn btn-dark mt-3">Mulai Belanja</a>
        </div>

    <?php else: ?>
        <div class="wishlist-grid">

            <?php while ($row = $q->fetch_assoc()): ?>
                <div class="wishlist-card">

                    <!-- HAPUS WISHLIST -->
                    <button class="btn-remove remove-wishlist"
                            data-id="<?= $row['product_id'] ?>">
                        <i class="bi bi-x-circle-fill"></i>
                    </button>

                    <img src="assets/images/<?= $row['image']; ?>" alt="">

                    <div class="wishlist-info">
                        <div class="wishlist-name"><?= $row['name']; ?></div>
                        <div class="wishlist-price">Rp <?= number_format($row['price'], 0, ',', '.'); ?></div>
                    </div>

                    <div class="wishlist-actions">
                        <button class="btn-cart add-to-cart"
                                data-id="<?= $row['product_id'] ?>">
                            <i class="bi bi-cart-plus"></i> Keranjang
                        </button>
                    </div>

                </div>
            <?php endwhile; ?>

        </div>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
// =============================================
// REMOVE FROM WISHLIST
// =============================================
document.querySelectorAll('.remove-wishlist').forEach(btn => {
    btn.addEventListener("click", function () {
        let pid = this.dataset.id;

        fetch("remove_wishlist.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: "product_id=" + pid
        })
        .then(r => r.text())
        .then(r => {
            if (r === "REMOVED") {
                location.reload();
            }
        });
    });
});

// =============================================
// ADD TO CART FROM WISHLIST
// =============================================
document.querySelectorAll('.add-to-cart').forEach(btn => {
    btn.addEventListener("click", function () {

        let pid = this.dataset.id;

        fetch("../cart/cart_add.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: "product_id=" + pid
        })
        .then(r => r.json())
        .then(r => {
            if (r.status === "success") {
                alert("Produk dimasukkan ke keranjang!");
            }
        });
    });
});
</script>

</body>
</html>
