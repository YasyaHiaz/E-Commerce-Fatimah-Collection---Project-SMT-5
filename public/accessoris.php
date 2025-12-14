<?php
session_start();

// Panggil koneksi
require_once '../app/config/database.php';

// FIX: buat objek Database
$db = new Database();
$conn = $db->conn;

// Auth dan header
include 'components/auth_check.php'; 
include 'components/header_user.php';

// Ambil data accessories dari database
$query = "SELECT * FROM products WHERE category = 'accessories' AND published = 1 ORDER BY created_at DESC";
$result = $conn->query($query); // FIX: pakai $conn bukan $db
$items = $result->fetch_all(MYSQLI_ASSOC);
?>


<link rel="stylesheet" href="assets/css/accessories.css">

<div class="shop-container">
    <h1 class="shop-title">Aksesoris Pilihan</h1>
    <p class="shop-subtitle">Koleksi aksesoris eksklusif untuk melengkapi gaya Anda</p>

    <div class="products-grid">
        <?php if (count($items) == 0): ?>
            <div class="product-card no-item">
                <h3>Belum ada aksesoris</h3>
                <p>Silakan kembali lagi nanti.</p>
            </div>
        <?php else: ?>
            <?php foreach ($items as $p): ?>
                <?php 
                    $thumb = !empty($p['image']) 
                        ? '/uploads/products/' . $p['image'] 
                        : '/assets/images/product-placeholder.webp';
                ?>
                <article class="product-card">
                    <div class="product-img-wrapper">
                        <img src="<?= $thumb ?>" class="product-img" alt="<?= esc($p['name']); ?>">
                    </div>

                    <div class="product-info">
                        <h3><?= esc($p['name']); ?></h3>
                        <p class="product-price">Rp <?= number_format($p['price'], 0, ',', '.'); ?></p>
                    </div>

                    <div class="product-actions">
                        <a href="product_detail.php?id=<?= $p['id'] ?>" class="btn-detail">Lihat Detail</a>
                    </div>
                </article>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
<?php include  '../public/components/footer.php'; ?>
