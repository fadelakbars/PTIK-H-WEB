<?php 

require 'function.php';

if(isset($_POST["register"])){
    if(registrasi($_POST) > 0) {
        echo "<script>
                alert('user baru berhasil ditambahkan');
                document.display.block = 'index.php';
            </script>";
    }else{
        echo mysqli_error($conn);   
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="regis.css">
    <title>Registrasi</title>
</head>
<body>
    <div class="container-fluid login">
        <form class='login-form mx-auto' method="post" action="">
            <h3 class="text-center">Silahkan Registrasi</h3>
            <div class="block inputan" style="margin-bottom: 15px; margin-top:20px;">
                <label class="lf--label" for="username">Username:</label>
                <input id="username" class='lf--input' placeholder='Username' type='text' name="username">
            </div>
            <div class="block inputan" style="margin-bottom: 15px;">
                <label class="lf--label" for="password">Password:</label>
                <input id="password" class='lf--input' placeholder='Password' type='password' name="password">
            </div>
            <div class="block inputan" style="margin-bottom: 10px;">
                <label class="lf--label" for="password">Konfirmasi Password:</label>
                <input id="password" class='lf--input' placeholder='Masukkan Ulang Password' type='password' name="password2">
            </div>
            <button type="submit" class="btn mx-auto lf--submit mt-3" name="register">Kirim</button>
        </form>
    </div>
</body>
</html>
