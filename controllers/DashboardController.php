<?php
// controllers/DashboardController.php

// ⭐ PENTING: Panggil session handler di awal
require_once __DIR__ . '/../config/session_handler.php';

// Cek login
requireLogin();

// Mulai dengan include database & models
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Produk.php';
require_once __DIR__ . '/../models/TransaksiMasuk.php';
require_once __DIR__ . '/../models/TransaksiKeluar.php';
require_once __DIR__ . '/../models/Kategori.php';

$database = new Database();
$db = $database->getConnection();

$produk = new Produk($db);
$kategori = new Kategori($db);
$transaksiMasuk = new TransaksiMasuk($db);
$transaksiKeluar = new TransaksiKeluar($db);

include __DIR__ . '/../views/dashboard.php';
?>