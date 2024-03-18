<?php
    session_start();
    if ( isset($_SESSION["u"]) && isset($_GET["cId"])){
        include("connection.php");
        $email = $_SESSION["u"]["email"];
        $cid = $_GET["cId"];

        $cartRS = Database::search("SELECT * FROM `cart` WHERE `user_email`='".$email."' AND `product_product_id`='".$cid."'");
        if ( $cartRS -> num_rows > 0 ){
            Database::iud("DELETE FROM `cart` WHERE `user_email`='".$email."' AND `product_product_id`='".$cid."'");
            echo("r");
        }else {
            echo("Something Went Wrong");
        }
    }else{
        ?>
            <script>
                window.location = "login.php";
            </script>
        <?php
    }
?>