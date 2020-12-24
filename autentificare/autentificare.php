<?php
session_start();
include("../conectare.php");
include("../functii/emailExists.php");

$raspuns ="";//variabila utilizata pt a afisa erori ex: parola introdusa gresit

if (isset($_POST['submit'])) {

    if (isset($connect)) {
        //tehnica de a preveni injection "www.w3schools.com"
        //se creaza un cursor in SQL
        if ($stmt = $connect->prepare('SELECT id,nume,prenume,email,parola,avatar FROM users WHERE email = ?')) {

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
                /**
                 * Verificam daca exista emailul in baza de date
                 **/
                if (email_exists($email, $connect)) {
                    /**
                     * Verificam daca parola introdusa se potriveste cu cea din baza de date
                     **/
                    if (md5($_POST['parola']) === $parola) {
                        /**
                         * Daca email-ul si parola se protrivesc updateaza sesiunea curenta
                         * cu noile date ale utilizatorului
                         */
                        session_regenerate_id();
                        $_SESSION['loggedin'] = TRUE;
                        $_SESSION['nume'] = $nume;
                        $_SESSION['prenume'] = $prenume;
                        $_SESSION['id'] = $id;
                        $_SESSION['avatar'] = $avatar;
                        $_SESSION['email'] = $email;
                        // redirectioneaza catre pagina utilizatorului
                        header('Location: ../users/user_home_page.php');
                    }
                    else {
                        $raspuns = "Parola incorecta";
                    }
                }
            }
            else {
                // Incorrect username
                $raspuns = "Acest email nu exista!Reîncercați sau mergeți la pagina de înregistrare.";
            }
            $stmt->close();
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Autentificare</title>
    <link rel="stylesheet" href="css/autentificare.css"/>
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
            <p class="item_login text_color">Autentificare</p>
            <a class="item_login item_login_hover" href="../inregistrare/inregistrare.php">Inregistrare</a>
        </div>
    </div>

</header>
<div id="wrapper">
    <h3 id="title">Bine ai venit  pe <br/> myrecipesnotebook.com</h3>
    <div id="formDiv">
        <!-- method POST is for background data "you don't see anything in URL" -->
        <!--enctype -- to be able to upload file such as images -->
        <form method="POST" action="../autentificare/autentificare.php" enctype="multipart/form-data">

            <label>
                Email:<br/>
                <input type="text" name="email" class="input_fields" required/>
            </label><br/><br/>

            <label>
                Parola:<br/>
                <input type="password" name="parola" class="input_fields" required/>
            </label><br/><br/>

            <input type="submit" class="the_buttons" name="submit" value="Autentifica"/>

        </form>

    </div>

    <div id="raspuns">
        <?php echo $raspuns; ?>
    </div>

</div>
<footer>
    <div class="footer">
        <p>&copy 2020-2021 Dezvoltarea Aplicațiilor Web - FMI - Ion Donescu</p>
    </div>
</footer>

</body>

</html>


