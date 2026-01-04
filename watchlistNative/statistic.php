<?php
session_start();
if( !isset($_SESSION['login']) || $_SESSION['role'] !== 'admin' ){
      header("Location: indexUser.php");
      exit;
  }

  require('function.php');

  $id = $_SESSION['user_id'];
  $user = query("SELECT * FROM user WHERE user_id = $id")[0];

  $user_id = $_SESSION['user_id'];

  $data = query("
     SELECT watchlist.judul,
     user.username,
     progress.ulasan,
     progress.rating,
     AVG(progress.rating) AS rating
     FROM progress
     INNER JOIN watchlist ON progress.watchlist_id = watchlist.watchlist_id
     INNER JOIN user ON progress.user_id = user.user_id
     WHERE progress.rating IS NOT NULL
     GROUP BY watchlist.watchlist_id
  ");
  
  $progress = query("
     SELECT watchlist.judul,
     user.username,
     progress.ulasan,
     progress.rating
     FROM progress
     INNER JOIN watchlist ON progress.watchlist_id = watchlist.watchlist_id
     INNER JOIN user ON progress.user_id = user.user_id
     WHERE progress.rating IS NOT NULL
  ");

  $labels = [];
  $values = [];

  foreach ($data as $d) {
    $labels[] = $d['judul'];
    $values[] = $d['rating'];
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistic</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css"
      crossorigin="anonymous"
    />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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
        <img src="basic/logo1.png" alt="" />
      </div>
  </div>
  <div class="pe-5">
    <ul class="navbar-nav ms-auto">
        <li class="nav-item dropdown user-menu pe-5">
            <a href="#" class="nav-link d-flex align-items-center gap-2 dropdown-toggle-hidden" data-bs-toggle="dropdown">
                <img src="profile/<?= $user['pp']?>" class="rounded-circle pp"  alt="foto profile"/>
                <h5 class="text-light"><?= $_SESSION['username']?></h5>
            </a>
            <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-3">
            <li class="user-header pe-5 ps-5">
                <img src="profile/<?= $user['pp']?>" class="rounded-circle d-block mx-auto" width="40" height="40" style="object-fit: cover;" alt="foto profile"/>
                <h3 style="text-align: center;"><?= $_SESSION['username']?></h3>
                <h5 style="text-align: center;" class="text-secondary"><?= $_SESSION['role']?></h5>
            </li>
            <li>
                <a href="profileAdmin.php" class="btn btn-secondary btn-flat">Profile</a>
                <a href="logout.php" class="btn btn-secondary btn-flat float-end">Log out</a>
            </li>
            </ul>
        </li>
    </ul>
  </div>
</nav>
<!-- Navbar -->

<!-- Diagram -->
<section class="p-3 bg-light-subtle">
    <div class="container">
      <div class="col-sm-12 d-flex justify-content-center">
          <ul class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="indexAdmin.php" class="text-dark text-decoration-none fw-bold">Watchlist</a></li>
            <li class="breadcrumb-item"><a href="statistic.php" class="text-dark text-decoration-none fw-bold">Statistic</a></li>
          </ul>
      </div>
        <h3 class="text-center ">Data Rating</h3>
        <div class="card shadow">
            <div class="card-body">
                <div style="height: 400px">
                    <canvas id="ratingChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Diagram -->

<!-- Isi diagram -->
<script>
    const labels = <?= json_encode($labels) ?>;
    const values = <?= json_encode($values) ?>;

    const ctx = document.getElementById('ratingChart');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Rata-Rata',
                data: values,
                backgroundColor: 'grey',
                borderRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    max: 10,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
</script>
<!-- Isi diagram -->

<!-- review -->
    <section id="" class="p-3 pb-5">
      <div class="container">
        <h3 class="text-center">Ulasan</h3>
        <div class="row row-cols-1 row-cols-md-2 g-4 ">
          <?php foreach ($progress as $p) : ?>
          <div class="col">
            <div class="card">
              <div class="card-body shadow">
                <h5 class="card-title fw-bold"> <?= $p['judul'] ?> <h6> Review's by: <?= $p['username'] ?></h6></h5>
                <p class="card-text"> <?= $p['ulasan'] ?> </p>
                <p class="card-text"> ⭐<?= $p['rating'] ?> </p>
              </div>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
      </div>
    </section>
 <!-- review -->

 <!-- footer -->
    <footer class="text-center p-1 pb-0">
      <div>
        <p>Copyright &copy Kiko</p>
      </div>
    </footer>
<!-- footer -->

 <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js"></script>

</body>
</html>