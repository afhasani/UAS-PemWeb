<?php
// Memulai sesi
session_start();

// Kelas untuk koneksi ke database
class Database {
    private $host = "localhost"; // Nama host database
    private $username = "root"; // Username database
    private $password = ""; // Password database
    private $dbname = "uas"; // Nama database
    public $conn;

    // Koneksi ke database dibuat ketika kelas diinisialisasi
    public function __construct() {
        $this->conn = new mysqli($this->host, $this->username, $this->password, $this->dbname);
        // Periksa apakah koneksi berhasil, jika gagal hentikan eksekusi dan tampilkan pesan error
        if ($this->conn->connect_error) {
            die("Koneksi Gagal: " . $this->conn->connect_error);
        }
    }

    // Fungsi untuk menjalankan query SQL
    public function query($sql) {
        return $this->conn->query($sql);
    }

    // Fungsi untuk mengamankan data input dari SQL injection
    public function escape_string($value) {
        return $this->conn->real_escape_string($value);
    }
}

// Kelas untuk mengelola data mahasiswa
class Mahasiswa {
    private $db;

    // Menggunakan koneksi database yang diberikan saat kelas diinisialisasi
    public function __construct($db) {
        $this->db = $db;
    }

    // Fungsi untuk menambahkan mahasiswa baru
    public function tambah($data) {
        // Mengambil data input
        $nama = $this->db->escape_string($data['nama']); //escape_string digunakan untuk memastikan tidak ada karakter yang mengganggu query
        $nim = $this->db->escape_string($data['nim']);
        $prodi = $this->db->escape_string($data['prodi']);
        $nilai_mutu = $this->db->escape_string($data['nilai_mutu']);
        $ip_address = $_SERVER['REMOTE_ADDR']; // Mendapatkan alamat IP pengguna
        $browser = $_SERVER['HTTP_USER_AGENT']; // Mendapatkan informasi browser pengguna
        $semester = $this->db->escape_string($data['semester']);
        $jenis_kelamin = $this->db->escape_string($data['jenis_kelamin']);
        $hobi = implode(', ', $data['hobi']); // Menggabungkan array hobi menjadi string
        $catatan = $this->db->escape_string($data['catatan']);

        // Menyusun query SQL untuk menambahkan data ke tabel mahasiswa
        $sql = "INSERT INTO mahasiswa (nama, nim, prodi, nilai_mutu, ip_address, browser, semester, jenis_kelamin, hobi, catatan) 
                VALUES ('$nama', '$nim', '$prodi', '$nilai_mutu', '$ip_address', '$browser', '$semester', '$jenis_kelamin', '$hobi', '$catatan')";

        return $this->db->query($sql); // Menjalankan query dan mengembalikan hasilnya
    }

    // Fungsi untuk memperbarui data mahasiswa
    public function update($data) {
        $id = $this->db->escape_string($data['id_mahasiswa']);
        $nama = $this->db->escape_string($data['nama']);
        $nim = $this->db->escape_string($data['nim']);
        $prodi = $this->db->escape_string($data['prodi']);
        $nilai_mutu = $this->db->escape_string($data['nilai_mutu']);
        $ip_address = $_SERVER['REMOTE_ADDR'];
        $browser = $_SERVER['HTTP_USER_AGENT'];
        $semester = $this->db->escape_string($data['semester']);
        $jenis_kelamin = $this->db->escape_string($data['jenis_kelamin']);
        $hobi = implode(', ', $data['hobi']); //implode digunakan untuk menggabungkan hobi yang dipilih oleh pengguna (berupa array) menjadi satu string
        $catatan = $this->db->escape_string($data['catatan']);

        // Query SQL untuk memperbarui data mahasiswa berdasarkan id
        $sql = "UPDATE mahasiswa 
                SET nama='$nama', nim='$nim', prodi='$prodi', nilai_mutu='$nilai_mutu', 
                    ip_address='$ip_address', browser='$browser', semester='$semester',
                    jenis_kelamin='$jenis_kelamin', hobi='$hobi', catatan='$catatan'
                WHERE id_mahasiswa='$id'";

        return $this->db->query($sql);
    }

