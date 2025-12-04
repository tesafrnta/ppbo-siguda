<nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
    <div class="container">
        <a class="navbar-brand" href="<?= $base_url ?>/Dashboard">
            <i class="bi bi-box-seam-fill"></i> SIGUDA PPBO
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">

                <li class="nav-item">
                    <a class="nav-link" href="<?= $base_url ?>/Dashboard">
                        <i class="bi bi-house-door"></i> Dashboard
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="<?= $base_url ?>/Kategori">
                        <i class="bi bi-tags"></i> Kategori
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="<?= $base_url ?>/Produk">
                        <i class="bi bi-box-seam"></i> Produk
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="<?= $base_url ?>/Transaksi">
                        <i class="bi bi-arrow-left-right"></i> Transaksi
                    </a>
                </li>

            </ul>
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle"></i> 
                        <?= htmlspecialchars($_SESSION['nama_lengkap'] ?? 'Guest'); ?>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        <li>
                            <span class="dropdown-item-text">
                                <small class="text-muted">
                                    Role: <strong><?= ucfirst($_SESSION['role'] ?? 'N/A'); ?></strong>
                                </small>
                            </span>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item text-danger" href="<?= $base_url ?>/Logout">
                                <i class="bi bi-box-arrow-right"></i> Logout
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>