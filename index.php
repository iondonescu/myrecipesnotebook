<?php
session_start();
// If the poza_profil is not logged in redirect to the login page...

include('conectare.php');

if (isset($connect)) {
    $resultReteta = mysqli_query($connect, "SELECT owner,codreteta,titlu,datareteta FROM reteta ORDER BY datareteta DESC");
}

if (isset($connect)) {
    $resultFoto = mysqli_query($connect, "SELECT codreteta,owner,numefotografie FROM fotoretete ");
};


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- A se adauga meta tag-uri -->
    <title>Carnețelul</title>

    <link rel="stylesheet" href="users/styles_home.css">
    <link rel='icon' href='favicon.ico' type='image/x-icon'>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
</head>

<body id="body">
<!-- structura repetitiva pe mai multe pagini - index
login/sign up -->
<header id="header">
    <div class="header_inner">
        <div class="gif">
            <img class="header_gif" src="fire.gif" alt="fire">
        </div>
        <div class="page_title">
            <h1>Carnețelul de rețete culinare</h1>
        </div>
        <div class="login_section login">
            <!-- aici ar trebui sa pun un hamburger pt screen less than  px
            children trebuiesc stilizati in css pentru a fi responsive 22.10.2020
            cred ca nav bar ar trebui completata cu autentificare si inregistrare
            visible in phone/tablet mode, hide in desktop mode
            -->
            <a class="item_login" href="autentificare/autentificare.php">Autentificare</a>
            <a class="item_login" href="inregistrare/inregistrare.php">Inregistrare</a>
        </div>
    </div>

</header>
<!-- sfarsit structura repetitiva -->
<div class="nav_bar">
    <div class="nav_bar_items">
        <ul>
            <li><a class="item" href="./sosuri.html">Sosuri</a></li>
            <li><a class="item" href="#">Semipreparate</a></li>
            <li><a class="item" href="#">Gustări</a></li>
            <li><a class="item" href="#">Supe, ciorbe și borșuri</a></li>
            <li><a class="item" href="#">Mâncăruri</a></li>
            <li><a class="item" href="#">Fripturi și garnituri</a></li>
            <li><a class="item" href="#">Salate</a></li>
            <li><a class="item" href="#">Preparate din vânat</a></li>
            <li><a class="item" href="#">Dulciuri</a></li>
            <!-- fiecare li trebuie sa aiba corespodentul unei pagini,
            incarcata dinamic in functie de ultimile postari ca timp.19.10.2020 -->

        </ul>
    </div>
</div>


<main class="main_section">
    <h2 class="title_main">Rețetele utilizatorilor</h2>
    <div id="retetele_mele">
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
                            <div class="food_images auto">
                            <h3 class="titlu_reteta">' . $row["titlu"] . '</h3>
                                <img class="reteta_mea" src="' . 'users/' . $ownerReteta . '/' . $codReteta . '/foto/' . $file . '">'
                        . '<button class="myBtn" onclick="arataReteta(\'' . $codReteta . '\')">Vezi rețeta</button>
                            </div>';
                }
            }
            ?>
        </div>

</main>
<?php
include("footer.html");
?>
<script src="reteta.js" ></script>
</body>
</html>