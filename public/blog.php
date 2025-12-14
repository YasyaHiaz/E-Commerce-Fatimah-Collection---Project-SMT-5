<?php
// file: blog.php
session_start();
require_once '../app/config/database.php'; 

// ============================
// FIX: Buat koneksi database
// ============================
$db = new Database();
$conn = $db->conn;

// Header
include '../public/components/header_user.php'; 


// fallback esc jika config tidak menyediakan
if (!function_exists('esc')) {
    function esc($s){ return htmlspecialchars($s, ENT_QUOTES|ENT_SUBSTITUTE, 'UTF-8'); }
}

// Pagination
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$perPage = 9;
$offset = ($page - 1) * $perPage;

// ============================
// FIX QUERY: gunakan $conn->prepare()
// ============================
$stmt = $conn->prepare("
    SELECT id, title, slug, thumbnail, content, published_at 
    FROM blog_posts 
    WHERE published_at IS NOT NULL 
    ORDER BY published_at DESC 
    LIMIT ? OFFSET ?
");

$stmt->bind_param("ii", $perPage, $offset);
$stmt->execute();
$res = $stmt->get_result();
$posts = $res->fetch_all(MYSQLI_ASSOC);

// Hitung total artikel
$totalRes = $conn->query("SELECT COUNT(*) AS total FROM blog_posts WHERE published_at IS NOT NULL");
$total = intval($totalRes->fetch_assoc()['total']);
$totalPages = max(1, ceil($total / $perPage));
?>

<style>
/* ============================
   BLOG LIST PREMIUM STYLE
============================ */

.shop-container {
    padding: 60px 0;
    max-width: 1200px;
    margin: auto;
}

.shop-title {
    font-size: 36px;
    font-weight: 800;
    text-align: center;
    margin-bottom: 50px;
    color: #4b2e15;
    letter-spacing: -0.5px;
}

/* GRID */
.products-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 28px;
}

/* CARD STYLE */
.product-card {
    background: #ffffff;
    border-radius: 18px;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    box-shadow: 0 8px 22px rgba(0,0,0,0.08);
    transition: 0.35s ease;
    border: 1px solid #f1e7df;
}

.product-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 16px 35px rgba(0,0,0,0.12);
}

/* THUMBNAIL */
.product-img {
    width: 100%;
    height: 220px;
    object-fit: cover;
    border-bottom: 1px solid #f0e6df;
}

/* CONTENT */
.product-info {
    padding: 20px;
}

.product-info h3 {
    font-size: 20px;
    font-weight: 700;
    color: #3a210c;
    margin-bottom: 8px;
}

.product-info .price {
    color: #a1836b;
}

/* BUTTON */
.product-actions {
    padding: 0 20px 20px 20px;
}

.btn-detail {
    width: 100%;
    display: block;
    text-align: center;
    background: #4b2e15;
    color: #fff !important;
    padding: 10px 0;
    border-radius: 30px;
    font-weight: 600;
    font-size: 14px;
    transition: 0.35s ease;
    box-shadow: 0 4px 12px rgba(75,46,21,0.25);
}

.btn-detail:hover {
    background: #6e4220;
    transform: translateY(-3px);
    box-shadow: 0 10px 22px rgba(75,46,21,0.45);
}

@media (max-width: 480px) {
    .product-img {
        height: 190px;
    }
}
</style>


<div class="shop-container">
    <h1 class="shop-title">Artikel & Blog</h1>

    <div class="products-grid">
        <?php if (count($posts) == 0): ?>
            <div class="product-card">
                <div class="product-info">
                    <h3>Tidak ada artikel</h3>
                    <p class="price" style="font-size:14px; font-weight:400;">Belum ada posting yang dipublikasikan.</p>
                </div>
            </div>
        <?php else: ?>
            <?php foreach ($posts as $p): ?>
                <article class="product-card" style="display:flex; flex-direction:column;">
                    <?php
                        $thumb = !empty($p['thumbnail']) ? '/uploads/blog/' . esc($p['thumbnail']) : '/assets/images/blog-placeholder.jpg';
                    ?>
                    <img src="<?= $thumb ?>" class="product-img" alt="<?= esc($p['title']); ?>">

                    <div class="product-info" style="flex:1;">
                        <h3><?= esc($p['title']); ?></h3>
                        <p class="price" style="font-size:14px; font-weight:400;">
                            <?= date('d M Y', strtotime($p['published_at'])); ?>
                        </p>
                    </div>

                    <div class="product-actions">
                        <a href="blog_detail.php?slug=<?= urlencode($p['slug']); ?>" class="btn-detail">Baca</a>
                    </div>
                </article>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <!-- Pagination -->
    <?php if ($totalPages > 1): ?>
    <div style="margin-top:30px; display:flex; justify-content:center; gap:8px;">
        <?php if ($page > 1): ?>
            <a href="?page=<?= $page-1 ?>" class="btn-detail" style="padding:6px 12px;">&laquo; Prev</a>
        <?php endif; ?>

        <?php for ($i=1;$i<=$totalPages;$i++): ?>
            <?php if ($i == $page): ?>
                <span class="btn-detail" style="background:#7b5434; padding:6px 12px; opacity:0.9;"><?= $i ?></span>
            <?php else: ?>
                <a href="?page=<?= $i ?>" class="btn-detail" style="padding:6px 12px; background: #5e3d1d; opacity:0.95;"><?= $i ?></a>
            <?php endif; ?>
        <?php endfor; ?>

        <?php if ($page < $totalPages): ?>
            <a href="?page=<?= $page+1 ?>" class="btn-detail" style="padding:6px 12px;">Next &raquo;</a>
        <?php endif; ?>
    </div>
    <?php endif; ?>

</div>

<?php include  '../public/components/footer.php'; ?>
