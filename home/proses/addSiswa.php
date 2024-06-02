<?php
require "../asset/koneksi.php";

$NISN = mysqli_real_escape_string($koneksi, $_POST["NISN"]);
$Nama_Lengkap = mysqli_real_escape_string($koneksi, $_POST["Nama_Lengkap"]);
$Username = mysqli_real_escape_string($koneksi, $_POST["Username"]);
$Password = mysqli_real_escape_string($koneksi, $_POST["Password"]);
$Jurusan = mysqli_real_escape_string($koneksi, $_POST["Jurusan"]);
$Kelas = mysqli_real_escape_string($koneksi, $_POST["Kelas"]);
$Tipe_Kelas = mysqli_real_escape_string($koneksi, $_POST["Tipe_Kelas"]);

$sql = "INSERT INTO `biodata_siswa` (`ID`, `username`, `password`, `status`, `Nama_Lengkap`, `Tempat_Lahir`, `Tanggal_Lahir`, `Jenis_Kelamin`, `No_Induk_Siswa`, `NISN`, `NIK`, `No_Hp`, `Alamat`, `Anak_Ke`, `Kelas`, `Kelas_Type`, `Jurusan`, `Tahun_Masuk`, `Tahun_Lulus`, `No_Seri_Ijazah`, `SMP`, `Nama_Ayah`, `Lulusan_Ayah`, `Pekerjaan_Ayah`, `Nama_Ibu`, `Lulusan_Ibu`, `Pekerjaan_Ibu`, `Foto`, `ID_Walikelas`) 
        VALUES (NULL, '$Username', '$Password', 'Siswa', '$Nama_Lengkap', '', '', '', '', '$NISN', '', '', '', '', '$Kelas', '$Tipe_Kelas', '$Jurusan', '', '', '', '', '', '', '', '', '', '', 'images.png', NULL)";

if(mysqli_query($koneksi, $sql)){
    header("Location: ../management-siswa.php");
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($koneksi);
}
?>
