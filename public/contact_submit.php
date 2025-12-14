<?php
include '../app/config/database.php'; // sesuaikan dengan file koneksi kamu

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name    = htmlspecialchars($_POST['name']);
    $email   = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);

    // Validasi sederhana
    if (empty($name) || empty($email) || empty($message)) {
        header("Location: contact.php?status=error");
        exit();
    }

    // Query insert
    $stmt = $db->prepare("INSERT INTO contact_messages (name, email, message) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $message);

    if ($stmt->execute()) {
        header("Location: contact.php?status=success");
        exit();
    } else {
        header("Location: contact.php?status=failed");
        exit();
    }
}
?>
