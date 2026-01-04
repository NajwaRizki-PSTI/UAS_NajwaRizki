<?php
session_start();
  if( !isset($_SESSION['user_id']) ){
      header("Location: login.php");
      exit;
  }

  require ("function.php");

  $user_id = $_SESSION['user_id'];
  $user = query("SELECT * FROM user WHERE user_id = $user_id")[0];

$query = query("
          SELECT
          p.progress_id,
          p.status_progress,
          p.rating,
          p.ulasan,
          w.judul,
          w.poster
          FROM progress AS p
          INNER JOIN watchlist AS w ON p.watchlist_id = w.watchlist_id
          WHERE p.user_id = $user_id
       ");    

$progress = $query;

 if(isset($_POST['tombol_cari'])){
      $watchlist = cari($_POST['keyword']);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Watch Progress</title>
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
                    <img src="profile/<?= $user['pp']?>" class="rounded-circle pp" alt="">
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

<!-- Konten status-->
<section class="p-3">
        <div class="container">
            <div class="col-sm-12 d-flex justify-content-center">
                <ul class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="indexUser.php"class="text-dark text-decoration-none fw-bold">Watchlist</a>
                    </li>
                    <li class="breadcrumb-item"><a href="progress.php"class="text-dark text-decoration-none fw-bold">Progress</a>
                    </li>
                </ul>
            </div>
            <div class="d-flex justify-content-between align-items-center">
                <form class="mb-2" action="" method="POST">
                    <div class="input-group">
                        <input type="text" class="form-control" name="keyword" placeholder="Search..." autocomplete="off">
                        <button class="btn btn-secondary" type="submit" name="tombol_cari">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>
<!-- Konten Status-->

<!-- Konten Review -->
    <section id="project" class="bg-secondary-subtle p-3 pb-5">
      <div class="container">
        <?php if (empty($progress)) : ?>
          <p class="text-center fw-bold">Belum Ada Progress</p>
        <?php else : ?>

        <div class="row row-cols-6 row-cols-md-7 g-4">
          <?php foreach ($progress as $p) : ?>
          <div class="col">
            <div class="card">
              <img
                src="img/<?= $p['poster'] ?>"
                class="card-img-top"
                height="200"
                width="100"
                alt="..."
              />
              <div class="card-body">
                <h5 class="card-title"> <?= $p['judul'] ?> </h5>
                <h6><?= $p['status_progress'] ?></h6>
                <p class="card-text"> Review:<br><?= $p['ulasan'] ?> </p>
                <p class="card-text"> ⭐<?= $p['rating'] ?> </p>
              </div>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
        <?php endif; ?>
      </div>
    </section>
<!-- Konten Review -->

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


</body>
</html>