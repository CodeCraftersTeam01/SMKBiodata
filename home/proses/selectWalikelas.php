<?php
header('Content-Type: application/json');
 require "../asset/koneksi.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];

    $sql = "SELECT Nama_Lengkap, Kelas, Tipe_Kelas, Jurusan, Username, Password FROM walikelas WHERE ID = '$username'";
    $query = mysqli_query($koneksi, $sql);

    if ($query) {
        $dash = mysqli_fetch_array($query);
        echo json_encode($dash);
    } else {
        echo json_encode(array("error" => "Query failed"));
    }
} else {
    echo json_encode(array("error" => "Invalid request method"));
}

mysqli_close($koneksi);
?>
