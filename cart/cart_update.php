<?php
session_start();
require_once '../app/config/database.php';

// Cek login
if (!isset($_SESSION['user_id'])) {
    echo json_encode(["status" => "error", "message" => "Unauthorized"]);
    exit;
}

$user_id = intval($_SESSION['user_id']);

$id     = intval($_POST['id'] ?? 0);      // ID item cart
$action = $_POST['action'] ?? "";         // plus / minus / remove

if ($id <= 0 || $action === "") {
    echo json_encode(["status" => "error", "message" => "Invalid request"]);
    exit;
}

// Ambil item cart
$stmt = $db->prepare("SELECT qty FROM cart WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $id, $user_id);
$stmt->execute();
$result = $stmt->get_result();
$item = $result->fetch_assoc();

if (!$item) {
    echo json_encode(["status" => "error", "message" => "Item not found"]);
    exit;
}

$currentQty = intval($item['qty']);

switch ($action) {
    case "plus":
        $newQty = $currentQty + 1;
        break;

    case "minus":
        $newQty = max(1, $currentQty - 1); // minimal qty = 1
        break;

    case "remove":
        $del = $db->prepare("DELETE FROM cart WHERE id = ? AND user_id = ?");
        $del->bind_param("ii", $id, $user_id);
        $del->execute();

        echo json_encode(["status" => "success", "message" => "Item removed"]);
        exit;

    default:
        echo json_encode(["status" => "error", "message" => "Invalid action"]);
        exit;
}

// Update qty ke database
$upd = $db->prepare("UPDATE cart SET qty = ? WHERE id = ? AND user_id = ?");
$upd->bind_param("iii", $newQty, $id, $user_id);
$upd->execute();

echo json_encode(["status" => "success", "newQty" => $newQty]);
exit;
