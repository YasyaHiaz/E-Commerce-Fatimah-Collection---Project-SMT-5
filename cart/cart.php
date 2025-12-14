<?php
session_start();
require_once '../app/config/database.php';

// Cek login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}
$user_id = $_SESSION['user_id'];

// Ambil cart dari database
$query = "
    SELECT c.id AS cart_id, c.qty, p.name, p.price, p.image 
    FROM cart c
    JOIN products p ON p.id = c.product_id
    WHERE c.user_id = ?
";
$stmt = $db->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$cart = [];
$total_price = 0;

while ($row = $result->fetch_assoc()) {
    $cart[] = $row;
    $total_price += $row['price'] * $row['qty'];
}

//header
if (isset($_SESSION['users'])) {
    include '../public/components/header_user.php';
} else {
    include '../public/components/header_guest.php';
}
?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>

    <link rel="stylesheet" href="../public/assets/css/shop.css">

    <style>
        body {
            font-family: Arial, sans-serif;
            background:#f5f5f5;
            margin:0;
            padding:0;
        }

        .cart-container {
            max-width: 900px;
            margin: 30px auto;
            background:#fff;
            padding:20px;
            border-radius:12px;
            box-shadow:0 4px 12px rgba(0,0,0,0.1);
        }

        .cart-title {
            font-size:26px;
            font-weight:bold;
            margin-bottom:25px;
        }

        .cart-item {
            display:flex;
            gap:18px;
            padding:20px;
            border-radius:10px;
            margin-bottom:18px;
            background:#fafafa;
            border:1px solid #eee;
            align-items:center;
        }

        .cart-item img {
            width:110px;
            height:110px;
            object-fit:cover;
            border-radius:10px;
        }

        .item-info {
            flex:1;
        }

        .item-name {
            font-size:18px;
            font-weight:600;
        }

        .item-price {
            font-size:16px;
            margin-top:6px;
            color:#444;
        }

        .qty-controls {
            margin-top:10px;
            display:flex;
            align-items:center;
            gap:10px;
        }

        .qty-btn {
            width:32px;
            height:32px;
            background:#eee;
            border:none;
            border-radius:8px;
            font-size:20px;
            cursor:pointer;
            transition:0.2s;
        }

        .qty-btn:hover {
            background:#ddd;
        }

        .item-qty {
            min-width:26px;
            text-align:center;
            font-size:16px;
            font-weight:bold;
        }

        .remove-btn {
            margin-top:12px;
            color:#e63946;
            cursor:pointer;
            font-size:14px;
            font-weight:bold;
            text-decoration:underline;
        }

        .cart-summary {
            padding-top:20px;
            text-align:right;
            border-top:2px solid #ddd;
        }

        .summary-price {
            font-size:22px;
            font-weight:bold;
        }

        .checkout-btn {
            margin-top:15px;
            display:inline-block;
            padding:12px 20px;
            background:#e91e63;
            color:#fff;
            border-radius:8px;
            text-decoration:none;
            font-size:16px;
            transition:0.3s;
        }

        .checkout-btn:hover {
            background:#d01755;
        }
    </style>
</head>

<body>

<div class="cart-container">

    <div class="cart-title">Keranjang</div>
    <div id="empty-cart" style="display:none; text-align:center; padding:40px;">
    <img src="../public/assets/images/shopping-cart.gif" 
     alt="Empty Cart Animation" 
     style="width:180px; margin-bottom:20px;">
    <h2 style="color:#555; font-weight:600;">Keranjangmu masih kosong</h2>
    <p style="color:#777; margin-top:10px;">Yuk mulai tambahkan barang kesukaanmu </p>
    <a href="/fatimah-collection-clean1/public/shop.php" 
       style="display:inline-block; margin-top:20px; padding:12px 20px; background:#e91e63; color:#fff; border-radius:8px; text-decoration:none;">
       Mulai Belanja
    </a>
</div>


    <?php if (empty($cart)): ?>
        <p>Keranjang anda kosong.</p>

    <?php else: ?>
        <?php foreach ($cart as $item): ?>

            <div class="cart-item" 
               data-id="<?= $item['cart_id']; ?>" 
               data-price="<?= $item['price']; ?>">


                <img src="../public/assets/products/<?= $item['image']; ?>">

                <div class="item-info">
                    <div class="item-name"><?= $item['name']; ?></div>
                    <div class="item-price">Rp <?= number_format($item['price']); ?></div>

                    <div class="qty-controls">
                        <button class="qty-btn btn-minus">−</button>
                        <span class="item-qty"><?= $item['qty']; ?></span>
                        <button class="qty-btn btn-plus">+</button>
                    </div>

                    <div class="remove-btn">Hapus barang</div>
                </div>
            </div>

        <?php endforeach; ?>

        <div class="cart-summary" id="cart-summary">
            <div class="summary-price">
                Total: Rp <?= number_format($total_price); ?>
            </div>

            <a href="../checkout/checkout.php" class="checkout-btn">
                Lanjut Checkout
            </a>
        </div>

    <?php endif; ?>
</div>


<script>
document.addEventListener("DOMContentLoaded", () => {

    // PLUS QTY
    document.querySelectorAll(".btn-plus").forEach(btn => {
        btn.addEventListener("click", function() {
            const item = this.closest(".cart-item");
            updateQty(item.dataset.id, "plus", item);
        });
    });

    // MINUS QTY
    document.querySelectorAll(".btn-minus").forEach(btn => {
        btn.addEventListener("click", function() {
            const item = this.closest(".cart-item");
            updateQty(item.dataset.id, "minus", item);
        });
    });

    // REMOVE ITEM
    document.querySelectorAll(".remove-btn").forEach(btn => {
        btn.addEventListener("click", function() {
            const item = this.closest(".cart-item");
            updateQty(item.dataset.id, "remove", item);
        });
    });
});


// AJAX
function updateQty(id, action, itemElement) {

    fetch("cart_update.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: "id=" + id + "&action=" + action
    })
    .then(res => res.json())
    .then(data => {

        if (data.status === "success") {

            const qtyElem = itemElement.querySelector(".item-qty");

            if (action === "plus") {
                qtyElem.innerText = parseInt(qtyElem.innerText) + 1;
            }
            else if (action === "minus") {
                const newVal = Math.max(1, parseInt(qtyElem.innerText) - 1);
                qtyElem.innerText = newVal;
            }
            else if (action === "remove") {
                itemElement.remove();
                // Jika semua item sudah terhapus → tampilkan UI kosong
                 if (document.querySelectorAll(".cart-item").length === 0) {
                    document.getElementById("empty-cart").style.display = "block";
                     document.getElementById("cart-summary").style.display = "none";
                     }
            }

            //  Update total harga real-time
            updateTotalPrice();

        } else {
            alert(data.message || "Terjadi kesalahan");
        }

    });


    function updateTotalPrice() {
    let total = 0;
    document.querySelectorAll(".cart-item").forEach(item => {
        const price = parseInt(item.dataset.price);
        const qty = parseInt(item.querySelector(".item-qty").innerText);
        total += price * qty;
    });

    document.querySelector(".summary-price").innerText =
        "Total: Rp " + total.toLocaleString("id-ID");
}

}
</script>
<?php include '../public/components/footer.php'; ?>
</body>
</html>
