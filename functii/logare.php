<?php
    function logare(){
        if(isset($_SESSION['email'])){
            return true;
        }
        else {
            return false;
        }
    }
?>
