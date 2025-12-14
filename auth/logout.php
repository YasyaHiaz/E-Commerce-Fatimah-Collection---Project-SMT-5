<?php
session_start();

// Hapus semua session user
session_unset();
session_destroy();

// Arahkan ke halaman utama
header("Location: ../public/home.php");
exit;
?>
