<?php
session_start();
require_once '../app/config/database.php';

if (!isset($_SESSION['user_id'])) exit;

$db = new Database();
$conn = $db->conn;

$user_id = $_SESSION['user_id'];
$product_id = intval($_POST['product_id']);

$conn->query("DELETE FROM wishlist WHERE user_id=$user_id AND product_id=$product_id");

echo "REMOVED";
