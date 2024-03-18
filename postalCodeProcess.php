<?php
    if ( isset($_GET["cId"])){
        include("connection.php");
        $cId = $_GET["cId"];
        $pCodeRs = Database::search("SELECT * FROM `city` WHERE `city_id`='".$cId."'");
        $pCodeData = $pCodeRs -> fetch_assoc();
        $pCode = $pCodeData["postcode"];
        echo($pCode);
    }else {
        header("location:index.php");
    }
?>