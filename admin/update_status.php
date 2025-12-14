<?php
require_once "../app/config/database.php";
$db = new Database();
$conn = $db->conn;


if(isset($_POST['order_id'], $_POST['status'])){
    $id = $_POST['order_id'];
    $status = $_POST['status'];

    $stmt = $conn->prepare("UPDATE orders SET status=? WHERE id=?");
    $stmt->bind_param("si", $status, $id);
    $stmt->execute();
}

header("Location: index.php");
exit;
