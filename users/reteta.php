<?php

session_start();
// If the poza_profil is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
    exit;
}

/*
 * salvam datele din reteta
 */

if (isset($_POST['submit'])) {

    /*
     * Generăm un cod unic pentru retetă
     * Ne ajută să asociem tabelul rețeta cu tabelele materiile prime și fotografii
     */
    $codReteta = "reteta".rand(0, 10000) . time();
    //var_dump($codReteta);
    $titlu = $_POST['titlu'];
    //var_dump($titlu);
    $categoria =$_POST['categoria'];
    //var_dump($categoria);
    $portii = $_POST['portii'];
    //var_dump($portii);

   /*
    * materiile prime trebuiesc adăugate într-un tabel "materiiPrime"
    * și asociate cu rețeta
    */

    //aici ar trebui 4 siruri
    $materiePrima = $_POST['materiePrima'];
//    foreach ($materiePrima as $mPrima) {
//        echo '<br/>';
//        var_dump($mPrima);
//    }
//    echo '<br/>';
    $um = $_POST['um'];
//    foreach ($um as $mPrimaUm) {
//        echo '<br/>';
//        var_dump($mPrimaUm);
//    }
//
//    echo '<br/>';
    $cantitate = $_POST['cantitate'];
//    foreach ($cantitate as $mPrimaCantitate) {
//        echo '<br/>';
//        var_dump($mPrimaCantitate);
//    }
//    echo '<br/>';
    $observatii = $_POST['observatii'];
//    foreach ($observatii as $mPrimaObservatii) {
//        echo '<br/>';
//        var_dump($mPrimaObservatii);
//    }

    /*
     * Creăm un director denumirea adresa de email(unica)
     * și identificabila in care stocam date referitoare la rețetă
     */

    $userPath = $_SESSION['email']."/";
    mkdir($userPath.$codReteta);
    $retetaPath = $userPath.$codReteta."/";

    //de adăugat în acest director pozele
    /*
     * Creăm un fișier txt cu nume unic,
     * in care vom stoca informațiile despre oprerațiile de pregătire
     */
    $pregatire = $_POST['pregatire'];
    $pregatireText ="pregatire_".$codReteta.".txt";
    $filePregatire = fopen($retetaPath.$pregatireText,"w")or die("Unable to open file");
    fwrite($filePregatire,$pregatire);
    fclose($filePregatire);
    /*
     * Creăm un fișier txt cu nume unic,
     * in care vom stoca informațiile despre oprerațiile de preparare
     */
    $preparare = $_POST['preparare'];
    $preparareText ="preparare_".$codReteta.".txt";
    $filePreparare = fopen($retetaPath.$preparareText,"w")or die("Unable to open file");
    fwrite($filePreparare,$preparare);
    fclose($filePreparare);

    /*
     * Creăm un fișier txt cu nume unic,
     * in care vom stoca informațiile despre servire
     */
    $servire = $_POST['servire'];
    $servireText ="servire_".$codReteta.".txt";
    //var_dump($pregatireText);
    $fileServire = fopen($retetaPath.$servireText,"w")or die("Unable to open file");
    fwrite($fileServire,$servire);
    fclose($fileServire);

    $foto = $_FILES['foto'];
//    foreach ($foto as $retetaFoto) {
//        echo '<br/>';
//        var_dump($retetaFoto);
//    }
//    echo '<br/>';

    /*
     *de implementat in js daca fotografiile sunt
     * mai mari de 2MB sau daca sunt jpg sau png
     */


    /*
     * Daca nu au fost incarcate fotografii
     * incarca in baza de date valuarea NULL
     */
    $foto = $_FILES['foto']['name'];
    $tmp_foto = $_FILES['foto']['tmp_name'];
    mkdir($retetaPath."foto");
    $numberOfPhoto = count($tmp_foto);
    for($i=0;$i<$numberOfPhoto;$i++){
        move_uploaded_file($tmp_foto[$i],"$retetaPath/foto/$foto[$i]");
    }
    /*
     * variabila pt a stabili dacă rețeta va fi făcută publica
     * in pagina principala (fără a fi autentificat)
     */
    $visibila = $_POST['visibila'];
    //var_dump($visibila);

//    /*
//     * data la care este creată rețeta
//     * necesară la UI-ul user_home_page
//     */
    $dataReteta= date("F j, Y, g:i a");
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
                <input type="text" name="titlu" class="inputFields" /> <!--required-->
            </label><br/><br/>

            <label>
                <b>Categoria:</b><sup style="color: red">*</sup><br/>
                <input type="radio" id="sosuri" name="categoria" value="sosuri">
                <label for="sosuri">Sosuri</label><br>

                <input type="radio" id="semipreparate" name="categoria" value="semipreparate">
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

                <select id="portii" name="portii" /> <!--required-->
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
                    <th>Cantitate</th>
                    <th>Observații</th>
                    <th> Șterge</th>
                    </thead>
                    <tbody id="rows">
                    <tr class="row">
                        <td>
                            <input type="text" name="materiePrima[]" /> <!--required-->
                        </td>
                        <td>
                            <select id="um" name="um[]">
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
                            <input type="text" name="cantitate[]" /> <!--required-->
                        </td>
                        <td>
                            <input type="text" name="observatii[]">
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
                        <input type="file" class="fotografie" name="foto[]"/>
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
                <b>Dorești ca rețeta să fie văzută și de alții?</b><sup style="color: red">*</sup><br/> <!--required-->
                <input type="radio" id="da" name="visibila" value="da">
                <label for="da">Da</label><br>

                <input type="radio" id="nu" name="visibila" value="nu">
                <label for="nu">Nu</label><br>
            </label> <br/>

            <!-- 20.12.2020 de scris cod pe partea de client pt previzualizare rețetă -->

            <button>Previzualizeză</button>
            <input type="submit" name = "submit" value="Salvează rețeta">

        </form>
    </div>
    <!-- 23.12.2020 de implementat pe viitor
    <div class="previzualizare">

    </div>
    -->
</div>

<footer>
    <div class="footer">
        <p>&copy 2020-2021 Dezvoltarea Aplicațiilor Web - FMI - Ion Donescu</p>
    </div>
</footer>
<script src="materiePrima.js"></script>
</body>

