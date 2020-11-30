<?php
include ("../connect.php");
$raspuns ="";
if (isset($_POST['submit'])) {
    $nume = $_POST['nume'];
    $prenume = $_POST['prenume'];
    $email = $_POST['email'];
    $parola = $_POST['parola'];
    $confirmaParola = $_POST['confirmaParola'];
    $avatar = $_FILES['imageupload']['name'];
    $tmp_avatar = $_FILES['imageupload']['tmp_name'];
    $avatarSize = $_FILES['imageupload']['size'];

    //echo $nume."<br/>".$prenume."<br/>".$email."<br/>".$parola."<br/>".$confirmaParola."<br/>".$avatar."<br/>".$avatarSize."<br/>";
    if(strlen($nume) < 2){
        $raspuns = "Nume prea scurt";
    }
    else if (strlen($prenume) < 2){
        $raspuns = "Prenume prea scurt";
    }
    else if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
        $raspuns = "Introduceti o adresa de email valida";
    }
    else if(strlen($parola) < 6){
        $raspuns = "Parola trebuie sa aibe cel putin 6 caractere";
    }
    else if($parola !== $confirmaParola){
        $raspuns = "Parolele nu se potrivesc";
    }
    else{
        //30.11.2020 de implementat daca email-ul exista in baza de date
            //$raspuns = "Inregistare cu succes";
            $insertQuery = "INSERT INTO users (nume, prenume,email,parola,avatar) VALUES ('$nume','$prenume','$email','$parola','$avatar')";
            if(mysqli_query($connect,$insertQuery)){
                if(move_uploaded_file($tmp_avatar,"../images/users/$avatar")) {
                    $raspuns = "Inregistrare cu succes";
                }
                else {
                    $raspuns = "Avatarul nu a fost salvat";
                }
            }
        //daca exista $raspuns = "exista deja un user cu aceasta adresa de email <a href="autentificare.php">Autentificare</a>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <title>Inregistrare</title>
    <link rel="stylesheet" href="css/styles_inregistrare.css"/>

</head>


<body>

<div id="wrapper">
    <!--
        <div id="menu">
            <a href="../index.php">Sign Up</a>
            <a href="login.php">Login</a>
        </div-->

    <div id="formDiv">
        <!-- method POST is for background data "you don't see anything in URL" -->
        <!--enctype -- to be able to upload file such as images -->
        <form method="POST" action="../inregistrare/inregistrare.php" enctype="multipart/form-data">

            <label>
                Nume:<br/>
                <input type="text" name="nume" class="inputFields"  required/>
            </label><br/><br/>

            <label>
                Prenume:<br/>
                <input type="text" name="prenume" class="inputFields" required/>
            </label><br/><br/>

            <label>
                Email:<br/>
                <input type="text" name="email" class="inputFields" required/>
            </label><br/><br/>

            <label>
                Parola:<br/>
                <input type="password" name="parola" class="inputFields" required/>
            </label><br/><br/>

            <label>
                Reintroduceti parola:<br/>
                <input type="password" name="confirmaParola" class="inputFields" required/>
            </label><br/><br/>

            <label>
                Alegeti imagine de profil:<br/>
                <input type="file"
                       id="avatar" name="imageupload"
                       accept="image/png, image/jpeg">
            </label><br/><br/>

            <input type="checkbox" name="conditions"/>
            <label>Sunt de acord cu termenii si conditiile</label><br/><br/>

            <input type="submit" class="theButtons" name="submit" value="Trimite"/>

        </form>

    </div>
    <div id="raspuns">
        <?php echo $raspuns; ?>
    </div>

</div>

</body>

</html>

