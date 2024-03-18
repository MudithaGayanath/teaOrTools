<?php
    session_start();
    include("connection.php");
    if ( isset($_SESSION["u"]) && isset($_GET["disId"])){
        $disId = $_GET["disId"];
        if ( $disId > 0 ){
            $cityRS = Database::search("SELECT * FROM `city` WHERE `district_id`='".$disId."' ORDER BY `city_name` ASC");
            ?>
            <option value='0'> Select City </option>
            <?php
            for ($i=0; $i < $cityRS -> num_rows; $i++) { 
                $cityData = $cityRS -> fetch_assoc();
                ?>
                    <option value="<?php echo($cityData["city_id"])?>"><?php echo($cityData["city_name"])?></option>
                <?php
            }
            
        }else {
            echo("0");
        }
    }else {
        header("location:index.php");
    }

?>