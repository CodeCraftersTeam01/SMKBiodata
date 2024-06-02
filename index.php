<?php include "call_packages.php" ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biodata Siswa SMKN 1 Sumenep | Login</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="asset/image/smk.png" type="image/x-icon">
</head>

<body>
    <?php
    if (isset($_GET['Error'])) {
        if ($_GET["Error"] == "GagalLogin") {
            echo " <script>const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                  toast.onmouseenter = Swal.stopTimer;
                  toast.onmouseleave = Swal.resumeTimer;
                }
              });
              Toast.fire({
                icon: 'error',
                title: 'Username Or Password Incorrect'
              });</script>";
        }
        if ($_GET["Error"] == "WalikelasNotFound") {
            echo " <script>const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                  toast.onmouseenter = Swal.stopTimer;
                  toast.onmouseleave = Swal.resumeTimer;
                }
              });
              Toast.fire({
                icon: 'error',
                title: 'Tidak Ada Data Walikelas Yang Cocok'
              });</script>";
        }
    }
    ?>
    <form action="cek_login.php" method="post">
        <center>
            <img src="asset/image/smk.png" id="logo" class="logo" alt="">
        </center>
        <div id="inputform">
            <input  type="text" name="username" id="UsernameVALUE" placeholder="Username" class="form-control">
            <input  type="password" name="password" id="PasswordVALUE" placeholder="Password" class="form-control">
            <input  type="submit" value="Login" class="btn btn-primary">
        </div>
    </form>
   
</body>

</html>