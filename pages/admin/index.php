<?php
include_once("../../config/conn.php");
session_start();

if (isset($_SESSION['login'])) {
  $_SESSION['login'] = true;
} else {
  echo "<meta http-equiv='refresh' content='0; url=../auth/login.php'>";
  die();
}

$nama = $_SESSION['username'];
$akses = $_SESSION['akses'];

if ($akses != 'admin') {
  echo "<meta http-equiv='refresh' content='0; url=../..'>";
  die();
}
//Mengambil Data Ringkasan dari database, pasien, dokter, obat
$totalPatientsQuery = "SELECT COUNT(*) as total FROM pasien";
$totalPatientsResult = mysqli_query($conn, $totalPatientsQuery);
$totalPatients = mysqli_fetch_assoc($totalPatientsResult)['total'];

$totalDoctorQuery = "SELECT COUNT(*) as total FROM dokter";
$totalDoctorResult = mysqli_query($conn, $totalDoctorQuery);
$totalDoctor = mysqli_fetch_assoc($totalDoctorResult)['total'];

$totalObatQuery = "SELECT COUNT(*) as total FROM obat";
$totalObatResult = mysqli_query($conn, $totalObatQuery);
$totalObat = mysqli_fetch_assoc($totalObatResult)['total'];
?>
<?php
$title = 'Poliklinik | Dashboard';
ob_start();

$content = ob_get_clean();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Poliklinik | Dashboard</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] ?>/bk_poliklinik/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] ?>/bk_poliklinik/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] ?>/bk_poliklinik/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] ?>/bk_poliklinik/plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] ?>/bk_poliklinik/dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] ?>/bk_poliklinik/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] ?>/bk_poliklinik/plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] ?>/bk_poliklinik/plugins/summernote/summernote-bs4.min.css">
</head>

<style>
  .summary-box {
    background: linear-gradient(135deg, #1c1c1c, #3a3a3a); /* Gradasi warna gelap */
    border-radius: 10px;
    box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.8);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    padding: 20px;
    color: #f8f9fa;
    text-align: center;
    margin: 10px;
    flex: 1;
  }

  .summary-box:hover {
    transform: translateY(-10px);
    box-shadow: 4px 4px 15px rgba(0, 0, 0, 0.9);
  }

  .summary-box h3 {
    font-size: 1.5rem;
    margin-bottom: 10px;
  }

  .summary-box p {
    font-size: 1.25rem;
    margin: 0;
  }

  .summary-icon {
    font-size: 3rem;
    margin-bottom: 15px;
    color: #17c0eb; /* Warna ikon */
  }

  .summary-container {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 15px;
  }

  .no-decoration {
    text-decoration: none;
    color: inherit;
  }

  .no-decoration:hover {
    text-decoration: none;
    opacity: 0.8;
    transition: opacity 0.5s;
  }
  .content-wrapper {
  padding: 0 !important; /* Kurangi padding pada konten utama */
  margin: 0 auto; /* Pastikan margin rata */
}

.container {
  padding-top: 0 !important; /* Hilangkan padding bagian atas */
}

.summary-container {
  margin-top: 0 !important; /* Atur ulang margin untuk container */
}
</style>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    <?php include "../../layouts/header.php" ?>

    <div class="content-wrapper">
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">Dashboard <?= ucwords($_SESSION['akses']) ?></h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Dashboard v1</li>
              </ol>
            </div>
          </div>
        </div>
      </div>
      <div class="container">
        <div class="summary-container">
          <!-- Total Dokter -->
          <div class="summary-box">
            <i class="fas fa-user-md summary-icon"></i>
            <h3>Total Dokter</h3>
            <p><?php echo $totalDoctor; ?> Dokter</p>
          </div>

          <!-- Total Obat -->
          <div class="summary-box">
            <i class="fas fa-pills summary-icon"></i>
            <h3>Total Obat</h3>
            <p><?php echo $totalObat; ?> Obat</p>
          </div>

          <!-- Total Pasien -->
          <div class="summary-box">
            <i class="fas fa-user-injured summary-icon"></i>
            <h3>Total Pasien</h3>
            <p><?php echo $totalPatients; ?> Pasien</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>

<?php include '../../layouts/index.php';?>