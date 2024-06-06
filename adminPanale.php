<?php
session_start();
if (isset($_SESSION["a"])) {
  include("connection.php");

  $invoiceRs = Database::search("SELECT * FROM `invoice`");
  $userRs = Database::search("SELECT * FROM `user`");

?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap.css">
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <title>Admin Panale | Tea or Tools</title>
  </head>

  <body onload="income();sold();">
    <nav class="navbar bg-body-tertiary navbar-expand-md  sticky-top">
      <div class="container-fluid">
        <a class="navbar-brand" href="adminPanale.php">Tea or Tools </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
          <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Tea or Tools</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
          </div>
          <div class="offcanvas-body">
            <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="adminPanale.php">Dashboard</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="manageUser.php">Manger Users</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="manageProducts.php">Manger Products</a>
              </li>
             
              <li class="nav-item">
                <a class="nav-link text-danger" href="#" onclick="adminLogout();">LogOut</a>
              </li>

            </ul>

          </div>
        </div>
      </div>
    </nav>

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
      
        <div class="col-12 col-sm-4">Hello , <?php echo ($_SESSION["a"]["fname"] . " " . $_SESSION["a"]["lname"]); ?></div>
        <?php

        $start_date = new DateTime("2024-01-01 00:00:00");

        $tdate = new DateTime();
        $tz = new DateTimeZone("Asia/Colombo");
        $tdate->setTimezone($tz);
        $end_date = new DateTime($tdate->format("Y-m-d H:i:s"));

        $difference = $end_date->diff($start_date);
        ?>
        <div class="col-12 col-sm-8 col-md-6  col-lg-5  offset-lg-3  offset-md-2 text-sm-center  bg-primary text-white rounded-1" id="time">

          <h5> Active Time : <?php echo ($difference->format('%Y') . "Years " . $difference->format('%m') . "Months " . $difference->format('%d') . "Days"); ?></h5>
        </div>
      </div>

      <!-- box start -->
      <div class="row justify-content-center justify-content-lg-around" id="adReport">
        <!-- totIncome -->
        <div class="card bg-primary text-white m-2" style="width: 18rem;">
          <div class="card-body">
            <h5 class="card-title">Total Cash</h5>
            <?php
            $totIncomeRs = Database::search("SELECT SUM(`total`) AS totalIncome  FROM `invoice`");
            $totIncomeData = $totIncomeRs->fetch_assoc();
            $totIncome = (float)$totIncomeData["totalIncome"]
            ?>
            <p class="card-text">RS. <?php echo (number_format($totIncome)); ?></p>

          </div>
        </div>
        <!-- totSoldItems -->
        <div class="card bg-success text-white m-2" style="width: 18rem;">
          <div class="card-body">
            <h5 class="card-title">Total Sold Items</h5>
            <?php
            $totalSoldItemsRs = Database::search("SELECT SUM(buy_qty) AS totalSoldItems  FROM `invoice`");
            $totalSoldItemsData = $totalSoldItemsRs->fetch_assoc();
            $totalSoldItems = $totalSoldItemsData["totalSoldItems"]
            ?>
            <p class="card-text"> <?php echo ($totalSoldItems); ?> Items</p>

          </div>
        </div>
        <!-- totSales  -->
        <div class="card bg-danger text-white m-2" style="width: 18rem;">
          <div class="card-body">
            <h5 class="card-title">Total Sales </h5>
            <?php
            $totalSalesRs = Database::search("SELECT COUNT(`invoice_id`) AS totalSales  FROM `invoice`");
            $totalSalesData = $totalSalesRs->fetch_assoc();
            $totalSales = $totalSalesData["totalSales"]
            ?>
            <p class="card-text"> <?php echo ($totalSales); ?> Times</p>

          </div>
        </div>

        <!-- totUsers -->
        <div class="card bg-secondary text-white m-2" style="width: 18rem;">
          <div class="card-body">
            <h5 class="card-title">Total Users</h5>
            <?php
            $totalUsersRs = Database::search("SELECT COUNT(`email`) AS totalUsers  FROM `user`");
            $totalUsersData = $totalUsersRs->fetch_assoc();
            $totalUsers = $totalUsersData["totalUsers"];
            ?>
            <p class="card-text"> <?php echo ($totalUsers); ?> Users </p>

          </div>
        </div>

      </div>
      <div class="row justify-content-end ">
        <button class=" btn col-1" onclick="adReoprt();" id="save">Save</button>
      </div>
      <!-- box end -->
      <div class="row">
        <div class="col-12 col-md-6 mt-2">
          <div class="card ">
            <div class="card-body">
              <div class="row">
                <div class="col-6">
                  <h5 class="card-title ">Cash Flow</h5>

                </div>
                <!-- <div class="col-6 text-end" id="pBtn">
                  <p class=" " onclick="printChart();">Print</p>

                </div> -->
              </div>
              <div id="chart">

                <canvas id="myChart"></canvas>
              </div>
            </div>
          </div>
        </div>
       
        <div class="col-12 col-md-6 mt-2">
          <div class="card ">
            <div class="card-body">

              <h5 class="card-title ">Categorie Activity</h5>
              <canvas id="myChart2"></canvas>
            </div>
          </div>
        </div>

      </div>
      <!-- aftr chart -->
      <div class="row justify-content-center justify-content-lg-around text-center">
        <h1>Main Tables</h1>
        <div class="card bg-primary text-white m-2" style="width: 18rem;" onclick="goToCat();">
          <div class="card-body">
            <h5 class="card-title">Categories</h5>
          </div>
        </div>

        <div class="card bg-primary text-white m-2" style="width: 18rem;" onclick="goToBrand();">
          <div class="card-body">
            <h5 class="card-title">Brands</h5>
          </div>
        </div>

        <div class="card bg-primary text-white m-2" style="width: 18rem;" onclick="goToModel();">
          <div class="card-body">
            <h5 class="card-title">Models</h5>
          </div>
        </div>
        <div class="card bg-primary text-white m-2" style="width: 18rem;" onclick="goToColor();">
          <div class="card-body">
            <h5 class="card-title">Colors</h5>
          </div>
        </div>
      </div>
      <!-- aftr chart -->
      <!-- r Tables -->
      <div class="row justify-content-center justify-content-lg-around text-center">
        <h1>Relation Tables</h1>
        <div class="card bg-success text-white m-2" style="width: 18rem;" onclick="goToBandC();">
          <div class="card-body">
            <h5 class="card-title">Brands & Categories</h5>
          </div>
        </div>

        <div class="card bg-success text-white m-2" style="width: 18rem;" onclick="goToMandB();">
          <div class="card-body">
            <h5 class="card-title">Models & Brands</h5>
          </div>
        </div>
        <div class="card bg-success text-white m-2" style="width: 18rem;" onclick="goToMandC();">
          <div class="card-body">
            <h5 class="card-title">Models & Color</h5>
          </div>
        </div>

      </div>
      <!-- r Tables -->
    </div>

    <script src="bootstrap.bundle.js"></script>
    <script src="script.js"></script>
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
} else {
?>
  <script>
    alert("Illegal Admin  Access Denied");
    window.location = "index.php";
  </script>
<?php
}
?>