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
        <h2 class="h2">Management Walikelas</h2>
        <input type="text" id="status" hidden value='<?php echo $dash["status"]; ?>'>
        <div class="card" style="padding: 10px;">
            <form id="FormWalikelas" action="proses/addWalikelas.php" method="post">
                <h5><b>Tambahkan Walikelas</b></h5>
                <div class="row">
                    <div class="col-sm-4"><input required type="text" name="Nama_Lengkap" placeholder="Nama lengkap" id="Nama_Lengkap" class="form-control"></div>
                    <div class="col-sm-8"><input required type="text" name="Username" placeholder="Username" id="Username" class="form-control"></div>
                    <div class="col-sm-4"><input required type="text" name="Password" placeholder="Password" id="Password" class="form-control"></div>
                    <div class="col">
                        <select name="Jurusan" id="Jurusan" class="form-control">
                            <option value="" hidden>-- Jurusan --</option>
                            <?php
                            $sql = "SELECT * FROM `jurusan` ";
                            $query = mysqli_query($koneksi, $sql);
                            while ($row = mysqli_fetch_array($query)) {
                                echo "
                                <option value='" . $row["Nama_Jurusan"] . "'>" . $row["Nama_Jurusan"] . "</option>
                            ";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col">
                        <select name="Kelas" id="Kelas" class="form-control">
                            <option value="" hidden>-- Kelas --</option>
                            <?php
                            $sql = "SELECT * FROM `tingkatan_kelas` WHERE Kelas <> '0' And Kelas <> '99'";
                            $query = mysqli_query($koneksi, $sql);
                            while ($row = mysqli_fetch_array($query)) {
                                echo "
                            <option value='" . $row["Kelas"] . "'>" . $row["Kelas"] . "</option>
                            ";
                            }
                            ?>

                        </select>
                    </div>
                    <div class="col">
                        <select name="Tipe_Kelas" onchange="" id="Tipe_Kelas" class="form-control">
                            <option value="" hidden>-- Tipe Kelas --</option>
                        </select>
                    </div>

                    <div class=""><input required type="submit" style="margin-bottom: 10px;" value="Tambahkan" id="btnWalikelas" class="btn btn-primary"></div>
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
                            <th>Jurusan</th>
                            <th>Kelas</th>
                            <th>Tipe Kelas</th>
                            <th>Option</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT walikelas.ID, walikelas.Nama_Lengkap, walikelas.Username, walikelas.Password, walikelas.Jurusan, walikelas.Kelas, kelas.Nama_Tipe_Kelas as Tipe_Kelas FROM `walikelas` inner join kelas on walikelas.Tipe_Kelas=kelas.Tipe_Kelas ";
                        $query = mysqli_query($koneksi, $sql);
                        while ($row = mysqli_fetch_array($query)) {
                            echo "
                    <tr>
                        <td>" . $row["ID"] . "</td>
                        <td>" . $row["Nama_Lengkap"] . "</td>
                        <td>" . $row["Username"] . "</td>
                        <td>" . $row["Password"] . "</td>
                        <td>" . $row["Jurusan"] . "</td>
                        <td>" . $row["Kelas"] . "</td>
                        <td>" . $row["Tipe_Kelas"] . "</td>
                        <td><div class='option' style='display: grid;
                        grid-template-columns: repeat(2, 1fr);'> <a onclick='edit(" . $row["ID"] . ")' href='#" . $row["ID"] . "'> <button class='btn btn-success'><ion-icon name='pencil'></ion-icon> </button></a> <a href='proses/deleteWalikelas.php?ID=" . $row["ID"] . "'> <button class='btn btn-danger'><ion-icon name='trash'></ion-icon> </button></a></div></td>
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
    <script>
        function populateTipeKelas() {
            var jurusan = document.getElementById("Jurusan").value;
            var kelas = document.getElementById("Kelas").value;
            var tipeKelasDropdown = document.getElementById("Tipe_Kelas");

            // Clear existing options
            tipeKelasDropdown.innerHTML = "<option value='' hidden>-- Tipe Kelas --</option>";

            // Fetch options based on selected Jurusan and Kelas using AJAX
            // You need to implement this part to fetch data dynamically from your server
            // Here's an example using jQuery AJAX
            $.ajax({
                url: "proses/fetch_tipe_kelas.php", // URL to your PHP script that fetches Tipe Kelas based on Jurusan and Kelas
                type: "POST",
                data: {
                    jurusan: jurusan,
                    kelas: kelas
                },
                dataType: "json",
                success: function(response) {
                    // Populate the Tipe Kelas dropdown with the fetched options
                    response.forEach(function(option) {
                        var optionElement = document.createElement("option");
                        optionElement.value = option.Tipe_Kelas;
                        optionElement.textContent = option.Nama_Tipe_Kelas;
                        tipeKelasDropdown.appendChild(optionElement);
                    });
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching Tipe Kelas:", error);
                }
            });
        }
        // Call the function initially and whenever Jurusan or Kelas selection changes
        document.getElementById("Jurusan").addEventListener("change", populateTipeKelas);
        document.getElementById("Kelas").addEventListener("change", populateTipeKelas);
        function edit(id) {
            const data = new URLSearchParams();
            data.append('username', id);

            fetch('proses/selectWalikelas.php', {
                    method: 'POST',
                    body: data
                })
                .then(response => response.json())
                .then(result => {
                    if (result.error) {
                        console.error('Error:', result.error);
                    } else {
                        document.getElementById('Nama_Lengkap').value = result.Nama_Lengkap;
                        document.getElementById('Kelas').value = result.Kelas;
                        document.getElementById('Jurusan').value = result.Jurusan;
                        document.getElementById('Tipe_Kelas').value = result.Tipe_Kelas;
                        document.getElementById('Username').value = result.Username;
                        document.getElementById('Password').value = result.Password;
                        document.getElementById('FormWalikelas').action = "proses/editWalikelas.php?ID=" + id;
                        document.getElementById('btnWalikelas').value = "Update";
                        populateTipeKelas();
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

    </script>
</body>

</html>