<?php
include("../../app/config/database.php");

if ($_SERVER['REQUEST_METHOD']==='POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $desc = $_POST['description'];

    $image = null;
    if (!empty($_FILES['image']['name'])) {
    $image = time()."_".$_FILES['image']['name'];

    $targetDir = __DIR__ . "/../../public/assets/images/";

    
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    move_uploaded_file($_FILES['image']['tmp_name'], $targetDir . $image);
    }


   $stmt = $db->prepare("INSERT INTO products 
   (name, description, price, stock, image) 
   VALUES (?,?,?,?,?)");

    if(!$stmt){
      die("SQL Error: " . $db->error);
    }

    $stmt->bind_param("ssiis", $name, $desc, $price, $stock, $image);

    $stmt->execute();
    header("Location: index.php");
}
?>

<style>
.form-card {
    max-width: 600px;
    background: white;
    padding: 25px;
    border-radius: 20px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.15);
}

.form-card label {
    font-weight: 600;
    color: #543824;
    margin-top: 12px;
}

.form-card input, .form-card textarea {
    width: 100%;
    padding: 12px;
    border: 1px solid #ddd;
    border-radius: 12px;
    margin-top: 6px;
}

.btn-submit {
    margin-top: 20px;
    width: 100%;
    background: #543824;
    color: white;
    padding: 12px;
    border-radius: 12px;
    font-weight: 700;
}
.btn-submit:hover { background: #6a4a32; }
</style>

<h2 class="page-title">Tambah Produk Baru</h2>

<div class="form-card">
<form method="POST" enctype="multipart/form-data">

    <label>Nama Produk</label>
    <input type="text" name="name" required>

    <label>Harga</label>
    <input type="number" name="price" required>

    <label>Stok</label>
    <input type="number" name="stock" required>

    <label>Deskripsi</label>
    <textarea name="description" rows="5"></textarea>

    <label>Gambar Produk</label>
    <input type="file" name="image">

    <button class="btn-submit">Simpan Produk</button>
</form>
</div>
