<?php
include("../../app/config/database.php");
include "../layout.php";

$db = new Database();
$conn = $db->conn;

if (!isset($_GET['id'])) { die("ID tidak ditemukan."); }

$id = intval($_GET['id']);
$product = $conn->query("SELECT * FROM products WHERE id=$id")->fetch_assoc();

if (!$product) { die("Produk tidak ditemukan."); }

if ($_SERVER['REQUEST_METHOD']==='POST') {
    $name = $_POST['name'];
    $slug = strtolower(str_replace(" ", "-", $name));
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $desc = $_POST['description'];

    $image = $product['image'];

    if (!empty($_FILES['image']['name'])) {
        $image = time()."_".$_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], "../../uploads/products/" . $image);
    }

    $stmt = $conn->prepare("UPDATE products 
        SET name=?, slug=?, description=?, price=?, stock=?, image=? 
        WHERE id=?");
    $stmt->bind_param("sssissi", $name, $slug, $desc, $price, $stock, $image, $id);
    $stmt->execute();

    header("Location: index.php");
    exit;
}
?>

<style>
/* =======================================
   WRAPPER DASHBOARD
======================================= */
.content {
    padding: 0 20px;
}

.dashboard-container {
    padding: 30px;
    background: #faf7f3;
    min-height: 100vh;
    border-radius: 16px;
}

/* =======================================
   PAGE TITLE
======================================= */
.page-title {
    font-size: 28px;
    font-weight: 700;
    margin-bottom: 25px;
    color: #543824;
    letter-spacing: 0.4px;
}

/* =======================================
   FORM CARD (MATCH DASHBOARD STYLE)
======================================= */
.form-card {
    background: #fff;
    padding: 28px;
    border-radius: 18px;
    border: 1px solid #e6d5c6;
    max-width: 600px;
    box-shadow: 0 8px 24px rgba(179,139,103,0.18);
}

.form-card label {
    font-weight: 600;
    margin-bottom: 5px;
    display: block;
    color: #543824;
}

.form-card input,
.form-card textarea {
    width: 100%;
    padding: 13px;
    border-radius: 12px;
    border: 1px solid #cdb7a6;
    margin-bottom: 18px;
    font-size: 15px;
}

/* SUBMIT BUTTON */
.btn-submit {
    background: #5e3d1d;
    color: white;
    font-weight: 600;
    padding: 13px;
    border-radius: 10px;
    width: 100%;
    border: none;
    cursor: pointer;
    font-size: 16px;
    transition: 0.2s;
}

.btn-submit:hover {
    background: #744c28;
}
</style>

<div class="content">
    <div class="dashboard-container">

        <h2 class="page-title">Edit Produk</h2>

        <div class="form-card">
            <form method="POST" enctype="multipart/form-data">

                <label>Nama Produk</label>
                <input type="text" name="name" value="<?= $product['name'] ?>" required>

                <label>Harga</label>
                <input type="number" name="price" value="<?= $product['price'] ?>" required>

                <label>Stok</label>
                <input type="number" name="stock" value="<?= $product['stock'] ?>" required>

                <label>Deskripsi</label>
                <textarea name="description" rows="5"><?= $product['description'] ?></textarea>

                <label>Gambar Produk</label>
                <img src="../../uploads/products/<?= $product['image'] ?>" width="120" 
                     style="border-radius:10px; margin-bottom:10px;">
                <input type="file" name="image">

                <button class="btn-submit" type="submit">Update Produk</button>
            </form>
        </div>

    </div>
</div>

