<?php
    include("header.php");
    if ( isset($_SESSION["u"])){
        $email = $_SESSION["u"]["email"];
        include("connection.php");
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="bootstrap.css">
            <link rel="stylesheet" href="style.css">
            <title>Wish List | Tea or Tools</title>
        </head>
        <body onload="active(6);salesAlert();">
            <div class="container-fluid">
                <!-- l1 -->
            <div class="loader justify-content-center " id="loader">
                <div class=" text-center  sp ">
                    <div class="spinner-border position-absolute text-primary" style="width: 5rem; height: 5rem;" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
            <!-- l1 -->
            <!-- l2 -->
            <div class="loader d-none " id="loader-2">
                <div class=" text-center  sp ">
                    <div class="spinner-border position-absolute text-primary" style="width: 5rem; height: 5rem;" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
            <!-- l2 -->
            <div class="row text-center">
                    <h1>Wish List</h1>
                </div>
                <div class="row justify-content-center  text-center">
                    <?php
                        $email = $_SESSION["u"]["email"];
                        $wishListRs = Database::search("SELECT * FROM `wish_list` WHERE  `user_email`='".$email."'");
                        if ( $wishListRs -> num_rows > 0 ){
                            for ($i=0; $i < $wishListRs -> num_rows; $i++) { 
                                $wishData = $wishListRs -> fetch_assoc();
                                $productRs = Database::search("SELECT * FROM `product` INNER JOIN `condition` ON 
                                product.condition_condition_id=condition.condition_id WHERE `product_id`='".$wishData["product_id"]."'");
                                $productData = $productRs -> fetch_assoc();
    
                                $productImgRs = Database::search("SELECT * FROM `product_img` WHERE `product_product_id`='".$wishData["product_id"]."'");
                                $productImgData = $productImgRs -> fetch_assoc();
                                ?>
                                <div class="col-11 offset-1 offset-sm-0  mb-2 col-sm-6 col-lg-4 col-xl-3 ms-5  ms-sm-0">
                                <div class="card" style="width: 18rem;">
                                <img src="<?php echo($productImgData["path"]);?>" class="img-fluid" alt="..." style="width: 300px; height: 200px;"/>
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo($productData["title"]);?></h5>
                                    <span class="badge <?php if ($productData["condition_id"] == 1 ){
                                        ?>text-bg-primary<?php
                                        }else{
                                        ?> text-bg-secondary<?php
                                        }?> "><?php echo($productData["condition_name"]);?></span>
                                        <p class=" mb-0">Rs: <?php echo( (float) $productData["price"])?>.00</p>  
                                        <?php
                                        $productId = $productData["product_id"];
                                        if ($productData["qty"] > 0 ){
                                            ?>
                                            <p class=" mb-0">In Stock</p>
                                            <p class=" mb-0"><?php echo($productData["qty"]);?> Items Left</p>
                                            <button class=" btn btn-danger col-10 offset-1" onclick="goToSingaleProductView(<?php echo($productId); ?>);">Buy Now</button>
                                            <?php
                                                if ( isset($_SESSION["u"])){
                                                    $cartRs =  Database::search("SELECT * FROM `cart` WHERE `user_email`='".$email."' AND `product_product_id`='".$productId."'");
                                                    
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
                                        }else{
                                            ?>
                                            <p class=" mb-0 text-danger">Out Of Stock</p>
                                            <p class=" mb-0"><?php echo($productData["qty"]);?> Items Left</p>
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
                                        }
                                    ?>
    
                                    <svg id="wish" onclick="wish(<?php echo($productId);?>);" xmlns="http://www.w3.org/2000/svg" width="35" height="50" fill="red" class="bi bi-bookmark-heart" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M8 4.41c1.387-1.425 4.854 1.07 0 4.277C3.146 5.48 6.613 2.986 8 4.412z"/>
                                    <path d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.777.416L8 13.101l-5.223 2.815A.5.5 0 0 1 2 15.5zm2-1a1 1 0 0 0-1 1v12.566l4.723-2.482a.5.5 0 0 1 .554 0L13 14.566V2a1 1 0 0 0-1-1z"/>
                                    </svg>
                                </div>
                                </div>
                                </div>
                                <?php
                            }
                        }else{?>
                        <div class=" col-12 col-md-6  offset-md-2">
                            <div class="card">
                                <div class="card-body text-center">
                                <h2>Your Wish List is Empty</h2>
                                <p>Looks like you haven't added any items to your Wish List yet.</p>
                                <a href="index.php" class="btn btn-primary">Browse Products</a>
                                </div>
                            </div>
                        </div>
                        <?php
                        }
                        
                    ?>
                    
                </div>
            </div>
            <!-- mod -->
            <div class="modal" tabindex="-1" id="cartModal">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add To Cart </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <label for="cartQty">Add QTY</label>
                            <input type="number"  id="cartQty" class=" form-control" value="1" />
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="addToCartFormIndex();">Add</button>
                </div>
                </div>
            </div>
            </div>
            <?php
    include("footer.php");
    ?>
    <script src="jqery.min.js"></script>
            <script>
                $(document).ready(function() {
                    $("#loader").animate({
                        opacity: "0%"
                    }, 1000, function() {
                        $("#loader").hide();
                    })
                });
            </script>
        </body>
        </html>
        <?php
    }else {
        header("location:login.php");
    }
?>