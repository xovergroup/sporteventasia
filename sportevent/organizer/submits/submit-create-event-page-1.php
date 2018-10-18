<?php 

include_once "../inc/app-top.php";
include_once "../classes/CRUD.php";
include_once "../classes/File.php";
include_once "../classes/URL.php";
include_once "../classes/CustomArray.php";


    

if($_POST){
    
    
    
    $crud = new CRUD($mysqli);
    $file = new File();
    $url = new URL();
    $customarray = new CustomArray();
    
    if(isset($_POST["event"]["action"]) && $crud->sanitizeStringV3($_POST["event"]["action"]) == "createEvent"){
        
        //process image
        $banner = $file->processImage64($_POST["event_banner"], $url->banner, "../img/event_banner/", "event_banner");
        $thumbnail = $file->processImage64($_POST["event_thumbnail"], $url->thumbnail, "../img/event_thumbnail/", "event_thumbnail");
       
        
        //insert event
        $data = array(
            "event_organizer"=>$_SESSION["organizer_id"],
            "event_name"=>$_POST["event"]["eventName"],
            "event_location"=>$_POST["event"]["eventLocation"],
            "event_state"=>$_POST["event"]["eventState"],
            "event_date_start"=>$_POST["event"]["eventDateStart"],
            "event_date_end"=>$_POST["event"]["eventDateEnd"],
            "event_time_start"=>$_POST["event"]["eventTimeStart"],
            "event_time_end"=>$_POST["event"]["eventTimeEnd"],
            "event_banner"=>$banner,
            "event_thumbnail"=>$thumbnail,
            "event_description"=>$_POST["event"]["eventDescription"],
            "event_url"=>$_POST["event"]["eventUrl"],
            "event_created_at"=>date("Y-m-d H:i:s")

        );

        $crud->table = "events";
        $crud->data = $data;
        $crud->createV2();
        
        $event_id = $crud->lastInsertId;
        
        
        if(isset($_POST["tags"])){
            
            $count_tag = count($_POST["tags"]);
            if($count_tag > 0){

                $loop = $count_tag;

                //put data into array
                for($x = 0; $x < $loop; $x++) {
                    $event_ids[]    = $event_id; 
                    $timestamps[]   = date("Y-m-d H:i:s"); 
                }

                //prepare array
                $data = array(
                    "event_tag_tag"=>$_POST["tags"],
                    "event_tag_event"=>$event_ids,
                    "event_tag_created_at"=>$timestamps
                );

                //set loop
                $crud->loop = $loop;

                //set data
                $crud->data = $data;

                //set table name
                $crud->table = "event_tag";

                //insert multiple
                $crud->createMultipleV2();
            }
        }
        
        
        
        if(isset($_POST["sponsor_types"])){
            
            $count_sponsor = count($_POST["sponsor_types"]);
            
            if($count_sponsor > 0){
                
                $loop = $count_sponsor;

                //put data into array
                for($x = 0; $x < $loop; $x++) {
                    $event_ids[]        = $event_id; 
                    $sponsor_images[]   = $file->processImage64($_POST["sponsor_images"][$x], $url->sponsor, "../img/event_sponsor/", "event_sponsor");
                    $timestamps[]       = date("Y-m-d H:i:s"); 
                }

                //prepare array
                $data = array(
                    "event_sponsor_event"=>$event_ids,
                    "event_sponsor_type"=>$_POST["sponsor_types"],
                    "event_sponsor_image"=>$sponsor_images,
                    "event_sponsor_created_at"=>$timestamps
                );

                //set loop
                $crud->loop = $loop;

                //set data
                $crud->data = $data;

                //set table name
                $crud->table = "event_sponsor";

                //insert multiple
                $crud->createMultipleV2();
                
            }
        }
        
        
        echo json_encode(array("status"=>$crud->status, "eventId"=>$event_id));
        
    } elseif(isset($_POST["event"]["action"]) && $crud->sanitizeStringV3($_POST["event"]["action"]) == "saveEvent"){
        
        //process image
        $banner = $file->processImage64($_POST["event_banner"], $url->banner, "../img/event_banner/", "event_banner");
        $thumbnail = $file->processImage64($_POST["event_thumbnail"], $url->thumbnail, "../img/event_thumbnail/", "event_thumbnail");
        
        $event_id = intval($_POST["event"]["eventId"]);
                           
        $data = array(
            "event_organizer"=>$_SESSION["organizer_id"],
            "event_name"=>$_POST["event"]["eventName"],
            "event_location"=>$_POST["event"]["eventLocation"],
            "event_state"=>$_POST["event"]["eventState"],
            "event_date_start"=>$_POST["event"]["eventDateStart"],
            "event_date_end"=>$_POST["event"]["eventDateEnd"],
            "event_time_start"=>$_POST["event"]["eventTimeStart"],
            "event_time_end"=>$_POST["event"]["eventTimeEnd"],
            "event_banner"=>$banner,
            "event_thumbnail"=>$thumbnail,
            "event_description"=>$_POST["event"]["eventDescription"],
            "event_url"=>$_POST["event"]["eventUrl"]

        );

        $crud->table        = "events";
        $crud->data         = $data;
        $crud->condition    = " WHERE event_id = ".$event_id;
        $crud->update();
        
        /* --------------------------- Event Tag  --------------------------- */
        $crud->table            = "event_tag";
        $crud->id               = $event_id;
        $crud->conditionColumn  = "event_tag_event";
        $crud->delete();
        
        if(isset($_POST["tags"])){
            
            $count_tag = count($_POST["tags"]);
            if($count_tag > 0){

                $loop = $count_tag;

                //put data into array
                for($x = 0; $x < $loop; $x++) {
                    $event_ids[]    = $event_id; 
                    $timestamps[]   = date("Y-m-d H:i:s"); 
                }

                //prepare array
                $data = array(
                    "event_tag_tag"=>$_POST["tags"],
                    "event_tag_event"=>$event_ids,
                    "event_tag_created_at"=>$timestamps
                );

                //set loop
                $crud->loop = $loop;

                //set data
                $crud->data = $data;

                //set table name
                $crud->table = "event_tag";

                //insert multiple
                $crud->createMultipleV2();
            }
        }
        
        /* --------------------------- Event Sponsor  --------------------------- */
        $crud->table = "event_sponsor";
        $crud->id = $event_id;
        $crud->conditionColumn = "event_sponsor_event";
        $crud->delete();
        
        if(isset($_POST["sponsor_types"])){
            
            $count_sponsor = count($_POST["sponsor_types"]);
            
            if($count_sponsor > 0){
                
                $loop = $count_sponsor;

                //put data into array
                for($x = 0; $x < $loop; $x++) {
                    $event_ids[]        = $event_id; 
                    $sponsor_images[]   = $file->processImage64($_POST["sponsor_images"][$x], $url->sponsor, "../img/event_sponsor/", "event_sponsor");
                    $timestamps[]       = date("Y-m-d H:i:s"); 
                }

                //prepare array
                $data = array(
                    "event_sponsor_event"=>$event_ids,
                    "event_sponsor_type"=>$_POST["sponsor_types"],
                    "event_sponsor_image"=>$sponsor_images,
                    "event_sponsor_created_at"=>$timestamps
                );

                //set loop
                $crud->loop = $loop;

                //set data
                $crud->data = $data;

                //set table name
                $crud->table = "event_sponsor";

                //insert multiple
                $crud->createMultipleV2();
                
            }
        }
        
        
        echo json_encode(array("status"=>$crud->status, "eventId"=>$event_id));
        
    }
    
}




include_once "../inc/app-bottom.php"; 

?>