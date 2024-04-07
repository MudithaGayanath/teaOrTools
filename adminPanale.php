<?php
    session_start();
    if ( isset($_SESSION["a"])){
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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <title>Admin Panale | Tea or Tools</title>
</head>
<body onload="income();">
<nav class="navbar bg-body-tertiary navbar-expand-md  sticky-top">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Tea or Tools </a>
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
            <a class="nav-link active" aria-current="page" href="#">Dashboard</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Manger Users</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Manger Products</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">History</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#" onclick="adminLogout();">LogOut</a>
          </li>
          
        </ul>
       
      </div>
    </div>
  </div>
</nav>

<div class="container-fluid">
    <div class="row">
        <div class="col-12 col-sm-4">Hello , <?php echo($_SESSION["a"]["fname"]." ".$_SESSION["a"]["lname"]); ?></div>
        <?php
            
            $start_date = new DateTime("2024-2-22 08:00:00");

            $tdate = new DateTime();
            $tz = new DateTimeZone("Asia/Colombo");
            $tdate->setTimezone($tz);
            $end_date = new DateTime($tdate->format("Y-m-d H:i:s")) ;

            $difference = $end_date -> diff($start_date);
        ?>
        <div class="col-12 col-sm-8 col-md-6  col-lg-5  offset-lg-3  offset-md-2 text-sm-center  bg-primary text-white rounded-1" id="time">
            
       <h5> Active Time : <?php echo($difference -> format('%Y')."Years ".$difference -> format('%m')."Months ".$difference -> format('%d')."Days");?></h5>
        </div>
    </div>

    <!-- box start -->
    <div class="row">
      <!-- totIncome -->
      <div class="col-11 offset-1 mt-3 ps-5 col-sm-6 offset-sm-0 col-xl-3 ps-md-5 ps-lg-4 ps-sm-1">
        <div class="card bg-primary text-white" style="width: 18rem;">
        <div class="card-body">
          <h5 class="card-title">Total Income</h5>
          <?php
          $totIncomeRs = Database::search("SELECT SUM(total) AS totalIncome  FROM `invoice`");
          $totIncomeData = $totIncomeRs ->  fetch_assoc();
          $totIncome = (double)$totIncomeData["totalIncome"]
          ?>
          <p class="card-text">RS. <?php echo(number_format($totIncome));?></p>
                
            </div>
        </div>
      </div>
              <!-- totSold -->
      <div class="col-11 offset-1 mt-3 ps-5 col-sm-6 offset-sm-0 col-xl-3 ps-md-5 ps-lg-4 ps-sm-1">
        <div class="card bg-success text-white" style="width: 18rem;">
        <div class="card-body">
          <h5 class="card-title">Total Salles</h5>
          <?php
          $totalSoldItemsRs = Database::search("SELECT SUM(buy_qty) AS totalSoldItems  FROM `invoice`");
          $totalSoldItemsData = $totalSoldItemsRs ->  fetch_assoc();
          $totalSoldItems = $totalSoldItemsData["totalSoldItems"]
          ?>
          <p class="card-text"> <?php echo($totalSoldItems);?> Items</p>
                
            </div>
        </div>
      </div>
    </div>
    <!-- box end -->
    <div class="row">
    <div class="col-12 col-md-6 mt-2">
      <div class="card ">
        <div class="card-body">
          
        <h5 class="card-title ">Income Activity</h5>
        <canvas id="myChart" ></canvas>
        </div>
      </div>
    </div>

    <!-- <div class="col-12 col-md-6 mt-2">
      <div class="card">
      <div class="card-header">
        <h3>Category Activity</h3>
      </div>
      <div class="card-body bg-warning text-white">
      <div id="piechart" class=" w-100" ></div>
      </div>
    </div>
    </div> -->
        
    </div>
</div>

<script src="bootstrap.bundle.js"></script>
<script src="script.js"></script>
</body>
</html>
        <?php
    }else {
        ?>
        <script>
            alert("Illegal Admin  Access Denied");
            window.location = "index.php";
        </script>
        <?php
    }
?>