<?php
    session_start();
    if ( isset($_SESSION["u"])){
        $_SESSION["u"] = null;
        setcookie("email","" , time() + (-1));
        setcookie("pass", "" , time() + (-1));
       
        echo("done");
    }
?>