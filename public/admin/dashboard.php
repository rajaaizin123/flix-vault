<?php
session_start();
require '../../config/db.php';

// Jika admin belum login, arahkan ke halaman login
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}

// Mengambil semua data konten
$sql = "SELECT * FROM Konten";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/startbootstrap-sb-admin@7.0.5/css/styles.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .card-stats {
            transition: transform 0.2s ease-in-out;
        }
        .card-stats:hover {
            transform: scale(1.05);
        }
        .dashboard-header {
            color: #343a40;
            font-weight: bold;
            font-size: 2rem;
        }
        .card-header {
            background: linear-gradient(90deg, #ff7eb3, #ff758c);
            color: white;
            font-weight: bold;
        }
    </style>
</head>
<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand ps-3" href="#">Admin Dashboard</a>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <div class="d-flex justify-content-between align-items-center mt-4 mb-4">
                        <h1 class="dashboard-header">Halo, Admin!</h1>
                        <a href="logout.php" class="btn btn-danger">Logout</a>
                    </div>
                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <div class="card card-stats text-white bg-primary">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h5>Total Konten</h5>
                                            <h3><?= $result->num_rows ?></h3>
                                        </div>
                                        <div><i class="fas fa-video fa-3x"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card card-stats text-white bg-success">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h5>Konten Aktif</h5>
                                            <h3><?= $result->num_rows // Ganti dengan query untuk konten aktif ?></h3>
                                        </div>
                                        <div><i class="fas fa-check-circle fa-3x"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card card-stats text-white bg-warning">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h5>Konten Tertunda</h5>
                                            <h3><?= $result->num_rows // Ganti dengan query untuk konten tertunda ?></h3>
                                        </div>
                                        <div><i class="fas fa-clock fa-3x"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Daftar Konten
                        </div>
                        <div class="card-body">
                            <table id="datatablesSimple" class="table table-hover table-bordered">
                                <thead class="table-dark">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Konten</th>
                                        <th>Deskripsi</th>
                                        <th>Jenis Konten</th>
                                        <th>Status Unggah</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($result->num_rows > 0): ?>
                                        <?php $no = 1; ?>
                                        <?php while ($row = $result->fetch_assoc()): ?>
                                            <tr>
                                                <td><?= $no++ ?></td>
                                                <td><?= htmlspecialchars($row['nama_konten']) ?></td>
                                                <td><?= htmlspecialchars($row['deskripsi']) ?></td>
                                                <td><?= htmlspecialchars($row['jenis_konten']) ?></td>
                                                <td><?= htmlspecialchars($row['status_unggah']) ?></td>
                                                <td>
                                                    <a href="edit.php?id=<?= $row['id_konten'] ?>" class="btn btn-warning btn-sm">Edit</a>
                                                    <a href="hapus.php?id=<?= $row['id_konten'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus konten ini?')">Hapus</a>
                                                </td>
                                            </tr>
                                        <?php endwhile; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="6" class="text-center">Belum ada konten.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">&copy; 2024 Flix Vault</div>
                        <div>
                            <a href="#">Privacy Policy</a>
                            &middot;
                            <a href="#">Terms &amp; Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/simple-datatables.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const dataTable = new simpleDatatables.DataTable("#datatablesSimple");
        });
    </script>
</body>
</html>
