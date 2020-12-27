<?php
session_start();

if (!isset($_SESSION['loggedin'])) {
    //var_dump($_SESSION['nume']);
    header('Location: ../index.php');
    exit;
}
include('../conectare.php');


$q=$_GET['cod'];

if (isset($connect)) {
    $resultReteta = mysqli_query($connect, "SELECT titlu FROM reteta WHERE codreteta = '$q'");
    $row = $resultReteta->fetch_assoc();
    $titluReteta = $row["titlu"];
}



//echo $q.'<p>A mers</p>
echo '<header id="header">
    <div class="header_inner">
        <div class="gif">
            <img class="header_gif" src="../fire.gif" alt="fire">
        </div>
        <div class="page_title">
            <h1>Carnețelul meu de rețete culinare</h1>
        </div>
        <div class="login_section login">
           <a class="item_login item_login_hover" href="user_home_page.php">Inapoi la retete</a>
        </div>
</header>
    <h2 class="title">'.$titluReteta
    .'</h2>
    <div  style="width: 100%;display: flex">
        <div class="reteta_img">';
            /*
             * preluăm fotografiile rețetei din DB
             */
            if (isset($connect)) {
                $resultFoto = mysqli_query($connect, "SELECT codreteta,owner,numefotografie FROM fotoretete WHERE codreteta = '$q'");
            };
             while ($row = $resultFoto->fetch_assoc()) {
                 $codReteta = $row["codreteta"];
                 $ownerReteta = $row["owner"];
                 $file = $row["numefotografie"];
                  echo '<img class="visibility reteta_imagine" src="' . $ownerReteta . '/' . $codReteta . '/foto/' . $file . '" alt = "fotografii ale retetei" >';
             };
    echo    '<i class="left-button left-button-float fas fa-arrow-circle-left" onclick="increment(-1)"></i>
            <i class="right-button right-button-float fas fa-arrow-circle-right" onclick ="increment(+1)"></i>
            </div>
            <div>
                <table>
                    <thead>
                    <th>Materie primă</th>
                    <th>U/M</th>
                    <th>Cantitate</th>
                    <th>Observații</th>
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
                   echo '<tr class="row">
                        <td>';
                            echo  $materiePrima;
                        echo '</td>
                        <td>';
                            echo $um;
                        echo '</td>
                        <td>';
                            echo $cantitate;
                        echo '</td>
                        <td>';
                            echo $observatii;
                        echo '</td>
                    </tr>';
                    }
                    echo '</tbody>
                </table>
            </div>
    </div>
    <div class="pregatire" style="width:100%">
        <h3>Pregătire:</h3>
        <p style="max-width: 1200px">    ';
            /*
             * Citim din fisiere modul de preparare
             */
            //$myfilePregatire = fopen($ownerReteta.'/'.$codReteta.'/pregatire_'.$codReteta.'.txt', 'r') or die("Unable to open file!");
            echo '&emsp;&emsp;'.file_get_contents($ownerReteta.'/'.$codReteta.'/pregatire_'.$codReteta.'.txt');
            //fclose($myfilePregatire);
            echo '</p>
        <h3>Modul de preparare:</h3>
        <p style="max-width: 1200px">    ';
            //$myfilePreparare = fopen($ownerReteta.'/'.$codReteta.'/preparare_'.$codReteta.'.txt', 'r') or die("Unable to open file!");
            echo '&emsp;&emsp;'.file_get_contents($ownerReteta.'/'.$codReteta.'/preparare_'.$codReteta.'.txt');
            //fclose($myfilePreparare);
            echo '</p>
        <h3>Servire:</h3>
        <p style="max-width: 1200px">    ';
            //$myfileServire = fopen($ownerReteta.'/'.$codReteta.'/servire_'.$codReteta.'.txt', 'r') or die("Unable to open file!");
            echo '&emsp;&emsp;'.file_get_contents($ownerReteta.'/'.$codReteta.'/servire_'.$codReteta.'.txt');
            //fclose($myfileServire);
            echo '</p>
    </div>
</main><br/><br/>
';
include("../footer.html");
?>



