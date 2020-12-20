<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- A se adauga meta tag-uri -->
    <title>Carnețelul</title>
    <link rel="stylesheet" href="styles_index.css">
    <link rel='icon' href='favicon.ico' type='image/x-icon'>
    <script src="https://kit.fontawesome.com/c9f2ec41c3.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body>
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
        <ul >
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
    <div class="food_images auto">
        <!-- aici trebuie lucrat la view:
        -adaugat owner-ul, 5-6 imagini/ reteta/ display etc 19.10.2020-->

    </div>
</main>
<?php
include("footer.html");
?>
</body>
</html>