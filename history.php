<?php
include("header.php");
if (isset($_SESSION["u"])) {
  include("connection.php");
  $email = $_SESSION["u"]["email"];

  $mRs = Database::search("SELECT * FROM `invoice` WHERE `cou_user_email`='" . $email . "'");
  $tot = $mRs->num_rows;
  $resultPrePage = 10;
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

  $invoiceRs = Database::search("SELECT * FROM `invoice` INNER JOIN `product` ON 
        invoice.product_id=product.product_id INNER JOIN `order_status` ON
        invoice.status_id=order_status.order_status_id WHERE `cou_user_email`='" . $email . "'  ORDER BY `date_time` ".$orderBy." LIMIT " . $resultPrePage . " OFFSET " . $offset . "  ");
?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap.css" />
    <link rel="stylesheet" href="style.css">
    <title>History | Tea or Tools</title>
  </head>

  <body onload="active(7);salesAlert();">
    <div class=" container-fluid">
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
      <h1 class=" text-center">History</h1>
      <p>You can add your feedback when order is Deliverd</p>
      <div class="row justify-content-end">
        <div class="col-12 col-md-3">

          <select id="filter" class=" form-select" onclick="historyFilter();">
            <option value="1" 
            <?php  if ( isset($_GET["orderBy"])){
              $o = $_GET["orderBy"];
              if ( $o=="DESC"){
                ?> selected <?php
              }
            }?>
            >Newest to oldest</option>
            <option value="2"
            <?php  if ( isset($_GET["orderBy"])){
              $o = $_GET["orderBy"];
              if ( $o=="ASC"){
                ?> selected <?php
              }
            }?>
            >Oldest to newest</option>
            <option value="3">Pending Only</option>
            <option value="4">Processing Only</option>
            <option value="5">Shiped Only</option>
            <option value="6">Deliverd Only</option>
          </select>
        </div>
      </div>
      <div class="row justify-content-center justify-content-lg-around d-none" id="rs"></div>
      <div class="row justify-content-center justify-content-lg-around" id="main">
        <?php
        if ($invoiceRs->num_rows > 0) {
          for ($i = 0; $i < $invoiceRs->num_rows; $i++) {
            $data = $invoiceRs->fetch_assoc();
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
            <div class="card m-3 p-0" style="width: 18rem;" <?php if ( $status == 4 ) {
              ?>
               onclick="feedModel(<?php echo ($pId); ?>);"
              <?php
            }?>>
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
                <a class="page-link" href="history.php?orderBy=<?php echo($orderBy);?>&page=<?php echo ($mp); ?>" aria-label="Previous">
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
                <a class="page-link" href="history.php?orderBy=<?php echo($orderBy);?>&page=<?php echo ($pp); ?>" aria-label="Next">
                  <span aria-hidden="true">&raquo;</span>
                </a>
              </li>
            </ul>
          </nav>
        <?php
        } else {
        ?>
          <p class=" display-1 text-center">N/A</p>
        <?php
        }
        ?>
      </div>
    </div>
    <?php
    include("footer.php");
    ?>
    <div class="modal" tabindex="-1" id="feedModel">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Feedback</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-12">
            <label for="comment">Comment</label>
            <textarea name="" class=" form-control" id="comment" cols="30" rows="5"></textarea>
          </div>
        </div>
        <div class="col-12">
          <label for="type">Type</label>
          <select name="" id="type" class=" form-select">
            <option value="1">Good</option>
            <option value="2">Neutral</option>
            <option value="3">Bad</option>
          </select>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="addFeedProcess();">Add Feedback</button>
      </div>
    </div>
  </div>
</div>
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
  header("location:login.php");
}
?>