<?php
require "../asset/koneksi.php";

$Nama_Lengkap = mysqli_real_escape_string($koneksi, $_POST["Nama_Lengkap"]);
$Username = mysqli_real_escape_string($koneksi, $_POST["Username"]);
$Password = mysqli_real_escape_string($koneksi, $_POST["Password"]);

$sql = "INSERT INTO admin (Nama_Lengkap, Username, Password, Status) 
        VALUES ('$Nama_Lengkap', '$Username', '$Password', 'Admin')";

if(mysqli_query($koneksi, $sql)){
    header("Location: ../management-admin.php");
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($koneksi);
}

mysqli_close($koneksi);
?>
