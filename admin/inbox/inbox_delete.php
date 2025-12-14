<?php
session_start();
require_once '../app/config/database.php';
include 'components/auth_check.php';

if (!isset($_GET['id'])) {
    header("Location: inbox.php");
    exit;
}

$id = intval($_GET['id']);

$conn->query("DELETE FROM contact_messages WHERE id = $id");

header("Location: inbox.php?msg=Pesan berhasil dihapus");
exit;
