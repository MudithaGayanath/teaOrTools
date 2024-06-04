<?php
include("header.php");
include("connection.php");

if (isset($_SESSION["u"])) {
    $email = $_SESSION["u"]["email"];
    $d = new DateTime();
    $tz = new DateTimeZone("Asia/Colombo");
    $d->setTimezone($tz);
    $date = $d->format("Y-m-d H:i:s");

    $sData = explode("-", $date);
    $currentYear = $sData[0];
    $currentMonth = $sData[1];
    $currentDate = $currentYear . "-" . $currentMonth;

    $months = [
        "January",
        "February",
        "March",
        "April",
        "May",
        "June",
        "July",
        "August",
        "September",
        "October",
        "November",
        "December"
    ];
    //change here
    //change here
    //change here
    //change here
    //change here
    $rs = Database::search("SELECT * FROM `invoice` INNER JOIN `product` ON
    invoice.product_id=product.product_id  WHERE `user_email`='" . $email . "' AND `date_time` LIKE '%2024-04%'");
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Monthly Income | Tea or Tools</title>
    </head>

    <body onload="active(8);">
        <?php
        if ($rs->num_rows > 0) {
            $data = $rs -> fetch_assoc();
            $income = 0;
            $iRs = Database::search("SELECT SUM(`total`) AS `tot`  FROM `invoice` INNER JOIN `product` ON
            invoice.product_id=product.product_id  WHERE `user_email`='" . $email . "' AND `date_time` LIKE '%2024-04%'");
            $inData = $iRs -> fetch_assoc();
            $income = $inData["tot"];

            $mostSellingItem = "";
            $mRS = Database::search("SELECT MAX(invoice.product_id) AS pid FROM `invoice` INNER JOIN `product` ON
            invoice.product_id=product.product_id  WHERE `user_email`='" . $email . "' AND `date_time` LIKE '%2024-04%'");
            $mData = $mRS -> fetch_assoc();
            $mProduct = Database::search("SELECT `title` FROM `product` WHERE `product_id`='".$mData["pid"]."'");
            $mpData = $mProduct -> fetch_assoc();
            $mostSellingItem = $mpData["title"];

            $name = $_SESSION["u"]["fname"]." ".$_SESSION["u"]["lname"];
            


        ?>
            <div class=" container-fluid" id="conten">
                <h1 class=" text-center"><?php echo ("Report for " . $months[$currentMonth - 1]); ?></h1>
                <div class="row p-0 text-end me-3">
                    <div class="col-12 p-0 m-0">
                        <p class=" m-0"><?php echo($name) ?></p>
                        <p class=" m-0"><?php echo($email) ?></p>
                        <p class=" m-0">from - <?php echo($currentDate)  ?>-01 to - <?php echo($date) ?> </p>
                    </div>
                </div>
                <div class="row">
                    <p class=" m-0 fs-4">Total income = <?php echo($income);?>.00</p>
                    <p class=" m-0 fs-4">Total Sellings = <?php echo($rs->num_rows);?></p>
                    <p class=" m-0 fs-4">Most Selling Item = <?php echo($mostSellingItem);?></p>
                </div>
                <div class="row">
                    <div class="col-md-10 offset-md-1 col-12">
                    <table class=" table text-center">
                    <thead>
                        <tr>
                        <th>Title</th>
                        <th>QTY</th>
                        <th>Total</th>
                        <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $tRs = Database::search("SELECT * FROM `invoice` INNER JOIN `product` ON
                            invoice.product_id=product.product_id  WHERE `user_email`='" . $email . "' AND `date_time` LIKE '%2024-04%'");
                            for ($i=0; $i < $tRs -> num_rows; $i++) { 
                                $tData = $tRs -> fetch_assoc();
                                $title = $tData["title"];
                                $qty = $tData["buy_qty"];
                                $total = $tData["total"];
                                $date = $tData["date_time"];
                                ?>
                                <tr>
                                    <td><?php echo($title)?></td>
                                    <td><?php echo($qty)?></td>
                                    <td><?php echo($total)?>.00</td>
                                    <td><?php echo($date)?></td>
                                </tr>
                                <?php
                            }
                        ?>
                    </tbody>
                </table>
                    </div>
                </div>
                <div class="row" id="row">
                    
                    <div class="col-6 text-start">
                       

                            <a href="mySales.php" class=" btn btn-danger">Back</a>
                       
                    </div>
                    <div class="col-6 text-end">
                      
                            
                            <button class=" btn btn-primary" onclick="pdf();">PDF</button>
                        
                    </div>
                </div>
            </div>
           

        <?php
        } else {
        ?>
            <h1 class=" text-center">N/A</h1>
        <?php
        }
        ?>
        <script src="script.js"></script>
    </body>

    </html>
<?php
} else {
    header("location:login.php");
}
?>