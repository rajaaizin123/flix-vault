<?php
session_start();
require '../config/db.php';

$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['nama_pelanggan']);
    $password = trim($_POST['password_pelanggan']);

    $sql = "SELECT * FROM Pelanggan WHERE nama_pelanggan = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['password_pelanggan'])) {
                $_SESSION['id_pelanggan'] = $row['id_pelanggan'];
                $_SESSION['nama_pelanggan'] = $row['nama_pelanggan'];
                header('Location: user/home.php');
                exit();
            } else {
                $error = "Password salah!";
            }
        } else {
            $error = "Username salah!";
        }
        $stmt->close();
    } else {
        $error = "Terjadi kesalahan. Silakan coba lagi.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
            background-color: white;
            color: black;
            text-align: center;
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
        }

        .form-control {
            border-radius: 10px;
        }
        .text-muted a {
            color: #007bff;
            text-decoration: none;
        }

        .text-muted a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="card p-4" style="width: 100%; max-width: 400px;">
        <div class="card-header">
            <h3 class="mb-0">Login ...</h3>
        </div>
        <div class="card-body">
            <?php if ($error): ?>
                <div class="alert alert-danger text-center"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            <form action="" method="POST">
                <div class="form-floating mb-4">
                    <input type="text" name="nama_pelanggan" class="form-control" placeholder="Username" required>
                    <label for="floatingInput" class="form-label">Username</label>
                </div>
                <div class="form-floating">
                    <input type="password" name="password_pelanggan" class="form-control" placeholder="Masukkan password Anda" required>
                    <label for="password_pelanggan floatingPassword" class="form-label">Password</label>
                </div>
                <button type="submit" class="btn btn-danger w-100 mt-4 py-2">Login? Gasss</button>
            </form>
        </div>
        <div class="card-footer text-muted">
            <p>Telupa akun? <a href="index.php">Daftar ulang</a></p>
            <p>Apakah kamu admin? <a href="login_admin.php">Masuk di sini</a></p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
