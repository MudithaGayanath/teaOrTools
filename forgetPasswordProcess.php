<?php
   include ("SMTP.php");
   include ("PHPMailer.php");
   include ("Exception.php");
   
   use PHPMailer\PHPMailer\PHPMailer;
   if ( $_SERVER["REQUEST_METHOD"] == "POST" ){
       
        $email = $_POST["e"];
        if ( empty($email)){
            echo("Enter Email");
        }else if ( !filter_var($email,FILTER_VALIDATE_EMAIL)){
            echo("Invalid Email");
        }else {
            include("connection.php");
            
            
            $userRs = Database::search("SELECT * FROM `user` WHERE `email`='".$email."'");
            if ( $userRs -> num_rows > 0){
                $userData = $userRs -> fetch_assoc();
                $userEmail = $userData["email"];
                $code = uniqid();
                Database::iud("UPDATE `user` SET `v_code`='".$code."' WHERE `email`='".$userEmail."' ");

                $mail = new PHPMailer;
                $mail->IsSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'programmerlk89@gmail.com';
                $mail->Password = 'dheomioerrausvou';
                $mail->SMTPSecure = 'ssl';
                $mail->Port = 465;
                $mail->setFrom('programmerlk89@gmail.com', 'Reset Password');
                $mail->addReplyTo('programmerlk89@gmail.com', 'Reset Password');
                $mail->addAddress($userEmail);
                $mail->isHTML(true);
                $mail->Subject = 'Tea or Tools ';
                $bodyContent = '<h2>Verification Code is</h2> 
                <h1 style="color: blue;">'.$code.'</h1>';
                $mail->Body    = $bodyContent;

                if ( $mail -> send()){
                    echo("send");
                }else {
                    echo("Some Thing Went Wrong. Try Again Later");
                }

            }else {
                echo("Invalid User");
            }
        }
    }else {
        header("location:login.php");
    }
?>