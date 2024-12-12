<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Header & Sidebar</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.2/css/bootstrap.min.css">
</head>

<body>
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-dark bg-dark">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link text-white" data-widget="pushmenu" href="#" role="button">
                    <i class="fas fa-bars"></i>
                </a>
            </li>
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <!-- Navbar Search -->
            <li class="nav-item">
                <a class="nav-link text-white" data-widget="navbar-search" href="#" role="button">
                    <i class="fas fa-search"></i>
                </a>
                <div class="navbar-search-block">
                    <form class="form-inline">
                        <div class="input-group input-group-sm">
                            <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
                            <div class="input-group-append">
                                <button class="btn btn-navbar btn-dark" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </li>

            <!-- Dropdown Logout -->
            <li class="nav-item dropdown">
                <a class="nav-link text-white" data-toggle="dropdown" href="#">
                    <i class="far fa-user"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right bg-dark">
                    <a href="http://<?= $_SERVER['HTTP_HOST']?>/bk_poliklinik/pages/auth/destroy.php" class="dropdown-item text-white">Logout</a>
                </div>
            </li>
        </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary bg-dark elevation-4">
        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user panel -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="info">
                    <a href="#" class="d-block text-white">Selamat Datang, <?= ucwords($_SESSION['username']) ?></a>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column text-white" role="menu" data-accordion="false">
                    <?php if ($_SESSION['akses'] == 'admin') : ?>
                        <li class="nav-item">
                            <a href="<?= $base_admin ?>" class="nav-link">
                                <i class="nav-icon fas fa-home"></i>
                                <p>Dashboard <span class="right badge badge-success">Admin</span></p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= $base_admin.'/dokter' ?>" class="nav-link">
                                <i class="nav-icon fas fa-user-nurse"></i>
                                <p>Dokter</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= $base_admin.'/pasien' ?>" class="nav-link">
                                <i class="nav-icon fas fa-procedures"></i>
                                <p>Pasien</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= $base_admin.'/poli' ?>" class="nav-link">
                                <i class="nav-icon fas fa-clinic-medical"></i>
                                <p>Poli</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= $base_admin.'/obat' ?>" class="nav-link">
                                <i class="nav-icon fas fa-capsules"></i>
                                <p>Obat</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="http://<?= $_SERVER['HTTP_HOST']?>/bk_poliklinik/pages/auth/destroy.php" class="nav-link">
                                <i class="nav-icon fas fa-power-off"></i>
                                <p>Logout</p>
                            </a>
                        </li>
                    <?php elseif ($_SESSION['akses'] == 'dokter') : ?>
                        <li class="nav-item">
                            <a href="<?= $base_dokter ?>" class="nav-link">
                                <i class="nav-icon fas fa-th"></i>
                                <p>Dashboard <span class="right badge badge-success">Dokter</span></p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= $base_dokter . '/jadwal_periksa' ?>" class="nav-link">
                                <i class="nav-icon fas fa-clipboard-list"></i>
                                <p>Jadwal Periksa</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= $base_dokter . '/memeriksa_pasien' ?>" class="nav-link">
                                <i class="nav-icon fas fa-stethoscope"></i>
                                <p>Memeriksa Pasien</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= $base_dokter . '/riwayat_pasien' ?>" class="nav-link">
                                <i class="nav-icon fas fa-notes-medical"></i>
                                <p>Riwayat Pasien</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= $base_dokter . '/profil' ?>" class="nav-link">
                                <i class="nav-icon fas fa-user"></i>
                                <p>Profil</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="http://<?= $_SERVER['HTTP_HOST']?>/bk_poliklinik/pages/auth/destroy.php" class="nav-link">
                                <p>Logout</p>
                            </a>
                        </li>
                    <?php else : ?>
                        <li class="nav-item">
                            <a href="<?= $base_pasien ?>" class="nav-link">
                                <i class="nav-icon fas fa-th"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= $base_pasien . '/poli' ?>" class="nav-link">
                                <i class="nav-icon fas fa-hospital"></i>
                                <p>Poli</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="http://<?= $_SERVER['HTTP_HOST']?>/bk_poliklinik/pages/auth/destroy.php" class="nav-link">
                                <p>Logout</p>
                            </a>
                        </li>
                    <?php endif ?>
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.2/js/bootstrap.bundle.min.js"></script>
</body>

</html>


