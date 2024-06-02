<?php
session_start();
include "../call_packages.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Biodata Siswa SMKN 1 Sumenep | Home</title>
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

    <!-- Content -->
    <div id='content' class='content'>
        <h2 class="h2">Edit Profile</h2>
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
        <hr>
        <div class="card" id="card" style="padding:10px;">
            <h4><b>Your Profile</b></h4>
            <form action="proses/updateProfile.php" id="changeProfileSiswa" method="post" enctype="multipart/form-data">
                <?php
                $sqlcheckProfile = "SELECT * FROM biodata_siswa INNER JOIN kelas ON biodata_siswa.Kelas_Type=kelas.Tipe_Kelas WHERE username = '$username'";
                $queryCheckProfile = mysqli_query($koneksi, $sqlcheckProfile);
                $dashCheckProfile = mysqli_fetch_array($queryCheckProfile);
                ?>
                <label required for="" class="label-control">Nama Lengkap</label>
                <input type="text" name="Nama_lengkap" value="<?php echo $dashCheckProfile['Nama_Lengkap'] ?>" class="form-control">
                <label required for="" class="label-control">Username</label>
                <input type="text" name="Username" class="form-control" value="<?php echo $dashCheckProfile['username'] ?>">
                <label required for="" class="label-control">Password</label>
                <input type="password" name="Password" value="<?php echo $dashCheckProfile['password'] ?>" class="form-control">
                <label for="" class="label-control">Confirm Password</label>
                <input type="password" name="ConfirmPassword" class="form-control">
                <label required for="" class="label-control">Jurusan</label>
                <input type="text" name="Jurusan" value="<?php echo $dashCheckProfile['Jurusan'] ?>" disabled class="form-control">
                <label required for="" class="label-control">Kelas</label>
                <div class="row" style="gap:0px">
                    <div class="col-2" style="padding-right:2px;"> <input type="text" name="Kelas" id="KelasInput" value="<?php echo $dashCheckProfile['Kelas'] ?>" disabled class="form-control"></div>
                    <div class="col" style="padding-left:2px;"> <input type="text" name="KelasType" id="KelasInput" value="<?php echo $dashCheckProfile['Nama_Tipe_Kelas'] ?>" disabled class="form-control"></div>
                </div>
                <label required for="" class="label-control">Tempat Lahir</label>
                <input type="text" name="Tempat_Lahir" value="<?php echo $dashCheckProfile['Tempat_Lahir'] ?>" class="form-control">
                <label required for="" class="label-control">Tanggal Lahir</label>
                <input type="date" name="Tanggal_Lahir" value="<?php echo $dashCheckProfile['Tanggal_Lahir'] ?>" class="form-control">
                <label required for="" class="label-control">Jenis Kelamin</label>
                <select name="Jenis_Kelamin" class="form-control">
                    <option value="" hidden></option>
                    <option value="Laki - Laki" <?php if ($dashCheckProfile['Jenis_Kelamin'] == 'Laki - Laki') echo 'selected'; ?>>Laki - Laki</option>
                    <option value="Perempuan" <?php if ($dashCheckProfile['Jenis_Kelamin'] == 'Perempuan') echo 'selected'; ?>>Perempuan</option>
                </select>
                <label required for="" class="label-control">NO Induk Siswa</label>
                <input type="number" name="NIS" value="<?php echo $dashCheckProfile['No_Induk_Siswa'] ?>" class="form-control">
                <label required for="" class="label-control">NISN</label>
                <input type="number" name="NISN" value="<?php echo $dashCheckProfile['NISN'] ?>" class="form-control">
                <label required for="" class="label-control">NIK</label>
                <input type="number" name="NIK" value="<?php echo $dashCheckProfile['NIK'] ?>" class="form-control">
                <label required for="" class="label-control">NO Hp</label>
                <input type="number" name="NO_Hp" value="<?php echo $dashCheckProfile['No_Hp'] ?>" class="form-control">
                <label required for="" class="label-control">Alamat</label>
                <input type="text" name="Alamat" value="<?php echo $dashCheckProfile['Alamat'] ?>" class="form-control">
                <label required for="" class="label-control">Tahun Masuk</label>
                <input type="number" name="Tahun_Masuk" value="<?php echo $dashCheckProfile['Tahun_Masuk'] ?>" class="form-control">
                <label required for="" class="label-control">Tahun Lulus</label>
                <input type="number" name="Tahun_Lulus" id="inputLulus" value="<?php echo $dashCheckProfile['Tahun_Lulus'] ?>" class="form-control">
                <label required for="" class="label-control">NO Seri Ijasah</label>
                <input type="number" name="No_Seri_Ijazah" id="inputLulus" value="<?php echo $dashCheckProfile['No_Seri_Ijazah'] ?>" class="form-control">
                <label required for="" class="label-control">SMP</label>
                <input type="text" name="SMP" value="<?php echo $dashCheckProfile['SMP'] ?>" class="form-control">
                <label required for="" class="label-control">Nama Ayah</label>
                <input type="text" name="Nama_Ayah" value="<?php echo $dashCheckProfile['Nama_Ayah'] ?>" class="form-control">
                <label required for="" class="label-control">Lulusan Ayah</label>
                <input type="text" name="Lulusan_Ayah" value="<?php echo $dashCheckProfile['Lulusan_Ayah'] ?>" class="form-control">
                <label required for="" class="label-control">Pekerjaan Ayah</label>
                <input type="text" name="Pekerjaan_Ayah" value="<?php echo $dashCheckProfile['Pekerjaan_Ayah'] ?>" class="form-control">
                <label required for="" class="label-control">Nama Ibu</label>
                <input type="text" name="Nama_Ibu" value="<?php echo $dashCheckProfile['Nama_Ibu'] ?>" class="form-control">
                <label required for="" class="label-control">Lulusan Ibu</label>
                <input type="text" name="Lulusan_Ibu" value="<?php echo $dashCheckProfile['Lulusan_Ibu'] ?>" class="form-control">
                <label required for="" class="label-control">Pekerjaan Ibu</label>
                <input type="text" name="Pekerjaan_Ibu" value="<?php echo $dashCheckProfile['Pekerjaan_Ibu'] ?>" class="form-control">
                <label required for="" class="label-control">Foto Profile</label>
                <input type="file" name="Foto" class="form-control">
                <input type="submit" style="float: right;" class="btn btn-success" value="Simpan">
            </form>
            <form action="proses/updateProfileAdmin.php" id="changeProfileAdmin" method="post" enctype="multipart/form-data">
                <?php
                $sqlcheckProfileAdmin = "SELECT * FROM admin WHERE username = '$username'";
                $queryCheckProfileAdmin = mysqli_query($koneksi, $sqlcheckProfileAdmin);
                $dashCheckProfileAdmin = mysqli_fetch_array($queryCheckProfileAdmin);
                ?>
                <label required for="" class="label-control">Nama Lengkap</label>
                <input type="text" name="Nama_lengkap" value="<?php echo $dashCheckProfileAdmin['Nama_Lengkap'] ?>" class="form-control">
                <label required for="" class="label-control">Username</label>
                <input type="text" name="Username" value="<?php echo $dashCheckProfileAdmin['Username'] ?>" class="form-control">
                <label required for="" class="label-control">Password</label>
                <input type="password" name="Password" value="<?php echo $dashCheckProfileAdmin['Password'] ?>" class="form-control">
                <label required for="" class="label-control">Foto Profile</label>
                <input type="file" name="Foto" class="form-control">
                <label required for="" class="label-control">Kepala Sekolah</label>
                <input type="text" id="KepalaSekolah" name="Kepsek" value="" class="form-control">
                <input type="submit" value="Kirim" style="float:right;" class="btn btn-success">
            </form>
            <form action="proses/updateProfileWalikelas.php" id="changeProfileWalikelas" method="post" enctype="multipart/form-data">
                <?php
                $sqlcheckProfileWalikelas = "SELECT * FROM walikelas INNER JOIN kelas on walikelas.Tipe_Kelas=kelas.Tipe_Kelas  WHERE username = '$username'";
                $queryCheckProfileWalikelas = mysqli_query($koneksi, $sqlcheckProfileWalikelas);
                $dashCheckProfileWalikelas = mysqli_fetch_array($queryCheckProfileWalikelas);
                ?>
                <label required for="" class="label-control">Nama Lengkap</label>
                <input type="text" name="Nama_lengkap" value="<?php echo $dashCheckProfileWalikelas['Nama_Lengkap'] ?>" class="form-control">
                <label required for="" class="label-control">Username</label>
                <input type="text" name="Username" value="<?php echo $dashCheckProfileWalikelas['Username'] ?>" class="form-control">
                <label required for="" class="label-control">Password</label>
                <input type="password" name="Password" value="<?php echo $dashCheckProfileWalikelas['Password'] ?>" class="form-control">
                <label required for="" class="label-control">Jurusan</label>
                <input type="text" name="Jurusan" value="<?php echo $dashCheckProfileWalikelas['Jurusan'] ?>" class="form-control">
                <label required for="" class="label-control">Walikelas</label>
                <div class="row">
                    <div class="col-2" style="padding-right:2px;"><input type="text" name="Kelas" disabled value="<?php echo $dashCheckProfileWalikelas['Kelas'] ?>" class="form-control"></div>
                    <div class="col" style="padding-left:2px;"><input type="text" name="Kelas_Type" disabled value="<?php echo $dashCheckProfileWalikelas['Nama_Tipe_Kelas'] ?>" class="form-control"></div>
                </div>
                <label required for="" class="label-control">Foto Profile</label>
                <input type="file" name="Foto" class="form-control">
                <input type="submit" value="Kirim" style="float:right;" class="btn btn-success">
            </form>
        </div>

    </div>
    </div>
    <?php include "footer.php" ?>
    <script>
        function changeprofile() {
            const status = document.getElementById("status").value;

            if (status === "Admin") {
                document.getElementById("changeProfileWalikelas").style.display = "none";
                document.getElementById("changeProfileSiswa").style.display = "none";
            } else if (status === "Walikelas") {
                document.getElementById("changeProfileAdmin").style.display = "none";
                document.getElementById("changeProfileSiswa").style.display = "none";
            } else if (status === "Siswa") {
                document.getElementById("changeProfileAdmin").style.display = "none";
                document.getElementById("changeProfileWalikelas").style.display = "none";
            }
        }
        changeprofile();

        if (document.getElementById("kelasSiswa").textContent == "0") {
            document.getElementById("kelasSiswa").innerText = "Lulus";
        } else if (document.getElementById("kelasSiswa").textContent == "99") {
            document.getElementById("kelasSiswa").innerText = "None";
        }
        setTimeout(() => {
            if (document.getElementById("KelasInput").value == "0") {
                document.getElementById("KelasInput").value = "Lulus"
            } else if (document.getElementById("KelasInput").value == "99") {
                document.getElementById("KelasInput").value = "None"
            }
        }, 100);
        kelas = document.getElementById("KelasInput").value;
        if (kelas = !0) {
            const elements = document.querySelectorAll('#inputLulus');

            // Langkah 2: Loop melalui setiap elemen dan atur display ke none
            elements.forEach(function(element) {
                element.disabled = true;
            });
        }
    </script>
    <script src="js/script.js"></script>
</body>

</html>