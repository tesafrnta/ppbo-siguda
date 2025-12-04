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
        body {
            background: #000;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Poppins', sans-serif;
        }

        /* Card */
        .login-card {
            width: 400px;
            border-radius: 18px;
            padding: 30px;
            background: linear-gradient(145deg, rgba(0, 0, 0, 0.9), rgba(30, 30, 30, 0.95));
            box-shadow: 0 0 20px rgba(212, 175, 55, 0.3);
            border: 1px solid rgba(212, 175, 55, 0.2);
            animation: fadeIn 0.8s ease-out;
        }

        @keyframes fadeIn {
            from {opacity: 0; transform: translateY(20px);}
            to {opacity: 1; transform: translateY(0);}
        }

        .login-card h3 {
            color: #d4af37;
        }

        .login-card p,
        .login-card label,
        small {
            color: #f5f5f5;
        }

        /* Input styling */
        .form-control {
            background: rgba(255, 255, 255, 0.05) !important;
            border: 1px solid rgba(212, 175, 55, 0.4) !important;
            color: #fff !important;
        }

        .form-control:focus {
            box-shadow: 0 0 10px rgba(212, 175, 55, 0.7);
            border-color: #d4af37 !important;
        }

        .input-group-text {
            background: rgba(212, 175, 55, 0.2) !important;
            border: 1px solid rgba(212, 175, 55, 0.4) !important;
            color: #d4af37;
        }

        ::placeholder {
            color: #aaa !important;
        }

        /* Button */
        .btn-gold {
            background: #d4af37;
            border: none;
            color: #000;
            font-weight: bold;
            transition: 0.3s;
        }

        .btn-gold:hover {
            background: #b8922d;
        }

        /* Icon */
        .login-icon {
            color: #d4af37;
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

            <button type="submit" class="btn btn-gold w-100 py-2">MASUK SISTEM</button>
        </form>

        <div class="text-center mt-3">
            <small>Gunakan akun: <b>admin</b> / <b>admin123</b></small>
        </div>
    </div>

</body>

</html>
