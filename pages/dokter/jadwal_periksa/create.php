<?php
include_once "../../../config/conn.php";
session_start();

// Cek login dan akses
if (isset($_SESSION['login'])) {
    $_SESSION['login'] = true;
} else {
    echo "<meta http-equiv='refresh' content='0; url=..'>";
    die();
}

$nama = $_SESSION['username'];
$akses = $_SESSION['akses'];
$id_dokter = $_SESSION['id'];

if ($akses != 'dokter') {
    echo "<meta http-equiv='refresh' content='0; url=..'>";
    die();
}

// Function to check if the schedule already exists for the same day
function isJadwalExist($id_dokter, $hari) {
    global $conn;
    $query = "SELECT COUNT(*) AS count FROM jadwal_periksa 
              WHERE id_dokter = ? AND hari = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("is", $id_dokter, $hari);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
    return $data['count'] > 0;
}

// Function to add schedule (stub function, implement sesuai kebutuhan)
function tambahJadwalPeriksa($data) {
    global $conn;
    $id_dokter = $data['id_dokter'];
    $hari = $data['hari'];
    $jam_mulai = $data['jam_mulai'];
    $jam_selesai = $data['jam_selesai'];

    $query = "INSERT INTO jadwal_periksa (id_dokter, hari, jam_mulai, jam_selesai) 
              VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("isss", $id_dokter, $hari, $jam_mulai, $jam_selesai);

    if ($stmt->execute()) {
        return 1; // Success
    }
    return -1; // Failed
}

// Input data to db
if (isset($_POST["submit"])) {
    // Validasi input
    if (empty($_POST["hari"]) || empty($_POST["jam_mulai"]) || empty($_POST["jam_selesai"])) {
        echo "
            <script>
                alert('Data tidak boleh kosong');
                document.location.href = '../jadwal_periksa/create.php';
            </script>
        ";
        die;
    } else {
        $hari = $_POST['hari'];
        $jam_mulai = $_POST['jam_mulai'];
        $jam_selesai = $_POST['jam_selesai'];

        // Cek apakah jadwal dengan hari yang sama sudah ada
        if (isJadwalExist($id_dokter, $hari)) {
            echo "
                <script>
                    alert('Data Gagal ditambahkan, jadwal untuk hari yang sama sudah ada');
                    document.location.href = '../jadwal_periksa/create.php';
                </script>
            ";
            die;
        }

        // Cek apakah data berhasil ditambahkan atau tidak
        if (tambahJadwalPeriksa($_POST) > 0) {
            echo "
                <script>
                    alert('Data berhasil ditambahkan');
                    document.location.href = '../jadwal_periksa';
                </script>
            ";
        } else {
            echo "
                <script>
                    alert('Data Gagal ditambahkan');
                    document.location.href = '../jadwal_periksa/create.php';
                </script>
            ";
        }
    }
}
?>

<?php
$title = 'Poliklinik | Tambah Jadwal Periksa';

// Breadcrumb Section
ob_start();?>
<ol class="breadcrumb float-sm-right">
  <li class="breadcrumb-item"><a href="<?=$base_dokter;?>">Home</a></li>
  <li class="breadcrumb-item"><a href="<?=$base_dokter . '/jadwal_periksa';?>">Jadwal Periksa</a></li>
  <li class="breadcrumb-item active">Tambah Jadwal Periksa</li>
</ol>
<?php
$breadcrumb = ob_get_clean();
ob_flush();

// Title Section
ob_start();?>
Tambah Jadwal Periksa
<?php
$main_title = ob_get_clean();
ob_flush();

// Content Section
ob_start();?>
<div class="card">
  <div class="card-header">
    <h3 class="card-title">Tambah Jadwal Periksa</h3>
  </div>
  <div class="card-body">
    <form action="" id="tambahJadwal" method="POST">
      <input type="hidden" name="id_dokter" value="<?=$id_dokter?>">
      <div class="form-group">
        <label for="hari">Hari</label>
        <select name="hari" id="hari" class="form-control">
          <option value="">-- Pilih Hari --</option>
          <option value="Senin">Senin</option>
          <option value="Selasa">Selasa</option>
          <option value="Rabu">Rabu</option>
          <option value="Kamis">Kamis</option>
          <option value="Jumat">Jumat</option>
          <option value="Sabtu">Sabtu</option>
        </select>
      </div>
      <div class="form-group">
        <label for="jam_mulai">Jam Mulai</label>
        <input type="time" name="jam_mulai" id="jam_mulai" class="form-control">
      </div>
      <div class="form-group">
        <label for="jam_selesai">Jam Selesai</label>
        <input type="time" name="jam_selesai" id="jam_selesai" class="form-control">
      </div>
      <div class="d-flex justify-content-end">
        <button type="submit" name="submit" id="submitButton" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
      </div>
    </form>
  </div>
</div>
<?php
$content = ob_get_clean();
ob_flush();
?>

<?php include_once "../../../layouts/index.php";?>
