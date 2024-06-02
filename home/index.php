<?php
session_start();
include "../call_packages.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Biodata Siswa SMKN 1 Sumenep | Home</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="../asset/image/smk.png" type="image/x-icon">
</head>

<body style="overflow-x: hidden; background:#fafdfb;">
    <?php include "head.php"; ?>
    <?php
    require "../asset/koneksi.php";
    $username = $_SESSION["username"];
    $sql = "SELECT * FROM admin WHERE Username = '$username' ";
    $query = mysqli_query($koneksi, $sql);
    $dash = mysqli_fetch_array($query);
    $check = mysqli_num_rows($query);
    if ($check == 0) {
        $sql = "SELECT biodata_siswa.Nama_Lengkap as Nama_Lengkap, biodata_siswa.status, biodata_siswa.Kelas, biodata_siswa.Jurusan, walikelas.Nama_Lengkap as Nama_Walikelas, kelas.Nama_Tipe_Kelas AS Kelas_Type, biodata_siswa.Foto 
                FROM biodata_siswa 
                INNER JOIN walikelas ON biodata_siswa.ID_Walikelas = walikelas.ID 
                INNER JOIN kelas ON biodata_siswa.Kelas_type = kelas.Tipe_Kelas 
                WHERE biodata_siswa.Username = '$username' ";
        $query = mysqli_query($koneksi, $sql);
        $dash = mysqli_fetch_array($query);
        $check = mysqli_num_rows($query);
        if ($check == 0) {
            $sql = "SELECT walikelas.Nama_Lengkap, walikelas.Jurusan AS Kelas, walikelas.status, walikelas.Jurusan, walikelas.Kelas AS Nama_Walikelas, kelas.Nama_Tipe_Kelas AS Kelas_Type, walikelas.Foto 
                    FROM walikelas 
                    INNER JOIN kelas ON walikelas.Tipe_Kelas = kelas.Tipe_Kelas 
                    WHERE walikelas.Username = '$username' ";
            $query = mysqli_query($koneksi, $sql);
            $dash = mysqli_fetch_array($query);
        }
    }
    ?>
    <!-- Konten -->
    <div id='content' class='content'>
        <h2 class="h2">Dashboard</h2>
        <div class='row'>
            <div class='col-lg'>
                <div class='card'>
                    <center>
                        <input type="text" id="status" hidden value='<?php echo $dash["status"]; ?>'>
                        <input type="text" id="Kelasval" hidden value='<?php echo $dash["Nama_Walikelas"]; ?>'>
                        <input type="text" id="Kelas_Typeval" hidden value='<?php echo $dash["Kelas_Type"]; ?>'>
                        <img src='image_siswa/<?php echo $dash["Foto"] ?>' class='imageprofil' alt=''>
                        <h2 class='name'><b><?php echo $dash["Nama_Lengkap"] ?></b></h2>
                        <text class='kelas' id="kelas"> <text id="kelasSiswa"><?php echo $dash["Kelas"] ?></text> <text id="Kelas_Tipe"><?php echo $dash["Kelas_Type"] ?></text></text>
                    </center>
                </div>
            </div>
            <div class='col-lg-4'>
                <div class='card' style='margin-top:10px;'>
                    <div class='row'>
                        <div class='col-4'>
                            <h1 class='icon-card'><ion-icon name='home'></ion-icon></h1>
                        </div>
                        <div class='col'>
                            <h3 class='jurusan-title'>Jurusan</h3>
                            <p class='jurusan-text' id="jurusan"><?php echo $dash["Jurusan"] ?></p>
                        </div>
                    </div>
                </div>
                <div class='card' style='margin-top:10px'>
                    <div class='row'>
                        <div class='col-4'>
                            <h1 class='icon-card'><ion-icon name='person-circle'></ion-icon></h1>
                        </div>
                        <div class='col'>
                            <h3 class='walikelas-title' id="walikelastitle">Wali Kelas</h3>
                            <p class='walikelas-text' id="walikelas"><?php echo $dash["Nama_Walikelas"] ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include "footer.php" ?>
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            }
        });
        Toast.fire({
            icon: "success",
            html: "Welcome <b><?php echo $dash["Nama_Lengkap"]; ?></b>"
        });
        if (document.getElementById("kelasSiswa").textContent == "0") {
            document.getElementById("kelasSiswa").innerText = "Lulus";
        } else if (document.getElementById("kelasSiswa").textContent == "99") {
            document.getElementById("kelasSiswa").innerText = "None";
        }
    </script>
    <script src="js/script.js"></script>
    <script>
    </script>
</body>

</html>
