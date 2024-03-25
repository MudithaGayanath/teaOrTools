<?php
    include("header.php");
    include("connection.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="bootstrap.css" />
    <title>Home | Tea or Tools</title>
</head>
<body onload="active(1);salesAlert();">
    <?php
        
        // include("connection.php");
        $fName = "User";
        if ( isset($_SESSION["u"])) {
            $fName = $_SESSION["u"]["fname"];
        }
        
    ?>
    <div class="container-fluid">
        <!-- head start-->
        <div class="row mt-2">
           <div class="col-12 col-md-2">Hello, <?php echo($fName);?></div>
           <div class="col-12 col-md-8">
                <div class="input-group mb-3">
                    <select  id="cat" class="btn btn-close-white border border-secondary" onclick="changeMenu()">
                        <option value="0">All</option>
                        <?php
                            $catRs = Database::search("SELECT * FROM `categorie`");
                            for ($i=0; $i < $catRs -> num_rows; $i++) { 
                                $catData = $catRs -> fetch_assoc();
                                ?>
                                <option value="<?php echo($catData["categorie_id"]);?>"><?php echo($catData["categorie_name"]);?></option>
                                <?php
                            }
                        ?>
                    </select>
                    <input type="text" placeholder="Search in Tea or Tools" class="form-control" id="searchText" aria-label="Text input with dropdown button"/>
                    <button class="btn btn-primary" type="button" id="button-addon2" onclick="searchText();">Search</button>
                </div>
            </div>
        </div>
            
        
    </div>
        <!-- head end -->

        

        <!-- products start -->
        <div class="row mt-2 justify-content-center text-center d-none " id="searchRs">
        
        </div>
        
        <div class="row mt-2 justify-content-center text-center " id="main">
        
            <h1 class="col-12 display-1 d-flex " >All Products</h1>
        
             
            <?php 
                $productRs = Database::search("SELECT * FROM `product` INNER JOIN `condition` ON 
                product.condition_condition_id=condition.condition_id WHERE `status_status_id`='1' ORDER BY `add_date_time` DESC");
                for ($i=0; $i < $productRs -> num_rows; $i++) { 
                    $productData = $productRs -> fetch_assoc();
                    $productId = $productData["product_id"];
                    $imgRs = Database::search("SELECT * FROM `product_img` WHERE `product_product_id`='".$productId."'");
                    $imgData = $imgRs -> fetch_assoc();
                    $path = $imgData["path"];
                    ?>
                    <div class="col-11 offset-1 ps-5 ms-5 mt-2 mb-2 col-sm-6 offset-sm-0 ms-sm-0  col-lg-4 col-xl-3 ps-md-5 pt-0" >
                        <div class="card" style="width: 18rem;">
                            <img src="<?php echo($path);?>" class=" img-fluid" alt="..." style="width: 300px; height: 200px;" />
                            <div class="card-body">
                                <h4><?php echo($productData["title"]);?></h4>
                                <span class="badge <?php if ($productData["condition_id"] == 1 ){
                                    ?>text-bg-primary<?php
                                    }else{
                                    ?> text-bg-secondary<?php
                                    }?> "><?php echo($productData["condition_name"]);?></span>
                                    
                                <p class=" mb-0">Rs: <?php echo( (float) $productData["price"])?>.00</p>   
                                <?php
                                    if ($productData["qty"] > 0 ){
                                        ?>
                                        <p class=" mb-0">In Stock</p>
                                        <p class=" mb-0"><?php echo($productData["qty"]);?> Items Left</p>
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
            ?>
            
        </div>
        <!-- products end -->
        <!-- add to cart -->
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
    </div>
    <?php
    include("footer.php");
    ?>
    <script src="bootstrap.bundle.js"></script>
</body>
</html>