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
                <h5 class="card-title">Available Items</h5>
                <p class="card-text">100 Items soled</p>
                
            </div>
        </div>
        </div>
        </div>

        <h1 >Monthly Income</h1>
        <div class="row">
            <div class="col-12 col-lg-6  ">
            <canvas id="myChart" ></canvas>
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

