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
// AMBIL DATA BLOG (UNTUK THUMBNAIL)
// ============================
$id = intval($_GET['id'] ?? 0);

if ($id <= 0) {
    header("Location: index.php");
    exit;
}

$stmt = $conn->prepare("
    SELECT thumbnail 
    FROM blog_posts 
    WHERE id = ?
");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$post = $result->fetch_assoc();

if (!$post) {
    header("Location: index.php");
    exit;
}

// ============================
// HAPUS FILE THUMBNAIL
// ============================
if (!empty($post['thumbnail'])) {
    $filePath = "../../public/uploads/blog/" . $post['thumbnail'];
    if (file_exists($filePath)) {
        unlink($filePath);
    }
}

// ============================
// DELETE DATABASE
// ============================
$stmtDel = $conn->prepare("
    DELETE FROM blog_posts 
    WHERE id = ?
");
$stmtDel->bind_param("i", $id);
$stmtDel->execute();

// ============================
// REDIRECT
// ============================
header("Location: index.php?deleted=1");
exit;
