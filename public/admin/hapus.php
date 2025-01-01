<?php
session_start();
require '../../config/db.php';

// Jika admin belum login, arahkan ke halaman login
if (!isset($_SESSION['admin'])) {
    header('Location: ../login.php');
    exit();
}

if (isset($_GET['id'])) {
    $id_konten = $_GET['id'];

    // Hapus data konten
    $sql = "DELETE FROM Konten WHERE id_konten = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_konten);

    if ($stmt->execute()) {
        // Setelah konten dihapus, redirect ke dashboard
        header('Location: dashboard.php');
        exit();
    } else {
        // Jika terjadi kesalahan
        echo "Terjadi kesalahan saat menghapus konten.";
    }
}
?>
