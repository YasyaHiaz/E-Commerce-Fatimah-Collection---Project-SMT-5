<?php
include("../app/config/database.php");

if(isset($_POST['submit'])){

    $title = $_POST['title'];
    $slug = strtolower(str_replace(" ", "-", $title));
    $content = $_POST['content'];

    // Upload thumbnail
    $thumbnail = "";
    if(!empty($_FILES['thumbnail']['name'])){
        $thumbnail = time() . "_" . $_FILES['thumbnail']['name'];
        move_uploaded_file($_FILES['thumbnail']['tmp_name'], "upload/" . $thumbnail);
    }

    $query = "INSERT INTO blog(title, slug, content, thumbnail) 
              VALUES('$title', '$slug', '$content', '$thumbnail')";
    $db->query($query);

    header("Location: index.php");
}
?>
<style>
    .form-blog {
    background: #fff;
    padding: 25px;
    border-radius: 14px;
    box-shadow: 0 6px 18px rgba(0,0,0,0.05);
    margin-top: 20px;
}

.form-blog label {
    font-weight: 600;
    margin-top: 15px;
    display: block;
    color: #5e3d1d;
}

.form-blog input, .form-blog textarea {
    width: 100%;
    padding: 12px;
    border-radius: 10px;
    border: 1px solid #d8c4ad;
    margin-top: 5px;
    font-size: 14px;
    background: #fffdfa;
}

</style>
<h2 class="title">Tambah Artikel</h2>

<form method="POST" enctype="multipart/form-data" class="form-blog">

    <label>Judul Artikel</label>
    <input type="text" name="title" required>

    <label>Thumbnail</label>
    <input type="file" name="thumbnail">

    <label>Konten</label>
    <textarea name="content" rows="8" required></textarea>

    <button name="submit" class="btn-add">Publish Artikel</button>
</form>
