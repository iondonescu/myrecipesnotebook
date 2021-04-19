<?php
/*
 * deconectarea ca utilizator inregistrat
 * stergerea datelor din sirul generat de session_start
 */
session_start();
session_destroy();
// redirectioneaza catre pagina de start
header('Location: vizitator/retetar.php');
?>