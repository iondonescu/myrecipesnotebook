<?php
    function email_exists($email,$connect ){
        $interogare = mysqli_query($connect,"SELECT id FROM users WHERE email='$email'");

        if(mysqli_num_rows($interogare) !== 1){
            return false;

        }
        else{
            return true;
        }
    }
?>
