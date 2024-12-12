<?php
session_start();
include_once("../../config/conn.php");

if (isset($_SESSION['login'])) {
  echo "<meta http-equiv='refresh' content='0; url=../..'>";
  die();
}

if (isset($_POST['klik'])) {
  $username = stripslashes($_POST['nama']);
  $password = $_POST['alamat'];

  // Cek apakah username terdaftar
  $cek_username = $pdo->prepare("SELECT * FROM pasien WHERE nama = :nama");
  $cek_username->bindParam(':nama', $username, PDO::PARAM_STR);
  try {
    $cek_username->execute();
    if ($cek_username->rowCount() == 1) {
      $baris = $cek_username->fetch(PDO::FETCH_ASSOC);
      // Verifikasi password
      if ($password == $baris['alamat']) {
        // Set data sesi
        $_SESSION['login'] = true;
        $_SESSION['id'] = $baris['id'];
        $_SESSION['username'] = $baris['nama'];
        $_SESSION['no_rm'] = $baris['no_rm']; // Menyimpan No RM di sesi
        $_SESSION['akses'] = 'pasien';
        echo "<meta http-equiv='refresh' content='0; url=../pasien/index.php'>";
        die();
      }
    }
  } catch (PDOException $e) {
    $_SESSION['error'] = $e->getMessage();
    echo "<meta http-equiv='refresh' content='0;'>";
    die();
  }
  $_SESSION['error'] = 'Nama dan Password Tidak Cocok';
  echo "<meta http-equiv='refresh' content='0;'>";
  die();
}
?>
<!DOCTYPE html>
<html lang="id-ID">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Poliklinik | Masuk</title>
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
  height: 500px;
  max-width: 100%;
  border-radius: 20px;
  background: #1b1b1b;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
  overflow: hidden;
}

.left-box {
  flex: 1;
  background: linear-gradient(135deg, #2c2c2c, #1b1b1b); /* Gradien gelap */
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  padding: 40px;
}

.left-box h1 {
  font-size: 32px;
  margin-bottom: 10px;
  font-weight: 700;
  color: #ffa500;
  text-shadow: 0 4px 10px rgba(0, 0, 0, 0.5);
}

.left-box p {
  font-size: 18px;
  color: #fff;
}

.right-box {
  flex: 1;
  padding: 50px 40px;
  background: #2c2c2c;
  display: flex;
  flex-direction: column;
  justify-content: center;
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
}

.form-control:focus {
  border-color: #ffa500;
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
  box-shadow: 0 4px 10px rgba(255, 165, 0, 0.3);
}

.btn-primary:hover {
  background-color: #cc8400;
  box-shadow: 0 6px 15px rgba(255, 165, 0, 0.5);
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
        background: linear-gradient(135deg, #0e9785, #11B69F);
        
      }
    }
  </style>
</head>
<body>
<div class="container">
  <div class="left-box">
    <h1>Selamat Datang</h1>
    <p>Poliklinik Login Pasien</p>
  </div>
  <div class="right-box" style="color: white;">
    <h2>Login</h2>
    <?php if (isset($_SESSION['error'])) { ?>
      <div class="alert"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php } ?>
    <form method="POST">
      <input type="text" name="nama" class="form-control" placeholder="Username" required />
      <input type="password" name="alamat" class="form-control" placeholder="Password" required />
      <div class="form-check mb-4">
        <label class="form-check-label" for="agreeTerms" style="color: white;">Jika belum memiliki akun <a href="http://<?= $_SERVER['HTTP_HOST'] ?>/bk_poliklinik/pages/auth/register.php">Daftar</a></label>
      </div>
      <button type="submit" name="klik" class="btn-primary">Masuk</button>
    </form>
  </div>
</div>
</body>
</html>
