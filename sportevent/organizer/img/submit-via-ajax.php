<?php 

include_once "inc/app-top.php";
include_once "classes/CRUD.php";
include_once "classes/File.php";
include_once "classes/URL.php";




if($_POST){
    
    $crud = new CRUD($mysqli);
    $file = new File();
    $url = new URL();
    
    if(isset($_POST["action"]) && $crud->sanitizeStringV3($_POST["action"]) == "createEvent"){
        
        
        $data_event = $crud->getKeyValueRelated($_POST, "event_");
        $tags       = json_decode(stripslashes($_POST['tags']));
        $count_tag  = count($tags);
        
        //process image
        $banner = $file->processImage64($_POST["event_banner"], $url->normal."img/event_banner/", "img/event_banner/", "event_banner");
        $thumbnail = $file->processImage64($_POST["event_thumbnail"], $url->normal."img/event_thumbnail/", "img/event_thumbnail/", "event_thumbnail");
        
        /*
        $crud->table = "events";
        $data_event = $crud->addDateTime($data_event, "event_created_at");
        $crud->data = $data_event;
        $crud->create();
        $event_id = $crud->lastInsertId;
        
        $crud->table = "event_tag";
        for($x = 0; $x < $count_tag; $x++) {
            
            $data_tag = $crud->addDateTime($data_tag, "event_tag_created_at");
            $data_tag = $crud->addKeyValue($data_tag, "event_tag_event", $event_id);
            $data_tag = $crud->addKeyValue($data_tag, "event_tag_tag", $crud->sanitizeInt($tags[$x]));
            $crud->data = $data_tag;
            $crud->create();
        } 
        */
        
        
        
        
        
        $status = "Success";
        $msg = "good";
        
        echo json_encode(array("status"=>$status, "msg"=>$banner." ".$thumbnail));
        
    }
    
    
    
    
}




include_once "inc/app-bottom.php"; 

?>