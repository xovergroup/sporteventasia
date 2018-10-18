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
    
    if(isset($_POST["action"]) && $crud->sanitizeStringV3($_POST["action"]) == "editMerchandise"){
        
        
        //process image
        $image = $file->processImage64($_POST["image"], $url->merchandise, "../img/merchandises/", "merchandise");
        
        //prepare data
        $merchandise_id = intval($_POST["id"]);
                           
        $data = array(
            "merchandise_image"=>$image,
            "merchandise_name"=>$_POST["name"],
            "merchandise_price"=>$_POST["price"],
            "merchandise_desc"=>$_POST["description"]

        );

        $crud->table        = "merchandises";
        $crud->data         = $data;
        $crud->condition    = " WHERE merchandise_id = ".$merchandise_id;
        $crud->update();
        
        
        
        if(isset($_POST["variableData"])){
            
            $crud->table            = "merchandise_variable";
            $crud->id               = $merchandise_id;
            $crud->conditionColumn  = "variable_merchandise";
            $crud->delete();
            
            $loop = count($_POST["variableData"]["names"]);
            
            //put data into array
            for($x = 0; $x < $loop; $x++) {
                $merchandise_ids[]  = $merchandise_id; 
                $timestamps[]       = date("Y-m-d H:i:s"); 
            }
            
            //prepare array
            $data = array(
                "variable_merchandise"=>$merchandise_ids,
                "variable_no"=>$_POST["variableData"]["variables"],
                "variable_name"=>$_POST["variableData"]["names"],
                "variable_type"=>$_POST["variableData"]["types"],
                "variable_remark"=>$_POST["variableData"]["remarks"],
                "variable_require"=>$_POST["variableData"]["requires"],
                "variable_other_value"=>$_POST["variableData"]["otherValues"],
                "variable_created_at"=>$timestamps
            );
            
            //set loop
            $crud->loop = $loop;

            //set data
            $crud->data = $data;

            //set table name
            $crud->table = "merchandise_variable";

            //insert multiple
            $crud->createMultipleV2();
        }
        
        if(isset($_POST["optionData"]) && $_POST["optionData"] != 0){
            
            $crud->table            = "merchandise_option";
            $crud->id               = $merchandise_id;
            $crud->conditionColumn  = "merchandise_option_merchandise";
            $crud->delete();
            
            
           $loop = count($_POST["optionData"]["optionNos"]);
            
            //put data into array
            for($x = 0; $x < $loop; $x++) {
                $merchandise_ids[]  = $merchandise_id; 
                $timestamps[]       = date("Y-m-d H:i:s"); 
            }
            
            //prepare array
            $data = array(
                "merchandise_option_merchandise"=>$merchandise_ids,
                "merchandise_option_variable"=>$_POST["optionData"]["variables"],
                "merchandise_option_no"=>$_POST["optionData"]["optionNos"],
                "merchandise_option_title"=>$_POST["optionData"]["titles"],
                "merchandise_option_limit"=>$_POST["optionData"]["limits"],
                "merchandise_option_created_at"=>$timestamps
            );
            
            //set loop
            $crud->loop = $loop;

            //set data
            $crud->data = $data;

            //set table name
            $crud->table = "merchandise_option";

            //insert multiple
            $crud->createMultipleV2();
            
        }
        
        if(isset($_POST["eventMerchandise"]) && $_POST["eventMerchandise"] != 0){
            
            $crud->table            = "merchandise_designate";
            $crud->id               = $merchandise_id;
            $crud->conditionColumn  = "merchandise_id";
            $crud->delete();
            
            
           $loop = count($_POST["eventMerchandise"]["eventIds"]);
            
            //put data into array
            for($x = 0; $x < $loop; $x++) {
                $merchandise_ids[]  = $merchandise_id; 
                $timestamps[]       = date("Y-m-d H:i:s"); 
            }
            
            //prepare array
            $data = array(
                "merchandise_id"=>$merchandise_ids,
                "event_id"=>$_POST["eventMerchandise"]["eventIds"],
                "merchandise_for"=>$_POST["eventMerchandise"]["types"],
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
            
        }
        
        echo json_encode(array("status"=>$crud->status, "data"=>$crud->sql));
        
    }
    
}




include_once "../inc/app-bottom.php"; 

?>