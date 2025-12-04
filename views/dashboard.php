<?php

// Hitung total data
$total_produk = $produk->readAll()->rowCount();
$total_kategori = $kategori->readAll()->rowCount();

// Ambil semua transaksi
$data_masuk = $transaksiMasuk->readAll()->fetchAll(PDO::FETCH_ASSOC);
$data_keluar = $transaksiKeluar->readAll()->fetchAll(PDO::FETCH_ASSOC);

// Gabungkan semua transaksi untuk dashboard
$all_transaksi = array_merge($data_masuk, $data_keluar);

// Urutkan berdasarkan tanggal DESC
usort($all_transaksi, function($a, $b) {
    return strtotime($b['tanggal']) - strtotime($a['tanggal']);
});

$total_transaksi = count($all_transaksi);

// Hitung total nilai stok
$stmt_nilai = $produk->readAll();
$total_nilai_stok = 0;
while($row = $stmt_nilai->fetch(PDO::FETCH_ASSOC)) {
    $harga_hitung = isset($row['harga_beli']) && $row['harga_beli'] > 0 ? $row['harga_beli'] : ($row['harga'] ?? 0);
    $total_nilai_stok += ($row['stok'] * $harga_hitung);
}

// Ambil stok menipis (<10)
$stmt_low = $produk->getLowStock(10);
$low_stock_data = $stmt_low ? $stmt_low->fetchAll(PDO::FETCH_ASSOC) : [];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - SIGUDA PPBO</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

