<?php
    $connect = mysqli_connect("localhost","root","","myrecipesnotebook");
    if(mysqli_connect_errno()){
        echo "Conectare la baza de date esuata!";
    }

?>
