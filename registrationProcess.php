<?php
    if ( $_SERVER["REQUEST_METHOD"] === "POST"){
            include("connection.php");

        $fname = $_POST["fn"];
        $lname = $_POST["ln"];
        $email = $_POST["e"];
        $pw1 = $_POST["pw1"];
        $pw2 = $_POST["pw2"];
        $mobile = $_POST["m"];
        $gen = $_POST["g"];
        $status = 1;

        if(empty($fname)){
            echo ("Please Enter Your First Name.");
        }else if(strlen($fname) > 50){
            echo ("First Name Must Contain LOWER THAN 50 characters.");
        }else if(empty($lname)){
            echo ("Please Enter Your Last Name.");
        }else if(strlen($lname) > 50){
            echo ("Last Name Must Contain LOWER THAN 50 characters.");
        }else if(empty($email)){
            echo ("Please Enter Your Email Address.");
        }else if(strlen($email) > 100){
            echo ("Email Address Must Contain LOWER THAN 100 characters.");
        }else if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
            echo ("Invalid Email Address.");
        }else if(empty($pw1)){
            echo ("Please Enter Your Password.");
        }else if(strlen($pw1) < 5 || strlen($pw1) > 20){
            echo ("Password Must Contain 5 to 20 Characters.");
        }
        else if(empty($pw2)){
        echo ("Please Retype Your Password.");
        }
        else if( $pw1 != $pw2){
            echo("Password Did Not Match");
        }
        else if(empty($mobile)){
            echo ("Please Enter Your Mobile Number.");
        }else if(strlen($mobile) != 10){
            echo ("Mobile Number Must Contain 10 characters.");
        }else if(!preg_match("/07[0,1,2,4,5,6,7,8]{1}[0-9]{7}/",$mobile)){
            echo ("Invalid Mobile Number.");
        }else {
            $userRs = Database::search("SELECT * FROM `user` WHERE `email`='".$email."' AND `mobile`='".$mobile."'");
            if ( $userRs -> num_rows > 0 ){
                echo ("User with the same Email Address or same Mobile Number already exists.");
            }else {  
            $d = new DateTime();
            $tz = new DateTimeZone("Asia/Colombo");
            $d->setTimezone($tz);
            $date = $d->format("Y-m-d H:i:s");

            Database::iud("INSERT INTO `user` (`fname`,`lname`,`email`,`password`,`mobile`,`joined_date`,`status_status_id`,`gender_gender_id`) 
            VALUES ('".$fname."','".$lname."','".$email."','".$pw2."','".$mobile."','".$date."','".$status."','".$gen."')");
            echo("done");
            }
        }
    }else {
        header("location:index.php");
    }
    
?>