<?php
    session_start();
    if ( isset($_SESSION["a"])){
        include("connection.php");
        $invoiceRs = Database::search("SELECT * FROM `invoice`");
        $tdate = new DateTime();
        $tz = new DateTimeZone("Asia/Colombo");
        $tdate->setTimezone($tz);
        $day = $tdate->format("Y-m-d H:i:s") ;

        $sliptMonth = explode("-",$day);

        
        $tot = "0";

        $jan="01";
        $janTot ="0";

        $feb="02";
        $febTot="0";

        $march="03";
        $marchTot="0";

        $april="04";
        $aprilTot="0";

        $may="05";
        $mayTot="0";

        $june="06";
        $juneTot="0";

        $april="04";
        $aprilTot="0";

        for ($i=0; $i < $invoiceRs -> num_rows ; $i++) { 
            $invoiceData = $invoiceRs -> fetch_assoc();
            $sliptInMonth = explode("-" , $invoiceData["date_time"]);
            $inMonth = $sliptInMonth["1"];
            if ( $inMonth < 7 ){
                if ( $inMonth == $jan ){
                    $janTot = $janTot + $invoiceData["total"];
                }else if ( $inMonth == $feb ){
                    $febTot = $febTot + $invoiceData["total"];
                }else if ( $inMonth == $march ){
                    $marchTot = $marchTot + $invoiceData["total"];
                }else if ( $inMonth == $april ){
                    $aprilTot = $aprilTot + $invoiceData["total"];
                }else if ( $inMonth == $may ){
                    $mayTot = $mayTot + $invoiceData["total"];
                }else if ( $inMonth == $june ){
                    $juneTot = $juneTot + $invoiceData["total"];
                }
            }else {

            }
            
            
        }
        $array["jan"] = $janTot; 
        $array["feb"] = $febTot; 
        $array["mar"] = $marchTot; 
        $array["apr"] = $aprilTot; 
        $array["may"] = $mayTot; 
        $array["june"] = $juneTot; 
        echo(json_encode($array));
    }
    
?>