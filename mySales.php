<?php
    include("header.php");

    if ( isset($_SESSION["u"])){
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
<body onload="salesAlert();sellerMonthlyIncome();">
    <div class="container-fluid">
        <h1>Monthly Income</h1>
        <div class="row">
            <div class="col-12 col-md-6 ">
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

