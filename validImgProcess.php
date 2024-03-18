<?php
    if ( isset($_FILES) ){
        $size = sizeof($_FILES);
        if ( $size < 4  ){
            $allowed_image_extensions = array("image/jpeg","image/png","image/svg+xml");
            $v = 0;
            for ($i=0; $i < $size; $i++) { 
                $img = $_FILES["i".$i];
                $type = $img["type"];

                if ( in_array($type , $allowed_image_extensions)){
                    $v = 1;
                }else {
                    $v= 0 ;
                    break;
                }
            }
            if ( $v == 1 ){
                echo("valid");
            }else {
                echo("Invalid");
            }
        }else {
            echo("Maximum Count Is 3 ");
        }
        
    }else {
        header("location:index.php");
    }
?>