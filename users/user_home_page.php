<?php

session_start();
// If the poza_profil is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
    //var_dump($_SESSION['nume']);
    //header('Location: vizitator.php');
    exit;
}
include('../conectare.php');
$owner = $_SESSION['email'];
if (isset($connect)) {
    $resultReteta = mysqli_query($connect, "SELECT owner,codreteta,titlu,datareteta FROM reteta WHERE owner = '$owner' ORDER BY datareteta DESC");
}


?>
<!DOCTYPE html>
<html>
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
    <link rel="stylesheet" href="styles_home.css">
    <link rel="stylesheet" href="../vizitator/retetar.css">

    <title>Recipesnotebook</title>
</head>
<body id="body" class="py-3 d-flex flex-column body" style="max-width: 1200px">
<header class="container d-flex justify-content-between">
    <img src="images/poza_profil/<?= $_SESSION['avatar'] ?>" alt="imagine-de-profil"
         style="width: 50px; height: 50px;border-radius: 10px">
    <h4 class="mx-2">Carnețelul meu culinar</h4>
    <div class="float-right">
        <p >Bine ai venit, <?= $_SESSION['prenume'] ?>!</p>
       <a href="../deconectare.php" class="btn btn-danger btn-sm float-right">Deconectare</a>
    </div>
</header>
<nav class="navbar navbar-expand-sm navbar-light bg-light mb-3 my-3">
    <div class="container">
        <?php
        include("../navbar/navbar.html");
        ?>

    </div>
</nav>

<div class="container w-100 mx-4 ">
    <a class="adauga-reteta float-right" id="reteta" href="reteta_noua.php">
        <img class="adauga" src="../img/avatar.png" alt="Imagine_generica_reteta noua">
        Adaugă rețetă nouă
    </a>

</div>


<section class="my-auto mx-2 text-center">
    <div class="container">
        <h2 class="text-center mb-3">Rețetele mele</h2>
        <div class="row">

            <?php
            /*
             * afiseaza toate rețetele mele
             */
            if ($resultReteta->num_rows > 0) {
                // output data of each row
                while ($row = $resultReteta->fetch_assoc()) {
                    $ownerReteta = $row["owner"];
                    $codReteta = $row["codreteta"];
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
                                        <h5 class="text-primary text-truncate">' . $row["titlu"] . '</h5>
                                        <div class="fotocontainer">
                                            <img class="reteta" src="' . $ownerReteta . '/' . $codReteta . '/foto/' . $file . '" alt="avatar">
                                     
                                        </div>
                                        <p class="card-text text-justify ">'.'<div class="container text-truncate">'.
                        file_get_contents($ownerReteta . '/' . $codReteta . '/descriere_' . $codReteta . '.txt').'</div>'.'
                                        <a class="myBtn btn btn-primary btn-sm" onclick="arataReteta(\'' . $codReteta . '\')" role="button">Vizualizeză</a>
                                   </div>
                                </div>
                                
                        </div>';
                }
            }
            ?>
        </div>
    </div>
</section>


<?php
include("../footer.html");
?>
<script src="reteta_mea.js"></script>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous">
</script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"
        integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous">
</script>
</body>
</html>


