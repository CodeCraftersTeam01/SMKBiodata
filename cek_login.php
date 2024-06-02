<?php
// Mengaktifkan sesi PHP
session_start();

// Menghubungkan dengan koneksi
include 'asset/koneksi.php';

// Menangkap data yang dikirim dari form
$username = mysqli_real_escape_string($koneksi, $_POST['username']);
$password = mysqli_real_escape_string($koneksi, $_POST['password']);

// Fungsi untuk memeriksa login dan mengatur sesi
function checkLogin($koneksi, $table, $username, $password)
{
    $query = "SELECT * FROM $table WHERE username='$username' AND password='$password'";
    $result = mysqli_query($koneksi, $query);
    return $result;
}

// Cek login untuk admin
$data = checkLogin($koneksi, 'admin', $username, $password);
$cek = mysqli_num_rows($data);

if ($cek > 0) {
    $_SESSION['username'] = $username;
    $_SESSION['status'] = "login";
    header("Location: home/");
    exit();
}

// Cek login untuk walikelas
$data = checkLogin($koneksi, 'walikelas', $username, $password);
$cek = mysqli_num_rows($data);

if ($cek > 0) {
    $_SESSION['username'] = $username;
    $_SESSION['status'] = "login";
    header("Location: home/");
    exit();
}

// Cek login untuk siswa
$data = checkLogin($koneksi, 'biodata_siswa', $username, $password);
$cek = mysqli_num_rows($data);

if ($cek > 0) {
    $row = mysqli_fetch_array($data);

    // Periksa jika status siswa adalah "mutasi"
    if ($row['status'] == 'None') {
        header("Location: index.php?Error=GagalLogin");
        exit();
    }

    // Jika siswa sudah lulus, tidak perlu update walikelas
    if ($row['Kelas'] != 0) {
        $sql = "SELECT Kelas, Kelas_Type FROM biodata_siswa WHERE username='$username'";
        $query = mysqli_query($koneksi, $sql);
        $row = mysqli_fetch_array($query);

        if ($row) {
            $sqlcheckwalikelas = "SELECT * FROM walikelas WHERE Kelas='" . $row["Kelas"] . "' AND Tipe_Kelas='" . $row["Kelas_Type"] . "'";
            $querycheckwalikelas = mysqli_query($koneksi, $sqlcheckwalikelas);
            $rowcheckwalikelas = mysqli_fetch_array($querycheckwalikelas);

            if ($rowcheckwalikelas) {
                $sqlinsertwalikelas = "UPDATE biodata_siswa SET ID_Walikelas='" . $rowcheckwalikelas["ID"] . "' WHERE username='$username'";
                $queryinsertwalikelas = mysqli_query($koneksi, $sqlinsertwalikelas);

                if (!$queryinsertwalikelas) {
                    // Tangani kesalahan pembaruan ID_Walikelas
                    die("Error updating ID_Walikelas: " . mysqli_error($koneksi));
                }
            } else {
                // Tangani kesalahan tidak menemukan walikelas yang sesuai
                header("location:index.php?Error=WalikelasNotFound");
                exit();
            }
        } else {
            // Tangani kesalahan tidak menemukan data siswa
            die("Error fetching student data: " . mysqli_error($koneksi));
        }
    }

    $_SESSION['username'] = $username;
    $_SESSION['status'] = "login";

    // Fungsi untuk menghapus data kelulusan siswa yang sudah satu tahun
    function hapusDataKelulusanSatuTahunLalu($koneksi)
    {
        // Mendapatkan tahun saat ini
        $tahunSekarang = date("Y");

        // SQL untuk menghapus data siswa yang lulus lebih dari satu tahun yang lalu
        $sql = "DELETE FROM kelulusan_siswa WHERE Tahun <= ?";

        // Menyiapkan pernyataan SQL
        $stmt = $koneksi->prepare($sql);

        // Menghitung tahun batas (satu tahun yang lalu)
        $tahunBatas = $tahunSekarang - 1;

        // Mengikat parameter dan menjalankan pernyataan SQL
        $stmt->bind_param("i", $tahunBatas);
        $stmt->execute();

        // Menutup pernyataan
        $stmt->close();
    }

    // Panggil fungsi saat pengguna masuk ke web
    hapusDataKelulusanSatuTahunLalu($koneksi);

    //sistem check endtanggal dengan tanggal sekarang secara realtime
    // Fungsi untuk memeriksa tanggal end dan mengosongkan file jika sesuai
    function checkAndResetTanggalEnd()
    {
        $fileTanggalEnd = 'home/proses/tanggalEnd.txt';
        $fileTanggal = 'home/proses/tanggal.txt';

        // Membaca nilai dari file tanggalEnd.txt
        if (file_exists($fileTanggalEnd)) {
            $tanggalEnd = file_get_contents($fileTanggalEnd);
            $tanggalSekarang = date("Y-m-d");

            // Memeriksa apakah tanggal end sama dengan tanggal sekarang
            if (trim($tanggalEnd) === $tanggalSekarang) {
                // Mengosongkan file tanggalEnd.txt dan tanggal.txt
                file_put_contents($fileTanggalEnd, '');
                file_put_contents($fileTanggal, '');
            }
        }
    }
    checkAndResetTanggalEnd();

    header("Location: home/");
    exit();
} else {
    header("Location: index.php?Error=GagalLogin");
    exit();
}