    // Fungsi untuk menghapus data mahasiswa berdasarkan id
    public function hapus($id) {
        $id = $this->db->escape_string($id);
        $sql = "DELETE FROM mahasiswa WHERE id_mahasiswa=$id";
        return $this->db->query($sql);
    }

    // Fungsi untuk mengambil semua data mahasiswa
    public function getAll() {
        $sql = "SELECT * FROM mahasiswa";
        return $this->db->query($sql);
    }
}

// Membuat koneksi database dan inisialisasi kelas Mahasiswa
$db = new Database();
$mahasiswa = new Mahasiswa($db);

// Proses untuk menambahkan data mahasiswa
if (isset($_POST['tambah'])) {
    if ($mahasiswa->tambah($_POST)) {
        echo "<div class='alert alert-success'>Data berhasil ditambahkan!</div>";
    } else {
        echo "<div class='alert alert-danger'>Data gagal ditambahkan!</div>";
    }
}

// Proses untuk memperbarui data mahasiswa
if (isset($_POST['update'])) {
    if ($mahasiswa->update($_POST)) {
        echo "<div class='alert alert-success'>Data berhasil diupdate!</div>";
    } else {
        echo "<div class='alert alert-danger'>Data gagal diupdate!</div>";
    }
}

// Proses untuk menghapus data mahasiswa
if (isset($_GET['hapus'])) {
    if ($mahasiswa->hapus($_GET['hapus'])) {
        echo "<div class='alert alert-success'>Data berhasil dihapus!</div>";
    } else {
        echo "<div class='alert alert-danger'>Data gagal dihapus!</div>";
    }
}

// Mengecek apakah pengguna sudah login, jika belum, arahkan ke halaman login
if (!isset($_SESSION['session_username'])) {
    header("Location: index.php");
    exit();
}
$username = $_SESSION['session_username']; // Ambil username dari sesi login

