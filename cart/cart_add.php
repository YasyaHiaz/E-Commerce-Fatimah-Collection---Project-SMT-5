<?php
session_start();
header('Content-Type: application/json');

require_once $_SERVER['DOCUMENT_ROOT'] . "/fatimah-collection-clean1/app/config/database.php";
$db = new Database();
$conn = $db->conn;

// Ambil user_id dari session
$user_id = null;

if (isset($_SESSION['user']['id'])) {
    $user_id = (int) $_SESSION['user']['id'];
} elseif (isset($_SESSION['users']['id'])) {
    $user_id = (int) $_SESSION['users']['id'];
} elseif (isset($_SESSION['user_id'])) {
    $user_id = (int) $_SESSION['user_id'];
}

// Jika belum login
$user_id = $_SESSION['user_id'] ?? null;

if (!$user_id) {
    echo json_encode([
        "status" => "not_login",
        "message" => "Silakan login terlebih dahulu!"
    ]);
    exit;
}


// Ambil POST (WAJIB ADA!)
$product_id = isset($_POST['product_id']) ? (int) $_POST['product_id'] : 0;
$qty = isset($_POST['qty']) ? (int) $_POST['qty'] : 1;

// Validasi
if ($product_id <= 0) {
    echo json_encode([
        "status" => "error",
        "message" => "Produk tidak valid!"
    ]);
    exit;
}

// Ambil nama produk
$stmt_prod = $conn->prepare("SELECT name FROM products WHERE id = ? LIMIT 1");
$stmt_prod->bind_param("i", $product_id);
$stmt_prod->execute();
$res_prod = $stmt_prod->get_result();
$product = $res_prod->fetch_assoc();
$product_name = $product['name'] ?? 'Produk';

// Cek apakah produk sudah ada di cart
$stmt = $conn->prepare("SELECT * FROM cart WHERE user_id = ? AND product_id = ?");
$stmt->bind_param("ii", $user_id, $product_id);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows > 0) {
    // update qty
    $cartItem = $res->fetch_assoc();
    $new_qty = $cartItem['qty'] + $qty;

    $stmt_up = $conn->prepare("UPDATE cart SET qty = ? WHERE id = ?");
    $stmt_up->bind_param("ii", $new_qty, $cartItem['id']);
    $stmt_up->execute();
} else {
    // insert baru
    $stmt_in = $conn->prepare("INSERT INTO cart (user_id, product_id, qty) VALUES (?, ?, ?)");
    $stmt_in->bind_param("iii", $user_id, $product_id, $qty);
    $stmt_in->execute();
}

// Hitung total item
$stmt_count = $conn->prepare("SELECT SUM(qty) AS total FROM cart WHERE user_id = ?");
$stmt_count->bind_param("i", $user_id);
$stmt_count->execute();
$res_count = $stmt_count->get_result();
$total_items = $res_count->fetch_assoc()['total'] ?? 0;

// response success
echo json_encode([
    "status" => "success",
    "message" => "Berhasil ditambahkan ke keranjang!",
    "product_name" => $product_name,
    "total_items" => $total_items
]);
exit;
