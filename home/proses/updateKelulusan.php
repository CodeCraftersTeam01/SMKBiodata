<?php
session_start();
require "../asset/koneksi.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if any students were selected
    if (isset($_POST['kelulusan'])) {
        $nisnArray = $_POST['kelulusan'];

        // Prepare the SQL statement to update the class
        $updateClassStmt = $koneksi->prepare("UPDATE biodata_siswa SET Kelas = ?, Kelas_Type = ? WHERE NISN = ?");

        // Prepare the SQL statement to insert into kelulusan_siswa
        $insertKelulusanStmt = $koneksi->prepare("INSERT INTO kelulusan_siswa (ID_Biodata_Siswa, Username, Password, Tahun) VALUES (?, ?, ?, ?)");

        foreach ($nisnArray as $nisn) {
            // Fetch the current class of the student
            $fetchClassStmt = $koneksi->prepare("SELECT ID, Username, Password, Kelas, Kelas_Type FROM biodata_siswa WHERE NISN = ?");
            $fetchClassStmt->bind_param("s", $nisn);
            $fetchClassStmt->execute();
            $fetchClassStmt->bind_result($idBiodataSiswa, $username, $password, $currentClass, $Type_Kelas);
            $fetchClassStmt->fetch();
            $fetchClassStmt->close();

            // Determine the new class based on the current class
            $newClass = $currentClass;
            if ($currentClass == 10) {
                $newClass = 11;
            } elseif ($currentClass == 11) {
                $newClass = 12;
            } elseif ($currentClass == 12) {
                $newClass = 0; // Graduated
            }

            // Get Nama_Tipe_Kelas based on current Tipe_Kelas
            $getClassTypeStmt = $koneksi->prepare("SELECT Nama_Tipe_Kelas FROM kelas WHERE Tipe_Kelas = ?");
            $getClassTypeStmt->bind_param("i", $Type_Kelas);
            $getClassTypeStmt->execute();
            $getClassTypeStmt->bind_result($namaTipeKelas);
            $getClassTypeStmt->fetch();
            $getClassTypeStmt->close();

            // Get Tipe_Kelas based on new class and Nama_Tipe_Kelas
            $tipeKelas = $Type_Kelas; // Default to current Type_Kelas
            if ($newClass != 0) { // Only fetch new Tipe_Kelas if the student hasn't graduated
                $getKelasTypeStmt = $koneksi->prepare("SELECT Tipe_Kelas FROM kelas WHERE Kelas = ? AND Nama_Tipe_Kelas = ?");
                $getKelasTypeStmt->bind_param("is", $newClass, $namaTipeKelas);
                $getKelasTypeStmt->execute();
                $getKelasTypeStmt->bind_result($tipeKelas);
                $getKelasTypeStmt->fetch();
                $getKelasTypeStmt->close();
            }

            // Update the student's class and class type
            $updateClassStmt->bind_param("iis", $newClass, $tipeKelas, $nisn);
            $updateClassStmt->execute();

            // If the student has graduated (class is 0), insert into kelulusan_siswa
            if ($newClass == 0) {
                // Check if the student is already in kelulusan_siswa
                $checkKelulusanStmt = $koneksi->prepare("SELECT COUNT(*) FROM kelulusan_siswa WHERE ID_Biodata_Siswa = ?");
                $checkKelulusanStmt->bind_param("i", $idBiodataSiswa);
                $checkKelulusanStmt->execute();
                $checkKelulusanStmt->bind_result($count);
                $checkKelulusanStmt->fetch();
                $checkKelulusanStmt->close();

                if ($count == 0) {
                    // Get the current year
                    $currentYear = date("Y");

                    // Insert the student into kelulusan_siswa
                    $insertKelulusanStmt->bind_param("isss", $idBiodataSiswa, $username, $password, $currentYear);
                    $insertKelulusanStmt->execute();
                }
            }
        }

        // Close the updateClassStmt and insertKelulusanStmt
        $updateClassStmt->close();
        $insertKelulusanStmt->close();
    }

    // Redirect back to the main page
    header("Location: ../management-kenaikan-kelulusan.php");
    exit();
} else {
    // Redirect to the main page if the script is accessed directly
    header("Location: ../management-kenaikan-kelulusan.php");
    exit();
}
?>
