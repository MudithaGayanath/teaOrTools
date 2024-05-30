<?php
session_start();
if (isset($_SESSION["a"])) {
    include("connection.php");

    $mRs = Database::search("SELECT * FROM `brand_has_categorie`");
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
        <title>Brands & Categories | Tea or Tools</title>
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
            <h1>Brands & Categories Table</h1>
            <div class="row">
                <div class="col-12 col-md-10 offset-md-1">
                    <?php
                    $rs = Database::search("SELECT * FROM `brand_has_categorie` INNER JOIN brand ON
                    brand_has_categorie.brand_brand_id=brand.brand_id INNER JOIN categorie ON
                    brand_has_categorie.categorie_categorie_id=categorie.categorie_id LIMIT " . $resultPrePage . " OFFSET " . $offset . " ");
                    if ($rs->num_rows > 0) {
                    ?>
                        <table class=" table table-hover table-striped text-center">
                            <thead>
                                <tr>
                                    <th> ID</th>
                                    <th> Brand Name</th>
                                    <th> Categorie Name</th>
                                </tr>
                            </thead>
                            <tbody>


                                <?php
                                for ($i = 0; $i < $rs->num_rows; $i++) {
                                    $data = $rs->fetch_assoc();
                                    $id = $data["id"];
                                    $brandId = $data["brand_name"];
                                    $categorieId = $data["categorie_name"];
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
                                    <a class="page-link" href="brandAndCat.php?page=<?php echo ($mp); ?>" aria-label="Previous">
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
                                    <a class="page-link" href="brandAndCat.php?page=<?php echo ($pp); ?>" aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    <?php
                    } else {
                    ?>
                        <h5>No Brands & Categories found</h5>
                    <?php
                    }
                    ?>
                </div>

                <button class=" btn btn-danger mt-1 col-10 offset-1 col-md-2 offset-md-0  mt-md-0" onclick="goToPanel();">Back</button>
                <button class=" btn btn-primary mt-1 col-10 offset-1 col-md-2 offset-md-8 mt-md-0" onclick="addBandCModel() ;">Add Brand & Categorie</button>
            </div>
        </div>
        <!-- model -->
        <div class="modal" tabindex="-1" id="addBandC">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Brands & Categories to Table</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <label for="brand">Brands name</label>
                                <select name=""id="brand" class="  form-select">
                                    <?php
                                   $bRs = Database::search("SELECT * FROM `brand`");
                                if ( $bRs -> num_rows > 0){
                                    for ($i=0; $i < $bRs -> num_rows ; $i++) {
                                        $bData = $bRs -> fetch_assoc();
                                        $bId= $bData["brand_id"];
                                        $bName= $bData["brand_name"];
                                        ?>
                                        <option value="<?php echo($bId)?>"><?php echo($bName)?></option>
                                        <?php
                                    }

                                }
                                    ?>
                                </select>
                            </div>
                            <!-- cats -->
                            <div class="col-12">
                                <label for="categorie">Categorie name</label>
                                <select name=""id="categorie" class="  form-select">
                                    <?php
                                   $cRs = Database::search("SELECT * FROM `categorie`");
                                if ( $cRs -> num_rows > 0){
                                    for ($i=0; $i < $cRs -> num_rows ; $i++) {
                                        $cData = $cRs -> fetch_assoc();
                                        $cId= $cData["categorie_id"];
                                        $cName= $cData["categorie_name"];
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
                        <button type="button" class="btn btn-primary" onclick="addBandC();">Add</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- model -->
        <script src="bootstrap.bundle.js"></script>
        <script src="script.js"></script>
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