<?php
session_start();

if (!isset($_SESSION['loggedin'])) {
    //var_dump($_SESSION['nume']);
    header('Location: ../vizitator/vizitator.php');
    exit;
}
include('../conectare.php');


$q = $_GET['cod'];

if (isset($connect)) {
    $resultReteta = mysqli_query($connect, "SELECT titlu FROM reteta WHERE codreteta = '$q'");
    $row = $resultReteta->fetch_assoc();
    $titluReteta = $row["titlu"];
}


//echo $q.'<p>A mers</p>
echo '
<header class="container d-flex justify-content-between">
    <img src="images/poza_profil/' . $_SESSION['avatar'] . '" alt="imagine-de-profil"
         style="width: 50px; height: 50px;border-radius: 10px">
    <h4 class="mx-2">' . $titluReteta . '</h4>
    <div class="float-right">
        <p >Bine ai venit,' . $_SESSION['prenume'] . '</p>
       <a href="user_home_page.php" class="btn btn-primary btn-sm">Rețetele mele</a>
    </div>
</header>
';
/*
 * preluăm fotografiile rețetei din DB
 */
if (isset($connect)) {
    $resultFoto = mysqli_query($connect, "SELECT codreteta,owner,numefotografie FROM fotoretete WHERE codreteta = '$q'");
}
// SHOWCASE SLIDER
echo '<div class="carousel w-75 reteta_img mx-auto mt-5" >';

while ($row = $resultFoto->fetch_assoc()) {
    $codReteta = $row["codreteta"];
    $ownerReteta = $row["owner"];
    $file = $row["numefotografie"];
    echo '
    <img class="reteta_imagine w-100" src="' . $ownerReteta . '/' . $codReteta . '/foto/' . $file . '">
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
echo '&emsp;&emsp;' . file_get_contents($ownerReteta . '/' . $codReteta . '/pregatire_' . $codReteta . '.txt');
//fclose($myfilePregatire);
echo '</p>
        <h3>Modul de preparare:</h3>
        <p style="max-width: 1200px">    ';
//$myfilePreparare = fopen($ownerReteta.'/'.$codReteta.'/preparare_'.$codReteta.'.txt', 'r') or die("Unable to open file!");
echo '&emsp;&emsp;' . file_get_contents($ownerReteta . '/' . $codReteta . '/preparare_' . $codReteta . '.txt');
//fclose($myfilePreparare);
echo '</p>
        <h3>Servire:</h3>
        <p style="max-width: 1200px">    ';
//$myfileServire = fopen($ownerReteta.'/'.$codReteta.'/servire_'.$codReteta.'.txt', 'r') or die("Unable to open file!");
echo '&emsp;&emsp;' . file_get_contents($ownerReteta . '/' . $codReteta . '/servire_' . $codReteta . '.txt');
//fclose($myfileServire);
echo '</p>
    </div>
</div><br/><br/>
';


include("../footer.html");
?>


<!DOCTYPE html>
<html>
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

    <title>Recipesnotebook</title>
</head>
<body id="body" class="py-3 d-flex flex-column body" style="max-width: 1200px">

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



