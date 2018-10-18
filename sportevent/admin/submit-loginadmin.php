<?php 
include "inc/app-top1.php";
include_once "../organizer/classes/CRUD.php";

if($_POST) {
    
    $crud = new CRUD($mysqli);
    
	$email = $_POST["admin_email"];
	$password = $_POST["admin_password"];
	
    $sql_admin = "SELECT * FROM admin WHERE admin_email ='$email'";        
    $query_admin = $mysqli->query($sql_admin);
    while($row_admin = $query_admin->fetch_assoc()) {
        
        $salt = $row_admin["admin_salt"];
        $db_encrypted_password = $row_admin["admin_password"];
        $admin_id = $row_admin["admin_id"];
    }
    
    
    if(password_verify($password.$salt, $db_encrypted_password)){
        
        $_SESSION["admin_id"] = $admin_id;
        $_SESSION["admin_email"] = $email;
        
        header("Location: user-list.php?msg=1");
        
    } else {
        
        header("Location: login-admin.php?msg=1");
        
    }
} 
?>