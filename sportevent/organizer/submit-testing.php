<?php 
include_once "inc/app-top.php";
include_once "classes/CRUD.php";
include_once "classes/CustomArray.php";

if($_POST){
    
    $crud = new CRUD($mysqli);
    $array = new CustomArray();
    
    
    //post data
    $data_category = $crud->getKeyValueRelated($_POST, "event_category_");
    
    //set table name
    $crud->table = "event_category";
    
    //create array to match the post data
    $count_values = $array->countFirstElementOfArrayValue($data_category);
    $event_ids = $array->createArray($crud->sanitizeInt($_POST["event_id"]), $count_values);
    $data_category["event_category_event"] = $event_ids;
    $datetimes = $array->createArray(date("Y-m-d H:i:s"), $count_values);
    $data_category["event_category_created_at"] = $datetimes;
    
    //set data
    $crud->data = $data_category;
    
    //multiple insert
    $crud->createMultiple();
    
    echo $crud->sql;
    
    //post data
    $data_input = $crud->getKeyValueRelated($_POST, "event_input_");
    
    //set table name
    $crud->table = "event_input";
    
    //create array to match the post data
    $count_values = $array->countFirstElementOfArrayValue($data_input);
    $event_ids = $array->createArray($crud->sanitizeInt($_POST["event_id"]), $count_values);
    $data_input["event_input_event"] = $event_ids;
    $datetimes = $array->createArray(date("Y-m-d H:i:s"), $count_values);
    $data_input["event_input_created_at"] = $datetimes;
    
    //set data
    $crud->data = $data_input;
    
    //multiple insert
    $crud->createMultiple();
    
    
    //post data
    $count_options = count($_POST["event_option_title"]);
    if($count_options > 0){
        
        $data_option = $crud->getKeyValueRelated($_POST, "event_option_");

        //set table name
        $crud->table = "event_option";

        //create array to match the post data
        $count_values = $array->countFirstElementOfArrayValue($data_option);
        $event_ids = $array->createArray($crud->sanitizeInt($_POST["event_id"]), $count_values);
        $data_option["event_option_event"] = $event_ids;
        $datetimes = $array->createArray(date("Y-m-d H:i:s"), $count_values);
        $data_option["event_option_created_at"] = $datetimes;

        //set data
        $crud->data = $data_option;

        //multiple insert
        $crud->createMultiple();
    }
    
    
    
    //redirect
    /*if(isset($_POST["event_category_save_extra_action"]) && $crud->sanitizeStringV3($_POST["event_category_save_extra_action"]) == "goBack"){
        $url = filter_var($_POST["event_category_save_url"], FILTER_SANITIZE_URL);
        header("Location: ".$url." ");
    } else {
        header("Location: create-event-page-3.php?event_id=".$crud->sanitizeInt($_POST["event_id"]));
    }*/
    
    


?>




<pre><?php print_r($data_option); ?></pre>





<?php 

} 

include_once "inc/app-bottom.php"; 
?>