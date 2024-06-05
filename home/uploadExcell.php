<?php
include_once("asset/koneksi.php");
require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

if (isset($_POST["UploadExcel"])) {
    if (isset($_FILES["excel_file"]) && $_FILES["excel_file"]["error"] == UPLOAD_ERR_OK) {
        $file = $_FILES["excel_file"]["tmp_name"];
        $extension = pathinfo($_FILES["excel_file"]["name"], PATHINFO_EXTENSION);

        if (in_array($extension, ["xlsx", "xls", "csv"])) {
            try {
                $spreadsheet = IOFactory::load($file);
                $data = $spreadsheet->getActiveSheet()->toArray();

                foreach ($data as $index => $row) {
                    if ($index == 0) {
                        continue; // Lewati header
                    }

                    $NISN = $row[0];
                    $Nama_Lengkap = $row[1];
                    $username = $row[2];
                    $password = $row[3];
                    $Jurusan = $row[4];
                    $Kelas = $row[5];
                    $Tipe_Kelas = $row[6];

                    // Periksa apakah Tipe_Kelas ada di tabel kelas
                    $checkQuery = "SELECT Tipe_Kelas FROM kelas WHERE Nama_Tipe_Kelas = ?";
                    $checkStmt = mysqli_prepare($koneksi, $checkQuery);
                    mysqli_stmt_bind_param($checkStmt, 's', $Tipe_Kelas);
                    mysqli_stmt_execute($checkStmt);
                    mysqli_stmt_bind_result($checkStmt, $validTipeKelas);
                    mysqli_stmt_fetch($checkStmt);
                    mysqli_stmt_close($checkStmt);

                    if ($validTipeKelas) {
                        $query = "INSERT INTO `biodata_siswa` (`ID`, `username`, `password`, `status`, `Nama_Lengkap`, `Tempat_Lahir`, `Tanggal_Lahir`, `Jenis_Kelamin`, `No_Induk_Siswa`, `NISN`, `NIK`, `No_Hp`, `Alamat`, `Anak_Ke`, `Kelas`, `Kelas_Type`, `Jurusan`, `Tahun_Masuk`, `Tahun_Lulus`, `No_Seri_Ijazah`, `SMP`, `Nama_Ayah`, `Lulusan_Ayah`, `Pekerjaan_Ayah`, `Nama_Ibu`, `Lulusan_Ibu`, `Pekerjaan_Ibu`, `Foto`, `ID_Walikelas`) VALUES (NULL, ?, ?, 'Siswa', ?, '', '', '', '', ?, '', '', '', '', ?, ?, ?, ?, '', '', '', '', '', '', '', '', '', 'images.jpg', NULL)";
                        $currentYear = date("Y");
                        $stmt = mysqli_prepare($koneksi, $query);
                        mysqli_stmt_bind_param($stmt, 'sssssssi', $username, $password, $Nama_Lengkap, $NISN, $Kelas, $validTipeKelas, $Jurusan, $currentYear);
                        mysqli_stmt_execute($stmt);
                        mysqli_stmt_close($stmt);
                        header("Location: management-siswa.php");
                    } else {
                        echo "Nilai Kelas_Type tidak valid: " . $Tipe_Kelas . "<br>";
                    }
                }
                echo "Data berhasil diimpor ke tabel biodata_siswa di database smkbiodata.";
            } catch (Exception $e) {
                echo "Terjadi kesalahan saat memproses file: " . $e->getMessage();
            }
        } else {
            echo "Format file tidak valid. Hanya file .xlsx, .xls, dan .csv yang diperbolehkan.";
        }
    } else {
        echo "Tidak ada file yang diunggah atau terjadi kesalahan saat mengunggah file.";
        switch ($_FILES["excel_file"]["error"]) {
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                echo " Ukuran file terlalu besar.";
                break;
            case UPLOAD_ERR_PARTIAL:
                echo " File hanya terunggah sebagian.";
                break;
            case UPLOAD_ERR_NO_FILE:
                echo " Tidak ada file yang diunggah.";
                break;
            case UPLOAD_ERR_NO_TMP_DIR:
                echo " Folder temporer hilang.";
                break;
            case UPLOAD_ERR_CANT_WRITE:
                echo " Gagal menulis file ke disk.";
                break;
            case UPLOAD_ERR_EXTENSION:
                echo " Ekstensi PHP menghentikan unggahan file.";
                break;
            default:
                echo " Kesalahan tidak diketahui.";
                break;
        }
    }
}
?>
