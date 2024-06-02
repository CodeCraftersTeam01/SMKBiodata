<?php
session_start();
include "../call_packages.php"; 
// Baca tanggal dari file
$tanggal = trim(file_get_contents("proses/tanggal.txt"));
$tanggalEnd = trim(file_get_contents("proses/tanggalEnd.txt"));

// Dapatkan tanggal sekarang
$tanggalSekarang = date("Y-m-d");

// Cek apakah tanggal sekarang berada dalam rentang yang diizinkan
if ($tanggalSekarang < $tanggal || $tanggalSekarang > $tanggalEnd) {
    // Jika tanggal sekarang tidak sesuai, redirect ke halaman lain atau tampilkan pesan error
    header("Location: index.php");
    exit();
}
?>
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
        $sql = "SELECT biodata_siswa.NISN, biodata_siswa.NIK, biodata_siswa.No_Induk_Siswa, biodata_siswa.Nama_Lengkap as Nama_Lengkap, biodata_siswa.status, biodata_siswa.Kelas, biodata_siswa.Jurusan, walikelas.Nama_Lengkap as Nama_Walikelas, kelas.Nama_Tipe_Kelas AS Kelas_Type, biodata_siswa.Foto 
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

    $sqlKelulusan = "SELECT * FROM kelulusan_siswa WHERE Username = '$username'";
    $queryKelulusan = mysqli_query($koneksi, $sqlKelulusan);
    $checkKelulusan = mysqli_num_rows($queryKelulusan);
    ?>
    <!-- Konten -->
    <div id='content' class='content' style="opacity:0%;transition:1s all;">
        <h2 class="h2">Check Kelulusan</h2>
        <input type="text" id="status" hidden value='<?php echo $dash["status"]; ?>'>
        <div class="card" id="statusKelulusan">
            <div class="row">
                <div class="col-sm-9">
                    <div id="textKelulusan">
                        <?php
                        if ($checkKelulusan > 0) {
                            echo "<h3><b>SELAMAT ANDA DINYATAKAN LULUS</b></h3>
                            <script>document.getElementById('statusKelulusan').style.color = 'white'</script>
                            <script>document.getElementById('statusKelulusan').style.background = 'linear-gradient(90deg,#005c4b,#22bf76)'</script>
                            ";
                        } else {
                            echo "<h3><b>MAAF ANDA BELUM DINYATAKAN LULUS</b></h3>
                            <script>document.getElementById('statusKelulusan').style.background = 'linear-gradient(90deg, darkred, red)'</script>
                            <script>document.getElementById('statusKelulusan').style.color = 'white'
                            </script>
                            ";
                        }
                        ?>
                    </div>
                </div>
                <div class="col-sm">
                    <center>
                        <img class='imageprofil' style="border-radius: 0px;border:0px;width:150px;" src="asset/image/smk.png" alt="">
                    </center>
                </div>
            </div>
        </div><br>
        <div class="row" style="z-index:10;position:relative;background:#ffffff90;padding:10px;backdrop-filter:blur(10px);">
            <div class="col-sm" style="font-family:Arial, Helvetica, sans-serif;">
                <small style="font-size:11px;position:relative;top:5px;"><b>NISN : <?php echo $dash["NISN"] ?></b></small>
                <h2 style="font-family:Arial Black, Helvetica, sans-serif"><b><?php echo $dash["Nama_Lengkap"] ?></b></h2>
                <h5 style="position:relative;top:-10px;font-weight:bold;">12 <?php echo $dash["Kelas_Type"] ?></h5>
                <div class="row">
                    <div class="col-sm">
                        <h5><b>Jurusan</b></h5>
                        <p><?php echo $dash["Jurusan"] ?></p>
                    </div>
                    <div class="col-sm">
                        <h5><b>Walikelas</b></h5>
                        <p><?php echo $dash["Nama_Walikelas"] ?></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <h5><b>NIS</b></h5>
                        <p><?php echo $dash["No_Induk_Siswa"] ?></p>
                    </div>
                    <div class="col">
                        <h5><b>NIK</b></h5>
                        <p><?php echo $dash["NIK"] ?></p>
                    </div>
                </div>
                <div class="card" style="padding:10px;">
                    <h5><b>" Pesan</b></h5>
                    <p> "Selamat atas kelulusanmu! Ini adalah awal dari perjalanan baru yang penuh peluang. Teruslah berusaha dan kejar impianmu!,
                        Dan untuk yang tidak LULUS Jangan menyerah! Kegagalan adalah langkah menuju sukses. Belajarlah dari pengalaman ini dan bangkit lebih kuat. Masa depan masih penuh peluang.
                    </p>
                </div>
            </div>
            <div class="col-sm-4">
                <center>
                    <div class="card" style="padding:10px;">
                        <img class='imageprofil' style="border-radius: 0px;border:0px;width:100%;" src='image_siswa/<?php echo $dash["Foto"] ?>' alt="">
                    </div>
                </center>
            </div>
        </div>
    </div>
    <?php include "footer.php" ?>
    <script>
        Swal.fire({
            title: "Check Kelulusan Anda?",
            text: "Apakah Anda Ingin Melanjutkan Pengechekan?",
            icon: "question",
            allowOutsideClick: false,
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Lanjutkan!"
        }).then((result) => {
            if (result.isConfirmed) {
                let timerInterval;
                Swal.fire({
                    title: "Checking Data",
                    html: "Please Wait For Your Data Estiminate : <b></b> milliseconds.",
                    timer: 1000,
                    allowOutsideClick: false,
                    timerProgressBar: true,
                    didOpen: () => {
                        Swal.showLoading();
                        const timer = Swal.getPopup().querySelector("b");
                        timerInterval = setInterval(() => {
                            timer.textContent = `${Swal.getTimerLeft()}`;
                        }, 100);
                    },
                    willClose: () => {
                        clearInterval(timerInterval);
                    }
                }).then((result) => {
                    /* Read more about handling dismissals below */
                    if (result.dismiss === Swal.DismissReason.timer) {
                        console.log("I was closed by the timer");
                    }
                });
                setTimeout(() => {
                    document.getElementById("content").style.opacity = "100%"
                }, 1000);
            } else if (
                /* Read more about handling dismissals below */
                result.dismiss === Swal.DismissReason.cancel
            ) {
                window.location.href = "index.php";
            }
        });
    </script>
    <script src="js/script.js"></script>
    <script>
    </script>
</body>

</html>