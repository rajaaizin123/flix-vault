<?php
require '../config/db.php';
session_start();

$error = ""; // Variabel untuk pesan error

// Pastikan email dari sesi login tersedia
if (!isset($_SESSION['email'])) {
    header('Location: index.php');
    exit();
}

$email = $_SESSION['email']; // Ambil email dari sesi

// Proses registrasi jika form dikirim
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = trim($_POST['nama_pelanggan']);
    $password = trim($_POST['password_pelanggan']);

    // Validasi input
    if (!empty($nama) && !empty($password)) {
        $password_hashed = password_hash($password, PASSWORD_BCRYPT);

        $sql = "INSERT INTO Pelanggan (nama_pelanggan, email_pelanggan, password_pelanggan) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("sss", $nama, $email, $password_hashed);
            if ($stmt->execute()) {
                header('Location: login.php'); // Redirect ke halaman login
                exit();
            } else {
                $error = "Gagal mendaftarkan akun. Silakan coba lagi.";
            }
            $stmt->close();
        } else {
            $error = "Terjadi kesalahan pada server.";
        }
    } else {
        $error = "Semua kolom harus diisi.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background-color: #007bff;
            color: #fff;
            text-align: center;
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
        }

        .form-control {
            border-radius: 10px;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            border-radius: 10px;
            padding: 10px;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="card p-4" style="width: 100%; max-width: 400px;">
        <div class="card-header">
            <h3 class="mb-0">Register</h3>
        </div>
        <div class="card-body">
            <?php if ($error): ?>
                <div class="alert alert-danger text-center"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            <form action="" method="POST">
                <div class="mb-3">
                    <label for="nama_pelanggan" class="form-label">Username</label>
                    <input type="text" name="nama_pelanggan" class="form-control" placeholder="Masukkan username Anda" required>
                </div>
                <div class="mb-3">
                    <label for="password_pelanggan" class="form-label">Password</label>
                    <input type="password" name="password_pelanggan" class="form-control" placeholder="Masukkan password Anda" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Register</button>
            </form>
        </div>
        <div class="card-footer text-center text-muted">
            <p>Sudah punya akun? <a href="login.php">Login di sini</a></p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
