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
    body {
        background: #000;
        font-family: 'Poppins', sans-serif;
        background-image: url('https://i.imgur.com/Yl5xQ0i.png');
        background-size: cover;
        background-attachment: fixed;
        background-repeat: no-repeat;
        color: #fff;
    }

    .glass-card {
        background: rgba(255, 255, 255, 0.07);
        border: 1px solid rgba(255, 215, 0, 0.35);
        border-radius: 15px;
        backdrop-filter: blur(7px);
        -webkit-backdrop-filter: blur(7px);
        box-shadow: 0 4px 20px rgba(255, 215, 0, 0.18);
    }

    .page-title {
        color: #f5d17a;
        font-weight: 600;
        letter-spacing: 1px;
        text-shadow: 0 0 12px rgba(255, 215, 0, 0.35);
    }

    .summary-card {
        background: rgba(20, 20, 20, 0.55);
        border: 1px solid rgba(255, 215, 0, 0.35);
        color: #f7e7b8;
        border-radius: 14px;
        transition: 0.3s ease;
        backdrop-filter: blur(3px);
    }

    .summary-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 28px rgba(255, 215, 0, 0.4);
    }

    .summary-card i {
        color: #e6c45c !important;
    }

    table {
        color: #fff !important;
    }

    thead {
        background: rgba(255, 215, 0, 0.20) !important;
    }

    .table-striped tbody tr:nth-of-type(odd) {
        background: rgba(255,255,255,0.06);
    }

    .table-striped tbody tr:nth-of-type(even) {
        background: rgba(255,255,255,0.12);
    }

    .card-header {
        border-bottom: 1px solid rgba(255, 215, 0, 0.35);
        background: rgba(255, 255, 255, 0.08) !important;
        color: #f7d67a !important;
    }

    .badge {
        padding: 8px 12px;
        font-size: 0.8rem;
        border-radius: 50px;
        font-weight: 600;
    }
</style>

</head>
<body>

<?php include __DIR__ . '/layouts/navbar.php'; ?>

<div class="container">

    <!-- Welcome -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="glass-card p-4">
                <h3 class="page-title mb-1">Selamat Datang, <?= htmlspecialchars($_SESSION['nama_lengkap']) ?>!</h3>
                <p class="text-light opacity-75">Anda login sebagai <strong><?= ucfirst($_SESSION['role']) ?></strong></p>
            </div>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="row mb-4">

        <div class="col-md-3 mb-3">
            <div class="summary-card p-3 h-100 shadow">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6>Total Produk</h6>
                        <h2><?= $total_produk ?></h2>
                    </div>
                    <i class="bi bi-box-seam display-4 opacity-75"></i>
                </div>
                <a href="<?= $base_url ?>/Produk" class="text-warning small text-decoration-none">Lihat Detail →</a>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="summary-card p-3 h-100 shadow">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6>Total Kategori</h6>
                        <h2><?= $total_kategori ?></h2>
                    </div>
                    <i class="bi bi-tags display-4 opacity-75"></i>
                </div>
                <a href="<?= $base_url ?>/Kategori" class="text-warning small text-decoration-none">Lihat Detail →</a>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="summary-card p-3 h-100 shadow">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6>Total Transaksi</h6>
                        <h2><?= $total_transaksi ?></h2>
                    </div>
                    <i class="bi bi-arrow-left-right display-4 opacity-75"></i>
                </div>
                <a href="<?= $base_url ?>/Transaksi" class="text-warning small text-decoration-none">Lihat Detail →</a>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="summary-card p-3 h-100 shadow">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6>Nilai Aset Stok</h6>
                        <h4>Rp <?= number_format($total_nilai_stok,0,',','.') ?></h4>
                    </div>
                    <i class="bi bi-cash-coin display-4 opacity-75"></i>
                </div>
            </div>
        </div>

    </div>

    <!-- Stok Menipis & Transaksi -->
    <div class="row">

        <div class="col-md-6 mb-4">
            <div class="glass-card p-0">
                <div class="card-header">
                    <h5><i class="bi bi-exclamation-triangle"></i> Stok Menipis (&lt;10)</h5>
                </div>
                <div class="p-0 table-responsive">
                    <table class="table table-striped mb-0">
                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Produk</th>
                                <th class="text-center">Sisa</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(count($low_stock_data)): ?>
                                <?php foreach($low_stock_data as $row): ?>
                                <tr>
                                    <td><?= $row['kode_produk'] ?></td>
                                    <td><?= $row['nama_produk'] ?></td>
                                    <td class="text-center">
                                        <span class="badge bg-danger"><?= $row['stok'] ?></span>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr><td colspan="3" class="text-center py-3 text-muted">Tidak ada stok menipis</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="glass-card p-0">
                <div class="card-header">
                    <h5><i class="bi bi-clock-history"></i> 5 Transaksi Terakhir</h5>
                </div>
                <div class="p-0 table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Jenis</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i=0; foreach($all_transaksi as $row): if($i++>=5) break; ?>
                            <tr>
                                <td><?= $row['kode_produk'] ?></td>
                                <td>
                                    <?php if($row['jenis_transaksi']=="masuk"): ?>
                                        <span class="badge bg-success">Masuk</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger">Keluar</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= date('d/m/Y', strtotime($row['tanggal'])) ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
