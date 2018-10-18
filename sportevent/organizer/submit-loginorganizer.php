<?php 
include "inc/app-top1.php";
include_once "classes/CRUD.php";

if($_POST) {
    
    $crud = new CRUD($mysqli);
    
	$email = $_POST["organizer_email"];
	$password = $_POST["organizer_password"];
	
    $sql_organizer = "SELECT * FROM organizers WHERE organizer_email ='$email'";        
    $query_organizer = $mysqli->query($sql_organizer);
    while($row_organizer = $query_organizer->fetch_assoc()) {
        
        $salt = $row_organizer["organizer_salt"];
        $db_encrypted_password = $row_organizer["organizer_password"];
        $organizer_id = $row_organizer["organizer_id"];
    }
    
    
    if(password_verify($password.$salt, $db_encrypted_password)){
    
        $_SESSION["organizer_email"]    = $email;
        $_SESSION["organizer_id"]       = $organizer_id;
        
        header("Location: event-page-list.php?msg=1");
        
    } else {
        header("Location: login-organizer.php?msg=1");
        
    }
} 
?>