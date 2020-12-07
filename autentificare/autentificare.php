<?php
session_start();
include ("../connect.php");
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
                        // redirectioneaza catre pagina utilizatorului
                        header('Location: ../home.php');
                    }
                    else {
                        $raspuns = "Parola incorecta";
                    }
                }
            }
            else {
                // Incorrect username
                $raspuns = "Acest email nu exista";
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

<div id="wrapper">
    <h3 id="title">Bine ai venit  pe <br/> myrecipesnotebook.com</h3>
    <div id="formDiv">
        <!-- method POST is for background data "you don't see anything in URL" -->
        <!--enctype -- to be able to upload file such as images -->
        <form method="POST" action="../autentificare/autentificare.php" enctype="multipart/form-data">

            <label>
                Email:<br/>
                <input type="text" name="email" class="inputFields" required/>
            </label><br/><br/>

            <label>
                Parola:<br/>
                <input type="password" name="parola" class="inputFields" required/>
            </label><br/><br/>

            <input type="submit" class="theButtons" name="submit" value="Autentifica"/>

        </form>

    </div>

    <div id="raspuns">
        <?php echo $raspuns; ?>
    </div>

</div>

</body>

</html>


