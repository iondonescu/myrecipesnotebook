<?php
    $connect = mysqli_connect("localhost","root","","inregistrare");
    if(mysqli_connect_errno()){
        echo "Conectare la baza de date esuata!";
    }
?>
