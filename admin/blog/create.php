<?php
// ============================
// INIT
// ============================
session_start();
require_once "../../app/config/database.php";
include "../layout.php"; // SAMA DENGAN PAGE PRODUCT

// ============================
// KONEKSI DATABASE
// ============================
$db   = new Database();
$conn = $db->conn;

// ============================
// HELPER ESCAPE
// ============================
if (!function_exists('esc')) {
    function esc($s) {
        return htmlspecialchars($s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }
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
    display: block;
    margin-bottom: 6px;
    font-weight: 600;
    color: #3d2b1f;
}

.form-control {
    width: 100%;
    padding: 12px 14px;
    border-radius: 10px;
    border: 1px solid #ddd;
    font-size: 15px;
}

.form-control:focus {
    outline: none;
    border-color: #543824;
    box-shadow: 0 0 0 2px rgba(84,56,36,.15);
}

.btn-primary {
    padding: 10px 18px;
    background: #543824;
    color: #fff;
    border-radius: 10px;
    font-weight: 600;
    text-decoration: none;
    border: none;
    cursor: pointer;
}

.btn-secondary {
    padding: 10px 18px;
    background: #ccc;
    color: #333;
    border-radius: 10px;
    text-decoration: none;
    font-weight: 600;
    margin-left: 6px;
}
</style>

<div class="content">
<div class="admin-content">

    <div class="form-wrapper">
        <h2 class="page-title">📝 Tambah Artikel Blog</h2>

        <form action="store.php" method="POST" enctype="multipart/form-data">

            <div class="form-group">
                <label>Judul Artikel</label>
                <input type="text" name="title" required class="form-control">
            </div>

            <div class="form-group">
                <label>Slug (URL)</label>
                <input type="text" name="slug"
                       placeholder="contoh-artikel-blog"
                       required class="form-control">
            </div>

            <div class="form-group">
                <label>Thumbnail</label>
                <input type="file" name="thumbnail" accept="image/*" class="form-control">
            </div>

            <div class="form-group">
                <label>Isi Artikel</label>
                <textarea name="content" rows="8" required class="form-control"></textarea>
            </div>

            <div class="form-group">
                <label>Status</label>
                <select name="publish" class="form-control">
                    <option value="1">Publish</option>
                    <option value="0">Draft</option>
                </select>
            </div>

            <button type="submit" class="btn-primary">Simpan Artikel</button>
            <a href="index.php" class="btn-secondary">Kembali</a>
        </form>
    </div>

</div>
</div>
