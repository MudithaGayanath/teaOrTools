<?php
    session_start();
    if ( isset($_SESSION["u"])){
        if ( $_SERVER["REQUEST_METHOD"] == "POST"){
            include("connection.php");
            $email = $_SESSION["u"]["email"];
            $userAddressRs = Database::search("SELECT * FROM `user_has_address` INNER JOIN `city` ON
            user_has_address.city_city_id=city.city_id WHERE `user_email`='".$email."'");
            if ( $userAddressRs -> num_rows > 0 ){
                $userAddressData = $userAddressRs -> fetch_assoc();
                $userAddress = $userAddressData["line1"] .",".$userAddressData["line2"];
                $fname = $_SESSION["u"]["fname"];
                $lname = $_SESSION["u"]["lname"];
                $mobile = $_SESSION["u"]["mobile"];
                $city = $userAddressData["city_name"];
                $orderId = uniqid();
                $pid = $_POST["pid"];
                $tot = (int)$_POST["tot"];
                $qty = $_POST["qty"];
                $deliveryFee = $_POST["deliveryFee"];

                if ( $qty == 0 ){
                    echo("iqty");
                }
                else if ( empty($qty)){
                    echo("noQt");
                }
                else if ( $qty < 0 ){
                    echo("iqty");
                } 
                else if ( empty($deliveryFee)){
                    echo("address");
                }else if ( $deliveryFee == 0 ){
                    echo("address");
                }else {
                    $productRs = Database::search("SELECT * FROM `product` WHERE `product_id`='".$pid."'");
                    if ( $productRs -> num_rows > 0){
                        $productData = $productRs -> fetch_assoc();
                        if ( $productData["user_email"] == $email ){
                            echo("self");
                        }
                        else if ( $qty > $productData["qty"]){
                            echo("over");
                        }
                        else {
                            $productTitle = $productData["title"];
                            $newTot = ((int)$qty * (int)$productData["price"]) + (int)$deliveryFee;
                            $merchantId = "1226127";
                            $merchantSecret="Mjk5Mjk3NDQ0NzMzNjY5MzU3ODkyOTAzODU3MDUxMTY4NTUyODg1";
                            $currency ="LKR";
                            $hash = strtoupper(
                                md5(
                                    $merchantId . 
                                    $orderId . 
                                    number_format($newTot, 2, '.', '') . 
                                    $currency .  
                                    strtoupper(md5($merchantSecret)) 
                                ) 
                            );
                            $array["orderId"] = $orderId;
                            $array["productTitle"] = $productTitle;
                            $array["total"] = $newTot;
                            $array["fname"] = $fname;
                            $array["lanme"] = $lname;
                            $array["mobile"] = $mobile;
                            $array["address"] = $userAddress;
                            $array["city"] = $city;
                            $array["email"] = $email;
                            $array["mid"] = $merchantId;
                            $array["msecret"] = $merchantSecret;
                            $array["currency"] = $currency;
                            $array["hash"] = $hash;

                            echo(json_encode($array));
                            
                        }


                        
                    }else {
                        echo("worng");
                    }
                    
                }
            }else {
                echo("address");
            }
            
            
        }else{
            header("location:index.php");
        }
    }else{
        echo("log");
    }
?>