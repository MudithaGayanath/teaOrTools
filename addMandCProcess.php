<?php
session_start();
if (isset($_SESSION["a"])) {
    include("connection.php");
    $mId = $_POST["mName"];
    $cId = $_POST["cName"];
    
        $rs = Database::search("SELECT * FROM `model_has_color` WHERE `model_model_id`='".$mId."' AND `color_color_id`='".$cId."'");
        if ( $rs -> num_rows > 0){
            echo("have");
        }else{
            Database::iud("INSERT INTO `model_has_color`(`model_model_id`,`color_color_id`) VALUES ('".$mId."','".$cId."')");
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