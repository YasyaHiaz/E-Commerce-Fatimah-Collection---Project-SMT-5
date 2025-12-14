<?php
include '../../app/config/database.php';

$id = $_GET['id'];
$db->query("DELETE FROM users WHERE id = $id");

header("Location: index.php");
exit;
