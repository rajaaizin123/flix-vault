<?php
session_start();
require '../../config/db.php';

// Jika admin belum login, arahkan ke halaman login
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}

$error = "";
$success = "";

// Proses jika form ditambah
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_content'])) {
    $nama_konten = trim($_POST['nama_konten']);
    $deskripsi = trim($_POST['deskripsi']);
    $jenis_konten = $_POST['jenis_konten'];
    $status_unggah = $_POST['status_unggah'];

    // Validasi input
    if (empty($nama_konten) || empty($deskripsi) || empty($jenis_konten) || empty($status_unggah)) {
        $error = "Semua kolom harus diisi!";
    } else {
        // Menyimpan data ke database
        $sql = "INSERT INTO Konten (nama_konten, deskripsi, jenis_konten, status_unggah) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("ssss", $nama_konten, $deskripsi, $jenis_konten, $status_unggah);
            if ($stmt->execute()) {
                $success = "Konten berhasil ditambahkan!";
            } else {
                $error = "Terjadi kesalahan, coba lagi.";
            }
            $stmt->close();
        } else {
            $error = "Terjadi kesalahan dalam koneksi database.";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Konten</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center">Tambah Konten</h2>

    <!-- Pesan error atau sukses -->
    <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php elseif ($success): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <!-- Form untuk menambah konten -->
    <form action="" method="POST">
        <div class="mb-3">
            <label for="nama_konten" class="form-label">Nama Konten</label>
            <input type="text" name="nama_konten" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="deskripsi" class="form-label">Deskripsi</label>
            <textarea name="deskripsi" class="form-control" rows="4" required></textarea>
        </div>
        <div class="mb-3">
            <label for="jenis_konten" class="form-label">Jenis Konten</label>
            <select name="jenis_konten" class="form-control" required>
                <option value="">Pilih Jenis Konten</option>
                <option value="film">Film</option>
                <option value="serial">Serial</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="status_unggah" class="form-label">Status Unggah</label>
            <select name="status_unggah" class="form-control" required>
                <option value="">Pilih Status Unggah</option>
                <option value="unggah">Unggah</option>
                <option value="belum_unggah">Belum Unggah</option>
            </select>
        </div>
        <button type="submit" name="add_content" class="btn btn-primary">Tambah Konten</button>
    </form>
    <br>
    <a href="dashboard.php" class="btn btn-secondary">Kembali ke Dashboard</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
