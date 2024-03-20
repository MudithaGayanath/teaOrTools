<?php
    session_start();
    if ( $_SERVER["REQUEST_METHOD"] == "POST"){
        include("connection.php");
        $vc = $_POST["vc"];
        $rs = Database::search("SELECT * FROM `admin` WHERE `v_code`='".$vc."'");
        if ( $rs -> num_rows == 1 ){
            $data = $rs -> fetch_assoc();
            $_SESSION["a"] = $data;
            echo("done");
        }else {
            echo("Invalid Verification Code");
        }
    }
?>