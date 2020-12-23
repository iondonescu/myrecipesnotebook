<?php

session_start();
// If the poza_profil is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
    //var_dump($_SESSION['nume']);
    //header('Location: index.php');
    exit;
}

/*
 * salvam datele din reteta
 */

if (isset($_POST['submit'])) {
//mysqli_real_escape_string - function that avoid mysqli injection with malicious code
    if (isset($connect)) {
        $nume = mysqli_real_escape_string($connect, $_POST['nume']);
        $prenume = mysqli_real_escape_string($connect, $_POST['prenume']);
        $email = mysqli_real_escape_string($connect, $_POST['email']);
    }
    $parola = $_POST['parola'];
    $confirmaParola = $_POST['confirmaParola'];


    $today = date("F j, Y, g:i a");// data la care se inregistreaza userul
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
    <link rel='icon' href='../favicon.ico' type='image/x-icon'>
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
<p class="item_login auto"><?= $_SESSION['prenume'] ?>,<br/> completează toate câmpurile obligatorii<sup
            style="color: red">*</sup> de mai jos pentru noua rețetă</p>
<div class="pagina_reteta">
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

                <select id="portii" name="portii" required/>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
                <option value="10">10</option>
                </select>

            </label><br/><br/>

            <label>
                <b>Materii prime:</b><sup style="color: red">*</sup><br/>

                <table id="materiiPrime">
                    <thead>
                    <th>Materie primă</th>
                    <th>U/M</th>
                    <th>Cantitatea brută pentru numărul de porții</th>
                    <th>Observații</th>
                    <th> Șterge</th>
                    </thead>
                    <tbody id="rows">
                    <tr class="row">
                        <td>
                            <input type="text" name="materiePrima" required/>
                        </td>
                        <td>
                            <select id="um" name="um">
                                <option value="kg">kg</option>
                                <option value="g">g</option>
                                <option value="l">l</option>
                                <option value="ml">ml</option>
                                <option value="lingura">lingură</option>
                                <option value="lingurita">linguriță</option>
                                <option value="cana">cană</option>
                                <option value="ceasca">ceașcă</option>
                                <option value="buc">buc</option>
                            </select>
                        </td>
                        <td>
                            <input type="text" name="cantitate" required/>
                        </td>
                        <td>
                            <input type="text" name="observatii">
                        </td>
                        <td>
                            <div class="minus">
                                <i class="fas fa-minus-circle" onclick="stergeMateriePrima(this)"></i>
                            </div>
                        </td>

                        </td>
                    </tr>
                    </tbody>

                </table>
                <!-- de facut tabel cu posibilitatea de a adauga materii prime in js -->

            </label>
            <div style="display: flex">
                <p style="padding-top: 3px">Adaugă materie primă</p>
                <div class="plus"><i class="fas fa-plus-circle"></i></div>
                <br/>
            </div>
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

            Adaugă fotografii (opțional):<br/>
            <table id="fotografii">
                <tr>
                    <td>
                        <input type="file" class="fotografie" name="foto"/>
                    </td>
                    <td>
                        <div class="minus">
                            <i class="fas fa-minus-circle" onclick="stergeFotografie(this)"></i>
                        </div>
                    </td>
                </tr>
            </table>


            <div id="schimbaClasa" class="visible" style="display: flex">
                <p style="padding-top: 3px">Adaugă fotografie</p>
                <div class="plus"><i class="fas fa-plus-circle"></i></div>
            </div>
            <br/>
            <label>
                <b>Dorești ca rețeta să fie văzută și de alții?</b><sup style="color: red">*</sup><br/>
                <input type="radio" id="da" name="vazuta" value="da">
                <label for="da">Da</label><br>

                <input type="radio" id="nu" name="vazuta" value="nu">
                <label for="nu">Nu</label><br>
            </label> <br/>

            <!-- 20.12.2020 de scris cod pe partea de client pt previzualizare rețetă -->

            <button>Previzualizeză</button>
            <input type="submit" value="Salvează rețeta">

        </form>
    </div>
    <div class="previzualizare">

    </div>

</div>

<footer>
    <div class="footer">
        <p>&copy 2020-2021 Dezvoltarea Aplicațiilor Web - FMI - Ion Donescu</p>
    </div>
</footer>
<script src="materiePrima.js"></script>
</body>

