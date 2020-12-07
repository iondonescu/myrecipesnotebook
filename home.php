<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
    var_dump($_SESSION['nume']);
    //header('Location: index.php');
    exit;
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Home Page</title>
    <link href="styles.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
</head>
<body >
<header id="header">
    <div class="header-inner">
        <div class="gif">
            <img class="header_gif" src="images/fire.gif" alt="fire">
        </div>
        <div class="page-title">
            <h1>Carnețelul de rețete culinare</h1>
        </div>
        <div class="login-section login">
            <p class="item-login">Welcome, <?=$_SESSION['prenume']?>!</p>
            <img class="item-login" src="images/users/<?=$_SESSION['avatar']?>" width="30" height="30" alt="imagine de profil">
            <a class="item-login" href="deconectare/deconectare.php"></>Logout</a>
        </div>
</header>

<div class="nav-bar">
    <div class="nav-bar-items">
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


<main class="main-section">
    <div class="food-images auto">
        <!-- aici trebuie lucrat la view:
        -adaugat owner-ul, 5-6 imagini/ reteta/ display etc 19.10.2020-->
        <img class="food-image food-image-display-block" src="images/friptura_de_porc_1.jpg" alt="friptura_de_porc"/>
        <img class="food-image food-image-display-none" src="images/friptura_de_porc_2.jpg" alt="friptura_de_porc"/>

        <i class="left-button left-button-float fas fa-arrow-circle-left"></i>
        <i class="right-button right-button-float fas fa-arrow-circle-right"></i>
    </div>
</main>
<!-- structura repetitiva pe mai multe pagini - index
login/sign up -->
<footer>
    <div class="footer">
        <p>&copy 2020-2021 The owners of this application are Ion and Mihai Donescu</p>
    </div>
</footer>
</body>
</html>


