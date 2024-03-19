<?php
    include("header.php");
    if (isset($_SESSION["u"])){
        if ( isset($_GET["pId"])){
            include("connection.php");
            $pId = $_GET["pId"];
            $email = $_SESSION["u"]["email"];
            $productRs = Database::search("SELECT * FROM `product` INNER JOIN `brand_has_categorie` ON
            product.brand_has_categorie_id=brand_has_categorie.id INNER JOIN `brand` ON
            brand_has_categorie.brand_brand_id=brand.brand_id INNER JOIN `categorie` ON
            brand_has_categorie.categorie_categorie_id=categorie.categorie_id INNER JOIN `model_has_brand` ON
            product.model_has_brand_id=model_has_brand.id INNER JOIN `model`ON
            model_has_brand.model_model_id=model.model_id INNER JOIN `condition` ON
            product.condition_condition_id=condition.condition_id INNER JOIN `model_has_color` ON
            product.model_has_color_id=model_has_color.id INNER JOIN `color` ON
            model_has_color.color_color_id=color.color_id INNER JOIN `status` ON
            product.status_status_id=status.status_id WHERE `product_id`='".$pId."'");
            $productData = $productRs -> fetch_assoc();
            $addressRs = Database::search("SELECT * FROM `user_has_address` INNER JOIN `city` ON
            user_has_address.city_city_id=city.city_id WHERE `user_email`='".$email."'");
            $addressData = $addressRs -> fetch_assoc();

            ?>
            <!DOCTYPE html>
                <html lang="en">

                <head>
                    <meta charset="UTF-8" />
                    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
                    <link rel="stylesheet" href="bootstrap.css" />
                    <title>Update Product | Tea or Tools</title>
                </head>

                <body onload="active(3);">

                    <div class="container-fluid">
                        <div class=" text-center sticky-top d-none" id="spin">
                            <div class="spinner-border position-absolute text-primary" style="width: 8rem; height: 8rem;" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 text-center">
                                <h1 class=" text-info">Update Product</h1>
                            </div>
                        </div>
                        <div class="row ">
                            <div class="col-12">
                                <h3> Product Images</h3>
                            </div>
                            <div class="col-12">
                                <div class="row ">
                                    <img src="img/empty.svg" class=" col-4  col-md-3  ms-md-5 mb-1  border-primary img-fluid rounded-start img-thumbnail" id="i0" />
                                    <img src="img/empty.svg" class=" col-4  col-md-3 offset-md-1 mb-1   border-primary img-fluid rounded-start img-thumbnail" id="i1" />
                                    <img src="img/empty.svg" class=" col-4 col-md-3 offset-md-1  mb-1  border-primary img-fluid rounded-start img-thumbnail" id="i2" />
                                </div>
                                <div class="row mt-1">
                                    <div class="col-10 offset-1">
                                        <label for="addImg" class=" btn btn-success form-control disabled" onclick="addproductImg();" >add Images</label>
                                        <input type="file" id="addImg" multiple class=" d-none" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-12 col-md-4">
                                        <label for="categorie">Categorie</label>

                                        <select id="categorie" class=" form-select "  disabled>
                                            <option value="0"><?php echo($productData["categorie_name"]);?></option>
                                        </select>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <label for="brand">Brand</label>
                                        <select id="brand" class=" form-select " disabled>
                                            <option value="0"><?php echo($productData["brand_name"]);?></option>
                                        </select>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <label for="model">Model</label>
                                        <select id="model" class=" form-select" disabled>
                                            <option value="0"><?php echo($productData["model_name"]);?></option>
                                        </select>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <label for="color">Colour</label>
                                        <select id="color" class=" form-select" disabled>
                                            <option value="0"><?php echo($productData["color_name"]);?></option>
                                        </select>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <label for="condition">Condition</label>
                                        <select id="condition" class=" form-select" disabled>
                                            <option value="0"><?php echo($productData["condition_name"]);?></option>
                                        </select>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <label for="condition">Status</label>
                                        <select id="condition" class=" form-select">
                                            <?php
                                                $statusRs = Database::search("SELECT * FROM `status`");
                                                for ($i=0; $i < $statusRs -> num_rows; $i++) { 
                                                    $statusData = $statusRs -> fetch_assoc();
                                                    ?>
                                                    <option value="<?php echo($statusData["status_id"]);?>" <?php
                                                        if ( $productData["status_status_id"] == $statusData["status_id"]) {
                                                            ?> selected <?php
                                                        }else{

                                                        };
                                                    ?>><?php echo($statusData["status_name"]);?></option>
                                                    <?php
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <label for="title">Title</label>
                                        <input type="text" id="title" class=" form-control" value="<?php echo($productData["title"]);?>" disabled/>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <label for="ppi">Price Per Item</label>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text">Rs</span>
                                            <input type="number" class="form-control" id="ppi" aria-label="Amount (to the nearest dollar)" value="<?php echo($productData["price"]);?>.00" >
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label for="qty">Qty</label>
                                        <input type="number" id="qty" class=" form-control" value="<?php echo($productData["qty"]);?>"  />
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label for="diuc">Delivery In <?php echo($addressData["city_name"]);?> </label>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text">Rs</span>
                                            <input type="number" class="form-control" id="diuc" aria-label="Amount (to the nearest dollar)" value="<?php echo($productData["delevery_in_user_city"]);?>.00">
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label for="dofuc">Delivery Out Of <?php echo($addressData["city_name"]);?> </label>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text">Rs</span>
                                            <input type="number" class="form-control" id="dofuc" aria-label="Amount (to the nearest dollar)" value="<?php echo($productData["delevery_outof_usre_city"]);?>.00">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <label for="discription">Product Discription</label>
                                <textarea id="discription" cols="30" rows="10" class=" form-control" disabled><?php echo($productData["discription"]);?></textarea>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <h5>We are Charging 2% for your each item</h5>
                            </div>
                        </div>
                        <div class="row mb-5 mt-2">
                            <button class=" btn btn-primary col-10 offset-1" onclick="updateProduct(<?php echo($pId)?>);">Update Product</button>
                        </div>
                    </div>
                    </div>


                    <!-- Model -->


                    <!-- Address Modal -->


                    <script src="bootstrap.bundle.js"></script>
                    <script src="script.js"></script>
                </body>

                </html>

            <?php
        }else {
            header("location:index.php");
        }
    }else {
        header("location:login.php");
    }
?>