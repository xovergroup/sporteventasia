<?php 

include_once "../inc/app-top.php";
include_once "../../organizer/classes/CRUD.php";
include_once "../../organizer/classes/File.php";
include_once "../../organizer/classes/URL.php";
include_once "../../organizer/classes/CustomArray.php";


    

if($_POST){
    
    
    
    $crud = new CRUD($mysqli);
    $file = new File();
    $url = new URL();
    $customarray = new CustomArray();
    
    if(isset($_POST["action"]) && $crud->sanitizeStringV3($_POST["action"]) == "selectEvents"){
        
            
            $input = $crud->sanitizeStringV2($_POST["input"]);
            $today = date('Y-m-d');
        
            $crud->sql = "SELECT event_id, event_name FROM events WHERE event_date_start >= '".$today."' AND event_name LIKE '%".$input."%' ";
            $crud->selectAll();
            if($crud->total > 0){
                while($row = $crud->result->fetch_object()){
                    $data[] = $row;
            } $crud->result->close(); }
        
        
        echo json_encode(array("status"=>$crud->status, "data"=>$data, "total"=>$crud->total));
        
    } elseif(isset($_POST["action"]) && $crud->sanitizeStringV3($_POST["action"]) == "selectCategories"){
        
            
            $input = $crud->sanitizeStringV2($_POST["input"]);
            $today = date('Y-m-d');
        
            $crud->sql = "SELECT event_category_id, event_category_name FROM event_category WHERE event_category_reg_date_end >= '".$today."' AND event_category_name LIKE '%".$input."%' ";
            $crud->selectAll();
            if($crud->total > 0){
                while($row = $crud->result->fetch_object()){
                    $data[] = $row;
            } $crud->result->close(); }
        
        
        echo json_encode(array("status"=>$crud->status, "data"=>$data, "total"=>$crud->total));
        
    } elseif(isset($_POST["action"]) && $crud->sanitizeStringV3($_POST["action"]) == "grabEventCategory"){
        
            
            $ids = $crud->sanitizeStringV2($_POST["ids"]);
            $today = date('Y-m-d');
        
            $crud->sql = "SELECT event_category_id, event_category_name FROM `event_category` WHERE `event_category_event` IN (".$ids.")";
            $crud->selectAll();
            if($crud->total > 0){
                while($row = $crud->result->fetch_object()){
                    $data[] = $row;
            } $crud->result->close(); }
        
        
        echo json_encode(array("status"=>$crud->status, "data"=>$data, "total"=>$crud->total));
        
    } elseif(isset($_POST["action"]) && $crud->sanitizeStringV3($_POST["action"]) == "addMerchandiseToEvent"){
        
           
        $merchandise_id = intval($_POST["merchandiseId"]);
        
        $crud->table            = "merchandise_designate";
        $crud->id               = $merchandise_id;
        $crud->conditionColumn  = "merchandise_id";
        $crud->delete();
        
        $loop = count($_POST["eventData"]["ids"]);
            
            //put data into array
            for($x = 0; $x < $loop; $x++) {
                $merchandise_ids[]  = $merchandise_id; 
                $merchandise_fors[] = 1; 
                $timestamps[]       = date("Y-m-d H:i:s"); 
            }
            
            //prepare array
            $data = array(
                "merchandise_id"=>$merchandise_ids,
                "event_id"=>$_POST["eventData"]["ids"],
                "merchandise_for"=>$merchandise_fors,
                "created_at"=>$timestamps
            );
            
            //set loop
            $crud->loop = $loop;

            //set data
            $crud->data = $data;

            //set table name
            $crud->table = "merchandise_designate";

            //insert multiple
            $crud->createMultipleV2();
            
        
        echo json_encode(array("status"=>$crud->status));
        
    } elseif(isset($_POST["action"]) && $crud->sanitizeStringV3($_POST["action"]) == "removeMerchandiseFromEvent"){
        
           
        $merchandise_id = intval($_POST["merchandiseId"]);
        
        $crud->table            = "merchandise_designate";
        $crud->id               = $merchandise_id;
        $crud->conditionColumn  = "merchandise_id";
        $crud->delete();
        
        echo json_encode(array("status"=>$crud->status));
        
    }
    
}




include_once "../inc/app-bottom.php"; 

?>