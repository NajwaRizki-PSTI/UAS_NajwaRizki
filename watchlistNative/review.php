<?php
session_start();
require("function.php");

if ( !isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit;
}

if ( !isset ($_GET['progress_id'])) {
  header("Location: indexUser.php");
  exit;
}

$user_id = $_SESSION['user_id'];
$user = query("SELECT * FROM user WHERE user_id = $user_id")[0];

$id = $_GET['progress_id'];

$data = query("SELECT * FROM progress WHERE progress_id = $id AND user_id = $user_id");

if (empty($data)) {
  header("Location: indexUser.php");
  exit;
}

$data = $data[0];
$watchlist_id = $data['watchlist_id'];

    if(isset($_POST['tombol_submit'])){
        if(review($_POST) > 0){
            echo "
                <script>
                    alert('Review berhasil ditambahkan!');
                    document.location.href = 'indexUser.php';
                </script>
            ";
        }else{
            echo "
                <script>
                    alert('Review gagal ditambahkan!');
                    document.location.href = 'indexUser.php';
                </script>
            ";
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Review</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css"
      crossorigin="anonymous"
    />
    <style>
        body{
            background-image: url(basic/wall.jpg);
            background-position: center;
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }
        
        .brand-logo img{
            height: 100px;
            margin: 0;
        }

        .pp {
            height: 50px;
            width: 50px;
            border-radius: 50%;
            position: relative;
            cursor: pointer;
        }
    </style>
</head>
<body>

<!-- Navbar -->
 <nav class="navbar navbar-expand-lg navbar-light bg-secondary border-bottom sticky-top">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="brand-logo">
            <img src="basic/logo1.png" alt="">
        </div>
    </div>
    <div class="pe-5">
        <ul class="navbar-nav ms-auto">
            <li class="nav-item dropdown user-menu pe-5">
                <a href="#" class="nav-link d-flex align-items-center gap-2 dropdown-toggle-hidden" data-bs-toggle="dropdown">
                    <img src="profile/<?= $user['pp']?>" class="pp rounded-circle" alt="" />
                    <h5 class="text-light"><?= $user['username']?></h5>
                </a>
                <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-3">
                    <li class="user-header pe-5 ps-5">
                        <img src="profile/<?= $user['pp']?>" class="rounded-circle d-block mx-auto" width="40" height="40" style="object-fit: cover;" alt="foto profile">
                        <h3 style="text-align: center;"><?= $user['username']?></h3>
                        <h5 style="text-align: center;" class="text-black-subttle"><?= $user['role']?></h5>
                    </li>
                    <li>
                        <a href="profileUser.php" class="btn btn-secondary btn-flat">Pofile</a>
                        <a href="logout.php" class="btn btn-secondary btn-flat float-end"> Log Out</a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
 </nav>
<!-- Navbar -->

 <!-- Konten -->
<div class="p-4 container" >
        <div class="row">
            <h3 class="mb-2">Tambahkan Review</h3>
            <section>
              <a href="indexUser.php">back</a>
            </section>
            <div class="col-md-6">
                <form action="" method="POST">
                    <input type="hidden" name="watchlist_id" value="<?= $watchlist_id ?>">
                    <div>
                        <label class="form-label fw-bold">Rating</label>
                        <div class="mb-3">
                            <?php
                            for ($i = 1; $i <= 5; $i++) : ?>
                                <input type="radio" name="rating" value="<?= $i ?>" id="rate-<?= $i ?>">
                                <label for="rate-<?= $i ?>">⭐</label>
                            <?php endfor; ?>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Review</label>
                        <textarea class="form-control" name="ulasan" rows="5"></textarea>
                    </div>
                    <div class="mb-3">
                        <button type="submit" name="tombol_submit" class="btn btn-secondary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<!-- Konten -->

<!-- footer -->
 <footer class="text-center p-1 pb-0">
    <div>
        <p>Copyright &copy Kiko</p>
    </div>
 </footer>
<!-- footer -->

<script 
    src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/browser/overlayscrollbars.browser.es6.min.js"
    crossorigin="anonymous"
    ></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>