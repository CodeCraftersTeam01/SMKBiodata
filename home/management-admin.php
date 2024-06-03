<?php
session_start();
include "../call_packages.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Biodata Siswa SMKN 1 Sumenep | Home</title>
    <link rel="shortcut icon" href="../asset/image/smk.png" type="image/x-icon">
    <link rel="stylesheet" href="css/style.css">
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
        <h2 class="h2">Management Admin</h2>
        <input type="text" id="status" hidden value='<?php echo $dash["status"]; ?>'>
        <div class="card" style="padding: 10px;">
            <form action="proses/addAdmin.php" method="post">
                <h5><b>Tambahkan Admin</b></h5>
                <div class="row">
                    <div class="col-sm"><input required type="text" name="Nama_Lengkap" placeholder="Nama_lengkap" id="" class="form-control"></div>
                    <div class="col-sm"><input required type="text" name="Username" placeholder="Username" id="" class="form-control"></div>
                    <div class="col-sm"><input required type="text" name="Password" placeholder="Password" id="" class="form-control"></div>
                    <div class=""><input required type="submit" style="margin-bottom: 10px;" value="Tambahkan" class="btn btn-primary"></div>
                </div>
            </form>
            <hr>
            <div style="overflow:auto;">
                <table id="myTable" class="display">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama Lengkap</th>
                            <th>Username</th>
                            <th>Password</th>
                            <th>Option</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT * FROM `admin` ";
                        $query = mysqli_query($koneksi, $sql);
                        while ($row = mysqli_fetch_array($query)) {
                            echo "
                    <tr>
                        <td>" . $row["ID"] . "</td>
                        <td>" . $row["Nama_Lengkap"] . "</td>
                        <td>" . $row["Username"] . "</td>
                        <td>" . $row["Password"] . "</td>
                        <td><div class='option'></a> <a href='proses/deleteAdmin.php?ID=" . $row["ID"] . "'></button> <button class='btn btn-danger'><ion-icon name='trash'></ion-icon> </button></a></div></td>
                    </tr>
                    ";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </div>

    <!-- Modal Template Excel -->
    <!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Guide</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Untuk Contoh isi cell pada tabel excell sebagai berikut
        <img src="asset/image/Screenshot 2024-05-18 190637.png" width="100%" alt="">
        <h5><b>Tata Cara</b></h5>
        <ul>
            <li><b>NISN</b> : Isi Dengan Nomor NISN</li>
            <li><b>Nama Lengkap</b> : Isi Dengan Text Nama Siswa</li>
            <li><b>Username</b> : Username Untuk Login Siswa</li>
            <li><b>Password</b> : Password Untuk Login Siswa</li>
            <li><b>Jurusan</b> : Isi Dengan Nama Jurusan ( Require : Tidak Boleh Singkat, Setelah Spasi karakter Pertama Huruf Kapital )</li>
            <li><b>Kelas</b> : Isi Dengan Number Kelas Dari Kelas 10, 11, 12</li>
            <li><b>Kelas Tipe</b> : Isi Dengan Text Kelas Misal : RPL 1, Jurusan Harus Singkat Seperti AKL, RPL, Huruf Harus Kapital Semua Dan Berikan Spasi untuk memberikan Nomor</li>
        </ul>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <a href="asset/TemplateWeb.xlsx"><button type="button" class="btn btn-primary"><ion-icon name="download"></ion-icon> Download</button></a>
      </div>
    </div>
  </div>
</div>
    <?php include "footer.php" ?>
    <script src="js/script.js"></script>
</body>

</html>