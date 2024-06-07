<?php
    session_start();
    if ( isset ( $_SESSION["u"])  ){
        $email = $_SESSION["u"]["email"];
        $pId = $_GET["pId"];
        include("connection.php");
        $wishListRs = Database::search("SELECT * FROM `wish_list` WHERE `user_email`='".$email."' AND `product_id`='".$pId."'");
        if ( $wishListRs -> num_rows > 0 ) {
            Database::iud("DELETE FROM `wish_list` WHERE `user_email`='".$email."' AND `product_id`='".$pId."' ");
            echo("r");
        }else {
            Database::iud("INSERT INTO `wish_list` (`user_email`,`product_id`) VALUES ('".$email."','".$pId."')");
            echo("a");
        }
            
        
    }else{
       echo("l");
    }
?>