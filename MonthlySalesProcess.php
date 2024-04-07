<?php
    session_start();
    include("connection.php");
    if ( isset($_SESSION["a"]) && $_SERVER["REQUEST_METHOD"] == "POST"){
        $months[0] =0;
        $months[1] =0;
        $months[2] =0;
        $months[3] =0;
        $months[4] =0;
        $months[5] =0;
        $months[6] =0;
        $months[7] =0;
        $months[8] =0;
        $months[9] =0;
        $months[10] =0;
        $months[11] =0;
      
        $sellsRs = Database::search("SELECT * FROM `invoice`");
        $tdate = new DateTime();
        $tz = new DateTimeZone("Asia/Colombo");
        $tdate->setTimezone($tz);
        $day = $tdate->format("Y-m-d H:i:s") ;

        $sliptMonth = explode("-",$day);
        $thisMonth = $sliptMonth["1"];

        for ($i=0; $i < $sellsRs -> num_rows; $i++) { 
           $invoiceData = $sellsRs -> fetch_assoc();
           $sellDate = $invoiceData["date_time"];
           $sliptSellDate = explode("-",$sellDate);
           $sellMonth = $sliptSellDate["1"];

           if ( $sellMonth == 1){
             $months[0] = $months[0] + $invoiceData["total"];
           }
           else if ( $sellMonth == 2){
             $months[1] = $months[1] + $invoiceData["total"];
           }
           else if ( $sellMonth == 3){
             $months[2] = $months[2] + $invoiceData["total"];
           }
           else if ( $sellMonth == 4){
             $months[3] = $months[3] + $invoiceData["total"];
           }
           else if ( $sellMonth == 5){
             $months[4] = $months[4] + $invoiceData["total"];
           }
           else if ( $sellMonth == 6){
             $months[5] = $months[5] + $invoiceData["total"];
           }
           else if ( $sellMonth == 7){
             $months[6] = $months[6] + $invoiceData["total"];
           }
           else if ( $sellMonth == 8){
             $months[7] = $months[7] + $invoiceData["total"];
           }
           else if ( $sellMonth == 9){
             $months[8] = $months[8] + $invoiceData["total"];
           }
           else if ( $sellMonth == 10){
             $months[9] = $months[9] + $invoiceData["total"];
           }
           else if ( $sellMonth == 11){
             $months[10] = $months[10] + $invoiceData["total"];
           }
           else if ( $sellMonth == 12){
             $months[11] = $months[11] + $invoiceData["total"];
           }

          
           
        }
        for ($x=0; $x < $thisMonth; $x++) { 
         $arry[$x] = $months[$x];
        }
        
        echo(json_encode($arry));
    }else {
        header("location:index.php");
    }
    
?>