<?php
session_start();

// Periksa otentikasi pengguna
if (!isset($_SESSION['status']) || $_SESSION['status'] !== "login") {
    die("Akses ditolak. Anda harus login terlebih dahulu.");
}

if (isset($_GET['file'])) {
    $file = basename($_GET['file']);
    $filepath = 'skl/' . $file;

    if (file_exists($filepath)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($filepath) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filepath));
        readfile($filepath);
        exit;
    } else {
        echo "File tidak ditemukan.";
    }
} else {
    echo "Nama file tidak diberikan.";
}
?>
