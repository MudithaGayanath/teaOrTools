<?php
    session_start();
    if ( isset($_SESSION["u"]) && isset($_GET["proid"])){
        
        include("connection.php");
        $proId = $_GET["proid"];
        if ( $proId > 0) {
            $disRs = Database::search("SELECT * FROM `district` WHERE `province_id`='".$proId."' ORDER BY `district_name` ASC ");
            ?>
                <option value='0'> Select District</option>
                <?php
            for ($i=0; $i < $disRs -> num_rows; $i++) { 
                
                $disData = $disRs -> fetch_assoc();
                ?>
                    <option value="<?php echo($disData["district_id"])?>"><?php echo($disData["district_name"])?></option>
                <?php
            }
            
        }else {
            echo("0");
        }
        
    }else {
        header("location:index.php");
    }
?>