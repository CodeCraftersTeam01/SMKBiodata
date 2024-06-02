<?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Tentukan folder upload
        $target_dir = "Ijasah_Siswa/";
        
        // Buat folder jika belum ada
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        
        $target_file = $target_dir . basename($_FILES["file"]["name"]);
        $uploadOk = 1;
        $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        
        // Tentukan ekstensi file yang diperbolehkan
        $allowed_extensions = array("pdf");
        
        // Periksa apakah file sudah ada
        if (file_exists($target_file)) {
            echo "Maaf, file sudah ada.";
            $uploadOk = 0;
        }
        
        // Periksa ukuran file
        if ($_FILES["file"]["size"] > 5000000) { // Batas ukuran 5MB
            echo "Maaf, file Anda terlalu besar.";
            $uploadOk = 0;
        }
        
        // Periksa ekstensi file
        if (!in_array($fileType, $allowed_extensions)) {
            echo "Maaf, hanya file dengan ekstensi PDF yang diperbolehkan.";
            $uploadOk = 0;
        }
        
        // Periksa apakah $uploadOk bernilai 0 karena kesalahan
        if ($uploadOk == 0) {
            echo "Maaf, file Anda tidak dapat diupload.";
        // Jika semuanya oke, coba upload file
        } else {
            if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
                echo "File ". htmlspecialchars(basename($_FILES["file"]["name"])). " telah berhasil diupload.";
                header("location:index.php");
            } else {
                echo "Maaf, terjadi kesalahan saat mengupload file Anda.";
            }
        }
    }
    ?>