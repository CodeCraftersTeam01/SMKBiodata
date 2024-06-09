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
        <h2 class="h2">Management Kelas</h2>
        <input type="text" id="status" hidden value='<?php echo $dash["status"]; ?>'>
        <div class="card" style="padding: 10px;">
            <form action="proses/addKelasType.php" method="post">
                <h5><b>Tambahkan Kelas</b></h5>
                <div class="row">
                    <div class="col-sm-4"><input required type="text" name="NamaKelas" placeholder="Nama Kelas" id="" class="form-control"></div>
                    <div class="col-auto">
                        <select name="Kelas" id="" class="form-control">
                            <option value="" hidden>-- Kelas --</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                        </select>
                    </div>
                    <div class="col">
                        <select name="Jurusan" id="" class="form-control">
                            <option value="" hidden>-- Jurusan --</option>
                            <?php
                            $sql = "SELECT * FROM `jurusan` ";
                            $query = mysqli_query($koneksi, $sql);
                            while ($row = mysqli_fetch_array($query)) {
                                echo "
                                <option value='".$row["Nama_Jurusan"]."'>".$row["Nama_Jurusan"]."</option>
                            ";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-sm"><input required type="submit" value="Tambahkan" class="btn btn-primary"></div>
                </div>
            </form>
            <hr>
            <div style="overflow:auto;">
            <table id="myTable" class="display">
                <thead>
                    <tr>
                        <th>Nama Kelas</th>
                        <th>Kelas</th>
                        <th>Jurusan</th>
                        <th>Option</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM `kelas` ";
                    $query = mysqli_query($koneksi, $sql);
                    while ($row = mysqli_fetch_array($query)) {
                        echo "
                    <tr>
                        <td>" . $row["Nama_Tipe_Kelas"] . "</td>
                        <td>" . $row["Kelas"] . "</td>
                        <td>" . $row["Jurusan"] . "</td>
                        <td><div class='option'></a> <a href='proses/deleteKelasType.php?kelas=" . $row["Tipe_Kelas"] . "'  onclick='return confirm(\"Apakah Anda yakin ingin menghapus data kelas ini?, ini akan menghapus data walikelas dan siswa yang terkait dengan data ini!!\")'></button> <button class='btn btn-danger'><ion-icon name='trash'></ion-icon> </button></a></div></td>
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
    <?php include "footer.php" ?>
    <script src="js/script.js"></script>
</body>

</html>