<?php
session_start();
if (isset($_SESSION["a"])) {
  include("connection.php");

// 
$mRs = Database::search("SELECT * FROM `user`");
$tot = $mRs->num_rows;
$resultPrePage = 8;
$page = 1;

$orderBy = "DESC";
if ( isset($_GET["orderBy"])){
  $orderBy = $_GET["orderBy"];
}

if (isset($_GET["page"])) {
  $pNum = $_GET["page"];
  if ($pNum <= 0) {
    $page = 1;
  } else {

    $page = $_GET["page"];
  }
} else {
  $page = 1;
}

$totPages = ceil($tot / $resultPrePage);

$offset = ($page - 1) * $resultPrePage;
// 

  $userRs = Database::search("SELECT * FROM `user` INNER JOIN `gender` ON
  user.gender_gender_id=gender.gender_id INNER JOIN `status` ON
  user.status_status_id=status.status_id   ORDER BY `joined_date` ".$orderBy." LIMIT " . $resultPrePage . " OFFSET " . $offset . "  ");
?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap.css">
    <link rel="stylesheet" href="style.css">
    <title>Manage Users | Tea or Tools</title>
  </head>

  <body>
    
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
                <a class="nav-link " aria-current="page" href="adminPanale.php">Dashboard</a>
              </li>
              <li class="nav-item">
                <a class="nav-link active" href="manageUser.php">Manger Users</a>
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
    <div class=" container-fluid">
      <h1 class=" text-center">Manage Users</h1>
      <!-- header -->
      <div class="row mt-2 justify-content-center">

        <div class="col-12 col-md-8">
          <div class="input-group mb-3">
            <select id="cat" class="btn btn-close-white border border-secondary" onclick="">
              <option value="0">User Name</option>
              <option value="1">Email</option>

            </select>
            <input type="text" placeholder="Search in Tea or Tools" class="form-control" id="searchText" aria-label="Text input with dropdown button" />
            <button class="btn btn-primary  rounded-end-3" type="button" id="button-addon2" onclick="searchUser();">Search</button>
            <button class="btn btn-close-white" type="button" id="button-addon2" onclick="window.location.reload();">Clear</button>
          </div>
        </div>

      </div>
      <div class="row justify-content-end">
        <div class="col-12 col-md-3">

          <select id="filter" class=" form-select" onclick="userFilter();">
            <option value="1" <?php  if ( isset($_GET["orderBy"])){
              $o = $_GET["orderBy"];
              if ( $o=="DESC"){
                ?> selected <?php
              }
            }?>>Newest to oldest</option>
            <option value="2"  <?php  if ( isset($_GET["orderBy"])){
              $o = $_GET["orderBy"];
              if ( $o=="ASC"){
                ?> selected <?php
              }
            }?>>Oldest to newest</option>
            <option value="3">Active Only</option>
            <option value="4">Inactive Only</option>
            <option value="5">Male Only</option>
            <option value="6">Female Only</option>
          </select>
        </div>
      </div>
      <!-- header -->
      <!-- filterRS -->
      <div class="row justify-content-center justify-content-lg-around d-none" id="filterResultRow">

      </div>
      <!-- filterRS -->
      <div class="row justify-content-center justify-content-lg-around" id="mainRow">

        <?php
        
        for ($i = 0; $i < $userRs->num_rows; $i++) {
          $data = $userRs->fetch_assoc();
          $name = $data["fname"] . " " . $data["lname"];
          $email = $data["email"];
          $mobile = $data["mobile"];
          $joined_date = $data["joined_date"];
          $gender = $data["gender_name"];
          $status = $data["status_status_id"];
          $path = "";
          $imgRs = Database::search("SELECT `path` FROM `user_img` WHERE `user_email`='" . $email . "'");
          if ($imgRs->num_rows == 0) {
            $path = "img/userProfile/user.svg";
          } else {

            $imgData = $imgRs->fetch_assoc();

            $path = $imgData["path"];
          }
        ?>
          <div class="card m-3 p-0" style="width: 18rem;">
            <img src="<?php echo ($path); ?>" class=" img-fluid " alt="..." style="width: 300px; height: 200px;">
            <div class="card-body" onclick="goToUserDetails(<?php echo ($i) ?>);">
              <h5 class="card-title"><?php echo ($name); ?></h5>
              <p class="card-text m-0" id="<?php echo ($i) ?>"> <?php echo ($email); ?></p>
              <p class="card-text m-0"><?php echo ($mobile); ?></p>
              <p class="card-text m-0"><?php echo ($gender); ?></p>
              <p class="card-text m-0"><?php echo ($joined_date); ?>(Joined Date)</p>

            </div>
          </div>
        <?php

        }
        ?>
           <nav aria-label="Page navigation example ">
            <?php

            $mp = $page - 1;
            ?>
            <ul class="pagination justify-content-center">
              <li class="page-item <?php
                                    if ($page <= 1) {
                                      echo ("disabled");
                                    }
                                    ?>">
                <a class="page-link" href="manageUser.php?orderBy=<?php echo($orderBy);?>&page=<?php echo ($mp); ?>" aria-label="Previous">
                  <span aria-hidden="true">&laquo;</span>
                </a>
              </li>
              <li class="page-item"><a class="page-link" ><?php echo ($page); ?></a></li>
              <!-- <li class="page-item"><a class="page-link" href="#">2</a></li>
                                    <li class="page-item"><a class="page-link" href="#">3</a></li> -->
              <?php

              $pp = $page + 1;
              ?>
              <li class="page-item <?php
                                    if ($page >= $totPages) {
                                      echo ("disabled");
                                    }
                                    ?>">
                <a class="page-link" href="manageUser.php?orderBy=<?php echo($orderBy);?>&page=<?php echo ($pp); ?>" aria-label="Next">
                  <span aria-hidden="true">&raquo;</span>
                </a>
              </li>
            </ul>
          </nav>
      </div>
    </div>
    <script src="script.js"></script>
    <script src="bootstrap.bundle.js"></script>
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