<?php
 if ( $_SERVER["REQUEST_METHOD"] == "POST" ){
    include("connection.php");
    $email = $_POST["em"];
    $np = $_POST["np"];
    $rnp = $_POST["rnp"];
    $vc = $_POST["vc"];

    if ( empty($np)){
        echo("Enter Password");
    }else if ( empty($rnp)) {
        echo("Retype Your Password");
    }else if ( empty($vc)) {
        echo("Enter Verification Code");
    }else if ( $np != $rnp ){
        echo("Password Didn't Match");
    }else if(strlen($np) < 5 || strlen($np) > 20){
        echo ("Password Must Contain 5 to 20 Characters.");
    }else if(strlen($rnp) < 5 || strlen($rnp) > 20){
        echo ("Password Must Contain 5 to 20 Characters.");
    }else {
        $userRs = Database::search("SELECT * FROM `user` WHERE `email`='".$email."' AND `v_code`='".$vc."'");
        if ( $userRs -> num_rows > 0 ){
            Database::iud("UPDATE `user` SET `password`='".$rnp."' WHERE `email`='".$email."' AND `v_code`='".$vc."' ");
            echo("done");
        }else {
            echo("Invalid Verification Code");
        }
    }

 }else {
    header("location:login.php");
 }

?>