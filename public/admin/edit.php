<?php
session_start();
require '../../config/db.php';

// Jika admin belum login, arahkan ke halaman login
if (!isset($_SESSION['admin'])) {
    header('Location: ../login.php');
    exit();
}

$error = "";
$success = "";

if (isset($_GET['id'])) {
    $id_konten = $_GET['id'];

    // Ambil data konten yang akan diedit
    $sql = "SELECT * FROM Konten WHERE id_konten = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_konten);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Proses edit konten
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_content'])) {
            $nama_konten = trim($_POST['nama_konten']);
            $deskripsi = trim($_POST['deskripsi']);
            $jenis_konten = $_POST['jenis_konten'];
            $status_unggah = $_POST['status_unggah'];

            // Validasi input
            if (empty($nama_konten) || empty($deskripsi) || empty($jenis_konten) || empty($status_unggah)) {
                $error = "Semua kolom harus diisi!";
            } else {
                // Update data ke database
                $sql = "UPDATE Konten SET nama_konten = ?, deskripsi = ?, jenis_konten = ?, status_unggah = ? WHERE id_konten = ?";
                $stmt = $conn->prepare($sql);

                if ($stmt) {
                    $stmt->bind_param("ssssi", $nama_konten, $deskripsi, $jenis_konten, $status_unggah, $id_konten);
                    if ($stmt->execute()) {
                        $success = "Konten berhasil diperbarui!";
                    } else {
                        $error = "Terjadi kesalahan saat memperbarui konten.";
                    }
                    $stmt->close();
                } else {
                    $error = "Terjadi kesalahan dalam koneksi database.";
                }
            }
        }
    } else {
        header('Location: dashboard.php');
        exit();
    }
} else {
    header('Location: dashboard.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Konten</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center">Edit Konten</h2>

    <!-- Pesan error atau sukses -->
    <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php elseif ($success): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <!-- Form untuk mengedit konten -->
    <form action="" method="POST">
        <div class="mb-3">
            <label for="nama_konten" class="form-label">Nama Konten</label>
            <input type="text" name="nama_konten" class="form-control" value="<?= htmlspecialchars($row['nama_konten']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="deskripsi" class="form-label">Deskripsi</label>
            <textarea name="deskripsi" class="form-control" rows="4" required><?= htmlspecialchars($row['deskripsi']) ?></textarea>
        </div>
        <div class="mb-3">
            <label for="jenis_konten" class="form-label">Jenis Konten</label>
            <select name="jenis_konten" class="form-control" required>
                <option value="film" <?= $row['jenis_konten'] == 'film' ? 'selected' : '' ?>>Film</option>
                <option value="serial" <?= $row['jenis_konten'] == 'serial' ? 'selected' : '' ?>>Serial</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="status_unggah" class="form-label">Status Unggah</label>
            <select name="status_unggah" class="form-control" required>
                <option value="unggah" <?= $row['status_unggah'] == 'unggah' ? 'selected' : '' ?>>Unggah</option>
                <option value="belum_unggah" <?= $row['status_unggah'] == 'belum_unggah' ? 'selected' : '' ?>>Belum Unggah</option>
            </select>
        </div>
        <button type="submit" name="edit_content" class="btn btn-primary">Perbarui Konten</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
