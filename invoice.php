<?php
    session_start();
    if ( isset($_SESSION["u"])){
        include("connection.php");
        $customerEmail = $_SESSION["u"]["email"];
        $customerFname = $_SESSION["u"]["fname"];
        $customerLname = $_SESSION["u"]["fname"];
        $orderId = $_GET["orderId"];
        $pId = $_GET["pId"];
        $qty = $_GET["qty"];
        $tot = $_GET["tot"];
        $deleveryFee = $_GET["fee"];

        $d = new DateTime();
        $tz = new DateTimeZone("Asia/Colombo");
        $d->setTimezone($tz);
        $date = $d->format("Y-m-d H:i:s");
        ?>
        <!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Invoice | Tea or Tools</title>
  <link rel="stylesheet" href="bootstrap.css" />
</head>
<body>

<div class="container" id="main">
  <div class="row">
    <div class="col-md-12">
      <div class="bg-light p-4 mb-1">
        <h1 class="mb-0">Invoice</h1>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-6">
      <div class="bg-light p-4 mb-1">
        <h5>Invoice Details:</h5>
        <p><strong>Order ID:</strong> <?php echo($orderId);?></p>
        <p><strong>Date:</strong><?php echo($date);?></p>
      </div>
    </div>
    <div class="col-md-6">
      <div class="bg-light p-4 mb-1">
        <h5>Seller Details:</h5>
        <?php
        $sellerRs = Database::search("SELECT * FROM `product` INNER JOIN `user` ON 
        product.user_email=user.email INNER JOIN `user_has_address` ON 
        user.email=user_has_address.user_email WHERE `product_id`='".$pId."'");
        $sellerData = $sellerRs -> fetch_assoc();
        ?>
        <p><strong>Name:</strong> <?php echo($sellerData["fname"]." ".$sellerData["lname"]);?></p>
        <p><strong>Email:</strong> <?php echo($sellerData["user_email"]);?></p>
        <p><strong>Address:</strong> <?php echo($sellerData["line1"]." ,".$sellerData["line2"]);?></p>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="bg-light p-4 mb-1">
        <h5>Customer Details:</h5>
        <p><strong>Name:</strong>  <?php echo($customerFname." ".$customerLname);?></p>
        <p><strong>Email:</strong> <?php echo($customerEmail);?></p>
        <?php
            $customerAddressRs = Database::search("SELECT * FROM `user_has_address` WHERE `user_email`='".$customerEmail."'");
            $customerAddress = $customerAddressRs -> fetch_assoc();
        ?>
        <p><strong>Address:</strong><?php echo($customerAddress["line1"]." , ".$customerAddress["line2"]);?></p>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="bg-light p-4 mb-1">
        <h5>Invoice Items:</h5>
        <table class="table">
          <thead class="thead-light">
            <tr>
              <th scope="col">Product Title</th>
              <th scope="col">Image</th>
              <th scope="col">Quantity</th>
              <th scope="col">Unit Price</th>
              <th scope="col">Total</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $productRs = Database::search("SELECT * FROM `product` WHERE `product_id`='".$pId."'");
            $productData = $productRs -> fetch_assoc();

            $productImgRs = Database::search("SELECT * FROM `product_img` WHERE `product_product_id`='".$pId."'");
            $productImgData = $productImgRs -> fetch_assoc();
            ?>
            <tr>
              <td><?php echo($productData["title"]);?></td>
              <td><img src="<?php echo($productImgData["path"]);?>" alt="Product A" style="max-width: 100px;"></td>
              <td><?php echo($qty);?></td>
              <td><?php echo($productData["price"]);?>.00</td>
              <?php
                $newTot = (int)$qty * (int)$productData["price"];
              ?>
              <td><?php echo(intval($newTot));?>.00</td>
            </tr>
           
            <tr>
              <td colspan="4" class="text-right">Subtotal</td>
              <td><?php echo($newTot);?>.00</td>
            </tr>
            <tr>
              <td colspan="4" class="text-right">Delevery Fee</td>
              <td><?php echo($deleveryFee);?></td>
            </tr>
            <tr>
              <td colspan="4" class="text-right"><strong>Total</strong></td>
              <td><strong><?php echo($tot);?>.00</strong></td>
            </tr>
          </tbody>
        </table>
        <button class="btn btn-primary" onclick="printInvoice();" id="printBtn">Print</button>
      </div>
    </div>
  </div>
</div>
<script src="script.js"></script>
</body>
</html>


        <?php
    Database::iud("INSERT INTO `invoice` (`product_id`,`cou_user_email`,`order_id`,`buy_qty`,`total`,`date_time`,`status_id`,`view_id`) VALUES 
    ('".$pId."','".$customerEmail."','".$orderId."','".$qty."','".$tot."','".$date."','1','1')");    
    }else{
        header("location:login.php");
    }
?>

