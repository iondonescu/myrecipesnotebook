<?php

session_start();
// If the poza_profil is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
    //var_dump($_SESSION['nume']);
    //header('Location: index.php');
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- A se adauga meta tag-uri -->
    <title>Carnețelul</title>
    <link rel="stylesheet" href="styles_home.css">
    <link rel='icon' href='../users/favicon.ico' type='image/x-icon'>
    <script src="https://kit.fontawesome.com/c9f2ec41c3.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body>
<header id="header">
    <div class="header_inner">
        <div class="gif">
            <img class="header_gif" src="../fire.gif" alt="fire">
        </div>
        <div class="page_title">
            <h1>Carnețelul de rețete culinare</h1>
        </div>

        <div class="login_section login">
            <img class="profile_image" src="images/poza_profil/<?= $_SESSION['avatar'] ?>" alt="imagine de profil">
            <p class="item_login"> Rețetă nouă </p>
            <a class="item_login" href="user_home_page.php">Renunță</a>
        </div>
    </div>
</header>
<p class="item_login auto"><?= $_SESSION['prenume'] ?>, completează toate câmpurile obligatorii<sup
            style="color: red">*</sup> de mai jos pentru noua rețetă</p>
<div class="reteta">
    <form method="POST" action="reteta.php" enctype="multipart/form-data">

        <label>
            <b>Titlu:</b><sup style="color: red">*</sup><br/>
            <input type="text" name="titlu" class="inputFields" required/>
        </label><br/><br/>

        <label>
            <b>Categoria:</b><sup style="color: red">*</sup><br/>
            <input type="radio" id="sosuri" name="categoria" value="sosuri">
            <label for="sosuri">Sosuri</label><br>

            <input type="radio" id="semipretarate" name="categoria" value="semipreparate">
            <label for="semipreparate">Semipreparate</label><br>

            <input type="radio" id="gustari" name="categoria" value="gustari">
            <label for="gustari">Gustări</label><br>

            <input type="radio" id="supe" name="categoria" value="supe">
            <label for="supe">Supe, ciorbe și borșuri</label><br>

            <input type="radio" id="mancaruri" name="categoria" value="mancaruri">
            <label for="mancaruri">Mâncăruri</label><br>

            <input type="radio" id="fripturi" name="categoria" value="fripturi">
            <label for="fripturi">Fripturi și garnituri</label><br>

            <input type="radio" id="salate" name="categoria" value="salate">
            <label for="salate">Salate</label><br>

            <input type="radio" id="vanat" name="categoria" value="vanat">
            <label for="vanat">Preparate din vânat</label><br>

            <input type="radio" id="dulciuri" name="categoria" value="dulciuri">
            <label for="dulciuri">Dulciuri</label><br>

        </label><br/>

        <label>
            <b>Numărul de porții:</b><sup style="color: red">*</sup><br/>
            <input type="text" name="nrPortii" class="inputFields" required/>
        </label><br/><br/>

        <label id="materiiPrime">
            <b>Materii prime:</b><sup style="color: red">*</sup><br/>
            <input type="text" name="materiiPrime" class="input_fields" required/>
            <!-- de facut tabel cu posibilitatea de a adauga materii prime in js -->

        </label><br/><br/>
        <!-- on focus remove text -->
        <label for="pregatire">
            <b>Operații pregătitoare:</b><sup style="color: red">*</sup><br/>
            <textarea id="pregatire" name="pregatire" rows="4" cols="50">Scrie aici operațiile dinaintea preparării
        </textarea>
        </label><br/><br/>
        <!-- on focus remove text -->
        <label for="preparare">
            <b>Tehnica preparării:</b><sup style="color: red">*</sup><br/>
            <textarea id="preparare" name="preparare" rows="4" cols="50">Scrie aici modul de preparare
        </textarea>
        </label><br/><br/>
        <!-- on focus remove text -->
        <label for="servire">
            <b>Prezentare și servire:</b><sup style="color: red">*</sup><br/>
            <textarea id="servire" name="servire" rows="4" cols="50"
                      placeholder="Scrie aici modul de prezentare, servire, garituri recomandate etc">
        </textarea>
        </label><br/><br/>

        <label>
            Adaugă fotografii:<br/>
            <!-- a se completa in js name  si posibilitatea de a adauga mai multe poze -->
            <input type="file" id="fotografii" name=""/>
        </label><br/><br/>
        <label>
            <b>Dorești ca rețeta să fie văzută și de alții?</b><sup style="color: red">*</sup><br/>
            <input type="radio" id="da" name="vazuta" value="da">
            <label for="da">Da</label><br>

            <input type="radio" id="nu" name="vazuta" value="nu">
            <label for="nu">Nu</label><br>
        </label> <br/>

        <input type="submit" value="Submit">

    </form>
</div>
<footer>
    <div class="footer">
        <p>&copy 2020-2021 Dezvoltarea Aplicațiilor Web - FMI - Ion Donescu</p>
    </div>
</footer>
</body>

