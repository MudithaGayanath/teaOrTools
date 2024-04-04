<?php
include("header.php");
    
        if( isset($_GET["pid"])){
            $pid = $_GET["pid"];
            
            include("connection.php");

            $productRs = Database::search("SELECT * FROM `product` INNER JOIN `brand_has_categorie` ON 
            product.brand_has_categorie_id=brand_has_categorie.id INNER JOIN `categorie` ON
            brand_has_categorie.categorie_categorie_id=categorie.categorie_id INNER JOIN `brand` ON
            brand_has_categorie.brand_brand_id=brand.brand_id INNER JOIN `model_has_brand` ON
            product.model_has_brand_id=model_has_brand.id INNER JOIN `model` ON
            model_has_brand.model_model_id=model.model_id INNER JOIN `model_has_color` ON
            product.model_has_color_id=model_has_color.id WHERE `product_id`='".$pid."'");

            $productData = $productRs->fetch_assoc();
            $productImgRs = Database::search("SELECT * FROM `product_img` WHERE `product_product_id`='" . $pid . "'");
            $productOwnerRs = Database::search("SELECT * FROM `user` INNER JOIN `user_has_address` ON
            user.email=user_has_address.user_email INNER JOIN  `city` ON 
            user_has_address.city_city_id=city.city_id WHERE `email`='" . $productData["user_email"] . "'");
            $productOwnerData = $productOwnerRs -> fetch_assoc();

            


            

            ?>
                <!DOCTYPE html>
                <html lang="en">
                <head>
                    <meta charset="UTF-8" />
                    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
                    <link rel="stylesheet" href="bootstrap.css" />
                    <script src="jqery.min.js"></script>
                    <title><?php echo($productData["title"]);?> | Tea or Tools</title>
                </head>
                <body onload="singalProudctTotal(<?php echo ($productData['price']); ?>,<?php echo($productData['qty'])?>);">
                    <div class="container-fluid">
                        
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div id="carouselExampleIndicators" class="carousel slide">
                                <div class="carousel-indicators">
                                    <?php 
                                    for ($i=0; $i < $productImgRs -> num_rows; $i++) { 
                                        ?>
                                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="<?php echo($i);?>" class="<?php
                                            if ( $i == 0 ){
                                                ?>
                                                active
                                                <?php
                                            }
                                        ?>" aria-current="true" aria-label="Slide 1"></button>
                                        <?php
                                    }
                                    ?>
                                    
                                    
                                </div>
                                <div class="carousel-inner">
                                <?php 
                                    for ($i=0; $i < $productImgRs -> num_rows; $i++) { 
                                        $productImgData = $productImgRs -> fetch_assoc();
                                        ?>
                                        <div class="carousel-item <?php
                                            if ( $i == 0 ){
                                                ?>
                                                active
                                                <?php
                                            }
                                        ?>">
                                
                                        <img src="<?php echo($productImgData["path"])?>" class=" w-100" alt="..." style="height: 500px;" />
                                        </div>
                                        <?php
                                            
                                    }
                                ?>
                                    
                                    
                                </div>
                                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                                </div>
                                <h5>Title : <?php echo ($productData["title"]); ?></h5>
                                <h5>Product Price : Rs.<?php echo ($productData["price"]); ?>.00</h5>
                                <h5>Available Items : <?php echo ($productData["qty"]); ?></h5>
                            </div>
                            
                                <!-- <div class="col-12 d-flex">
                                    <h5>Seller </h5>
                                    <h5 class=" text-info text-center ms-2"><?php echo ($userData["fname"] . " " . $userData["lname"]); ?></h5>
                                </div> -->
                            <div class="col-12 col-md-6">
                                <div class="row">
                                    <div class="col-12 ">
                                    <h5>Discription</h5>
                                    <textarea name="" id="" cols="30" rows="5" class=" form-control" readonly><?php echo ($productData["discription"]); ?></textarea>
                                    </div>
                                    <?php

                                        
                                    ?> 
                                    <?php
                                        $line1 = "";
                                        $line2 = "";
                                        $deliveryFee = 0;
                                            if ( isset($_SESSION["u"])) {
                                                $email = $_SESSION["u"]["email"];
                                                $costomerAddressRs = Database::search("SELECT * FROM `user_has_address` INNER JOIN  `city` ON 
                                                user_has_address.city_city_id=city.city_id WHERE `user_email`='" . $email. "'");
                                                if ( $costomerAddressRs -> num_rows > 0) {
                                                    $costomerAddressData = $costomerAddressRs -> fetch_assoc();
                                                    $line1 = $costomerAddressData["line1"];
                                                    $line2 = $costomerAddressData["line2"];
                                                    if ( $productOwnerData["city_id"] == $costomerAddressData["city_id"] ){
                                                        $deliveryFee = $productData["delevery_in_user_city"];
                                                    }else {
                                                        $deliveryFee = $productData["delevery_outof_usre_city"];
                                                    }
                                                    ?>
                                                    <div class="col-12">
                                                        <h5>Delivery Address : <?php echo($line1." , ".$line2);?></h5>
                                                    </div>
                                                    <?php
                                                }else {
                                                    ?>
                                                    <div class="col-12">
                                                    <h5>Delivery Address : N/A</h5>
                                                    </div>
                                                    <?php
                                                }
                                                

                                                ?>
                                                 
                                                <?php

                                               
                                            }else{
                                                ?>
                                                <div class="col-12">
                                                    <h5>Delivery Address : N/A</h5>
                                                </div>
                                                <?php
                                            }
                                        ?>
                                   
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-4 col-md-5 col-lg-4 col-xl-3">
                                                <label for="deliveryFee"><h5>Delivery Fee </h5></label>
                                            </div>
                                            <div class="col-8 col-md-7 col-lg-8 col-xl-9 mb-md-0">
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text">RS</span>
                                                    <input type="text" id="deliveryFee" readonly class="form-control" value="<?php echo($deliveryFee);?>.00" aria-label="Amount (to the nearest dollar)">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 mt-md-0 border border-primary">
                                            <h3 class=" text-center">Buy Here</h3>
                                        <div class="row">
                                            <div class="col-12">
                                                <label for="qty">QTY</label>
                                                <input type="number" id="qty" class=" form-control" value="1" onkeyup="singalProudctTotal(<?php echo ($productData['price']); ?>,<?php echo($productData['qty'])?>);"/>
                                            </div>
                                            <div class="col-12">
                                                <label for="tot">Totla</label>
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text">RS</span>
                                                    <input type="text" id="tot" readonly class="form-control" aria-label="Amount (to the nearest dollar)">
                                                </div>
                                            </div>
                                            <?php
                                                if ( !empty($email)) {
                                                    $cartRs =  Database::search("SELECT * FROM `cart` WHERE `user_email`='".$email."' AND `product_product_id`='".$productData["product_id"]."'");
                                                    if ( $cartRs -> num_rows > 0 ){
                                                        ?>
                                                        <button class=" btn btn-success col-5 offset-1 mt-2 mb-3 mb-md-2" onclick="removeFromCart(<?php echo($productData['product_id']); ?>);">Remove From Cart</button><br>
                                                        <?php
                                                    }else {
                                                        ?>
                                                        <button class=" btn btn-success col-5 offset-1 mt-2 mb-3 mb-md-2" onclick="addToCart(<?php echo($productData['product_id']); ?>);">Add to Cart</button><br>
                                                        <?php
                                                    }
                                                    ?>
                                                    
                                                    <?php
                                                }else{
                                                    ?>
                                                    <button class=" ms-4 btn btn-success col-5 mt-2 mb-3 mb-md-2" onclick="addToCart(<?php echo($productData['product_id']); ?>);">Add to Cart</button>
                                                    <?php
                                                }
                                            ?>
                                            
                                            <button class="  btn btn-danger col-5 offset-1 mt-2 mb-3 mb-md-2" type="submit" id="payhere-payment" onclick="buyNow(<?php echo($productData['product_id']); ?>);">Buy Now</button>
                                        </div>    
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row border border-primary justify-content-center text-center">
                            
                            <h1>Related Items</h1>
                            <?php
                                $relatedItemsRs = Database::search("SELECT * FROM `product` INNER JOIN `model_has_brand` ON
                                product.model_has_brand_id=model_has_brand.id INNER JOIN `brand` ON
                                model_has_brand.brand_brand_id=brand.brand_id INNER JOIN `condition` ON
                                product.condition_condition_id=condition.condition_id WHERE `brand_brand_id`='".$productData["brand_id"]."'AND `brand_id` != '8' AND `product_id`!='".$productData["product_id"]."'");

                                
                                if ($relatedItemsRs -> num_rows > 0 ){
                                    for ($i=0; $i < $relatedItemsRs -> num_rows; $i++) { 
                                        $relatedItemsData = $relatedItemsRs -> fetch_assoc();
                                        $productId = $relatedItemsData["product_id"];
                                        $imgRs = Database::search("SELECT * FROM `product_img` WHERE `product_product_id`='".$productId."'");
                                        $imgData = $imgRs -> fetch_assoc();
                                        $path = $imgData["path"];
                                        ?>
    
                                        <div class="col-11 offset-1 offset-sm-0  mb-2 col-sm-6 col-lg-4 col-xl-3 ms-5  ms-sm-0 ">
                                                <div class="card" style="width: 18rem;">
                                                    <img src="<?php echo($path);?>" class=" img-fluid" alt="..." style="width: 300px; height: 200px;" />
                                                    <div class="card-body">
                                                        <h4><?php echo($relatedItemsData["title"] );?></h4>
                                                        <span class="badge <?php if ($relatedItemsData["condition_id"] == 1 ){
                                                            ?>text-bg-primary<?php
                                                            }else{
                                                            ?> text-bg-secondary<?php
                                                            }?> "><?php echo($relatedItemsData["condition_name"]);?></span>
                                                        <p class=" mb-0">Rs: <?php echo($relatedItemsData["price"]);?>.00</p>   
                                                        <?php
                                                            if ($relatedItemsData["qty"] > 0 ){
                                                                ?>
                                                                <p class=" mb-0">In Stock</p>
                                                                <p class=" mb-0"><?php echo($relatedItemsData["qty"]);?> Items Left</p>
                                                                <button class=" btn btn-danger col-10 offset-1" onclick="goToSingaleProductView(<?php echo($productId); ?>);">Buy Now</button>
                                                                <?php
                                                                    if ( isset($_SESSION["u"])){
                                                                        $email2 = $_SESSION["u"]["email"];
                                                                        $cartRs =  Database::search("SELECT * FROM `cart` WHERE `user_email`='".$email2."' AND `product_product_id`='".$productId."'");
                                                                        
                                                                        if ( $cartRs -> num_rows > 0 ){
                                                                            ?>
                                                                            <button class=" btn btn-success mt-1 col-10 offset-1" onclick="removeFromCart(<?php echo($productId); ?>);">Remove From Cart</button><br>
                                                                            <?php
                                                                        }else {
                                                                            ?>
                                                                            <button class=" btn btn-success mt-1 col-10 offset-1" onclick="addToCartModal(<?php echo($productId); ?>);">Add to Cart</button><br>
                                                                            <?php
                                                                        }
                                                                    }else {
                                                                        ?>
                                                                        <button class=" btn btn-success mt-1 col-10 offset-1" onclick="addToCartModal(<?php echo($productId); ?>);">Add to Cart</button><br>
                                                                        <?php
                                                                    }
                                                                    
                                                                ?>
                                                                
                                                                
                                                                <?php
                                                                    if ( isset($_SESSION["u"])){
                                                                        $email = $_SESSION["u"]["email"];
                                                                        $wishListRs = Database::search("SELECT * FROM `wish_list` WHERE `product_id`='".$productId."' AND `user_email`='".$email."'");
                                                                        if ( $wishListRs -> num_rows > 0 ){
                                                                            ?>
                                                                            <svg id="wish" onclick="wish(<?php echo($productId);?>);" xmlns="http://www.w3.org/2000/svg" width="35" height="50" fill="red" class="bi bi-bookmark-heart" viewBox="0 0 16 16">
                                                                            <path fill-rule="evenodd" d="M8 4.41c1.387-1.425 4.854 1.07 0 4.277C3.146 5.48 6.613 2.986 8 4.412z"/>
                                                                            <path d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.777.416L8 13.101l-5.223 2.815A.5.5 0 0 1 2 15.5zm2-1a1 1 0 0 0-1 1v12.566l4.723-2.482a.5.5 0 0 1 .554 0L13 14.566V2a1 1 0 0 0-1-1z"/>
                                                                            </svg>
                                                                            <?php
                                                                        }else{
                                                                            ?>
                                                                            <svg id="wish" onclick="wish(<?php echo($productId);?>);" xmlns="http://www.w3.org/2000/svg" width="35" height="50" fill="currentColor" class="bi bi-bookmark-heart" viewBox="0 0 16 16">
                                                                            <path fill-rule="evenodd" d="M8 4.41c1.387-1.425 4.854 1.07 0 4.277C3.146 5.48 6.613 2.986 8 4.412z"/>
                                                                            <path d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.777.416L8 13.101l-5.223 2.815A.5.5 0 0 1 2 15.5zm2-1a1 1 0 0 0-1 1v12.566l4.723-2.482a.5.5 0 0 1 .554 0L13 14.566V2a1 1 0 0 0-1-1z"/>
                                                                            </svg>
                                                                            <?php
                                                                        }
                                                                    }else {
                                                                        ?>
                                                                        <svg id="wish" onclick="wish(<?php echo($productId);?>);" xmlns="http://www.w3.org/2000/svg" width="35" height="50" fill="currentColor" class="bi bi-bookmark-heart" viewBox="0 0 16 16">
                                                                        <path fill-rule="evenodd" d="M8 4.41c1.387-1.425 4.854 1.07 0 4.277C3.146 5.48 6.613 2.986 8 4.412z"/>
                                                                        <path d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.777.416L8 13.101l-5.223 2.815A.5.5 0 0 1 2 15.5zm2-1a1 1 0 0 0-1 1v12.566l4.723-2.482a.5.5 0 0 1 .554 0L13 14.566V2a1 1 0 0 0-1-1z"/>
                                                                        </svg>
                                                                        <?php
                                                                    }
                                                                
                                                                
                                                                ?>
    
                                                                
                                                                <?php
                                                            }else{
                                                                ?>
                                                                <p class=" mb-0 text-danger">Out Of Stock</p>
                                                                <p class=" mb-0"><?php echo($relatedItemsData["qty"]);?> Items Left</p>
                                                                <button class=" btn btn-danger col-10 offset-1 disabled">Buy Now</button>
                                                                <?php
                                                                    if ( isset($_SESSION["u"])){
                                                                        $email2 = $_SESSION["u"]["email"];
                                                                        $cartRs =  Database::search("SELECT * FROM `cart` WHERE `user_email`='".$email2."' AND `product_product_id`='".$productId."'");
                                                                        
                                                                        if ( $cartRs -> num_rows > 0 ){
                                                                            ?>
                                                                            <button class=" btn btn-success mt-1 col-10 offset-1 disabled" onclick="removeFromCart(<?php echo($productId); ?>);">Remove From Cart</button><br>
                                                                            <?php
                                                                        }else {
                                                                            ?>
                                                                            <button class=" btn btn-success mt-1 col-10 offset-1 disabled" onclick="addToCartModal(<?php echo($productId); ?>);">Add to Cart</button><br>
                                                                            <?php
                                                                        }
                                                                    }else {
                                                                        ?>
                                                                        <button class=" btn btn-success mt-1 col-10 offset-1 disabled" onclick="addToCartModal(<?php echo($productId); ?>);">Add to Cart</button><br>
                                                                        <?php
                                                                    }
                                                                ?>
                                                                <?php
                                                                    if ( isset($_SESSION["u"])){
                                                                        $email = $_SESSION["u"]["email"];
                                                                        $wishListRs = Database::search("SELECT * FROM `wish_list` WHERE `product_id`='".$productId."' AND `user_email`='".$email."'");
                                                                        if ( $wishListRs -> num_rows > 0 ){
                                                                            ?>
                                                                            <svg id="wish" onclick="wish(<?php echo($productId);?>);" xmlns="http://www.w3.org/2000/svg" width="35" height="50" fill="red" class="bi bi-bookmark-heart" viewBox="0 0 16 16">
                                                                            <path fill-rule="evenodd" d="M8 4.41c1.387-1.425 4.854 1.07 0 4.277C3.146 5.48 6.613 2.986 8 4.412z"/>
                                                                            <path d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.777.416L8 13.101l-5.223 2.815A.5.5 0 0 1 2 15.5zm2-1a1 1 0 0 0-1 1v12.566l4.723-2.482a.5.5 0 0 1 .554 0L13 14.566V2a1 1 0 0 0-1-1z"/>
                                                                            </svg>
                                                                            <?php
                                                                        }else{
                                                                            ?>
                                                                            <svg id="wish" onclick="wish(<?php echo($productId);?>);" xmlns="http://www.w3.org/2000/svg" width="35" height="50" fill="currentColor" class="bi bi-bookmark-heart" viewBox="0 0 16 16">
                                                                            <path fill-rule="evenodd" d="M8 4.41c1.387-1.425 4.854 1.07 0 4.277C3.146 5.48 6.613 2.986 8 4.412z"/>
                                                                            <path d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.777.416L8 13.101l-5.223 2.815A.5.5 0 0 1 2 15.5zm2-1a1 1 0 0 0-1 1v12.566l4.723-2.482a.5.5 0 0 1 .554 0L13 14.566V2a1 1 0 0 0-1-1z"/>
                                                                            </svg>
                                                                            <?php
                                                                        }
                                                                    }else {
                                                                        ?>
                                                                        <svg id="wish" onclick="wish(<?php echo($productId);?>);" xmlns="http://www.w3.org/2000/svg" width="35" height="50" fill="currentColor" class="bi bi-bookmark-heart" viewBox="0 0 16 16">
                                                                        <path fill-rule="evenodd" d="M8 4.41c1.387-1.425 4.854 1.07 0 4.277C3.146 5.48 6.613 2.986 8 4.412z"/>
                                                                        <path d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.777.416L8 13.101l-5.223 2.815A.5.5 0 0 1 2 15.5zm2-1a1 1 0 0 0-1 1v12.566l4.723-2.482a.5.5 0 0 1 .554 0L13 14.566V2a1 1 0 0 0-1-1z"/>
                                                                        </svg>
                                                                        <?php
                                                                    }
                                                                
                                                                
                                                                ?>
                                                                <?php
                                                            }
                                                        ?> 
                                                    </div>
                                                </div>
                                            </div>
                                        <?php
                                    }
                                }else {
                                    ?>
                                    <div class="col-11 offset-1 offset-sm-0  mb-2 col-sm-6 col-lg-4 col-xl-3 ms-5  ms-sm-0 ">
                                        <p class=" display-1">N/A</p>
                                    </div>
                                    <?php
                                }
                                
                            ?>
                            
                        </div>
                        <div class="row">
                            <!-- <h1 class=" border-bottom">Feedbacks</h1> -->
                            <?php
                            
                                $feedRs = Database::search("SELECT * FROM `feedback` WHERE `product_product_id`='".$productData["product_id"]."'");
                                if ( $feedRs -> num_rows > 0 ){
                                    $feedData = $feedRs -> fetch_assoc();
                                    ?>
                                    
                                    <div class="col-11 offset-1 offset-sm-0  mb-2 col-sm-6 col-lg-4 col-xl-3 ms-5  ms-sm-0">
                                    <div class="toast" role="alert" aria-live="assertive" aria-atomic="ture" data-autohide="false" data-delay="0" id="toos">
                                    <div class="toast-header">
                                        <img src="..." class="rounded me-2" alt="...">
                                        <strong class="me-auto">Bootstrap</strong>
                                        <small>11 mins ago</small>
                                        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                                    </div>
                                    <div class="toast-body">
                                        Hello, world! This is a toast message.
                                    </div>
                                    </div>
                                    </div>
                                    <script>

                                        // var toos = document.getElementById("toos");
                                        // var newToos = new bootstrap.Toast(toos);
                                        // newToos.show();
                                        // $('.toast').toast('show');
                                    </script>
                                    <?php

                                }else{
                                    ?>
                                    <!-- <div class="col-12">
                                        <p class=" display-3">No Feedbacks Yet</p>
                                    </div> -->
                                    <?php
                                }
                            ?>
                            
                        </div>
                    </div>
                    <script type="text/javascript" src="https://www.payhere.lk/lib/payhere.js"></script>
                </body>
                </html>
            <?php
            
        }else {
            header("location:index.php");
        }
        
    
?>