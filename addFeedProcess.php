<?php
session_start();
if (isset($_SESSION["u"]) && $_SERVER["REQUEST_METHOD"] === "POST") {
    include("connection.php");
    $email = $_SESSION["u"]["email"];
    $pid = $_POST["pid"];
    $comment = $_POST["comment"];
    $type = $_POST["type"];

    $rs = Database::search("SELECT * FROM `feedback` WHERE `product_product_id`='". $pid ."' AND `user_email`='" . $email . "'");
    if ($rs->num_rows > 0) {
        echo ("have");
    } else {
        if (empty($comment)) {
            echo ("empty");
        } elseif (strlen($comment) > 200) {
            echo ("long");
        } else {
            $d = new DateTime();
            $tz = new DateTimeZone("Asia/Colombo");
            $d->setTimezone($tz);
            $date = $d->format("Y-m-d H:i:s");
            Database::iud("INSERT INTO `feedback` (`feedback`,`feed_type`,`added_date`,`product_product_id`,`user_email`) 
            VALUES  ('".$comment."','".$type."','".$date."','".$pid."','".$email."')");
            echo("done");
        }
    }
} else {
    header("location:login.php");
}
