<?php
session_start();
include_once("../../config/conn.php");
//Memeriksa Status Login
if (isset($_SESSION['login'])) {
  echo "<meta http-equiv='refresh' content='0; url=../..'>";
  die();
}
//Menangani Login
if (isset($_POST['klik'])) {
 //Input Username dan Password
  $username = stripslashes($_POST['nama']);
  $password = $_POST['alamat'];
  //Login Admin
  if ($username == 'admin') {
    if ($password == 'admin') {
      //Validasi dan Login Dokter
      $_SESSION['login'] = true;
      $_SESSION['id'] = null;
      $_SESSION['username'] = 'admin';
      $_SESSION['akses'] = 'admin';
      echo "<meta http-equiv='refresh' content='0; url=../admin'>";
      die();
    }
  } else {
    $cek_username = $pdo->prepare("SELECT * FROM dokter WHERE nama = '$username'; ");
    try{
        $cek_username->execute();
        if($cek_username->rowCount()==1){
            $baris = $cek_username->fetchAll(PDO::FETCH_ASSOC);
            if($password == $baris[0]['alamat']){
              $_SESSION['login'] = true;
              $_SESSION['id'] = $baris[0]['id'];
              $_SESSION['username'] = $baris[0]['nama'];
              $_SESSION['akses'] = 'dokter';
              echo "<meta http-equiv='refresh' content='0; url=../dokter/index.php'>";
              die();
            }
        }
    } catch(PDOException $e){
      $_SESSION['error'] = $e->getMessage();
      echo "<meta http-equiv='refresh' content='0;'>";
      die();
    }
  }
  $_SESSION['error'] = 'Username dan Password Tidak Cocok';
  echo "<meta http-equiv='refresh' content='0;'>";
  die();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Poliklinik | Log in</title>
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

  .alert {
    margin-bottom: 20px;
    padding: 15px;
    background-color: #e74c3c;
    border: 1px solid #c0392b;
    color: #fff;
    border-radius: 5px;
    text-align: center;
    font-size: 14px;
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
    <p>Poliklinik Login Dokter</p>
  </div>
  <div class="right-box">
    <h2>Login</h2>
    <?php if (isset($_SESSION['error'])) { ?>
      <div class="alert"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php } ?>
    <form method="POST">
      <input type="text" name="nama" class="form-control" placeholder="Username" required />
      <input type="password" name="alamat" class="form-control" placeholder="Password" required />
      <button type="submit" name="klik" class="btn-primary">Login</button>
    </form>
  </div>
</div>
</body>
</html>
