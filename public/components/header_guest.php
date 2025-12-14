<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../../app/config/config.php';
?>


<!-- Navbar -->
<nav class="navbar navbar-expand-lg bg-white py-3 shadow-sm">
  <div class="container">

    <!-- Logo -->
    <a class="navbar-brand fw-bold" href="/fatimah-collection-clean1/index.php" 
       style="font-family:'Playfair Display', serif; color:#5e3d1d;">
      FATIMAH<br>
      <small class="fw-normal" style="font-size:12px; letter-spacing:5px;">
        COLLECTION
      </small>
    </a>

    <!-- Toggle -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Menu -->
    <div class="collapse navbar-collapse justify-content-center" id="mainNav">
      <ul class="navbar-nav">
    <li class="nav-item mx-2">
        <a class="nav-link fw-semibold" href="/fatimah-collection-clean1/public/home.php">Home</a>
    </li>

    <li class="nav-item mx-2">
        <a class="nav-link fw-semibold" href="/fatimah-collection-clean1/public/shop.php">Shop</a>
    </li>

    <li class="nav-item mx-2">
        <a class="nav-link fw-semibold" href="/fatimah-collection-clean1/public/aboutus.php">About Us</a>
    </li>

    <li class="nav-item mx-2">
        <a class="nav-link fw-semibold" href="/fatimah-collection-clean1/public/contact.php">Contact Us</a>
    </li>

    <li class="nav-item mx-2">
        <a class="nav-link fw-semibold" href="/fatimah-collection-clean1/public/blog.php">Blog</a>
    </li>
</ul>


    </div>

    <!-- Icons Right -->
    <div class="d-flex align-items-center gap-3">

      <!-- Wishlist -->
      <a href="/fatimah-collection-clean/public/whislist.php" class="icon-link require-login"><i class="bi bi-heart fs-5"></i></a>

      <!-- Cart -->
      <a href="#" class="icon-link position-relative require-login">
        <i class="bi bi-cart3 fs-5"></i>
        <span class="badge bg-dark text-white position-absolute top-0 start-100 translate-middle" style="font-size:10px;">0</span>
      </a>

      <!-- Account -->
      <a href="#" class="icon-link require-login"><i class="bi bi-person fs-5"></i></a>

    </div>

  </div>
</nav>

<!-- POPUP LOGIN -->
<div id="loginPopup" class="login-popup hidden">
  <div class="popup-box">
      <p class="fw-bold mb-2" style="color:#5e3d1d; font-size:16px;">
        Login diperlukan
      </p>
      <p class="mb-3" style="font-size:14px;">
        Silakan login untuk menggunakan fitur ini.
      </p>
      <a href="/fatimah-collection-clean1/auth/login.php" class="btn btn-sm w-100 text-white fw-semibold" 
         style="background-color:#5e3d1d;">
        Login Sekarang
      </a>
      <button class="btn mt-2 w-100" id="closePopup" style="border:1px solid #ddd;">
        Tutup
      </button>
  </div>
</div>

<!-- STYLE -->
<style>
  .nav-link {
    color:#5e3d1d !important;
    font-weight:600;
    position:relative;
  }
  .nav-link::after {
    content:"";
    position:absolute;
    bottom:-3px; left:0;
    width:0%; height:2px;
    background:#5e3d1d;
    transition:.3s;
  }
  .nav-link:hover::after { width:100%; }

  .icon-link {
    color:#5e3d1d;
    transition:.3s;
  }
  .icon-link:hover {
    color:#a67c52;
    transform:scale(1.1);
  }

  /* POPUP */
  .login-popup {
    position:fixed;
    top:0; left:0;
    width:100%; height:100%;
    background:rgba(0,0,0,.3);
    display:flex;
    align-items:center;
    justify-content:center;
    z-index:2000;
  }
  .login-popup.hidden { display:none; }

  .popup-box {
    background:white;
    padding:25px 28px;
    width:320px;
    border-radius:15px;
    text-align:center;
    box-shadow:0 4px 15px rgba(0,0,0,0.15);
  }
</style>

<!-- JS Popup -->
<script>
document.addEventListener('DOMContentLoaded', () => {
    const popup = document.getElementById('loginPopup');
    const closePop = document.getElementById('closePopup');

    document.querySelectorAll('.require-login').forEach(btn => {
        btn.addEventListener('click', e => {
            e.preventDefault();
            popup.classList.remove('hidden');
        });
    });

    closePop.addEventListener('click', () => {
        popup.classList.add('hidden');
    });
});
</script>

<!-- Fonts & Bootstrap -->
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&family=Poppins&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
