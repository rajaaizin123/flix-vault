<?php
require '../config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validasi email
    if (isset($_POST['email']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        // Simpan email dari form ke sesi
        session_start();
        $_SESSION['email'] = $_POST['email'];
        
        header('Location: register.php');
        exit();
    } else {
        $error = "Silakan masukkan email yang valid!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flix Vault</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .bg-index {
            background-image: url('bg-index.png');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 120vh; 
        }
    </style>
</head>
<body>
    <div class="bg-index">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="#">Flix Vault</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="btn btn-danger" href="login.php" role="button">Masuk</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container-fluid d-flex justify-content-center align-items-center vh-100 text-white">
            <div class="text-center bg-dark p-5 rounded" style="background-color: rgba(0, 0, 0, 0.7); --bs-bg-opacity: .9;">
                <h1>Nak Nonton Film? Serial? Sini Tempatnya.</h1>
                <p>Nonton di manapun, kapanpun... Daftarlah!</p>
                <!-- Form untuk mendapatkan email pengguna -->
                <form action="index.php" method="POST" class="d-flex flex-column align-items-center">
                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php endif; ?>
                    <div class="input-group mb-3">
                        <input type="email" class="form-control" name="email" placeholder="Masukkan Email Anda" required>
                        <button type="submit" class="btn btn-danger">Mulai</button>
                    </div>
                </form>
            </div>
        </div>

        <footer class="bg-dark text-white text-center py-3 mt-5">
            <p>Copyright &copy; 2024 Flix Vault</p>
        </footer>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
