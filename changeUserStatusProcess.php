<?php
session_start();
include("connection.php");
if($_SERVER["REQUEST_METHOD"] == "POST"){
    if (isset($_SESSION["a"])){
     $email = $_POST["e"];
    
     $rs = Database::search("SELECT * FROM `user` WHERE `email`='".$email."'");
     $data = $rs-> fetch_assoc();
     $sId = $data["status_status_id"];
     if ( $sId == 1 ){
        Database::iud("UPDATE `user` SET `status_status_id`='2' WHERE `email`='".$email."' ");
     }else{
        Database::iud("UPDATE `user` SET `status_status_id`='1' WHERE `email`='".$email."' ");
     }
     echo("done");
    }else {
      echo ( "illeagel");
    }
}else{
   echo ("illeagel");
}

?>