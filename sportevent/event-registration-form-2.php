<?php 

include_once "inc/app-top.php";
include_once "organizer/classes/CRUD.php";
include_once "organizer/classes/CustomDateTime.php";
//include_once "organizer/classes/Session.php";
include_once "organizer/classes/Miscellaneous.php";


echo "user id: ".$_SESSION["id"]."<br>";
echo "user temporary id: ".$_SESSION["user_temporary_id"]."<br>";
echo "user current order no: ".$_SESSION["current_order_no"]."<br>";
echo "user current register event: ".$_SESSION["user_registering_event"]."<br>";
var_dump($_SESSION);

    
$crud           = new CRUD($mysqli);
$swipers        = new CRUD($mysqli);
$inputs         = new CRUD($mysqli);
$options        = new CRUD($mysqli);
$customDateTime = new CustomDateTime();
$misc           = new Miscellaneous();
//$session        = new Session();


$crud->sql = "UPDATE event_registration SET register_user = '".$_SESSION["id"]."' WHERE register_user = '".$_SESSION["user_temporary_id"]."'";
$crud->updateV2();

$event_id = intval($_GET["event_id"]);

$crud->sql = "SELECT event_id, event_name, event_thumbnail FROM events WHERE event_id = ".$event_id;
$the_event = $crud->selectOne();

$crud->sql = "SELECT * FROM `event_category`, `event_registration` WHERE `event_category`.`event_category_id` = `event_registration`.`register_category` AND `event_registration`.`register_user` = '".$_SESSION["id"]."' ORDER BY `event_category`.`event_category_id` ASC";
$crud->selectAll();

$swipers->sql = "SELECT * FROM `event_category`, `event_registration` WHERE `event_category`.`event_category_id` = `event_registration`.`register_category` AND `event_registration`.`register_user` = '".$_SESSION["id"]."' ORDER BY `event_category`.`event_category_id` ASC";
$swipers->selectAll();

$date_today = $customDateTime->dateTimeNow('Y-m-d');
$time_now = $customDateTime->dateTimeNow('H:i');
    





?>


<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Event Registration Form</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<?php include_once "inc/inc-css.php"; ?>
</head>
<body>

