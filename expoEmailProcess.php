<?php
session_start();
if (isset($_SESSION["a"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
    include("connection.php");
    $email = $_POST["email"];
    
    $spEmail = explode(" ",$email);
    echo($spEmail[1]);
       
    
} else {
    ?>
        <script>
            alert("Illegal Admin  Access Denied");
            window.location = "index.php";
        </script>
    <?php
    }
?>