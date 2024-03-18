<?php
    if (isset($_POST["sId"])){
        session_start();
        include("connection.php");
        $sId = $_POST["sId"];
        $email = $_SESSION["u"]["email"];
        $query = ("SELECT * FROM `product` ");

        if ( $sId == 1 ){
            $query .=(" WHERE `user_email`='".$email."' ORDER BY `add_date_time` DESC ");
        }else if ( $sId == 2 ){
            $query .= (" WHERE `user_email`='".$email."' ORDER BY `add_date_time` ASC ");
        }else if ( $sId == 3 ){
            $query .= (" WHERE `user_email`='".$email."' ORDER BY `price` DESC ");
        }else if ( $sId ==  4 ){
            $query .= (" WHERE `user_email`='".$email."' ORDER BY `price` ASC ");
        }else if ( $sId == 5 ){
            $query .= (" WHERE `user_email`='".$email."' AND `condition_condition_id`='1' ");
        }else if ( $sId == 6 ){
            $query .= (" WHERE `user_email`='".$email."' AND `condition_condition_id`='2' ");
        }else if ( $sId == 7 ){
            $query .= (" WHERE `user_email`='".$email."' AND `status_status_id`='1' ");
        }else if ( $sId == 8 ){
            $query .= (" WHERE `user_email`='".$email."' AND `status_status_id`='2' ");
        }

        $productRs = Database::search($query);
        $row = $productRs -> num_rows;
        if ( $row > 0 ){
            for ($i=0; $i < $row; $i++) { 
                $proData = $productRs -> fetch_assoc();
                $proId = $proData["product_id"];
                $imgRs = Database::search("SELECT * FROM `product_img` WHERE `product_product_id`='".$proId."'");
                $imgData = $imgRs -> fetch_assoc();
                $imgPath = $imgData["path"];
                ?>
                <div class="col-10 offset-1 ms-5 ms-md-0 mt-3 col-md-6 offset-md-0 col-xl-4 mb-3  " >
                    <div class="card" style="width: 18rem;">
                        <img src="<?php echo($imgPath);?>" class=" img-fluid" alt="..."  style="width: 300px; height: 200px;">
                        <div class="card-body text-center">
                            <h4 class="m-0"><?php echo($proData["title"]);?></h4>
                            <p class=" m-0">Rs.<?php echo($proData["price"]);?>.00</p>
                            <p class=" m-0">QTY - <?php echo($proData["qty"]);?></p>
                            <p class=" text-info fw-bold m-0">Active</p>
                            <button class="btn btn-success col-5">Update</button>
                        </div>
                    </div>
                </div>
                <?php
            }
        }else{
            ?>
            <div class="col-12 text-center">
                <h1 class=" display-1">N/A</h1>
            </div>
            <?php
        }
    }else {
        header("location:index.php");
    }
?>