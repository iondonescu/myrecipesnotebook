
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- A se adauga meta tag-uri -->
    <title>Carnețelul</title>
    <link rel="stylesheet" href="styles.css">
    <link rel='icon' href='favicon.ico' type='image/x-icon'>
    <script src="https://kit.fontawesome.com/c9f2ec41c3.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body>
<!-- structura repetitiva pe mai multe pagini - index
login/sign up -->
<header id="header">
    <div class="header-inner">
        <div class="gif">
            <img class="header_gif" src="images/fire.gif" alt="fire">
        </div>
        <div class="page-title">
            <h1>My recipes notebook</h1>
        </div>

        <div class="login-section login">
            <!-- aici ar trebui sa pun un hamburger pt screen less than  px
            children trebuiesc stilizati in css pentru a fi responsive 22.10.2020
            cred ca nav bar ar trebui completata cu autentificare si inregistrare
            visible in phone/tablet mode, hide in desktop mode
            -->
            <a class="item_login" href="autentificare.html">Autentificare</a>
            <!-- DE IMPLEMENTAT (comentat 22.10.2020)
                Pagina de autentificare (pop-up window)
                1. Fetch-uesc date,
                2. Verific baza de date privind datele de autentificare cu tot ce inseamna exceptions
                3. Returnez pagina principala in partea main cu ultimele retete postate de mine
                si apoi retetele tuturor utilizatorilor
                4. De implemetat sectiune adauga retetele mele
                 to be continued
            -->
            <a class="item_login" href="inregistrare/inregistrare.php">Inregistrare</a>
            <!-- DE IMPLEMENTAT (comentat 22.10.2020)
                 Pagina de autentificare (pop-up window)
                 1. Fetch-uesc date
                 2. Verific baza de date privind datele de autentificare cu tot ce inseamna exceptions
                 3. Returnez pagina principala in partea main cu utimele retete postate
                 4. De implemetat sectiune adauga retetele mele
                  to be continued
             -->
        </div>
    </div>
</header>
<!-- sfarsit structura repetitiva -->
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
<footer >
    <div class="footer">
        <p>&copy 2020-2021 The owners of this application are Ion and Mihai Donescu</p>
    </div>
</footer>
<!-- sfarsit structura repetitiva -->

<script type="text/javascript" src="./js/start.js"></script>

</body>
</html>