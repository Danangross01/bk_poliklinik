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

if ($akses != 'dokter') {
  echo "<meta http-equiv='refresh' content='0; url=../..'>";
  die();
}

$totalPatientsQuery = "SELECT COUNT(*) as total FROM pasien";
$totalPatientsResult = mysqli_query($conn, $totalPatientsQuery);
$totalPatients = mysqli_fetch_assoc($totalPatientsResult)['total'];
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
  <!-- Theme style -->
  <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] ?>/bk_poliklinik/dist/css/adminlte.min.css">
</head>

<style>
  body {
    background-color: #1b1b1b;
    color: #eaeaea;
  }

  .summary-kategori {
    background-color: #3a3a3a;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
  }

  .summary-kategori:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.4);
  }

  .summary-kategori h3 {
    color: #ffa500;
  }

  .breadcrumb-item a {
    color: #ffa500;
  }

  .breadcrumb-item a:hover {
    color: #f5f5f5;
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
              <h1 class="m-0" style="color: black;">Dashboard <?= ucwords($_SESSION['akses']) ?></h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
              </ol>
            </div>
          </div>
        </div>
      </div>

      <div class="container">
        <div class="row">
          <div class="col-lg-4 col-md-6 col-12 mb-3">
            <div class="summary-kategori p-4">
              <div class="row">
                <div class="col-12">
                  <h3>Total Pasien</h3>
                  <p><?php echo $totalPatients; ?> Pasien</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <?php include "../../layouts/footer.php"; ?>
  </div>
</body>

</html>
