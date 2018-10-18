<?php 

include_once "../inc/app-top.php";
include_once "../organizer/classes/CRUD.php";
include_once "../organizer/classes/CustomDateTime.php";
include_once "../organizer/classes/State.php";


    

if($_POST){
    
    $crud       = new CRUD($mysqli);
    $category   = new CRUD($mysqli);
    $datetime   = new CustomDateTime();
    
    
    if(isset($_POST["action"]) && $crud->sanitizeStringV3($_POST["action"]) == "grabAllStates"){
        
        
        $crud->sql = "SELECT * FROM states";
        $crud->selectAll();
        
        if($crud->total > 0){
            
            while($row = $crud->result->fetch_object()){
                $states[] = $row;
            } 
            $crud->result->close(); 
        }
        
        echo json_encode(array("status"=>$crud->status, "states"=>$states));
        
    
    } elseif(isset($_POST["action"]) && $crud->sanitizeStringV3($_POST["action"]) == "deleteRegisterCategory"){
        
        
        $crud->table = "event_registration";
        $crud->id = $_POST["id"];
        $crud->conditionColumn = "register_id";
        
        $crud->delete();
        
        echo json_encode(array("status"=>$crud->status));
        
    } elseif(isset($_POST["action"]) && $crud->sanitizeStringV3($_POST["action"]) == "saveParticipantData"){
        
        $crud       = new CRUD($mysqli);
        
        
        if($_POST["texts"] != 0){
            
            $loop = count($_POST["texts"]["values"]);
            
            //put data into array
            for($x = 0; $x < $loop; $x++) {
                $timestamps[]   = date("Y-m-d H:i:s"); 
            }
            
            //prepare array
            $data = array(
                "event_id"=>$_POST["texts"]["events"],
                "user_id"=>$_POST["texts"]["users"],
                "category_id"=>$_POST["texts"]["categories"],
                "input_no"=>$_POST["texts"]["inputsNos"],
                "input_type"=>$_POST["texts"]["inputsTypes"],
                "input_value"=>$_POST["texts"]["values"],
                "participant_no"=>$_POST["texts"]["participants"],
                "participant_no_overall"=>$_POST["texts"]["participantsOverall"],
                "created_at"=>$timestamps
            );
            
            //set loop
            $crud->loop = $loop;

            //set data
            $crud->data = $data;

            //set table name
            $crud->table = "event_registration_data";

            //insert multiple
            $crud->createMultipleV2();
            
        }
        
        if($_POST["textareas"] != 0){
            
            $loop = count($_POST["textareas"]["values"]);
            
            //put data into array
            for($x = 0; $x < $loop; $x++) {
                $timestamps[]   = date("Y-m-d H:i:s"); 
            }
            
            //prepare array
            $data = array(
                "event_id"=>$_POST["textareas"]["events"],
                "user_id"=>$_POST["textareas"]["users"],
                "category_id"=>$_POST["textareas"]["categories"],
                "input_no"=>$_POST["textareas"]["inputsNos"],
                "input_type"=>$_POST["textareas"]["inputsTypes"],
                "input_value"=>$_POST["textareas"]["values"],
                "participant_no"=>$_POST["textareas"]["participants"],
                "participant_no_overall"=>$_POST["textareas"]["participantsOverall"],
                "created_at"=>$timestamps
            );
            
            //set loop
            $crud->loop = $loop;

            //set data
            $crud->data = $data;

            //set table name
            $crud->table = "event_registration_data";

            //insert multiple
            $crud->createMultipleV2();
        }
        
        
        
        
        if($_POST["dropdowns"] != 0){
            
            $loop = count($_POST["dropdowns"]["values"]);
            
            //put data into array
            for($x = 0; $x < $loop; $x++) {
                $timestamps[]   = date("Y-m-d H:i:s"); 
            }
            
            //prepare array
            $data = array(
                "event_id"=>$_POST["dropdowns"]["events"],
                "user_id"=>$_POST["dropdowns"]["users"],
                "category_id"=>$_POST["dropdowns"]["categories"],
                "input_no"=>$_POST["dropdowns"]["inputsNos"],
                "input_type"=>$_POST["dropdowns"]["inputsTypes"],
                "input_value"=>$_POST["dropdowns"]["values"],
                "participant_no"=>$_POST["dropdowns"]["participants"],
                "participant_no_overall"=>$_POST["dropdowns"]["participantsOverall"],
                "created_at"=>$timestamps
            );
            
            //set loop
            $crud->loop = $loop;

            //set data
            $crud->data = $data;

            //set table name
            $crud->table = "event_registration_data";

            //insert multiple
            $crud->createMultipleV2();
        }
        
        if($_POST["radios"] != 0){
            
            $loop = count($_POST["radios"]["values"]);
            
            //put data into array
            for($x = 0; $x < $loop; $x++) {
                $timestamps[]   = date("Y-m-d H:i:s"); 
            }
            
            //prepare array
            $data = array(
                "event_id"=>$_POST["radios"]["events"],
                "user_id"=>$_POST["radios"]["users"],
                "category_id"=>$_POST["radios"]["categories"],
                "input_no"=>$_POST["radios"]["inputsNos"],
                "input_type"=>$_POST["radios"]["inputsTypes"],
                "input_value"=>$_POST["radios"]["values"],
                "participant_no"=>$_POST["radios"]["participants"],
                "participant_no_overall"=>$_POST["radios"]["participantsOverall"],
                "created_at"=>$timestamps
            );
            
            //set loop
            $crud->loop = $loop;

            //set data
            $crud->data = $data;

            //set table name
            $crud->table = "event_registration_data";

            //insert multiple
            $crud->createMultipleV2();
        }
        
        if($_POST["checkboxes"] != 0){
            
            $loop = count($_POST["checkboxes"]["values"]);
            
            //put data into array
            for($x = 0; $x < $loop; $x++) {
                $timestamps[]   = date("Y-m-d H:i:s"); 
            }
            
            //prepare array
            $data = array(
                "event_id"=>$_POST["checkboxes"]["events"],
                "user_id"=>$_POST["checkboxes"]["users"],
                "category_id"=>$_POST["checkboxes"]["categories"],
                "input_no"=>$_POST["checkboxes"]["inputsNos"],
                "input_type"=>$_POST["checkboxes"]["inputsTypes"],
                "input_value"=>$_POST["checkboxes"]["values"],
                "participant_no"=>$_POST["checkboxes"]["participants"],
                "participant_no_overall"=>$_POST["checkboxes"]["participantsOverall"],
                "created_at"=>$timestamps
            );
            
            //set loop
            $crud->loop = $loop;

            //set data
            $crud->data = $data;

            //set table name
            $crud->table = "event_registration_data";

            //insert multiple
            $crud->createMultipleV2();
        }
        
        if($_POST["contacts"] != 0){
            
            $loop = count($_POST["contacts"]["values"]);
            
            //put data into array
            for($x = 0; $x < $loop; $x++) {
                $timestamps[]   = date("Y-m-d H:i:s"); 
            }
 
            $data = array(
                "event_id"=>$_POST["contacts"]["events"],
                "user_id"=>$_POST["contacts"]["users"],
                "category_id"=>$_POST["contacts"]["categories"],
                "input_no"=>$_POST["contacts"]["inputsNos"],
                "input_type"=>$_POST["contacts"]["inputsTypes"],
                "input_value"=>$_POST["contacts"]["values"],
                "participant_no"=>$_POST["contacts"]["participants"],
                "participant_no_overall"=>$_POST["contacts"]["participantsOverall"],
                "created_at"=>$timestamps
            );
            
            //set loop
            $crud->loop = $loop;

            //set data
            $crud->data = $data;

            //set table name
            $crud->table = "event_registration_data";

            //insert multiple
            $crud->createMultipleV2();
        }
        
        if($_POST["icNos"] != 0){
            
            $loop = count($_POST["icNos"]["values"]);
            
            //put data into array
            for($x = 0; $x < $loop; $x++) {
                $timestamps[]   = date("Y-m-d H:i:s"); 
            }
 
            $data = array(
                "event_id"=>$_POST["icNos"]["events"],
                "user_id"=>$_POST["icNos"]["users"],
                "category_id"=>$_POST["icNos"]["categories"],
                "input_no"=>$_POST["icNos"]["inputsNos"],
                "input_type"=>$_POST["icNos"]["inputsTypes"],
                "input_value"=>$_POST["icNos"]["values"],
                "input_value_extra"=>$_POST["icNos"]["valuesExtras"],
                "participant_no"=>$_POST["icNos"]["participants"],
                "participant_no_overall"=>$_POST["icNos"]["participantsOverall"],
                "created_at"=>$timestamps
            );
            
            //set loop
            $crud->loop = $loop;

            //set data
            $crud->data = $data;

            //set table name
            $crud->table = "event_registration_data";

            //insert multiple
            $crud->createMultipleV2();
        }
        
        if($_POST["registerFor"] != 0){
            
            $loop = count($_POST["registerFor"]["values"]);
            
            //put data into array
            for($x = 0; $x < $loop; $x++) {
                $timestamps[]   = date("Y-m-d H:i:s"); 
            }
 
            $data = array(
                "for_user"=>$_POST["registerFor"]["users"],
                "for_event"=>$_POST["registerFor"]["events"],
                "for_category"=>$_POST["registerFor"]["categories"],
                "for_participant_no"=>$_POST["registerFor"]["participants"],
                "for_value"=>$_POST["registerFor"]["values"],
                "for_created_at"=>$timestamps
            );
            
            //set loop
            $crud->loop = $loop;

            //set data
            $crud->data = $data;

            //set table name
            $crud->table = "event_registration_for";

            //insert multiple
            $crud->createMultipleV2();
            
        }
        
        if(isset($_POST["emergency"])){
            
            if(!isset($_SESSION["id"])){
                $user_id = $_SESSION["user_temporary_id"];
            } else {
                $user_id = $_SESSION["id"];
            }
 
            $data = array(
                "emergency_user"=>$user_id,
                "emergency_event"=>$_POST["emergency"]["event"],
                "emergency_is_leader"=>$_POST["emergency"]["isLeader"],
                "emergency_name"=>$_POST["emergency"]["name"],
                "emergency_relationship"=>$_POST["emergency"]["relationship"],
                "emergency_number"=>$_POST["emergency"]["number"],
                "emergency_email"=>$_POST["emergency"]["email"],
                "emergency_created_at"=>date("Y-m-d H:i:s")
            );
            
            $crud->table = "event_registration_emergency";
            $crud->data = $data;
            $crud->createV2();
        }
        
        
        echo json_encode(array("status"=>$crud->status));
    }
    
    
}




include_once "../inc/app-bottom.php"; 

?>