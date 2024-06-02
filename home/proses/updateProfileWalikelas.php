<?php
session_start();
include "../call_packages.php";
require "../asset/koneksi.php";

$username = $_SESSION["username"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil nilai yang dikirimkan melalui form
    $nama_lengkap = $_POST['Nama_lengkap'];
    $username = $_POST['Username'];
    $password = $_POST['Password'];
    $jurusan = $_POST['Jurusan'];
    $kelas = $_POST['Kelas'];
    $kelas_type = $_POST['Kelas_Type'];

    // Proses upload foto jika ada
    if ($_FILES['Foto']['error'] === 0) {
        // Ambil info file foto
        $foto_name = $_FILES['Foto']['name'];
        $foto_temp = $_FILES['Foto']['tmp_name'];
        $foto_type = $_FILES['Foto']['type'];

        // Direktori penyimpanan foto
        $target_dir = "../path/to/your/upload/directory/";
        $target_file = $target_dir . basename($foto_name);

        // Cek apakah file yang diupload adalah gambar
        $allowed_types = array('image/jpeg', 'image/png', 'image/gif');
        if (in_array($foto_type, $allowed_types)) {
            // Pindahkan file foto ke direktori yang ditentukan
            move_uploaded_file($foto_temp, $target_file);
        } else {
            echo "Tipe file yang diupload tidak didukung.";
            exit; // Keluar dari skrip jika tipe file tidak didukung
        }
    }

    // Lakukan query update ke database
    $sql = "UPDATE walikelas SET 
                Nama_Lengkap = '$nama_lengkap', 
                Username = '$username', 
                Password = '$password', 
                Jurusan = '$jurusan', 
                Kelas = '$kelas', 
                Tipe_Kelas = '$kelas_type'";
    
    // Tambahkan kondisi untuk foto jika diunggah
    if (isset($foto_name)) {
        $sql .= ", Foto = '$foto_name'";
    }

    $sql .= " WHERE Username = '$username'";

    $result = mysqli_query($koneksi, $sql);

    if ($result) {
        // Jika update berhasil, redirect ke halaman profil atau halaman lain yang sesuai
        header("Location: ../profile.php");
        exit;
    } else {
        echo "Terjadi kesalahan saat melakukan update.";
    }
}
?>
