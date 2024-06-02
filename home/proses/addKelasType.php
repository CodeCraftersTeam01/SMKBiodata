<?php

$nama = $_POST["NamaKelas"];
$kelas = $_POST["Kelas"];
$jurusan = $_POST["Jurusan"];

require "../asset/koneksi.php";
$randomNumber = rand(10, 2000);
$sql = mysqli_query($koneksi, "INSERT INTO kelas (Nama_Tipe_Kelas, Tipe_Kelas, Kelas, Jurusan) Value ('$nama', '$randomNumber', '$kelas', '$jurusan')");
if($sql){
    header("location:../management-kelas.php");
}