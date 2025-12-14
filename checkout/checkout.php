<?php
session_start();
require_once __DIR__ . '/../app/config/database.php'; // sesuaikan jika path beda

// pastikan session user_id konsisten dengan login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

$db = new Database();
$conn = $db->conn;
$user_id = intval($_SESSION['user_id']);

// =============================
// MODE DIRECT CHECKOUT
// =============================
$directItem = null;

if (isset($_POST['direct_buy'])) {
    $pid = intval($_POST['product_id']);
    $qty = intval($_POST['qty']);

    $stmt = $conn->prepare("SELECT id, name, price, image FROM products WHERE id = ?");
    $stmt->bind_param("i", $pid);
    $stmt->execute();
    $directItem = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if ($directItem) {
        $directItem['qty'] = $qty;
        $cartItems = [$directItem];
        $total = $directItem['price'] * $qty;
    }
}

// ambil isi cart untuk user
$stmt = $conn->prepare("
    SELECT c.id AS cart_id, c.qty, p.id AS product_id, p.name, p.price, p.image
    FROM cart c
    JOIN products p ON c.product_id = p.id
    WHERE c.user_id = ?
");

$stmt->bind_param("i", $user_id);
$stmt->execute();
$res = $stmt->get_result();

$cartItems = [];
$total = 0;
while ($row = $res->fetch_assoc()) {
    $cartItems[] = $row;
    $total += $row['price'] * $row['qty'];
}

$stmt->close();

// include header (sesuaikan path)
include __DIR__ . '/../public/components/header_user.php';
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Checkout - Fatimah Collection</title>

  <!-- bootstrap CDN (opsional) -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    /* Simple modern checkout styles */
    .checkout-wrap { max-width: 1000px; margin:48px auto; }
    .card-modern { border-radius: 14px; box-shadow: 0 8px 30px rgba(0,0,0,.06); }
    .product-row { display:flex; gap:12px; align-items:center; padding:12px 0; border-bottom:1px solid #eee; }
    .product-row img { width:72px; height:72px; object-fit:cover; border-radius:8px; }
    .summary-box { background:#faf7f5; border-radius:12px; padding:18px; }
    .btn-checkout { background:#4a2e1c; color:#fff; border:none; padding:12px; border-radius:10px; width:100%; }
  </style>
</head>
<body>
<div class="container checkout-wrap">
  <div class="card card-modern p-4">
    <h3 class="mb-4">Checkout</h3>

    <?php if (empty($cartItems)): ?>
      <div class="text-center py-5">
        <img src="../public/assets/images/empty-cart.png" alt="empty" style="width:160px; opacity:.8">
        <h5 class="mt-3">Keranjang Anda kosong</h5>
        <p class="text-muted">Tambahkan produk terlebih dahulu untuk checkout.</p>
        <a href="../public/shop.php" class="btn btn-outline-dark">Mulai Belanja</a>
      </div>
    <?php else: ?>
      <div class="row">
        <!-- left: form -->
        <div class="col-md-7">
          <div class="mb-3">
            <h5>Informasi Pengiriman</h5>
          </div>
          <form action="process_checkout.php" method="POST" id="checkout-form">
            <div class="mb-3">
              <label class="form-label">Nama Lengkap</label>
              <input required name="fullname" class="form-control" />
            </div>
            <div class="mb-3">
              <label class="form-label">Nomor Telepon</label>
              <input required name="phone" class="form-control" />
            </div>
            <div class="mb-3">
              <label class="form-label">Alamat Lengkap</label>
              <textarea required name="address" class="form-control" rows="3"></textarea>
            </div>

            <!-- payment options -->
            <div class="mb-3">
              <label class="form-label">Metode Pembayaran</label>
              <select name="payment_method" class="form-select" required>
                <option value="transfer">Transfer Bank</option>
                <option value="cod">COD (Bayar di Tempat)</option>
              </select>
            </div>

            <!-- hidden total -->
            <input type="hidden" name="total_price" value="<?= htmlspecialchars($total + 15000) ?>">
        </div>

        <!-- right: summary -->
        <div class="col-md-5">
          <div class="summary-box">
            <h6 class="mb-3">Ringkasan Belanja</h6>

            <?php foreach ($cartItems as $it): ?>
              <div class="product-row">
                <img src="../public/assets/products/<?= htmlspecialchars($it['image']) ?>" alt="">
                <div style="flex:1;">
                  <div class="fw-bold"><?= htmlspecialchars($it['name']) ?></div>
                  <div class="text-muted">Qty: <?= (int)$it['qty'] ?></div>
                </div>
                <div class="fw-bold">Rp <?= number_format($it['price'] * $it['qty'], 0, ',', '.') ?></div>
              </div>
            <?php endforeach; ?>

            <div class="d-flex justify-content-between mt-3">
              <div>Subtotal</div>
              <div>Rp <?= number_format($total, 0, ',', '.') ?></div>
            </div>
            <div class="d-flex justify-content-between">
              <div>Biaya Pengiriman</div>
              <div>Rp 15.000</div>
            </div>
            <hr>
            <div class="d-flex justify-content-between fw-bold fs-5">
              <div>Total</div>
              <div>Rp <?= number_format($total + 15000, 0, ',', '.') ?></div>
            </div>

            <div class="mt-3">
              <button type="submit" class="btn-checkout">Bayar Sekarang</button>
            </div>

          </div>
        </div>
      </div>
      </form>
    <?php endif; ?>
  </div>
</div>

<!-- optional bootstrap js -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<?php include '../public/components/footer.php'; ?>
</body>
</html>
