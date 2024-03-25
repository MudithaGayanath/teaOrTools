<?php
    include("header.php");
    if ( isset($_SESSION["u"])){
        include("connection.php");
        $email = $_SESSION["u"]["email"];
        $grandTot = 0;
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0" />
            <link rel="stylesheet" href="bootstrap.css" />
            <title>Cart | Tea or Tools</title>
        </head>
        <body onload="active(5);salesAlert();">
            <div class="container-fluid">
                <div class="row text-center">
                    <h1>Cart</h1>
                </div>
                <div class="row">
                    <?php
                    $addressData = "";
                    
                        $addressRs = Database::search("SELECT * FROM `user_has_address` INNER JOIN `city` ON 
                        user_has_address.city_city_id=city.city_id WHERE  `user_email`='".$email."'");
                        if ( $addressRs -> num_rows > 0 ){
                            $addressData = $addressRs -> fetch_assoc();
                            $line1 = $addressData["line1"];
                            $line2 = $addressData["line2"];
                            
                            ?>
                             <div class="col-12">Delivery Address : <?php echo($line1." , ".$line2);?></div>
                            <?php
                        }else {
                            ?>
                             <div class="col-12">Delivery Address : N/A</div>
                            <?php
                        }
                       
                    ?>
                   
                </div>
            <div class="row">
                <?php
                    $cartRS = Database::search("SELECT * FROM `cart` WHERE `user_email`='".$email."'");
                    $row = $cartRS -> num_rows;
                    $count = 0;
                    if ( $row > 0){
                        
                        for ($i=0; $i < $row; $i++) { 
                            $count = $count + $i;
                                $cartData = $cartRS -> fetch_assoc();
                                $cartId = $cartData["product_product_id"];
                                
                                $proRs = Database::search("SELECT * FROM `product` INNER JOIN `user` ON
                                product.user_email=user.email INNER JOIN `user_has_address` ON
                                user.email=user_has_address.user_email INNER JOIN `city` ON 
                                user_has_address.city_city_id=city.city_id WHERE `product_id`='".$cartId."'");

                                $proData = $proRs -> fetch_assoc();

                                $imgRs = Database::search("SELECT * FROM `product_img` WHERE `product_product_id`='".$cartData["product_product_id"]."'");
                                $imgData = $imgRs -> fetch_assoc();


                                ?>
                                <div class="col-12">
                        
                                    <div class="row border border-primary mt-2">
                                        <div class="col-12 col-md-4">
                                        <img src="<?php echo($imgData["path"]);?>" class=" img-fluid mt-2" style="width: 100%; height: 260px;"  />
                                        </div>
                                        <div class="col-12 col-md-8 ">
                                            <div class="row">
                                                    <h3 class=" text-center"><?php echo($proData["title"]);?></h3>
                                                    

                                                <div class="col-12 col-md-6">
                                                    <label for="seller">Seller</label>
                                                    <input type="text"  id="seller" class=" form-control" value="<?php echo($proData["fname"]." ".$proData["lname"]);?>" readonly/>
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <label for="price">Price</label>
                                                    <div class="input-group mb-3">
                                                            <span class="input-group-text">RS</span>
                                                            <input type="text" id="price" readonly class="form-control" value="<?php echo($proData["price"].".00");?>" aria-label="Amount (to the nearest dollar)">
                                                        </div>
                                                </div>
                                                <div class="col-12 col-md-6">
                                                <label for="qty">QTY</label>
                                                    <input type="number"  id="qty" class=" form-control" value="<?php echo($cartData["qty"]);?>"  readonly/>
                                                </div>
                                                <div class="col-12 col-md-6">
                                                <label for="delivery">Delivery Fee</label>
                                                <?php
                                                        $fee ="";
                                                        if ( $addressRs -> num_rows > 0 ){
                                                            if ( $proData["city_id"] == $addressData["city_id"]){
                                                                $fee = $proData["delevery_in_user_city"];
                                                            }else{
                                                                $fee = $proData["delevery_outof_usre_city"];
                                                            }
                                                        }
                                                        
                                                ?>
                                                    <div class="input-group mb-3">
                                                        <?php
                                                            if ( $addressRs -> num_rows > 0 ) {
                                                                ?>
                                                                <span class="input-group-text">RS</span>
                                                                <input type="text" id="delivery" readonly class="form-control" value="<?php echo($fee.".00");?>" aria-label="Amount (to the nearest dollar)">
                                                                <?php
                                                            }else {
                                                                ?>
                                                                <span class="input-group-text">RS</span>
                                                                <input type="text" id="delivery" readonly class="form-control" value="N/A" aria-label="Amount (to the nearest dollar)">
                                                                <?php
                                                            }
                                                        ?>
                                                            
                                                        </div>
                                                </div>
                                                <div class="col-6 offset-6 text-end mb-2">
                                                <?php
                                                        if ( $addressRs -> num_rows > 0 ) {
                                                            $tot = ($cartData["qty"] * $proData["price"]) + $fee;
                                                        }else {
                                                            $tot = $cartData["qty"] * $proData["price"];
                                                        }
                                                        
                                                        $grandTot = $grandTot + $tot;
                                                    ?>
                                                <label for="tot" class=" h4">Total</label>
                                                        <div class="input-group mb-3">
                                                            <span class="input-group-text">RS</span>
                                                            <input type="text" id="tot" readonly class="form-control" value="<?php echo($tot.".00");?>" aria-label="Amount (to the nearest dollar)">
                                                        </div>
                                                </div>
                                                <div class="col-12 text-center mb-1">
                                                    <button class=" btn btn-warning form-control" onclick="removeFromCart(<?php echo($cartId); ?>);">Remove</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                   
                                </div>
                            <?php
                        }
                        ?>
                        <p class=" m-0  mt-2 display-5">Grand Total</p>
                        <div class="row border border-info mt-2 justify-content-center">
                            
                            <div class="col-6">
                                <label for="count">Items</label>
                                <input type="number" value="<?php echo($i);?>" id="count" class=" form-control" readonly/>
                            </div>
                            <div class="col-6">
                                <label for="gtot">Grand Total</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text">RS</span>
                                        <input type="text" id="gtot" readonly class="form-control" value="<?php echo($grandTot.".00");?>" aria-label="Amount (to the nearest dollar)">
                                    </div>
                            </div>
                            <button type="button" class=" btn btn-danger col-6 mt-2 mb-2">Buy All</button>
                        </div>
                        <?php
                    }else{
                        ?>
                        <div class="col-md-8 offset-md-2">
                            <div class="card">
                                <div class="card-body text-center">
                                <h2>Your Cart is Empty</h2>
                                <p>Looks like you haven't added any items to your cart yet.</p>
                                <a href="index.php" class="btn btn-primary">Browse Products</a>
                                </div>
                            </div>
                        </div>
                        <?php
                    }

                    
                ?>
                    
                </div>
                 <!-- grand total -->
                 
            </div>

        <script src="script.js"></script>
        </body>
        </html>
        <?php
    }else {
        header("location:login.php");
    }
?>