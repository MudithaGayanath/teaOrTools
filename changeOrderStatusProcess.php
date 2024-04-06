<?php
    session_start();
    include("connection.php");
    if ( isset($_SESSION["u"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
        $invoiceId = $_POST["inId"];
        $statusId = $_POST["sValue"];

        if ( $statusId != 0 ){
            $invoiceRs = Database::search("SELECT * FROM `invoice` WHERE `invoice_id`='".$invoiceId."'");
            $invoiceData = $invoiceRs -> fetch_assoc();

            if ( $statusId == $invoiceData["status_id"]) {
                echo(" Can't Change Order To Same Status");
            } else if ( $statusId <= $invoiceData["status_id"] ) {
                echo(" Illegal Status Change");
            } else {
                Database::iud("UPDATE `invoice` SET `status_id`='".$statusId."' WHERE `invoice_id`='".$invoiceId."' ");
                echo("done");
            }
        }else {
            echo("Invalid Status Type ");
        }

        

    }else {
        header("location:index.php");
    }
?>