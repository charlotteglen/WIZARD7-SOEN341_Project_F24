<?php
session_start();

//Check is SESSION is set
if(isset($_SESSION['user_id'])){

    //Then unset it
    unset($_SESSION['user_id']);
}


//Redirect the user
header("Location: login.php");
die;
?>