<?php

$nama = $_GET["ID"];

require "../asset/koneksi.php";
$sql = mysqli_query($koneksi, "DELETE FROM admin WHERE ID = '$nama'");
if($sql){
    header("location:../management-admin.php");
}