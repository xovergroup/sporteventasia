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
    
    $crud = new CRUD($mysqli);
    
	$user_unique_id = $_POST["user_unique_id"];
    $password = $_POST["user_password"];
    
    $arr_password = passwordProcessing($password);
    
    $user_hash = $arr_password["salt"];
    $user_password =  $arr_password["encrypted"];
	
    $sql = "UPDATE users SET user_password = '".$user_password."', user_hash = '".$user_hash."' WHERE user_unique_id = '".$user_unique_id."'";
    $result = $mysqli->query($sql);
    
    header("Location: login.php?msg=8");
    
} 
?>