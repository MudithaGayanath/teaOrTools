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
                <a class="nav-link " href="manageUser.php">Manger Users</a>
              </li>
              <li class="nav-item">
                <a class="nav-link active" href="manageProducts.php">Manger Products</a>
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
      <h1 class=" text-center">Manage Products</h1>
      <!-- header -->
      <div class="row mt-2 justify-content-center">

        <div class="col-12 col-md-8">
          <div class="input-group mb-3">
            <select id="pCat" class="btn btn-close-white border border-secondary" onclick="">
              <option value="0">Owner Name</option>
              <option value="1">Product Name</option>

            </select>
            <input type="text" placeholder="Search in Tea or Tools" class="form-control" id="searchText" aria-label="Text input with dropdown button" />
            <button class="btn btn-primary  rounded-end-3" type="button" id="button-addon2" onclick="searchProduct();">Search</button>
            <button class="btn btn-close-white" type="button" id="button-addon2" onclick="window.location.reload();">Clear</button>
          </div>
        </div>

      </div>
      <div class="row justify-content-end">
        <div class="col-12 col-md-3">

          <select id="productFilter" class=" form-select" onclick="productFilter();">
            <option value="1">Newest to oldest</option>
            <option value="2">Oldest to newest</option>
            <option value="3">Active Only</option>
            <option value="4">Inactive Only</option>
          </select>
        </div>
      </div>
      <!-- header -->
      <!-- filterRS -->
      <div class="row justify-content-center justify-content-lg-around d-none" id="filterResultRowPro">

      </div>
      <!-- filterRS -->
      <div class="row justify-content-center justify-content-lg-around" id="mainRowPro">
        <!-- ertert -->
        <?php
        $productRs = Database::search("SELECT * FROM `product` INNER JOIN `condition` ON 
        product.condition_condition_id=condition.condition_id  ORDER BY `add_date_time` DESC");
        for ($i = 0; $i < $productRs->num_rows; $i++) {
          $productData = $productRs->fetch_assoc();
          $ownerRs = Database::search("SELECT * FROM `user` WHERE `email`='" . $productData["user_email"] . "'");
          $ownerData = $ownerRs->fetch_assoc();
          $productOwner = $ownerData["fname"] . " " . $ownerData["lname"];
          $productId = $productData["product_id"];
          $imgRs = Database::search("SELECT * FROM `product_img` WHERE `product_product_id`='" . $productId . "'");
          $imgData = $imgRs->fetch_assoc();
          $path = $imgData["path"];

        ?>
          <div class="card p-0 m-3" style="width: 18rem;" onclick="productDetails(<?php echo ($productId) ?>)">
            <img src="<?php echo ($path); ?>" class=" img-fluid" alt="..." style="width: 300px; height: 200px;" />
            <div class="card-body">
              <h4><?php echo ($productData["title"]); ?></h4>
              <p class=" mb-0"><?php echo ($productOwner); ?> (Owner)</p>
              <span class="badge <?php if ($productData["condition_id"] == 1) {
                                  ?>text-bg-primary<?php
                                                    } else {
                                                      ?> text-bg-secondary<?php
                                                                        } ?> "><?php echo ($productData["condition_name"]); ?></span>

              <p class=" mb-0">Rs: <?php echo ((float) $productData["price"]) ?>.00</p>

              <p class=" mb-0">In Stock</p>
              <p class=" mb-0"><?php echo ($productData["qty"]); ?> Items Left</p>



            </div>
          </div>
        <?php
        }
        ?>

        <!-- ertert -->

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