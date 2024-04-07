<?php

    session_start();
    if ( isset($_SESSION["a"])){
        $_SESSION["a"] = null;
        
        echo("done");
    }

?>