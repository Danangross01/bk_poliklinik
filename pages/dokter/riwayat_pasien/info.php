<?php
include_once("../../../config/conn.php");
session_start();

// Validasi Sesi
if (!isset($_SESSION['login']) || $_SESSION['akses'] != 'dokter') {
    echo "<meta http-equiv='refresh' content='0; url=../auth/login.php'>";
    die();
}
//RIWAYAT PASIEN (INDEX.PHP)
// Ambil Nama Dokter dari Sesi
$doctor_name = $_SESSION['username']; // Nama dokter dari sesi login

$title = 'Poliklinik | Riwayat Pasien';
// Breadcrumb section
ob_start(); ?>
<ol class="breadcrumb float-sm-right">
  <li class="breadcrumb-item"><a href="<?= $base_dokter; ?>">Home</a></li>
  <li class="breadcrumb-item active">Riwayat Pasien</li>
</ol>
<?php
$breadcrumb = ob_get_clean();
ob_flush();

// Title Section
ob_start(); ?>
Riwayat Pasien
<?php
$main_title = ob_get_clean();
ob_flush();

// Content section
ob_start();
?>
<div class="card">
  <div class="card-header">
    <h3 class="card-title fw-bold">Daftar Riwayat Pasien</h3>
  </div>
  <div class="card-body">
    <table id="example1" class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>No</th>
          <th>Nama Pasien</th>
          <th>Alamat</th>
          <th>No. KTP</th>
          <th>No. Telepon</th>
          <th>No. RM</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $index = 1;
        // Query untuk mengambil pasien yang terkait dengan nama dokter
        $data = $pdo->prepare("
            SELECT DISTINCT p.* 
            FROM pasien p
            INNER JOIN daftar_poli dpo ON p.id = dpo.id_pasien
            INNER JOIN jadwal_periksa jp ON dpo.id_jadwal = jp.id
            INNER JOIN dokter d ON jp.id_dokter = d.id
            WHERE d.nama = :nama_dokter
        ");
        $data->execute(['nama_dokter' => $doctor_name]);

        if ($data->rowCount() == 0) {
          echo "<tr><td colspan='7' align='center'>Tidak ada data</td></tr>";
        } else {
          while ($d = $data->fetch()) {
        ?>
            <tr>
              <td><?= $index++; ?></td>
              <td><?= $d['nama']; ?></td>
              <td><?= $d['alamat']; ?></td>
              <td><?= $d['no_ktp']; ?></td>
              <td><?= $d['no_hp']; ?></td>
              <td><?= $d['no_rm']; ?></td>
              <td>
                  <a href="detailriwayat.php?pasien_id=<?= $d['id'] ?>" class="btn btn-primary btn-sm"><i class="fa fa-external-link"></i>Detail Pasien</a>
              </td>
            </tr>
            <!-- Modal Detail Riwayat Periksa start here -->
          <?php
          $no = 1;
          $pasien_id = $d['id'];
          $data2 = $pdo->prepare("
              SELECT 
                  p.nama AS 'nama_pasien',
                  pr.*,
                  d.nama AS 'nama_dokter',
                  dpo.keluhan AS 'keluhan',
                  GROUP_CONCAT(o.nama_obat SEPARATOR ', ') AS 'obat'
              FROM periksa pr
              LEFT JOIN daftar_poli dpo ON (pr.id_daftar_poli = dpo.id)
              LEFT JOIN jadwal_periksa jp ON (dpo.id_jadwal = jp.id)
              LEFT JOIN dokter d ON (jp.id_dokter = d.id)
              LEFT JOIN pasien p ON (dpo.id_pasien = p.id)
              LEFT JOIN detail_periksa dp ON (pr.id = dp.id_periksa)
              LEFT JOIN obat o ON (dp.id_obat = o.id)
              WHERE dpo.id_pasien = :pasien_id AND d.nama = :nama_dokter
              GROUP BY pr.id
              ORDER BY pr.tgl_periksa DESC;
          ");
          $data2->execute(['pasien_id' => $pasien_id, 'nama_dokter' => $doctor_name]);
          ?>
          <div class="modal fade" id="detailModal<?= $d['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true" data-backdrop="static" >
            <div class="modal-dialog modal-xl modal-dialog-scrollable modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalScrollableTitle">Riwayat <?= $d['nama'] ?></h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <!-- Mulai Tabel -->
                  <?php if ($data2->rowCount() == 0) : ?>
                    <h5>Tidak Ditemukan Riwayat Periksa</h5>
                  <?php else : ?>
                    <div class="grid-container">
                      <div class="grid-item">No</div>
                      <div class="grid-item">Tanggal Periksa</div>
                      <div class="grid-item">Nama Pasien</div>
                      <div class="grid-item">Nama Dokter</div>
                      <div class="grid-item">Keluhan</div>
                      <div class="grid-item">Catatan</div>
                      <div class="grid-item">Obat</div>
                      <div class="grid-item">Biaya Periksa</div>
                      <?php while ($da = $data2->fetch()) : ?>
                        <div class="grid-item"><?= $no++; ?></div>
                        <div class="grid-item"><?= $da['tgl_periksa']; ?></div>
                        <div class="grid-item"><?= $da['nama_pasien']; ?></div>
                        <div class="grid-item"><?= $da['nama_dokter']; ?></div>
                        <div class="grid-item"><?= $da['keluhan']; ?></div>
                        <div class="grid-item"><?= $da['catatan']; ?></div>
                        <div class="grid-item"><?= $da['obat']; ?></div>
                        <div class="grid-item"><?= formatRupiah($da['biaya_periksa']); ?></div>
                      <?php endwhile ?>
                      <?php $no = 1; ?>
                    </div>
                  <?php endif ?>
                  <!-- Akhir dari Tabel -->
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
              </div>
            </div>
          </div>
          <!-- Modal Detail Riwayat Periksa ends here -->
        <?php }
        } ?>
      </tbody>
    </table>
  </div>
</div>
<?php
$content = ob_get_clean();
ob_flush();
?>

<?php include '../../../layouts/index.php'; ?>
