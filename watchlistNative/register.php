<?php
    require("function.php");


    $error = "";
    $success = "";


    if(isset($_POST['tombol_register'])){
     
        if(register($_POST) === true){
            $success = "Register berhasil! Silakan login.";
  
        }else{
            $error = register($_POST);
            
        }
    }
?> 



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body{
            background-image: url(basic/wall.jpg);
            background-repeat: no-repeat;
            background-position: center;
            background-size: cover;
            background-attachment: fixed;
        }

        .brand-logo img{
            height: 100px;
            margin: 0;
        }

    .content {
        position: relative;
        z-index: 1;
        color: white;
        text-align: center;
        margin-top: 20%;
    } 

    .login-card {
            margin-top: 25%;
            padding: 30px;
            color: white;
            align-items: center;
    }
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="login-card">
                <div class="brand-logo text-center">
                    <img src="basic/logo2.png" alt="" class="mx-auto d-block"/>
                </div>
                <h3 class="text-center mb-4 text-black">Register</h3>
                
                <?php if($error) : ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= $error ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php endif; ?>


                <?php if($success) : ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= $success ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php endif; ?>

                <form action="" method="POST">
                    <div class="mb-3">
                        <input type="text" name="username" class="form-control" placeholder="👤Username" autocomplete="off" required>
                    </div>
                    <div class="mb-3">
                        <input type="email" name="email" class="form-control" placeholder="📧Email" autocomplete="off" required>
                    </div>
                    <div class="mb-3">
                        <input type="password" name="password" class="form-control" placeholder="🔐Password" autocomplete="off" required>
                    </div>
                    <button type="submit" name="tombol_register" class="btn btn-dark w-100 text-light">Register</button>
                    <p class="mt-2 text-black">Sudah punya akun? <a href="login.php">Login</a></p>
                </form>


            </div>


        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>


</body>
</html>
