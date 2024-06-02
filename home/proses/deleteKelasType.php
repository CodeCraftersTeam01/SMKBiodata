<?php

$nama = $_GET["kelas"];

require "../asset/koneksi.php";
$sql = mysqli_query($koneksi, "DELETE FROM kelas WHERE Tipe_Kelas = '$nama'");
if($sql){
    header("location:../management-kelas.php");
}