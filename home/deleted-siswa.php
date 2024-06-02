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
        <h2 class="h2"><div id="management-siswa">Deleted Siswa</div></h2>
        <input type="text" id="status" hidden value='<?php echo $dash["status"]; ?>'>
        <div class="card" style="padding: 10px;">
            <div style="overflow:auto;">
            <a href="management-siswa.php" class="btn btn-secondary"><ion-icon name="person-add"></ion-icon> Display current students</a>
                <table id="myTable" class="display">
                    <thead>
                        <tr>
                            <th>Nisn</th>
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
                        if ($dash["status"] == "Admin") {
                            $sql = "SELECT * FROM `biodata_siswa` Where Kelas = '99' ORDER BY FIELD(Kelas, '0', '12', '11', '10');";
                        }
                        $query = mysqli_query($koneksi, $sql);
                        while ($row = mysqli_fetch_array($query)) {
                            // Set your encryption key
                            $key = 'YourSecretKey';

                            // Set your parameter to be encrypted
                            $parameter = $row["NISN"]; // Assuming contains the parameter value

                            // Set the encryption cipher
                            $cipher = 'AES-256-CBC';

                            // Generate an initialization vector
                            $iv_length = openssl_cipher_iv_length($cipher);
                            $iv = openssl_random_pseudo_bytes($iv_length);

                            // Encrypt the parameter
                            $encrypted_parameter = openssl_encrypt($parameter, $cipher, $key, 0, $iv);

                            // Encode the IV along with the encrypted parameter
                            $encrypted_data = base64_encode($iv . $encrypted_parameter);

                            // Construct the encrypted URL
                            $encrypted_url = 'inspectProfile.php?NISN=' . urlencode($encrypted_data);

                            // Now you can use $encrypted_url in your HTML link
                            echo "
                    <tr>
                        <td>" . $row["NISN"] . "</td>
                        <td>" . $row["Nama_Lengkap"] . "</td>
                        <td>" . $row["username"] . "</td>
                        <td>" . $row["password"] . "</td>
                        <td>" . $row["Jurusan"] . "</td>
                        <td><div class='Kelas-Status btn' style='font-size:13px; padding:3px 5px;' id=''>" . $row["Kelas"] . "</div></td>
                        <td>" . $row["Kelas_Type"] . "</td>
                        <td><div class='option' style='display: grid;
                        grid-template-columns: repeat(2, 1fr);'> <a href='$encrypted_url'> <button class='btn btn-success'><ion-icon name='eye'></ion-icon> </button></a> <a href='proses/deleteSiswa.php?NISN=" . $row["NISN"] . "' <button class='btn btn-danger level_user-1'><ion-icon name='trash'></ion-icon> </button></a></div></td>
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
    <div class="modal fade" id="exampleModalExcel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Import Excel</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="uploadExcell.php" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col"><input required type="file" name="excel_file" class="form-control" id=""></div>
                            <div class="col-2"><input required type="submit" name="UploadExcel" value="Kirim" class="btn btn-success"></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

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
// Wait for the DOM content to be fully loaded
document.addEventListener("DOMContentLoaded", function() {
    // Get all elements with class "Kelas-Status"
    var kelasStatusElements = document.querySelectorAll(".Kelas-Status");

    // Loop through each element
    kelasStatusElements.forEach(function(element) {
        // Get the text content of the element
        var kelas = element.textContent.trim();

        // Remove existing classes
        element.classList.remove("btn-primary", "btn-info", "btn-danger", "btn-success", "btn-secondary");

        // Set class based on the class
        switch (kelas) {
            case "10":
                element.classList.add("btn-info");
                break;
            case "11":
                element.classList.add("btn-warning");
                break;
            case "12":
                element.classList.add("btn-danger");
                break;
            case "99":
                element.classList.add("btn-secondary");
                element.textContent = "None";
                break;
            case "0":
                element.textContent = "Lulus";
                element.classList.add("btn-success");
                break;
            default:
                // Handle other cases or leave it as default
                break;
        }
    });
});
        

        // Call the function initially and whenever Jurusan or Kelas selection changes
        document.getElementById("Jurusan").addEventListener("change", populateTipeKelas);
        document.getElementById("Kelas").addEventListener("change", populateTipeKelas);
    </script>
</body>

</html>