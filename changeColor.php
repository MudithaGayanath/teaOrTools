<?php
    if ( isset($_POST["modelId"])) {
        include("connection.php");
        $modelId = $_POST["modelId"];
        if ( $modelId > 0 ){
            $colorRs = Database::search("SELECT * FROM `model_has_color` INNER JOIN `color` ON
            model_has_color.color_color_id=color.color_id WHERE `model_model_id`='".$modelId."'");
            ?>
            <option value="0">Select Color</option>
            <?php
            for ($i=0; $i < $colorRs -> num_rows; $i++) { 
                $colorData = $colorRs -> fetch_assoc();
                ?>
                    <option value="<?php echo($colorData["color_id"]);?>"><?php echo($colorData["color_name"]);?></option>
                <?php
            }
        }else {
            echo("0");
        }
    }else {
        header("location : index.php");
    }
    
    
?>