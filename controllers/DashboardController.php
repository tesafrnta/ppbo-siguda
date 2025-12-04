<?php
namespace Controllers;

use Config\Database;
use Models\Produk;
use Models\TransaksiMasuk;
use Models\TransaksiKeluar;
use Models\Kategori;

$database = new Database();
$db = $database->getConnection();

$produk = new Produk($db);
$kategori = new Kategori($db);
$transaksiMasuk = new TransaksiMasuk($db);
$transaksiKeluar = new TransaksiKeluar($db);

include __DIR__ . '/../views/dashboard.php';