<?php

$_SESSION['page'] = "booking";

?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Booking Detail</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<?php include_once "inc/inc-css.php"; ?>
</head>
<body>

<div id="main-body">

	<?php include_once "inc/header.php"; ?>
    
    <div class="pt-5">
    	<div class="container">
        	<div class="row pt-5">
            
                <?php include_once "inc/side-nav.php"; ?>
                
                <div class="col-lg-9 ml-auto mb-5">
                    <a href="user-booking.php">< Back</a>
                    <div class="event-news-box p-4 mb-3 mt-2">
                        <div class="row">
                        	<div class="col-md-9">
                            	<a href="user-booking-detail.php"><h3>Booking No. 000001</h3></a>
                                <p>Event: Lorem Ipsum Dolor Event</p>
                            </div>
                            <div class="col-3 txt-right">
                            	<p>RM49.90</p>
                                <p class="txt-green">Successful</p>
                            </div>
                        </div>
                        <div class="">
                        	<p class="txt-orange">Participants Information</p>
                            <div class="">
                            	<p>Group Male</p>
                                <div class="bg-whitesmoke p-2 mb-2 row no-gutters">
                                	<div class="col-md">
                                    	<p class="font-weight-bold">Azmir Abdul Wahab</p>
                                    </div>
                                    <div class="col-md">
                                    	<p>NRIC New: 1234567890</p>
                                        <p>Email: abc@gmail.com</p>
                                        <p>Contact: 012345689</p>
                                        <p>Gender: Male</p>
                                        <p>T-shirt Size: L</p>
                                    </div>
                                    <div class="col-md">
                                    	<p class="txt-orange">Emergency Person</p>
                                        <p>Azim Fauzi (Father)</p>
                                        <p>abc@gmail.com</p>
                                        <p>012345689</p>
                                    </div>
                                </div>
                                <div class="bg-whitesmoke p-2 mb-2 row no-gutters">
                                	<div class="col-md">
                                    	<p class="font-weight-bold">Azmir Abdul Wahab</p>
                                    </div>
                                    <div class="col-md">
                                    	<p>NRIC/Passport/Police No: 1234567890</p>
                                        <p>Email: abc@gmail.com</p>
                                        <p>Contact: 012345689</p>
                                        <p>Gender: Male</p>
                                        <p>T-shirt Size: L</p>
                                    </div>
                                    <div class="col-md">
                                    	<p class="txt-orange">Emergency Person</p>
                                        <p>Azim Fauzi (Father)</p>
                                        <p>abc@gmail.com</p>
                                        <p>012345689</p>
                                    </div>
                                </div>
                            </div>
                            <div class="">
                            	<p>Individual Male</p>
                                <div class="bg-whitesmoke p-2 mb-2 row no-gutters">
                                	<div class="col-md">
                                    	<p class="font-weight-bold">Azmir Abdul Wahab</p>
                                    </div>
                                    <div class="col-md">
                                    	<p>NRIC/Passport/Police No: 1234567890</p>
                                        <p>Email: abc@gmail.com</p>
                                        <p>Contact: 012345689</p>
                                        <p>Gender: Male</p>
                                        <p>T-shirt Size: L</p>
                                    </div>
                                    <div class="col-md">
                                    	<p class="txt-orange">Emergency Person</p>
                                        <p>Azim Fauzi (Father)</p>
                                        <p>abc@gmail.com</p>
                                        <p>012345689</p>
                                    </div>
                                </div>
                            </div>
                            <div class="">
                            	<p>Merchandise</p>
                                <div class="bg-whitesmoke p-2 mb-2 row no-gutters">
                                	<div class="col-md">
                                    	<p class="font-weight-bold">Lorem Ipsum Merchandise</p>
                                        <p>RM49.90 | Quantity: 1</p>
                                    </div>
                                    <div class="col-md txt-right">
                                        <p>Size: L</p>
                                        <p>Color: Red</p>
                                    </div>
                                </div>
                            </div>
                           
                        </div>
                    </div>
                    
                    <div class="event-news-box p-4 mb-3">
                        <div class="">
                        	<p class="txt-orange">Payment Summary</p>
                            <p>Subtotal: RM49.90</p>
                            <p>Discount: RM20.90</p>
                            <p>Grand Total: RM20.00</p>
                            <p>Status: Success (Paid on 21 Sempter 2018)</p>
                        </div>
                    </div>
                    
                    
                    <div class="txt-center">
                        <div class="pagination float-none">
                          <a href="#">&laquo;</a>
                          <a href="#" class="active">1</a>
                          <a href="#">2</a>
                          <a href="#">3</a>
                          <a href="#">4</a>
                          <a href="#">5</a>
                          <a href="#">6</a>
                          <a href="#">&raquo;</a>
                        </div>
                    </div>
                    
                    
                </div>
            </div>
        </div>
        
    </div>
    
    
    
    <?php include_once "inc/footer.php"; ?>


</div>

<?php include_once "inc/inc-js.php"; ?>

<script type="text/javascript" src="js/custom.js<?php echo '?'.mt_rand(); ?>"></script>


</body>
</html>
