<?php
include_once("../../config/conn.php");
session_start();

$nama = $_SESSION['username'];
$akses = $_SESSION['akses'];

if ($akses != 'pasien') {
  echo "<meta http-equiv='refresh' content='0; url=../..'>";
  die();
}
$totalPatientsQuery = "SELECT COUNT(*) as total FROM pasien";
$totalPatientsResult = mysqli_query($conn, $totalPatientsQuery);
$totalPatients = mysqli_fetch_assoc($totalPatientsResult)['total'];

$totalDoctorQuery = "SELECT COUNT(*) as total FROM dokter";
$totalDoctorResult = mysqli_query($conn, $totalDoctorQuery);
$totalDoctor = mysqli_fetch_assoc($totalDoctorResult)['total'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= getenv('APP_NAME') ?> | Dashboard</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="../../plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="../../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="../../plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="../../plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="../../plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="../../plugins/summernote/summernote-bs4.min.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Preloader -->
  
  <?php include "../../layouts/header.php"?>
  <div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-4">
        <div class="col-12 text-center">
          <h1 class="fw-bold">Selamat Datang, <?= htmlspecialchars($nama) ?>!</h1>
          <p class="lead text-muted">Dashboard Anda untuk mengakses layanan Poliklinik.</p>
        </div>
      </div>
    </div>
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <!-- Statistik Utama -->
      <div class="row">
        <!-- Card 1 -->
        <div class="col-md-4 col-sm-6 mb-4">
          <div class="card text-white bg-primary">
            <div class="card-body">
              <div class="d-flex justify-content-between">
                <div>
                  <h5 class="card-title">Total Pasien</h5>
                  <h2> <?php echo $totalPatients; ?></h2>
                </div>
                <div>
                  <i class="fas fa-notes-medical fa-3x"></i>
                </div>
              </div>
              <p class="card-text mt-3">Jumlah Pasien Poli.</p>
            </div>
          </div>
        </div>
        <!-- Card 2 -->
        <div class="col-md-4 col-sm-6 mb-4">
          <div class="card text-white bg-success">
            <div class="card-body">
              <div class="d-flex justify-content-between">
                <div>
                  <h5 class="card-title">Dokter Tersedia</h5>
                  <h2><?php echo $totalDoctor; ?></h2>
                </div>
                <div>
                  <i class="fas fa-user-md fa-3x"></i>
                </div>
              </div>
              <p class="card-text mt-3">Dokter aktif yang siap melayani Anda.</p>
            </div>
          </div>
        </div>
      </div>
      <!-- /Statistik Utama -->

      <!-- Informasi & Aksi -->
      <div class="row">
        <div class="col-md-8">
          <div class="card">
            <div class="card-header bg-secondary text-white">
              <h5 class="m-0">Informasi Penting</h5>
            </div>
            <div class="card-body">
              <p class="text-muted">Berikut adalah informasi terkini mengenai layanan poliklinik kami:</p>
              <ul>
                <li>Jam operasional: Senin - Jumat, 08.00 - 17.00.</li>
                <li>Pastikan Anda hadir 15 menit sebelum waktu pendaftaran.</li>
                <li>Pilih dokter yang sedang aktif atau dokter yang tersedia.</li>
              </ul>
              <p class="mt-3">Untuk informasi lebih lanjut, silakan kunjungi bagian *Help* di menu sidebar.</p>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card text-center">
            <div class="card-header bg-info text-white">
              <h5 class="m-0">Aksi Cepat</h5>
            </div>
            <div class="card-body">
              <a href="poli/index.php" class="btn btn-primary btn-block mb-3">
                <i class="fas fa-clipboard-list"></i> Daftar Poli
              </a>
              <a href="poli/index.php" class="btn btn-success btn-block mb-3">
                <i class="fas fa-history"></i> Riwayat Pendaftaran
              </a>
              <a href="#" class="btn btn-warning btn-block">
                <i class="fas fa-question-circle"></i> Bantuan
              </a>
            </div>
          </div>
        </div>
      </div>
      <!-- /Informasi & Aksi -->
    </div>
  </section>
  <!-- /.content -->
</div>

  <!-- /.content-wrapper -->
  <?php include "../../layouts/footer.php"; ?>
</div>
<!-- ./wrapper -->
<?php include "../../layouts/pluginsexport.php"; ?>
</body>
</html>