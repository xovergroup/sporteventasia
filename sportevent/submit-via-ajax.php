<?php 

include_once "inc/app-top.php";
include_once "organizer/classes/CRUD.php";
include_once "organizer/classes/CustomDateTime.php";
include_once "organizer/classes/State.php";


    

if($_POST){
    
    $crud = new CRUD($mysqli);
    $datetime = new CustomDateTime();
    $state = new State();
    
    if(isset($_POST["action"]) && $crud->sanitizeStringV3($_POST["action"]) == "viewMoreEvent"){
        
        $organizer_id = intval($_POST["organizerId"]);
        
        $crud->sql = "SELECT * FROM `events` WHERE `events`.`event_organizer` = ".$organizer_id. " ORDER BY `events`.`event_date_start` DESC";
        $crud->selectAll();
        
        if($crud->total > 0){
            
            while($row = $crud->result->fetch_object()){
                $html .= '
                
                <div class="event-box-3 each-event">
                    <div class="event-img-box">
                        <a href="event-detail.php">
                            <img src="'.$row->event_thumbnail.'">
                            <div class="corner-left-wrapper">
                                <div class="corner-left"></div>
                            </div>
                            <div class="corner-right-wrapper">
                                <div class="corner-right"></div>
                            </div>
                        </a>
                    </div>
                    <div class="event-content">
                        <p class="text-red">'.$datetime->convertDateTime($row->event_date_start, "j F Y").'</p>
                        <h2>'.$row->event_name.'</h2>
                        <p>'.$row->event_location.','. $state->getStateName($row->event_state).'</p>
                    </div>
                </div>
                
                ';
            } $crud->result->close(); 
            
            
        } else {
            $html = "No data";
        }
        
        echo json_encode(array("status"=>$crud->status, "html"=>$html));
        
    } elseif(isset($_POST["action"]) && $crud->sanitizeStringV3($_POST["action"]) == "viewLessEvent"){
        
        $organizer_id = intval($_POST["organizerId"]);
        
        $crud->sql = "SELECT * FROM `events` WHERE `events`.`event_organizer` = ".$organizer_id. " ORDER BY `events`.`event_date_start` DESC LIMIT 3";
        $crud->selectAll();
        
        if($crud->total > 0){
            
            while($row = $crud->result->fetch_object()){
                $html .= '
                
                <div class="event-box-3 each-event">
                    <div class="event-img-box">
                        <a href="event-detail.php">
                            <img src="'.$row->event_thumbnail.'">
                            <div class="corner-left-wrapper">
                                <div class="corner-left"></div>
                            </div>
                            <div class="corner-right-wrapper">
                                <div class="corner-right"></div>
                            </div>
                        </a>
                    </div>
                    <div class="event-content">
                        <p class="text-red">'.$datetime->convertDateTime($row->event_date_start, "j F Y").'</p>
                        <h2>'.$row->event_name.'</h2>
                        <p>'.$row->event_location.','. $state->getStateName($row->event_state).'</p>
                    </div>
                </div>
                
                ';
            } $crud->result->close(); 
            
            
        } else {
            $html = "No data";
        }
        
        echo json_encode(array("status"=>$crud->status, "html"=>$html));
        
    } elseif(isset($_POST["action"]) && $crud->sanitizeStringV3($_POST["action"]) == "viewMoreReview"){
        
        $organizer_id = intval($_POST["organizerId"]);
        
        $crud->sql = "SELECT `users`.`user_full_name`, `events`.`event_name`, `event_review`.`review_rate`, `event_review`.`review_desc`, `event_review`.`review_desc`, `event_review`.`review_created_at` 
        FROM users, events, event_review WHERE 
        `users`.`user_id` = `event_review`.`review_user` AND 
        `events`.`event_id` = `event_review`.`review_event` AND 
        `events`.`event_organizer` = ".$organizer_id." 
        ORDER BY `event_review`.`review_created_at` DESC";
        $crud->selectAll();
        
        if($crud->total > 0){
            
            while($row = $crud->result->fetch_object()){
                $html .= '
                
                <div class="p-3 mb-3 bg-white each-review">
                    <div class="row">
                        <div class="col-auto review-profile">
                            <img src="img/Facebook_Color.png">
                        </div>
                        <div class="col-md">
                            <p><a href="" class="font-weight-bold">'.$row->user_full_name.'</a> Reviewed '.$row->review_rate.' star on <a href="" class="txt-orange">'.$row->event_name.'</a></p>
                            <p class="text-secondary">'.$datetime->convertDateTime($row->review_created_at, "Y-m-d").' '.$datetime->convertDateTime($row->review_created_at, "g:iA").'</p>
                        </div>
                    </div>
                    <div class="row">
                        <p class="txt-yellow col-auto star-rating" data-rate="'.$row->review_rate.'">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </p> 

                        <p class="">'.number_format($row->review_rate, 1).'</p>
                    </div>
                    <div>
                     <p>'.$row->review_desc.'</p>
                    </div>
                </div>
                
                
                
                ';
            } $crud->result->close(); 
            
            
        } else {
            $html = "No data";
        }
        
        echo json_encode(array("status"=>$crud->status, "html"=>$html));
        
    } elseif(isset($_POST["action"]) && $crud->sanitizeStringV3($_POST["action"]) == "viewLessReview"){
        
        $organizer_id = intval($_POST["organizerId"]);
        
        $crud->sql = "SELECT `users`.`user_full_name`, `events`.`event_name`, `event_review`.`review_rate`, `event_review`.`review_desc`, `event_review`.`review_desc`, `event_review`.`review_created_at` 
        FROM users, events, event_review WHERE 
        `users`.`user_id` = `event_review`.`review_user` AND 
        `events`.`event_id` = `event_review`.`review_event` AND 
        `events`.`event_organizer` = ".$organizer_id." 
        ORDER BY `event_review`.`review_created_at` DESC LIMIT 3";
        $crud->selectAll();
        
        if($crud->total > 0){
            
            while($row = $crud->result->fetch_object()){
                $html .= '
                
                <div class="p-3 mb-3 bg-white each-review">
                    <div class="row">
                        <div class="col-auto review-profile">
                            <img src="img/Facebook_Color.png">
                        </div>
                        <div class="col-md">
                            <p><a href="" class="font-weight-bold">'.$row->user_full_name.'</a> Reviewed '.$row->review_rate.' star on <a href="" class="txt-orange">'.$row->event_name.'</a></p>
                            <p class="text-secondary">'.$datetime->convertDateTime($row->review_created_at, "Y-m-d").' '.$datetime->convertDateTime($row->review_created_at, "g:iA").'</p>
                        </div>
                    </div>
                    <div class="row">
                        <p class="txt-yellow col-auto star-rating" data-rate="'.$row->review_rate.'">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </p> 

                        <p class="">'.number_format($row->review_rate, 1).'</p>
                    </div>
                    <div>
                     <p>'.$row->review_desc.'</p>
                    </div>
                </div>
                
                
                
                ';
            } $crud->result->close(); 
            
            
        } else {
            $html = "No data";
        }
        
        echo json_encode(array("status"=>$crud->status, "html"=>$html));
        
    } elseif(isset($_POST["action"]) && $crud->sanitizeStringV3($_POST["action"]) == "viewMoreUpcomingEvents"){
        
        
        $crud->sql = "SELECT event_id, event_thumbnail, event_date_start, event_name, event_location, event_state FROM events WHERE event_date_start >= '".date('Y-m-d')."' ORDER BY event_date_start ASC";
        $crud->selectAll();
        if($crud->total > 0){
            while($row = $crud->result->fetch_object()){

                $html .= '
                <div class="event-box-3 each-upcoming-event">
                    <div class="event-img-box">
                        <a href="event-detail.php?event_id='.$row->event_id.'">
                            <img src="'.$row->event_thumbnail.'">
                            <div class="corner-left-wrapper">
                                <div class="corner-left"></div>
                            </div>
                            <div class="corner-right-wrapper">
                                <div class="corner-right"></div>
                            </div>
                        </a>
                    </div>
                    <div class="event-content">
                        <p class="text-red">'.$datetime->convertDateTime($row->event_date_start, "j F Y").'</p>
                        <h2>'.$row->event_name.'</h2>
                        <p>'.$row->event_location.', '.$state->getStateName($row->event_state).'</p>
                        <button class="btn-outline-red"></button>
                    </div>
                </div>
                ';
                
               
                        
        } $crud->result->close(); }


        echo json_encode(array("status"=>$crud->status, "html"=>$html));

    } elseif(isset($_POST["action"]) && $crud->sanitizeStringV3($_POST["action"]) == "viewLessUpcomingEvents"){
        
        
        $crud->sql = "SELECT event_id, event_thumbnail, event_date_start, event_name, event_location, event_state FROM events WHERE event_date_start >= '".date('Y-m-d')."' ORDER BY event_date_start ASC LIMIT 9";
        $crud->selectAll();
        if($crud->total > 0){
            while($row = $crud->result->fetch_object()){

                $html .= '
                <div class="event-box-3 each-upcoming-event">
                    <div class="event-img-box">
                        <a href="event-detail.php?event_id='.$row->event_id.'">
                            <img src="'.$row->event_thumbnail.'">
                            <div class="corner-left-wrapper">
                                <div class="corner-left"></div>
                            </div>
                            <div class="corner-right-wrapper">
                                <div class="corner-right"></div>
                            </div>
                        </a>
                    </div>
                    <div class="event-content">
                        <p class="text-red">'.$datetime->convertDateTime($row->event_date_start, "j F Y").'</p>
                        <h2>'.$row->event_name.'</h2>
                        <p>'.$row->event_location.', '.$state->getStateName($row->event_state).'</p>
                        <button class="btn-outline-red"></button>
                    </div>
                </div>
                ';
                
               
                        
        } $crud->result->close(); }


        echo json_encode(array("status"=>$crud->status, "html"=>$html));

    } elseif(isset($_POST["action"]) && $crud->sanitizeStringV3($_POST["action"]) == "searchUpcomingEvents"){
        
        $event_state    = intval($_POST["event_state"]);
        $event_tag      = intval($_POST["event_tag"]);
        
        if($event_state == 0 && $event_tag == 0){
            $crud->sql = "SELECT event_id, event_thumbnail, event_date_start, event_name, event_location, event_state FROM events WHERE event_date_start >= '".date('Y-m-d')."' ORDER BY event_date_start ASC";
        } elseif($event_state != 0 && $event_tag == 0){
            $crud->sql = "SELECT event_id, event_thumbnail, event_date_start, event_name, event_location, event_state FROM events WHERE event_date_start >= '".date('Y-m-d')."' AND event_state = ".$event_state." ORDER BY event_date_start ASC";
        } elseif($event_state == 0 && $event_tag != 0){
            $crud->sql = "SELECT * FROM `events`, `event_tag` WHERE `events`.`event_id` = `event_tag`.`event_tag_event` AND `events`.`event_date_start` >= '".date('Y-m-d')."' AND `event_tag`.`event_tag_tag` = ".$event_tag. " ORDER BY `events`.`event_date_start` ASC";
        } elseif($event_state != 0 && $event_tag != 0){
            $crud->sql = "SELECT * FROM `events`, `event_tag` WHERE `events`.`event_id` = `event_tag`.`event_tag_event` AND `events`.`event_date_start` >= '".date('Y-m-d')."' AND `event_tag`.`event_tag_tag` = ".$event_tag. "  AND `events`.`event_state` = ".$event_state." ORDER BY `events`.`event_date_start` ASC";
        }
        
        $crud->selectAll();
        if($crud->total > 0){
            while($row = $crud->result->fetch_object()){

                $html .= '
                <div class="event-box-3 each-upcoming-event">
                    <div class="event-img-box">
                        <a href="event-detail.php?event_id='.$row->event_id.'">
                            <img src="'.$row->event_thumbnail.'">
                            <div class="corner-left-wrapper">
                                <div class="corner-left"></div>
                            </div>
                            <div class="corner-right-wrapper">
                                <div class="corner-right"></div>
                            </div>
                        </a>
                    </div>
                    <div class="event-content">
                        <p class="text-red">'.$datetime->convertDateTime($row->event_date_start, "j F Y").'</p>
                        <h2>'.$row->event_name.'</h2>
                        <p>'.$row->event_location.', '.$state->getStateName($row->event_state).'</p>
                        <button class="btn-outline-red"></button>
                    </div>
                </div>
                ';
                        
        } $crud->result->close(); }


        echo json_encode(array("status"=>$crud->status, "html"=>$html));

    }
    
    
}




include_once "inc/app-bottom.php"; 

?>