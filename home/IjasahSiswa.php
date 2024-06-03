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
    <input type="text" id="status" hidden value='<?php echo $dash["status"]; ?>'>
        <h2 class="h2">Manajemen File Ijasah Siswa</h2>
        <div class="card" style="padding: 10px;">
            <div style="overflow:auto;">
                <table id="myTable" class="display">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama File</th>
                            <th>Ukuran File</th>
                            <th>Tipe File</th>
                            <th>Option</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $directory = 'Ijasah_Siswa/';
                        $files = array_diff(scandir($directory), array('.', '..', '.htaccess')); // Mengecualikan .htaccess dan file sistem lainnya
                        $no = 1;
                        foreach ($files as $file) {
                            $filePath = $directory . $file;
                            // Pastikan hanya file yang dapat diakses ditampilkan
                            if (is_file($filePath)) {
                                echo "<tr>
                                        <td>$no</td>
                                        <td>" . htmlspecialchars($file) . "</td>
                                        <td>" . filesize($filePath) . " bytes</td>
                                        <td>" . pathinfo($filePath, PATHINFO_EXTENSION) . "</td>
                                        <td>
                                            <a href='download.php?file=" . urlencode($file) . "' class='btn btn-primary'>Download</a>
                                            <a href='proses/delete.php?file=" . urlencode($file) . "' class='btn btn-danger' onclick='return confirm(\"Apakah Anda yakin ingin menghapus file ini?\")'>Delete</a>
                                        </td>
                                    </tr>";
                                $no++;
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <?php include "footer.php"; ?>
    <script src="js/script.js"></script>
</body>

</html>
