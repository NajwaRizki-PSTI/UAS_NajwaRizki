<?php
session_start();
require("function.php");

    if(status($_POST) > 0){
        echo "
            <script>
                alert('Progress berhasil ditambahkan!');
                document.location.href = 'indexUser.php';
            </script>
        ";
    }else{
        echo "
            <script>
                alert('Progres gagal ditambahkan!');
                document.location.href = 'indexUser.php';
            </script>
        ";
    }

?>