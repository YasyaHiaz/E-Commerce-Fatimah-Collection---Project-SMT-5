<?php
session_start();
header('Content-Type: application/json');

require_once $_SERVER['DOCUMENT_ROOT'] . "/fatimah-collection-clean1/app/config/database.php";
$db = new Database();
$conn = $db->conn;

// ===============================
// CEK LOGIN USER
// ===============================
$user_id = $_SESSION['user_id'] ?? null;

if (!$user_id) {
    echo json_encode([
        "status" => "not_login",
        "message" => "Silakan login terlebih dahulu!"
    ]);
    exit;
}

// ===============================
// VALIDASI INPUT
// ===============================
$product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;

if ($product_id <= 0) {
    echo json_encode([
        "status" => "error",
        "message" => "ID produk tidak valid!"
    ]);
    exit;
}

// ===============================
// CEK APAKAH PRODUK SUDAH DI WISHLIST
// ===============================
$stmt_check = $conn->prepare("SELECT id FROM wishlist WHERE user_id = ? AND product_id = ?");
$stmt_check->bind_param("ii", $user_id, $product_id);
$stmt_check->execute();
$result = $stmt_check->get_result();

$response = [];

if ($result->num_rows > 0) {
    // ===============================
    // REMOVE (HAPUS DARI WISHLIST)
    // ===============================
    $stmt_del = $conn->prepare("DELETE FROM wishlist WHERE user_id = ? AND product_id = ?");
    $stmt_del->bind_param("ii", $user_id, $product_id);
    $stmt_del->execute();

    $response['status'] = "removed";
    $response['message'] = "Dihapus dari wishlist!";
} else {
    // ===============================
    // ADD (TAMBAHKAN KE WISHLIST)
    // ===============================
    $stmt_add = $conn->prepare("INSERT INTO wishlist (user_id, product_id) VALUES (?, ?)");
    $stmt_add->bind_param("ii", $user_id, $product_id);
    $stmt_add->execute();

    $response['status'] = "added";
    $response['message'] = "Ditambahkan ke wishlist!";
}

// ===============================
// HITUNG TOTAL ITEM DI WISHLIST
// ===============================
$stmt_count = $conn->prepare("SELECT COUNT(*) AS total FROM wishlist WHERE user_id = ?");
$stmt_count->bind_param("i", $user_id);
$stmt_count->execute();
$res_count = $stmt_count->get_result();
$total = $res_count->fetch_assoc()['total'] ?? 0;

$response['total'] = $total;

// ===============================
echo json_encode($response);
exit;
