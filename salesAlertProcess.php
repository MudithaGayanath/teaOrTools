<?php
    session_start();
    include("connection.php");
    if ( $_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION["u"])){
        $sellrProductRs = Database::search("SELECT * FROM `invoice` INNER JOIN `product` ON
        invoice.product_id=product.product_id  WHERE `user_email`='".$_SESSION["u"]["email"]."' AND `view_id`='1'");
        
        $count = $sellrProductRs -> num_rows;
        echo($count);
    }else {

    }
?>