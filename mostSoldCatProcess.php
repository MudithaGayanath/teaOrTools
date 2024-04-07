<?php
    session_start();
    include("connection.php");
    if ( isset($_SESSION["a"]) && $_SERVER["REQUEST_METHOD"] == "POST"){
        $rs = Database::search("SELECT * FROM `invoice` INNER JOIN product ON
        invoice.product_id=product.product_id INNER JOIN brand_has_categorie ON
        product.brand_has_categorie_id=brand_has_categorie.id");

        $array[0] = 0;
        $array[1] = 0;
        $array[2] = 0;

        for ($i=0; $i < $rs -> num_rows; $i++) { 
            $rsData = $rs -> fetch_assoc();
            if ( $rsData["categorie_categorie_id"] == 1 ){
                $array[0]++;
            }
            else if ( $rsData["categorie_categorie_id"] == 2 ){
                $array[1]++;
            }
            else if ( $rsData["categorie_categorie_id"] == 3 ){
                $array[2]++;
            }
        }

        echo(json_encode($array));
    }
?>