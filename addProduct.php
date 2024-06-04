<?php
include("header.php");
include("connection.php");

if (isset($_SESSION["u"])) {
    $email = $_SESSION["u"]["email"];
    $addressRs = Database::search("SELECT * FROM `user_has_address` INNER JOIN `city` ON
        user_has_address.city_city_id=city.city_id WHERE `user_email`='" . $email . "'");
    if ($addressRs->num_rows > 0) {
        $addressData = $addressRs->fetch_assoc();
?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8" />
            <meta name="viewport" content="width=device-width, initial-scale=1.0" />
            <link rel="stylesheet" href="bootstrap.css" />
            <title>Add Product | Tea or Tools</title>
        </head>

        <body onload="active(3);">

            <div class="container-fluid">
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
                <div class=" text-center sticky-top d-none" id="spin">
                    <div class="spinner-border position-absolute text-primary" style="width: 8rem; height: 8rem;" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 text-center">
                        <h1 class=" ">Add Product</h1>
                    </div>
                </div>
                <div class="row ">
                    <div class="col-12">
                        <h3> Product Images</h3>
                    </div>
                    <div class="col-12">
                        <div class="row justify-content-center justify-content-lg-around">
                            <img src="img/empty.svg" style="width: 400px; height: 300px;" class=" border border-primary p-0 m-2 img-fluid " id="i0" />
                            <img src="img/empty.svg" style="width: 400px; height: 300px;" class=" border border-primary p-0 m-2 img-fluid " id="i1" />
                            <img src="img/empty.svg" style="width: 400px; height: 300px;" class=" border border-primary p-0 m-2 img-fluid " id="i2" />
                        </div>
                        <div class="row mt-1">
                            <div class="col-10 offset-1">
                                <label for="addImg" class=" btn btn-success form-control" onclick="addproductImg();">add Images</label>
                                <input type="file" id="addImg" multiple class=" d-none" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-12 col-md-4">
                                <label for="categorie">Categorie</label>

                                <select id="categorie" class=" form-select" onclick="changeBrand();">
                                    <option value="0">Select Categorie</option>
                                    <?php
                                    $categorieRs = Database::search("SELECT * FROM `categorie`");
                                    for ($i = 0; $i < $categorieRs->num_rows; $i++) {
                                        $categorieData = $categorieRs->fetch_assoc();
                                    ?>
                                        <option value="<?php echo ($categorieData["categorie_id"]); ?>"><?php echo ($categorieData["categorie_name"]); ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-12 col-md-4">
                                <label for="brand">Brand</label>
                                <select id="brand" class=" form-select " onclick="changeModel();">
                                    <option value="0">Select Brand</option>

                                </select>
                            </div>
                            <div class="col-12 col-md-4">
                                <label for="model">Model</label>
                                <select id="model" class=" form-select" onclick="changeColor();">
                                    <option value="0">Select Model</option>

                                </select>
                            </div>
                            <div class="col-12 col-md-6">
                                <label for="color">Colour</label>
                                <select id="color" class=" form-select">
                                    <option value="0">Select Colour</option>

                                </select>
                            </div>
                            <div class="col-12 col-md-6">
                                <label for="condition">Condition</label>
                                <select id="condition" class=" form-select">
                                    <option value="0">Select Condition</option>
                                    <?php
                                    $conditionRs = Database::search("SELECT * FROM `condition`");
                                    for ($i = 0; $i < $conditionRs->num_rows; $i++) {
                                        $conditionData = $conditionRs->fetch_assoc();
                                    ?>
                                        <option value="<?php echo ($conditionData["condition_id"]); ?>"><?php echo ($conditionData["condition_name"]); ?></option>
                                    <?php

                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <label for="title">Title</label>
                                <input type="text" id="title" class=" form-control" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <label for="ppi">Price Per Item</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text">Rs</span>
                                    <input type="number" class="form-control" id="ppi" aria-label="Amount (to the nearest dollar)">
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <label for="qty">Qty</label>
                                <input type="number" id="qty" class=" form-control" />
                            </div>
                            <div class="col-12 col-md-6">
                                <label for="diuc">Delivery In <?php
                                                                echo ($addressData["city_name"]);
                                                                ?> </label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text">Rs</span>
                                    <input type="number" class="form-control" id="diuc" aria-label="Amount (to the nearest dollar)">
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <label for="dofuc">Delivery Out Of <?php
                                                                    echo ($addressData["city_name"]);
                                                                    ?></label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text">Rs</span>
                                    <input type="number" class="form-control" id="dofuc" aria-label="Amount (to the nearest dollar)">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <label for="discription">Product Discription</label>
                        <textarea id="discription" cols="30" rows="10" class=" form-control"></textarea>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <h5>We are Charging 2% for your each item</h5>
                    </div>
                </div>
                <div class="row mb-5 mt-2">
                    <button class=" btn btn-primary col-10 offset-1" onclick="addProduct();">Add Product</button>
                </div>
            </div>
            </div>


            <!-- Model -->


            <!-- Address Modal -->


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
            alert("Add Your Addrss");
            window.location = ("userProfile.php");
        </script>
<?php
    }
} else {
    header("location:login.php");
}
?>