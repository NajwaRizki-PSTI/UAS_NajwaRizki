<?php

$conn = mysqli_connect('localhost', 'root', '', 'watchlistnative');

function query($query) {
    global $conn;

    $result = mysqli_query($conn, $query);
    $rows = [];
    while( $row = mysqli_fetch_assoc($result) ) {
        $rows[] = $row;
    }
    return $rows;
}

function tambah($data){
    global $conn;

    $judul = $data['judul'];
    $kategori_id = $data['kategori_id'];
    $genre = $data['genre'];
    $aktor = $data['aktor'];
    $deskripsi = $data['deskripsi'];
    $poster = $data['poster'];
    $tahun_rilis = $data['tahun_rilis'];

    $poster = upload_gambar($judul);
    if( !$poster){
        return false;
    }

    $query = "INSERT INTO watchlist (judul, kategori_id, genre, aktor, deskripsi, poster, tahun_rilis)
                  VALUES ('$judul', '$kategori_id', '$genre', '$aktor', '$deskripsi', '$poster', '$tahun_rilis')
                 ";
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);  
}

function review($data){
    global $conn;

    $user_id = $_SESSION['user_id'];
    $watchlist_id = $data['watchlist_id'];
    $rating = $data['rating'];
    $ulasan = $data['ulasan'];

    $query = "UPDATE progress SET
               rating = '$rating',
               ulasan = '$ulasan'
            WHERE user_id = $user_id
            AND watchlist_id = $watchlist_id   
    ";

    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn); 
}

function hapus($id){
    global $conn;

    $query = "DELETE FROM watchlist WHERE watchlist_id = $id";

    $result = mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);    
}

function edit($data){
    global $conn;

    $watchlist_id = $data['watchlist_id'];
    $judul = $data['judul'];
    $kategori_id = $data['kategori_id'];
    $genre = $data['genre'];
    $aktor = $data['aktor'];
    $deskripsi = $data['deskripsi'];
    $tahun_rilis = $data['tahun_rilis'];

    $posterLama = $data['posterLama'];

    if( $_FILES['poster']['error'] === 4 ){
        $poster = $posterLama;
    }else{
        $poster = upload_gambar($judul);
        if(!$poster){
            return false;
        }
        if(file_exists('img/' . $posterLama)){
            unlink('img/' . $posterLama);
        }
    }

    // var_dump($data);
    // die();

    $query = "UPDATE watchlist SET
                judul = '$judul',
                kategori_id = '$kategori_id',
                genre = '$genre',
                aktor = '$aktor',
                deskripsi = '$deskripsi',
                tahun_rilis = '$tahun_rilis',
                poster = '$poster'
             WHERE watchlist_id = $watchlist_id   
            ";

    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

function upload_gambar($judul) {

    $namaFile = $_FILES['poster']['name'];
    $ukuranFile = $_FILES['poster']['size'];
    $error = $_FILES['poster']['error'];
    $tmpName = $_FILES['poster']['tmp_name'];

    if( $error === 4 ) {
        echo "<script>
                alert('pilih gambar terlebih dahulu!');
              </script>";
        return false;
    }

    $ekstensiValid = ['jpg', 'jpeg', 'png'];
    $ekstensiGambar = strtolower(pathinfo($namaFile, PATHINFO_EXTENSION));

    if( !in_array($ekstensiGambar, $ekstensiValid) ) {
        echo "<script>
                alert('yang anda upload bukan gambar!');
              </script>";
        return false;
    }

    if( $ukuranFile > 2000000 ) {
        echo "<script>
                alert('ukuran gambar terlalu besar!');
              </script>";
        return false;
    }

    $namaFileBaru ="_" .preg_replace('/\s+/', '_', $judul) . "_" . uniqid();
    $namaFileBaru .= '.' . $ekstensiGambar;

    move_uploaded_file($tmpName, 'img/' . $namaFileBaru);


    return $namaFileBaru;
}

function cari($keyword){
    global $conn;

    $query = "SELECT 
              watchlist.*, kategori.nama_kategori
              FROM watchlist
              INNER JOIN kategori ON watchlist.kategori_id = kategori.kategori_id
			  WHERE
			  watchlist.judul LIKE '%$keyword%' OR
              watchlist.tahun_rilis LIKE '%$keyword%' OR
              watchlist.aktor LIKE '%$keyword%' OR
              watchlist.genre LIKE '%$keyword%'
              ORDER BY watchlist.tahun_rilis DESC 
			";
	return query($query);
}

function register($data_register){
    global $conn;

   // tampung data
    $username = $data_register['username'];
    $email    = $data_register['email'];
    $password = mysqli_real_escape_string($conn, $data_register['password']);

    // cek username sudah ada atau belum
    $query  = "SELECT * FROM user WHERE username = '$username' OR email = '$email'";
    $result = mysqli_query($conn, $query);

    // jika ada user dengan username atau email tersebut
    if(mysqli_num_rows($result) > 0){
        $row = mysqli_fetch_assoc($result);

        // cek username duplikat
        if($row['username'] == $username){
            return "Username sudah terdaftar!";
        }
        // cek email duplikat
        if($row['email'] == $email){
            return "Email sudah terdaftar. Gunakan email lain!";
        }
    }

    // cek panjang password
    if(strlen($password) < 8){
        return "Password harus lebih atau sama dengan 8!";
    }

    $password = password_hash($password, PASSWORD_DEFAULT);

    mysqli_query($conn, "INSERT INTO user (user_id, username, email, password) VALUES('', '$username', '$email', '$password')");

    return true;
}

function login($data){
    global $conn;


    $username = $data['username'];
    $password = $data['password'];

    $query = "SELECT * FROM user WHERE username = '$username'";
    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) === 1){
        $row = mysqli_fetch_assoc($result);

        if(password_verify($password, $row["password"])) {
            $_SESSION['login'] = true;
            $_SESSION['username'] = $row['username'];
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['role'] = $row['role'];
           
            return $row;
        } else {
            return "Password salah!";
        }

    } else {
        return "Username tidak ditemukan!"; 
    }
   
}

