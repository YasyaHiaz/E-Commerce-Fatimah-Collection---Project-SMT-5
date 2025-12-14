<?php
// file: blog_detail.php
session_start();
require_once '../app/config/database.php'; 
include '../public/components/header_user.php'; // Langsung pakai header_user
if (!function_exists('esc')) {
    function esc($s){ return htmlspecialchars($s, ENT_QUOTES|ENT_SUBSTITUTE, 'UTF-8'); }
}

$slug = isset($_GET['slug']) ? $_GET['slug'] : '';
if (empty($slug)) {
    header('Location: blog.php');
    exit;
}

$stmt = $db->prepare("SELECT * FROM blog_posts WHERE slug = ? LIMIT 1");
if (!$stmt) {
    die("Query error: " . $db->error);
}
$stmt->bind_param('s', $slug);
$stmt->execute();
$res = $stmt->get_result();
$post = $res->fetch_assoc();

if (!$post) {
    header('Location: blog.php');
    exit;
}

// (Optional) update view count jika ada kolom views
// $db->query("UPDATE blog_posts SET views = views + 1 WHERE id = " . intval($post['id']));
?>

<link rel="stylesheet" href="assets/css/shop-style.css">
<div class="shop-container" style="max-width:900px;">
    <h1 class="shop-title"><?= esc($post['title']); ?></h1>

    <?php if (!empty($post['thumbnail'])): ?>
        <img src="/uploads/blog/<?= esc($post['thumbnail']); ?>" class="product-img" style="height:420px; object-fit:cover; border-radius:12px; margin-bottom:20px;">
    <?php endif; ?>

    <div style="background:#fff; padding:22px; border-radius:12px; box-shadow:0 8px 20px rgba(0,0,0,0.06);">
        <div style="color:#777; font-size:14px; margin-bottom:12px;">
            Dipublikasikan: <?= date('d M Y H:i', strtotime($post['published_at'])); ?>
        </div>

        <div style="line-height:1.9; color:#444; font-size:16px;">
            <?= nl2br(esc($post['content'])); ?>
        </div>

        <div style="margin-top:18px;">
            <a href="blog.php" class="btn-detail">Kembali ke Blog</a>
        </div>
    </div>
</div>

<?php include __DIR__ . '/components/footer.php'; ?>
