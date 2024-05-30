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
    <title>Advanced Search | Tea or Tools</title>
</head>

<body onload="active(1);">
    <div class="container-fluid p-2">
        <h1 class=" text-center">Advanced Search</h1>
        <div class="row">
            <div class="col-12">
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
            
            <button class=" col-10 offset-1 mt-2 col-md-4 offset-md-8  btn btn-primary " onclick="advancedSearchProcess();">Search</button>
            
        </div>
        <!-- rs -->
        <div class="row mt-2 justify-content-center text-center border border-primary m-3" id="main">
            <div class="col-12">
                <div class=" display-1">N/A</div>
            </div>
            
        </div>

    </div>
    <script src="script.js"></script>
    <script src="bootstrap.bundle.js"></script>
</body>

</html>
<?php
?>