<?php
// ============================
// INIT
// ============================
session_start();
require_once "../../app/config/database.php";

// ============================
// KONEKSI DATABASE
// ============================
$db   = new Database();
$conn = $db->conn;

// ============================
// VALIDASI INPUT (MINIMAL)
// ============================
$title   = trim($_POST['title'] ?? '');
$slug    = trim($_POST['slug'] ?? '');
$content = trim($_POST['content'] ?? '');
$publish = ($_POST['publish'] ?? '0') == '1'
            ? date('Y-m-d H:i:s')
            : null;

if ($title === '' || $slug === '' || $content === '') {
    header("Location: create.php?error=empty");
    exit;
}

// ============================
// UPLOAD THUMBNAIL
// ============================
$thumbnailName = null;
$uploadDir = "../../public/uploads/blog/";

if (!empty($_FILES['thumbnail']['name'])) {

    // Validasi ekstensi
    $allowed = ['jpg', 'jpeg', 'png', 'webp'];
    $ext = strtolower(pathinfo($_FILES['thumbnail']['name'], PATHINFO_EXTENSION));

    if (!in_array($ext, $allowed)) {
        header("Location: create.php?error=invalid_image");
        exit;
    }

    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    $thumbnailName = uniqid('blog_', true) . '.' . $ext;
    $uploadPath = $uploadDir . $thumbnailName;

    move_uploaded_file($_FILES['thumbnail']['tmp_name'], $uploadPath);
}

// ============================
// INSERT DATABASE
// ============================
$stmt = $conn->prepare("
    INSERT INTO blog_posts (title, slug, content, thumbnail, published_at)
    VALUES (?, ?, ?, ?, ?)
");

$stmt->bind_param(
    "sssss",
    $title,
    $slug,
    $content,
    $thumbnailName,
    $publish
);

$stmt->execute();

// ============================
// REDIRECT
// ============================
header("Location: index.php?success=1");
exit;
