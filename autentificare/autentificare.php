<?php
session_start();
include("../conectare.php");
include("../functii/emailExists.php");

$raspuns = "";//variabila utilizata pt a afisa erori ex: parola introdusa gresit

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
                    } else {
                        $raspuns = "E-mail sau parola incorecte";
                    }
                }
            } else {
                // Incorrect username
                $raspuns = "Acest email nu exista! Reîncercați sau mergeți la pagina de înregistrare.";
            }
            $stmt->close();
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
    <!-- folosim framework-ul bootstrap 4.1-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css"
          integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
    <link rel="stylesheet" href="../style.css">
    <title>Recipesnotebook</title>
</head>


<body>
<?php
include ("../header.html");
?>

<!--sectiunea de autentificare-->
<section>
    <div class="container mt-3">
        <div class="row">
            <div class="col-md-6 mx-auto">
                <div class="card">
                    <div class="card-header">
                        <h4>Autentificare</h4>
                    </div>
                    <div class="card-body">
                        <!-- method POST is for background data "you don't see anything in URL" -->
                        <!--enctype -- to be able to upload file such as images -->
                        <form method="post" action="../autentificare/autentificare.php" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="email">E-mail</label>
                                <input class="form-control" type="text" name="email" required/>
                            </div>
                            <div class="form-group">
                                <label for="password">Parolă</label>
                                <input class="form-control" type="password" name="parola" required/>
                            </div>
                            <input class="btn btn-primary btn-block" type="submit" name="submit" value="Autentifică"/>
                        </form>
                        <div id="raspuns">
                            <?php echo $raspuns; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- FOOTER -->
<?php
include("../footer.html");
?>

</body>

</html>


