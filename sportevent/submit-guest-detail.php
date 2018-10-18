<?php 
include "inc/app-top.php";
$user_id = $_SESSION['id'];

if($_POST) {
    
    $icprefix = $_POST["icprefix"];
    $icmiddle = $_POST["icmiddle"];
    $icsuffix = $_POST["icsuffix"];
    
    $newic = $icprefix."".$icmiddle."".$icsuffix;
	
    $id = $_POST["guest_id"];
	$username = $_POST["guest_name"];
	$email = $_POST["guest_email"];
	$tel_no = $_POST["guest_contact"];
	$nric = $_POST["guest_ic"];
	$nrictype = $_POST["guest_ic_status"];
    $gender = $_POST["guest_gender"];
    
        
    if($nrictype == 1){

        $sql_edit = "UPDATE guest SET guest_name = '".$username."', guest_email = '".$email."', guest_contact = '".$tel_no."', guest_ic = ".$newic.", guest_ic_status = ".$nrictype.", guest_gender = '".$gender."' WHERE guest_id = ".$id;
        $result_edit = $mysqli->query($sql_edit);

        header("Location: user-guest.php?msg=1");

    } else{

        
        $sql_edit = "UPDATE guest SET guest_name = '".$username."', guest_email = '".$email."', guest_contact = '".$tel_no."', guest_ic = '".$nric."', guest_ic_status = ".$nrictype.", guest_gender = '".$gender."' WHERE guest_id = ".$id;
        $result_edit = $mysqli->query($sql_edit);

        header("Location: user-guest.php?msg=1");

    }
        
}

?>