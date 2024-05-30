<?php
    include("header.php");
    if ( isset($_SESSION["u"])){
        include("connection.php");
        $emali = $_SESSION["u"]["email"];
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="bootstrap.css" />
            <title>My Products | Tea or Tools</title>
        </head>
        <body onload="active(3);salesAlert();">
            <div class="container-fluid">
                <div class="row">
                    <h1 class=" text-center">My Products</h1>
                </div>
                <div class="row">
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" id="text" placeholder="Search Products" aria-label="Recipient's username" aria-describedby="button-addon2">
                            <button class="btn btn-success" type="button" id="button-addon2" onclick="myProductSearch();">Search</button>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-4">
                        <select class=" form-select" id="stor" onclick="stor();">
                            <option value="1">Newest to oldest</option>
                            <option value="2">Oldest to newest</option>
                            <option value="3">High to low</option>
                            <option value="4">Low to high</option>
                            <option value="5">Brandnew</option>
                            <option value="6">Used</option>
                            <option value="7">Active Only</option>
                            <option value="8">Deactive Only</option>
                        </select>
                    </div>
                    <div class="col-10 col-md-4 offset-1 offset-md-0 mt-2 mt-sm-0">
                    <button class=" btn btn-primary  form-control " onclick="goToAddProduct();">Add Product</button>
                    </div>
                    
                </div>

                <div class="container-fluid">
                    <div class="row border border-primary mt-md-0 mt-3 " id="sortRow">
                        <?php
                            $proRs = Database::search("SELECT * FROM `product` WHERE `user_email`='".$emali."' ORDER BY `add_date_time` DESC");
                            $row = $proRs -> num_rows;
                            if ( $row > 0 ){
                                for ($i=0; $i < $row; $i++) { 
                                    $proData = $proRs -> fetch_assoc();
                                    $proId = $proData["product_id"];
        
                                    $imgRs = Database::search("SELECT * FROM `product_img` WHERE `product_product_id`='".$proId."'");
                                    $imgData = $imgRs -> fetch_assoc();
                                    $imgPath = $imgData["path"];
    
                                    ?>
                                    <div class="col-10 offset-1 ms-5 ms-md-0 mt-3 col-md-6 offset-md-0 col-xl-4 mb-3  " >
                                    <div class="card" style="width: 18rem;">
                                        <img src="<?php echo($imgPath);?>" class=" img-fluid" alt="..."  style="width: 300px; height: 200px;" />
                                        <div class="card-body text-center">
                                            <h4 class="m-0"><?php echo($proData["title"]);?></h4>
                                            <p class=" m-0">Rs.<?php echo($proData["price"]);?>.00</p>
                                            <p class=" m-0">QTY - <?php echo($proData["qty"]);?></p>
                                            <?php
                                                if ( $proData["status_status_id"] == 1 ){
                                                    ?> <p class=" text-info fw-bold m-0">Active</p><?php
                                                }else if ( $proData["status_status_id"] == 2 ) {
                                                    ?> <p class=" text-danger fw-bold m-0">Inactive</p><?php
                                                }
                                            ?>
                                           
                                            <button class="btn btn-success col-5" onclick="goToUpadteProduct(<?php echo($proData['product_id']);?>);">Update</button>
                                        </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                               
                            }else {
                                ?>
                                 <div class="col-12 text-center " >
                                    <h1 class=" display-1">N/A</h1>
                                </div>
                                <?php
                            }
                            
                        ?>
                       
                        
                    </div>
                </div>
                <?php
    include("footer.php");
    ?>
        </body>
        </html>
        <?php

    }else{
        header("location:login.php");
    }

?>