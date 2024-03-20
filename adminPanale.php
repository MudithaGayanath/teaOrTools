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
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
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
            
            $start_date = new DateTime("2023-12-15 19:00:00");

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
        <h3>Proformance</h3>
        <div id="curve_chart" class=" col-12"></div>
    </div>
</div>
<script type="text/javascript">
      
    </script>
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