<?php
include("../../app/config/database.php");
include '../layout.php';

// Ambil data penjualan
$query = "SELECT id, total_price FROM orders ORDER BY id ASC";
$result = $db->query($query);

$labels = [];
$sales = [];

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $labels[] = "Order #" . $row['id'];
        $sales[] = (float)$row['total_price'];
    }
}
?>

<style>
/* ============================
   CONTENT WRAPPER
============================ */
.chart-content {
    padding: 35px 40px;
    background: #faf7f3;
    min-height: 100vh;
    border-radius: 16px;
}

/* ============================
   TITLE
============================ */
.page-title {
    font-size: 24px;
    font-weight: 700;
    color: #543824;
    margin-bottom: 22px;
    letter-spacing: 0.3px;
}

/* ============================
   CHART CARD
============================ */
.chart-card {
    background: white;
    padding: 25px;
    border-radius: 16px;
    box-shadow: 0 8px 24px rgba(0,0,0,0.12);
    border: 1px solid #ecd9c9;
    max-width: 100%;
    width: 100%;
}

.chart-card canvas {
    width: 100% !important;
    height: 420px !important;
}

/* MOBILE FIX */
@media (max-width: 540px) {
    .chart-content {
        padding: 25px 20px;
    }
    .page-title {
        font-size: 20px;
    }
}
</style>

<div class="content">
<div class="chart-content">

    <h2 class="page-title">📊 Grafik Penjualan Keseluruhan</h2>

    <div class="chart-card">
        <canvas id="salesChart"></canvas>
    </div>

</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const ctx = document.getElementById('salesChart').getContext('2d');

new Chart(ctx, {
    type: 'bar',
    data: {
        labels: <?= json_encode($labels) ?>,
        datasets: [{
            label: 'Total Penjualan (Rp)',
            data: <?= json_encode($sales) ?>,
            backgroundColor: 'rgba(110, 76, 47, 0.55)',       // coklat elegan
            borderColor: 'rgba(110, 76, 47, 1)',
            borderWidth: 2,
            borderRadius: 8
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: true, position: 'top' },
            tooltip: { mode: 'index', intersect: false }
        },
        scales: {
            x: {
                ticks: { color: '#543824' },
                title: { display: true, text: 'Order Number', color: '#543824' }
            },
            y: {
                ticks: { color: '#543824' },
                title: { display: true, text: 'Total Penjualan (Rp)', color: '#543824' },
                beginAtZero: true
            }
        }
    }
});
</script>

