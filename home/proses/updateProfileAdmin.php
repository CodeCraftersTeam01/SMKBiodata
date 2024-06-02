<?php 
require "../asset/koneksi.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $nama_lengkap = $_POST['Nama_lengkap'];
    $username = $_POST['Username'];
    $password = $_POST['Password'];
    $kepsek = $_POST['Kepsek'];

    // Proses file upload untuk Foto
    $foto = $_FILES['Foto']['name'];
    $foto_tmp = $_FILES['Foto']['tmp_name'];
    $upload_dir = 'uploads/'; // Direktori upload
    $target_file = $upload_dir . basename($foto);

    // Pindahkan file ke direktori tujuan
    if (move_uploaded_file($foto_tmp, $target_file)) {
        // File berhasil diupload, lanjutkan ke database
        $sqlUpdateAdmin = "UPDATE admin SET Nama_Lengkap='$nama_lengkap', Username='$username', Password='$password', Foto='$target_file' WHERE Username='$username'";
    } else {
        // Jika tidak ada foto yang diupload, tetap update data selain foto
        $sqlUpdateAdmin = "UPDATE admin SET Nama_Lengkap='$nama_lengkap', Username='$username', Password='$password' WHERE Username='$username'";
    }

    // Jalankan query update
    if (mysqli_query($koneksi, $sqlUpdateAdmin)) {
        echo "Data admin berhasil diperbarui.";
        header("location:../profile.php");
    } else {
        echo "Error: " . $sqlUpdateAdmin . "<br>" . mysqli_error($koneksi);
    }

    // Simpan nilai Kepsek ke dalam file
    $kepsek_file = 'kepsek.txt';
    file_put_contents($kepsek_file, $kepsek);
}