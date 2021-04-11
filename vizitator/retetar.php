<?php
session_start();

include('../conectare.php');

if (isset($connect)) {
    $resultReteta = mysqli_query($connect, "SELECT reteta.owner,reteta.codreteta,reteta.titlu,reteta.datareteta,users.avatar FROM reteta LEFT JOIN users ON users.email = reteta.owner  ORDER BY datareteta DESC");
}

?>
<!DOCTYPE html>
<html lang="en">

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
    <link rel="stylesheet" href="retetar.css">
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="../users/styles_home.css">

    <title>Recipesnotebook</title>
</head>

<body id="body" class="py-3 d-flex flex-column body" style="max-width: 1200px" >
<nav class="navbar navbar-expand-sm navbar-light bg-light mb-3">
    <div class="container">
        <img src="../img/avatar.png" alt="avatar-picture" style="width: 50px; height: 50px;">
        <h6 class="navbar-brand"><a href="../index.html">Carnețelul culinar</a></h6>
<?php
include("../navbar/navbar.html");
?>
    </div>
</nav>
<div class="container">
    <div class="col text-center">
        <a href="../autentificare/autentificare.php" class="btn btn-primary btn-sm">Autentificare</a>
        <a href="../inregistrare/inregistrare.php" class="btn btn-primary btn-sm">Înregistrare</a>

    </div>
</div>
<section class="my-5 mx-2 text-center">
    <div class="container">
        <h2 class="text-center mb-3">Rețetele utilizatorilor</h2>
        <div class="row">

            <?php
            /*
             * afiseaza toate rețetele utilizatorilor
             */
            if ($resultReteta->num_rows > 0) {
                // output data of each row
                while ($row = $resultReteta->fetch_assoc()) {
                    $ownerReteta = $row["owner"];
                    $codReteta = $row["codreteta"];
                    $avatar = $row["avatar"];
                    if (isset($connect)) {
                        $resultFoto = mysqli_query($connect, "SELECT numefotografie FROM fotoretete WHERE codreteta = '$codReteta'");
                        if ($resultFoto->num_rows > 0) {
                            // output data of each row
                            $rowFoto = $resultFoto->fetch_assoc();
                            $file = $rowFoto["numefotografie"];
                            //var_dump($file);
                        }
                    }
                    echo '
<!-- col-lg-3 - 4 coloane pt larger screen md-6 - 2 coloane pt medium screen -->
                        <div class="col-lg-3 col-md-6 mb-3">                   
                            <div class="card">
                                <div class="card-body">                                            
                                    <h5 class="text-primary text-truncate">' . $row["titlu"] . '</h5>
                                    <div class="fotocontainer">
                                        <img class="reteta" src="../' . 'users/' . $ownerReteta . '/' . $codReteta . '/foto/' . $file . '" alt="avatar">
                                        <img class="avatar" src="../users/images/poza_profil/'.$avatar.'" alt="avatar" >
                                    </div>
                                    <p class="card-text text-justify">'.'<div class="container text-truncate">'.
                        file_get_contents('../users/'.$ownerReteta . '/' . $codReteta . '/descriere_' . $codReteta . '.txt').'</div>'.'
                                    <a class="btn btn-primary btn-sm text-white" onclick="arataReteta(\'' . $codReteta . '\')" role="button">Vizualizează</a>
                               </div>
                            </div>
                        </div>';

                }
            }

            ?>
        </div>
    </div>
</section>

<?php
include("../footer.html");
?>
<script src="reteta.js"></script>
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
</html>