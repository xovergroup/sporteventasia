<?php 
include "inc/app-top.php";

function passwordProcessing($new_password){
    
    
    $salt       = sha1(rand());
    $salt       = substr($salt, 0, 10);
    $encrypted  = password_hash($new_password.$salt, PASSWORD_DEFAULT);
    $hash       = array("salt" => $salt, "encrypted" => $encrypted);

    return $hash;

}

if($_POST) {
    
    $icprefix = $_POST["icprefix"];
    $icmiddle = $_POST["icmiddle"];
    $icsuffix = $_POST["icsuffix"];
    
    $newic = $icprefix."".$icmiddle."".$icsuffix;
	
    $id = $_POST["user_id"];
	$username = $_POST["user_full_name"];
	$email = $_POST["user_email"];
	$tel_no = $_POST["user_contact"];
    $full_tel_no = $_POST["full_number"];
	$password = $_POST["user_password"];
    $new_password = $_POST["user_new_password"];
	$nric = $_POST["user_ic"];
	$nrictype = $_POST["user_ic_status"];
    $gender = $_POST["user_gender"];

    
    if(!empty($password)){
        
        
        $sql_user = "SELECT * FROM users WHERE user_id = ".$id;
        $query_user = $mysqli->query($sql_user);
        while($row_user = $query_user->fetch_assoc()) {

            $salt = $row_user["user_hash"];
            $db_encrypted_password = $row_user["user_password"];
            $user_id = $row_user["user_id"];
        }
    
        if(password_verify($password.$salt, $db_encrypted_password)){
            
            $arr_password = passwordProcessing($new_password);
    
            $user_hash = $arr_password["salt"];
            $user_password =  $arr_password["encrypted"];
            
            if($icprefix != ""){
                
                $sql_update = "UPDATE users SET user_full_name = '".$username."', user_email = '".$email."', user_contact = '".$tel_no."', user_full_contact = '".$full_tel_no."', user_password = '".$user_password."', user_hash = '".$user_hash."', user_ic = ".$newic.", user_ic_status = ".$nrictype.", user_gender = '".$gender."' WHERE user_id = ".$id;
                $result_update = $mysqli->query($sql_update);

                header("Location: user-profile.php?msg=1");
                
            } else {
                
                $sql_update = "UPDATE users SET user_full_name = '".$username."', user_email = '".$email."', user_contact = '".$tel_no."', user_full_contact = '".$full_tel_no."', user_password = '".$user_password."', user_hash = '".$user_hash."', user_ic = ".$nric.", user_ic_status = ".$nrictype.", user_gender = '".$gender."' WHERE user_id = ".$id;
                $result_update = $mysqli->query($sql_update);

                header("Location: user-profile.php?msg=1");
                
            }

        } else {
            header("Location: user-profile.php?msg=3");
        }
    } else {
        
        if($icprefix != ""){
            
            $sql_update = "UPDATE users SET user_full_name = '".$username."', user_email = '".$email."', user_contact = '".$tel_no."', user_full_contact = '".$full_tel_no."', user_ic = ".$newic.", user_ic_status = ".$nrictype.", user_gender = '".$gender."' WHERE user_id = ".$id;
            $result_update = $mysqli->query($sql_update);

            header("Location: user-profile.php?msg=2");
            
        } else{
            
            $sql_update = "UPDATE users SET user_full_name = '".$username."', user_email = '".$email."', user_contact = '".$tel_no."', user_full_contact = '".$full_tel_no."', user_ic = ".$nric.", user_ic_status = ".$nrictype.", user_gender = '".$gender."' WHERE user_id = ".$id;
            $result_update = $mysqli->query($sql_update);

            header("Location: user-profile.php?msg=2");
            
        }
        
    }
    
}

?>