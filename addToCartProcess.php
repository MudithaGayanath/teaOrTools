<?php
    session_start();
    if ( isset($_SESSION["u"]) && isset($_GET["pId"]) && isset($_GET["qty"]) ){
        include("connection.php");
        $email = $_SESSION["u"]["email"];
        $pid = $_GET["pId"];
        $qty = $_GET["qty"];

        if ( empty($qty)){
            echo("Please Enter QTY");
        }else if ( $qty <= 0 ) {
            echo("Invalid Number");
        }else {
            
            $selfRs = Database::search("SELECT * FROM `product` WHERE `product_id`='".$pid."' AND `user_email`='".$email."'");
            if ( $selfRs -> num_rows > 0 ){
                echo("Self Items Can't Add To Cart");
            }else {
                $productQtyRs = Database::search("SELECT * FROM `product` WHERE `product_id`='".$pid."'");
                $productQtyData = $productQtyRs -> fetch_assoc();
                $productQty = $productQtyData["qty"];
                
                

            if ( $qty > $productQty){
                echo("Over Limit");
            }else {
                Database::iud("INSERT INTO `cart` (`qty`,`user_email`,`product_product_id`) VALUES 
                ('".$qty."','".$email."','".$pid."')");
                echo("Added To Cart");
            }
            }

            
        }
    }else {
        echo("log");
    }
?>