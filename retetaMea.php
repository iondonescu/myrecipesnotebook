<?php
session_start();
// If the poza_profil is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
    //var_dump($_SESSION['nume']);
    //header('Location: index.php');
    exit;
}
include('conectare.php');
//include('../users/user_home_page.php');
//$result = mysqli_query($connect, "SELECT titlu FROM reteta WHERE owner = '$owner'");
?>

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
            <a class="item_login" href="users/user_home_page.php">Înapoi la rețetele mele</a>
        </div>
    </div>

</header>

<main class="main_section">
    <h2 class="title">
       </h2>
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
</main>
<?php
include("footer.html");
?>
</body>
</html>

