<?php 
include "inc/app-top.php";
include_once "organizer/classes/CRUD.php";
//require 'phpmailer/PHPMailerAutoload.php';

function generateUniqueId(){
        
    $salt = sha1(rand());
    $salt = substr($salt, 0, 10);
    $random_num = rand(1000000000, 9999999999);
    $unique_id = $random_num.$salt;

    return $unique_id;

}

if($_POST) {
    
    $crud = new CRUD($mysqli);
    
	$email = $_POST["user_email"];
	
    $sql = "SELECT * FROM users WHERE user_email ='$email'";
    $result = $mysqli->query($sql);

    if ($result->num_rows > 0) {
        
        $unique_link = generateUniqueId();
        
        $sql_check = "SELECT user_unique_id FROM users WHERE user_email ='$email'";
        $result_check = $mysqli->query($sql_check);
        
        if ($result_check->num_rows > 0) {
            
            $sql_unique = "UPDATE users SET user_unique_id = '".$unique_link."' where user_email ='$email'";
            $result_unique = $mysqli->query($sql_unique);
        }else {
            $sql_unique = "INSERT INTO users (user_unique_id) VALUES ('".$unique_link."') where user_email ='$email'";
            $result_unique = $mysqli->query($sql_unique);
        }
            
        
        $to = $email;
        $subject = "Password recovery";
        $body  = "
        <html>
            <head>
            <title>HTML email</title>
            </head>
            <body style='text-align: center;'>
            <img style='width: 20%;' src='http://x-cow.com/sportevent/img/logo-orange.png'>
            <div style='background-color: #FFE5CC; width: 55%; height: 15%; margin:0 auto;'>
            <p style='padding-top: 2%;'>We have received a request to reset your account password for the SportsEvents.Asia.</p>
            <p style='line-height: 1;'>To reset your password, click the ‘Reset Password’ button below:</p>
            <a href='https://x-cow.com/sportevent/reset-password.php?id=".$unique_link."'><button style='
                    background-color: #e33f2c; 
                    border: none;
                    color: white;
                    padding: 12px;
                    text-align: center;
                    text-decoration: none;
                    display: inline-block;
                    font-size: 14px;
                    margin: 20px 2px;
                    cursor: pointer;
                    border-radius: 2px;'>RESET PASSWORD</button></a>
            <br>
            <p style='line-height: 0;'>Thank you,</p>
            <p style='line-height: 0.5; padding-bottom: 2%;'>Sports Events House Sdn Bhd</p>
            </div>
            <img style='width: 3%; padding-top: 2%; padding-right: 0.5%; display: inline-block;' src='http://x-cow.com/sportevent/img/facebook.PNG'>
            <img style='width: 3%; display: inline-block;' src='http://x-cow.com/sportevent/img/twitter.PNG'>
            <p>© Copyright 2018 Sports Events House Sdn. Bhd. (1100784-A)</p>
            
            </body>
            </html>
        
        ";
        
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= "From: sportevent.my" . "\r\n";
        mail($to,$subject,$body,$headers);
        
        header("Location: login.php?msg=6");
        
    } else{
        header("Location: login.php?msg=7");
    }
    
//	if($crud->total == 1){
//        $_SESSION["organizer_email"] = $email;
//        header("Location: event-page-list.php?msg=1");
//        
//    } else {
//        
//        header("Location: login-organizer.php?msg=1");
//        
//    }
} 
?>