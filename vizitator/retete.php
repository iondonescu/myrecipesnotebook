<?php
session_start();

include('../conectare.php');


$q=$_GET['cod'];

if (isset($connect)) {
    $resultReteta = mysqli_query($connect, "SELECT titlu FROM reteta WHERE codreteta = '$q'");
    $row = $resultReteta->fetch_assoc();
    $titluReteta = $row["titlu"];
}

include ("../header.html");

//echo $q.'<p>A mers</p>
echo '<h4 class="mx-auto">' . $titluReteta . '</h4>';
/*
 * preluăm fotografiile rețetei din DB
 */
if (isset($connect)) {
    $resultFoto = mysqli_query($connect, "SELECT codreteta,owner,numefotografie FROM fotoretete WHERE codreteta = '$q'");
};
//if (isset($connect)) {
//    $resultBucatar = mysqli_query($connect, "SELECT users.nume,users.prenume FROM users LEFT JOIN reteta ON users.email = reteta.owner");
//};
//while ($row = $resultBucatar->fetch_assoc()) {
//    $nume = $row["nume"];
//    $prenume = $row["prenume"];
//};
//echo '<p><i>Bucătar</i> <b>'.$nume.' </b> '.'<b>'.$prenume.'</b></p>';
echo '<div class="carousel w-75 reteta_img mx-auto mt-5" >';

while ($row = $resultFoto->fetch_assoc()) {
    $codReteta = $row["codreteta"];
    $ownerReteta = $row["owner"];
    $file = $row["numefotografie"];
    echo '
    <img class="reteta_imagine w-100" src="../users/'. $ownerReteta . '/' . $codReteta . '/foto/' . $file . '">
    ';
};
echo '
  <button class="carousel-control-prev button_left" type="button" onclick="increment(-1)">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next button_right" type="button" onclick ="increment(+1)">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>  
    ';
echo '<div class="container my-5">
               <table class="table w-75 mx-auto">
                    <thead>
                        <th scope="col"><h5>Materie primă</h5></th>                    
                        <th scope="col"><h5>Cantitate</h5></th>
                        <th scope="col"><h5>U/M</h5></th>
                        <th scope="col"><h5>Observații</h5></th>
                    </thead>
                    <tbody>';
/*
 * Preluam materiile prime din DB
 */

if (isset($connect)) {
    $resultMaterii = mysqli_query($connect, "SELECT codreteta,materieprima,um,cantitate,observatii FROM materiiprime WHERE codreteta = '$q'");
}
while ($row = $resultMaterii->fetch_assoc()) {
    $materiePrima = $row["materieprima"];
    $um = $row["um"];
    $cantitate = $row['cantitate'];
    $observatii = $row['observatii'];
    echo '<tr scope="row">
                        <td>';
    echo $materiePrima;
    echo '</td>
                        <td>';

    echo $cantitate;
    echo '</td>
                        <td>';
    echo $um;
    echo '</td>
                        <td>';
    echo $observatii;
    echo '</td>
                    </tr>';
}
echo '</tbody>
      </table>
         
    <div class="pregatire" style="width:100%">
        <h3>Pregătire:</h3>
        <p style="max-width: 1200px">    ';
/*
 * Citim din fisiere modul de preparare
 */
//$myfilePregatire = fopen($ownerReteta.'/'.$codReteta.'/pregatire_'.$codReteta.'.txt', 'r') or die("Unable to open file!");
echo '&emsp;&emsp;'.file_get_contents('../users/'.$ownerReteta.'/'.$codReteta.'/pregatire_'.$codReteta.'.txt');
//fclose($myfilePregatire);
echo '</p>
        <h3>Modul de preparare:</h3>
        <p style="max-width: 1200px">';
//$myfilePreparare = fopen($ownerReteta.'/'.$codReteta.'/preparare_'.$codReteta.'.txt', 'r') or die("Unable to open file!");
echo '&emsp;&emsp;'.file_get_contents('../users/'.$ownerReteta.'/'.$codReteta.'/preparare_'.$codReteta.'.txt');
//fclose($myfilePreparare);
echo '</p>
        <h3>Servire:</h3>
        <p style="max-width: 1200px">';
//$myfileServire = fopen($ownerReteta.'/'.$codReteta.'/servire_'.$codReteta.'.txt', 'r') or die("Unable to open file!");
echo '&emsp;&emsp;'.file_get_contents('../users/'.$ownerReteta.'/'.$codReteta.'/servire_'.$codReteta.'.txt');
//fclose($myfileServire);
echo '</p>
    </div>
</main>
';

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
    <link rel="stylesheet" href="retetar.css">
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="../users/styles_home.css">

    <title>Recipesnotebook</title>
</head>

<body id="body" class="py-3 d-flex flex-column body" style="max-width: 1200px" >
<div class="container w-100 mx-4 ">
    <a class="adauga-reteta float-right" id="reteta" href="retetar.php">
        <img class="adauga" src="../img/avatar.png" alt="Imagine_generica_reteta noua">
        Rețetele utilizatorilor
    </a>

</div>
</body>




