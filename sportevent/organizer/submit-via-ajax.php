<?php 

include_once "inc/app-top.php";
include_once "classes/CRUD.php";
include_once "classes/File.php";
include_once "classes/URL.php";
include_once "classes/CustomArray.php";


    

if($_POST){
    
    
    
    $crud = new CRUD($mysqli);
    $file = new File();
    $url = new URL();
    $customarray = new CustomArray();
    
    if(isset($_POST["action"]) && $crud->sanitizeStringV3($_POST["action"]) == "saveRacekitOtherInfo"){
        
        
        $crud->table = "events";
        $data_event = $crud->getKeyValueRelated($_POST, "event_");
        
        $crud->condition    = $crud->setCondition($data_event, "event_id");
        $data_event         = $crud->unsetKeyValue($data_event, "event_id");
        $crud->data         = $data_event;
        
        $crud->update();
        
        echo json_encode(array("status"=>$crud->status, "eventId"=>$event_id));
        
    } elseif(isset($_POST["action"]) && $crud->sanitizeStringV3($_POST["action"]) == "checkEventCategorySavedOrNot"){
        
        $crud->table = "event_category";
        $crud->conditionColumn = "event_category_event";
        $crud->find = intval($_POST["event_id"]);
        $crud->selectCount();
        
        echo json_encode(array("status"=>$crud->status, "total"=>$crud->total));
        
    } elseif(isset($_POST["action"]) && $crud->sanitizeStringV3($_POST["action"]) == "saveProfile"){
        
        //process image
        $banner = $file->processImage64($_POST["organizer_banner"], $url->normal."img/organizer_banner/", "img/organizer_banner/", "organizer_banner");
        $logo = $file->processImage64($_POST["organizer_logo"], $url->normal."img/organizer_logo/", "img/organizer_logo/", "organizer_logo");
        
        //prepare update
        $crud->table        = "organizers";
        $data_organizer     = $crud->getKeyValueRelated($_POST, "organizer_");
        $crud->condition    = $crud->setCondition($data_organizer, "organizer_id");
        $data_organizer     = $crud->unsetKeyValue($data_organizer, "organizer_id");
        $data_organizer     = $crud->unsetKeyValue($data_organizer, "organizer_tag_tag");
        $data_organizer     = $crud->addKeyValue($data_organizer, "organizer_banner", $banner);
        $data_organizer     = $crud->addKeyValue($data_organizer, "organizer_logo", $logo);
        $crud->data         = $data_organizer;
        
        
        //update
        $crud->update();
        
        //delete db tags
        $crud->table = "organizer_tag";
        $crud->id = $_POST["organizer_id"];
        $crud->conditionColumn = "organizer_tag_organizer";
        $crud->delete();
        
        //prepare insert multiple
        $tags = json_decode($_POST['organizer_tag_tag']);
        $count_tags = count($tags);
        $organizer_ids = $customarray->createArray($_POST["organizer_id"], $count_tags);
        $timestamps = $customarray->createArray(date("Y-m-d H:i:s"), $count_tags);
        
        //prepare array
        $data_tags = array(
            "organizer_tag_tag"=>$tags,
            "organizer_tag_organizer"=>$organizer_ids, 
            "organizer_tag_created_at"=>$timestamps
        );
        
        //set loop
        $crud->loop = $count_tags;
        
        //set data
        $crud->data = $data_tags;
        
        //set table name
        $crud->table = "organizer_tag";
        
        //insert multiple
        $crud->createMultipleV2();
        
        
        echo json_encode(array("status"=>$crud->status));
        
    } elseif(isset($_POST["action"]) && $crud->sanitizeStringV3($_POST["action"]) == "searchOrganizerEvent"){
        
        $event = $crud->sanitizeStringV2($_POST["event"]);
        $star = $crud->sanitizeStringV2($_POST["star"]);
        $name = $crud->sanitizeStringV2($_POST["name"]);
        
        $added_sql = "";
        
        if($event == 0 && $star == 0 && $name == ""){
            
            $msg = "all empty";
            
        } elseif($event != 0 && $star == 0 && $name == ""){
            
            $added_sql = "AND `events`.`event_id` = ".$event." ";
            $msg = "event not empty, star empty, name empty";
        
        } elseif($event == 0 && $star != 0 && $name == ""){
            
            $added_sql = "AND `event_review`.`review_rate` = ".$star." ";
            $msg = "event empty, star not empty, name empty";
            
        } elseif($event == 0 && $star == 0 && $name != ""){
            
            $added_sql = "AND `users`.`user_full_name` LIKE '%".$name."%' ";
            $msg = "event empty, star empty, name not empty";
            
        } elseif($event != 0 && $star != 0 && $name == ""){
            
            $added_sql = "AND `events`.`event_id` = ".$event." ";
            $added_sql .= "AND `event_review`.`review_rate` = ".$star." ";
            $msg = "event not empty, star not empty, name empty";
            
        } elseif($event != 0 && $star == 0 && $name != ""){
            
            $added_sql = "AND `events`.`event_id` = ".$event." ";
            $added_sql .= "AND `users`.`user_full_name` LIKE '%".$name."%' ";
            $msg = "event not empty, star empty, name not empty";
            
        } elseif($event == 0 && $star != 0 && $name != ""){
            
            $added_sql = "AND `event_review`.`review_rate` = ".$star." ";
            $added_sql .= "AND `users`.`user_full_name` LIKE '%".$name."%' ";
            $msg = "event empty, star not empty, name not empty";
            
        } elseif($event != 0 && $star != 0 && $name != ""){
            
            $added_sql = "AND `events`.`event_id` = ".$event." ";
            $added_sql .= "AND `event_review`.`review_rate` = ".$star." ";
            $added_sql .= "AND `users`.`user_full_name` LIKE '%".$name."%' ";
            $msg = "all not empty";
            
        }
        
        if($event == 0 && $star == 0 && $name == ""){
            $crud->sql = "SELECT `users`.`user_full_name`, `events`.`event_name`, `event_review`.`review_rate`, `event_review`.`review_desc`, `event_review`.`review_desc`, `event_review`.`review_created_at` 
            FROM users, events, event_review WHERE 
            `users`.`user_id` = `event_review`.`review_user` AND 
            `events`.`event_id` = `event_review`.`review_event` AND 
            `events`.`event_organizer` = ".$_SESSION["organizer_id"]." 
            ORDER BY `event_review`.`review_created_at` DESC";
            
        } else {
            $crud->sql = "SELECT `users`.`user_full_name`, `events`.`event_name`, `event_review`.`review_rate`, `event_review`.`review_desc`, `event_review`.`review_desc`, `event_review`.`review_created_at` 
            FROM users, events, event_review WHERE 
            `users`.`user_id` = `event_review`.`review_user` AND 
            `events`.`event_id` = `event_review`.`review_event` AND 
            `events`.`event_organizer` = ".$_SESSION["organizer_id"]." ".$added_sql."
            ORDER BY `event_review`.`review_created_at` DESC";
        }
        
        
        $crud->selectAll();
        
        
        if($crud->total > 0){
            while($row = $crud->result->fetch_object()){
                $html[] = $row;
            } $crud->result->close(); 
        
        } else {
            $html = "No data";
        }
        
        
        echo json_encode(array("status"=>$crud->status, "data"=>$html, "total"=>$crud->total));
    
    } elseif(isset($_POST["action"]) && $crud->sanitizeStringV3($_POST["action"]) == "searchEvent"){
        
        $search_by = $crud->sanitizeStringV2($_POST["search_by"]);
        $event_name = $crud->sanitizeStringV2($_POST["event_name"]);
        $event_status = $crud->sanitizeStringV2($_POST["event_status"]);
        $event_month = $crud->sanitizeStringV2($_POST["event_month"]);
        $event_state = $crud->sanitizeStringV2($_POST["event_state"]);
        
        
        $msg = 'Search by Event = 1, Empty OR 0: event name, event status, event_month, event_state';
        
        if($search_by == 1 && $event_name != "" && $event_status == 0 && $event_month == 0 && $event_state == 0){
            
            $msg = 'Search by Event = 1, NOT Empty: event_name, Empty OR 0: event status, event_month, event_state';
            $added_sql = " AND event_name LIKE '%".$event_name."%' ";
            
            
        } 
            
            
        $crud->sql ="SELECT event_name, event_date_start, event_time_start, event_time_end, event_thumbnail 
                    FROM events WHERE 
                    event_organizer = ".$_SESSION["organizer_id"]." ".$added_sql." 
                    ORDER BY `events`.`event_id` DESC";
         
        
        
        
        
        $crud->selectAll();
        if($crud->total > 0){
            while($row = $crud->result->fetch_object()){
                $data[] = $row;
            } $crud->result->close(); 
        
        } else {
            $data = "No data";
        }
        
        
        
        
        echo json_encode(array("status"=>"good", "data"=>$data, "msg"=>$msg, "sql"=>$crud->sql));
        
    }
    
    
}




include_once "inc/app-bottom.php"; 

?>