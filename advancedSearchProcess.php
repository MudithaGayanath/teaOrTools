<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include("connection.php");
    session_start();
    $text = $_POST["text"];
    $categorie = $_POST["categorie"];
    $brand = $_POST["brand"];
    $model = $_POST["model"];
    $color = $_POST["color"];
    $condition = $_POST["condition"];

    $query = "SELECT * FROM `product` 
    INNER JOIN `condition` ON  product.condition_condition_id=condition.condition_id 
    INNER JOIN brand_has_categorie ON product.brand_has_categorie_id=brand_has_categorie.id
    INNER JOIN model_has_color ON  product.model_has_color_id=model_has_color.id
    INNER JOIN model_has_brand ON product.model_has_brand_id=model_has_brand.id";

    if (!empty($text)) {

        if (!empty($text) && $categorie == 0 && $brand == 0 && $model == 0 && $color == 0 && $condition == 0) {
            $query .= " WHERE `title` LIKE '%" . $text . "%' ";
        } else if (!empty($text) && $categorie != 0 && $brand == 0 && $model == 0 && $color == 0 && $condition == 0) {
            $query .= " WHERE `title` LIKE '%" . $text . "%' AND `categorie_categorie_id`='" . $categorie . "' ";
        } else if (!empty($text) && $categorie != 0 && $brand != 0 && $model == 0 && $color == 0 && $condition == 0) {
            $query .= " WHERE `title` LIKE '%" . $text . "%' AND `categorie_categorie_id`='" . $categorie . "' AND brand_has_categorie.brand_brand_id='" . $brand . "' ";
        } else if (!empty($text) && $categorie != 0 && $brand != 0 && $model != 0 && $color == 0 && $condition == 0) {
            $query .= " WHERE `title` LIKE '%" . $text . "%' AND categorie_categorie_id='" . $categorie . "' AND brand_has_categorie.brand_brand_id='" . $brand . "' AND model_has_brand.model_model_id='" . $model . "'";
        } else if (!empty($text) && $categorie != 0 && $brand != 0 && $model != 0 && $color != 0 && $condition == 0) {
            $query .= " WHERE `title` LIKE '%" . $text . "%' AND categorie_categorie_id='" . $categorie . "' AND brand_has_categorie.brand_brand_id='" . $brand . "' AND model_has_brand.model_model_id='" . $model . "' AND model_has_color.color_color_id='" . $color . "'";
        } else if (!empty($text) && $categorie != 0 && $brand != 0 && $model != 0 && $color != 0 && $condition != 0) {
            $query .= " WHERE `title` LIKE '%" . $text . "%' AND categorie_categorie_id='" . $categorie . "' AND brand_has_categorie.brand_brand_id='" . $brand . "' AND model_has_brand.model_model_id='" . $model . "' AND model_has_color.color_color_id='" . $color . "' AND `condition_condition_id`='" . $condition . "' ";
        } 
        else if (!empty($text) && $condition != 0) {
            $query .= " WHERE `title` LIKE '%" . $text . "%' AND `condition_condition_id`='" . $condition . "' ";
        }
    } else {
        // if ($categorie == 0 || $brand == 0 || $model == 0 || $color == 0 || $condition == 0) {
            if ($categorie != 0 && $brand == 0 && $model == 0 && $color == 0 && $condition == 0) {
                $query .= " WHERE `categorie_categorie_id`='" . $categorie . "'";
            } else if ($categorie != 0 && $brand != 0 && $model == 0 && $color == 0 && $condition == 0) {
                $query .= " WHERE `categorie_categorie_id`='" . $categorie . "' AND brand_has_categorie.brand_brand_id='" . $brand . "' ";
            } else if ($categorie != 0 && $brand != 0 && $model != 0 && $color == 0 && $condition == 0) {
                $query .= " WHERE categorie_categorie_id='" . $categorie . "' AND brand_has_categorie.brand_brand_id='" . $brand . "' AND model_has_brand.model_model_id='" . $model . "'";
            } else if ($categorie != 0 && $brand != 0 && $model != 0 && $color != 0 && $condition == 0) {
                $query .= " WHERE categorie_categorie_id='" . $categorie . "' AND brand_has_categorie.brand_brand_id='" . $brand . "' AND model_has_brand.model_model_id='" . $model . "' AND model_has_color.color_color_id='" . $color . "'";
            } else if ($categorie != 0 && $brand != 0 && $model != 0 && $color != 0 && $condition != 0) {
                $query .= " WHERE categorie_categorie_id='" . $categorie . "' AND brand_has_categorie.brand_brand_id='" . $brand . "' AND model_has_brand.model_model_id='" . $model . "' AND model_has_color.color_color_id='" . $color . "' AND `condition_condition_id`='" . $condition . "' ";
            }
    
        //     if ($categorie != 0 && $condition != 0) {
        //         $query .= " WHERE `categorie_categorie_id`='" . $categorie . "' AND `condition_condition_id`='" . $condition . "'";
        //     } else if ($categorie != 0 && $brand != 0 && $condition != 0) {
        //         $query .= " WHERE `categorie_categorie_id`='" . $categorie . "' AND brand_has_categorie.brand_brand_id='" . $brand . "' AND `condition_condition_id`='" . $condition . "'";
        //     } else if ($categorie != 0 && $brand != 0 && $model != 0 && $condition != 0) {
        //         $query .= " WHERE `categorie_categorie_id`='" . $categorie . "' AND brand_has_categorie.brand_brand_id='" . $brand . "'  AND model_has_brand.model_model_id='" . $model . "' AND `condition_condition_id`='" . $condition . "'";
        //     }
       
    }




    $rs = Database::search($query);
    if ($rs->num_rows > 0) {
        for ($i = 0; $i < $rs->num_rows; $i++) {
            $data = $rs->fetch_assoc();
            $productId = $data["product_id"];
            $imgRs = Database::search("SELECT * FROM `product_img` WHERE `product_product_id`='" . $data["product_id"] . "'");
            $imgData = $imgRs->fetch_assoc();
            $path = $imgData["path"];
            // rs show
?>
            <div class="col-11 offset-1 ps-5 ms-5 mt-2 mb-2 col-sm-6 offset-sm-0 ms-sm-0 col-lg-4 col-xl-3 ps-md-4 pt-0">
                <div class="card" style="width: 18rem;">
                    <img src="<?php echo ($path); ?>" class=" img-fluid" alt="..." style="width: 300px; height: 200px;" />
                    <div class="card-body">
                        <h4><?php echo ($data["title"]); ?></h4>
                        <span class="badge <?php if ($data["condition_id"] == 1) {
                                            ?>text-bg-primary<?php
                                                    } else {
                                                        ?> text-bg-secondary<?php
                                                    } ?> "><?php echo ($data["condition_name"]); ?></span>
                        <p class="mb-0">Rs: <?php echo ($data["price"]); ?>.00</p>
                        <?php
                        if ($data["qty"] > 0) {
                        ?>
                            <p class=" mb-0">In Stock</p>
                            <p class=" mb-0"><?php echo ($data["qty"]); ?> Items Left</p>
                            <button class=" btn btn-danger col-10 offset-1" onclick="goToSingaleProductView(<?php echo ($productId); ?>);">Buy Now</button>
                            <?php
                            if (isset($_SESSION["u"])) {
                                $email2 = $_SESSION["u"]["email"];
                                $cartRs =  Database::search("SELECT * FROM `cart` WHERE `user_email`='" . $email2 . "' AND `product_product_id`='" . $productId . "'");

                                if ($cartRs->num_rows > 0) {
                            ?>
                                    <button class=" btn btn-success mt-1 col-10 offset-1" onclick="removeFromCart(<?php echo ($productId); ?>);">Remove From Cart</button><br>
                                <?php
                                } else {
                                ?>
                                    <button class=" btn btn-success mt-1 col-10 offset-1" onclick="addToCartModal(<?php echo ($productId); ?>);">Add to Cart</button><br>
                                <?php
                                }
                            } else {
                                ?>
                                <button class=" btn btn-success mt-1 col-10 offset-1" onclick="addToCartModal(<?php echo ($productId); ?>);">Add to Cart</button><br>
                            <?php
                            }

                            ?>


                            <?php
                            if (isset($_SESSION["u"])) {
                                $email = $_SESSION["u"]["email"];
                                $wishListRs = Database::search("SELECT * FROM `wish_list` WHERE `product_id`='" . $productId . "' AND `user_email`='" . $email . "'");
                                if ($wishListRs->num_rows > 0) {
                            ?>
                                    <svg id="wish" onclick="wish(<?php echo ($productId); ?>);" xmlns="http://www.w3.org/2000/svg" width="35" height="50" fill="red" class="bi bi-bookmark-heart" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M8 4.41c1.387-1.425 4.854 1.07 0 4.277C3.146 5.48 6.613 2.986 8 4.412z" />
                                        <path d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.777.416L8 13.101l-5.223 2.815A.5.5 0 0 1 2 15.5zm2-1a1 1 0 0 0-1 1v12.566l4.723-2.482a.5.5 0 0 1 .554 0L13 14.566V2a1 1 0 0 0-1-1z" />
                                    </svg>
                                <?php
                                } else {
                                ?>
                                    <svg id="wish" onclick="wish(<?php echo ($productId); ?>);" xmlns="http://www.w3.org/2000/svg" width="35" height="50" fill="currentColor" class="bi bi-bookmark-heart" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M8 4.41c1.387-1.425 4.854 1.07 0 4.277C3.146 5.48 6.613 2.986 8 4.412z" />
                                        <path d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.777.416L8 13.101l-5.223 2.815A.5.5 0 0 1 2 15.5zm2-1a1 1 0 0 0-1 1v12.566l4.723-2.482a.5.5 0 0 1 .554 0L13 14.566V2a1 1 0 0 0-1-1z" />
                                    </svg>
                                <?php
                                }
                            } else {
                                ?>
                                <svg id="wish" onclick="wish(<?php echo ($productId); ?>);" xmlns="http://www.w3.org/2000/svg" width="35" height="50" fill="currentColor" class="bi bi-bookmark-heart" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M8 4.41c1.387-1.425 4.854 1.07 0 4.277C3.146 5.48 6.613 2.986 8 4.412z" />
                                    <path d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.777.416L8 13.101l-5.223 2.815A.5.5 0 0 1 2 15.5zm2-1a1 1 0 0 0-1 1v12.566l4.723-2.482a.5.5 0 0 1 .554 0L13 14.566V2a1 1 0 0 0-1-1z" />
                                </svg>
                            <?php
                            }


                            ?>


                        <?php
                        } else {
                        ?>
                            <p class=" mb-0 text-danger">Out Of Stock</p>
                            <p class=" mb-0"><?php echo ($data["qty"]); ?> Items Left</p>
                            <button class=" btn btn-danger col-10 offset-1 disabled">Buy Now</button>
                            <?php
                            if (isset($_SESSION["u"])) {
                                $email2 = $_SESSION["u"]["email"];
                                $cartRs =  Database::search("SELECT * FROM `cart` WHERE `user_email`='" . $email2 . "' AND `product_product_id`='" . $productId . "'");

                                if ($cartRs->num_rows > 0) {
                            ?>
                                    <button class=" btn btn-success mt-1 col-10 offset-1 disabled" onclick="removeFromCart(<?php echo ($productId); ?>);">Remove From Cart</button><br>
                                <?php
                                } else {
                                ?>
                                    <button class=" btn btn-success mt-1 col-10 offset-1 disabled" onclick="addToCartModal(<?php echo ($productId); ?>);">Add to Cart</button><br>
                                <?php
                                }
                            } else {
                                ?>
                                <button class=" btn btn-success mt-1 col-10 offset-1 disabled" onclick="addToCartModal(<?php echo ($productId); ?>);">Add to Cart</button><br>
                            <?php
                            }
                            ?>
                            <?php
                            if (isset($_SESSION["u"])) {
                                $email = $_SESSION["u"]["email"];
                                $wishListRs = Database::search("SELECT * FROM `wish_list` WHERE `product_id`='" . $productId . "' AND `user_email`='" . $email . "'");
                                if ($wishListRs->num_rows > 0) {
                            ?>
                                    <svg id="wish" onclick="wish(<?php echo ($productId); ?>);" xmlns="http://www.w3.org/2000/svg" width="35" height="50" fill="red" class="bi bi-bookmark-heart" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M8 4.41c1.387-1.425 4.854 1.07 0 4.277C3.146 5.48 6.613 2.986 8 4.412z" />
                                        <path d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.777.416L8 13.101l-5.223 2.815A.5.5 0 0 1 2 15.5zm2-1a1 1 0 0 0-1 1v12.566l4.723-2.482a.5.5 0 0 1 .554 0L13 14.566V2a1 1 0 0 0-1-1z" />
                                    </svg>
                                <?php
                                } else {
                                ?>
                                    <svg id="wish" onclick="wish(<?php echo ($productId); ?>);" xmlns="http://www.w3.org/2000/svg" width="35" height="50" fill="currentColor" class="bi bi-bookmark-heart" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M8 4.41c1.387-1.425 4.854 1.07 0 4.277C3.146 5.48 6.613 2.986 8 4.412z" />
                                        <path d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.777.416L8 13.101l-5.223 2.815A.5.5 0 0 1 2 15.5zm2-1a1 1 0 0 0-1 1v12.566l4.723-2.482a.5.5 0 0 1 .554 0L13 14.566V2a1 1 0 0 0-1-1z" />
                                    </svg>
                                <?php
                                }
                            } else {
                                ?>
                                <svg id="wish" onclick="wish(<?php echo ($productId); ?>);" xmlns="http://www.w3.org/2000/svg" width="35" height="50" fill="currentColor" class="bi bi-bookmark-heart" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M8 4.41c1.387-1.425 4.854 1.07 0 4.277C3.146 5.48 6.613 2.986 8 4.412z" />
                                    <path d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.777.416L8 13.101l-5.223 2.815A.5.5 0 0 1 2 15.5zm2-1a1 1 0 0 0-1 1v12.566l4.723-2.482a.5.5 0 0 1 .554 0L13 14.566V2a1 1 0 0 0-1-1z" />
                                </svg>
                            <?php
                            }


                            ?>
                        <?php
                        }
                        ?>

                        <!--  -->

                        <!--  -->
                    </div>
                </div>
            </div>
        <?php
        }
    } else {
        ?>
        <div class="col-12">
            <div class=" display-1">N/A</div>
        </div>
<?php
    }
} else {
    header("Location:index.php");
}
?>