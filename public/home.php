<?php
include 'components/auth_check.php';

if (isLogin()) {
    include 'components/header_user.php';
} else {
    include 'components/header_guest.php';
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Fatimah Collection - Modest & Elegant Fashion</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Poppins', sans-serif;
    background: #fafafa;
    color: #5E3D1D;
}

/* HERO */
.hero {
    min-height: 80vh;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 80px 8%;
    gap: 40px;
    background: linear-gradient(120deg, #FFE9F3, #FFF6FB);
}

.hero-text h1 {
    font-size: 52px;
    font-weight: 700;
    color: #4A2C16;
}

.hero-text p {
    font-size: 18px;
    margin-top: 12px;
    max-width: 420px;
    opacity: 0.75;
}

/* CTA BUTTON */
.btn-cta {
    display: inline-block;
    margin-top: 28px;
    padding: 16px 44px;
    background: #6d4c41;
    color: #fff;
    border-radius: 50px;
    font-size: 16px;
    font-weight: 600;
    text-decoration: none;
    transition: .3s ease;
    box-shadow: 0 12px 30px rgba(0,0,0,0.1);
}

.btn-cta:hover {
    background: #5d4037;
    transform: translateY(-3px);
}

/* IMAGE */
.hero img {
    width: 450px;
    border-radius: 20px;
    object-fit: cover;
    box-shadow: 0 20px 50px rgba(0,0,0,0.12);
}

/* SECTIONS */
.section {
    padding: 70px 8%;
}

.section-title {
    text-align: center;
    font-size: 32px;
    font-weight: 600;
    color: #4A2C16;
    margin-bottom: 30px;
}

/* PROMO */
.promo-banner {
    margin: 50px auto;
    padding: 28px;
    max-width: 900px;
    background: linear-gradient(135deg, #ff9cc8, #ff68ac);
    color: #fff;
    text-align: center;
    border-radius: 18px;
    font-size: 18px;
    font-weight: 600;
    box-shadow: 0 10px 30px rgba(0,0,0,0.12);
}

/* CATEGORY */
.category-list {
    display: flex;
    gap: 25px;
    justify-content: center;
    flex-wrap: wrap;
}

.category-card {
    background: #fff;
    width: 170px;
    border-radius: 18px;
    padding: 15px;
    text-align: center;
    box-shadow: 0 6px 20px rgba(0,0,0,0.06);
    transition: .3s;
    cursor: pointer;
}

.category-card:hover {
    transform: translateY(-6px);
}

.category-card img {
    width: 100%;
    height: 140px;
    border-radius: 12px;
    object-fit: cover;
}

/* PRODUCT */
.product-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
    gap: 24px;
}

.product-card {
    background: #fff;
    border-radius: 20px;
    padding: 16px;
    text-align: center;
    box-shadow: 0 10px 25px rgba(0,0,0,0.06);
    transition: .3s ease;
}

.product-card:hover {
    transform: translateY(-8px);
}

.product-card img {
    width: 100%;
    height: 260px;
    object-fit: cover;
    border-radius: 14px;
}

.product-card span {
    color: #FF6F9C;
    font-weight: 700;
}

/* TESTIMONI */
/* TESTIMONI SECTION - FIXED LAYOUT */

.testimoni-cards {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
    gap: 24px;
    justify-items: center;
    align-items: stretch;
}

.testimoni-card {
    background: #fff;
    padding: 28px 22px;
    width: 100%;
    max-width: 300px;
    border-radius: 22px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.06);
    text-align: center;

    display: flex;
    flex-direction: column;
    justify-content: space-between;
    gap: 14px;

    transition: transform .3s ease, box-shadow .3s ease;
}

.testimoni-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 16px 38px rgba(0,0,0,0.08);
}

/* Avatar image rapi */
.testimoni-card img {
    width: 70px;
    height: 70px;
    border-radius: 50%;
    object-fit: cove
}

/* NEWSLETTER */
.newsletter {
    background: #f3f3f3;
    padding: 70px 8%;
    text-align: center;
}

.newsletter input {
    padding: 14px 20px;
    border-radius: 30px;
    border: 1px solid #ccc;
    width: 300px;
}

.newsletter button {
    padding: 14px 30px;
    border-radius: 30px;
    background: #6d4c41;
    border: none;
    color: #fff;
    font-weight: 600;
    margin-left: 10px;
    cursor: pointer;
    transition: .3s;
}

.newsletter button:hover {
    background: #5d4037;
}

/* RESPONSIVE */
@media (max-width: 900px) {
    .hero {
        flex-direction: column-reverse;
        text-align: center;
    }

    .hero img {
        width: 85%;
    }
}
</style>
</head>

<body>

<!-- HERO -->
<section class="hero" data-aos="fade-up">
    <div class="hero-text">
        <h1>Modest & Elegant Fashion</h1>
        <p>Tampil Anggun & Stylish dengan Koleksi Hijab Modern dari Fatimah Collection</p>

        <a href="shop.php" class="btn-cta">Belanja Sekarang</a>
    </div>

    <img src="./assets/images/kontak-img.jpeg" alt="Model Fashion">
</section>

<!-- PROMO -->
<div class="promo-banner" data-aos="fade-up">
    ⭐ Diskon Spesial Akhir Tahun - Hingga 40% Untuk Semua Produk! ⭐
</div>

<!-- CATEGORY -->
<section class="section" data-aos="fade-up">
    <h2 class="section-title">Kategori</h2>
    <div class="category-list">
        <div class="category-card"><img src="./assets/images/Hijab.jpg"><p>Hijab</p></div>
        <div class="category-card"><img src="./assets/images/Gamis.JPG"><p>Gamis</p></div>
        <div class="category-card"><img src="./assets/images/Dress.png"><p>Dress</p></div>
        <div class="category-card"><img src="./assets/images/Outwear.png"><p>Outerwear</p></div>
    </div>
</section>

<!-- PRODUCT -->
<section class="section" data-aos="fade-up">
    <h2 class="section-title">Best Seller</h2>
    <div class="product-grid">
        <div class="product-card"><img src="./assets/images/Paris Elegant Hijab.jpg"><h4>Paris Elegant Hijab</h4><span>Rp 150.000</span></div>
        <div class="product-card"><img src="./assets/images/Premium Dress Syari.jpg"><h4>Premium Dress Syari</h4><span>Rp 380.000</span></div>
        <div class="product-card"><img src="./assets/images/Timeless Outer Linen.jpg"><h4>Timeless Outer Linen</h4><span>Rp 280.000</span></div>
        <div class="product-card"><img src="./assets/images/Floral Abaya.jpg"><h4>Floral Abaya</h4><span>Rp 420.000</span></div>
    </div>
</section>

<!-- TESTIMONI -->
<section class="section" data-aos="fade-up">
    <h2 class="section-title">Apa Kata Mereka?</h2>
    <div class="testimoni-cards">
        <div class="testimoni-card"><img src="./assets/images/labib.jpg"><p>“Bahan adem, jatuh, dan nyaman! Recommended!”</p></div>
        <div class="testimoni-card"><img src="./assets/images/farid.jpg"><p>“Hijab cantik, packaging premium, pengiriman cepat!”</p></div>
    </div>
</section>

<!-- NEWSLETTER -->
<section class="newsletter" data-aos="fade-up">
    <h2 class="section-title">Dapatkan Update & Promo Menarik!</h2>
    <input type="email" placeholder="Masukkan Email">
    <button>Subscribe</button>
</section>

<?php include 'components/footer.php'; ?>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
AOS.init({ duration: 900, once: true });
</script>

</body>
</html>
