<?php
// ============================
// INIT
// ============================
session_start();
require_once "../../app/config/database.php";
include "../layout.php";

// ============================
// KONEKSI DATABASE (WAJIB)
// ============================
$db   = new Database();
$conn = $db->conn;

// ============================
// QUERY DATA BLOG
// ============================
$stmt = $conn->prepare("
    SELECT id, title, slug, published_at 
    FROM blog_posts 
    ORDER BY id DESC
");
$stmt->execute();
$result = $stmt->get_result();
?>

<style>
/* ============================
   BLOG ADMIN STYLE (SAMA DENGAN PRODUK)
============================ */

.admin-content {
    background: #faf7f3;
    padding: 25px;
    min-height: 100vh;
    border-radius: 16px;
}

.top-bar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 18px;
}

.page-title {
    font-size: 24px;
    font-weight: 700;
    margin: 0;
    color: #543824;
}

.btn-primary {
    padding: 10px 18px;
    background: #543824;
    color: white;
    border-radius: 10px;
    text-decoration: none;
    font-weight: 600;
    transition: .25s;
}

.btn-primary:hover {
    background: #6e4c2f;
    transform: translateY(-2px);
    box-shadow: 0 6px 14px rgba(0,0,0,.18);
}

.table-modern {
    width: 100%;
    background: #fff;
    border-radius: 12px;
    padding: 18px 22px;
    box-shadow: 0 6px 16px rgba(0,0,0,0.1);
    overflow-x: auto;
}

.table-modern table {
    width: 100%;
    border-collapse: collapse;
    min-width: 720px;
}

.table-modern th {
    background: #f3ece5;
    padding: 14px 12px;
    color: #543824;
    font-weight: 700;
    text-align: left;
}

.table-modern td {
    padding: 13px 12px;
    border-bottom: 1px solid #eee;
    color: #3d2b1f;
}

.table-modern tr:hover {
    background: #faf5ef;
}

.action-btn {
    padding: 7px 14px;
    border-radius: 6px;
    font-size: 14px;
    font-weight: 600;
    text-decoration: none;
    display: inline-block;
}

.edit-btn {
    background: #b48862;
    color: white;
}

.delete-btn {
    background: #d9534f;
    color: white;
}

@media (max-width: 540px) {
    .top-bar {
        flex-direction: column;
        align-items: flex-start;
        gap: 12px;
    }

    .page-title {
        font-size: 20px;
    }
}
</style>

<div class="content">
<div class="admin-content">

    <div class="top-bar">
        <h2 class="page-title">📝 Manajemen Blog</h2>
        <a href="create.php" class="btn-primary">+ Tambah Artikel</a>
    </div>

    <div class="table-modern">
        <table>
            <tr>
                <th>No</th>
                <th>Judul</th>
                <th>Status</th>
                <th>Tanggal Publish</th>
                <th>Aksi</th>
            </tr>

            <?php $no = 1; while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= htmlspecialchars($row['title']) ?></td>

                <td>
                    <?= $row['published_at']
                        ? '<span style="color:green;font-weight:600;">Publish</span>'
                        : '<span style="color:orange;font-weight:600;">Draft</span>' ?>
                </td>

                <td><?= $row['published_at'] ?? '-' ?></td>

                <td>
                    <a href="edit.php?id=<?= $row['id'] ?>" class="action-btn edit-btn">Edit</a>
                    <a href="delete.php?id=<?= $row['id'] ?>"
                       onclick="return confirm('Hapus artikel ini?')"
                       class="action-btn delete-btn">Hapus</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>

</div>
</div>
