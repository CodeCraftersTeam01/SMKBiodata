<?php

$ID = $_GET["ID"];
$Nama_Lengkap = $_POST["Nama_Lengkap"];
$Username = $_POST["Username"];
$Password = $_POST["Password"];
$Jurusan = $_POST["Jurusan"];
$Kelas = $_POST["Kelas"];
$Tipe_Kelas = $_POST["Tipe_Kelas"];

require "../asset/koneksi.php";
$sql = mysqli_query($koneksi, "UPDATE walikelas SET Nama_Lengkap = '$Nama_Lengkap', Kelas = '$Kelas', Tipe_Kelas='$Tipe_Kelas', Jurusan = '$Jurusan', Username='$Username', Password = '$Password' WHERE ID = '$ID'");
if($sql){
    header("location:../management-walikelas.php");
}