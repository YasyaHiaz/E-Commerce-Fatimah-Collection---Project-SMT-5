<?php
include("../../app/config/database.php");

if (!isset($_GET['id'])) { die("ID tidak ditemukan."); }

$id = intval($_GET['id']);

$file = $db->query("SELECT image FROM products WHERE id=$id")->fetch_assoc();

if ($file['image'] && file_exists("../../uploads/products/".$file['image'])) {
    unlink("../../uploads/products/".$file['image']);
}

$db->query("DELETE FROM products WHERE id=$id");

header("Location: index.php");
exit;
