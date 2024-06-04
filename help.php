<?php
include("header.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="bootstrap.css" />
    <title>Help | Tea or Tools</title>
</head>

<body onload="active(9);">

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
        <h1>Buy</h1>
        <h5>You can use following test card numbers to test simulated successful payments.</h5>
        <div class="row justify-content-center text-center">
            <div class="card m-3" style="width: 18rem;">

                <div class="card-body ">
                    <h5 class="card-title">Visa </h5>
                    <p class="card-text m-1">Card NO - 4916217501611292 </p>
                    <p class="card-text m-1">CVV - 123 </p>
                    <p class="card-text m-1">Expir - 12/26 </p>
                </div>
            </div>
            <div class="card m-3" style="width: 18rem;">

                <div class="card-body ">
                    <h5 class="card-title">MasterCard </h5>
                    <p class="card-text m-1">Card NO - 5307732125531191 </p>
                    <p class="card-text m-1">CVV - 123 </p>
                    <p class="card-text m-1">Expir - 12/26 </p>
                </div>
            </div>
        </div>


    </div>
    <?php
    include("footer.php");
    ?>
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