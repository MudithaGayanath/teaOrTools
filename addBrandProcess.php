<?php
session_start();
if (isset($_SESSION["a"])) {
    include("connection.php");
    $name = $_POST["name"];
    if (empty($name)){
        echo("empty");
    }else if ( strlen($name) > 46 ){
        echo("long");
    }else{
        $rs = Database::search("SELECT * FROM `brand` WHERE `brand_name`='".$name."'");
        if ( $rs -> num_rows > 0){
            echo("have");
        }else{
            Database::iud("INSERT INTO `brand`(`brand_name`) VALUES ('".$name."')");
            echo ("' $name ' added successfully");
        }
    }
} else {
    ?>
        <script>
            alert("Illegal Admin  Access Denied");
            window.location = "index.php";
        </script>
    <?php
    }
?>