<?php 
include "inc/app-top.php";
$user_id = $_SESSION['id'];

if($_POST) {
    
    $icprefix = $_POST["icprefix"];
    $icmiddle = $_POST["icmiddle"];
    $icsuffix = $_POST["icsuffix"];
    
    $newic = $icprefix."".$icmiddle."".$icsuffix;
	
	$username = $_POST["guest_name"];
	$email = $_POST["guest_email"];
	$tel_no = $_POST["guest_contact"];
	$nric = $_POST["guest_ic"];
	$nrictype = $_POST["guest_ic_status"];
    $gender = $_POST["guest_gender"];
    
        
    if($icprefix != ""){

        $sql_add = "INSERT INTO guest (guest_user_id, guest_name, guest_email, guest_contact, guest_ic, guest_ic_status, guest_gender) VALUES ('".$user_id."', '".$username."', '".$email."', '".$tel_no."', '".$newic."', '".$nrictype."', '".$gender."' )";
        $result_add = $mysqli->query($sql_add);

        header("Location: user-guest-add.php?msg=1");

    } else{

        
        $sql_add = "INSERT INTO guest (guest_user_id, guest_name, guest_email, guest_contact, guest_ic, guest_ic_status, guest_gender) VALUES ('".$user_id."', '".$username."', '".$email."', '".$tel_no."', '".$nric."', '".$nrictype."', '".$gender."' )";
        $result_add = $mysqli->query($sql_add);

        header("Location: user-guest-add.php?msg=1");

    }
        
}

?>