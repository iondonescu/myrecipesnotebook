<?php
session_start();
session_destroy();
// redirectioneaza catre pagina de start
header('Location: vizitator/retetar.php');
?>