<?php
session_start();
require_once '../app/config/database.php';

// CEK LOGIN
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

$db = new Database();
$conn = $db->conn;

// HEADER
if (isset($_SESSION['users'])) {
    include '../public/components/header_user.php';
} else {
    include '../public/components/header_guest.php';
}

$user_id = $_SESSION['user_id'];

// AMBIL DATA USER
$stmt = $conn->prepare("SELECT id, name, email, profile_photo FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
$stmt->close();

$photo = $user['profile_photo']
    ? "../public/uploads/profile/" . $user['profile_photo']
    : "../public/assets/user.png";
?>

<style>
/* ============================
   STYLING HALAMAN ACCOUNT
   ============================ */

body {
    background: #e8e9eb !important;
}

.fc-title-page {
    font-family: 'Poppins', sans-serif;
    font-size: 32px;
    font-weight: 700;
    color: #5e3d1d;
    letter-spacing: .5px;
}

/* CARD */
.fc-card {
    border-radius: 20px !important;
    background: white;
    padding: 30px;
    box-shadow: 0px 10px 25px rgba(0,0,0,0.07);
    border: none;
}

/* INPUT */
.fc-input {
    height: 48px;
    border-radius: 10px;
    border: 1px solid #ddd;
}
.fc-input:focus {
    border-color: #5e3d1d;
    box-shadow: 0 0 6px rgba(94,61,29,0.4);
}

/* Button */
.fc-btn-save {
    background: #5e3d1d;
    border: none;
    padding: 10px 30px;
    color: white;
    font-weight: 600;
    border-radius: 10px;
    transition: .3s;
}
.fc-btn-save:hover {
    background: #a67c52;
    color: white;
}

/* FOTO PROFIL FRAME */
.fc-photo {
    border-radius: 50%;
    border: 6px solid #fad3d8;
    box-shadow: 0 8px 18px rgba(0,0,0,0.15);
}

</style>

<div class="container my-5">

    

    <div class="row justify-content-center">
        
        <div class="col-lg-8">
            
            <div class="card fc-card">
                <h3 class="fc-title-page text-center mb-4">Management Account</h3>
                <br>
                <div class="text-center mb-4">
                    <img src="<?= $photo ?>"
                         class="fc-photo"
                         width="150" height="150"
                         style="object-fit: cover;">
                </div>

                <!-- FORM -->
                <form action="update_profile.php" method="POST" enctype="multipart/form-data">

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Foto Profil</label>
                        <input type="file" name="profile_photo" class="form-control fc-input" accept="image/*">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama Lengkap</label>
                        <input type="text" name="name"
                               class="form-control fc-input"
                               value="<?= htmlspecialchars($user['name']) ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Email</label>
                        <input type="email" name="email"
                               class="form-control fc-input"
                               value="<?= htmlspecialchars($user['email']) ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Password Baru</label>
                        <input type="password" name="password"
                               class="form-control fc-input"
                               placeholder="Kosongkan jika tidak ingin mengganti password">
                    </div>

                    <div class="text-center">
                        <button type="submit" class="fc-btn-save">
                            Simpan Perubahan
                        </button>
                    </div>

                </form>

            </div>

        </div>
    </div>

</div>


<!-- ============================================ -->
<!-- MODAL POPUP AESTHETIC MODERN -->
<!-- ============================================ -->
<style>
.fc-modal-success .modal-content {
    border-radius: 22px;
    padding: 25px 15px 35px;
    background: white;
    border: none;
    position: relative;
    animation: fadeUp .35s ease-out;
}

@keyframes fadeUp {
    from { transform: translateY(25px); opacity: 0; }
    to   { transform: translateY(0); opacity: 1; }
}

.fc-modal-icon {
    width: 110px;
    height: 110px;
    background: #fad3d8;
    border-radius: 50%;
    border: 4px solid #5e3d1d;
    display: flex;
    justify-content: center;
    align-items: center;
    margin: 15px auto 10px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.15);
}

.fc-modal-icon i {
    font-size: 50px;
    color: #5e3d1d;
}

.fc-modal-title {
    font-size: 26px;
    font-weight: 700;
    color: #5e3d1d;
}

.fc-modal-text {
    font-size: 16px;
    color: #7a604a;
    margin-top: 6px;
}

.fc-modal-btn {
    background: #5e3d1d;
    color: white;
    padding: 10px 30px;
    border-radius: 10px;
    font-weight: 600;
    transition: .3s;
}
.fc-modal-btn:hover {
    background: #a67c52;
    color: white;
}
</style>

<div class="modal fade fc-modal-success" id="successModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content shadow">

      <div class="fc-modal-icon">
        <i class="bi bi-check-lg"></i>
      </div>

      <h4 class="text-center fc-modal-title">Berhasil!</h4>
      <p class="text-center fc-modal-text">Profil Anda berhasil diperbarui.</p>

      <div class="text-center mt-3 mb-2">
        <button type="button" class="fc-modal-btn" data-bs-dismiss="modal">Oke</button>
      </div>

    </div>
  </div>
</div>

<?php if (isset($_GET['updated'])): ?>
<script>
document.addEventListener("DOMContentLoaded", function() {
    new bootstrap.Modal(document.getElementById('successModal')).show();
});
</script>
<?php endif; ?>

<?php include '../public/components/footer.php'; ?>
