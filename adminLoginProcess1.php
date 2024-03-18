<?php
   include ("SMTP.php");
   include ("PHPMailer.php");
   include ("Exception.php");
   
   use PHPMailer\PHPMailer\PHPMailer;
    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        include("connection.php");
        $email = $_POST["e"];
        $password = $_POST["pw"];

        if ( empty($email)){
            echo ("Please Enter Your Email Address.");
        }else if (!filter_var($email,FILTER_VALIDATE_EMAIL)){
            echo ("Invalid Email Address.");
        }else if ( empty($password)){
            echo ("Please Enter Your Password.");
        }else {
            $adminRs = Database::search("SELECT * FROM `admin` WHERE `email`='".$email."' AND `password`='".$password."'");
            if ( $adminRs -> num_rows >0 ){
                $vCode = uniqid();
                Database::iud("UPDATE `admin` SET `v_code`='".$vCode."' WHERE `email`='".$email."' AND `password`='".$password."'");
                $mail = new PHPMailer;
                $mail->IsSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'programmerlk89@gmail.com';
                $mail->Password = 'dheomioerrausvou';
                $mail->SMTPSecure = 'ssl';
                $mail->Port = 465;
                $mail->setFrom('programmerlk89@gmail.com', 'Admin Login');
                $mail->addReplyTo('programmerlk89@gmail.com', 'Admin Login');
                $mail->addAddress($email);
                $mail->isHTML(true);
                $mail->Subject = 'Tea or Tools ';
                $bodyContent = '<h2>Verification Code is</h2> 
                <h1 style="color: blue;">'.$vCode.'</h1>';
                $mail->Body    = $bodyContent;
                if ( $mail -> send()){
                    echo("done");
                }else {
                    echo("Some Thing Went Wrong. Try Again Later");
                }
                
            }else{
                echo("Invaild Admin");
            }
        }


    }else {
        header("location:login.php");
    }
?>