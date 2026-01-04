<?php
session_start();
  if( !isset($_SESSION['login']) ){
      header("Location: login.php");
      exit;
  }

require ("function.php");

$jumlahDataPerHalaman = 5;
$jumlahData = count(query("SELECT * FROM watchlist"));
$jumlahHalaman = ceil($jumlahData / $jumlahDataPerHalaman);
$halamanAktif = ( isset($_GET["halaman"]) ) ? $_GET["halaman"] : 1;
$awalData = ( $jumlahDataPerHalaman * $halamanAktif ) - $jumlahDataPerHalaman;

$user_id = $_SESSION['user_id'];
$user = query("SELECT * FROM user WHERE user_id = $user_id")[0];

$query = query("
          SELECT
          watchlist.*,
          kategori.nama_kategori,
          progress.progress_id,
          progress.status_progress
          FROM watchlist
          INNER JOIN kategori ON watchlist.kategori_id = kategori.kategori_id
          LEFT JOIN progress ON watchlist.watchlist_id = progress.watchlist_id
          AND progress.user_id = $user_id
          ORDER BY watchlist.tahun_rilis ASC
          LIMIT $awalData, $jumlahDataPerHalaman
       ");    

$watchlist = $query;

 if(isset($_POST['tombol_cari'])){
      $watchlist = cari($_POST['keyword']);
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>USER</title>
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
                    <img src="profile/<?= $user['pp']?>" class="rounded-circle pp" alt="" style="border-radius: 100%">
                    <h5 class="text-light"><?= $user['username']?></h5>
                </a>
                <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-3" style="border-color: black">
                    <li class="user-header pe-5 ps-5">
                        <img src="profile/<?= $user['pp']?>" class="rounded-circle-shadow d-block mx-auto" width="40" height="40" style="object-fit: cover;border-radius: 100%" alt="foto profile">
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
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                            <!-- Tombol Previous -->
                        <?php if ($halamanAktif > 1) : ?>
                            <li class="page-item">
                                <a class="page-link" href="?halaman=<?= $halamanAktif - 1; ?>">&laquo;</a>
                            </li>
                        <?php endif; ?>


                        <!-- Daftar halaman -->
                        <?php for ($i = 1; $i <= $jumlahHalaman; $i++) : ?>
                            <?php if ($i == $halamanAktif) : ?>
                                <li class="page-item active">
                                    <a class="page-link" href="?halaman=<?= $i; ?>"><?= $i; ?></a>
                                </li>
                            <?php else : ?>
                                <li class="page-item">
                                    <a class="page-link" href="?halaman=<?= $i; ?>"><?= $i; ?></a>
                                </li>
                            <?php endif; ?>
                        <?php endfor; ?>


                        <!-- Tombol Next -->
                        <?php if ($halamanAktif < $jumlahHalaman) : ?>
                            <li class="page-item">
                                <a class="page-link" href="?halaman=<?= $halamanAktif + 1; ?>">&raquo;</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </nav> 

                <form class="mb-2" action="" method="POST">
                    <div class="input-group">
                        <input type="text" class="form-control" name="keyword" placeholder="Search..." autocomplete="off">
                        <button class="btn btn-secondary" type="submit" name="tombol_cari">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </form>
            </div>
            
            <table class="table table-hover bg-white table-wrapper">
                <tr class="bg-secondary text-light">
                    <th>No.</th>
                    <th>Judul</th>
                    <th>Kategori</th>
                    <th>Genre</th>
                    <th>Pemeran</th>
                    <th>Sinopsis</th>
                    <th>Poster</th>
                    <th>Tahun Rilis</th>
                    <th>Step</th>
                    <th></th>
                </tr>
                <?php $no=1 ?>
                <?php foreach($watchlist as $w): ?>
                <tr>
                    <td> <?= $no ?>. </td>
                    <td> <?= $w['judul'] ?> </td>
                    <td> <?= $w['nama_kategori'] ?> </td>
                    <td> <?= $w['genre'] ?> </td>
                    <td> <?= $w['aktor'] ?> </td>
                    <td> <?= $w['deskripsi'] ?> </td>
                    <td> 
                        <img src="img/<?= $w['poster'] ?> " height="140" width="100" alt="">
                    </td>
                    <td> <?= $w['tahun_rilis'] ?> </td>
                    <td>
                        <form action="status.php" method="POST">
                            <input type="hidden" name="watchlist_id" value="<?=$w['watchlist_id']?>">
                            <button type="submit" name="status" value="completed" class="btn btn-secondary">Completed</button>
                        </form>
                        <form action="status.php" method="POST">
                            <input type="hidden" name="watchlist_id" value="<?=$w['watchlist_id']?>">
                            <button type="submit" name="status" value="watching" class="btn btn-danger">Watching</button>
                        </form>
                    </td>
                    <td>
                        <a href="review.php?progress_id=<?= $w['progress_id'] ?>">
                            <button class="btn btn-secondary">Review</button>
                        </a>
                    </td>
                </tr>
                <?php $no++; ?>
                <?php endforeach; ?>
            </table>
        </div>
    </section>
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

</body>
</html>