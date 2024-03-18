<?php
    
    

    if ( $_SERVER["REQUEST_METHOD"] === "POST"){
        session_start();
        include("connection.php");

        $image = $_FILES["i"];
        $image_extension = $image["type"];
        $email = $_SESSION["u"]["email"];
        $fname = $_SESSION["u"]["fname"];

        $new_img_extension;
        if($image_extension == "image/jpeg"){
            $new_img_extension = ".jpeg";
        }else if($image_extension == "image/png"){
            $new_img_extension = ".png";
        }else if($image_extension == "image/svg+xml"){
            $new_img_extension = ".svg";
        }

        $file_name = "img//userProfile//".$fname."_".uniqid().$new_img_extension;
        move_uploaded_file($image["tmp_name"],$file_name);
    
        $profile_img_rs = Database::search("SELECT * FROM `user_img` WHERE `user_email`='".$email."'");
        if ( $profile_img_rs -> num_rows == 1 ){
            $profile_img_Data = $profile_img_rs -> fetch_assoc();
            unlink($profile_img_Data["path"]);
            Database::iud("UPDATE `user_img` SET `path`='".$file_name."'WHERE `user_email`='".$email."' ");
            
        }else {
            Database::iud("INSERT INTO `user_img` VALUES ('".$file_name."','".$email."')");
            
        }
    }else{
        header("location:index.php");
    }
   

   

?>