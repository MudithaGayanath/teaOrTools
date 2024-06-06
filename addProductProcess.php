<?php
    if ( $_SERVER["REQUEST_METHOD"] == "POST"){
        session_start();
        include("connection.php");
        $email = $_SESSION["u"]["email"];
        $status = 1;

        $cat = $_POST["ca"];
        $brand = $_POST["b"];
        $model = $_POST["m"];
        $title = $_POST["t"];
        $con = $_POST["con"];
        $color = $_POST["col"];
        $qty = $_POST["q"];
        $price = $_POST["co"];
        $diuc = $_POST["diuc"];
        $dofuc = $_POST["dofuc"];
        $discription = $_POST["de"];

        if ( $cat == 0 ) {
            echo("Please Select Category");
        }else if ( $brand == 0 ) {
            echo("Please Select Brand");
        }else if ( $model == 0 ) {
            echo("Please Select Model");
        }else if (empty($title)) {
            echo("Please Enter Product Title ");
        }
        else if ( strlen($title) > 45 ){
            echo("Title Length Should be Lower Than 45 Characters");
        }
        elseif ( empty($con)) {
            echo("Please Select Condithion");
        }
        elseif ($color == 0 ) {
            echo("Please Select Color");
        }
        elseif (empty($price)) {
            echo("Please Enter Price Per Item");
        }
        elseif ($price < 0 ){
            echo("Invalid Price");
        }
        elseif (empty($qty)) {
            echo("Please Enter Qty");
        }
        else if( $qty < 0 ){
            echo("Invalid Qty");
        }
        elseif (empty($diuc)){
            echo("Please Enter Delevery Fee In Your City");
        }
        else if ( $diuc < 0) {
            echo("Invalid Delevery Fee");
        }
        elseif (empty($dofuc)){
            echo("Please Enter Delevery Fee Out Of  Your City");
        }
        else if ( $dofuc < 0){
            echo("Invalid Delevery Fee");
        }
        elseif (empty($discription)){
            echo("Please Enter Discription");
        }
        else if ( strlen($discription) > 1000 ){
            echo("Description Length Should be Lower Than 100 Characters");
        }
        else if (empty($_FILES)) {
            echo("Please Add Product Images");
        }else {
            $d = new DateTime();
            $tz = new DateTimeZone("Asia/Colombo");
            $d->setTimezone($tz);
            $date = $d->format("Y-m-d H:i:s");

            $brandHasCatRs = Database::search("SELECT * FROM `brand_has_categorie` WHERE `brand_brand_id`='".$brand."' AND `categorie_categorie_id`='".$cat."'");
            $brandHasCatData = $brandHasCatRs -> fetch_assoc();
            $brandHasCatId = $brandHasCatData["id"];

            $modelHsaBrandRs = Database::search("SELECT * FROM `model_has_brand` WHERE `model_model_id`='".$model."' AND `brand_brand_id`='".$brand."'");
            $modelHsaBrandData = $modelHsaBrandRs -> fetch_assoc();
            $modelHsaBrandId = $modelHsaBrandData["id"];

            $modelHsaColorRs = Database::search("SELECT * FROM `model_has_color` WHERE `model_model_id`='".$model."' AND `color_color_id`='".$color."'");
            $modelHsaColorData = $modelHsaColorRs -> fetch_assoc();
            $modelHsaColorId = $modelHsaColorData["id"];

            Database::iud("INSERT INTO `product` (`title`,`price`,`qty`,`discription`,`add_date_time`,`delevery_in_user_city`,`delevery_outof_usre_city`,`brand_has_categorie_id`,`model_has_brand_id`,`condition_condition_id`,`user_email`,`model_has_color_id`,`status_status_id`) VALUES ('".$title."','".$price."','".$qty."','".$discription."','".$date."','".$diuc."','".$dofuc."','".$brandHasCatId."','".$modelHsaBrandId."','".$con."','".$email."','".$modelHsaColorId."','".$status."')");
            
            $pid = Database::$connection -> insert_id;
            $size = sizeof($_FILES);
            for ($i=0; $i < $size; $i++) { 
                $img = $_FILES["i".$i];
                $type = $img["type"];
                $exetention = "";

                if ( $type == "image/jpeg") {
                    $exetention = ".jpeg";
                }else if ( $type == "image/png" ) {
                    $exetention = ".png";
                }else if ( $type == "image/svg+xml" ) {
                    $exetention = ".svg";
                }
                $fileName = "img//product//".$title."_".$i."_".uniqid().$exetention;
                move_uploaded_file($img["tmp_name"],$fileName);

                Database::iud("INSERT INTO `product_img` (`path`,`product_product_id`) VALUES ('".$fileName."','".$pid."')");

            }
            echo("add");
        }
    }else {
        header("location:index.php");
    }
?>