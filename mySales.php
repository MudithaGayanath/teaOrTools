<?php
    include("header.php");
    include("connection.php");

    if ( isset($_SESSION["u"])){
        $email = $_SESSION["u"]["email"];
        ?>
        <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap.css" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <title>My Sales | Tea or Tools</title>
</head>
<body onload="active(8);salesAlert();sellerMonthlyIncome();">
    <div class="container-fluid">

        <div class="row">
        <div class="col-11 offset-1 mt-3 ps-5 col-sm-6 offset-sm-0 col-xl-3 ps-md-5 ps-lg-4 ps-sm-1">
        <div class="card bg-primary text-white" style="width: 18rem;">
            <div class="card-body">
                <h5 class="card-title">Total Income</h5>
                <?php
                    $incomeRs = Database::search("SELECT * FROM `invoice` INNER JOIN `product` ON
                    invoice.product_id=product.product_id  WHERE `user_email`='".$email."'");
                    $totIncome = 0;
                    $solledItems = 0;
                    for ($i=0; $i < $incomeRs -> num_rows; $i++) { 
                        $incomeData = $incomeRs -> fetch_assoc();
                        $totIncome = $totIncome + $incomeData["total"];
                        $solledItems = $solledItems + $incomeData["buy_qty"];
                    }
                    
                ?>
                <p class="card-text">RS. <?php echo($totIncome);?>.00</p>
                
            </div>
        </div>
        </div>

        <div class="col-11 offset-1 mt-3 ps-5 col-sm-6 offset-sm-0 col-xl-3 ps-md-0 ps-lg-4 ps-sm-1">
        <div class="card bg-secondary text-white" style="width: 18rem;">
            <div class="card-body">
                <h5 class="card-title">Total Sellings</h5>
               
                <p class="card-text"><?php echo($solledItems);?> Items solled</p>
                
            </div>
        </div>
        </div>

        <div class="col-11 offset-1 mt-3 ps-5 col-sm-6 offset-sm-0 col-xl-3 ps-md-5 ps-lg-4 ps-sm-1">
        <div class="card bg-success text-white" style="width: 18rem;">
            <div class="card-body">
                <h5 class="card-title">Available Items</h5>
                <?php 
                    $avaitableProductRs = Database::search("SELECT * FROM `product` WHERE `user_email`='".$email."' AND `status_status_id`='1' ");
                    $avaitableProduct= 0;
                    for ($i=0; $i < $avaitableProductRs -> num_rows; $i++) { 
                        $avaitableProductData = $avaitableProductRs -> fetch_assoc();
                        $avaitableProduct = $avaitableProduct + $avaitableProductData["qty"];
                    }
                ?>
                <p class="card-text"> <?php echo($avaitableProduct);?> Items </p>
                
            </div>
        </div>
        </div>

        <div class="col-11 offset-1 mt-3 ps-5 col-sm-6 offset-sm-0 col-xl-3 ps-md-0 ps-lg-4 ps-sm-1">
        <div class="card bg-danger text-white" style="width: 18rem;">
            <div class="card-body">
                <h5 class="card-title">Inactive Items</h5>
                <?php 
                    $unavaitableProductRs = Database::search("SELECT * FROM `product` WHERE `user_email`='".$email."' AND `status_status_id`='2' ");
                    $unavaitableProduct= 0;
                    for ($i=0; $i < $unavaitableProductRs -> num_rows; $i++) { 
                        $unavaitableProductData = $unavaitableProductRs -> fetch_assoc();
                        $unavaitableProduct = $unavaitableProduct + $unavaitableProductData["qty"];
                    }
                ?>
                <p class="card-text"> <?php echo($unavaitableProduct);?> Items </p>
                
            </div>
        </div>
        </div>
        </div>

        <h1 >Monthly Income</h1>
        <div class="row ">
            <div class="col-12  col-lg-10 offset-lg-1">
            <canvas id="myChart" ></canvas>
            </div>
        </div>
        <div class="container-fluid container-lg">
        <div class="row">
            <h1>Sales History</h1>
            <table class="table text-center ">
            <thead>
                <th>Order ID</th>
                <th>Item Name</th>
                <th>Date & Time</th>
                <th>Status</th>
            </thead>
            <tbody>
                <?php
                    $ProductRs = Database::search("SELECT * FROM `invoice` INNER JOIN `product` ON
                    invoice.product_id=product.product_id INNER JOIN `order_status` ON
                    invoice.status_id=order_status.order_status_id  WHERE `user_email`='".$email."'  ORDER BY `date_time` DESC ");
                    for ($i=0; $i < $ProductRs -> num_rows; $i++) { 
                        $ProductData = $ProductRs -> fetch_assoc();
                        if ( $ProductData["view_id"] == 1 ){
                            ?>
                            
                            <tr class=" bg-primary-subtle" onclick="unviewToViwe(<?php echo($ProductData['invoice_id']) ?>);">
                            <td ><?php echo($ProductData["order_id"]); ?></td>
                            <td><?php echo($ProductData["title"]); ?></td>
                            <td><?php echo($ProductData["date_time"]); ?></td>
                            <td><button class=" btn col-4"><?php echo($ProductData["status_name"]); ?></button></td>
                            </tr>
                            <?php
                        }else {
                            ?>
                            <tr class=" " onclick="goToSoldProduct(<?php echo($ProductData['invoice_id']) ?>);">
                            <td><?php echo($ProductData["order_id"]); ?></td>
                            <td><?php echo($ProductData["title"]); ?></td>
                            <td><?php echo($ProductData["date_time"]); ?></td>
                            <td>
                                <?php
                                if ($ProductData["status_id"] == 1) {
                                    ?>
                                    <button class=" btn btn-primary col-12 col-lg-6"><?php echo($ProductData["status_name"]); ?></button>
                                    <?php
                                }else if ($ProductData["status_id"] == 2) {
                                    ?>
                                    <button class=" btn btn-success col-12 col-lg-6"><?php echo($ProductData["status_name"]); ?></button>
                                    <?php
                                }else if ($ProductData["status_id"] == 3) {
                                    ?>
                                    <button class=" btn btn-warning col-12 col-lg-6"><?php echo($ProductData["status_name"]); ?></button>
                                    <?php
                                }else if ($ProductData["status_id"] == 4) {
                                    ?>
                                    <button class=" btn btn-danger col-12 col-lg-6"><?php echo($ProductData["status_name"]); ?></button></td>
                                    <?php
                                }
                                ?>    
                            </tr>
                            <?php
                        }
                        
                    }
                ?>
            </tbody>
            </table>
        </div>
        </div>
        
    </div>





<script src="script.js"></script>
</body>
</html>
        <?php
    }else {
        header("location:login.php");
    }
?>

