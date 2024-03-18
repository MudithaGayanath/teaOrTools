<?php
    session_start();
    if ( isset($_SESSION["u"]) && $_SERVER["REQUEST_METHOD"] === "POST"){
        include("connection.php");
        $email = $_SESSION["u"]["email"];
        $address1=$_POST["address1"];
        $address2=$_POST["address2"];
        $provinc=$_POST["provinc"];
        $distric=$_POST["distric"];
        $city=$_POST["city"];

        if ( empty($address1)){
            echo("Please Enter  Address Line 1");
        }
        else if ( strlen($address1) > 45 ) {
            echo("Address Line 1 Too Long");
        }
        else if ( empty($address2)){
            echo("Please Enter  Address Line 2");
        }
        else if ( strlen($address2) > 45 ) {
            echo("Address Line 2 Too Long");
        }
        else if ( $provinc == 0 ){
            echo("Please Select Province");
        }
        else if ( $distric == 0 ){
            echo("Please Select District");
        }
        else if ( $city == 0 ){
            echo("Please Select City");
        }
        
        else {
            $addRs = Database::search("SELECT * FROM `user_has_address` WHERE `user_email`='".$email."'");
            if ( $addRs -> num_rows > 0 ) {
                Database::iud("UPDATE `user_has_address` SET `city_city_id`='".$city."',`line1`='".$address1."',`line2`='".$address2."' WHERE `user_email`='".$email."' ");
                echo("updated");
            }else {
                Database::iud("INSERT INTO `user_has_address` (`user_email`,`city_city_id`,`line1`,`line2`) VALUES
                ('".$email."','".$city."','".$address1."','".$address2."')");
                echo("done");
            }
            
        }
    }else {
        header("location:index.php");
    }
    
?>