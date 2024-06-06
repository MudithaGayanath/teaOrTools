<?php
session_start();
if (isset($_SESSION["u"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
    include("connection.php");
    $email = $_SESSION["u"]["email"];
    $userAddressRs = Database::search("SELECT * FROM `user_has_address` INNER JOIN `city` ON
    user_has_address.city_city_id=city.city_id WHERE `user_email`='" . $email . "'");

    if ($userAddressRs->num_rows > 0) {
        $cartRs = Database::search("SELECT * FROM `cart` WHERE `cart`.`user_email`='" . $email . "'");
        if ($cartRs->num_rows > 0) {
            $fname = $_SESSION["u"]["fname"];
            $lname = $_SESSION["u"]["lname"];
            $mobile = $_SESSION["u"]["mobile"];
            $userAddressData = $userAddressRs->fetch_assoc();
            $userAddress = $userAddressData["line1"] . "," . $userAddressData["line2"];
            $userCity = $userAddressData["city_name"];

            $productTitle = "";
            $buyQty = 0;
            $tot = 0;

            for ($i = 0; $i < $cartRs->num_rows; $i++) {
                $cartData = $cartRs->fetch_assoc();
                $ppid = $cartData["product_product_id"];
                $buyQty = $cartData["qty"];

                $productRs = Database::search("SELECT * FROM `product` 
                INNER JOIN `user_has_address` ON product.user_email=user_has_address.user_email
                INNER JOIN `city` ON user_has_address.city_city_id=city.city_id   WHERE `product_id`='" . $ppid . "'");
                $productData = $productRs->fetch_assoc();
                $pTitle = $productData["title"];
                $invoiceTitle["title".$i] = $pTitle;
                
                    $productTitle .=$pTitle ." , "; 
               
                $price = $productData["price"];
                $sellerCity = $productData["city_name"];
                $delevery = 0;

                if ($userCity == $sellerCity) {
                    $delevery = $productData["delevery_in_user_city"];
                } else {
                    $delevery = $productData["delevery_outof_usre_city"];
                }

                $tot = $tot + (($buyQty * $price) + $delevery);
                $invoicePid["pid".$i] = $ppid;
                $invoicePrice["price".$i] = $price;
                $invoiceDeleveryPrice["delever".$i] = $delevery;
                $invoiceQty["qty".$i] = $buyQty;
                $invoiceTot["tot".$i] = ($buyQty * $price) + $delevery;
                
            }
            $merchantId = "1226127";
            $merchantSecret = "Mjk5Mjk3NDQ0NzMzNjY5MzU3ODkyOTAzODU3MDUxMTY4NTUyODg1";
            $currency = "LKR";
            $orderId = uniqid();
            $hash = strtoupper(
                md5(
                    $merchantId .
                        $orderId .
                        number_format($tot, 2, '.', '') .
                        $currency .
                        strtoupper(md5($merchantSecret))
                )
            );
            $array["orderId"] = $orderId;
            $array["productTitle"] = $productTitle;
            $array["total"] = $tot;
            $array["fname"] = $fname;
            $array["lanme"] = $lname;
            $array["mobile"] = $mobile;
            $array["address"] = $userAddress;
            $array["city"] = $userCity;
            $array["email"] = $email;
            $array["mid"] = $merchantId;
            $array["msecret"] = $merchantSecret;
            $array["currency"] = $currency;
            $array["hash"] = $hash;
            $_SESSION["buyAll"] = $orderId;

            $_SESSION["invoicePid"] = $invoicePid;
            $_SESSION["invoiceQty"] = $invoiceQty;
            $_SESSION["invoiceTot"] = $invoiceTot;
            $_SESSION["invoicePrice"] = $invoicePrice;
            $_SESSION["invoiceDelevery"] = $invoiceDeleveryPrice;
            $_SESSION["invoiceTitle"] = $invoiceTitle;
            echo (json_encode($array));
        } else {
            header("Location:index.php");
        }
    } else {
        echo ("noAddress");
    }
} else {
    header("Location:index.php");
}
