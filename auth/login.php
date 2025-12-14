<?php
session_start();
require_once '../app/config/database.php';

// BUAT KONEKSI DATABASE
$db = new Database();
$conn = $db->conn;

// PROSES LOGIN
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = $_POST['email'];
    $password = $_POST['password'];

    // Cek email
    $sql = "SELECT * FROM users WHERE email = ? LIMIT 1";
    $stmt = $conn->prepare($sql); // FIXED
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if (!$user) {
        $error = "Email tidak ditemukan.";
    } 
    elseif (!password_verify($password, $user['password'])) {
        $error = "Password salah.";
    } 
    else {
        // SET SESSION
        $_SESSION['is_login'] = true;
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_email'] = $user['email'];

        header("Location: ../public/home.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Masuk - Fatimah Collection</title>

  <!-- FIXED PATH CSS -->
  <link rel="stylesheet" href="../public/assets/css/auth.css">
</head>
<body>

<div class="auth-wrapper">

  <div class="auth-card">
    
    <!-- Left Side -->
    <div class="auth-left">
      <h1>Selamat Datang Kembali 💕</h1>
      <p>Masuk dan lanjutkan perjalanan belanja fashion terbaik dari  
         <span>Fatimah Collection</span>.</p>
      <a href="register.php" class="switch-btn">Belum punya akun? Daftar Sekarang</a>
    </div>

    <!-- Right Side -->
    <div class="auth-right">
      <h2>Masuk ke Akun</h2>

      <!-- Error Message -->
      <?php if(isset($error)): ?>
        <div style="background:#ffebee; padding:10px; margin-bottom:10px; border-radius:8px; color:#c62828;">
          <?= $error; ?>
        </div>
      <?php endif; ?>

      <form method="POST" class="auth-form">
        <div class="input-group">
          <input type="email" name="email" required>
          <label>Alamat Email</label>
        </div>

        <div class="input-group">
          <input type="password" name="password" required>
          <label>Kata Sandi</label>
        </div>

        <button type="submit" class="auth-btn">Masuk</button>
      </form>

      <div class="social-area">
        <p>Atau masuk dengan</p>

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
