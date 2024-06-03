<?php
session_start();

// Periksa otentikasi pengguna
if (!isset($_SESSION['status']) || $_SESSION['status'] !== "login") {
    die("Akses ditolak. Anda harus login terlebih dahulu.");
}

if (isset($_GET['file'])) {
    $file = basename($_GET['file']);
    $filepath = '../Ijasah_Siswa/' . $file;

    if (file_exists($filepath)) {
        if (unlink($filepath)) {
            echo "File berhasil dihapus.";
        } else {
            echo "Terjadi kesalahan saat menghapus file.";
        }
    } else {
        echo "File tidak ditemukan.";
    }
} else {
    echo "Nama file tidak diberikan.";
}

// Redirect kembali ke halaman utama setelah penghapusan
header("Location: ../index.php");
exit();
?>
