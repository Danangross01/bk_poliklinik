# Sistem Manajemen Poliklinik

## Deskripsi Proyek

Sistem Manajemen Poliklinik adalah aplikasi yang dirancang untuk mempermudah proses administrasi dan layanan di poliklinik. Sistem ini mencakup pengelolaan data dokter, pasien, poli, obat, dan jadwal, serta fitur untuk membantu pasien mendaftar dan dokter mencatat rekam medis pasien. Aplikasi ini dirancang responsif dan ramah pengguna untuk berbagai peran seperti Admin, Dokter, dan Pasien.

---

## Fitur Utama

### Untuk Admin
- **Mengelola Dokter**: Tambah, ubah, atau hapus data dokter.
- **Mengelola Poli**: Tambah, ubah, atau hapus data poli.
- **Mengelola Obat**: Tambah, ubah, atau hapus data obat.
- **Mengelola Pasien**: Tambah, ubah, atau hapus data pasien.
- **Dashboard**: Tampilkan statistik jumlah poli, dokter, pasien, dan data lainnya.

### Untuk Dokter
- **Melihat Daftar Pasien**: Daftar pasien yang terjadwal untuk pemeriksaan.
- **Catatan Medis**: Mencatat hasil pemeriksaan dan memberikan resep obat.
- **Hitung Biaya Pemeriksaan**: Menghitung total biaya berdasarkan layanan dan obat yang diberikan.
- **Mengelola Jadwal**: Mengatur ketersediaan jadwal pemeriksaan.
- **Riwayat Pasien**: Melihat rekam medis pasien yang telah diperiksa.
- **Update Profil**: Mengubah data pribadi dan kredensial login.

### Untuk Pasien
- **Pendaftaran Pasien Baru**: Mengisi data diri untuk mendapatkan nomor rekam medis.
- **Pendaftaran Poli**: Memilih poli dan dokter sesuai jadwal, serta mendapatkan nomor antrian.
- **Riwayat Kesehatan**: Melihat riwayat pemeriksaan (opsional jika fitur diberikan).

---

## Teknologi yang Digunakan

- **PHP**: Backend untuk mengelola logika sisi server.
- **MySQL**: Database untuk menyimpan data pasien, dokter, jadwal, dan rekam medis.
- **HTML, CSS, JavaScript**: Membuat antarmuka pengguna yang interaktif dan menarik.
- **Bootstrap**: Untuk desain responsif dan tampilan profesional.

---

## Cara Instalasi

1. **Klon Repository**  
   LINK GHUB : https://github.com/Danangross01/bk_poliklinik.git
2. **Siapkan Server Web**  

3. **Gunakan server web seperti Apache atau XAMPP.**
4. **Arahkan server ke direktori publik aplikasi.**
5. **Impor Database**

6. **Impor file poliklinik.sql ke MySQL menggunakan tools seperti phpMyAdmin atau CLI.**
7. **Konfigurasi Koneksi Database**

8. **Ubah konfigurasi di file config/conn.php sesuai pengaturan database Anda.**
9. **Akses Aplikasi**


**Nama Folder**
bk_poliklinik


**Admin**
Username: admin
Password: admin
**Dokter**
Username: Ifan
Password: Semarang
**Format Username & Password**
Username: Nama pengguna (contoh: Danang)
Password: Alamat pengguna (contoh: Semarang)
**Catatan: Pasien tidak memiliki akun login default karena mereka harus mendaftarkan diri terlebih dahulu untuk mendapatkan akses.**

**Pasien dalam database**
username : Adi
password : Semarang
