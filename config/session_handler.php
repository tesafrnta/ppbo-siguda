<?php
// config/session_handler.php
// File ini harus dipanggil SEBELUM apapun di setiap halaman

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Cek apakah user sudah login
function isLoggedIn() {
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
}

// Redirect ke login jika belum login
function requireLogin() {
    if (!isLoggedIn()) {
        // Gunakan relative path, bukan header location langsung
        header("Location: /index.php");
        exit();
    }
}

// Debug: Tampilkan session status (hapus setelah testing)
// echo "<!-- Session Status: " . (isset($_SESSION['user_id']) ? "OK" : "NONE") . " -->";
?>