<?php

$nama = $_GET["NISN"];

require "../asset/koneksi.php";

// Menggunakan perintah UPDATE untuk mengubah status siswa menjadi "Mutasi"
$sql = mysqli_query($koneksi, "UPDATE biodata_siswa SET status = 'None', Kelas = '99' WHERE NISN = '$nama'");

if($sql){
    header("location:../management-siswa.php");
} else {
    // Menangani kesalahan jika query gagal
    echo "Error updating record: " . mysqli_error($koneksi);
}

?>
