<?php 
include '../layout.php';
include '../../app/config/database.php';

$db = new Database();
$conn = $db->conn;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name  = $_POST['name'];
    $email = $_POST['email'];
    $pass  = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $pass);
    $stmt->execute();

    header("Location: index.php");
    exit;
}
?>

<style>
/* =======================================
   PAGE WRAPPER SESUAI DASHBOARD
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
   FORM CARD (MATCH DASHBOARD)
======================================= */
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
    color: #543824;
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
    background: #543824;
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

.btn-add:hover {
    background: #735039;
}
</style>

<div class="content">
    <div class="dashboard-container">

        <h2 class="page-title">Tambah User</h2>

        <div class="card-form">
            <form method="POST">

                <label>Nama Lengkap</label>
                <input type="text" name="name" required>

                <label>Email</label>
                <input type="email" name="email" required>

                <label>Password</label>
                <input type="password" name="password" required>

                <button class="btn-add" type="submit">Simpan</button>
            </form>
        </div>

    </div>
</div>

<?php include '../footer.php'; ?>
