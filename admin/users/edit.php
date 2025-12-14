<?php 
include '../layout.php';
include '../../app/config/database.php';

$db = new Database();
$conn = $db->conn;

$id = $_GET['id'];
$user = $conn->query("SELECT * FROM users WHERE id = $id")->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name  = $_POST['name'];
    $email = $_POST['email'];

    if (!empty($_POST['password'])) {
        $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $conn->query("UPDATE users SET name='$name', email='$email', password='$pass' WHERE id=$id");
    } else {
        $conn->query("UPDATE users SET name='$name', email='$email' WHERE id=$id");
    }

    header("Location: index.php");
    exit;
}
?>

<style>
/* =============================
    DASHBOARD GLOBAL STYLE
============================= */
.content {
    padding: 0 20px;
}

.dashboard-container {
    padding: 30px;
    background: #faf7f3;
    min-height: 100vh;
    border-radius: 16px;
}

/* =============================
    PAGE TITLE
============================= */
.page-title {
    font-size: 28px;
    font-weight: 700;
    margin-bottom: 25px;
    color: #543824;
    letter-spacing: 0.4px;
}

/* =============================
    FORM STYLE (DASHBOARD MATCH)
============================= */
.card-form {
    background: #fff;
    padding: 28px;
    border-radius: 18px;
    border: 1px solid #e6d5c6;
    max-width: 500px;
    box-shadow: 0 8px 24px rgba(179,139,103,0.18);
}

.card-form label {
    font-weight: 600;
    margin-bottom: 6px;
    display: block;
    color: #5a463f;
}

.card-form input {
    width: 100%;
    padding: 13px;
    border-radius: 12px;
    border: 1px solid #cdb7a6;
    margin-bottom: 18px;
    font-size: 15px;
}

/* BUTTON */
.btn-add {
    background: #5e3d1d;
    color: #fff;
    font-size: 15px;
    padding: 14px;
    border-radius: 10px;
    border: none;
    cursor: pointer;
    font-weight: 600;
    width: 100%;
    transition: 0.2s;
}

.btn-add:hover {
    background: #744c28;
}

.btn-back {
    display: inline-block;
    margin-top: 18px;
    color: #5e3d1d;
    font-weight: 600;
    text-decoration: none;
}

.btn-back:hover {
    text-decoration: underline;
}
</style>

<div class="content">
    <div class="dashboard-container">

        <h2 class="page-title">Edit User</h2>

        <div class="card-form">
            <form method="POST">
                <label>Nama Lengkap</label>
                <input type="text" name="name" required value="<?= $user['name']; ?>">

                <label>Email</label>
                <input type="email" name="email" required value="<?= $user['email']; ?>">

                <label>Password (opsional)</label>
                <input type="password" name="password" placeholder="Kosongkan jika tidak diganti">

                <button class="btn-add" type="submit">Update User</button>
            </form>

            <a href="index.php" class="btn-back">← Kembali</a>
        </div>

    </div>
</div>

<?php include '../footer.php'; ?>
