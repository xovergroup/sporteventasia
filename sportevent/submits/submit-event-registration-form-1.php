<?php 

include_once "../inc/app-top-index.php";
include_once "../organizer/classes/CRUD.php";
include_once "../organizer/classes/Order.php";
include_once "../organizer/classes/CustomDateTime.php";
include_once "../organizer/classes/State.php";


    

if($_POST){
    
    $crud       = new CRUD($mysqli);
    $order      = new Order($mysqli, "SELECT register_order_no FROM event_registration ORDER BY register_id DESC LIMIT 1");
    $category   = new CRUD($mysqli);
    $datetime   = new CustomDateTime();
    $state      = new State();
    
    if(isset($_POST["action"]) && $crud->sanitizeStringV3($_POST["action"]) == "registerEventFormOne"){
        
        $data                           = json_decode($_POST["selectedCategory"]);
        $count_data                     = count($data);
        $order_no                       = $order->generateNewOrderNo();
        $_SESSION["current_order_no"]   = $order_no; 
        
        //other data
        if(!isset($_SESSION["id"])){
            $user_id = "SE".$_SESSION["user_temporary_id"];
        } else {
            $user_id = $_SESSION["id"];
        }
        
        
        
        //put data into array
        for($x = 0; $x < $count_data; $x++) {
            
            $category_ids[] = $data[$x]->id;
            $quantities[]   = intval($data[$x]->quantity) * intval($data[$x]->pax);
            $categoryNos[]  = $data[$x]->categoryNo;
            
            $user_ids[]     = $user_id;
            $timestamps[]   = date("Y-m-d H:i:s"); 
            
            //check price
            $category->sql  = "SELECT * FROM `event_category` WHERE `event_category`.`event_category_id` = ".intval($data[$x]->id);
            $the_category   = $category->selectOne();
            
            $datetime->getDateDiff(date("Y-m-d"), $the_category->event_category_fees_early_bird_date_end);
            if($datetime->number >= 1){
                $prices[]               = $the_category->event_category_fees_early_bird;
                $total_prices[]         = $the_category->event_category_fees_early_bird * intval($data[$x]->quantity);
                $early_bird_statuses[] = 1;
            } else {
                $prices[]       = $the_category->event_category_fees;
                $total_prices[] = $the_category->event_category_fees * intval($data[$x]->quantity);
                $early_bird_statuses[] = 0;
                
            }
            
            //order nos
            $order_nos[] = $order_no;
        }
        
        //prepare array
        $data = array(
            "register_order_no"=>$order_nos,
            "register_category"=>$category_ids,
            "register_total_pax"=>$quantities, 
            "register_user"=>$user_ids, 
            "register_early_bird_price"=>$early_bird_statuses, 
            "register_price"=>$prices, 
            "register_total_price"=>$total_prices, 
            "register_created_at"=>$timestamps 
        );
        
        //set loop
        $crud->loop = $count_data;
        
        //set data
        $crud->data = $data;
        
        //set table name
        $crud->table = "event_registration";
        
        //insert multiple
        $crud->createMultipleV2();
        
        
        
        
        
        
        echo json_encode(array("status"=>$crud->status, "user_temporary_id"=>$_SESSION["user_temporary_id"], "user_id"=>$user_id));
        
    }
    
    
}




include_once "../inc/app-bottom.php"; 

?>