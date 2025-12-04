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
        /* ===== BACKGROUND PUTIH + TEKSTUR WARNA #255 ===== */
        body {
            background: #ffffff;
            font-family: 'Poppins', sans-serif;
            background-image:
                radial-gradient(circle at 20% 30%, rgba(0, 85, 85, 0.12) 0%, transparent 45%),
                radial-gradient(circle at 80% 70%, rgba(0, 85, 85, 0.12) 0%, transparent 45%),
                repeating-linear-gradient(
                    45deg,
                    rgba(0, 85, 85, 0.04) 0px,
                    rgba(0, 85, 85, 0.04) 2px,
                    transparent 2px,
                    transparent 6px
                );
            background-attachment: fixed;
            color: #003333;
        }

        /* ===== KARTU GLASS ===== */
        .glass-card {
            background: rgba(255, 255, 255, 0.65);
            border: 1px solid rgba(0, 85, 85, 0.25);
            border-radius: 15px;
            backdrop-filter: blur(7px);
            box-shadow: 0 4px 20px rgba(0, 85, 85, 0.15);
        }

        .page-title {
            color: #005555;
            font-weight: 600;
            text-shadow: 0 0 8px rgba(0, 85, 85, 0.15);
        }

        /* ===== SUMMARY CARD ===== */
        .summary-card {
            background: rgba(255, 255, 255, 0.45);
            border: 1px solid rgba(0, 85, 85, 0.25);
            border-radius: 14px;
            transition: 0.3s ease;
            color: #003333;
        }

        .summary-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 26px rgba(0, 85, 85, 0.35);
        }

        .summary-card i {
            color: #005555 !important;
        }

        /* ===== TABLE ===== */
        table {
            color: #003333 !important;
        }

        thead {
            background: rgba(0, 85, 85, 0.18) !important;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background: rgba(0, 85, 85, 0.05);
        }

        .table-striped tbody tr:nth-of-type(even) {
            background: rgba(0, 85, 85, 0.10);
        }

        /* ===== CARD HEADER ===== */
        .card-header {
            border-bottom: 1px solid rgba(0, 85, 85, 0.25);
            background: rgba(255, 255, 255, 0.30) !important;
            color: #005555 !important;
            font-weight: 600;
        }

        /* ===== BADGE ===== */
        .badge {
            padding: 8px 12px;
            border-radius: 50px;
            font-weight: 600;
        }

        .badge.bg-danger {
            background: #cc2e2e !important;
        }

        .badge.bg-success {
            background: #0f8f6e !important;
        }

        /* ===== LINK ===== */
        a.text-warning {
            color: #005555 !important;
            font-weight: 600;
        }
        a.text-warning:hover {
            color: #003f3f !important;
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
                <p class="text-dark opacity-75">
                    Anda login sebagai <strong><?= ucfirst($_SESSION['role']) ?></strong>
                </p>
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
                        <h4>Rp <?= number_format($total_nilai_stok, 0, ',', '.') ?></h4>
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
                            <?php $i = 0; foreach ($all_transaksi as $row): if ($i++ >= 5) break; ?>
                                <tr>
                                    <td><?= $row['kode_produk'] ?></td>
                                    <td>
                                        <?php if ($row['jenis_transaksi']=="masuk"): ?>
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
