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
    $key = 'YourSecretKey';

    // Get the encrypted data from the URL parameter
    $encrypted_data = $_GET['NISN'];

    // Decode the encrypted data
    $decoded_data = base64_decode($encrypted_data);

    // Extract the IV and the encrypted parameter
    $iv_length = openssl_cipher_iv_length('AES-256-CBC');
    $iv = substr($decoded_data, 0, $iv_length);
    $encrypted_parameter = substr($decoded_data, $iv_length);

    // Decrypt the parameter
    $parameter = openssl_decrypt($encrypted_parameter, 'AES-256-CBC', $key, 0, $iv);
    $username = $_SESSION["username"];


    $sqlasli = "SELECT status as statusasli FROM admin WHERE Username = '$username' ";
    $queryasli = mysqli_query($koneksi, $sqlasli);
    $dashasli = mysqli_fetch_array($queryasli);
    $checkasli = mysqli_num_rows($queryasli);
    if ($checkasli == 0) {
        $sqlasli = "SELECT biodata_siswa.status as statusasli FROM `biodata_siswa` INNER JOIN walikelas ON biodata_siswa.ID_Walikelas = walikelas.ID WHERE biodata_siswa.Username = '$username' ";
        $queryasli = mysqli_query($koneksi, $sqlasli);
        $dashasli = mysqli_fetch_array($queryasli);
        $checkasli = mysqli_num_rows($queryasli);
        if ($checkasli == 0) {
            $sqlasli = "SELECT status as statusasli FROM walikelas WHERE Username = '$username' ";
            $queryasli = mysqli_query($koneksi, $sqlasli);
            $dashasli = mysqli_fetch_array($queryasli);
        }
    }
    $parameter = openssl_decrypt($encrypted_parameter, 'AES-256-CBC', $key, 0, $iv);
    $sql = "SELECT biodata_siswa.Nama_Lengkap as Nama_Lengkap, biodata_siswa.status, biodata_siswa.Kelas, biodata_siswa.Jurusan, biodata_siswa.ID_Walikelas as ID_Walikelas, walikelas.Nama_Lengkap as Nama_Walikelas, kelas.Nama_Tipe_Kelas As Kelas_Type , biodata_siswa.Foto FROM `biodata_siswa` inner join walikelas on biodata_siswa.ID_Walikelas=walikelas.ID INNER JOIN kelas ON biodata_siswa.Kelas_Type=kelas.Tipe_Kelas where biodata_siswa.NISN = '$parameter' ";
    $query = mysqli_query($koneksi, $sql);
    $dash = mysqli_fetch_array($query);
    if (is_null($dash['ID_Walikelas'])) {
        $sql = "SELECT Kelas, Kelas_Type FROM biodata_siswa WHERE NISN='$parameter'";
        $query = mysqli_query($koneksi, $sql);
        $row = mysqli_fetch_array($query);

        if ($row) {
            $sqlcheckwalikelas = "SELECT * FROM walikelas WHERE Kelas='" . $row["Kelas"] . "' AND Tipe_Kelas='" . $row["Kelas_Type"] . "'";
            $querycheckwalikelas = mysqli_query($koneksi, $sqlcheckwalikelas);
            $rowcheckwalikelas = mysqli_fetch_array($querycheckwalikelas);

            if ($rowcheckwalikelas) {
                $sqlinsertwalikelas = "UPDATE biodata_siswa SET ID_Walikelas='" . $rowcheckwalikelas["ID"] . "' WHERE NISN='$parameter'";
                $queryinsertwalikelas = mysqli_query($koneksi, $sqlinsertwalikelas);
                echo '<script>window.location.reload();</script>';
                if (!$queryinsertwalikelas) {
                    // Tangani kesalahan pembaruan ID_Walikelas
                    die("Error updating ID_Walikelas: " . mysqli_error($koneksi));
                }
            }
        }
    }
    ?>

    <!-- Content -->
    <div id='content' class='content'>
        <h2 class="h2">Profile</h2>
        <div class='row'>
            <div class='col-lg'>
                <div class='card'>
                    <center>
                        <input type="text" id="status" hidden value='<?php echo $dashasli["statusasli"]; ?>'>
                        <input type="text" id="Kelasval" hidden value='<?php echo $dash["Nama_Walikelas"]; ?>'>
                        <input type="text" id="Kelas_Typeval" hidden value='<?php echo $dash["Kelas_Type"]; ?>'>
                        <img src='image_siswa/<?php echo $dash["Foto"] ?>' class='imageprofil' alt=''>
                        <h2 class='name'><b><?php echo $dash["Nama_Lengkap"] ?></b></h2>
                        <text class='kelas'> <text id="kelasSiswa"><?php echo $dash["Kelas"] ?></text> <text><?php echo $dash["Kelas_Type"] ?></text></text>
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
                            <p class='jurusan-text'><?php echo $dash["Jurusan"] ?></p>
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
                            <p class='walikelas-text'><?php echo $dash["Nama_Walikelas"] ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="card" style="padding:10px;">
            <h4><b>Your Profile</b></h4>
            <?php
            $sqlcheckProfile = "SELECT * FROM biodata_siswa WHERE NISN = '$parameter'";
            $queryCheckProfile = mysqli_query($koneksi, $sqlcheckProfile);
            $dashCheckProfile = mysqli_fetch_array($queryCheckProfile);
            ?>
            <form action="proses/updateProfileInspect.php?NISN=<?php echo $dashCheckProfile['NISN'] ?>" id="changeProfileSiswa" method="post" enctype="multipart/form-data">
                <label required for="" class="label-control">Nama Lengkap</label>
                <input type="text" name="Nama_lengkap1" value="<?php echo $dashCheckProfile['Nama_Lengkap'] ?>" class="form-control">
                <label required for="" class="label-control">Username</label>
                <input type="text" name="Username" class="form-control" value="<?php echo $dashCheckProfile['username'] ?>">
                <div class="level_user-2">
                    <label required for="" class="label-control">Password</label>
                    <input type="password" name="Password" value="<?php echo $dashCheckProfile['password'] ?>" class="form-control">
                    <label for="" class="label-control">Confirm Password <small>(Diisi Jika Ingin Mengganti Password)</small></label>
                    <input type="password" name="ConfirmPassword" class="form-control">
                </div>
                <label required for="" class="label-control">Jurusan</label>
                <input type="text" name="Jurusan" value="<?php echo $dashCheckProfile['Jurusan'] ?>" class="form-control">
                <label required for="" class="label-control">Kelas</label>
                <input type="text" name="Kelas" id="KelasInput" value="<?php echo $dashCheckProfile['Kelas'] ?>" class="form-control">
                <div class="level_user-2">
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
                    <div class="level_user-2">
                        <label required for="" class="label-control">NO Induk Siswa</label>
                        <input type="number" name="NIS" value="<?php echo $dashCheckProfile['No_Induk_Siswa'] ?>" class="form-control">
                        <label required for="" class="label-control">NISN</label>
                        <input type="number" name="NISN" value="<?php echo $dashCheckProfile['NISN'] ?>" class="form-control">
                        <label required for="" class="label-control">NIK</label>
                        <input type="number" name="NIK" value="<?php echo $dashCheckProfile['NIK'] ?>" class="form-control">
                    </div>
                    <label required for="" class="label-control">NO Hp</label>
                    <input type="number" name="NO_Hp" value="<?php echo $dashCheckProfile['No_Hp'] ?>" class="form-control">
                    <label required for="" class="label-control">Alamat</label>
                    <input type="text" name="Alamat" value="<?php echo $dashCheckProfile['Alamat'] ?>" class="form-control">
                    <label required for="" class="label-control">Tahun Masuk</label>
                    <input type="number" name="Tahun_Masuk" value="<?php echo $dashCheckProfile['Tahun_Masuk'] ?>" class="form-control">
                    <div class="level_user-2">
                        <label required for="" class="label-control">Tahun Lulus</label>
                        <input type="number" name="Tahun_Lulus" id="inputLulus" value="<?php echo $dashCheckProfile['Tahun_Lulus'] ?>" class="form-control">
                        <label required for="" class="label-control">NO Seri Ijasah</label>
                        <input type="number" name="No_Seri_Ijazah" id="inputLulus" value="<?php echo $dashCheckProfile['No_Seri_Ijazah'] ?>" class="form-control">
                    </div>
                    <label required for="" class="label-control">SMP</label>
                    <input type="text" name="SMP" value="<?php echo $dashCheckProfile['SMP'] ?>" class="form-control">
                    <div class="level_user-2">
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
                    </div>
                </div>
                <input type="submit" value="Kirim" class="btn btn-success level_user-1" style="float:right;">
            </form>
        </div><br>
        <div class="card level_user-2" style="padding:10px">
            <h3>Surat Keterangan Lulus</h3>
            <form action="proses/uploadSKL.php?id_siswa=<?php echo $dashCheckProfile["ID"]?>" method="post" enctype="multipart/form-data">
                <label for="" class="label-control">Upload File</label>
                <input type="file" name="file" id="" class="form-control">
                <input type="submit" value="Upload" class="btn btn-success" style="float:right;">
                <p></p>
            </form>
        </div>

    </div>
    </div>
    <?php include "footer.php" ?>
    <script>
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
        // Ambil nilai status
        var status = document.getElementById("status").value;

        // Cek status
        if (status === "Walikelas" || status === "Siswa") {
            // Ambil semua elemen input
            var inputs = document.querySelectorAll('input');

            // Loop melalui setiap elemen input dan atur disabled menjadi true
            inputs.forEach(function(input) {
                input.disabled = true;
            });

            // Ambil semua elemen select
            var selects = document.querySelectorAll('select');

            // Loop melalui setiap elemen select dan atur disabled menjadi true
            selects.forEach(function(select) {
                select.disabled = true;
            });
        }
        if (status == "Walikelas") {
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
                html: "Welcome!!, This page is your student's personal data <b><?php echo $dash["Nama_Lengkap"]; ?></b>"
            });
        }
        if (status == "Siswa") {
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
                html: "Welcome!!, This page is your friend's personal data <b><?php echo $dash["Nama_Lengkap"]; ?></b>"
            });
        }
    </script>
    <script src="js/script.js"></script>
</body>

</html>