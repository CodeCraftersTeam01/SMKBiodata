<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil nilai start_time dan end_time dari form
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];

    // Simpan start_time ke file tanggal.txt
    file_put_contents('tanggal.txt', $start_time);

    // Simpan end_time ke file tanggalEnd.txt
    file_put_contents('tanggalEnd.txt', $end_time);

    // Redirect ke halaman yang sesuai setelah penyimpanan
    header("Location: ../index.php");
    exit();
}
?>