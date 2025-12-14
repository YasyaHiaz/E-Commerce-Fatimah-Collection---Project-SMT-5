<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Fatimah Collection - Admin</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
/* ====== GLOBAL ====== */
body {
    margin: 0;
    padding: 0;
    font-family: 'Poppins', sans-serif;
    background: #f5f1eb;
    transition: .3s;
}

/* ====== NAVBAR ====== */
/* ================= NAVBAR ================= */
/* ================= NAVBAR ================= */
.navbar {
    width: 100%;
    position: fixed;
    top: 0;
    left: 0;
    background: #543824;
    color: white;
    padding: 0 30px;              /* Tinggi dipaksa via height */
    height: 70px;                 /* 🔥 Bikin elemen rata tengah */
    border-radius: 0;
    display: flex;
    justify-content: space-between;
    align-items: center;          /* 🔥 Tekan semua ke tengah vertikal */
    box-shadow: 0 10px 25px rgba(0,0,0,0.25);
    z-index: 999;
    box-sizing: border-box;
}

/* Kiri */
.left-nav {
    display: flex;
    align-items: center;          /* 🔥 Biar judul + icon rata */
    gap: 18px;
}

.toggle-btn {
    background: transparent;
    border: none;
    color: #f3dcb3;
    font-size: 26px;              /* Sedikit kecil agar lebih rapi */
    cursor: pointer;
    transition: .2s;
    line-height: 1;               /* 🔥 Supaya icon tidak turun */
}
.toggle-btn:hover {
    color: #ffffff;
}

.navbar .title {
    font-size: 19px;
    font-weight: 600;
    color: #f3dcb3;
    letter-spacing: 0.3px;
    line-height: 1;               /* 🔥 Title tidak naik/turun */
}

/* Kanan */
.nav-links {
    display: flex;
    align-items: center;          /* 🔥 Bikin link sejajar dengan kiri */
}

.nav-links a {
    color: #f3dcb3;
    text-decoration: none;
    margin-left: 22px;
    font-weight: 500;
    padding: 10px 14px;
    border-radius: 0;
    transition: .3s;
    letter-spacing: 0.3px;
    line-height: 1;               /* 🔥 Rapikan posisi teks */
}
.nav-links a:hover {
    background: rgba(255,255,255,0.15);
}


/* ====== SIDEBAR ====== */
/* ================= SIDEBAR ================= */
.sidebar {
    width: 220px;
    height: calc(100vh - 70px);     /* mengikuti tinggi navbar baru */
    background: #ffffff;
    position: fixed;
    top: 70px;                      /* pas di bawah navbar */
    left: 0;
    border-radius: 0;               /* 🔥 NO ROUNDED */
    padding: 15px 0;
    box-shadow: 4px 0 15px rgba(0,0,0,0.10);
    display: flex;
    flex-direction: column;
    gap: 6px;
    transition: .3s ease;
    z-index: 998;
}

/* COLLAPSED MODE */
.sidebar.collapsed {
    width: 70px;
}

.sidebar.collapsed span,
.sidebar.collapsed .sidebar-title {
    display: none;
}

/* Title di dalam sidebar */
.sidebar-title {
    font-size: 14px;
    font-weight: 700;
    color: #7a5c46;
    padding: 0 25px;
    margin-bottom: 12px;
    opacity: .75;
}

/* MENU LIST */
.sidebar a {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 14px 25px;
    color: #5c3f2a;
    text-decoration: none;
    font-weight: 600;
    border-left: 4px solid transparent;
    transition: .25s;
    border-radius: 0;               /* 🔥 NO ROUNDED */
}

.sidebar a:hover {
    background: #f7ede6;
    border-left-color: #b88a5f;
    color: #b88a5f;
}

.sidebar a.active {
    background: #f3e5d9;
    border-left-color: #a06c42;
    color: #a06c42;
}

/* ================= CONTENT ================= */
.content {
    margin-left: 220px;            /* ikut lebar sidebar */
    margin-top: 70px;              /* presisi dengan navbar tinggi */
    padding: 35px 40px;
    transition: .3s;
}

.sidebar.collapsed ~ .content {
    margin-left: 70px;             /* ikut lebar versi collapsed */
}

    </style>
</head>

<body>

<!-- ========== NAVBAR ========== -->
<div class="navbar">
    <div class="left-nav">
        <button id="toggleSidebar" class="toggle-btn">
            <i class="bi bi-list"></i>
        </button>

        <div class="title">Fatimah Collection — Admin Dashboard</div>
    </div>

    <div class="nav-links">
        <a href="/fatimah-collection-clean1/admin/index.php">Dashboard</a>
        <a href="/fatimah-collection-clean1/" target="_blank">Lihat Website</a>
        <a href="/fatimah-collection-clean1/admin/logout.php">Logout</a>
    </div>
</div>


<!-- ========== SIDEBAR ========== -->
<div class="sidebar">

    <div class="sidebar-title">Main Menu</div>

    <a href="/fatimah-collection-clean1/admin/users/index.php"
        class="<?= strpos($_SERVER['REQUEST_URI'], 'users') ? 'active' : '' ?>">
        <i class="bi bi-people-fill"></i>
        <span>Manajemen User</span>
    </a>

    <a href="/fatimah-collection-clean1/admin/orders/index.php"
        class="<?= strpos($_SERVER['REQUEST_URI'], 'orders') ? 'active' : '' ?>">
        <i class="bi bi-box-seam-fill"></i>
        <span>Manajemen Pesanan</span>
    </a>

    <a href="/fatimah-collection-clean1/admin/products/index.php"
        class="<?= strpos($_SERVER['REQUEST_URI'], 'products') ? 'active' : '' ?>">
        <i class="bi bi-bag-fill"></i>
        <span>Manajemen Produk</span>
    </a>

    <a href="/fatimah-collection-clean1/admin/inbox/inbox.php"
        class="<?= strpos($_SERVER['REQUEST_URI'], 'inbox') ? 'active' : '' ?>">
        <i class="bi bi-bag-fill"></i>
        <span>Pesan Pengunjung</span>
    </a>

    <a href="/fatimah-collection-clean1/admin/analytics/sales_chart.php"
        class="<?= strpos($_SERVER['REQUEST_URI'], 'analytics') ? 'active' : '' ?>">
        <i class="bi bi-bar-chart-fill"></i>
        <span>Grafik Penjualan</span>
    </a>

    <a href="/fatimah-collection-clean1/admin/reports/sales_report.php"
        class="<?= strpos($_SERVER['REQUEST_URI'], 'reports') ? 'active' : '' ?>">
        <i class="bi bi-file-earmark-text-fill"></i>
        <span>Laporan Penjualan</span>
    </a>


</div>


<!-- ========== SIDEBAR TOGGLE ========== -->
<script>
document.addEventListener("DOMContentLoaded", function () {
    const sidebar = document.querySelector('.sidebar');
    const toggleBtn = document.getElementById('toggleSidebar');
    const content = document.querySelector('.content');

    toggleBtn.onclick = function () {
        sidebar.classList.toggle('collapsed');

        if (sidebar.classList.contains('collapsed')) {
            content.style.marginLeft = "120px";
        } else {
            content.style.marginLeft = "240px";
        }
    };
});
</script>

