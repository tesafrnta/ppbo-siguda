<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SIGUDA PPBO</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

    <style>
        /* ===== BACKGROUND PUTIH + TEKSTRUR BIRU #255 ===== */
        body {
            height: 100vh;
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background: #ffffff;
            background-image:
                radial-gradient(circle at 20% 30%, rgba(0, 85, 85, 0.12) 0%, transparent 45%),
                radial-gradient(circle at 80% 70%, rgba(0, 85, 85, 0.12) 0%, transparent 45%),
                repeating-linear-gradient(
                    45deg,
                    rgba(0, 85, 85, 0.05) 0px,
                    rgba(0, 85, 85, 0.05) 2px,
                    transparent 2px,
                    transparent 6px
                );
            display: flex;
            justify-content: center;
            align-items: center;
            color: #003333;
        }

        /* ===== CARD TRANSPARAN ===== */
        .login-card {
            width: 400px;
            border-radius: 18px;
            padding: 30px;
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(8px);
            box-shadow: 0 0 20px rgba(0, 85, 85, 0.25);
            border: 1px solid rgba(0, 85, 85, 0.25);
            animation: fadeIn 0.8s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* ===== TEKS ===== */
        .login-card h3 {
            color: #005555;
            font-weight: 700;
        }

        .login-card p,
        .login-card label,
        small {
            color: #003333;
        }

        /* ===== INPUT ===== */
        .form-control {
            background: rgba(0, 85, 85, 0.05) !important;
            border: 1px solid rgba(0, 85, 85, 0.35) !important;
            color: #003333 !important;
        }

        .form-control:focus {
            box-shadow: 0 0 10px rgba(0, 85, 85, 0.5);
            border-color: #005555 !important;
        }

        .input-group-text {
            background: rgba(0, 85, 85, 0.2) !important;
            border: 1px solid rgba(0, 85, 85, 0.35) !important;
            color: #003333;
        }

        ::placeholder {
            color: #666 !important;
        }

        /* ===== BUTTON ===== */
        .btn-main {
            background: #005555;
            border: none;
            color: #fff;
            font-weight: bold;
            transition: 0.3s;
        }

        .btn-main:hover {
            background: #003f3f;
        }

        /* ===== ICON ===== */
        .login-icon {
            color: #005555;
            font-size: 55px;
        }
    </style>
</head>

<body>

    <div class="login-card">
        <div class="text-center mb-3">
            <i class="bi bi-box-seam-fill login-icon"></i>
            <h3 class="fw-bold mt-2">SIGUDA</h3>
            <p>Sistem Gudang Fashion</p>
        </div>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger text-center py-2">
                <i class="bi bi-exclamation-circle-fill"></i> <?= $error; ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Username</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                    <input type="text" name="username" class="form-control" placeholder="Masukkan username" required>
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label">Password</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-key"></i></span>
                    <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
                </div>
            </div>

            <button type="submit" class="btn btn-main w-100 py-2">MASUK SISTEM</button>
        </form>

        <div class="text-center mt-3">
            <small>Gunakan akun: <b>admin</b> / <b>admin123</b></small>
        </div>
    </div>

</body>

</html>
