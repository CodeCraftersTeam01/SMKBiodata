<?php
require "../asset/koneksi.php";

$Nama_Lengkap = mysqli_real_escape_string($koneksi, $_POST["Nama_Lengkap"]);
$Username = mysqli_real_escape_string($koneksi, $_POST["Username"]);
$Password = mysqli_real_escape_string($koneksi, $_POST["Password"]);
$Jurusan = mysqli_real_escape_string($koneksi, $_POST["Jurusan"]);
$Kelas = mysqli_real_escape_string($koneksi, $_POST["Kelas"]);
$Tipe_Kelas = mysqli_real_escape_string($koneksi, $_POST["Tipe_Kelas"]);

$sql = "INSERT INTO walikelas (Nama_Lengkap, Username, Password, Jurusan, Status, Kelas, Tipe_Kelas) 
        VALUES ('$Nama_Lengkap', '$Username', '$Password', '$Jurusan', 'Walikelas', '$Kelas', '$Tipe_Kelas')";

if(mysqli_query($koneksi, $sql)){
    header("Location: ../management-walikelas.php");
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($koneksi);
}

mysqli_close($koneksi);
?>
