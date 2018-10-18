<?php 
include "inc/app-top.php";
include_once "organizer/classes/CRUD.php";

function passwordProcessing($password){
    
    
    $salt       = sha1(rand());
    $salt       = substr($salt, 0, 10);
    $encrypted  = password_hash($password.$salt, PASSWORD_DEFAULT);
    $hash       = array("salt" => $salt, "encrypted" => $encrypted);

    return $hash;

}

if($_POST) {
    
    $icprefix = $_POST["icprefix"];
    $icmiddle = $_POST["icmiddle"];
    $icsuffix = $_POST["icsuffix"];
    
    $newic = $icprefix."".$icmiddle."".$icsuffix;
	
	$crud = new CRUD($mysqli);
	
    $fbid = $_POST["user_full_name"];
	$username = $_POST["user_full_name"];
	$email = $_POST["user_email"];
	$tel_no = $_POST["user_contact"];
    $full_tel_no = $_POST["full_number"];
	$nric = $_POST["user_ic"];
	$nrictype = $_POST["user_ic_status"];
	$approve = 1;
		
	$forward = $_SERVER["HTTP_X_FORWARDED_FOR"];
	$remote_ip = $_SERVER["REMOTE_ADDR"];
    
    $password = $_POST["user_password"];
    
    $arr_password = passwordProcessing($password);
    
    $user_hash = $arr_password["salt"];
    $user_password =  $arr_password["encrypted"];
    
	$captcha = $_POST["g-recaptcha-response"];
	if(!$captcha) {
		header("Location: login.php?msg=1");
        
	} else {
        
		$response = json_decode(file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=6LcI3f8SAAAAAD3RJ9E2xbNPw_dWW5cjThhKyHzO&response=".$captcha."&remoteip=".$_SERVER['REMOTE_ADDR']), true);
        
		if($response['success'] == false) {
			header("Location: login.php?msg=2");
            
		} else {
            
            $crud->sql = "SELECT * FROM users WHERE user_email LIKE '".$email."'";
            $crud->selectAll();
            
            if($crud->total < 1){  
                
                if($icprefix != ""){
                    
                    $data = array(
                        "user_full_name"=>$username,
                        "user_email"=>$email,
                        "user_password"=>$user_password,
                        "user_hash"=>$user_hash,
                        "user_ic"=>$newic,
                        "user_ic_status"=>$nrictype,
                        "user_contact"=>$tel_no,
                        "user_full_contact"=>$full_tel_no,
                        "user_created_at"=>date("Y-m-d H:i:s")

                    );

                    $crud->table = "users";
                    $crud->data = $data;
                    $crud->createV2();
                    
                    $user_id = $crud->lastInsertId;
                                       
                } else {
                    
                    $data = array(
                        "user_full_name"=>$username,
                        "user_email"=>$email,
                        "user_password"=>$user_password,
                        "user_hash"=>$user_hash,
                        "user_ic"=>$nric,
                        "user_ic_status"=>$nrictype,
                        "user_contact"=>$tel_no,
                        "user_full_contact"=>$full_tel_no,
                        "user_created_at"=>date("Y-m-d H:i:s")

                    );

                    $crud->table = "users";
                    $crud->data = $data;
                    $crud->createV2();
                    
                    $user_id = $crud->lastInsertId;
                    
                }          
               
               $_SESSION["id"] = $user_id;
               $_SESSION["email"] = $email;
               header("Location: index.php?msg=2");
            
            } else {
                
               header("Location: login.php?msg=3");
                
            }
                   
		}
             
	}
} else {
    header("Location: login.php?msg=4");
}
?>