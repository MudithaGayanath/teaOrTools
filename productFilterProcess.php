<?php
session_start();
include("connection.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_SESSION["a"])) {
        $a = $_POST["p"];
        $query = "SELECT * FROM `product` INNER JOIN `condition` ON 
        product.condition_condition_id=condition.condition_id ";
        if ($a == 1) {
            $query .= " ORDER BY `add_date_time` DESC ";
        } else if ($a == 2) {
            $query .= " ORDER BY `add_date_time` ASC ";
        } else if ($a == 3) {
            $query .= " WHERE `status_status_id`='1' ";
        } else if ($a == 4) {
            $query .= " WHERE `status_status_id`='2' ";
        }
        $productRs= Database::search($query);
        if ( $productRs -> num_rows == 0){
            ?>
            <div class="col-12 text-center">
                <h1>No product found</h1>
            </div>
            <?php
        }else{

       
        for ($i = 0; $i < $productRs->num_rows; $i++) {
            $productData = $productRs->fetch_assoc();
            $ownerRs = Database::search("SELECT * FROM `user` WHERE `email`='".$productData["user_email"]."'");
            $ownerData = $ownerRs ->fetch_assoc();
            $productOwner = $ownerData["fname"] . " " . $ownerData["lname"];
            $productId = $productData["product_id"];
            $imgRs = Database::search("SELECT * FROM `product_img` WHERE `product_product_id`='" . $productId . "'");
            $imgData = $imgRs->fetch_assoc();
            $path = $imgData["path"];
            $status = $productData["status_status_id"];
          ?>
            <div class="col-11 offset-1 ps-5 ms-5 mt-2 mb-2 col-sm-6 offset-sm-0 ms-sm-0  col-lg-4 col-xl-3 ps-md-5 pt-0">
              <div class="card" style="width: 18rem;">
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
  
                  <?php
                  if ($status == "1") {
                  ?>
                    <button class=" btn btn-primary col-10 offset-1" onclick="changeProductStatusByAdmin(<?php echo ($productId); ?>);">Active</button>
  
                  <?php
                  } else if ($status == "2") {
                  ?>
                    <button class=" btn btn-danger col-10 offset-1" onclick="changeProductStatusByAdmin(<?php echo ($productId); ?>);">Inactive</button>
  
                  <?php
                  }
                  ?>
  
                </div>
              </div>
            </div>
          <?php
          }
        }
          
    }}

?>