<div id="main-body">

	<?php include_once "inc/header.php"; ?>
    
    
    	<div class="bg-black pt-5">
        	<div class="container">
            	<div class="row pt-5 pb-3 align-items-center">
                	<div class="col txt-center">
                    	<img src="img/event-reg-1.png" class="col-md-3 opa-5">
                    	<p class="txt-gray">1. Select Category</p>
                    </div>
                    <div class="col-1 txt-center">
                    	<p class="txt-gray">></p>
                    </div>
                    <div class="col txt-center">
                    	<img src="img/event-reg-2.png" class="col-md-3">
                    	<p class="txt-white">2. Fill Information</p>
                    </div>
                    <div class="col-1 txt-center">
                    	<p class="txt-gray">></p>
                    </div>
                    <div class="col txt-center">
                    	<img src="img/event-reg-3.png" class="col-md-3 opa-5">
                    	<p class="txt-gray">3. Checkout</p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="bg-white pt-3 pb-3">
        	<div class="container">
                <div class="row align-items-center">
                	<div class="col-md-2">
                    	<img src="<?php echo $the_event->event_thumbnail; ?>">
                    </div>
                    <div class="col-md-6">
                        <h2 class="event-name" data-event="<?php echo $event_id; ?>"><?php echo $the_event->event_name; ?></h2>
                        <a href="event-detail.php?event_id=<?php echo $the_event->event_id; ?>" class="txt-orange">View Event</a>
                    </div>
                    <div class="col-md-4">
            			<div class="price-dropdown row float-right align-items-center">
                            <div class="col-2 txt-right">
                                <img src="img/event-register-price.png">
                            </div>
                            <div class="col-auto">
                                <h3>RM <span class="grand-total"></span></h3>
                                <p class="txt-orange"><span class="total-participant">3</span> Participants / 0 Items</p>
                            </div>
                            <div class="col-1">
                            	<br>
                            	<i class="fas fa-caret-down"></i>
                            </div>
                            <div class="price-dropdown-content">
                            	<h4 class="mb-2 txt-center">Your Cart</h4>
                                <div class="price-dropdown-inner">
                                   
                                   
                                    <?php 
                                    
                                    if($crud->total > 0){
                                        while($row = $crud->result->fetch_object()){
                                            
                                            $grand_total += $row->register_total_price;
                                            
                                    ?>
                                    <div class="bg-white row m-1 p-2">
                                        <div class="col">
                                            <h4><?php echo $row->event_category_name; ?></h4>
                                            <p class="txt-orange"><span class="category-participant"><?php echo $row->register_total_pax; ?></span> Participants</p>
                                        </div>
                                        <div class="col-auto">
                                            <h5>RM <?php echo $row->register_total_price; ?></h5>
                                        </div>
                                    </div>
                                    <?php } $crud->result->close(); } ?>
                                   
                                    
                                    
                                </div>
                                <div class="txt-center">
                                	<p>Grand Total: RM <span class="dropdown-grand-total"><?php echo $grand_total; ?></span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="bg-gray pt-3 pb-3">
        	<div class="container">
            	<h2>Participants Information</h2>
                
                <div class="bg-white event-form-category">
                    <div class="p-3">
                		<div class="swiper-container swiper-event-category no-padding">
                            <div class="swiper-wrapper">
                               
                                <?php 
                                    
                                    if($swipers->total > 0){
                                        $counter = 1;
                                        while($row = $swipers->result->fetch_object()){
                                            
                                ?>
                                <div class="swiper-slide">
                                	<div class="bg-lightOrange p-3 m-2">
                                    	<h3 class="pl-1"><?php echo $row->event_category_name; ?></h3>
                                        <button class="event-category-remove" data-register="<?php echo $row->register_id; ?>" data-register-category="<?php echo $row->register_category; ?>"><i class="fas fa-times"></i></button>
                                        <div class="row no-gutters">
                                           
                                            <?php 
                                    
                                                for($x = 0; $x < $row->register_total_pax; $x++) { 
                                                    if($counter == 1){
                                            ?>
                                            <div class="bg-red col-auto p-3 m-2 txt-white slide-form" data-slide="">
                                                <h4><i class="fas fa-user-circle"></i> Participant #<?php echo $x + 1; ?></h4>
                                                <p><?php echo $row->event_category_name ?></p>
                                            </div>
                                            <?php } else { ?>
                                            <div class="bg-white col-auto p-3 m-2 slide-form">
                                                <h4><i class="fas fa-user-circle"></i> Participant #<?php echo $x + 1; ?></h4>
                                                <p><?php echo $row->event_category_name ?></p>
                                            </div>
                                            <?php } $counter++; } ?>
                                            
                                        </div>
                                    </div>
                                </div>
                                <?php } $swipers->result->close(); } ?>
                                
                            </div>
                            <div class="swiper-scrollbar"></div>
                        </div>
                    </div>
                </div>
                
                
                
                
                
                <?php 
                
                    $crud->sql = "SELECT * FROM `event_category`, `event_registration` WHERE 
                                    `event_category`.`event_category_id` = `event_registration`.`register_category` AND 
                                    `event_registration`.`register_user` = '".$_SESSION["id"]."' ORDER BY `event_category`.`event_category_number` ASC";
                    $crud->selectAll();
                    if($crud->total > 0){
                        while($row = $crud->result->fetch_object()){
                            for($x = 0; $x < $row->register_total_pax; $x++) {
                                
                                $rand_gender = $misc->generateRandStr();
                                
                ?>
                
                <div class="bg-white mt-5 mb-5 pt-3 pb-3 pl-4 pr-4 participant-detail-container" data-event="<?php echo $row->event_category_event; ?>" data-user="<?php echo $_SESSION["id"]; ?>" data-category="<?php echo $row->event_category_id; ?>" data-participant="<?php echo $x+1; ?>" data-container="">
                    <h2>[<?php echo $row->event_category_name; ?>] Participant Detail <span class="txt-orange">#<?php echo $x+1; ?> </span></h2>
                    <div class="row mb-3">
                    	<div class="col-md register-for-radio-input">
                            <p>Register For</p>
                            <input type="radio" class="radio-name-process" name="register_for_" value="1">Myself
                            <input type="radio" class="radio-name-process" name="register_for_" value="2">Someone else
                        </div>
                    </div>
                    
                    
                    
                    <?php 
                    
                        /*
                        input type 1: text 
                        input type 2: textarea 
                        input type 3: date 
                        input type 4: time 
                        input type 5: dropdown 
                        input type 6: checkbox 
                        input type 7: radio buttons 
                        input type 8: malaysian states 
                        input type 9: countries 
                        input type 10: ic/passport 
                        input type 11: gender 
                        input type 12: contact 
                        */
                                
                        $inputs->sql = "SELECT * FROM `event_input` WHERE `event_input_event` = ".$row->event_category_event." AND `event_input_category` = ".$row->event_category_number." ORDER BY `event_input_number` ASC";
                        $inputs->selectAll();
                        if($inputs->total > 0){
                            while($input = $inputs->result->fetch_object()){
                    
                    ?>
                    
                    
                    
                    <?php if($input->event_input_type == 1){ ?>
                    <div class="row mb-3" data-input-no="<?php echo $input->event_input_number; ?>" data-input-type="<?php echo $input->event_input_type; ?>">
                        <div class="col-md-4">
                            <p><?php echo $input->event_input_label_name; ?></p>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="col-md-11 bg-gray no-border p-2 input-type-text" placeholder="<?php echo $input->event_input_label_name; ?>">
                        </div>
                    </div>
                    <?php } ?>
                    
                    
                    
                    <?php if($input->event_input_type == 2){ ?>
                    <div class="row mb-3" data-input-no="<?php echo $input->event_input_number; ?>" data-input-type="<?php echo $input->event_input_type; ?>">
                        <div class="col-md-4">
                            <p><?php echo $input->event_input_label_name; ?></p>
                        </div>
                        <div class="col-md-8">
                            <textarea class="col-md-11 bg-gray no-border p-2 input-type-textarea"></textarea>
                        </div>
                    </div>
                    <?php } ?>
                    
                    
                    <?php if($input->event_input_type == 3){ ?>
                    <div class="row mb-3" data-input-no="<?php echo $input->event_input_number; ?>" data-input-type="<?php echo $input->event_input_type; ?>">
                        <div class="col-md-4">
                            <p><?php echo $input->event_input_label_name; ?></p>
                        </div>
                        <div class="col-md-8" data-date-today="<?php echo $date_today; ?>">
                            <input type="date" class="date-picker input-type-text" value="">
                        </div>
                    </div>
                    <?php } ?>
                    
                    <?php if($input->event_input_type == 4){ ?>
                    <div class="row mb-3" data-input-no="<?php echo $input->event_input_number; ?>" data-input-type="<?php echo $input->event_input_type; ?>">
                        <div class="col-md-4">
                            <p><?php echo $input->event_input_label_name; ?></p>
                        </div>
                        <div class="col-md-8">
                            <input type="time" class="time-picker input-type-text" value="<?php echo $time_now; ?>">
                        </div>
                    </div>
                    <?php } ?>
                    
                    
                    
                    <?php if($input->event_input_type == 5){ ?>
                    <div class="row mb-3" data-input-no="<?php echo $input->event_input_number; ?>" data-input-type="<?php echo $input->event_input_type; ?>">
                        <div class="col-md-4">
                            <p><?php echo $input->event_input_label_name; ?></p>
                        </div>
                        <div class="col-md-8">
                            <select class="p-2 col-md-3 bg-gray no-border input-type-dropdown">
                               
                                <?php 
                                    $options->sql = "SELECT * FROM `event_option` WHERE `event_option_event` = ".$row->event_category_event." AND `event_option_category` = ".$row->event_category_number." AND `event_option_number` = ".$input->event_input_number." ORDER BY `event_option_id` ASC";
                                    $options->selectAll();
                                    if($options->total > 0){
                                        while($option = $options->result->fetch_object()){
                                ?>
                                <option value="<?php echo $option->event_option_title; ?>"><?php echo $option->event_option_title; ?></option>
                                <?php } $options->result->close(); } ?>
                                
                            </select>
                        </div>
                    </div>
                    <?php } ?>
                    
                    
                    
                    <?php if($input->event_input_type == 6){ ?>
                    <div class="row mb-3" data-input-no="<?php echo $input->event_input_number; ?>" data-input-type="<?php echo $input->event_input_type; ?>">
                        <div class="col-md-4">
                            <p><?php echo $input->event_input_label_name; ?></p>
                        </div>
                        <div class="col-md-8 checkbox-input">
                            
                            <?php 
                                $options->sql = "SELECT * FROM `event_option` WHERE `event_option_event` = ".$row->event_category_event." AND `event_option_category` = ".$row->event_category_number." AND `event_option_number` = ".$input->event_input_number." ORDER BY `event_option_id` ASC";
                                $options->selectAll();
                                if($options->total > 0){
                                    while($option = $options->result->fetch_object()){
                            ?>
                            <input type="checkbox" name="checkbox_value" value="<?php echo $option->event_option_title; ?>"><label class="check-item"><?php echo $option->event_option_title; ?></label>
                            <?php } $options->result->close(); } ?>
                            
                        </div>
                    </div>
                    <?php } ?>
                    
                    
                    
                    <?php if($input->event_input_type == 7){ ?>
                    <div class="row mb-3" data-input-no="<?php echo $input->event_input_number; ?>" data-input-type="<?php echo $input->event_input_type; ?>">
                        <div class="col-md-4">
                            <p><?php echo $input->event_input_label_name; ?></p>
                        </div>
                        <div class="col-md-8 radio-input">
                            
                            <?php 
                                $options->sql = "SELECT * FROM `event_option` WHERE `event_option_event` = ".$row->event_category_event." AND `event_option_category` = ".$row->event_category_number." AND `event_option_number` = ".$input->event_input_number." ORDER BY `event_option_id` ASC";
                                $options->selectAll();
                                if($options->total > 0){
                                    while($option = $options->result->fetch_object()){
                            ?>
                            <input type="radio" name="option_<?php echo preg_replace('/\s+/', '', $input->event_input_label_name); ?>_<?php echo ($x + 1);?>" value="<?php echo $option->event_option_title; ?>"><label class="check-item"><?php echo $option->event_option_title; ?></label>
                            <?php } $options->result->close(); } ?>
                        </div>
                    </div>
                    <?php } ?>
                    
                    

                    <?php if($input->event_input_type == 8){ ?>
                    <div class="row mb-3" data-input-no="<?php echo $input->event_input_number; ?>" data-input-type="<?php echo $input->event_input_type; ?>">
                        <div class="col-md-4">
                            <p><?php echo $input->event_input_label_name; ?></p>
                        </div>
                        <div class="col-md-8">
                            <select class="p-2 col-md-3 bg-gray no-border input-type-dropdown state-dropdown">
                                <option value="KL">Kuala Lumpur</option>
                                <option value="Selangor">Selangor</option>
                            </select>
                        </div>
                    </div>
                    <?php } ?>
                    
                    
                    
                    <?php if($input->event_input_type == 9){ ?>
                    <div class="row mb-3" data-input-no="<?php echo $input->event_input_number; ?>" data-input-type="<?php echo $input->event_input_type; ?>">
                        <div class="col-md-4">
                            <p><?php echo $input->event_input_label_name; ?></p>
                        </div>
                        <div class="col-md-8">
                            <select class="p-2 col-md-3 bg-gray no-border input-type-dropdown">
                                <option value="Malaysia">Malaysia</option>
                                <option value="Singapore">Singapore</option>
                            </select>
                        </div>
                    </div>
                    <?php } ?>
                    
                    <?php if($input->event_input_type == 10){ ?>
                    <div class="row mb-3" data-input-no="<?php echo $input->event_input_number; ?>" data-input-type="<?php echo $input->event_input_type; ?>">
                        <div class="col-md-4">
                            <p><?php echo $input->event_input_label_name; ?></p>
                        </div>
                        <div class="col-md-8 ic-container">
                            <select class="p-2 col-md-2 bg-gray no-border ic-format">
                                <option value="1" selected>NRIC New</option>
                                <option value="2">NRIC Old</option>
                                <option value="3">Passport</option>
                                <option value="4">Police No</option>
                            </select>
                            
                            <span class="extra-space-ic-form"> </span>
                            
                            <input type="text" class="col-md-2 bg-gray no-border p-2 new-ic-format new-ic-prefix" placeholder="991231">
                            <span class="col-md-1 ic-form-hyphen"> - </span>
                            <input type="text" class="col-md-1 bg-gray no-border p-2 new-ic-format new-ic-middle" placeholder="14">
                            <span class="col-md-1 ic-form-hyphen"> - </span>
                            <input type="text" class="col-md-2 bg-gray no-border p-2 new-ic-format new-ic-suffix" placeholder="9999">
                            
                        </div>
                    </div>
                    <?php } ?>
                    
                    
                    <?php if($input->event_input_type == 11){ ?>
                    <div class="row mb-3" data-input-no="<?php echo $input->event_input_number; ?>" data-input-type="<?php echo $input->event_input_type; ?>">
                        <div class="col-md-4">
                            <p><?php echo $input->event_input_label_name; ?></p>
                        </div>
                        <div class="col-md-8 radio-input">
                            
                            <input type="radio" name="option_<?php echo $rand_gender; ?>" value="Male"><label class="check-item">Male</label>
                            <input type="radio" name="option_<?php echo $rand_gender; ?>" value="Female"><label class="check-item">Female</label>
                        </div>
                    </div>
                    <?php } ?>
                    
                    
                    <?php if($input->event_input_type == 12){ ?>
                    <div class="row mb-3" data-input-no="<?php echo $input->event_input_number; ?>" data-input-type="<?php echo $input->event_input_type; ?>">
                        <div class="col-md-4">
                            <p><?php echo $input->event_input_label_name; ?></p>
                        </div>
                        <div class="col-md-8">
                            <input type="tel" class="col-md-11 bg-gray no-border p-2 plugin-contact-no" id="contact-no-">
                        </div>
                    </div>
                    <?php } ?>
                    
                    
                    
                    
                    <?php } $inputs->result->close(); }  ?>
                    
                </div>
                <?php  } } $crud->result->close(); } ?>
                
                
                
                
                
                
                
                <div class="bg-white mt-5 mb-5 pt-3 pb-3 pl-4 pr-4">
                	<h2>Emergency Person</h2>
                    <div class="row mb-3">
                    	<div class="col-md">
                        	<input type="radio" name="is_leader" value="1" class="emergency-is-leader">I am the team leader / contact emergency person
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <p>Contact Name</p>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="col-md-11 bg-gray no-border p-2 emergency-name" placeholder="Name">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <p>Relationship</p>
                        </div>
                        <div class="col-md-8">
                            <select class="p-2 col-md-3 bg-gray no-border emergency-relationship">
                                <option value="Father">Father</option>
                                <option value="Mother">Mother</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <p>Contact Number</p>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="col-md-11 bg-gray no-border p-2 emergency-number" placeholder="Contact Number">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <p>Contact Email</p>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="col-md-11 bg-gray no-border p-2 emergency-email" placeholder="Contact Email">
                        </div>
                    </div>
                </div>
                
                
                <!--
                <div class="bg-white mt-5 mb-5 pt-3 pb-3 pl-4 pr-4">
                	<h2>Merchandise(Optional)</h2>
                	<div class="row">
                    	<div class="col-md-3">
                        	<img src="img/merchandise.jpg">
                        </div>
                        <div class="col-md-7">
                        	<h3>Lorem Ipsum Merchandise</h3>
                            <p class="txt-gray">Lorem Ipsum</p>
                            <h5 class="txt-orange">RM49.90</h5>
                        </div>
                        <div class="col-md-2">
                        	 <button class="bg-red no-border p-3 txt-white font-dagger col">Add to Cart</button>
                        </div>
                    </div>
                </div>
                -->
                
                
                <div class="mt-5 mb-5 txt-right">
                    <a href="event-registration-form-3.php" class="bg-red no-border p-3 txt-white font-dagger go-to-checkout">Next Step: Checkout</a>
                </div>
            </div>
        </div>
        
        
    
    
    
    <?php include_once "inc/footer.php"; ?>


</div>

<?php include_once "inc/inc-js.php"; ?>

<script type="text/javascript" src="js/custom.js<?php echo '?'.mt_rand(); ?>"></script>
<script type="text/javascript" src="js/js-event-registration-form-2.js<?php echo '?'.mt_rand(); ?>"></script>

</body>
</html>
