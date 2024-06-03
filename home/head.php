<?php include "../call_packages.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="../asset/image/smk.png" type="image/x-icon">
</head>

<body style="overflow-x: hidden; ">

    <?php
    if ($_SESSION['status'] != "login") {
        header("location:../index.php?Error=GagalLogin");
    } ?>
    <!-- Sidebar -->
    <div class="grid" id="grid">
        <div class="sidebar" onmouseenter="mouseenter()" onmouseleave="mouseleave()" id="sidebar">
            <div id="header-side" class="header-side">
                <div class="row">
                    <div class="col-2"><text class="icon"><img src="../asset/image/smk.png" width="40px" alt=""></text></div>
                    <div class="col"><text class="text">
                            <p><b>SMKN 1 SUMENEP</b></p>
                        </text></div>
                </div>
            </div>
            <a class="pinned" href="index.php"><text class="icon"><ion-icon name="earth"></ion-icon></text> <text class="text">Dashboard</text></a>
            <hr>
            <div class="dropdown level_user-1">
                <a class="dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"><text class="icon"><ion-icon name="person"></ion-icon></text> <text class="text">Management User</text></a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="management-walikelas.php">Walikelas</a></li>
                    <li><a class="dropdown-item" href="management-admin.php">Admin</a></li>
                </ul>
            </div>
            <a href="management-siswa.php" class="level_user-3"><text class="icon"><ion-icon name="people"></ion-icon></text> <text class="text"><div id="management-siswa">Management Siswa</div></text></a>
            <a href="management-kenaikan-kelulusan.php" class="level_user-1"><text class="icon"><ion-icon name="document-text"></ion-icon></text> <text class="text">Kenaikan / Kelulusan</text></a>
            <a href="set-kenaikan-kelulusan.php" class="level_user-1"><text class="icon"><ion-icon name="time"></ion-icon></text> <text class="text">Set Waktu Kelulusan</text></a>
            <a href="management-kelas.php" class="level_user-1"><text class="icon"><ion-icon name="home"></ion-icon></text> <text class="text">Management Kelas</text></a>
            <a href="checkKelulusan.php" class="level_user-special"><text class="icon"><ion-icon name="medal"></ion-icon></text> <text class="text">Check Kelulusan</text></a>
            <a href="https://smk1sumenep.sch.id/" class="level_user-notAdmin"><text class="icon"><ion-icon name="globe"></ion-icon></text> <text class="text">SMKN 1 Sumenep</text></a>
            <a href="sipPKL.php" class="level_user-notAdmin"><text class="icon"><ion-icon name="document"></ion-icon></text> <text class="text">SIP PKL</text></a>
            <div class="dropdown">
                <a class="dropdown-toggle level_user-3" type="button" data-bs-toggle="dropdown" aria-expanded="false"><text class="icon"><ion-icon name="download"></ion-icon></text> <text class="text">Ijasah</text></a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item level_user-2" href="IjasahSiswa.php">Download Ijasah</a></li>
                    <li><a class="dropdown-item level_user-notAdmin" data-bs-toggle="modal" data-bs-target="#exampleModalUploadIjazah">Upload Ijasah</a></li>
                </ul>
            </div>
            <div class="dropdown">
                <a class="dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"><text class="icon"><ion-icon name="cog"></ion-icon></text> <text class="text">Settings</text></a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="profile.php">Profile</a></li>
                    <li><a class="dropdown-item" onclick="logout()">Logout</a></li>
                </ul>
            </div>
        </div>
        <div class="modal fade" id="exampleModalUploadIjazah" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Upload Ijazah</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <form method="post" action="uploadIjasah.php" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-sm"><input required type="file" name="file" class="form-control" id=""></div>
                            <div class="col-sm-2"><input required type="submit" name="UploadExcel" value="Kirim" class="btn btn-success"></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
        <div style="width:100%; overflow-x:hidden;">
            <div class="header" id="header">
                <!-- Hamburger menu icon for mobile view -->
                <div class="hamburger" id="hamburger" onclick="openNav()">&#9776;</div>
                <div class="hamburger2" id="hamburger2" onclick="closeNav()">&#9776;</div>
                <div class="logout" title="Logout"><a onclick="logout()"><ion-icon name="log-out"></ion-icon></a></div>
            </div>
       
</body>

</html>