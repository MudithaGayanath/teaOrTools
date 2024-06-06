<?php
session_start();
if (isset($_SESSION["a"])) {
    include("connection.php");

    $mRs = Database::search("SELECT * FROM `model_has_color`");
    $tot = $mRs->num_rows;
    $resultPrePage = 10;
    $page = 1;
    if (isset($_GET["page"])) {
        $pNum = $_GET["page"];
        if ( $pNum <= 0 ){
            $page = 1;
        }else{

            $page = $_GET["page"];
        }
    } else {
        $page = 1;
    }

    $totPages = ceil($tot / $resultPrePage);
    
    $offset = ($page - 1) * $resultPrePage;
    
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="bootstrap.css">
        <link rel="stylesheet" href="style.css">
        <title>Models & Colors | Tea or Tools</title>
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
                                <a class="nav-link active" aria-current="page" href="adminPanale.php">Dashboard</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="manageUser.php">Manger Users</a>
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
        <div class=" container-fluid ">
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
            <h1>Models & Colors Table</h1>
            <div class="row">
                <div class="col-12 col-md-10 offset-md-1">
                    <?php
                    $rs = Database::search("SELECT * FROM `model_has_color` INNER JOIN color ON
                    model_has_color.color_color_id=color.color_id INNER JOIN model ON
                    model_has_color.model_model_id=model.model_id LIMIT " . $resultPrePage . " OFFSET " . $offset . " ");
                    if ($rs->num_rows > 0) {
                    ?>
                        <table class=" table table-hover table-striped text-center">
                            <thead>
                                <tr>
                                    <th> ID</th>
                                    <th> Color Name</th>
                                    <th> Model Name</th>
                                </tr>
                            </thead>
                            <tbody>


                                <?php
                                for ($i = 0; $i < $rs->num_rows; $i++) {
                                    $data = $rs->fetch_assoc();
                                    $id = $data["id"];
                                    $brandId = $data["color_name"];
                                    $categorieId = $data["model_name"];
                                ?>
                                    <tr>
                                        <td><?php echo ($id); ?></td>
                                        <td><?php echo ($brandId); ?></td>
                                        <td><?php echo ($categorieId); ?></td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                        <nav aria-label="Page navigation example ">
                            <?php

                            $mp = $page - 1;
                            ?>
                            <ul class="pagination justify-content-center">
                                <li class="page-item <?php
                                                        if ($page == 1) {
                                                            echo ("disabled");
                                                        }
                                                        ?>">
                                    <a class="page-link" href="modelAndColor.php?page=<?php echo ($mp); ?>" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                                <li class="page-item"><a class="page-link" ><?php echo ($page); ?></a></li>
                                <?php

                                $pp = $page + 1;
                                ?>
                                <li class="page-item <?php
                                                        if ($page == $totPages) {
                                                            echo ("disabled");
                                                        }
                                                        ?>">
                                    <a class="page-link" href="modelAndColor.php?page=<?php echo ($pp); ?>" aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    <?php
                    } else {
                    ?>
                        <h5>No Models & Colors found</h5>
                    <?php
                    }
                    ?>
                </div>

                <button class=" btn btn-danger mt-1 col-10 offset-1 col-md-2 offset-md-0  mt-md-0" onclick="goToPanel();">Back</button>
                <button class=" btn btn-primary mt-1 col-10 offset-1 col-md-2 offset-md-8 mt-md-0" onclick="addMandCModel() ;">Add Model & Color</button>
            </div>
        </div>
        <!-- model -->
        <div class="modal" tabindex="-1" id="addMandC">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Models & Colors to Table</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row"> 
                            <!-- cats -->
                            <div class="col-12">
                                <label for="model">Model name</label>
                                <select name=""id="model" class="  form-select">
                                    <?php
                                   $mRs = Database::search("SELECT * FROM `model`");
                                if ( $mRs -> num_rows > 0){
                                    for ($i=0; $i < $mRs -> num_rows ; $i++) {
                                        $mData = $mRs -> fetch_assoc();
                                        $mId= $mData["model_id"];
                                        $mName= $mData["model_name"];
                                        ?>
                                        <option value="<?php echo($mId)?>"><?php echo($mName)?></option>
                                        <?php
                                    }

                                }
                                    ?>
                                </select>
                            </div>
                            <div class="col-12">
                                <label for="color">Colors name</label>
                                <select name=""id="color" class="  form-select">
                                    <?php
                                   $cRs = Database::search("SELECT * FROM `color`");
                                if ( $cRs -> num_rows > 0){
                                    for ($i=0; $i < $cRs -> num_rows ; $i++) {
                                        $cData = $cRs -> fetch_assoc();
                                        $cId= $cData["color_id"];
                                        $cName= $cData["color_name"];
                                        ?>
                                        <option value="<?php echo($cId)?>"><?php echo($cName)?></option>
                                        <?php
                                    }

                                }
                                    ?>
                                </select>
                            </div>
                           
                        </div>
                    </div>
                    <div class="modal-footer">
                        <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> -->
                        <button type="button" class="btn btn-primary" onclick="addMandC();">Add</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- model -->
        <?php
        include("footer.php");
        ?>
        <script src="bootstrap.bundle.js"></script>
        <script src="script.js"></script>
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