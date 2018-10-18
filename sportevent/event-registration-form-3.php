<?php 

include_once "inc/app-top.php";
include_once "organizer/classes/CRUD.php";
include_once "organizer/classes/CustomDateTime.php";
include_once "organizer/classes/Session.php";

if(isset($_SESSION["user_temporary_id"]) || isset($_SESSION["id"])){
    
    
    //echo $_SESSION["user_registering_id"];
    //echo $_SESSION["user_registering_event"];
    
    $crud = new CRUD($mysqli);
    $customDateTime = new CustomDateTime();
    $session = new Session();
    
    
    if(!isset($_SESSION["id"])){
        $user_id = $_SESSION["user_temporary_id"];
        } else {
        $user_id = $_SESSION["id"];
    }
    
    
    $event_id = intval($_GET["event_id"]);
    
    $crud->sql = "SELECT event_id, event_name, event_thumbnail FROM events WHERE event_id = ".$event_id;
    $the_event = $crud->selectOne();
    
    $crud->sql = "SELECT * FROM `event_category`, `event_registration` WHERE `event_category`.`event_category_id` = `event_registration`.`register_category` AND `event_registration`.`register_user` = '".$user_id."' ORDER BY `event_category`.`event_category_id` ASC";
    $crud->selectAll();
    
    
    
} else {
    header("Location: login.php");
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
                    	<img src="img/event-reg-1.png" class="col-md-3 opa-5">
                    	<p class="txt-gray">1. Select Category</p>
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
                    	<img src="img/event-reg-3.png" class="col-md-3">
                    	<p class="txt-white">3. Checkout</p>
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
                        <h2><?php echo $the_event->event_name; ?></h2>
                        <a href="event-detail.php?event_id=<?php echo $the_event->event_id; ?>" class="txt-orange">View Event</a>
                    </div>
                    <div class="col-md-4">
            			<div class="price-dropdown row float-right align-items-center">
                            <div class="col-2 txt-right">
                                <img src="img/event-register-price.png">
                            </div>
                            <div class="col-auto">
                                <h3>RM <span class="grand-total"></span></h3>
                                <p class="txt-orange"><span class="total-participant">3</span> Participants / 1 Items</p>
                            </div>
                            <div class="col-1">
                            	<br>
                            	<i class="fas fa-caret-down"></i>
                            </div>
                            <div class="price-dropdown-content">
                            	<h4 class="mb-2 txt-center">Your Cart</h4>
                                <div class="price-dropdown-inner">
                                   
                                    <?php 
                                    
                                    $crud->sql = "SELECT * FROM `event_category`, `event_registration` WHERE `event_category`.`event_category_id` = `event_registration`.`register_category` AND `event_registration`.`register_user` = '".$user_id."' ORDER BY `event_category`.`event_category_id` ASC";
                                    $crud->selectAll();
                                    if($crud->total > 0){
                                        while($row = $crud->result->fetch_object()){
                                            
                                            $grand_total += $row->register_total_price;
                                            
                                    ?>
                                    <div class="bg-white row m-1 p-2">
                                        <div class="col-md">
                                            <h4><?php echo $row->event_category_name; ?></h4>
                                            <p class="txt-orange"><span class="category-participant"><?php echo $row->register_total_pax; ?></span> Participants</p>
                                        </div>
                                        <div class="col-md-auto">
                                            <h5>RM  <?php echo $row->register_total_price; ?></h5>
                                        </div>
                                    </div>
                                    <?php } $crud->result->close(); } ?>
                                    
                                    <!--
                                    <div class="bg-white row m-1 p-2">
                                        <div class="col-md">
                                            <h4>ABC Merchandise</h4>
                                            <p class="txt-orange">1 Items</p>
                                        </div>
                                        <div class="col-md-auto">
                                            <h5>RM 49.90</h5>
                                        </div>
                                    </div>
                                    -->
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
            	<h2>Summary</h2>
                <div class="bg-white mt-3 mb-5 pt-3 pb-3 pl-4 pr-4">
                    <div class="">
                		<table class="col" style="text-align:left;">
                        	<tr class="border-none">
                                <th class="txt-gray">Type</th>
                                <th class="txt-gray">Description</th> 
                                <th class="txt-gray">Price</th>
                            </tr>
                            
                            
                            
                            <?php 
                                    
                            $crud->sql = "SELECT * FROM `event_category`, `event_registration` WHERE `event_category`.`event_category_id` = `event_registration`.`register_category` AND `event_registration`.`register_user` = '".$user_id."' ORDER BY `event_category`.`event_category_id` ASC";
                            $crud->selectAll();
                            if($crud->total > 0){
                                while($row = $crud->result->fetch_object()){
                                    
                                    $subtotal += $row->register_total_price;
                            ?>
                            <tr>
                            	<td width=5%><div class="p-1"><img src="img/event-register-ticket.png"></div></td>
                                <td><div class="p-1"><h3><?php echo $row->event_category_name; ?></h3><p>QTY:<?php echo $row->register_total_pax; ?></p></div></td>
                                <td><h3>RM<?php echo $row->register_total_price; ?></h3></td>
                            </tr>
                            <?php } $crud->result->close(); } ?>
                            
                            <!--
                            <tr>
                            	<td><div class="p-1"><img src="img/event-register-merchandise.png"></div></td>
                                <td><div class="p-1"><h3>Lorem Merchandise</h3><p>QTY:2</p><p class="txt-gray">Size: Small / Color: Red</p></div></td>
                                <td><h3>RM49.90</h3><a href="" class="txt-orange">Remove</a></td>
                            </tr>
                            -->
                            
                        </table>
                    </div>
                </div>
                <div class="bg-white mt-5 mb-5 pt-3 pb-3 pl-4 pr-4">
                    <div class="row">
                		<div class="col-md right-border">
                        	<input type="text" class="bg-whitesmoke p-3 no-border" placeholder="Have a Promo Code?"><button class="bg-black txt-white no-border p-3">APPLY</button>
                        </div>
                        <div class="col-md txt-right">
                        	<div class="row no-gutters">
                            	<div class="col-md">
                                	<p>Subtotal</p>
                                </div>
                                <div class="col-md">
                                	<h4>RM <span class="subtotal"><?php echo $subtotal; ?></span></h4>
                                </div>
                            </div>
                            <div class="row no-gutters">
                            	<div class="col-md">
                                	<p>Discount</p>
                                </div>
                                <div class="col-md">
                                    <h4>RM <span class="discount">0</span></h4>
                                </div>
                            </div>
                            <div class="row no-gutters">
                            	<div class="col-md">
                                	<p>Grand Total</p>
                                </div>
                                <div class="col-md">
                                	<h4 class="txt-orange">RM <span class="final-grand-total"></span></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-white mt-5 mb-5 pt-3 pb-3 pl-4 pr-4">
                    <div class="">
                		<h2>Select your payment option</h2>
                        <div class="row">
                        	<div class="payment-box payment-selected">
                            	<img src="img/pay-1.jpg">
                            </div>
                            <div class="payment-box">
                            	<img src="img/pay-2.png">
                            </div>
                            <div class="payment-box">
                            	<img src="img/pay-3.png">
                            </div>
                            <div class="payment-box">
                            	<img src="img/pay-4.png">
                            </div>
                            <div class="payment-box">
                            	<img src="img/pay-5.png">
                            </div>
                            <div class="payment-box">
                            	<img src="img/pay-6.png">
                            </div>
                            <div class="payment-box">
                            	<img src="img/pay-7.jpg">
                            </div>
                            <div class="payment-box">
                            	<img src="img/pay-8.png">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-5 mb-5 txt-right">
                    <a href="" class="bg-red no-border p-3 txt-white font-dagger">Place Order</a>
                </div>
            </div>
        </div>
        
        
    
    
    
    <?php include_once "inc/footer.php"; ?>


</div>

<?php include_once "inc/inc-js.php"; ?>

<script type="text/javascript" src="js/custom.js<?php echo '?'.mt_rand(); ?>"></script>
<script type="text/javascript" src="js/js-event-registration-form-3.js<?php echo '?'.mt_rand(); ?>"></script>

</body>
</html>
