<?php
    if ( $_SERVER["REQUEST_METHOD"] === "POST"){
        include("connection.php");
        session_start();

        $email = $_POST["e"];
        $pass = $_POST["pw"];
        $rem = $_POST["rem"];


        if (empty($email)) {
            echo("Please Enter Your Email Address.");
        }else if ( !filter_var($email , FILTER_VALIDATE_EMAIL)) {
            echo("Invalid Email Address.");
        }else if (empty($pass)) {
            echo("Please Enter Your Password.");
        }else {
            $rs = Database::search("SELECT * FROM `user` WHERE `email`='".$email."' AND `password`='".$pass."'");

            if ( $rs -> num_rows == 1 ){
                $rsData = $rs -> fetch_assoc();
                $_SESSION["u"] = $rsData;
                if ($rem == "true") {
                    setcookie("email", $email , time()+(60*60*24*365));
                    setcookie("pass", $pass , time()+(60*60*24*365));
                }
                echo("done");
            }else {
                echo("Invalid Email Address or Passowrd.");
            }
        }
       
    }else {
        
        header("location:index.php");
    }
    


?>