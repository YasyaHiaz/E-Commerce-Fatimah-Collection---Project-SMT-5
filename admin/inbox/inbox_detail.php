<?php
session_start();
require_once '../../app/config/database.php';

if (!isset($_GET['id'])) {
    header("Location: inbox.php");
    exit;
}

$id = intval($_GET['id']);

// Ambil data pesan
$query  = "SELECT * FROM contact_messages WHERE id = $id";
$result = $db->query($query);
$data   = $result->fetch_assoc();

if (!$data) {
    header("Location: inbox.php?msg=Pesan tidak ditemukan");
    exit;
}

// Update status jadi dibaca
$db->query("UPDATE contact_messages SET status = 'dibaca' WHERE id = $id");

// Layout dashboard
include '../layout.php';
?>

<style>
/* ==============================================
   DETAIL PAGE – SAMA DENGAN STYLE INBOX
================================================ */

.inbox-detail-page {
    width: 100%;
    background: #faf7f3;
    padding: 25px;
    border-radius: 16px;
}

.detail-title {
    font-size: 28px;
    font-weight: 700;
    color: #5A4640;
    text-align: center;
    margin-bottom: 25px;
}

.detail-card {
    background: #ffffff;
    border-radius: 18px;
    padding: 28px 30px;
    border: 1px solid #edd6c4;
    box-shadow: 0 8px 24px rgba(179, 139, 103, 0.15);
    transition: .25s;
}

.detail-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 28px rgba(179, 139, 103, 0.20);
}

.detail-row {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    margin-bottom: 12px;
    font-size: 15px;
    color: #4e3e39;
}

.detail-label {
    font-weight: 600;
    min-width: 100px;
    color: #5A4640;
}

.message-box {
    background: #fdf7f4;
    padding: 18px;
    border-radius: 14px;
    border: 1px solid #edd6c4;
    font-size: 15px;
    line-height: 1.7;
    color: #4e3e39;
}

/* BUTTONS SAMA SEPERTI INBOX */
.detail-actions {
    margin-top: 25px;
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 10px;
}

.btn-back {
    background: #5A4640;
    color: white !important;
    padding: 9px 16px;
    border-radius: 10px;
    font-size: 14px;
    font-weight: 600;
    text-decoration: none;
    transition: .25s;
}

.btn-back:hover {
    background: #6e544d;
}

.btn-delete {
    background: #f5b8c6;
    color: #742033 !important;
    padding: 9px 16px;
    border-radius: 10px;
    font-size: 14px;
    font-weight: 600;
    text-decoration: none;
    transition: .25s;
}

.btn-delete:hover {
    background: #ff8faa;
}

/* RESPONSIVE */
@media (max-width: 768px) {
    .detail-title {
        font-size: 24px;
    }

    .detail-card {
        padding: 20px;
    }
}
</style>

<!-- WRAPPER WAJIB MASUK ke .content -->
<div class="content">
    <div class="inbox-detail-page">

        <h2 class="detail-title">Detail Pesan</h2>

        <div class="detail-card">

            <div class="detail-row">
                <div class="detail-label">Nama</div>
                <div>: <?= htmlspecialchars($data['name']); ?></div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Email</div>
                <div>: <?= htmlspecialchars($data['email']); ?></div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Tanggal</div>
                <div>: <?= htmlspecialchars($data['created_at']); ?></div>
            </div>

            <hr style="margin:18px 0;">

            <div>
                <div class="detail-label mb-2">Isi Pesan</div>
                <div class="message-box">
                    <?= nl2br(htmlspecialchars($data['message'])); ?>
                </div>
            </div>

            <div class="detail-actions">
                <a href="inbox.php" class="btn-back">← Kembali</a>

                <a href="inbox_delete.php?id=<?= $data['id']; ?>"
                   onclick="return confirm('Yakin ingin menghapus pesan ini?')"
                   class="btn-delete">
                    Hapus Pesan
                </a>
            </div>

        </div>
    </div>
</div>
