<?php
include_once("../../config/conn.php");
session_start();

if (isset($_SESSION['signup']) || isset($_SESSION['login'])) {
  $_SESSION['signup'] = true;
  $_SESSION['login'] = true;
} else {
  echo "<meta http-equiv='refresh' content='0; url=..'>";
  die();
}

$id_pasien = $_SESSION['id'];
$no_rm = $_SESSION['no_rm'];
$nama = $_SESSION['username'];
$akses = $_SESSION['akses'];

if ($akses != 'pasien') {
  echo "<meta http-equiv='refresh' content='0; url=..'>";
  die();
}

if (isset($_POST['submit'])) {
  $subject = $_POST['subject'];
  $pertanyaan = $_POST['pertanyaan'];
  $jawaban = $_POST['jawaban'];
  $id_dokter = $_POST['id_dokter'];
  $tgl_konsultasi = date('Y-m-d H:i:s');

  if (empty($subject) || empty($pertanyaan) || $id_dokter == '900') {
    echo "
        <script>
            alert('Semua kolom harus diisi!');
        </script>
    ";
  } else {
    try {
      $stmt = $pdo->prepare("INSERT INTO keluhan (subject, pertanyaan, tgl_konsultasi, id_pasien, id_dokter) 
                            VALUES (:subject, :pertanyaan, :tgl_konsultasi, :id_pasien, :id_dokter)");
      $stmt->bindParam(':subject', $subject);
      $stmt->bindParam(':pertanyaan', $pertanyaan);
      $stmt->bindParam(':tgl_konsultasi', $tgl_konsultasi);
      $stmt->bindParam(':id_pasien', $id_pasien);
      $stmt->bindParam(':id_dokter', $id_dokter);

      if ($stmt->execute()) {
        echo "
            <script>
                alert('Konsultasi berhasil diajukan');
            </script>
        ";
      } else {
        echo "
            <script>
                alert('Konsultasi gagal diajukan');
            </script>
        ";
      }
    } catch (PDOException $e) {
      echo "
          <script>
              alert('Error: " . $e->getMessage() . "');
          </script>
      ";
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Konsultasi | Dashboard</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
</head>

<body class="hold-transition sidebar-mini">
  <div class="wrapper">

    <?php include "../../layouts/header.php"; ?>

    <div class="content-wrapper">
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">Konsultasi</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Konsultasi</li>
              </ol>
            </div>
          </div>
        </div>
      </div>

      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <!-- Form Konsultasi -->
            <div class="col-lg-6 mx-auto">
              <div class="card">
                <h5 class="card-header bg-info">Form Konsultasi</h5>
                <div class="card-body">
                  <form action="" method="POST">
                    <input type="hidden" value="<?= $id_pasien ?>" name="id_pasien">
                    <div class="mb-3">
                      <label for="subject" class="form-label">Subjek</label>
                      <input type="text" class="form-control" id="subject" name="subject" placeholder="Masukkan subjek konsultasi">
                    </div>
                    <div class="mb-3">
                      <label for="pertanyaan" class="form-label">Pertanyaan</label>
                      <textarea class="form-control" id="pertanyaan" name="pertanyaan" rows="4" placeholder="Masukkan pertanyaan Anda"></textarea>
                    </div>
                    <div class="mb-3">
                      <label for="dokter" class="form-label">Pilih Dokter</label>
                      <select id="dokter" class="form-control" name="id_dokter">
                        <option value="900">Pilih Dokter</option>
                        <?php
                        $dokter = $pdo->prepare("SELECT * FROM dokter");
                        $dokter->execute();
                        while ($row = $dokter->fetch()) {
                          echo "<option value='{$row['id']}'>{$row['nama']}</option>";
                        }
                        ?>
                      </select>
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary w-100">Ajukan Konsultasi</button>
                  </form>
                </div>
              </div>
            </div>
          </div>

       <!-- Riwayat Konsultasi -->
        <div class="row mt-4">
        <div class="col-lg-12">
            <div class="card">
            <h5 class="card-header bg-info">Riwayat Konsultasi</h5>
            <div class="card-body">
                <table class="table table-bordered table-hover text-center">
                <thead>
                    <tr>
                    <th>No</th>
                    <th>Subjek</th>
                    <th>Pertanyaan</th>
                    <th>Dokter</th>
                    <th>Jawaban</th>
                    <th>Tanggal Konsultasi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    try {
                    // Query untuk mendapatkan data riwayat konsultasi
                    $query = $pdo->prepare("SELECT 
                                            k.subject, 
                                            k.pertanyaan,
                                            k.jawaban, 
                                            k.tgl_konsultasi, 
                                            COALESCE(d.nama, 'Dokter Tidak Ditemukan') AS nama_dokter 
                                            FROM keluhan k 
                                            LEFT JOIN dokter d ON k.id_dokter = d.id 
                                            WHERE k.id_pasien = :id_pasien 
                                            ORDER BY k.tgl_konsultasi DESC
                    ");
                    $query->bindParam(':id_pasien', $id_pasien, PDO::PARAM_INT);
                    $query->execute();

                    $no = 1;

                    // Cek jika ada data
                    if ($riwayat->rowCount() > 0) {
                        while ($row = $riwayat->fetch(PDO::FETCH_ASSOC)) {
                        echo "
                            <tr>
                            <td>{$no}</td>
                            <td>" . htmlspecialchars($row['subject']) . "</td>
                            <td>" . htmlspecialchars($row['pertanyaan']) . "</td>
                            <td>" . htmlspecialchars($row['nama_dokter']) . "</td>
                            <td>" . htmlspecialchars($row['jawaban']) . "</td>
                            <td>" . date('d-m-Y H:i:s', strtotime($row['tgl_konsultasi'])) . "</td>
                            </tr>";
                        $no++;
                        }
                    } else {
                        // Jika tidak ada riwayat
                        echo "
                        <tr>
                            <td colspan='5'>Belum ada riwayat konsultasi</td>
                        </tr>";
                    }
                    } catch (PDOException $e) {
                    // Tampilkan error jika query gagal
                    echo "
                        <tr>
                        <td colspan='5'>Error: " . htmlspecialchars($e->getMessage()) . "</td>
                        </tr>";
                    }
                    ?>
                </tbody>
                </table>
            </div>
            </div>
        </div>
        </div>
      </section>
    </div>

    <?php include "../../layouts/footer.php"; ?>
  </div>

  <?php include "../../layouts/pluginsexport.php"; ?>
</body>

</html>
<!-- Riwayat Konsultasi -->
