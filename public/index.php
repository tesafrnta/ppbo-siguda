<?php
// public/index.php - PENTING: Tambahkan di PALING ATAS sebelum apapun

// ⭐ PENTING: Include session handler TERLEBIH DAHULU
require_once __DIR__ . '/../config/session_handler.php';
require_once __DIR__ . '/../config/path.php';

// Debug: Tampilkan apa yang sedang terjadi
// echo "<!-- DEBUG: User ID = " . ($_SESSION['user_id'] ?? 'TIDAK ADA') . " -->";

// Jika sudah login, atur return tampilan berdasarkan request
if (isLoggedIn()) {
    // Extract path dari REQUEST_URI
    $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $path = ltrim($path, '/');
    
    // Ambil nama controller (string sebelum ? atau /)
    $controller = explode('?', $path)[0];
    $controller = explode('/', $controller)[0];
    
    // Hapus trailing slashes
    $controller = trim($controller);
    
    // Debug
    // echo "<!-- DEBUG: Controller = " . $controller . " -->";

    // Cek apakah file controller ada
    $controller_file = __DIR__ . '/../controllers/' . ucfirst($controller) . 'Controller.php';
    
    if (!empty($controller) && file_exists($controller_file)) {
        require_once $controller_file;
        exit();
    }

    // Default ke Dashboard jika controller tidak ditemukan
    require_once __DIR__ . '/../controllers/DashboardController.php';
    exit();
}

// ========================================
// JIKA BELUM LOGIN - Proses Login
// ========================================

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require_once __DIR__ . '/../config/database.php';
    require_once __DIR__ . '/../models/Admin.php';

    $database = new Database();
    $db = $database->getConnection();
    
    if (!$db) {
        $error = "Gagal koneksi database. Periksa konfigurasi .env";
    } else {
        $admin = new Admin($db);
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        if ($admin->login($username, $password)) {
            // Set session
            $_SESSION['user_id'] = $admin->getId();
            $_SESSION['username'] = $admin->getUsername();
            $_SESSION['nama_lengkap'] = $admin->getNamaLengkap();
            $_SESSION['role'] = $admin->getRole();

            // Simpan session ke storage
            session_write_close();

            // Redirect ke dashboard dengan URL lengkap
            header("Location: {$base_url}/Dashboard");
            exit();
        } else {
            $error = "Username atau password salah!";
        }
    }
}

// Tampilkan form login
include_once __DIR__ . '/../views/login.php';
?>