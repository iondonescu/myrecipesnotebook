<?php
session_start();

include('../conectare.php');

if (isset($connect)) {
    $resultReteta = mysqli_query($connect, "SELECT reteta.owner,reteta.codreteta,reteta.titlu,reteta.datareteta,users.avatar FROM reteta LEFT JOIN users ON users.email = reteta.owner  ORDER BY datareteta DESC");
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <!-- Pentru a fi responsive-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- librarie de fonturi recomandata de bootstrap-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css"
          integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
    <!-- folosim framework -ul bootstrap 4.1-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css"
          integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
    <link rel="stylesheet" href="retetar.css">
    <link rel="stylesheet" href="../style.css">
    <title>Recipesnotebook</title>
</head>

<body class="d-flex flex-column min-vh-100">

<nav class="navbar navbar-expand-sm navbar-light bg-light mb-3">
    <div class="container">
        <img src="../img/avatar.png" alt="avatar-picture" style="width: 50px; height: 50px;">
        <h6 class="navbar-brand"><a href="../index.html">Carnețelul culinar</a>
            <h6>
                <button class="navbar-toggler" data-toggle="collapse" data-target="#categorie">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="categorie">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="#">Sosuri</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Semipreparate</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Gustări</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Supe/ciorbe</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Mâncăruri</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Fripturi</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Garnituri</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Salate</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Dulciuri</a>
                        </li>
                    </ul>
                    <!--                    fiecare li sa aibe un corespondent din baza de date
                       cu preparatul meu saul ale tuturor-->
                </div>
    </div>
</nav>

<div class="container">
    <div class="col text-center">
        <a href="../autentificare/autentificare.php" class="btn btn-primary btn-sm">Autentificare</a>
        <a href="../inregistrare/inregistrare.php" class="btn btn-primary btn-sm">Înregistrare</a>

    </div>
</div>
<section class="my-5 text-center">
    <div class="container">
        <h4 class="text-center mb-3">Rețetele utilizatorilor</h4>
        <div class="row">
            <!-- col-lg-3 - 4 coloane pt larger screen md-6 - 2 coloane pt medium screen -->
            <?php
            /*
             * afiseaza toate rețetele utilizatorilor
             */
            if ($resultReteta->num_rows > 0) {
                // output data of each row
                while ($row = $resultReteta->fetch_assoc()) {
                    $ownerReteta = $row["owner"];
                    $codReteta = $row["codreteta"];
                    $avatar = $row["avatar"];
                    if (isset($connect)) {
                        $resultFoto = mysqli_query($connect, "SELECT numefotografie FROM fotoretete WHERE codreteta = '$codReteta'");
                        if ($resultFoto->num_rows > 0) {
                            // output data of each row
                            $rowFoto = $resultFoto->fetch_assoc();
                            $file = $rowFoto["numefotografie"];
                            //var_dump($file);
                        }
                    }
                    echo '
                        <div class="col-lg-3 col-md-6 mb-3">                   
                            <div class="card">
                                <div class="card-body">                                               
                                 <img class="avatar img-fluid rounded-circle w-25" src="../users/images/poza_profil/'.$avatar.'" alt="avatar" >
                                 <h4 class="text-primary text-truncate">' . $row["titlu"] . '</h4>
                                 <img class="reteta" src="../' . 'users/' . $ownerReteta . '/' . $codReteta . '/foto/' . $file . '">
                                 <p class="card-text text-justify text-truncate">This is a longer card with supporting text
                                            below as a natural lead-in to additional content.This content is a little bit longer.</p>
                                 <a class="btn btn-primary btn-sm" onclick="arataReteta(\'' . $codReteta . '\')" role="button">Vizualizeză</a>
                                 </div>
                            </div>
                        </div>';
//                                        <div class="food_images auto">
//                                        <h3 class="titlu_reteta">' . $row["titlu"] . '</h3>
//                                            <img class="reteta_mea" src="' . 'users/' . $ownerReteta . '/' . $codReteta . '/foto/' . $file . '">'
//                                    . '<button class="myBtn" onclick="arataReteta(\'' . $codReteta . '\')">Vezi rețeta</button>
//                                        </div>';
                }
            }
            ?>

            <?php
            include("../footer.html");
            ?>
            <script src="../reteta.js"></script>
</body>
</html>