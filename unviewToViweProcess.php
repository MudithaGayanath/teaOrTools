<?php
    session_start();
    include("connection.php");
    if ( isset($_SESSION ["u"]) && $_SERVER["REQUEST_METHOD"] == "POST"){
        $inId = $_POST["inId"];
        Database::iud("UPDATE `invoice` SET `view_id`='2' WHERE `invoice_id`='".$inId."'");
        echo("done");
    }
?>