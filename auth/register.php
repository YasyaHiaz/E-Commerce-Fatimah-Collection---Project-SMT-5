<?php include '../app/config/database.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Daftar - Fatimah Collection</title>

  <!-- FIXED PATH -->
  <link rel="stylesheet" href="../public/assets/css/auth.css">
</head>
<body>

<div class="auth-wrapper">

  <div class="auth-card">

    <!-- Left Side -->
    <div class="auth-left">
      <h1>Bergabung Bersama Kami 💕</h1>
      <p>Buat akunmu dan mulailah menemukan koleksi busana muslimah terbaik hanya di <span>Fatimah Collection</span>.</p>
      <a href="login.php" class="switch-btn">Sudah punya akun? Masuk</a>
    </div>

    <!-- Right Side -->
    <div class="auth-right">
      <h2>Buat Akun Baru</h2>

      <form action="handler.php?action=signup" method="POST" class="auth-form">

        <div class="input-group">
          <input type="text" name="nama" required>
          <label>Nama Lengkap</label>
        </div>

        <div class="input-group">
          <input type="email" name="email" required>
          <label>Alamat Email</label>
        </div>

        <div class="input-group">
          <input type="password" name="password" required>
          <label>Kata Sandi</label>
        </div>

        <div class="input-group">
          <input type="password" name="confirm_password" required>
          <label>Konfirmasi Kata Sandi</label>
        </div>

        <button type="submit" class="auth-btn">Daftar Sekarang</button>
      </form>

      <div class="social-area">
        <p>Atau daftar menggunakan</p>

        <div class="social-login">
          <button class="google">Google</button>
          <button class="apple">Apple</button>
        </div>
      </div>

    </div>
  </div>
</div>

</body>
</html>
