<?php
$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'uas';

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$items_per_page = 10;

if (isset($_GET['page'])) {
    $page = (int)$_GET['page'];
} else {
    $page = 1;
}

$offset = ($page - 1) * $items_per_page;

$sql = "SELECT * FROM mahasiswa ORDER BY nim ASC LIMIT $offset, $items_per_page";
$result = $conn->query($sql);

$sql_count = "SELECT COUNT(*) AS total FROM mahasiswa";
$count_result = $conn->query($sql_count);
$total_rows = $count_result->fetch_assoc()['total'];
$total_pages = ceil($total_rows / $items_per_page);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Mahasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(90deg, #00C9FF 0%, #92FE9D 100%);
            padding: 20px;
        }
        .container {
            max-width: 90%;
            margin: auto;
            background: black;
            color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            opacity: 0.7;
        }
        .page-link {
            background-color: black;
        }
        tr, td {
            color: white;
        }
    </style>
</head>
<body>

<div class="container my-5">
    <h1 class="text-center mb-4">Daftar Mahasiswa</h1>
    <a href="dashboard.php" class="btn btn-primary mb-3">Edit Data Mahasiswa</a>
    <table class="table table-bordered text-center">
        <thead class="table-dark">
            <tr>
                <th>Nama</th>
                <th>NIM</th>
                <th>Prodi</th>
                <th>Nilai Mutu</th>
                <th>Browser</th>
                <th>IP Address</th>
                <th>Semester</th>
                <th>Jenis Kelamin</th>
                <th>Hobi</th>
                <th>Catatan</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['nama']}</td>
                            <td>{$row['nim']}</td>
                            <td>{$row['prodi']}</td>
                            <td>" . number_format($row['nilai_mutu'], 2, ',', '.') . "</td>
                            <td>{$row['browser']}</td>
                            <td>{$row['ip_address']}</td>
                            <td>{$row['semester']}</td>
                            <td>{$row['jenis_kelamin']}</td>
                            <td>{$row['hobi']}</td>
                            <td>{$row['catatan']}</td>
                          </tr>";
                }
                $remaining_rows = 10 - $result->num_rows;
                for ($i = 0; $i < $remaining_rows; $i++) {
                    echo "<tr>
                            <td>‎ </td>
                            <td>‎ </td>
                            <td>‎ </td>
                            <td>‎ </td>
                            <td>‎ </td>
                            <td>‎ </td>
                            <td>‎ </td>
                            <td>‎ </td>
                            <td>‎ </td>
                            <td>‎ </td>
                          <tr>";
                }
            } else {
                echo "<tr><td colspan='10'>Tidak ada data ditemukan</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <?php if ($total_pages > 1): ?>
        <nav>
            <ul class="pagination justify-content-center">
                <?php if ($page > 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?= $page - 1 ?>">Sebelumnya</a>
                    </li>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                        <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>

                <?php if ($page < $total_pages): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?= $page + 1 ?>">Selanjutnya</a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
