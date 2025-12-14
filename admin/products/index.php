<?php
include("../../app/config/database.php");
include '../layout.php';

$result = $db->query("SELECT * FROM products ORDER BY id DESC");
?>

<style>
/* WRAPPER UTAMA AGAR IKUT LAYOUT */
.admin-content {
    background: #faf7f3;
    padding: 25px;
    min-height: 100vh;
    border-radius: 16px;
}

/* TOP BAR PAGE */
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
    letter-spacing: 0.3px;
}

/* BUTTON ADD PRODUCT */
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

/* TABLE WRAPPER */
.table-modern {
    width: 100%;
    background: #fff;
    border-radius: 12px;
    padding: 18px 22px;
    box-shadow: 0 6px 16px rgba(0,0,0,0.1);
    overflow-x: auto; /* AGAR RESPONSIVE TIDAK PECAH */
}

/* TABLE STYLE */
.table-modern table {
    width: 100%;
    border-collapse: collapse;
    min-width: 720px; /* AGAR RAPI SAAT SCROLL DI HP */
}

.table-modern th {
    background: #f3ece5;
    padding: 14px 12px;
    color: #543824;
    font-weight: 700;
    font-size: 15px;
    text-align: left;
    letter-spacing: 0.3px;
}

.table-modern td {
    padding: 13px 12px;
    border-bottom: 1px solid #eee;
    font-size: 15px;
    color: #3d2b1f;
}

.table-modern tr:hover {
    background: #faf5ef;
}

/* PRODUK IMAGE */
.product-img {
    width: 70px;
    height: 70px;
    object-fit: cover;
    border-radius: 6px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.15);
}

/* ACTION BUTTONS */
.action-btn {
    padding: 7px 14px;
    border-radius: 6px;
    font-size: 14px;
    font-weight: 600;
    text-decoration: none;
    display: inline-block;
    transition: .25s;
}

.edit-btn {
    background: #b48862;
    color: white;
}
.edit-btn:hover {
    background: #9e7452;
}

.delete-btn {
    background: #d9534f;
    color: white;
}
.delete-btn:hover {
    background: #c64540;
}

/* MOBILE RESPONSIVE TITLE */
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
        <h2 class="page-title">📦 Manajemen Produk</h2>
        <a href="create.php" class="btn-primary">+ Tambah Produk</a>
    </div>

    <div class="table-modern">
        <table>
            <tr>
                <th>No</th>
                <th>Produk</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Gambar</th>
                <th>Aksi</th>
            </tr>

            <?php $no = 1; while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= $row['name'] ?></td>
                <td>Rp <?= number_format($row['price'], 0, ',', '.') ?></td>
                <td><?= $row['stock'] ?></td>

                <td>
                    <img class="product-img"
                         src="/fatimah-collection-clean/public/assets/images/<?= $row['image'] ?>">
                </td>

                <td>
                    <a href="edit.php?id=<?= $row['id'] ?>" class="action-btn edit-btn">Edit</a>
                    <a href="delete.php?id=<?= $row['id'] ?>"
                       onclick="return confirm('Hapus produk ini?')"
                       class="action-btn delete-btn">Hapus</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>

</div>
</div>