function status($data){
    global $conn;
    session_start();

    if (!isset($_SESSION['user_id'])){
        return -1;
    }

    $user_id = $_SESSION['user_id'];
    $watchlist_id = $data['watchlist_id'];
    $status_progress = $data['status'];

    $cek = mysqli_query($conn,
        "SELECT * FROM progress
        WHERE user_id = $user_id AND watchlist_id = $watchlist_id");

    if (mysqli_num_rows($cek) > 0) {
        $query = "UPDATE progress SET
                    status_progress = '$status_progress'
                  WHERE user_id = $user_id
                  AND watchlist_id = $watchlist_id";
    }   else {
        $query = "INSERT INTO progress (user_id, watchlist_id, status_progress)
                    VALUES ('$user_id', '$watchlist_id', '$status_progress')";
    }
    
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

function profileAdmin($data){
    global $conn;

    $user_id = $data['user_id'];
    $username = $data['username'];
    $bio = $data['bio'];
    $tanggal_lahir = $data['tanggal_lahir'];
    $email = $data['email'];
    
    $result = mysqli_query($conn, "SELECT pp FROM user WHERE user_id = $user_id");
    $ppLama = mysqli_fetch_assoc($result)['pp'];

    if ($_FILES['pp']['error'] === 4) {
        $pp = $ppLama;
    } else {
        $pp = upload_pp($username);
        if (!$pp) {
            return false;
        }
    }

    $query = "UPDATE user SET
                username = '$username',
                bio = '$bio',
                tanggal_lahir = '$tanggal_lahir',
                email = '$email',
                pp = '$pp'
             WHERE user_id = $user_id   
            ";

    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

function upload_pp($username) {

    $namaFile = $_FILES['pp']['name'];
    $ukuranFile = $_FILES['pp']['size'];
    $error = $_FILES['pp']['error'];
    $tmpName = $_FILES['pp']['tmp_name'];

    $ekstensiValid = ['jpg', 'jpeg', 'png'];
    $ekstensiGambar = strtolower(pathinfo($namaFile, PATHINFO_EXTENSION));

    if( !in_array($ekstensiGambar, $ekstensiValid) ) {
        echo "<script>
                alert('yang anda upload bukan gambar!');
              </script>";
        return false;
    }

    if( $ukuranFile > 2000000 ) {
        echo "<script>
                alert('ukuran gambar terlalu besar!');
              </script>";
        return false;
    }

    $namaFileBaru ="_" .preg_replace('/\s+/', '_', $username) . "_" . uniqid();
    $namaFileBaru .= '.' . $ekstensiGambar;

    move_uploaded_file($tmpName, 'profile/' . $namaFileBaru);


    return $namaFileBaru;
}
?>