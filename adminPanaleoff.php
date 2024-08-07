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
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="bootstrap.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <title>Admin Panale | Tea or Tools</title>
</head>
<body>
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
          
        </ul>
       
      </div>
    </div>
  </div>
</nav>

<div class="container-fluid">
    <div class="row">
        <div class="col-12 col-sm-4">Hello , <?php echo($_SESSION["a"]["fname"]." ".$_SESSION["a"]["lname"]); ?></div>
        <?php
            
            $start_date = new DateTime("2024-1-5 08:00:00");

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
    <div class="row">
      <div class="col-12 col-md-6 col-xl-3 text-white border bg-primary rounded-3 text-center shadow ">
        <!--  -->
        <!--  -->
        <h1 class="card-header lead fs-1">Total Users</h1>
          <?php 
            $totUsers = $userRs -> num_rows;
          ?>
        <h3><?php echo($totUsers);?></h3>
      </div>
      <div class="col-12 col-md-6 col-lg-3 text-white  bg-secondary rounded-3 text-center shadow offset-xl-1">
        <!--  -->
        
        <!--  -->
        <h1 class="card-header">Total Product</h1>
          <?php 
            $productsRs = Database::search("SELECT * FROM `product`");
            $totProduct = $productsRs -> num_rows;
          ?>
        <h3><?php echo($totProduct);?></h3>  
      </div>
      </div>
    <div class="col-12 d-none">
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