<style>
    /* =======================
       BACKGROUND HITAM EMAS
    ======================== */
    body {
        background: 
            linear-gradient(135deg, rgba(20,20,20,0.95), rgba(0,0,0,0.85)),
            url('https://www.transparenttextures.com/patterns/gold-scale.png');
        background-size: cover;
        background-attachment: fixed;
        color: #f2f2f2;
    }

    /* NAVBAR - opsional, jika mau elegan */
    .navbar {
        background: rgba(0, 0, 0, 0.3) !important;
        backdrop-filter: blur(5px);
        border-bottom: 1px solid rgba(255, 215, 0, 0.4);
    }
    .navbar a { color: gold !important; }

    /* =======================
       CARD TRANSPARAN EMAS
    ======================== */
    .card {
        background: rgba(0, 0, 0, 0.3) !important;
        backdrop-filter: blur(4px);
        border: 1px solid rgba(255, 215, 0, 0.4) !important;
        color: #f2f2f2 !important;
    }

    .card-header {
        background: rgba(0,0,0,0.45) !important;
        border-bottom: 1px solid rgba(255, 215, 0, 0.3);
        color: gold !important;
    }

    /* =======================
       SUMMARY CARD KHUSUS (EMAS)
    ======================== */
    .card-summary {
        background: rgba(0, 0, 0, 0.45) !important;
        border: 1px solid gold !important;
        color: gold !important;
        backdrop-filter: blur(4px);
    }

    .card-summary .card-footer {
        background: rgba(0, 0, 0, 0.3) !important;
        border-top: 1px solid rgba(255, 215, 0, 0.3) !important;
    }

    .card-summary i {
        color: gold !important;
        opacity: 0.7;
    }

    /* =======================
       TABEL HITAM-EMAS
    ======================== */
    table {
        color: #fff !important;
    }

    thead {
        background: rgba(255, 215, 0, 0.25) !important;
        color: gold !important;
    }

    .table-striped tbody tr:nth-of-type(odd) {
        background: rgba(255, 255, 255, 0.05) !important;
    }

    .table-hover tbody tr:hover {
        background: rgba(255, 215, 0, 0.15) !important;
    }

    /* BADGE */
    .badge.bg-danger { background-color: #ff5252 !important; }
    .badge.bg-success { background-color: #00c853 !important; }

</style>

</head>
<body>

<?php include __DIR__ . '/layouts/navbar.php'; ?>

<div class="container mt-4">

    <!-- Welcome Card -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h4 class="card-title">Selamat Datang, <?= htmlspecialchars($_SESSION['nama_lengkap']); ?>!</h4>
                    <p class="text-muted mb-0">Anda login sebagai <strong><?= ucfirst($_SESSION['role']); ?></strong></p>
                </div>
            </div>
        </div>
    </div>

    <!-- SUMMARY CARDS -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card card-summary mb-3 h-100 shadow-sm">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h6>Total Produk</h6>
                        <h2><?= $total_produk; ?></h2>
                    </div>
                    <i class="bi bi-box-seam display-4"></i>
                </div>
                <div class="card-footer">
                    <a href="<?= $base_url ?>/Produk" class="text-decoration-none small">Lihat Detail <i class="bi bi-arrow-right"></i></a>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card card-summary mb-3 h-100 shadow-sm">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h6>Total Kategori</h6>
                        <h2><?= $total_kategori; ?></h2>
                    </div>
                    <i class="bi bi-tags display-4"></i>
                </div>
                <div class="card-footer">
                    <a href="<?= $base_url ?>/Kategori" class="text-decoration-none small">Lihat Detail <i class="bi bi-arrow-right"></i></a>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card card-summary mb-3 h-100 shadow-sm">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h6>Total Transaksi</h6>
                        <h2><?= $total_transaksi; ?></h2>
                    </div>
                    <i class="bi bi-arrow-left-right display-4"></i>
                </div>
                <div class="card-footer">
                    <a href="<?= $base_url ?>/Transaksi" class="text-decoration-none small">Lihat Detail <i class="bi bi-arrow-right"></i></a>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card card-summary mb-3 h-100 shadow-sm">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h6>Nilai Aset Stok</h6>
                        <h4>Rp <?= number_format($total_nilai_stok, 0, ',', '.'); ?></h4>
                    </div>
                    <i class="bi bi-cash-coin display-4"></i>
                </div>
                <div class="card-footer">
                    <small>Estimasi nilai modal</small>
                </div>
            </div>
        </div>
    </div>

    <!-- CONTENT ROW -->
    <div class="row">

        <!-- STOK MENIPIS -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header">
                    <h5><i class="bi bi-exclamation-triangle"></i> Stok Menipis (&lt; 10)</h5>
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Produk</th>
                                <th class="text-center">Sisa Stok</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(count($low_stock_data) > 0): ?>
                                <?php foreach($low_stock_data as $row): ?>
                                <tr>
                                    <td><?= htmlspecialchars($row['kode_produk'] ?? '-'); ?></td>
                                    <td><?= htmlspecialchars($row['nama_produk']); ?></td>
                                    <td class="text-center">
                                        <span class="badge bg-danger rounded-pill"><?= $row['stok']; ?></span>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                            <tr><td colspan="3" class="text-center text-muted py-3">Tidak ada stok menipis</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- 5 TRANSAKSI TERAKHIR -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header">
                    <h5><i class="bi bi-clock-history"></i> 5 Transaksi Terakhir</h5>
                </div>
                <div class="card-body p-0">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Jenis</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $count = 0; ?>
                            <?php if(count($all_transaksi) > 0): ?>
                                <?php foreach($all_transaksi as $row): ?>
                                    <?php if($count >= 5) break; $count++; ?>
                                    <tr>
                                        <td><?= htmlspecialchars($row['kode_produk'] ?? $row['id_transaksi']); ?></td>
                                        <td>
                                            <?php if($row['jenis_transaksi'] == 'masuk'): ?>
                                                <span class="badge bg-success"><i class="bi bi-arrow-down"></i> Masuk</span>
                                            <?php else: ?>
                                                <span class="badge bg-danger"><i class="bi bi-arrow-up"></i> Keluar</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?= date('d/m/Y', strtotime($row['tanggal'])); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                            <tr><td colspan="3" class="text-center text-muted py-3">Belum ada transaksi</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div><!-- END ROW -->

</div><!-- END CONTAINER -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

