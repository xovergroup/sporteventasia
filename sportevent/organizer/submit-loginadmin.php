<?php 
include "inc/app-top.php";
include_once "classes/CRUD.php";

if($_POST) {
    
    $crud = new CRUD($mysqli);
    
	$email = $_POST["admin_email"];
	$password = base64_encode($_POST["admin_password"]);
	
    $crud->sql = "SELECT * FROM admin WHERE admin_email = '".$email."' AND admin_password = '".$password."'";
    $crud->selectAll();
    
    
	if($crud->total == 1){
        $_SESSION["admin_email"] = $email;
        header("Location: ../admin/user-list.php?msg=1");
        
    } else {
        
        header("Location: login-admin.php?msg=1");
        
    }
} 
?>