<?php
    if ( isset($_POST["catId"])) {
        include("connection.php");
        $catId = $_POST["catId"];
        if ( $catId > 0 ){
            $brandRs = Database::search("SELECT * FROM `brand_has_categorie` INNER JOIN `brand` ON
            brand_has_categorie.brand_brand_id=brand.brand_id WHERE `categorie_categorie_id`='".$catId."'");
            ?>
            <option value="0">Select Brand</option>
            <?php
            for ($i=0; $i < $brandRs -> num_rows; $i++) { 
                $brandData = $brandRs -> fetch_assoc();
                ?>
                    <option value="<?php echo($brandData["brand_id"]);?>"><?php echo($brandData["brand_name"]);?></option>
                <?php
            }
        }else {
            echo("0");
        }
    }else {
        header("location : index.php");
    }
    
    
?>