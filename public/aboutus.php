<?php
session_start();
require_once '../app/config/database.php'; 
include 'components/auth_check.php'; // Sudah memastikan user login
include 'components/header_user.php'; // Langsung pakai header_user

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Fatimah Collection</title>
    <link rel="stylesheet" href="assets/css/about.css">
</head>

<body class="bg-body">

    <!-- Hero -->
    <section class="section-hero">
        <div class="container text-center">
            <h1 class="title">Tentang Fatimah Collection</h1>
            <p class="subtitle">
                Fatimah Collection adalah brand fashion muslimah yang menghadirkan busana modern, elegan, dan syar'i.
            </p>
        </div>
    </section>

    <!-- Content -->
    <section class="section-content">
        <div class="container grid-2">
            
            <img src="assets/images/about.jpg" class="image-rounded shadow" alt="Tentang Kami">

            <div>
                <h2 class="heading">Perjalanan Kami</h2>
                <p class="text">
                    Fatimah Collection berdiri pada tahun 2019 dan fokus menyediakan pakaian muslimah
                    berkualitas tinggi, nyaman dikenakan, dan sesuai tuntunan syar'i.
                </p>

                <h2 class="heading mt">Visi</h2>
                <p class="text">
                    Menjadi brand fashion muslimah terdepan di Indonesia.
                </p>

                <h2 class="heading mt">Misi</h2>
                <ul class="list">
                    <li>Menghadirkan desain elegan dengan kualitas premium.</li>
                    <li>Memberikan pengalaman belanja terbaik untuk pelanggan.</li>
                    <li>Menjunjung nilai syariah dalam seluruh proses produksi.</li>
                </ul>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <?php include 'components/footer.php'; ?>

</body>
</html>

