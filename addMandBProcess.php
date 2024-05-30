<?php
session_start();
if (isset($_SESSION["a"])) {
    include("connection.php");
    $mId = $_POST["mName"];
    $bId = $_POST["bName"];
    
        $rs = Database::search("SELECT * FROM `model_has_brand` WHERE `model_model_id`='".$mId."' AND `brand_brand_id`='".$bId."'");
        if ( $rs -> num_rows > 0){
            echo("have");
        }else{
            Database::iud("INSERT INTO `model_has_brand`(`model_model_id`,`brand_brand_id`) VALUES ('".$mId."','".$bId."')");
            echo (" added successfully");
        }
    
} else {
    ?>
        <script>
            alert("Illegal Admin  Access Denied");
            window.location = "index.php";
        </script>
    <?php
    }
?>