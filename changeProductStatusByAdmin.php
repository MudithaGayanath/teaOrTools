<?php
session_start();
include("connection.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_SESSION["a"])) {
        $pid = $_POST["pid"];
        $rs = Database::search("SELECT * FROM `product` WHERE `product_id`='".$pid."'");
        $data = $rs ->fetch_assoc();
        $sid = $data["status_status_id"];
        if ( $sid == 1){
            Database::iud("UPDATE `product` SET `status_status_id`='2' WHERE `product_id`='".$pid."'");
        }else {
            Database::iud("UPDATE `product` SET `status_status_id`='1' WHERE `product_id`='".$pid."'");
        }
        echo("done");
    }
}
?>