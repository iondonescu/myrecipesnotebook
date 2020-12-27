<?php

session_start();
// If the poza_profil is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
    //var_dump($_SESSION['nume']);
    //header('Location: index.php');
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
    <meta charset="utf-8">
    <title>Carnetelul</title>
    <link href="styles_home.css" rel="stylesheet" ">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
</head>
<body id="body">
<header id="header">
    <div class="header_inner">
        <div class="gif">
            <img class="header_gif" src="../fire.gif" alt="fire">
        </div>
        <div class="page_title">
            <h1>Carnețelul meu de rețete culinare</h1>
        </div>
        <div class="login_section login">
            <img class="profile_image" src="images/poza_profil/<?= $_SESSION['avatar'] ?>" alt="imagine de profil">
            <p class="item_login">Salut, <?= $_SESSION['prenume'] ?>!</p>
            <a class="item_login item_login_hover" href="../deconectare.php">Deconectează-mă!</a>
        </div>
</header>

<div class="nav_bar">
    <div class="nav_bar_items">
        <ul>
            <li><a class="item" href="../sosuri.html">Sosuri</a></li>
            <li><a class="item" href="#">Semipreparate</a></li>
            <li><a class="item" href="#">Gustări</a></li>
            <li><a class="item" href="#">Supe, ciorbe și borșuri</a></li>
            <li><a class="item" href="#">Mâncăruri</a></li>
            <li><a class="item" href="#">Fripturi și garnituri</a></li>
            <li><a class="item" href="#">Salate</a></li>
            <li><a class="item" href="#">Preparate din vânat</a></li>
            <li><a class="item" href="#">Dulciuri</a></li>
            <!-- fiecare li trebuie sa aiba corespodentul unei pagini,
            incarcata dinamic in functie de ultimile postari ca timp.19.10.2020
            a se implementa-->


        </ul>
    </div>
</div>


<main class="main_section">
    <h2 class="title_main">Rețetele mele</h2>
    <div id="retetele_mele">
        <div class="food_images auto">
            <!-- Adaugă rețetă noua 18.12.2020 -->
            <!-- de stilizat mai frumos -->
            <a id="reteta" href="reteta.php">
                <img src="chef.png" alt="Imagine_generica_reteta noua">
                <p>Adaugă rețetă nouă</p>
                <i class="fas fa-plus-circle"></i>
            </a>
        </div>

        <!-- Adaugă rețetă noua 18.12.2020 -->
        <!-- de stilizat mai frumos -->
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
                    echo '<div class="food_images auto">
                            <h3 class="titlu_reteta">' . $row["titlu"] . '</h3>
                                <img class="reteta_mea" src="' . $ownerReteta . '/' . $codReteta . '/foto/' . $file . '">'
                        .'<button class="myBtn" onclick="arataReteta(\''.$codReteta.'\')">Vezi rețeta</button>
                            </div>';
            }
        }
        ?>
    </div>

</main>
<?php
include("../footer.html");
?>
<script src="retetaMea.js" ></script>
</body>
</html>


