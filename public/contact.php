<?php
session_start();
require_once '../app/config/database.php'; 
include 'components/auth_check.php'; 
include 'components/header_user.php';
?>

<link rel="stylesheet" href="assets/css/contact.css">

<div class="container py-5 contact-page">
    <div class="row justify-content-center">
        <div class="col-lg-10">

            <div class="contact-card fade-up">

                <h2 class="section-title text-center mb-3">Contact Us</h2>
                <p class="section-subtitle text-center mb-5">
                    Kami siap membantu Anda. Silakan hubungi kami melalui formulir berikut atau informasi kontak di bawah
                </p>

                <!-- STATUS -->
                <?php if (isset($_GET['status'])): ?>
                    <?php if ($_GET['status'] == 'success'): ?>
                        <div class="alert alert-success text-center rounded-3 mb-4">
                            Pesan berhasil dikirim!
                        </div>
                    <?php elseif ($_GET['status'] == 'error'): ?>
                        <div class="alert alert-danger text-center rounded-3 mb-4">
                            Semua field wajib diisi.
                        </div>
                    <?php elseif ($_GET['status'] == 'failed'): ?>
                        <div class="alert alert-danger text-center rounded-3 mb-4">
                            Terjadi kesalahan, coba lagi.
                        </div>
                    <?php endif; ?>
                <?php endif; ?>

                <div class="row mt-4">

                    <!-- INFO -->
                    <div class="col-md-5 mb-4">
                        <div class="contact-info-box fade-up">
                            <h5 class="info-title mb-3">Informasi Kontak</h5>
                            <p><strong>Alamat:</strong> Jl. Kemerdekaan No. 25, Jakarta</p>
                            <p><strong>Email:</strong> support@fatimahcollection.com</p>
                            <p><strong>Telepon:</strong> +62 812 3456 7890</p>

                            <hr>

                            <h5 class="info-title mb-3">Jam Operasional</h5>
                            <p>Senin – Jumat: 09.00 – 17.00</p>
                            <p>Sabtu: 09.00 – 14.00</p>
                            <p>Minggu: Tutup</p>
                        </div>
                    </div>

                    <!-- FORM -->
                    <div class="col-md-7">
                        <form method="POST" action="contact_submit.php" class="contact-form fade-up" id="contactForm">

                            <div class="mb-3">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" name="name" class="form-control input-soft" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control input-soft" required>
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Pesan</label>
                                <textarea name="message" rows="5" class="form-control input-soft" required></textarea>
                            </div>

                            <button type="submit" class="contact-btn" id="sendBtn">
                                Kirim Pesan
                            </button>

                        </form>
                    </div>

                </div>

            </div>

        </div>
    </div>
</div>

<!-- ✅ JS DIGABUNG -->
<script>
document.getElementById("contactForm")?.addEventListener("submit", function () {
    const btn = document.getElementById("sendBtn");
    btn.innerText = "Mengirim...";
    btn.style.opacity = "0.8";
    btn.style.transform = "scale(0.97)";
});
</script>

<?php include 'components/footer.php'; ?>
