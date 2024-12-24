<?php
session_start();
include_once("../../config/conn.php");
//Data pasien diambil 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $nama = htmlspecialchars($_POST['nama']);
  $alamat = htmlspecialchars($_POST['alamat']);
  $no_ktp = htmlspecialchars($_POST['no_ktp']);
  $no_hp = htmlspecialchars($_POST['no_hp']);

  // Cek apakah pasien sudah terdaftar berdasarkan nomor KTP menggunakan prepared statements
  $check_pasien = $conn->prepare("SELECT id, nama, no_rm FROM pasien WHERE no_ktp = ?");
  $check_pasien->bind_param("s", $no_ktp);
  $check_pasien->execute();
  $result_check_pasien = $check_pasien->get_result();

  if ($result_check_pasien->num_rows > 0) {
    $row = $result_check_pasien->fetch_assoc();
    if ($row['nama'] != $nama) {
      echo "<script>alert('Nama pasien tidak sesuai dengan nomor KTP yang terdaftar.');</script>";
      echo "<meta http-equiv='refresh' content='0; url=register.php'>";
      die();
    }
    $_SESSION['signup'] = true;
    $_SESSION['id'] = $row['id'];
    $_SESSION['username'] = $nama;
    $_SESSION['no_rm'] = $row['no_rm'];
    $_SESSION['akses'] = 'pasien';

    echo "<meta http-equiv='refresh' content='0; url=../pasien'>";
    die();
  }

  // Mendapatkan nomor pasien terakhir
  $get_rm = $conn->prepare("SELECT MAX(SUBSTRING(no_rm, 8)) AS last_queue_number FROM pasien");
  $get_rm->execute();
  $result_rm = $get_rm->get_result();

  if ($result_rm->num_rows > 0) {
    $row_rm = $result_rm->fetch_assoc();
    $lastQueueNumber = $row_rm['last_queue_number'] ? $row_rm['last_queue_number'] : 0;
  } else {
    $lastQueueNumber = 0;
  }
  $tahun_bulan = date("Ym");
  $newQueueNumber = $lastQueueNumber + 1;
  $no_rm = $tahun_bulan . "-" . str_pad($newQueueNumber, 3, '0', STR_PAD_LEFT);

  $insert = $conn->prepare("INSERT INTO pasien (nama, alamat, no_ktp, no_hp, no_rm) VALUES (?, ?, ?, ?, ?)");
  $insert->bind_param("sssss", $nama, $alamat, $no_ktp, $no_hp, $no_rm);

  if ($insert->execute()) {
    $_SESSION['signup'] = true;
    $_SESSION['id'] = $insert->insert_id;
    $_SESSION['username'] = $nama;
    $_SESSION['no_rm'] = $no_rm;
    $_SESSION['akses'] = 'pasien';

    echo "<meta http-equiv='refresh' content='0; url=../pasien'>";
    die();
  } else {
    echo "Error: " . $insert->error;
  }

  $insert->close();
  $check_pasien->close();
  $get_rm->close();
  $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Poliklinik | Registration Page</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,600,700&display=fallback">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      margin: 0;
      height: 100vh;
      background: linear-gradient(135deg, #2c2c2c, #1b1b1b);
      display: flex;
      justify-content: center;
      align-items: center;
      overflow: hidden;
    }

    .container {
      display: flex;
      width: 900px;
      height: auto;
      max-width: 100%;
      border-radius: 20px;
      background: #1b1b1b;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
      overflow: hidden;
      transform: scale(0.9);
      animation: zoomIn 0.5s ease-out forwards;
    }

    @keyframes zoomIn {
      0% {
        transform: scale(0.8);
        opacity: 0;
      }
      100% {
        transform: scale(1);
        opacity: 1;
      }
    }

    .left-box {
      flex: 1;
      background: linear-gradient(135deg, #333, #444);
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      padding: 40px;
      color: #ffa500;
    }

    .left-box h1 {
      font-size: 32px;
      margin-bottom: 10px;
      font-weight: 700;
      text-shadow: 0 4px 10px rgba(0, 0, 0, 0.5);
    }

    .left-box p {
      font-size: 18px;
      margin-top: 10px;
    }

    .right-box {
      flex: 1;
      padding: 50px 40px;
      display: flex;
      flex-direction: column;
      justify-content: center;
      background: #2c2c2c;
    }

    .right-box h2 {
      font-size: 24px;
      margin-bottom: 20px;
      font-weight: 600;
      color: #fff;
      text-align: center;
    }

    .form-control {
      width: 100%;
      padding: 15px;
      margin-bottom: 20px;
      border: 2px solid #555;
      background-color: #333;
      color: #fff;
      border-radius: 30px;
      font-size: 16px;
      transition: all 0.3s ease-in-out;
    }

    .form-control:focus {
      border-color: #ffa500;
      outline: none;
      box-shadow: 0 0 10px rgba(255, 165, 0, 0.7);
    }

    .btn-primary {
      background-color: #ffa500;
      color: #fff;
      padding: 15px;
      border: none;
      border-radius: 30px;
      font-size: 16px;
      cursor: pointer;
      width: 100%;
      transition: all 0.3s ease-in-out;
      box-shadow: 0 4px 10px rgba(255, 165, 0, 0.3);
    }

    .btn-primary:hover {
      background-color: #e69500;
      transform: translateY(-3px);
      box-shadow: 0 6px 15px rgba(255, 165, 0, 0.5);
    }

    .form-check {
      font-size: 14px;
      color: #fff;
      margin-bottom: 15px;
    }

    @media (max-width: 768px) {
      .container {
        flex-direction: column;
        height: auto;
      }

      .left-box, .right-box {
        flex: none;
        padding: 20px;
        text-align: center;
      }

      .left-box {
        background: linear-gradient(135deg, #444, #333);
      }
    }
  </style>
</head>
<body>
<div class="container">
  <div class="left-box">
    <h1>Selamat Datang</h1>
    <p>Poliklinik Registrasi Pasien</p>
  </div>
  <div class="right-box">
    <h2>Registrasi</h2>
    <form action="" method="post">
      <input type="text" class="form-control" required placeholder="Nama Lengkap" id="nama" name="nama">
      <input type="text" class="form-control" required placeholder="Alamat" id="alamat" name="alamat">
      <input type="number" class="form-control" required placeholder="No KTP" id="no_ktp" name="no_ktp">
      <input type="number" class="form-control" required placeholder="No HP" id="no_hp" name="no_hp">
      <div class="form-check">
        <input type="checkbox" required id="agreeTerms" name="terms" value="agree">
        <label for="agreeTerms">Saya setuju dengan <a href="#">Syarat & Ketentuan</a></label>
      </div>
      <div class="form-check">
        <label>Sudah punya akun? <a href="http://<?= $_SERVER['HTTP_HOST'] ?>/bk_poliklinik/pages/auth/login-pasien.php">Login</a></label>
      </div>
      <button type="submit" class="btn-primary">Daftar</button>
    </form>
  </div>
</div>
</body>
</html>
