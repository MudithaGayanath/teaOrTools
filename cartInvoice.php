<?php
session_start();
if (isset($_SESSION["buyAll"]) && isset($_SESSION["u"])) {
    include("connection.php");
    $email = $_SESSION["u"]["email"];
    $fname = $_SESSION["u"]["fname"];
    $lname = $_SESSION["u"]["lname"];
    $orderId = $_SESSION["buyAll"];

    $d = new DateTime();
    $tz = new DateTimeZone("Asia/Colombo");
    $d->setTimezone($tz);
    $date = $d->format("Y-m-d H:i:s");

    $pids = $_SESSION["invoicePid"];
    $qtys = $_SESSION["invoiceQty"];
    $tots = $_SESSION["invoiceTot"];
    $deleverts = $_SESSION["invoiceDelevery"];
    $prices = $_SESSION["invoicePrice"];
    $titles = $_SESSION["invoiceTitle"];
   
    for ($i = 0; $i < sizeof($pids); $i++) {
        $pid =  $pids["pid" . $i];
        $qyt = $qtys["qty" . $i];
        $tot = $tots["tot" . $i];
        

        Database::iud("INSERT INTO `invoice` (`product_id`,`cou_user_email`,`order_id`,`buy_qty`,`total`,`date_time`,`status_id`,`view_id`) VALUES
    ('" . $pid . "','" . $email . "','" . $orderId . "','" . $qyt . "','" . $tot . "','" . $date . "','1','1')");
    }

    $userAddressRs = Database::search("SELECT * FROM  `user`INNER JOIN `user_has_address` ON
  user.email=user_has_address.user_email INNER JOIN `city` ON
  user_has_address.city_city_id=city.city_id WHERE `email`='" . $email . "'");

    $userAddressData = $userAddressRs->fetch_assoc();
    $userAddress = $userAddressData["line1"] . "," . $userAddressData["line2"];
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="bootstrap.css" />
        <title>Invoice | Tea or Tools</title>
        <link rel="stylesheet" href="style.css">
    </head>

    <body>
        <div class="container invoice" id="invoice">
            <div class="row invoice-header">
                <div class="col-md-6">
                    <h1 class="invoice-title">Invoice</h1>
                    <p>Order ID - <?php echo ($orderId) ?></p>
                </div>
                <div class="col-md-6 text-md-right">
                    <h4>Tea or Tools</h4>
                    <p>R6/1 Weediyawaththa, Miyanawita, Deraniyagala</p>
                    <p>info@teaortools.com</p>
                </div>
            </div>

            <div class="row invoice-info">
                <div class="col-md-6">
                    <h5>Bill To:</h5>
                    <p>
                        <?php echo ($fname . " " . $lname) ?><br>
                        <?php echo ($userAddress) ?><br>
                        <?php echo ($email) ?><br>
                    </p>
                </div>
                <div class="col-md-6 text-md-right">
                    <h5>Invoice Date:</h5>
                    <p><?php echo ($date) ?></p>

                </div>
            </div>

            <div class="row invoice-details">
                <div class="col-md-12">
                    <table class="table table-bordered table-invoice">
                        <thead class="thead-light">
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th class="text-right">Quantity</th>
                                <th class="text-right">Unit Price</th>
                                <th class="text-right">Delevery Price</th>
                                <th class="text-right">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            for ($i = 0; $i < sizeof($pids); $i++) {
                            ?>
                                <tr>
                                    <td><?php echo ($i + 1) ?></td>
                                    <td><?php echo ($titles["title" . $i]) ?></td>
                                    <td class="text-right"><?php echo ($qtys["qty" . $i]) ?></td>
                                    <td class="text-right">Rs<?php echo ($prices["price" . $i]) ?>.00</td>
                                    <td class="text-right">Rs<?php echo ($deleverts["delever" . $i]) ?>.00</td>
                                    <td class="text-right">Rs<?php echo ($tots["tot" . $i]) ?>.00</td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="5" class="text-right">Subtotal</th>
                                <?php
                                $subTot = 0;
                                for ($i = 0; $i <  sizeof($pids); $i++) {
                                    $subTot = $subTot + $tots["tot" . $i];
                                }
                                ?>
                                <th class="text-right">Rs<?php echo ($subTot) ?>.00</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <div class="row invoice-footer">
                <div class="col-md-12">
                    <p>Thank you!</p>
                </div>
            </div>
            <div class="row" id="btn">
                <a class=" btn btn-danger mt-1 col-10 offset-1 col-md-2 offset-md-0  mt-md-0" href="cart.php">Back</a>
                <button class=" btn btn-primary mt-1 col-10 offset-1 col-md-2 offset-md-8 mt-md-0" onclick="cartPdf();">PDF</button>
            </div>
        </div>
        <script src="script.js"></script>
    </body>

    </html>
<?php
    Database::iud("DELETE FROM `cart` WHERE `user_email`='" . $email . "'");
    for ($i = 0; $i < sizeof($pids); $i++) {
        $pid =  $pids["pid" . $i];
        $qyt = $qtys["qty" . $i];
        $pQtyRs = Database::search("SELECT `qty` FROM `product` WHERE `product_id`='".$pid."'");
        $pQtyData = $pQtyRs -> fetch_assoc();
        $pQty = $pQtyData["qty"];
        
        $newQty = $pQty - $qyt;
        Database::iud("UPDATE `product` SET `qty`='".$newQty."' WHERE `product_id`='".$pid."'");
    }
    unset($_SESSION["buyAll"]);
    unset($_SESSION["invoicePid"]);
    unset($_SESSION["invoiceQty"]);
    unset($_SESSION["invoiceTot"]);
    unset($_SESSION["invoiceDelevery"]);
    unset($_SESSION["invoicePrice"]);
    unset($_SESSION["invoiceTitle"]);
} else {
    header("location:cart.php");
}
?>