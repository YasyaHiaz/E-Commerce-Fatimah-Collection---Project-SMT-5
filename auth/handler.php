<?php
session_start();
require_once "../app/config/database.php";
require_once "../app/models/UserModel.php";

$db = new Database();
$userModel = new UserModel($db->conn);

// Ambil action dari form
$action = $_POST['action'] ?? $_GET['action'] ?? null;

switch ($action) {

  // LOGIN
  case 'signin':
    $email = $_POST['email'] ?? null;
    $password = $_POST['password'] ?? null;

    $login = $userModel->login($email, $password);

    if ($login) {
      $_SESSION['user_id'] = $login['id'];
      $_SESSION['user_name'] = $login['nama'];

      header('Location: ../home.php');
      exit;
    } else {
      echo "<script>alert('Email atau password salah!'); history.back();</script>";
    }
  break;

  // REGISTER
  case 'signup':
    $nama = $_POST['nama'] ?? null;
    $email = $_POST['email'] ?? null;
    $password = $_POST['password'] ?? null;
    $confirm = $_POST['confirm_password'] ?? null;

    // Cek konfirmasi password
    if ($password !== $confirm) {
      echo "<script>alert('Konfirmasi password tidak cocok!'); history.back();</script>";
      exit;
    }

    $register = $userModel->register($nama, $email, $password);

    if ($register) {
      echo "<script>alert('Berhasil daftar, silakan login'); window.location='login.php';</script>";
    } else {
      echo "<script>alert('Email sudah digunakan!'); history.back();</script>";
    }
  break;

  // Jika action tidak dikenali
  default:
    echo "INVALID ACTION.";
}
