<?php
session_start();
// If the poza_profil is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
    //var_dump($_SESSION['nume']);
    //header('Location: index.php');
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
    <div style="width: 100%;display: flex">
        <div style="width:50%">
            <img src="" alt="fotografii ale retetei">
        </div style="width:50%">
        <div>
            <table>
                <thead>
                <th>Materie primă</th>
                <th>U/M</th>
                <th>Cantitate</th>
                <th>Observații</th>
                <th> Șterge</th>
                </thead>
                <tbody>
                <tr class="row">
                    <td>

                    </td>
                    <td>

                    </td>
                    <td>

                    </td>
                    <td>

                    <td>

                    </td>

                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div style="width:100%">
        <h3>Pregătire:</h3>
        <p></p>
        <h3>Preparare:</h3>
        <p></p>
        <h3>Servire:</h3>
        <p></p>
    </div>
</main>';
?>



