<?php
session_start();
include '../asset/koneksi.php';

// Pastikan pengguna sudah login
if (!isset($_SESSION['username'])) {
    header("Location: ../index.php");
    exit();
}

// Mendapatkan ID pengguna dari sesi atau dari form
$username = $_GET["NISN"];

// Mengambil data yang dikirim dari form
$namaLengkap = $_POST['Nama_lengkap1'];
$usernameBaru = isset($_POST['Username']) ? $_POST['Username'] : '';
$password = isset($_POST['Password']) ? $_POST['Password'] : '';
$confirmPassword = isset($_POST['ConfirmPassword']) ? $_POST['ConfirmPassword'] : '';
$tempatLahir = isset($_POST['Tempat_Lahir']) ? $_POST['Tempat_Lahir'] : '';
$tanggalLahir = isset($_POST['Tanggal_Lahir']) ? $_POST['Tanggal_Lahir'] : '';
$kelas = isset($_POST['Kelas']) ? $_POST['Kelas'] : '';
$jenisKelamin = isset($_POST['Jenis_Kelamin']) ? $_POST['Jenis_Kelamin'] : '';
$noIndukSiswa = isset($_POST['NIS']) ? $_POST['NIS'] : '';
$nisn = isset($_POST['NISN']) ? $_POST['NISN'] : '';
$nik = isset($_POST['NIK']) ? $_POST['NIK'] : '';
$noHp = isset($_POST['NO_Hp']) ? $_POST['NO_Hp'] : '';
$alamat = isset($_POST['Alamat']) ? $_POST['Alamat'] : '';
$tahunMasuk = isset($_POST['Tahun_Masuk']) ? $_POST['Tahun_Masuk'] : '';
$tahunLulus = isset($_POST['Tahun_Lulus']) ? $_POST['Tahun_Lulus'] : '';
$noSeriIjazah = isset($_POST['No_Seri_Ijazah']) ? $_POST['No_Seri_Ijazah'] : '';
$smp = isset($_POST['SMP']) ? $_POST['SMP'] : '';
$namaAyah = isset($_POST['Nama_Ayah']) ? $_POST['Nama_Ayah'] : '';
$lulusanAyah = isset($_POST['Lulusan_Ayah']) ? $_POST['Lulusan_Ayah'] : '';
$pekerjaanAyah = isset($_POST['Pekerjaan_Ayah']) ? $_POST['Pekerjaan_Ayah'] : '';
$namaIbu = isset($_POST['Nama_Ibu']) ? $_POST['Nama_Ibu'] : '';
$lulusanIbu = isset($_POST['Lulusan_Ibu']) ? $_POST['Lulusan_Ibu'] : '';
$pekerjaanIbu = isset($_POST['Pekerjaan_Ibu']) ? $_POST['Pekerjaan_Ibu'] : '';

// Mengatur direktori upload
$target_dir = "../image_siswa/";
$target_file = "../image_siswa/" . basename($_FILES["Foto"]["name"]);
$nama_file = basename($_FILES["Foto"]["name"]);
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
$uploadOk = 1;

// Memeriksa apakah file adalah gambar atau bukan
if (isset($_FILES["Foto"]["name"]) && !empty($_FILES["Foto"]["name"])) {
    $check = getimagesize($_FILES["Foto"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Memeriksa apakah file sudah ada
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

    // Memeriksa ukuran file
    if ($_FILES["Foto"]["size"] > 5000000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Memeriksa tipe file yang diperbolehkan
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

   // Memeriksa apakah $uploadOk bernilai 0 karena kesalahan
   if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
} else {
    if (move_uploaded_file($_FILES["Foto"]["tmp_name"], $target_file)) {
        // Mengambil path foto lama dari database
        $sqlOldPhoto = "SELECT Foto FROM biodata_siswa WHERE NISN='$username'";
        $resultOldPhoto = mysqli_query($koneksi, $sqlOldPhoto);
        if ($resultOldPhoto && mysqli_num_rows($resultOldPhoto) > 0) {
            $rowOldPhoto = mysqli_fetch_assoc($resultOldPhoto);
            $oldPhoto = "../image_siswa/" . $rowOldPhoto['Foto'];

            // Menghapus foto lama jika ada dan bukan 'images.jpg'
            if (!empty($oldPhoto) && basename($oldPhoto) != 'images.jpg' && file_exists($oldPhoto)) {
                unlink($oldPhoto);
            }
        }
        echo "The file " . htmlspecialchars(basename($_FILES["Foto"]["name"])) . " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
}

// Menyiapkan query update
$sql = "UPDATE biodata_siswa SET 
    Nama_Lengkap='$namaLengkap',
    username='$usernameBaru',
    Tempat_Lahir='$tempatLahir',
    Tanggal_Lahir='$tanggalLahir',
    Jenis_Kelamin='$jenisKelamin',
    No_Induk_Siswa='$noIndukSiswa',
    NISN='$nisn',
    NIK='$nik',
    No_Hp='$noHp',
    Kelas='$kelas',
    Alamat='$alamat',
    Tahun_Masuk='$tahunMasuk',
    Tahun_Lulus='$tahunLulus',
    No_Seri_Ijazah='$noSeriIjazah',
    SMP='$smp',
    Nama_Ayah='$namaAyah',
    Lulusan_Ayah='$lulusanAyah',
    Pekerjaan_Ayah='$pekerjaanAyah',
    Nama_Ibu='$namaIbu',
    Lulusan_Ibu='$lulusanIbu',
    Pekerjaan_Ibu='$pekerjaanIbu'";

// Menambahkan bagian upload file foto jika ada
if ($uploadOk == 1) {
    $sql .= ", Foto='$target_file'";
}

// Menambahkan validasi password dan update password jika ada perubahan
if (!empty($password) && !empty($confirmPassword)) {
    if ($password !== $confirmPassword) {
        echo "Password dan Konfirmasi Password tidak cocok.";
        exit();
    } else {
        $sql .= ", password='$password'";
    }
}

$sql .= " WHERE NISN='$username'";

// Menjalankan query update
if (mysqli_query($koneksi, $sql)) {
    echo "Profile updated successfully";
    header("Location: ../management-siswa.php");
} else {
    echo "Error updating profile: " . mysqli_error($koneksi);
}

mysqli_close($koneksi);


function encrypt($plaintext, $key) {
    // Initialization Vector (IV) should be random and unique for each encryption
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));

    // Encrypt the data
    $ciphertext = openssl_encrypt($plaintext, 'aes-256-cbc', $key, 0, $iv);

    // Combine the IV with the encrypted text
    $encrypted = base64_encode($iv . $ciphertext);
    return $encrypted;
}

$key = 'your-encryption-key-here'; // The key should be 32 bytes (256 bits) for AES-256
$encrypted = encrypt($nisn, $key);
echo "Encrypted: " . $encrypted;




// Mengarahkan kembali ke halaman profil setelah update

exit();
?>
