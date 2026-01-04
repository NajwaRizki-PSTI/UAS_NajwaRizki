<?php
session_start();
  if( isset($_SESSION['login']) ){
      header("Location: login.php");
      exit;
  }

require("function.php");

$error = "";
if( isset($_POST['tombol_login']) ){

    $user = login($_POST);

    if(is_array($user)){
        if($user['role'] === 'admin'){
        header("Location: indexAdmin.php");
        exit;
        }else{
        header("Location: indexUser.php");
        exit;
        }
    }else{
        $error = $user;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
    body{
            background-image: url(basic/wall.jpg);
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
            margin-bottom: 0;
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
                <h3 class="text-center mb-4 text-black">Login</h3>

                <?php if($error) : ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= $error ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php endif; ?>


                <form action="" method="POST">
                    <div class="mb-3">
                        <input type="text" name="username" class="form-control" placeholder="👤Username" autocomplete="off" required>
                    </div>
                    <div class="mb-3">
                        <input type="password" name="password" class="form-control" placeholder="🔐Password" autocomplete="off" required>
                    </div>
                    <button type="submit" name="tombol_login" class="btn btn-dark w-100">Login</button>
                    <p class="mt-2 text-black">Belum punya akun? <a href="register.php">Register</a></p>
                </form>


            </div>


        </div>
    </div>
</div>


<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script
      src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/browser/overlayscrollbars.browser.es6.min.js"
      crossorigin="anonymous"
    ></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js"></script>



</body>
</html>