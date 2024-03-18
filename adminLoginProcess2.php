<?php
    if ( $_SERVER["REQUEST_METHOD"] == "POST"){
        include("connection.php");
        $vc = $_POST["vc"];
        $rs = Database::search("SELECT * FROM `admin` WHERE `v_code`='".$vc."'");
        if ( $rs -> num_rows == 1 ){
            echo("done");
        }else {
            echo("Invalid Verification Code");
        }
    }
?>