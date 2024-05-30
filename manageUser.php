<?php
session_start();
if (isset($_SESSION["a"])) {
  include("connection.php");



?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap.css">
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
                <a class="nav-link" href="#">History</a>
              </li>
              <li class="nav-item">
                <a class="nav-link text-danger" href="#" onclick="adminLogout();">LogOut</a>
              </li>

            </ul>

          </div>
        </div>
      </div>
    </nav>
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
            <option value="1">Newest to oldest</option>
            <option value="2">Oldest to newest</option>
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
        $userRs = Database::search("SELECT * FROM `user` INNER JOIN `gender` ON
      user.gender_gender_id=gender.gender_id INNER JOIN `status` ON
      user.status_status_id=status.status_id ORDER BY `joined_date` DESC ");
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
            <img src="<?php echo ($path); ?>" class=" img-fluid " alt="..." style="width: 300px; height: 200px;" >
            <div class="card-body">
              <h5 class="card-title"><?php echo ($name); ?></h5>
              <p class="card-text m-0" id="<?php echo ($i) ?>"> <?php echo ($email); ?></p>
              <p class="card-text m-0"><?php echo ($mobile); ?></p>
              <p class="card-text m-0"><?php echo ($gender); ?></p>
              <p class="card-text m-0"><?php echo ($joined_date); ?>(Joined Date)</p>
              <div class="row">

              <?php
              if ($status == 1) {
              ?>
                <button class="btn btn-primary col-10 offset-1 mt-2" onclick="changeUserStatus(<?php echo ($i); ?>)">Active</button>
              <?php
              } else {
              ?>
                <button class="btn btn-danger col-10 offset-1 mt-2" onclick="changeUserStatus(<?php echo ($i); ?>)">Inactive</button>

              <?php
              }
              ?>
              </div>
            </div>
          </div>
        <?php

        }
        ?>
      </div>
    </div>
    <script src="script.js"></script>
    <script src="bootstrap.bundle.js"></script>
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