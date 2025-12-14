<?php
session_start();
require_once '../app/config/database.php';

// CEK LOGIN
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

$db = new Database();
$conn = $db->conn;

$user_id = $_SESSION['user_id'];

// ----------------------------------------------------------
// UPLOAD FOTO PROFIL
// ----------------------------------------------------------
$profile_name = null;

if (!empty($_FILES['profile_photo']['name'])) {
    $file = $_FILES['profile_photo'];

    $allowed = ['jpg', 'jpeg', 'png'];
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

    if (in_array($ext, $allowed) && $file['size'] <= 2000000) {

        $profile_name = "USER_" . time() . "." . $ext;
        $path = "../public/uploads/profile/" . $profile_name;

        // HAPUS FOTO LAMA
        $old = $conn->query("SELECT profile_photo FROM users WHERE id = $user_id")
                    ->fetch_assoc()['profile_photo'];

        if ($old && file_exists("../public/uploads/profile/" . $old)) {
            unlink("../public/uploads/profile/" . $old);
        }

        move_uploaded_file($file['tmp_name'], $path);
    }
}

// ----------------------------------------------------------
// UPDATE DATA LAIN
// ----------------------------------------------------------
$name     = $_POST['name'];
$email    = $_POST['email'];
$password = $_POST['password'];

// Jika password diisi → update password
if (!empty($password)) {

    $hashed = password_hash($password, PASSWORD_DEFAULT);

    if ($profile_name) {
        $stmt = $conn->prepare("
            UPDATE users 
            SET name=?, email=?, password=?, profile_photo=? 
            WHERE id=?
        ");
        $stmt->bind_param("ssssi", $name, $email, $hashed, $profile_name, $user_id);

    } else {
        $stmt = $conn->prepare("
            UPDATE users 
            SET name=?, email=?, password=? 
            WHERE id=?
        ");
        $stmt->bind_param("sssi", $name, $email, $hashed, $user_id);
    }

} else { 
    // Jika password kosong → tidak update password

    if ($profile_name) {
        $stmt = $conn->prepare("
            UPDATE users 
            SET name=?, email=?, profile_photo=? 
            WHERE id=?
        ");
        $stmt->bind_param("sssi", $name, $email, $profile_name, $user_id);

    } else {
        $stmt = $conn->prepare("
            UPDATE users 
            SET name=?, email=? 
            WHERE id=?
        ");
        $stmt->bind_param("ssi", $name, $email, $user_id);
    }
}

$stmt->execute();
$stmt->close();

// ----------------------------------------------------------
// REDIRECT DENGAN POPUP
// ----------------------------------------------------------
header("Location: index.php?updated=1");
exit;
