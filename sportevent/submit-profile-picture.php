<?php 
include "inc/app-top.php";
include_once "organizer/classes/File.php";
include_once "organizer/classes/URL.php";

if($_POST) {
    
    $file = new File();
    $url = new URL();
    
    $user_id = $_POST["user_id"];
    $profile_picture = $file->processImage64($_POST["profile_picture"], $url->normal."img/profile/", "img/profile/", "profile_picture");
    
    echo json_encode(array("status"=>$profile_picture));
    
    $sql = "UPDATE users SET user_picture = '".$profile_picture."' WHERE user_id = ".$user_id;
    $result1 = $mysqli->query($sql);
    
    echo json_encode(array("status"=>$profile_picture));
}