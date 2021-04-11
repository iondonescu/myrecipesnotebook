<?php
    //$connect = mysqli_connect( "hosting2099202.online.pro","00399512_myrecipesnotebook","Student%2018av","00399512_myrecipesnotebook");
    $connect = mysqli_connect( "localhost","root","","myrecipesnotebook");
    if(mysqli_connect_errno()){
        echo "Conectare la baza de date esuata!";
    }

?>
