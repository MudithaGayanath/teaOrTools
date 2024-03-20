<?php
    session_start();
    if ( $_SERVER["REQUEST_METHOD"] == "POST"){
        include("connection.php");
        $vc = $_POST["vc"];
        $rs = Database::search("SELECT * FROM `admin` WHERE `v_code`='".$vc."'");
        if ( $rs -> num_rows == 1 ){
            $_SESSION["a"] = $rs -> fetch_assoc();
            echo("done");
        }else {
            echo("Invalid Verification Code");
        }
    }
?>