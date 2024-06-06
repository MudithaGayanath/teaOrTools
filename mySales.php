<?php
include("header.php");
include("connection.php");

if (isset($_SESSION["u"])) {
    $email = $_SESSION["u"]["email"];
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="bootstrap.css" />
        <link rel="stylesheet" href="style.css">
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <title>My Sales | Tea or Tools</title>
    </head>

    <body onload="active(8);salesAlert();sellerMonthlyIncome();">
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

            <button id="hide" class="btn btn-close-white border border-secondary mt-3">Hide</button>
            <button id="show" class="btn btn-close-white border border-secondary mt-3 ">Show</button>

            <div class="row justify-content-center  text-center justify-content-lg-around p-0 m-3" id="row">
                <div class="card m-2 " style="width: 14rem;">
                    <div class="card-body">
                        <h5 class="card-title">Total Income</h5>
                        <?php
                        $incomeRs = Database::search("SELECT * FROM `invoice` INNER JOIN `product` ON
                    invoice.product_id=product.product_id  WHERE `user_email`='" . $email . "'");
                        $totIncome = 0;
                        $solledItems = 0;
                        for ($i = 0; $i < $incomeRs->num_rows; $i++) {
                            $incomeData = $incomeRs->fetch_assoc();
                            $totIncome = $totIncome + $incomeData["total"];
                            $solledItems = $solledItems + $incomeData["buy_qty"];
                        }

                        ?>
                        <p class="card-text">RS. <?php echo ($totIncome); ?>.00</p>

                    </div>
                </div>

                <div class="card m-2  " style="width: 14rem;">
                    <div class="card-body">
                        <h5 class="card-title">Total Sellings</h5>

                        <p class="card-text"><?php echo ($solledItems); ?> Items solled</p>

                    </div>
                </div>

                <div class="card m-2 " style="width: 14rem;">
                    <div class="card-body">
                        <h5 class="card-title">Available Items</h5>
                        <?php
                        $avaitableProductRs = Database::search("SELECT * FROM `product` WHERE `user_email`='" . $email . "' AND `status_status_id`='1' ");
                        $avaitableProduct = 0;
                        for ($i = 0; $i < $avaitableProductRs->num_rows; $i++) {
                            $avaitableProductData = $avaitableProductRs->fetch_assoc();
                            $avaitableProduct = $avaitableProduct + $avaitableProductData["qty"];
                        }
                        ?>
                        <p class="card-text"> <?php echo ($avaitableProduct); ?> Items </p>

                    </div>
                </div>

                <div class="card m-2 " style="width: 14rem;">
                    <div class="card-body">
                        <h5 class="card-title">Inactive Items</h5>
                        <?php
                        $unavaitableProductRs = Database::search("SELECT * FROM `product` WHERE `user_email`='" . $email . "' AND `status_status_id`='2' ");
                        $unavaitableProduct = 0;
                        for ($i = 0; $i < $unavaitableProductRs->num_rows; $i++) {
                            $unavaitableProductData = $unavaitableProductRs->fetch_assoc();
                            $unavaitableProduct = $unavaitableProduct + $unavaitableProductData["qty"];
                        }
                        ?>
                        <p class="card-text"> <?php echo ($unavaitableProduct); ?> Items </p>

                    </div>
                </div>

                <div class="card m-2  " style="width: 14rem;">
                    <div class="card-body">
                        <h5 class="card-title">Product Count</h5>
                        <?php
                        $productCountRs = Database::search("SELECT * FROM `product` WHERE `user_email`='" . $email . "'");

                        ?>
                        <p class="card-text"> <?php echo ($productCountRs->num_rows); ?> Items </p>

                    </div>
                </div>
                <div class="card m-2  " style="width: 14rem;">
                    <div class="card-body">
                        <h5 class="card-title">Most Selling Item</h5>
                        <?php
                        $fpName = "N/A";

                        $favoriteProductFromInvoiceRs = Database::search("SELECT MAX(invoice.product_id) AS `pid` FROM `invoice` INNER JOIN `product` ON
                    invoice.product_id=product.product_id WHERE `user_email`='" . $email . "'");



                        if ($favoriteProductFromInvoiceRs->num_rows > 0) {

                            $fpfiData = $favoriteProductFromInvoiceRs->fetch_assoc();
                            $fpfiPid = $fpfiData["pid"];

                            $favoriteProductRs = Database::search("SELECT * FROM `product` WHERE `product_id`='" . $fpfiPid . "'");
                            if ($favoriteProductRs -> num_rows > 0){
                                
                                                            $favoriteProductData = $favoriteProductRs->fetch_assoc();
                                                            $fpName = $favoriteProductData["title"];

                            }
                        }

                        ?>
                        <p class="card-text"> <?php echo ($fpName); ?> </p>

                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-12 col-md-9">

                    <h1>Income Flow</h1>
                </div>
                <div class="col-12 col-md-3 text-end">

                    <a href="sellerMonthlyIncome.php" class=" btn btn-primary ">Monthly Report</a>
                </div>
            </div>

            <div class="row justify-content-center ">
                <div class="col-12 col-lg-9 ">
                    <canvas id="myChart"></canvas>
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
                    invoice.status_id=order_status.order_status_id  WHERE `user_email`='" . $email . "'  ORDER BY `date_time` DESC ");
                            for ($i = 0; $i < $ProductRs->num_rows; $i++) {
                                $ProductData = $ProductRs->fetch_assoc();
                                if ($ProductData["view_id"] == 1) {
                            ?>

                                    <tr class=" bg-primary-subtle" onclick="unviewToViwe(<?php echo ($ProductData['invoice_id']) ?>);">
                                        <td><?php echo ($ProductData["order_id"]); ?></td>
                                        <td><?php echo ($ProductData["title"]); ?></td>
                                        <td><?php echo ($ProductData["date_time"]); ?></td>
                                        <td><button class=" btn col-4"><?php echo ($ProductData["status_name"]); ?></button></td>
                                    </tr>
                                <?php
                                } else {
                                ?>
                                    <tr class=" " onclick="goToSoldProduct(<?php echo ($ProductData['invoice_id']) ?>);">
                                        <td><?php echo ($ProductData["order_id"]); ?></td>
                                        <td><?php echo ($ProductData["title"]); ?></td>
                                        <td><?php echo ($ProductData["date_time"]); ?></td>
                                        <td>
                                            <?php
                                            if ($ProductData["status_id"] == 1) {
                                            ?>
                                                <button class=" btn btn-primary col-12 col-lg-6"><?php echo ($ProductData["status_name"]); ?></button>
                                            <?php
                                            } else if ($ProductData["status_id"] == 2) {
                                            ?>
                                                <button class=" btn btn-success col-12 col-lg-6"><?php echo ($ProductData["status_name"]); ?></button>
                                            <?php
                                            } else if ($ProductData["status_id"] == 3) {
                                            ?>
                                                <button class=" btn btn-warning col-12 col-lg-6"><?php echo ($ProductData["status_name"]); ?></button>
                                            <?php
                                            } else if ($ProductData["status_id"] == 4) {
                                            ?>
                                                <button class=" btn btn-danger col-12 col-lg-6"><?php echo ($ProductData["status_name"]); ?></button>
                                        </td>
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



        <?php
        include("footer.php");
        ?>

        <script src="script.js"></script>
        <script src="jqery.min.js"></script>
        <script>
            $(document).ready(

                function() {
                    $("#loader").animate({
                        opacity: "0%"
                    }, 1000, function() {
                        $("#loader").hide();
                    })
                    $("#show").hide();
                    $("#hide").click(function() {
                        $("#row").hide(function() {
                            $("#row").fadeOut(function() {
                                $("#hide").hide(function() {
                                    $("#show").show();
                                });
                            });
                        });
                    });

                    $("#show").click(function() {
                        $("#row").show(function() {
                            $("#row").fadeIn(function() {
                                $("#show").hide(function() {
                                    $("#hide").show();
                                });
                            });
                        });
                    });

                }

            );
        </script>
    </body>

    </html>
<?php
} else {
    header("location:login.php");
}
?>