// Ambil semua data mahasiswa untuk ditampilkan
$result = $mahasiswa->getAll();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
    <style>
    body {
      background: linear-gradient(90deg, #FC466B -20%, #3F5EFB 100%);
      padding: 20px;
      color: white;
    }

    .container {
      max-width: 80%;
      margin: auto;
      background: black;
      color: white;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      opacity: 0.7;
    }

    .card {
      background-color: #333;
      color: white;
    }

    .card-header {
      background-color: #444;
    }

    .card-body {
      background-color: #333;
    }

    .modal {
      display: none; 
      position: fixed;
      z-index: 1;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      overflow: auto;
      background-color: rgba(0, 0, 0, 0.7);
      animation: fadeIn 0.3s ease-in-out;
    }

    .modal-content {
      background-color: #2a2a2a;
      color: white;
      margin: 5% auto;
      padding: 20px;
      border: 1px solid #888;
      width: 80%;
      border-radius: 8px;
    }

    .close {
      color: #aaa;
      float: right;
      font-size: 28px;
      font-weight: bold;
      cursor: pointer;
    }

    .logout-bt{
      margin-left: auto;
    }

    .input-group {
      display: flex;
      gap: 1rem;
      align-items: center;
    }

    .form-check {
        display: inline-flex;
        align-items: center;
    }

    .form-check-input {
      margin-right: 5px;
    }
    </style>
</head>
<body>
<h1>Selamat datang di Admin Dashboard, <?php echo $username ?>!</h1>
  <div class="container mt-5">
    <h2 class="text-center mb-4">Manajemen Data Mahasiswa</h2>
    <a href="data_mahasiswa.php" class="btn btn-primary mb-3">Lihat Data Mahasiswa</a>
    <a href="logout.php" class="btn btn-danger mb-3 logout-bt">Logout</a>
    <div class="card">
      <div class="card-header">
        <h3>Tambah Mahasiswa</h3>
      </div>
      <div class="card-body">
      <form method="POST" id="form-mahasiswa">
        <div class="mb-3">
          <label for="nama" class="form-label">Nama Mahasiswa</label>
          <input type="text" name="nama" id="nama" class="form-control">
        </div>
        <div class="mb-3">
          <label for="nim" class="form-label">NIM</label>
          <input type="text" name="nim" id="nim" class="form-control" required>
        </div>
        <div class="mb-3">
          <label for="prodi" class="form-label">Program Studi</label>
          <input type="text" name="prodi" id="prodi" class="form-control" required>
        </div>
        <div class="mb-3">
          <label for="nilai_mutu" class="form-label">Nilai Mutu</label>
          <input type="number" name="nilai_mutu" id="nilai_mutu" class="form-control" step="0.01" required>
        </div>
        <div class="mb-3">
          <label for="semester" class="form-label">Semester</label>
          <select name="semester" id="semester" class="form-select" required>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
            <option value="7">7</option>
            <option value="8">8</option>
          </select>
        </div>
        <div class="mb-3">
          <label class="form-label d-block">Jenis Kelamin:</label>
            <div class="input-group">
                <div class="form-check">
                    <input type="radio" name="jenis_kelamin" id="laki_laki" value="Laki-Laki" class="form-check-input" required>
                    <label for="laki_laki" class="form-check-label">Laki-Laki</label>
                </div>
                <div class="form-check">
                    <input type="radio" name="jenis_kelamin" id="perempuan" value="Perempuan" class="form-check-input" required>
                    <label for="perempuan" class="form-check-label">Perempuan</label>
                </div>
            </div>
        </div>
        <div class="mb-3">
          <label class="form-label d-block">Hobi:</label>
            <div class="input-group">
                <div class="form-check">
                    <input type="checkbox" name="hobi[]" id="membaca" value="Membaca" class="form-check-input">
                    <label for="membaca" class="form-check-label">Membaca</label>
                </div>
                <div class="form-check">
                    <input type="checkbox" name="hobi[]" id="olahraga" value="Olahraga" class="form-check-input">
                    <label for="olahraga" class="form-check-label">Olahraga</label>
                </div>
                <div class="form-check">
                    <input type="checkbox" name="hobi[]" id="memasak" value="Memasak" class="form-check-input">
                    <label for="memasak" class="form-check-label">Memasak</label>
                </div>
            </div>
        </div>
        <div class="mb-3">
          <label for="catatan" class="form-label">Catatan</label>
          <textarea name="catatan" id="catatan" class="form-control" rows="3"></textarea>
        </div>
        <button type="submit" name="tambah" class="btn btn-success">Tambah Mahasiswa</button>
      </form>
      </div>
    </div>

    <div class="card mt-5">
      <div class="card-header">
        <h3>Daftar Mahasiswa</h3>
      </div>
      <div class="card-body">
        <table class="table table-striped table-bordered">
          <thead>
            <tr>
              <th>ID</th>
              <th>Nama Mahasiswa</th>
              <th>NIM</th>
              <th>Program Studi</th>
              <th>Nilai Mutu</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <!-- Menampilkan data ke table -->
            <?php while ($row = $result->fetch_assoc()) { ?>
              <tr>
                <td><?php echo $row['id_mahasiswa']; ?></td>
                <td><?php echo $row['nama']; ?></td>
                <td><?php echo $row['nim']; ?></td>
                <td><?php echo $row['prodi']; ?></td>
                <td><?php echo $row['nilai_mutu']; ?></td>
                <td>
                  <a href="?hapus=<?php echo $row['id_mahasiswa']; ?>" class="btn btn-danger btn-sm">Hapus</a>
                  <button class="btn btn-warning btn-sm openModalBtn" onclick="openModal(<?php echo $row['id_mahasiswa']; ?>, '<?php echo $row['nama']; ?>', '<?php echo $row['nim']; ?>', '<?php echo $row['prodi']; ?>', <?php echo $row['nilai_mutu']; ?>)">Update</button>
                </td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Modal untuk Update Mahasiswa -->
    <div id="editModal" class="modal">
      <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h3>Update Mahasiswa</h3>
        <form method="POST" id="modal-form">
          <input type="hidden" name="id_mahasiswa" id="modal_id">
          <div class="mb-3">
            <label for="modal_nama" class="form-label">Nama Mahasiswa</label>
            <input type="text" name="nama" id="modal_nama" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="modal_nim" class="form-label">NIM</label>
            <input type="text" name="nim" id="modal_nim" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="modal_prodi" class="form-label">Program Studi</label>
            <input type="text" name="prodi" id="modal_prodi" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="modal_nilai_mutu" class="form-label">Nilai Mutu</label>
            <input type="number" name="nilai_mutu" id="modal_nilai_mutu" class="form-control" step="0.01" required>
          </div>
          <div class="mb-3">
          <label for="semester" class="form-label">Semester</label>
          <select name="semester" id="semester" class="form-select" required>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
            <option value="7">7</option>
            <option value="8">8</option>
          </select>
        </div>
        <div class="mb-3">
          <label class="form-label d-block">Jenis Kelamin:</label>
            <div class="input-group">
                <div class="form-check">
                    <input type="radio" name="jenis_kelamin" id="laki_laki" value="Laki-Laki" required>
                    <label for="laki_laki" class="form-check-label">Laki-Laki</label>
                </div>
                <div class="form-check">
                    <input type="radio" name="jenis_kelamin" id="perempuan" value="Perempuan" required>
                    <label for="perempuan" class="form-check-label">Perempuan</label>
                </div>
            </div>
        </div>
        <div class="mb-3">
          <label class="form-label d-block">Hobi:</label>
            <div class="input-group">
                <div class="form-check">
                    <input type="checkbox" name="hobi[]" id="membaca" value="Membaca" class="form-check-input">
                    <label for="membaca" class="form-check-label">Membaca</label>
                </div>
                <div class="form-check">
                    <input type="checkbox" name="hobi[]" id="olahraga" value="Olahraga" class="form-check-input">
                    <label for="olahraga" class="form-check-label">Olahraga</label>
                </div>
                <div class="form-check">
                    <input type="checkbox" name="hobi[]" id="memasak" value="Memasak" class="form-check-input">
                    <label for="memasak" class="form-check-label">Memasak</label>
                </div>
            </div>
        </div>
        <div class="mb-3">
          <label for="catatan" class="form-label">Catatan</label>
          <textarea name="catatan" id="catatan" class="form-control" rows="3" required></textarea>
        </div>
          <button type="submit" name="update" class="btn btn-primary">Update Mahasiswa</button>
        </form>
      </div>
    </div>

  </div>

  <!-- Script untuk modal -->
  <script>
    function openModal(id, nama, nim, prodi, nilai_mutu) {
      document.getElementById('modal_id').value = id;
      document.getElementById('modal_nama').value = nama;
      document.getElementById('modal_nim').value = nim;
      document.getElementById('modal_prodi').value = prodi;
      document.getElementById('modal_nilai_mutu').value = nilai_mutu;
      document.getElementById('editModal').style.display = "block";
    }

    function closeModal() {
      document.getElementById('editModal').style.display = "none";
    }

    // Menutup modal ketika klik di luar modal
    window.onclick = function(event) {
      if (event.target == document.getElementById('editModal')) {
        closeModal();
      }
    }

    document.getElementById('modal-form').addEventListener('submit', function(event) {
      // Ambil semua checkbox dengan name hobi[]
      const checkboxes = document.querySelectorAll('input[name="hobi[]"]:checked');
      
      // Jika tidak ada checkbox yang dicentang, tampilkan peringatan dan batalkan pengiriman formulir
      if (checkboxes.length === 0) {
          alert("Harap pilih setidaknya satu hobi.");
          event.preventDefault(); // Mencegah form untuk disubmit
      }
    });
  </script>
  <script src="validate.js"></script>
</body>
</html>

