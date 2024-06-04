<?php
    include("header.php");
    include("connection.php");

    if ( isset($_SESSION["u"]) && isset($_GET["inId"])) {
        $invoiceId = $_GET["inId"];

        $invoiceRs = Database::search("SELECT * FROM `invoice` INNER JOIN `product` ON
        invoice.product_id=product.product_id INNER JOIN `order_status` ON
        invoice.status_id=order_status.order_status_id INNER JOIN `user` ON
        invoice.cou_user_email=user.email INNER JOIN `user_has_address` ON
        user.email=user_has_address.user_email WHERE `invoice_id`='".$invoiceId."'");
        $invoiceData = $invoiceRs -> fetch_assoc();

        $productImgRs = Database::search("SELECT * FROM `product_img` WHERE `product_product_id`='".$invoiceData["product_id"]."'");
        
       
        ?>
        
       <!DOCTYPE html>
       <html lang="en">
       <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style.css">
        <title><?php echo($invoiceData["title"]);?></title>
       </head>
       <body onload="active(8);">
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
                <div class="row">
                    <div class="col-12 col-md-6">
                        <h3>
                            Product Image(s)
                        </h3>
                       
                    </div>
                    <div class="col-12 col-md-6  mb-2 mt-0">
                        <div class="row   ">
                        <div class="col-12 col-md-6 offset-md-6 border border-info  mt-0">
                        <h4>Order Staus</h4>
                        <button class=" form-control mb-2 mt-0 btn <?php if ( $invoiceData["order_status_id"] == 1 ){
                            ?>btn-primary<?php
                        }else if ( $invoiceData["order_status_id"] == 2) {
                            ?>btn-success<?php
                        }else if ( $invoiceData["order_status_id"] == 3) {
                            ?>btn-warning<?php
                        } else if ( $invoiceData["order_status_id"] == 4 ) {
                            ?>btn-danger<?php
                        }?>"><?php echo($invoiceData["status_name"]);?></button>
                    </div>
                    
                        
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="row p-0 justify-content-center">
                        <?php
                            for ($i=0; $i < $productImgRs -> num_rows; $i++) {
                                $img = $productImgRs -> fetch_assoc(); 
                                ?>
                                
                                    <img src="<?php echo($img["path"]);?>" alt=""  style="width: 300px; height: 200px;" class=" border border-danger p-0 m-2 img-fluid "/>
                               
                                <?php
                            }
                        ?>
                            
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-lg-6">
                        <label for="title">Title</label>
                            <input type="text" id="title" class=" form-control" value="<?php echo($invoiceData["title"]);?>" readonly />
                    </div>
                    <div class="col-12 col-lg-6">
                        <label for="rqty">Requested QTY</label>
                            <input type="text" id="rqty" class=" form-control" value="<?php echo($invoiceData["buy_qty"]);?>" readonly />
                    </div>
                    <div class="col-12 col-lg-6">
                        <label for="dateTime">Requested Date & Time</label>
                            <input type="text" id="dateTime" class=" form-control" value="<?php echo($invoiceData["date_time"]);?>" readonly />
                    </div>
                    <div class="col-12 col-lg-6">
                    <label for="amount">Amount</label>
                    <div class="input-group mb-3 ">
                        <span class="input-group-text">Rs</span>
                        <input type="number" class="form-control" id="amount" aria-label="Amount (to the nearest dollar)" value="<?php echo($invoiceData["total"]);?>" readonly  />
                    </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <h4>Customer Details</h4>
                    </div>
                    <div class="col-12">
                        <div class="row">
                            <div class="col-12 col-lg-6">
                            <label for="cusName">Customer Name </label>
                                <input type="text" id="cusName" class=" form-control" value="<?php echo($invoiceData["fname"]." ".$invoiceData["lname"]);?>" readonly />
                            </div>
                            <div class="col-12 col-lg-6">
                            <label for="cusAddress">Customer Address </label>
                                <input type="text" id="cusAddress" class=" form-control" value="<?php echo($invoiceData["line1"]." , ".$invoiceData["line2"]);?>" readonly />
                            </div>
                            <div class="col-12 col-lg-6">
                            <label for="cusMobile">Customer Mobile No</label>
                                <input type="text" id="cusMobile" class=" form-control" value="<?php echo($invoiceData["mobile"]);?>" readonly />
                            </div>
                            <div class="col-12 col-lg-6">
                            <label for="cusEmail">Customer Email</label>
                                <input type="text" id="cusEmail" class=" form-control" value="<?php echo($invoiceData["email"]);?>" readonly />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row ms-2 me-2 border border-primary mb-3 mt-3">
                    <div class="col-12">
                        <h4>Change Order Status</h4>
                    </div>
                    
                    <div class="col-6 offset-3 mb-3" >
                        <select  id="orderStatus" class=" form-select" onclick="changeOrderStatus(<?php echo($invoiceId);?>)">
                            <option value="0">Select</option>
                            <?php
                                $orderStatusRs = Database::search("SELECT * FROM `order_status`");
                                for ($i=0; $i <$orderStatusRs -> num_rows ; $i++) { 
                                    $orderStatus = $orderStatusRs -> fetch_assoc();
                                    ?>
                                    <option value="<?php echo($orderStatus["order_status_id"]);?>"><?php echo($orderStatus["status_name"]);?></option>
                                    <?php
                                }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
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
        header("location:index.php");
    }

?>