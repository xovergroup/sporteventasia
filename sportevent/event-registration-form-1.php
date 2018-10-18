<?php 
include_once "inc/app-top-index.php";
include_once "organizer/classes/CRUD.php";
include_once "organizer/classes/CustomDateTime.php";
include_once "organizer/classes/Session.php";
include_once "organizer/classes/Miscellaneous.php";

$crud           = new CRUD($mysqli);
$customDateTime = new CustomDateTime();
$session        = new Session();
$misc           = new Miscellaneous();

if(isset($_GET["event_id"])){
    
    $event_id                           = $crud->sanitizeInt($_GET["event_id"]);
    $_SESSION["user_registering_event"] = $event_id;
    $_SESSION["user_temporary_id"]      = $misc->generateUniqueRandStr(true, true, true);
    
    
    //check
    $crud->sql = "SELECT COUNT(event_id) AS total FROM events WHERE event_id = ".$event_id;
    $validate = $crud->selectOne();
    if($validate->total < 1){
        header("Location: index.php");
    }
    
    $crud->sql = "SELECT * FROM events, organizers, states WHERE event_state = state_id AND event_organizer = organizer_id AND event_id = ".$event_id;
    $the_event = $crud->selectOne();
    
    
} else {
    header("Location: index.php");
}

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
                    	<img src="img/event-reg-1.png" class="col-md-3">
                    	<p class="txt-white">1. Select Category</p>
                    </div>
                    <div class="col-1 txt-center">
                    	<p class="txt-gray">></p>
                    </div>
                    <div class="col txt-center">
                    	<img src="img/event-reg-2.png" class="col-md-3 opa-5">
                    	<p class="txt-gray">2. Fill Information</p>
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
                        <h2 class="event-name" data-event="<?php echo $the_event->event_id; ?>"><?php echo $the_event->event_name; ?></h2>
                        <a href="" class="txt-orange">View Event</a>
                    </div>
                    <div class="col-md-4">
            			<div class="price-dropdown row float-right align-items-center">
                            <div class="col-2 txt-right">
                                <img src="img/event-register-price.png">
                            </div>
                            <div class="col-auto">
                                <h3>RM <span class="grand-total">0</span></h3>
                                <p class="txt-orange"><span class="total-pax">0</span> Pax / 0 Items</p>
                            </div>
                            <div class="col-1">
                            	<br>
                            	<i class="fas fa-caret-down"></i>
                            </div>
                            <div class="price-dropdown-content">
                            	<h4 class="mb-2 txt-center">Your Cart</h4>
                                <div class="price-dropdown-inner">
                                </div>
                                <div class="txt-center">
                                	<p>Grand Total: RM <span class="dropdown-grand-total">0</span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="bg-gray pt-3 pb-3">
        	<div class="container">
                <div class="bg-white">
                    <div class="">
                		<div class="event-category-table">
                            <table class="">
                                <tr class="border-none">
                                    <th>Category</th>
                                    <th>Description</th> 
                                    <th>Registration Date</th>
                                    <th>Price</th>
                                    <th>Action</th>
                                </tr>
                                
                                
                                 <?php 
            
                                    $crud->sql = "SELECT * FROM event_category WHERE event_category_event = ".$event_id. " ORDER BY event_category_id ASC";
                                    $crud->selectAll();
                                    if($crud->total > 0){
                                        while($row = $crud->result->fetch_object()){
                                ?>
                                
                                <tr class="each-category" data-id="<?php echo $row->event_category_id; ?>" data-category="<?php echo $row->event_category_number; ?>" data-price="0" data-quantity="0">
                                    <td>
                                        <p class="font-dagger font-16 category-name"><?php echo $row->event_category_name; ?></p>
                                        <p><span class="category-pax"><?php echo $row->event_category_pax; ?></span> Pax | <?php echo $row->event_category_limited_slot; ?> Slots</p>
                                    </td>
                                    <td>
                                        <p><?php echo $row->event_category_desc; ?></p>
                                    </td>
                                    <td>
                                        <p>Start Date: <?php echo $customDateTime->convertDateTime($row->event_category_reg_date_start, "d F Y"); ?> <br>End Date: <?php echo $customDateTime->convertDateTime($row->event_category_reg_date_end, "d F Y"); ?> </p>
                                    </td>
                                    
                                    <?php 
                                        $customDateTime->getDateDiff(date("Y-m-d"), $row->event_category_fees_early_bird_date_end);
                                        if($customDateTime->number >= 1){    
                                    ?>
                                    <td>
                                        <p class="font-dagger font-16">MYR <span class="price-early-bird"><?php echo $row->event_category_fees_early_bird; ?></span></p>
                                        <p class="txt-dashed txt-gray">MYR <span class="price-normal"><?php echo $row->event_category_fees; ?></span></p>
                                        <p class="txt-orange"><?php echo $customDateTime->msg; ?> left at this price!</p>
                                    </td>
                                    <?php } else { ?>
                                    <td>
                                        <p class="font-dagger font-16">MYR <span class="price-normal"><?php echo $row->event_category_fees; ?></span></p>
                                    </td>
                                    <?php } ?>
                                    
                                    
                                    <td class="select-category">
                                        <button class="bg-red no-border p-3 txt-white font-dagger col-6">Select</button>
                                    </td>
                                </tr>
                                <?php } $crud->result->close(); }?>
                                
                                
                                
                            </table>
                        </div>
                    </div>
                </div>
                <div class="mt-5 mb-5 txt-right">
                    <a href="event-registration-form-2.php?event_id=<?php echo $event_id; ?>" class="bg-red no-border p-3 txt-white font-dagger go-to-fill-information">Next Step: Fill Information</a>
                </div>
            </div>
        </div>
        
        
    
    
    
    <?php include_once "inc/footer.php"; ?>


</div>

<?php include_once "inc/inc-js.php"; ?>
<script type="text/javascript" src="js/custom.js<?php echo '?'.mt_rand(); ?>"></script>
<script type="text/javascript" src="js/js-event-registration-form-1.js<?php echo '?'.mt_rand(); ?>"></script>


</body>
</html>
<?php include_once "inc/app-bottom.php"; ?>