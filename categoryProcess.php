<?php
    session_start();
    if (isset($_SESSION["a"])){
        include("connection.php");
        $catRs = Database::search("SELECT * FROM `invoice` INNER JOIN `product` ON
        invoice.product_id=product.product_id INNER JOIN `brand_has_categorie` ON
        product.brand_has_categorie_id=brand_has_categorie.id ");

        $tea = "0";
        $m = "0";
        $f = "0";
        for ($i=0; $i < $catRs -> num_rows; $i++) { 
            $data = $catRs -> fetch_assoc();
            if ( $data["categorie_categorie_id"] == "1"){
                $tea ++;
            }else if (  $data["categorie_categorie_id"] == "2"){
                $f++;
            }else if (  $data["categorie_categorie_id"] == "3"){
                $m++;
            }
        }
        $array["tea"] = $tea;
        $array["f"] = $f;
        $array["m"] = $m;
        echo(json_encode($array));
        
    }
?>