<?php
  include("header.php");
  if ( isset($_SESSION["u"])){
    include("connection.php");
    $email = $_SESSION["u"]["email"];
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="bootstrap.css" />
        <title>History | Tea or Tools</title>
    </head>
    <body onload="active(7);salesAlert();">
    <div class="container-fluid">
      <div class="row">
        <h1 class=" text-center">History</h1>
      </div>
      <?php
        $invoiceRs = Database::search("SELECT * FROM `invoice` INNER JOIN `product` ON 
        invoice.product_id=product.product_id INNER JOIN `order_status` ON
        invoice.status_id=order_status.order_status_id WHERE `cou_user_email`='".$email."'");
        if ( $invoiceRs -> num_rows == 0){
          ?>
          <div class="col-12 text-center">
                <h1 class=" display-1">N/A</h1>
            </div>
          <?php
        }else {
          ?>
          <table   class="table table-striped table-hover">
      <thead>
        <tr>
          
          <th scope="col" class=" lead fw-bold">Order ID</th>
          <th scope="col" class=" lead fw-bold">Product Title</th>
          <th scope="col" class=" lead fw-bold">QTY</th>
          <th scope="col" class=" lead fw-bold">Total</th>
          <th scope="col" class=" lead fw-bold">Date & Time</th>
          <th scope="col" class=" lead fw-bold">Status</th>
          <th scope="col" class=" lead fw-bold">More</th>
        </tr>
      </thead>
      <tbody>
      <?php
        for ($i=0; $i < $invoiceRs -> num_rows; $i++) { 
          $inData = $invoiceRs -> fetch_assoc();
          ?>
            <tr>
              
              <td><?php echo($inData["order_id"]);?></td>
              <td><?php echo($inData["title"]);?></td>
              <td><?php echo($inData["buy_qty"]);?></td>
              <td><?php echo($inData["total"]);?>.00</td>
              <td><?php echo($inData["date_time"]);?></td>
              <?php
                if ( $inData["status_id"] == "1" ){
                    ?>
                    <td><button type="button" class="btn btn-primary"><?php echo($inData["status_name"]);?> </button></td>
                    <td>
              <button type="button" class="btn btn-secondary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="">
                View
            </button>
            </td>
                    <?php
                }else {
                    ?>
                    <td><button type="button" class="btn btn-success "><?php echo($inData["status_name"]);?> </button></td>
                    <td>
              <button type="button" class="btn btn-secondary" onmouseover="viewMore();" id="tooltip" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Click Here To Add Your Review">
                View
            </button>
            </td>
                    <?php
                }
              ?>
              
            </tr>
          <?php
        }
      ?>

      </tbody>
      
    </table>
          <?php
        }
      ?>
    
    </div>
    <?php
    include("footer.php");
    ?>
    </body>
    </html>
    <?php

  }else {
    header("location:login.php"); 
  }
?>
