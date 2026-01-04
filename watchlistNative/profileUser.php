<?php
session_start();
  if( !isset($_SESSION['login']) ){
      header("Location: login.php");
      exit;
  }

  require("function.php");

  $id = $_SESSION['user_id'];
  $user = query("SELECT * FROM user WHERE user_id = $id")[0];

  if(isset($_POST['tombol_submit'])){
        if(profileAdmin($_POST) > 0){
            echo "
                <script>
                    alert('Profile berhasil diperbarui!');
                    document.location.href = 'profileUser.php';
                </script>
            ";
        }else{
            echo "
                <script>
                    alert('Profile gagal diperbarui!');
                    document.location.href = 'profileUser.php';
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
    <title>Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css"
      crossorigin="anonymous"
    />
    <style>
        .brand-logo img{
            height: 100px;
            margin: 0;
        }

        .pp {
          height: 280px;
          width: 280px;
          border-radius: 50%;
          position: relative;
          margin: 20px;
          cursor: pointer;
        }

        .pp img{
          height: 100%;
          width: 100%;
          object-fit: cover;
        }
    </style>
</head>
<body>
    <!-- navbar -->
     <nav class="navbar navbar-expand-lg navbar-light bg-secondary border-bottom sticky-top">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
       <div class="brand-logo">
            <img src="basic/logo1.png" alt="" />
       </div>
       </div>
     </nav>
  <!-- navbar -->

  <!-- konten -->
   <section id="project" class="p-3 pb-5">
    <a href="indexUser.php" class="btn btn-secondary mb-2">back</a>
      <div class="container">
        <form method="POST" enctype="multipart/form-data">
        <input type="hidden" class="form-control" name="user_id" id="user_id" value="<?= $user['user_id'] ?>" autocomplete="off">
        <div class="row row-cols-1 row-cols-md-2 g-4 gt-1">
          <div class="col">
            <div class="card">
              <div class="profile-wrapper text-center mb-3">
                <label for="pp">
                  <div class="pp">
                    <img src="profile/<?= $user['pp']?>" class="rounded-circle shadow" alt="foto profile" id=""/>
                    <div class="camera-icon">
                      <i class="bi bi-camera-fill"></i>
                    </div>
                  </div>
                </label>
                <input type="file" name="pp" id="pp" accept="image/*" hidden>
              </div>
              <div class="card-body">
                <h5 class="card-title text-center"><?= $user['username']?></h5>
                <p class="card-text text-center">
                  <?= $user['email']?>
                </p>
              </div>
            </div>
          </div>
          <div class="col">
            <div class="card">
              <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Username</label>
                        <input type="text" class="form-control" name="username" id="username" value="<?= $user['username']?>" autocomplete="off" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Bio</label>
                        <input type="text" class="form-control" name="bio" id="bio" value="<?= $user['bio']?>" autocomplete="off" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Tanggal Lahir</label>
                        <input type="date" class="form-control" name="tanggal_lahir" id="tanggal_lahir" value="<?= $user['tanggal_lahir']?>" autocomplete="off" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Email</label>
                        <input type="text" class="form-control" name="email" id="email" value="<?= $user['email']?>" autocomplete="off" required>
                    </div>
                    <div class="mb-3">
                        <button type="submit" name="tombol_submit" class="btn btn-secondary">Save</button>
                    </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <ul class="ms-auto list-unstyled p-1">
            <li>
                <a class="text-secondary fw-bold" href="https://api.whatsapp.com/send?phone=6285641820797&text=Halo%20saya%20tertarik%20menjadi%20admin%20website%20ini">
                    Hubungi Admin Web</a>
            </li>
            <li><a class="text-secondary fw-bold" href="">Bantuan❔</a></li>
        </ul>
      </div>
    </section>
    <!-- konten -->

    <!-- footer -->
<footer class="text-center p-1 pb-0">
      <div>
        <p>Copyright &copy Kiko</p>
      </div>
    </footer>
<!-- footer -->
    
</body>
</html>