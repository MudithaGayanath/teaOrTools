<?php
session_start();
if (isset($_SESSION["a"])) {
    include("connection.php");
    $bId = $_POST["bName"];
    $cId = $_POST["cName"];
    
        $rs = Database::search("SELECT * FROM `brand_has_categorie` WHERE `brand_brand_id`='".$bId."' AND `categorie_categorie_id`='".$cId."'");
        if ( $rs -> num_rows > 0){
            echo("have");
        }else{
            Database::iud("INSERT INTO `brand_has_categorie`(`brand_brand_id`,`categorie_categorie_id`) VALUES ('".$bId."','".$cId."')");
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