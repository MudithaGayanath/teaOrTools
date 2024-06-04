<?php
    session_start();
    if (isset($_SESSION["a"])){
        if ( isset($_GET["pId"])){
            include("connection.php");
            
            $pId = $_GET["pId"];
            $rs = Database::search("SELECT * FROM `product` WHERE `product_id`='".$pId."'");
            if ( $rs -> num_rows == 1){
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
                $email = $productData["user_email"];
                $status = $productData["status_status_id"];
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
                        <title>Product Details | Tea or Tools</title>
                    </head>
    
                    <body onload="active(3);">
                    <nav class="navbar bg-body-tertiary navbar-expand-md  sticky-top">
      <div class="container-fluid">
        <a class="navbar-brand" href="adminPanale.php">Tea or Tools </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
          <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Tea or Tools</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
          </div>
          <div class="offcanvas-body">
            <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
              <li class="nav-item">
                <a class="nav-link " aria-current="page" href="adminPanale.php">Dashboard</a>
              </li>
              <li class="nav-item">
                <a class="nav-link " href="manageUser.php">Manger Users</a>
              </li>
              <li class="nav-item">
                <a class="nav-link active" href="manageProducts.php">Manger Products</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">History</a>
              </li>
              <li class="nav-item">
                <a class="nav-link text-danger" href="#" onclick="adminLogout();">LogOut</a>
              </li>

            </ul>

          </div>
        </div>
      </div>
    </nav>
                        <div class="container-fluid">
                            <div class=" text-center sticky-top d-none" id="spin">
                                <div class="spinner-border position-absolute text-primary" style="width: 8rem; height: 8rem;" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 text-center">
                                    <h1 class=" ">Product Details</h1>
                                </div>
                            </div>
                            <div class="row ">
                                <div class="col-12">
                                    <h3> Product Images</h3>
                                </div>
                                <div class="col-12">
                                    <div class="row justify-content-center">
                                            <?php
                                                $imgRS = Database::search("SELECT * FROM `product_img` WHERE `product_product_id`='".$pId."'");
                                                for ($i=0; $i < $imgRS -> num_rows; $i++) { 
                                                    $imgData = $imgRS -> fetch_assoc();
                                                    ?>
                                                     <img src="<?php echo($imgData["path"]);?>" style="width: 300px; height: 200px;" class=" border border-danger p-0 m-2 img-fluid " />
                                                    <?php
                                                }
                                            ?>
                                       
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
                                            <select id="status" class=" form-select" disabled>
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
                                            <label for="price">Price Per Item</label>
                                            <div class="input-group mb-3">
                                                <span class="input-group-text">Rs</span>
                                                <input type="number" disabled class="form-control" id="price" aria-label="Amount (to the nearest dollar)" value="<?php echo($productData["price"]);?>" >
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label for="qty">Qty</label>
                                            <input type="number" id="qty" disabled class=" form-control" value="<?php echo($productData["qty"]);?>"  />
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label for="diuc">Delivery In <?php echo($addressData["city_name"]);?> </label>
                                            <div class="input-group mb-3">
                                                <span class="input-group-text">Rs</span>
                                                <input type="number" disabled class="form-control" id="diuc" aria-label="Amount (to the nearest dollar)" value="<?php echo($productData["delevery_in_user_city"]);?>">
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label for="dofuc">Delivery Out Of <?php echo($addressData["city_name"]);?> </label>
                                            <div class="input-group mb-3">
                                                <span class="input-group-text">Rs</span>
                                                <input type="number" disabled class="form-control" id="dofuc" aria-label="Amount (to the nearest dollar)" value="<?php echo($productData["delevery_outof_usre_city"]);?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <label for="discription">Product Discription</label>
                                    <textarea id="discription" disabled cols="30" rows="10" class=" form-control" disabled><?php echo($productData["discription"]);?></textarea>
                                </div>
                            </div>
                            <?php
                if ($status == "1") {
                ?>
                  <button class=" btn btn-primary col-10 offset-1 mt-3 mb-3" onclick="changeProductStatusByAdmin(<?php echo ($pId); ?>);">Active</button>

                <?php
                } else if ($status == "2") {
                ?>
                  <button class=" btn btn-danger col-10 offset-1 mt-3 mb-3" onclick="changeProductStatusByAdmin(<?php echo ($pId); ?>);">Inactive</button>

                <?php
                }
                ?>
                            
                            
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
            header("location:index.php");
        }
    }else {
        header("location:login.php");
    }
?>