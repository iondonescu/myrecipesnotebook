<?php

session_start();

if (!isset($_SESSION['loggedin'])) {
    exit;
}
include("../conectare.php");
date_default_timezone_set('Europe/Bucharest');

/*
 * salvam datele din reteta
 */

if (isset($_POST['submit'])) {

    /*
     * Generăm un cod unic pentru retetă
     * Ne ajută să asociem tabelul rețeta cu tabelele materiile prime și fotografii
     */
    $codReteta = "reteta" . rand(0, 10000) . time();
    //var_dump($codReteta);
    /*
     * data la care este creată rețeta
     * necesară la UI-ul user_home_page
     */
    $dataReteta = date("F j, Y, g:i a");

    $titlu = $_POST['titlu'];
    //var_dump($titlu);
    $categoria = $_POST['categoria'];
    //var_dump($categoria);
    $portii = $_POST['portii'];
    //var_dump($portii);

    /*
     * materiile prime trebuiesc adăugate într-un tabel "materiiPrime"
     * și asociate cu rețeta
     */

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
     * Inserare in baza de date in tabelul materii prime informatii despre materii prime :)
     */
    $nrMateriiPrime = count($materiePrima);
    for ($i = 0; $i < $nrMateriiPrime; $i++) {
        $insertQueryMateriePrima = "INSERT INTO materiiprime (codReteta,materieprima,um,cantitate,observatii) VALUES ('$codReteta','$materiePrima[$i]','$um[$i]','$cantitate[$i]','$observatii[$i]')";
        if (!empty($connect)) {
            mysqli_query($connect, $insertQueryMateriePrima);
        } else {
            echo "Something went wrong";
        }
    }

    /*
     * Creăm un director denumirea adresa de email(unica)
     * și identificabila in care stocam date referitoare la rețetă
     */

    $userPath = $_SESSION['email'] . "/";
    mkdir($userPath . $codReteta);
    $retetaPath = $userPath . $codReteta . "/";

    /*
     * Creăm un fișier txt cu nume unic,
     * in care vom stoca informațiile despre descrierea rețetei ce va apărea în card
     */
    $descriere = $_POST['descriere'];
    $descriereText = "descriere_" . $codReteta . ".txt";
    $fileDescriere = fopen($retetaPath . $descriereText, "w") or die("Unable to open file");
    fwrite($fileDescriere, $descriere);
    fclose($fileDescriere);
    /*
     * Creăm un fișier txt cu nume unic,
     * in care vom stoca informațiile despre operațiile de pregătire
     */
    $pregatire = $_POST['pregatire'];
    $pregatireText = "pregatire_" . $codReteta . ".txt";
    $filePregatire = fopen($retetaPath . $pregatireText, "w") or die("Unable to open file");
    fwrite($filePregatire, $pregatire);
    fclose($filePregatire);
    /*
     * Creăm un fișier txt cu nume unic,
     * in care vom stoca informațiile despre oprerațiile de preparare
     */
    $preparare = $_POST['preparare'];
    $preparareText = "preparare_" . $codReteta . ".txt";
    $filePreparare = fopen($retetaPath . $preparareText, "w") or die("Unable to open file");
    fwrite($filePreparare, $preparare);
    fclose($filePreparare);

    /*
     * Creăm un fișier txt cu nume unic,
     * in care vom stoca informațiile despre servire
     */
    $servire = $_POST['servire'];
    $servireText = "servire_" . $codReteta . ".txt";
    //var_dump($pregatireText);
    $fileServire = fopen($retetaPath . $servireText, "w") or die("Unable to open file");
    fwrite($fileServire, $servire);
    fclose($fileServire);

    /*
     *de implementat in js daca fotografiile sunt
     * mai mari de 2MB sau daca sunt jpg sau png
     */


    /*
     * Daca nu au fost incarcate fotografii
     * incarcam o poza generica
     */
    $fotoName = $_FILES['foto']['name'];
    //var_dump($fotoName);
    //var_dump($foto);
    mkdir($retetaPath . "foto");
    $tmp_foto = $_FILES['foto']['tmp_name'];
    $numberOfPhoto = count($tmp_foto);
    //var_dump($numberOfPhoto);
    if ($_FILES['foto']['size'][0] !== 0) {
        for ($i = 0; $i < $numberOfPhoto; $i++) {
            move_uploaded_file($tmp_foto[$i], "$retetaPath/foto/$fotoName[$i]");
        }
    } else {
        //echo "nu exista fotografii";
        copy("chef.png", "$retetaPath/foto/chef.png");
    }

    /*
     * variabila pt a stabili dacă rețeta va fi făcută publica
     * in pagina principala (fără a fi autentificat)
     */
    $vizibila = $_POST['visibila'];
    //var_dump($visibila);

    /*
     * Inserare în baza de date, în tabelul rețetă informațiile despre rețetă
     */
    $owner = $_SESSION['email'];
    $insertQueryReteta = "INSERT INTO reteta (owner,codreteta,titlu,categoria,portii,vizibila,datareteta) VALUES ('$owner','$codReteta','$titlu','$categoria','$portii','$vizibila','$dataReteta')";
    if (!empty($connect)) {
        mysqli_query($connect, $insertQueryReteta);
    } else {
        echo "Something went wrong";
    }
    /*
     * Inserare în baza de date, în tabelul fotoreteta informațiile despre numele fisierelor
     */

    $nrFotografii = count($fotoName);
    /*
     * verificam daca utilizatorul a atașat fotografii pt rețetă
     * Dacă da inserăm în baza de date numele fotografiilor lui,
     * dacă nu inserăm numele fotografiei generice
     */
    //var_dump(array_values($nrFotografii));
    if ($_FILES['foto']['size'][0] !== 0) {
        for ($i = 0; $i < $nrFotografii; $i++) {
            $insertQueryFotografii = "INSERT INTO fotoretete (codreteta,owner,numefotografie) VALUES ('$codReteta','$owner','$fotoName[$i]')";
            if (!empty($connect)) {
                mysqli_query($connect, $insertQueryFotografii);
            } else {
                echo "Something went wrong";
            }
        }
    } else {

        $insertQueryFotografii = "INSERT INTO fotoretete  (codreteta,owner,numefotografie) VALUES ('$codReteta','$owner','chef.png')";
        if (!empty($connect)) {
            mysqli_query($connect, $insertQueryFotografii);
        } else {
            echo "Something went wrong";
        }

    }
    header("Location:user_home_page.php");
} else {
    //echo "Something went wrong";
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
    <link rel="stylesheet" href="styles_home.css">
    <link rel="stylesheet" href="../vizitator/retetar.css">
    <link rel="stylesheet" href="../style.css">
    <title>Recipesnotebook</title>
</head>


<body id="body" class="py-3 d-flex flex-column body" style="max-width: 1200px ">
<header class="container d-flex justify-content-between">
    <img src="images/poza_profil/<?= $_SESSION['avatar'] ?>" alt="imagine-de-profil"
         style="width: 50px; height: 50px;border-radius: 10px">
    <h4 class="mx-2 text-center">Carnețelul meu culinar</h4>
    <div class="float-right">
        <p class="font-weight-bold text-center">Rețetă nouă</p>
        <!--        <p >Bine ai venit, --><? //= $_SESSION['prenume'] ?><!--!</p>-->
        <!--        <a href="user_home_page.php" class="btn btn-danger btn-sm">Renunță</a>-->
    </div>
</header>

<p class="item_login auto"><?= $_SESSION['prenume'] ?>,<br/> completează toate câmpurile obligatorii<sup
            style="color: red">*</sup> de mai jos pentru noua rețetă</p>
<div class="pagina_reteta">
    <div class="reteta">
        <form method="POST" action="reteta_noua.php" enctype="multipart/form-data">
            <div class="form-group">
                <label for="titlu" class="h4">Titlu<sup style="color: red">*</sup></label>
                <!--                <b style="font-size: 1.25rem">Titlu:</b><sup style="color: red">*</sup><br/>-->
                <input class="form-control inputFields" type="text" name="titlu" required/> <!--required-->

            </div>

            <div id="accordion">
                <!--                javascript pentru a schimba sensul sagetii in UI-->
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <div href="#collapse1" data-toggle="collapse" data-parent="#accordion" aria-expanded="true">
                                <i class="fas fa-arrow-circle-down">
                                    <span>Categoria:</span><sup
                                            style="color: red">*</sup><br/>
                                </i>
                            </div>
                        </h5>
                    </div>
                    <div id="collapse1" class="collapse">
                        <div class="card-body container">

                            <div class="row">
                                <div class="bg-info py-1 px-3 rounded mb-2 mx-2 text-white col-sm">
                                    <input type="radio" id="sosuri" name="categoria" value="sosuri">
                                    <label class="w-75" for="sosuri">Sosuri</label>
                                </div>

                                <div class="bg-info py-1 px-3 rounded mb-2 mx-2 text-white col-sm">
                                    <input type="radio" id="semipreparate" name="categoria" value="semipreparate">
                                    <label class="w-75" for="semipreparate">Semipreparate</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="bg-info py-1 px-3 rounded mb-2  mx-2 text-white col-sm">
                                    <input type="radio" id="gustari" name="categoria" value="gustari">
                                    <label class="w-75" for="gustari">Gustări</label>
                                </div>

                                <div class="bg-info py-1 px-3 rounded mb-2 mx-2 text-white col-sm">
                                    <input type="radio" id="supe" name="categoria" value="supe">
                                    <label class="w-75" for="supe">Supe, ciorbe și borșuri</label>
                                </div>
                            </div>

                            <div class="row">
                                <div class="bg-info py-1 px-3 rounded mb-2 mx-2 text-white col-sm">
                                    <input type="radio" id="mancaruri" name="categoria" value="mancaruri">
                                    <label class="w-75" for="mancaruri">Mâncăruri</label>
                                </div>

                                <div class="bg-info py-1 px-3 rounded mb-2 mx-2 text-white col-sm">
                                    <input type="radio" id="fripturi" name="categoria" value="fripturi">
                                    <label class="w-75" for="fripturi">Fripturi</label>
                                </div>
                            </div>

                            <div class="row">

                                <div class="bg-info py-1 px-3 rounded mb-2 mx-2 text-white col-sm">
                                    <input type="radio" id="garnituri" name="categoria" value="garnituri">
                                    <label class="w-75" for="garnituri">Garnituri</label>
                                </div>

                                <div class="bg-info py-1 px-3 rounded mb-2 mx-2 text-white col-sm">
                                    <input type="radio" id="salate" name="categoria" value="salate">
                                    <label class="w-75" for="salate">Salate</label>
                                </div>

                            </div>
                            <div class="container w-50">
                                <div class="bg-info py-1 px-3 rounded mb-2 text-white col-sm">
                                    <input type="radio" id="dulciuri" name="categoria" value="dulciuri">
                                    <label class="w-75" for="dulciuri">Dulciuri</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br/>
            <div class="form-group">
                <label for="numar_portii"><b>Număr de porții</b></label>
                <!--                <b>Numărul de porții:</b><sup style="color: red">*</sup><br/>-->

                <select class="form-select form-select-sm" id="portii" name="portii" required/> <!--required-->
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

                </label>
            </div>

            <label>
                <b>Materii prime:</b><sup style="color: red">*</sup><br/>

                <table id="materiiPrime" class="table table-sm table-striped table-bordered">
                    <thead>
                    <tr>
                        <th scope="col">Materie primă</th>
                        <th scope="col">U/M</th>
                        <th scope="col">Cantitate</th>
                        <th scope="col">Observații</th>
                        <th scope="col"> Șterge</th>
                    </tr>
                    </thead>
                    <tbody id="rows">
                    <tr>
                        <td>
                            <input type="text" name="materiePrima[]" required/> <!--required-->
                        </td>
                        <td>
                            <select id="um" name="um[]">
                                <option value="g">g</option>
                                <option value="kg">kg</option>
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
                            <input style="max-width: 70px" type="text" name="cantitate[]" required/> <!--required-->
                        </td>
                        <td>
                            <input type="text" name="observatii[]">
                        </td>
                        <td>
                            <div>
                                <i class="fas fa-minus-circle sterge" onclick="stergeMateriePrima(this)"></i>
                            </div>
                        </td>

                        </td>
                    </tr>
                    </tbody>

                </table>
            </label>
            <br/>
            <div class="btn btn-primary plus">
                <div style="display:flex">
                    <p style="margin:0">Adaugă materie primă</p>
                    <div><i class="fas fa-plus-circle" style="padding-left: 15px"></i></div>
                </div>
            </div>
            <br/>
            <br/>

            <div class="form-group">
                <label for="descriere"><b>Scurtă descriere:</b><sup style="color: red">*</sup></label>
                <textarea class="form-control" rows="5" id="descriere" name="descriere"></textarea>
            </div>


            <div class="form-group">
                <label for="pregatire"><b>Operații pregătitoare:</b><sup style="color: red">*</sup></label>
                <textarea class="form-control" rows="5" id="pregatire" name="pregatire"></textarea>
            </div>

            <br/>


            <div class="form-group">
                <label for="preparare"><b>Mod de preparare:</b><sup style="color: red">*</sup></label>
                <textarea class="form-control" rows="5" id="preparare" name="preparare"></textarea>
            </div>

            <br/>


            <div class="form-group">
                <label for="servire"><b>Prezentare și servire:</b><sup style="color: red">*</sup></label>
                <textarea class="form-control" rows="5" id="servire" name="servire"></textarea>
            </div>

            <br/><br/>

            <b>Adaugă maxim cinci fotografii:</b><br/>
            <table id="fotografii">
                <tr>
                    <td>
                        <input type="file" class="fotografie" name="foto[]"/>
                    </td>
                    <td>
                        <div class="minus">
                            <i class="fas fa-minus-circle sterge" style="margin-left: 30px"
                               onclick="stergeFotografie(this)"></i>
                        </div>
                    </td>
                </tr>
            </table>

            <div id="schimbaClasa" class="visible btn btn-primary plus">
                <div style="display: flex">
                    <p style="margin:0">Adaugă fotografie</p>
                    <div><i class="fas fa-plus-circle" style="padding-left: 15px"></i></div>
                </div>
            </div>
            <br/>
            <br/>
            <br/>

            <label>
                <b>Dorești ca rețeta să fie văzută și de alții?</b><sup style="color: red">*</sup><br/> <!--required-->
                <div class="p-3">
                    <input type="radio" id="da" name="visibila" value="da">
                    <label for="da"><b>Da</b></label><br>
                </div>

                <div class="pb-3 px-3">
                    <input type="radio" id="nu" name="visibila" value="nu">
                    <label for="nu"><b>Nu</b></label>
                </div>
                <br>
            </label> <br/>

            <!-- 20.12.2020 de scris cod pe partea de client pt previzualizare rețetă -->

            <div style="padding-bottom: 50px">
                <input class="btn btn-primary btn-sm" type="submit" name="submit" value="Salvează rețeta">
                <a href="user_home_page.php" class="btn btn-danger btn-sm float-right">Renunță</a>
            </div>
        </form>

    </div>
</div>


<script src="materie_prima.js"></script>

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

