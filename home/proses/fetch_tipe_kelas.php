<?php
// Include your database connection file
include "../asset/koneksi.php";

// Check if the request is made using POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if both Jurusan and Kelas values are provided
    if (isset($_POST["jurusan"]) && isset($_POST["kelas"])) {
        // Sanitize the input values to prevent SQL injection
        $jurusan = mysqli_real_escape_string($koneksi, $_POST["jurusan"]);
        $kelas = mysqli_real_escape_string($koneksi, $_POST["kelas"]);

        // Query to fetch Tipe Kelas options based on Jurusan and Kelas
        $sql = "SELECT Tipe_Kelas, Nama_Tipe_Kelas FROM kelas WHERE Jurusan = '$jurusan' AND Kelas = '$kelas'";
        $result = mysqli_query($koneksi, $sql);

        if ($result) {
            $tipeKelasOptions = array();

            // Fetch each row from the result set and add Tipe Kelas options to the array
            while ($row = mysqli_fetch_assoc($result)) {
                $tipeKelasOptions[] = array(
                    "Tipe_Kelas" => $row["Tipe_Kelas"],
                    "Nama_Tipe_Kelas" => $row["Nama_Tipe_Kelas"]
                );
            }

            // Return the Tipe Kelas options as JSON
            echo json_encode($tipeKelasOptions);
        } else {
            // If query fails, return an empty array
            echo json_encode(array());
        }
    } else {
        // If Jurusan or Kelas values are missing, return an empty array
        echo json_encode(array());
    }
} else {
    // If the request method is not POST, return an empty array
    echo json_encode(array());
}
?>
