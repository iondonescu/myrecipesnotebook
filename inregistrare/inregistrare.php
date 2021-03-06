<?php
/*
 * Inregistrarea unui utilizator nou
 */
session_start();
include("../conectare.php");
/**
 * salvam in baza de date data la care se inregistreaza noul utilizator
 */
date_default_timezone_set('Europe/Bucharest');
//variabila utilizata pt a afisa erori
$raspuns = "";
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
    //fetch-uim intr-un array date introduse
    $interogare = mysqli_query($connect, "SELECT email FROM users WHERE email = '$email'");
    $raspunsInterogare = mysqli_fetch_assoc($interogare);

    if ($_FILES['imageupload']['name'] == "") {
        $avatar = "chef.png";
    } else {
/*
 * Opțional introducem o poză de profil
 * Dacă nu introducem este utilizată una generică
 */
        $avatar = $_FILES['imageupload']['name'];
        $avatarExt = explode(".", $avatar);
        $avatarExtention = $avatarExt[1];//aici e o problema daca numele fisierului contine . de doua ori
        //echo $avatarExtention;
        //Verificam daca avatarul are extensia png sau jpg
        if (strtoupper($avatarExtention) !== "PNG" && strtoupper($avatarExtention) !== "JPG") {
            $raspuns = "Avatarul trebuie să fie de tip jpg sau png";
        } else {
            $avatarSize = $_FILES['imageupload']['size'];
            //poza de profil nu poate sa fie mai mare de 5MB
            //atentie si la setarile phpmyadmin
            if ($avatarSize > 5242880) {
                $raspuns = "Avatarul nu poate fi mai mare de 5MB ";

            } else {
                $avatar = rand(0, 10000) . time() . "." . $avatarExtention;
                $tmp_avatar = $_FILES['imageupload']['tmp_name'];
                //dupa ce sunt indeplinite si celellate conditii
                //move_uploaded_file($tmp_avatar, "../users/images/poza_profil/$avatar");
            }
        }
    }

    if (strlen($nume) < 2) {
        $raspuns = "Nume prea scurt";
        }else{
        if (strlen($prenume) < 2){
            $raspuns = "Prenume prea scurt";
        }else{
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $raspuns = "Introduceți o adresa de email validă";
            }else{
                if (strlen($parola) < 6) {
                    $raspuns = "Parola trebuie sa aibe cel putin 6 caractere";
                }else{
                    if ($parola !== $confirmaParola) {
                        $raspuns = "Parolele nu se potrivesc";
                    }
                    else{

                        if (!empty($raspunsInterogare['email'])) {
                            $raspuns = "Aceasta adresa de email există deja. Reîncercați sau autentificați-vă!";
                        }
                            else{
                                //hash parola cu functia md5
                                $parola = md5($parola);
                                $insertQuery = "INSERT INTO users (nume,prenume,email,parola,avatar,date) VALUES ('$nume','$prenume','$email','$parola','$avatar','$today')";
                                if (mysqli_query($connect, $insertQuery)) {

                                    move_uploaded_file($tmp_avatar, "../users/images/poza_profil/$avatar");
                                    //echo "Inregistrare cu succes";
                                } else echo "Inregistrarea a esuat";

//                                                        if (!empty($connect)) {
//                                                            if (mysqli_query($connect, $insertQuery)) {
//                                                                if (move_uploaded_file($tmp_avatar, "../users/images/poza_profil/$avatar")) {
//                                                                    $raspuns = "Inregistrare cu succes";
//                                                                } else {
//                                                                    $raspuns = "Serverul nu suporta avatarul.<br/> Alegeti alta poza de profil";
//                                                                }
//                                                            }
                                if ($stmt = $connect->prepare('SELECT id,nume,prenume,email,parola,avatar FROM users WHERE email = ?')) {
                                    //echo "prepare";
                                    $stmt->bind_param('s', $_POST['email']);
                                    $stmt->execute();
                                        /**
                                 * Inregistram datele utilizatorului in zona de memorie la care pointeaza cursorul
                                 **/
                                $stmt->store_result();

                                /**
                                 * daca interogarea a returnat o singura linie( adresa de mail este unica, conform conditiilor
                                 * impuse la inregistrare in DB)
                                 **/
                                if ($stmt->num_rows == 1) {
                                    $stmt->bind_result($id, $nume, $prenume, $email, $parola, $avatar);
                                    $stmt->fetch();
                                }
                                session_regenerate_id();
                                $_SESSION['loggedin'] = TRUE;
                                $_SESSION['nume'] = $nume;
                                $_SESSION['prenume'] = $prenume;
                                $_SESSION['id'] = $id;
                                $_SESSION['avatar'] = $avatar;
                                $_SESSION['email'] = $email;
                                //var_dump($_SESSION['loggedin']);
                                mkdir("../users/" . $_SESSION['email']);
                                header("location:../users/user_home_page.php");

                            }
                            $stmt->close();
                        }

                    }
                }
            }
        }
    }

}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- folosim framework -ul bootstrap 4.1-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css"
          integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
    <link rel="stylesheet" href="../style.css">
    <title>Recipesnotebook</title>
</head>

<body  class="py-3 container" style="max-width: 1200px">
<header class="py-2 bg-light text-white">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <img src="../img/avatar.png" alt="avatar-picture" style="width: 50px; height: 50px;">
                <h6 class="navbar-brand"><a href="../index.html">Carnețelul culinar</a>
                </h6>
            </div>
        </div>
    </div>
</header>

<!-- Sign-in -->
<section>
    <div class="container mt-3">
        <div class="row">
            <div class="col-md-6 mx-auto">
                <div class="card">
                    <div class="card-header">
                        <h4>Înregistrare</h4>
                    </div>
                    <div class="card-body">
                        <!-- method POST is for background data "you don't see anything in URL" -->
                        <!-- enctype -- to be able to upload file such as images -->
                        <form method="POST" action="../inregistrare/inregistrare.php" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="nume">Nume</label>
                                <input class="form-control" type="text" name="nume" required/>
                            </div>
                            <div class="form-group">
                                <label for="prenume">Prenume</label>
                                <input class="form-control" type="text" name="prenume" required/ >
                            </div>
                            <div class="form-group">
                                <label for="email">E-mail</label>
                                <input class="form-control" type="text" name="email" required/ >
                            </div>
                            <div class="form-group">
                                <label for="parola">Parolă</label>
                                <input class="form-control" type="password" name="parola" required/ >
                            </div>
                            <div class="form-group">
                                <label for="parola">Reintroduceți parola</label>
                                <input class="form-control" type="password" name="confirmaParola" required/ >
                            </div>
                            <div class="form-group">
                                <label for="avatar">Alege o imagine ca avatar png sau jpg</label>
                                <input type="file" id="avatar" name="imageupload"/>
                            </div>
                            <!-- aici ar trebui sa fie un modal-->
                            <p id="mesaj"></p>
                            <input class="btn btn-primary btn-block" id="trimite" type="submit" name="submit" value="Carnețelul meu" />
                        </form>
                        <div class="text-danger" id="raspuns">
                            <?php echo $raspuns; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<footer class="footer mt-5 p-1 text-center my-2" style="max-width: 1200px">
    <div class="container">
        <div class="row">
            <div class="col">
                <p>Copyright &copy;
                    Ion Donescu</p>
            </div>
        </div>
    </div>
</footer>

</body>
</html>

