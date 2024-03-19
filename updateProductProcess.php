<?php
    session_start();
    if ( $_SERVER["REQUEST_METHOD"] == "POST"){
        if ( isset($_SESSION["u"])){
            include("connection.php");
            $pid = $_POST["pId"];
            $status = $_POST["status"];
            $qty = $_POST["qty"];
            $inCity = $_POST["inCity"];
            $outCity = $_POST["outCity"];
            $price = $_POST["price"];

            if ( empty($pid)){
                echo("Something Went Wrong");
            }else if ( empty($qty)){
                echo("Empty QTY");
            }else if ( empty($inCity)){
                echo("Empty Delivery Fee In City");
            }else if ( empty($outCity)){
                echo("Empty Delivery Fee Out of City");
            }else if ( empty($price)){
                echo("Empty Price");
            }elseif ( $price < 0 ){
                echo("Invalid Price");
            }elseif($qty < 0 ){
                echo("Invalid QTY");
            }else if ($inCity < 0) {
                echo("Invalid Delivery Fee");
            }else if ($outCity <0) {
                echo("Invalid Delivery Fee");
            } else {
                $rs = Database::search("SELECT * FROM `product` WHERE `product_id`='".$pid."'");
                if ( $rs -> num_rows > 0 ){
                    Database::iud("UPDATE `product` SET `price`='".$price."' , `qty`='".$qty."' , `delevery_in_user_city`='".$inCity."' , `delevery_outof_usre_city`='".$outCity."' , `status_status_id`='".$status."' WHERE `product_id`='".$pid."'");
                    echo("done");
                }else {
                    echo("Something Went Wrong");
                }
            }
        }else {
            header("location:login.php");
        }
    }else {
        header("location:index.php");
    }
?>