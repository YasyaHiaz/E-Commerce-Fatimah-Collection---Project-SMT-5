<?php
include("../../app/config/database.php");
include '../layout.php';

// Ambil data user
$result = $db->query("SELECT * FROM users ORDER BY id DESC");
?>

<style>
/* ============================
   WRAPPER AGAR IKUT SIDEBAR LAYOUT
============================ */
.admin-content {
    background: #faf7f3;
    padding: 30px;
    min-height: 100vh;
    border-radius: 16px;
}

/* ============================
   PAGE HEADER
============================ */
.top-bar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 22px;
}

.page-title {
    font-size: 24px;
    font-weight: 700;
    color: #543824;
    margin: 0;
}

/* ADD BUTTON */
.btn-add {
    background: #543824;
    color: white;
    padding: 10px 22px;
    text-decoration: none;
    font-weight: 600;
    border-radius: 10px;
    box-shadow: 0 4px 14px rgba(0,0,0,0.14);
    transition: .25s;
}

.btn-add:hover {
    background: #6a4a2f;
    transform: translateY(-2px);
}

/* ============================
   TABLE WRAPPER RESPONSIVE
============================ */
.table-users-wrapper {
    width: 100%;
    background: white;
    padding: 18px 22px;
    border-radius: 12px;
    margin-top: 18px;
    box-shadow: 0 6px 18px rgba(0,0,0,0.10);

    overflow-x: auto; /* RESPONSIVE */
}

/* TABLE */
.table-users {
    width: 100%;
    border-collapse: collapse;
    min-width: 720px; /* Agar tetap rapi di HP */
}

.table-users thead {
    background: #543824;
    color: white;
}

.table-users th {
    padding: 14px;
    font-size: 14px;
    text-align: left;
}

.table-users td {
    padding: 14px;
    font-size: 14px;
    border-bottom: 1px solid #eee;
}

.table-users tr:hover {
    background: #f7efe7;
}

/* ACTION BUTTONS */
.btn-edit {
    background: #c7a384;
    color: white;
    padding: 6px 16px;
    text-decoration: none;
    border-radius: 6px;
    font-size: 13px;
    transition: .25s;
}
.btn-edit:hover {
    background: #b48d6f;
}

.btn-del {
    background: #ffccd4;
    color: #7a2e3e;
    padding: 6px 16px;
    text-decoration: none;
    border-radius: 6px;
    font-size: 13px;
    transition: .25s;
}
.btn-del:hover {
    background: #ff9bb3;
}

/* MOBILE FIX */
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

    <!-- TITLE BAR -->
    <div class="top-bar">
        <h2 class="page-title">👥 Manajemen User</h2>
        <a href="create.php" class="btn-add">+ Tambah User</a>
    </div>

    <!-- TABLE -->
    <div class="table-users-wrapper">
        <table class="table-users">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Dibuat</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['name'] ?></td>
                    <td><?= $row['email'] ?></td>
                    <td><?= $row['created_at'] ?></td>
                    <td>
                        <a href="edit.php?id=<?= $row['id'] ?>" class="btn-edit">Edit</a>
                        <a href="delete.php?id=<?= $row['id'] ?>"
                           onclick="return confirm('Yakin hapus user ini?')"
                           class="btn-del">Delete</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

</div>
</div>
