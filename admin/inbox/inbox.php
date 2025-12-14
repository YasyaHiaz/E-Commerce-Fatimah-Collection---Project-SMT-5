<?php
require_once '../../app/config/database.php';

// Ambil data pesan
$query = "SELECT * FROM contact_messages ORDER BY created_at DESC";
$result = $db->query($query);

// Layout
include '../layout.php';
?>

<style>
/* ==============================================
   INBOX PAGE – RESPONSIVE WITH DASHBOARD LAYOUT
================================================*/

.inbox-page {
    width: 100%;
    background: #faf7f3;
    padding: 20px 25px;
    border-radius: 16px;
    box-sizing: border-box;
}

.page-title {
    font-size: 28px;
    font-weight: 700;
    color: #5A4640;
    text-align: center;
    margin-bottom: 25px;
}

/* Wrapper */
.inbox-wrapper {
    background: #ffffff;
    border-radius: 18px;
    padding: 22px;
    border: 1px solid #edd6c4;
    box-shadow: 0 8px 24px rgba(179, 139, 103, 0.15);
    transition: .25s;
}

.inbox-wrapper:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 28px rgba(179, 139, 103, 0.20);
}

/* TABLE */
.table-modern {
    width: 100%;
    border-radius: 16px;
    overflow: hidden;
    border: 1px solid #edd6c4;
    background: white;
}

.table-modern thead {
    background: #5A4640;
    color: white;
}

.table-modern th,
.table-modern td {
    padding: 13px 16px;
    font-size: 14px;
    text-align: left;
}

.table-modern tbody tr:hover {
    background: #f5eee8;
}

/* BADGES */
.badge-new,
.badge-read {
    padding: 6px 12px;
    border-radius: 30px;
    font-size: 12px;
    font-weight: 600;
    display: inline-block;
}

.badge-new {
    background: #fcd8d8;
    color: #7b2727;
}

.badge-read {
    background: #d9f9e0;
    color: #276b2e;
}

/* BUTTONS */
.btn-detail {
    background: #5A4640;
    color: white !important;
    padding: 6px 10px;
    border-radius: 10px;
    border: none;
    font-size: 13px;
    font-weight: 600;
    transition: .25s;
}

.btn-detail:hover {
    background: #6e544d;
}

.btn-delete {
    background: #f5b8c6;
    color: #742033 !important;
    padding: 6px 10px;
    border-radius: 10px;
    border: none;
    font-size: 13px;
    font-weight: 600;
    transition: .25s;
}

.btn-delete:hover {
    background: #ff8faa;
}

/* RESPONSIVE */
@media (max-width: 992px) {
    .inbox-page {
        padding: 18px;
    }
    .page-title {
        font-size: 24px;
    }
    .table-modern th,
    .table-modern td {
        padding: 10px 12px;
        font-size: 13px;
    }
}

@media (max-width: 576px) {
    .inbox-page {
        padding: 15px;
    }
    .inbox-wrapper {
        padding: 16px;
    }
    .page-title {
        font-size: 22px;
    }
    .table-modern th,
    .table-modern td {
        padding: 8px 10px;
    }
}
</style>

<!-- ==============================================
     WRAPPER HARUS MASUK KE DALAM .content !!!
================================================= -->
<div class="content">
    <div class="inbox-page">

        <h2 class="page-title">Inbox Pesan Pengunjung</h2>

        <?php if (isset($_GET['msg'])): ?>
            <div class="alert alert-success text-center rounded-pill">
                <?= htmlspecialchars($_GET['msg']) ?>
            </div>
        <?php endif; ?>

        <div class="inbox-wrapper mt-4">
            <div class="table-responsive">
                <table class="table table-bordered table-modern">
                    <thead>
                        <tr>
                            <th width="50">No</th>
                            <th width="160">Nama</th>
                            <th width="200">Email</th>
                            <th width="150">Tanggal</th>
                            <th width="120">Status</th>
                            <th width="150">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php $no = 1; while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= htmlspecialchars($row['name']); ?></td>
                            <td><?= htmlspecialchars($row['email']); ?></td>
                            <td><?= $row['created_at']; ?></td>

                            <td>
                                <?php if ($row['status'] == 'baru'): ?>
                                    <span class="badge-new">Baru</span>
                                <?php else: ?>
                                    <span class="badge-read">Dibaca</span>
                                <?php endif; ?>
                            </td>

                            <td>
                                <a href="inbox_detail.php?id=<?= $row['id']; ?>"
                                   class="btn-detail me-1">Detail</a>

                                <a href="inbox_delete.php?id=<?= $row['id']; ?>"
                                   onclick="return confirm('Hapus pesan ini?')"
                                   class="btn-delete">
                                    Hapus
                                </a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>

                </table>
            </div>
        </div>

    </div>
</div>
