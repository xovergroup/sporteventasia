<?php 
include "inc/app-top.php";
include_once "../organizer/classes/File.php";
include_once "../organizer/classes/URL.php";
include_once "../organizer/classes/CRUD.php";


function passwordProcessing($password){
    
    
    $salt       = sha1(rand());
    $salt       = substr($salt, 0, 10);
    $encrypted  = password_hash($password.$salt, PASSWORD_DEFAULT);
    $hash       = array("salt" => $salt, "encrypted" => $encrypted);

    return $hash;

}


if($_POST) {
    
    $crud = new CRUD($mysqli);
    $file = new File();
    $url = new URL();
    
//    $data_organizer     = $crud->getKeyValueRelated($_POST, "organizer_");
    $data_organizer = array();
    
    $tags           = json_decode(stripslashes($_POST['organizer_tags']));

    $count_tag              = count($tags);

    //process image
    $organizer_name = $_POST["organizer_name"];
    $organizer_email = $_POST["organizer_email"];
    $organizer_contact_no = $_POST["organizer_contact_no"];
    $organizer_facebook = $_POST["organizer_facebook"];
    $organizer_youtube = $_POST["organizer_youtube"];
    $organizer_twitter = $_POST["organizer_twitter"];
    $organizer_instagram = $_POST["organizer_instagram"];
    $organizer_website = $_POST["organizer_website"];        
    $organizer_desc = $_POST["organizer_desc"];
    $password = $_POST["organizer_password"];
    
    $arr_password = passwordProcessing($password);
    
    $organizer_salt = $arr_password["salt"];
    $organizer_password =  $arr_password["encrypted"];
    
    
    $banner = $file->processImage64($_POST["organizer_banner"], $url->normal."img/organizer_banner/", "img/organizer_banner/", "organizer_banner");
    $logo = $file->processImage64($_POST["organizer_logo"], $url->normal."img/organizer_logo/", "img/organizer_logo/", "organizer_logo");


    $crud->table = "organizers";
    
    $data_organizer = $crud->unsetKeyValue($data_organizer, "organizer_name");
    $data_organizer = $crud->unsetKeyValue($data_organizer, "organizer_email");
    $data_organizer = $crud->unsetKeyValue($data_organizer, "organizer_contact_no");
    $data_organizer = $crud->unsetKeyValue($data_organizer, "organizer_facebook");
    $data_organizer = $crud->unsetKeyValue($data_organizer, "organizer_youtube");
    $data_organizer = $crud->unsetKeyValue($data_organizer, "organizer_twitter");
    $data_organizer = $crud->unsetKeyValue($data_organizer, "organizer_instagram");
    $data_organizer = $crud->unsetKeyValue($data_organizer, "organizer_website");   
    $data_organizer = $crud->unsetKeyValue($data_organizer, "organizer_desc");
    $data_organizer = $crud->unsetKeyValue($data_organizer, "organizer_password");
    
    $data_organizer = $crud->unsetKeyValue($data_organizer, "organizer_banner");
    $data_organizer = $crud->unsetKeyValue($data_organizer, "organizer_logo");
    
    $data_organizer = $crud->addKeyValue($data_organizer, "organizer_name", $organizer_name);
    $data_organizer = $crud->addKeyValue($data_organizer, "organizer_email", $organizer_email);
    $data_organizer = $crud->addKeyValue($data_organizer, "organizer_contact_no", $organizer_contact_no);
    $data_organizer = $crud->addKeyValue($data_organizer, "organizer_facebook", $organizer_facebook);
    $data_organizer = $crud->addKeyValue($data_organizer, "organizer_youtube", $organizer_youtube);
    $data_organizer = $crud->addKeyValue($data_organizer, "organizer_twitter", $organizer_twitter);
    $data_organizer = $crud->addKeyValue($data_organizer, "organizer_instagram", $organizer_instagram);
    $data_organizer = $crud->addKeyValue($data_organizer, "organizer_website", $organizer_website); 
    $data_organizer = $crud->addKeyValue($data_organizer, "organizer_desc", $organizer_desc);
    $data_organizer = $crud->addKeyValue($data_organizer, "organizer_password", $organizer_password);
    $data_organizer = $crud->addKeyValue($data_organizer, "organizer_salt", $organizer_salt);
    
    $data_organizer = $crud->addKeyValue($data_organizer, "organizer_banner", $banner);
    $data_organizer = $crud->addKeyValue($data_organizer, "organizer_logo", $logo);
    $data_organizer = $crud->addDateTime($data_organizer, "organizer_created_at");
    $crud->data = $data_organizer;
    $crud->create();
    $organizer_id = $crud->lastInsertId;



    $crud->table = "organizer_tag";
    $data_tag = array();
    for($x = 0; $x < $count_tag; $x++) {

        $data_tag = $crud->addKeyValue($data_tag, "organizer_tag_organizer", $organizer_id);
        $data_tag = $crud->addKeyValue($data_tag, "organizer_tag_tag", $crud->sanitizeInt($tags[$x]));
        $data_tag = $crud->addDateTime($data_tag, "organizer_tag_created_at");
        $crud->data = $data_tag;
        $crud->create();
    } 



    echo json_encode(array("status"=>$crud->status));
    
}