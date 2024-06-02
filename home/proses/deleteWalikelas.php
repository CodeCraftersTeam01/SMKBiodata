<?php

$nama = $_GET["ID"];

require "../asset/koneksi.php";
$sql = mysqli_query($koneksi, "DELETE FROM walikelas WHERE ID = '$nama'");
if($sql){
    header("location:../management-walikelas.php");
}