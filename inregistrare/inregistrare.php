<?php
session_start();
include("../conectare.php");
/**
 * salvam in baza de date data la care se inregistreaza noul utilizator
 */
date_default_timezone_set('Europe/Bucharest');
//variabila utilizata pt a afisa erori
$raspuns ="";
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
    //var_dump($raspunsInterogare);

    //echo $nume."<br/>".$prenume."<br/>".$email."<br/>".$parola."<br/>".$confirmaParola."<br/>".$poza_profil."<br/>".$avatarSize."<br/>".$data;
    if (strlen($nume) < 2) {
        $raspuns = "Nume prea scurt";
    };

    if (strlen($prenume) < 2) {
        $raspuns = "Prenume prea scurt";
    };

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $raspuns = "Introduceti o adresa de email valida";
    } else if (strlen($parola) < 6) {
        $raspuns = "Parola trebuie sa aibe cel putin 6 caractere";
    } else if ($parola !== $confirmaParola) {
        $raspuns = "Parolele nu se potrivesc";
    };

/*
 * Opțional introducem o poză de profil
 * Dacă nu introducem este utilizată una generică
 */
    if ($_FILES['imageupload']['name'] == "") {
        $avatar = "chef.png";
    } else {
        $avatar = $_FILES['imageupload']['name'];
        $tmp_avatar = $_FILES['imageupload']['tmp_name'];
        $avatarSize = $_FILES['imageupload']['size'];
        //poza de profil nu poate sa fie mai mare de 1 MB
        //atentie si la setarile phpmyadmin
        if ($avatarSize > 1048576) {
            $raspuns = "Poza de profil nu poate fi mai mare de 1MB ";
        };
    }
    //daca nu exista inregistrata adresa de mail
    if (empty($raspunsInterogare['email'])) {
        //criptare parola cu functia md5
        $parola = md5($parola);
        // Verificam extensia avatarului, de implementat exceptia daca in denumire contine "."
        if ($avatar !== "chef.png") {
            $avatarExt = explode(".", $avatar);
            $avatarExtention = $avatarExt[1];

            //Verificam daca avatarul are extensia png sau jpg
            if (strtoupper($avatarExtention) == "PNG" || strtoupper($avatarExtention) == "JPG") {
                //generam nume unic pentru poza_profil
                $avatar = rand(0, 10000) . time() . "." . $avatarExtention;

                //$raspuns = "Inregistare cu succes";
                /**
                 * Daca validarea campurilor este ok inseram in baza de date
                 */
                $insertQuery = "INSERT INTO users (nume,prenume,email,parola,avatar,date) VALUES ('$nume','$prenume','$email','$parola','$avatar','$today')";

                if (!empty($connect)) {
                    if (mysqli_query($connect, $insertQuery)) {
                        if (move_uploaded_file($tmp_avatar, "../users/images/poza_profil/$avatar")) {
                            $raspuns = "Inregistrare cu succes";
                        } else {
                            $raspuns = "Serverul nu suporta avatarul.<br/> Alegeti alta poza de profil";
                        }
                    }
                }

            } else {
                $raspuns = "Avatarul trebuie sa fie imagine cu extensia png sau jpg";
            }
        } else {
            $insertQuery = "INSERT INTO users (nume,prenume,email,parola,avatar,date) VALUES ('$nume','$prenume','$email','$parola','chef.png','$today')";
            if (!empty($connect)) {
                mysqli_query($connect, $insertQuery);
            }
        }

            if ($stmt = $connect->prepare('SELECT id,nume,prenume,email,parola,avatar FROM users WHERE email = ?')) {
                echo "prepare";
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
                mkdir("../users/".$_SESSION['email']);
                header("location:../users/user_home_page.php");

            }
            $stmt->close();
        }else {
        $raspuns = "Aceasta adresa de email deja exista.Reîncercați sau autentificați-vă!";
    }

}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Inregistrare</title>
    <link rel="stylesheet" href="css/inregistrare.css"/>
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
            <a class="item_login item_login_hover" href="../autentificare/autentificare.php">Autentificare</a>
            <p class="item_login text_color">Inregistrare</p>
        </div>
    </div>
</header>

<div id="wrapper">
    <h3 id="title">Bine ai venit  pe <br/> myrecipesnotebook.com</h3>
    <div id="formDiv">
        <!-- method POST is for background data "you don't see anything in URL" -->
        <!--enctype -- to be able to upload file such as images -->
        <form method="POST" action="../inregistrare/inregistrare.php" enctype="multipart/form-data">

            <label>
                Nume:<br/>
                <input type="text" name="nume" class="input_fields"  required/>
            </label><br/><br/>

            <label>
                Prenume:<br/>
                <input type="text" name="prenume" class="input_fields" required/>
            </label><br/><br/>

            <label>
                Email:<br/>
                <input type="text" name="email" class="input_fields" required/>
            </label><br/><br/>

            <label>
                Parola:<br/>
                <input type="password" name="parola" class="input_fields" required/>
            </label><br/><br/>

            <label>
                Reintroduceti parola:<br/>
                <input type="password" name="confirmaParola" class="input_fields" required/>
            </label><br/><br/>

            <label>
                Alege o imaginea de profil(optional):<br/>
                <input type="file" id="avatar" name="imageupload" />
            </label><br/><br/>

            <input  id="trimite" type="submit" class="the_buttons" name="submit" value="Submit"/>

        </form>

    </div>

    <div id="raspuns">
        <?php echo $raspuns; ?>
    </div>

</div>
<!--2020.12.01 De stilizat form-ul de inregistrare si adaugat butonul Renunta.
La click se revine la pagina index.php -->
<footer>
    <div class="footer">
        <p>&copy 2020-2021 Dezvoltarea Aplicațiilor Web - FMI - Ion Donescu</p>
    </div>
</footer>

</body>
</html>

