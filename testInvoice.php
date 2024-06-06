<?php
include("connection.php");

$rs = Database::search("SELECT * FROM `invoice` WHERE `order_id`='665fb69359e88'");
$userData = $rs -> fetch_assoc();
$orderId = $userData["order_id"];
$date = $userData["date_time"];
?>

<!DOCTYPE html>
  <html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap.css"/>
    <title>Invoice | Tea or Tools</title>
   <link rel="stylesheet" href="style.css">
  </head>
  <body>
  <div class="container invoice">
        <div class="row invoice-header">
            <div class="col-md-6">
                <h1 class="invoice-title">Invoice</h1>
                <p>Order ID - 1</p>
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
                    John Doe<br>
                    5678 Another St.<br>
                    Some City, Some State, 67890<br>
                    Email: john.doe@example.com
                </p>
            </div>
            <div class="col-md-6 text-md-right">
                <h5>Invoice Date:</h5>
                <p>23</p>
                
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
                        <tr>
                            <td>1</td>
                            <td>Product 1</td>
                            <td class="text-right">2</td>
                            <td class="text-right">$50.00</td>
                            <td class="text-right">$100.00</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Product 2</td>
                            <td class="text-right">1</td>
                            <td class="text-right">$150.00</td>
                            <td class="text-right">$150.00</td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Service 1</td>
                            <td class="text-right">10</td>
                            <td class="text-right">$20.00</td>
                            <td class="text-right">$200.00</td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="4" class="text-right">Subtotal</th>
                            <th class="text-right">$450.00</th>
                        </tr>
                        
                        <tr>
                            <th colspan="4" class="text-right">Total</th>
                            <th class="text-right">$495.00</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <div class="row invoice-footer">
            <div class="col-md-12">
                <p>Thank you for your business!</p>
                <p><small>If you have any questions about this invoice, please contact [Name, Phone, Email]</small></p>
            </div>
        </div>
    </div>

  </body>
  </html>