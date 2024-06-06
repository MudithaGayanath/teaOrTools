<?php
include("header.php");
include("connection.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap.css" />
    <link rel="stylesheet" href="style.css">
    <title>Advanced Search | Tea or Tools</title>
</head>

<body onload="active(1);">
    <div class="container-fluid p-2">
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
        <h1 class=" text-center">Advanced Search</h1>
        <div class="row">
            <div class="col-10 offset-1">
                <div class="input-group mb-3">
                    <input type="text" placeholder="Type Key word to Search" class="form-control" id="searchText" aria-label="Text input with dropdown button" />
                    <!-- <button class="btn btn-primary" type="button" id="button-addon2" >Search</button> -->
                </div>
            </div>
            <div class="col-12 col-md-4">
                <label for="categorie">Categorie</label>

                <select id="categorie" class=" form-select" onclick="changeBrand();">
                    <option value="0">Select Categorie</option>
                    <?php
                    $catRs = Database::search("SELECT * FROM `categorie`");
                    for ($i = 0; $i < $catRs->num_rows; $i++) {
                        $catData = $catRs->fetch_assoc();
                    ?>
                        <option value="<?php echo ($catData["categorie_id"]); ?>"><?php echo ($catData["categorie_name"]); ?></option>
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

            <div class="col-12">
                <div class="row m-3 justify-content-lg-end text-center">
                    <button class="btn btn-primary col-10 offset-1 col-lg-1 offset-lg-0  " onclick="advancedSearchProcess();">Search</button>
                    <button class="btn btn-close-white col-10 offset-1 col-lg-1 offset-lg-0" onclick="r();">Clear</button>
                </div>
            </div>

        </div>
        <!-- rs -->
        <div class="row mt-2 justify-content-center text-center border border-primary m-3" id="main">
            <div class="col-12">
                <div class=" display-1">N/A</div>
            </div>

        </div>

    </div>
    <?php
    include("footer.php");
    ?>

    <script src="jqery.min.js"></script>
    <script src="bootstrap.bundle.js"></script>
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
?>