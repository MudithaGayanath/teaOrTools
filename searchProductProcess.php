<?php
session_start();
include("connection.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_SESSION["a"])) {
        $productRS = "";
        $cat = $_POST["cat"];
        $text = $_POST["text"];
        if (empty($text)) {
            echo ("empty");
        } else {
            $query = "";
            if ($cat == 0) {
                $sText = explode(" ", $text);
                if (isset($sText[0])) {
                    $query .= ("SELECT `email` FROM `user` WHERE `fname` LIKE '%" . $sText[0] . "%' ");
                } else if (isset($sText[1])) {
                    $query .= ("SELECT `email` FROM `user`  WHERE `fname` LIKE '%" . $sText[0] . "%' AND `lname` LIKE '%" . $sText[1] . "%' ");
                }
                $userRS = Database::search($query);
                if ($userRS->num_rows == 0) {
?>
                    <div class="col-12 text-center">
                        <h1>No product found</h1>
                    </div>
                    <?php
                } else {
                    $userData = $userRS->fetch_assoc();
                    $e = $userData["email"];
                    $productRs = Database::search("SELECT * FROM `product` INNER JOIN `condition` ON 
                    product.condition_condition_id=condition.condition_id WHERE `user_email`='" . $e . "'  ORDER BY `add_date_time` DESC");

                    if ($productRs->num_rows == 0) {
                    ?>
                        <div class="col-12 text-center">
                            <h1>No product found</h1>
                        </div>
                        <?php
                    } else {
                        for ($i = 0; $i < $productRs->num_rows; $i++) {
                            $productData = $productRs->fetch_assoc();
                            $ownerRs = Database::search("SELECT * FROM `user` WHERE `email`='" . $productData["user_email"] . "'");
                            $ownerData = $ownerRs->fetch_assoc();
                            $productOwner = $ownerData["fname"] . " " . $ownerData["lname"];
                            $productId = $productData["product_id"];
                            $imgRs = Database::search("SELECT * FROM `product_img` WHERE `product_product_id`='" . $productId . "'");
                            $imgData = $imgRs->fetch_assoc();
                            $path = $imgData["path"];
                            $status = $productData["status_status_id"];
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
                    }
                }
            } else {
                $productRs = Database::search("SELECT * FROM `product` INNER JOIN `condition` ON 
                product.condition_condition_id=condition.condition_id WHERE `title` LIKE '%" . $text . "%'");
                if ($productRs->num_rows > 0) {
                    // 
                    for ($i = 0; $i < $productRs->num_rows; $i++) {
                        $productData = $productRs->fetch_assoc();
                        $ownerRs = Database::search("SELECT * FROM `user` WHERE `email`='" . $productData["user_email"] . "'");
                        $ownerData = $ownerRs->fetch_assoc();
                        $productOwner = $ownerData["fname"] . " " . $ownerData["lname"];
                        $productId = $productData["product_id"];
                        $imgRs = Database::search("SELECT * FROM `product_img` WHERE `product_product_id`='" . $productId . "'");
                        $imgData = $imgRs->fetch_assoc();
                        $path = $imgData["path"];
                        $status = $productData["status_status_id"];
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
                    // 
                } else {
                    ?>
                    <div class="col-12 text-center">
                        <h1>No product found</h1>
                    </div>
<?php
                }
            }
        }
    }
}
