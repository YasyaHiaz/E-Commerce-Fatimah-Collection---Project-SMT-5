<?php
include '../layout.php';
include '../../app/config/database.php';

// Ambil data pesanan
$result = $db->query("
    SELECT o.*, u.name AS user_name 
    FROM orders o 
    LEFT JOIN users u ON o.user_id = u.id 
    ORDER BY o.id DESC
");
?>

<style>
/* ===== PAGE WRAPPER ===== */
.order-container {
    background: #faf7f3;
    padding: 25px;
    min-height: 100vh;
    border-radius: 16px;
}

/* PAGE TITLE */
.page-title {
    font-size: 24px;
    font-weight: 700;
    margin-bottom: 22px;
    color: #4a3520;
    letter-spacing: 0.3px;
}

/* TABLE STYLING */
.table-order {
    width: 100%;
    border-collapse: collapse;
    background: #ffffff;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 6px 16px rgba(0,0,0,0.08);
}

.table-order thead th {
    background: #543824;
    padding: 14px 16px;
    color: #fff;
    font-size: 14px;
    font-weight: 600;
    text-align: left;
}

.table-order tbody tr td {
    padding: 13px 16px;
    border-bottom: 1px solid #eee;
    font-size: 14px;
}

.table-order tbody tr:hover {
    background: #fff7ef;
}

/* BADGES */
.badge {
    padding: 5px 12px;
    border-radius: 6px;
    font-size: 12.5px;
    font-weight: 600;
}

.badge-pending   { background:#ffeccb; color:#9a6a00; }
.badge-paid      { background:#d4ffdf; color:#0f6c40; }
.badge-shipped   { background:#dce8ff; color:#003c7a; }
.badge-completed { background:#c8ffd8; color:#0e7b42; }
.badge-cancelled { background:#ffd3d3; color:#992323; }

/* ACTION BUTTONS */
.btn-act {
    padding: 7px 12px;
    border-radius: 6px;
    font-size: 13px;
    font-weight: 600;
    text-decoration: none;
    color: #fff;
    transition: .2s;
    margin-right: 4px;
}

.btn-update { background: #543824; }
.btn-update:hover { background: #6a4a2f; }

.btn-view { background: #b38b65; }
.btn-view:hover { background: #9c7654; }

/* RESPONSIVE TABLE */
@media (max-width: 600px) {
    .table-order thead {
        display: none;
    }

    .table-order tr {
        display: block;
        margin-bottom: 14px;
        border-bottom: 2px solid #eee;
        padding-bottom: 10px;
    }

    .table-order td {
        display: flex;
        justify-content: space-between;
        padding: 10px;
        font-size: 13px;
    }

    .table-order td::before {
        content: attr(data-label);
        font-weight: 700;
        color: #543824;
    }
}
</style>

<div class="content">
    <div class="order-container">

        <h2 class="page-title">Manajemen Pesanan</h2>

        <table class="table-order">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>User</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td data-label="ID"><?= $row['id'] ?></td>
                    <td data-label="User"><?= $row['user_name'] ?></td>
                    <td data-label="Total">Rp <?= number_format($row['total_price'], 0, ',', '.') ?></td>

                    <td data-label="Status">
                        <span class="badge badge-<?= $row['status'] ?>">
                            <?= ucfirst($row['status']) ?>
                        </span>
                    </td>

                    <td data-label="Aksi">
                        <a href="view.php?id=<?= $row['id'] ?>" class="btn-act btn-view">Detail</a>
                        <a href="edit.php?id=<?= $row['id'] ?>" class="btn-act btn-update">Update</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

    </div>
</div>
