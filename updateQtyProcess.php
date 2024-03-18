<?php
    session_start();
    if ( isset($_SESSION["u"])){
        if ( $_SERVER["REQUEST_METHOD"] == "POST"){
            include("connection.php");
            $pid = $_POST["pId"];
            $qty = $_POST["qty"];

            $productRs = Database::search("SELECT * FROM `product` WHERE `product_id`='".$pid."'");
            $productData = $productRs -> fetch_assoc();
            $currentQty = $productData["qty"];
            $newQty = $currentQty - $qty;

            Database::iud("UPDATE `product` SET `qty`='".$newQty."' WHERE `product_id`='".$pid."'");
            
        }else{
            header("location:index.php");
        }
    }else{
        header("location:login.php");
    }
?>