<?php
session_start();
require '../config/db.php';

$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username_admin']);
    $password = trim($_POST['password_admin']);

    $sql = "SELECT * FROM Admin WHERE username_admin = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            // Compare the plain password directly
            if ($password == $row['password_admin']) {
                $_SESSION['admin'] = $row['id_admin'];
                $_SESSION['username_admin'] = $row['username_admin'];
                header('Location: admin/dashboard.php');
                exit();
            } else {
                $error = "Password salah!";
            }
        } else {
            $error = "Username tidak ditemukan!";
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
    <title>Admin Login</title>
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
            color: #343a40;
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
            <h3 class="mb-0">Kamu admin ?</h3>
        </div>
        <div class="card-body">
            <?php if ($error): ?>
                <div class="alert alert-danger text-center"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            <form action="" method="POST">
                <div class="form-floating mb-4">
                    <input type="text" name="username_admin" class="form-control" placeholder="Username" required>
                    <label for="floatingInput" class="form-label">Username</label>
                </div>
                <div class="form-floating mb-4">
                    <input type="password" name="password_admin" class="form-control" placeholder="Masukkan password Anda" required>
                    <label for="password_admin floatingPassword" class="form-label">Password</label>
                </div>
                <button type="submit" class="btn btn-danger w-100 py-2">Punten mbah admin</button>
            </form>
        </div>
        <div class="card-footer text-muted">
            <p>Bukan admin ? <a href="../index.php">Balek balek</a></p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
