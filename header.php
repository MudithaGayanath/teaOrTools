<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap.css" />
    
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</head>
<body>
<nav class="navbar bg-body-tertiary navbar-expand-lg  sticky-top">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">Tea or Tools</a>
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
            <a class="nav-link "  href="index.php" id="h" >Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="userProfile.php" id="p" >Profile</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="myProducts.php" id="mp" >My Products</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#" id="ms" onclick="active(4);">My Sellings</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="cart.php" id="c" onclick="active(5);">Cart</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="wishList.php" id="wish" onclick="">Wish List</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="history.php" id="his" onclick="active(7);">History</a>
          </li>
          <!-- <li class="nav-item">
            <a class="nav-link" href="#" id="msg"></a>
          </li> -->
          <li class="nav-item">
            <a class="nav-link" href="#" id="hel" onclick="active(8);">Help</a>
          </li>
          <li class="nav-item">
            <?php
              if (isset($_SESSION["u"])){
                ?> <a class="nav-link text-danger"  onclick="logOut();">LogOut</a><?php
              }else {
                ?> <a class="nav-link text-success" id="log" href="login.php">LogIn</a><?php
              }
            ?>
           
          </li>
          
        </ul>
       
      </div>
    </div>
  </div>
</nav>

<script src="bootstrap.bundle.min.js"></script>
<script src="bootstrap.bundle.js"></script>
<script src="script.js"></script>
</body>
</html>