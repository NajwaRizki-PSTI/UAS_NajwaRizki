<?php
session_start();
  if( !isset($_SESSION['login']) ){
      header("Location: login.php");
      exit;
  }

require("function.php");

$id = $_SESSION['user_id'];
$user = query("SELECT * FROM user WHERE user_id = $id")[0];

$id = $_GET['watchlist_id'];

$query = query("SELECT * FROM watchlist WHERE watchlist_id = $id")[0];
$watchlist = $query;

$query = query("SELECT * FROM kategori");
$kategori = $query;

    if(isset($_POST['tombol_submit'])){
        if(edit($_POST) > 0){
            echo "
                <script>
                    alert('Data berhasil ditambahkan ke database!');
                    document.location.href = 'indexAdmin.php';
                </script>
            ";
        }else{
            echo "
                <script>
                    alert('Data gagal ditambahkan ke database!');
                    document.location.href = 'indexAdmin.php';
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
    <title>Edit</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
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
                <h5 class="d-none d-md-inline"><?= $_SESSION['username']?></h5>
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

<!-- Konten -->
<div class="p-4 container">
        <div class="row">
            <h3 class="mb-2">Edit Watchlist</h1>
            <section>
                <a href="indexAdmin.php">back</a>
            </section>
            <div class="col-md-6">
                <form action="" method="POST" enctype="multipart/form-data">
                    <input type="hidden" class="form-control" name="watchlist_id" id="watchlist_id" value="<?= $watchlist['watchlist_id'] ?>" autocomplete="off">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Judul</label>
                        <input type="text" class="form-control" name="judul" id="judul" value="<?= $watchlist['judul']?>" autocomplete="off" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Kategori</label>
                        <select name="kategori_id" class="form-select" required>
                            <option value="">-- Pilih Kategori --</option>
                            <?php foreach ($kategori as $k): ?>
                                <option value="<?= $k['kategori_id'];?>"><?= $k['nama_kategori'];?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Genre</label>
                        <input type="text" class="form-control" name="genre" id="genre" value="<?= $watchlist['genre']?>" autocomplete="off" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Pemeran</label>
                        <input type="text" class="form-control" name="aktor" id="aktor" value="<?= $watchlist['aktor']?>" autocomplete="off" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Sinopsis</label>
                        <textarea class="form-control" name="deskripsi" rows="3" autocomplete="off" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Poster</label>
                        <input type="file" class="form-control" name="poster" id="poster" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Tahun Rilis</label>
                        <input type="text" class="form-control" name="tahun_rilis" id="tahun_rilis" value="<?= $watchlist['tahun_rilis']?>" autocomplete="off" required>
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>