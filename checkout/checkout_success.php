<?php
$order_id = intval($_GET['order_id'] ?? 0);
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Pesanan Berhasil</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
      body {
          background: #f7f7f7;
          font-family: 'Poppins', sans-serif;
      }

      .success-card {
          max-width: 520px;
          margin: 70px auto;
          background: #ffffff;
          border-radius: 20px;
          padding: 40px;
          box-shadow: 0 4px 20px rgba(0,0,0,0.12);
          animation: fadeIn 0.6s ease;
      }

      @keyframes fadeIn {
          from { opacity: 0; transform: translateY(20px); }
          to { opacity: 1; transform: translateY(0); }
      }

      .success-icon {
          width: 130px;
          margin-bottom: 15px;
          filter: drop-shadow(0 2px 4px rgba(0,0,0,0.2));
      }

      .btn-premium {
          background: #000;
          color: #fff;
          border-radius: 30px;
          padding: 12px 30px;
          font-weight: 600;
          transition: 0.3s;
      }

      .btn-premium:hover {
          background: #333;
          color: #ffd6ef; /* gold accent */
      }

      .order-id {
          font-size: 20px;
          font-weight: 700;
          color: #000;
      }

      .text-muted {
          color: #777 !important;
      }
  </style>
</head>
<body>

<div class="success-card text-center">
    <img src="../public/assets/images/success-check.png" class="success-icon" alt="Success">

    <h2 class="fw-bold">Pesanan Berhasil Dibuat!</h2>
    <p class="text-muted mt-2">Terima kasih telah berbelanja di Fatimah Collection.</p>

    <p class="order-id mt-1">Order ID: #<?= htmlspecialchars($order_id) ?></p>

    <a href="../public/shop.php" class="btn btn-premium mt-4">Kembali Belanja</a>
</div>

</body>
</html>
