<?php 
include_once "inc/app-top-index.php";
include_once "organizer/classes/CRUD.php";


if($_POST) {
    
    $crud = new CRUD($mysqli);
    
	$email = $_POST["user_email"];
	$password = $_POST["user_password"];
	
    $sql_user = "SELECT * FROM users WHERE user_email ='$email'";        
    $query_user = $mysqli->query($sql_user);
    while($row_user = $query_user->fetch_assoc()) {
        
        $salt = $row_user["user_hash"];
        $db_encrypted_password = $row_user["user_password"];
        $user_id = $row_user["user_id"];
    }
    
    
    if(password_verify($password.$salt, $db_encrypted_password)){
                
        $_SESSION["email"] = $email;
        $_SESSION["id"] = $user_id;
        
        if(isset($_SESSION["user_registering_event"])){
            header("Location: event-registration-form-2.php?event_id=".$_SESSION["user_registering_event"]);
        } else {
            header("Location: index.php?msg=1");
        }
        
        
    } else {
        
        header("Location: login.php?msg=5");
        
    }
    
} 

include_once "inc/app-bottom.php";
?>