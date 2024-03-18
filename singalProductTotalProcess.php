<?php
    session_start();
    
        if( $_SERVER["REQUEST_METHOD"] == "POST"){
            $deliveryFee = $_POST["deliveryFee"];
            $qty = $_POST["qty"];
            $price = $_POST["price"];
            $item = $_POST["item"];

            if  ( empty($qty)){
                echo("0");
            }
            elseif ( $qty < 0   ){
                echo("invalid");
            }else if ( $qty > $item){
                echo("over");
                
            }
            else {
                $tot = ($price * $qty ) + $deliveryFee;
                echo($tot);
            }

           
        }else{
            echo("get");
            ?>
        <script>
            window.location = "index.php";
        </script>
        <?php 
        }
   
?>