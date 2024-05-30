<?php
session_start();
include("connection.php");

if (isset($_SESSION["u"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_SESSION["u"]["email"];
    $p = $_POST["p"];
    $query = "SELECT * FROM `invoice` INNER JOIN `product` ON 
    invoice.product_id=product.product_id INNER JOIN `order_status` ON
    invoice.status_id=order_status.order_status_id ";
    
    
    if ( $p == 3){
        $query .= " WHERE `cou_user_email`='" . $email . "' AND `order_status_id`='1' ORDER BY `date_time` DESC ";
    }
    else if ( $p == 4){
        $query .= " WHERE `cou_user_email`='" . $email . "' AND `order_status_id`='2' ORDER BY `date_time` DESC ";
    }
    else if ( $p == 5){
        $query .= " WHERE `cou_user_email`='" . $email . "' AND `order_status_id`='3' ORDER BY `date_time` DESC ";
    }
    else if ( $p == 6){
        $query .= " WHERE `cou_user_email`='" . $email . "' AND `order_status_id`='4' ORDER BY `date_time` DESC ";
    }

    $rs = Database::search($query);
    if( $rs -> num_rows > 0 ){
        for ($i = 0; $i < $rs->num_rows; $i++) {
            $data = $rs->fetch_assoc();
            $pId = $data["product_id"];
            $pName = $data["title"];
            $orderId = $data["order_id"];
            $qty = $data["buy_qty"];
            $totle = $data["total"];
            $date = $data["date_time"];
            $status = $data["status_id"];

            $imgRs = Database::search("SELECT * FROM `product_img` WHERE `product_product_id`='" . $pId . "' ");
            $imgData = $imgRs->fetch_assoc();
            $path = $imgData["path"];
        ?>
            <div class="card m-3 p-0" style="width: 18rem;">
              <img src="<?php echo ($path); ?>" class=" img-fluid" alt="..." style="width: 300px; height: 200px;" />
              <div class="card-body">
                <h5 class="card-title">Title : <?php echo ($pName); ?></h5>
                <p class="p m-0">Order ID : <?php echo ($orderId); ?></p>
                <p class="p m-0">QTY : <?php echo ($qty); ?></p>
                <p class="p m-0">Amount : <?php echo ($totle); ?>.00</p>
                <p class="p m-0">Date&Time : <?php echo ($date); ?></p>
                <?php
                if ($status == 1) {
                ?>
                <button class=" btn btn-primary col-10 offset-1 mt-2 mb-1" ><?php echo($data["status_name"]);?></button>
                <?php
                } 
                else if ( $status == 2 ) {
                  ?>
                <button class=" btn btn-success col-10 offset-1 mt-2 mb-1" ><?php echo($data["status_name"]);?></button>
                <?php
                }
                else if ( $status == 3 ) {
                  ?>
                <button class=" btn btn-warning col-10 offset-1 mt-2 mb-1" ><?php echo($data["status_name"]);?></button>
                <?php
                }
                else if ( $status == 4 ) {
                  ?>
                <button class=" btn btn-danger col-10 offset-1 mt-2 mb-1" ><?php echo($data["status_name"]);?></button>
                <?php
                }
                ?>

              </div>
            </div>
          <?php
          }
          
    }else {
        ?>
        <h1>No order found</h1>
        <?php
    }

} else {
?>
    <script>
        window.location = "login.php";
    </script>
<?php
}
?>