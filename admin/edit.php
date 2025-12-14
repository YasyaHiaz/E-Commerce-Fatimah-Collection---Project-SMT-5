<?php
include("../../config/database.php");

$id = $_GET['id'];
$post = $db->query("SELECT * FROM blog WHERE id=$id")->fetch_assoc();

if(isset($_POST['submit'])){

    $title = $_POST['title'];
    $slug = strtolower(str_replace(" ", "-", $title));
    $content = $_POST['content'];

    $thumbnail = $post['thumbnail'];

    // Jika user upload gambar baru
    if(!empty($_FILES['thumbnail']['name'])){
        $thumbnail = time() . "_" . $_FILES['thumbnail']['name'];
        move_uploaded_file($_FILES['thumbnail']['tmp_name'], "upload/" . $thumbnail);
    }

    $db->query("UPDATE blog SET 
                title='$title',
                slug='$slug',
                content='$content',
                thumbnail='$thumbnail'
                WHERE id=$id");

    header("Location: index.php");
}
?>

<h2 class="title">Edit Artikel</h2>

<form method="POST" enctype="multipart/form-data" class="form-blog">

    <label>Judul Artikel</label>
    <input type="text" name="title" value="<?= $post['title'] ?>">

    <label>Thumbnail</label>
    <img src="upload/<?= $post['thumbnail'] ?>" width="150">
    <input type="file" name="thumbnail">

    <label>Konten</label>
    <textarea name="content" rows="8"><?= $post['content'] ?></textarea>

    <button name="submit" class="btn-add">Update Artikel</button>
</form>
