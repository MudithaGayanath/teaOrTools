<?php
    if (isset($_POST["text"])){
        session_start();
        $email = $_SESSION["u"]["email"];
        include("connection.php");
        $title = $_POST["text"];
        if (empty($title)){
            echo("empty");
        }else {
            $rs = Database::search("SELECT * FROM `product` WHERE `user_email`='".$email."' AND `title` LIKE '%".$title."%' ORDER BY `add_date_time` DESC");
        $row = $rs -> num_rows;
        if ( $row > 0) {
            for ($i=0; $i < $row; $i++) { 
                $proData = $rs -> fetch_assoc();
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
        }else {
            ?>
            <div class="col-12 text-center">
                <h1 class=" display-1">N/A</h1>
            </div>
            <?php
        }
        
        }

        
    }else {
        header("location:index.php");
    }
?>