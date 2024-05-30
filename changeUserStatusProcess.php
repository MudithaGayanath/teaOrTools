<?php
session_start();
include("connection.php");
if($_SERVER["REQUEST_METHOD"] == "POST"){
    if (isset($_SESSION["a"])){
     $email = $_POST["e"];
     $e =  explode(" ",$email);
     $rs = Database::search("SELECT * FROM `user` WHERE `email`='".$e[1]."'");
     $data = $rs-> fetch_assoc();
     $sId = $data["status_status_id"];
     if ( $sId == 1 ){
        Database::iud("UPDATE `user` SET `status_status_id`='2' WHERE `email`='".$e[1]."' ");
     }else{
        Database::iud("UPDATE `user` SET `status_status_id`='1' WHERE `email`='".$e[1]."' ");
     }
     echo("done");
    }else {
      echo ( "illeagel");
    }
}else{
   echo ("illeagel");
}

?>