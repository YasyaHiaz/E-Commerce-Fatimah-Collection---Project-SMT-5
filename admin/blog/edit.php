<?php
// ============================
// INIT
// ============================
session_start();
require_once "../../app/config/database.php";
include "../layout.php";

// ============================
// KONEKSI DATABASE
// ============================
$db   = new Database();
$conn = $db->conn;

// ============================
// AMBIL ID
// ============================
$id = intval($_GET['id'] ?? 0);
if ($id <= 0) {
    header("Location: index.php");
    exit;
}

// ============================
// AMBIL DATA BLOG
// ============================
$stmt = $conn->prepare("
    SELECT title, slug, content, thumbnail, published_at
    FROM blog_posts
    WHERE id = ?
");
$stmt->bind_param("i", $id);
$stmt->execute();
$post = $stmt->get_result()->fetch_assoc();

if (!$post) {
    header("Location: index.php");
    exit;
}

// ============================
// SUBMIT UPDATE
// ============================
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $title   = trim($_POST['title']);
    $slug    = trim($_POST['slug']);
    $content = trim($_POST['content']);
    $publish = ($_POST['publish'] == '1') ? date('Y-m-d H:i:s') : null;

    $thumbnailName = $post['thumbnail'];
    $uploadDir = "../../public/uploads/blog/";

    // ===== UPLOAD THUMBNAIL BARU (JIKA ADA) =====
    if (!empty($_FILES['thumbnail']['name'])) {

        $allowed = ['jpg', 'jpeg', 'png', 'webp'];
        $ext = strtolower(pathinfo($_FILES['thumbnail']['name'], PATHINFO_EXTENSION));

        if (in_array($ext, $allowed)) {

            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            // hapus thumbnail lama
            if (!empty($post['thumbnail'])) {
                $oldFile = $uploadDir . $post['thumbnail'];
                if (file_exists($oldFile)) {
                    unlink($oldFile);
                }
            }

            $thumbnailName = uniqid('blog_', true) . '.' . $ext;
            move_uploaded_file(
                $_FILES['thumbnail']['tmp_name'],
                $uploadDir . $thumbnailName
            );
        }
    }

    // ===== UPDATE DATABASE =====
    $stmtUp = $conn->prepare("
        UPDATE blog_posts
        SET title = ?, slug = ?, content = ?, thumbnail = ?, published_at = ?
        WHERE id = ?
    ");
    $stmtUp->bind_param(
        "sssssi",
        $title,
        $slug,
        $content,
        $thumbnailName,
        $publish,
        $id
    );
    $stmtUp->execute();

    header("Location: index.php?updated=1");
    exit;
}
?>

<style>
.admin-content {
    background: #faf7f3;
    padding: 25px;
    min-height: 100vh;
    border-radius: 16px;
}

.form-wrapper {
    max-width: 800px;
    margin: auto;
}

.page-title {
    font-size: 24px;
    font-weight: 700;
    margin-bottom: 25px;
    color: #543824;
}

.form-group {
    margin-bottom: 18px;
}

.form-group label {
    font-weight: 600;
    display: block;
    margin-bottom: 6px;
}

.form-control {
    width: 100%;
    padding: 12px;
    border-radius: 10px;
    border: 1px solid #ddd;
}

.btn-primary {
    padding: 10px 18px;
    background: #543824;
    color: #fff;
    border-radius: 10px;
    font-weight: 600;
    border: none;
}

.btn-secondary {
    padding: 10px 18px;
    background: #ccc;
    color: #333;
    border-radius: 10px;
    font-weight: 600;
    text-decoration: none;
}
</style>

<div class="content">
<div class="admin-content">
<div class="form-wrapper">

    <h2 class="page-title">✏️ Edit Artikel Blog</h2>

    <form method="POST" enctype="multipart/form-data">

        <div class="form-group">
            <label>Judul</label>
            <input type="text" name="title" class="form-control"
                   value="<?= htmlspecialchars($post['title']) ?>" required>
        </div>

        <div class="form-group">
            <label>Slug</label>
            <input type="text" name="slug" class="form-control"
                   value="<?= htmlspecialchars($post['slug']) ?>" required>
        </div>

        <div class="form-group">
            <label>Thumbnail</label>
            <input type="file" name="thumbnail" class="form-control">
            <?php if ($post['thumbnail']): ?>
                <small>Thumbnail saat ini:</small><br>
                <img src="/fatimah-collection-clean/public/uploads/blog/<?= $post['thumbnail'] ?>"
                     style="width:120px; margin-top:6px; border-radius:6px;">
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label>Isi Artikel</label>
            <textarea name="content" rows="8" class="form-control" required><?= htmlspecialchars($post['content']) ?></textarea>
        </div>

        <div class="form-group">
            <label>Status</label>
            <select name="publish" class="form-control">
                <option value="1" <?= $post['published_at'] ? 'selected' : '' ?>>Publish</option>
                <option value="0" <?= !$post['published_at'] ? 'selected' : '' ?>>Draft</option>
            </select>
        </div>

        <button type="submit" class="btn-primary">Update</button>
        <a href="index.php" class="btn-secondary">Kembali</a>
    </form>

</div>
</div>
</div>
