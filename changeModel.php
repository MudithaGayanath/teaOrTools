<?php
     if ( isset($_POST["brandId"])) {
        include("connection.php");
        $brandId = $_POST["brandId"];
        if ( $brandId > 0 ){
            $modelRs = Database::search("SELECT * FROM `model_has_brand` INNER JOIN `model` ON
            model_has_brand.model_model_id=model.model_id WHERE `brand_brand_id`='".$brandId."'");
            ?>
            <option value="0">Select Model</option>
            <?php
            for ($i=0; $i < $modelRs -> num_rows; $i++) { 
                $modelData = $modelRs -> fetch_assoc();
                ?>
                    <option value="<?php echo($modelData["model_id"]);?>"><?php echo($modelData["model_name"]);?></option>
                <?php
            }
        }else {
            echo("0");
        }
    }else {
        header("location : index.php");
    }
?>