<?php

$_SESSION['page'] = "booking";

?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Booking List</title>
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
                    <h2>My Booking</h2>
                    <div class="event-news-box p-4 mb-3">
                        <div class="row">
                        	<div class="col-md-8">
                            	<a href="user-booking-detail.php"><h3>Booking No. 000001</h3></a>
                                <p>Event: Lorem Ipsum Dolor Event</p>
                            </div>
                            <div class="col-3 txt-right">
                            	<p>RM49.90</p>
                                <p class="txt-green">Successful</p>
                            </div>
                            <div class="col-1">
                            	<br>
                            	<a href="user-booking-detail.php">></a>
                            </div>
                        </div>
                        <hr>
                        <div class="">
                        	<p class="txt-gray">Group Male</p>
                            <p class="txt-gray">Individual Male</p>
                            <p class="txt-gray">Lorem Merchandise</p>
                        </div>
                    </div>
                    <div class="event-news-box p-4 mb-3">
                        <div class="row">
                        	<div class="col-md-8">
                            	<a href="user-booking-detail.php"><h3>Booking No. 000001</h3></a>
                                <p>Event: Lorem Ipsum Dolor Event</p>
                            </div>
                            <div class="col-3 txt-right">
                            	<p>RM49.90</p>
                                <p class="txt-green">Successful</p>
                            </div>
                            <div class="col-1">
                            	<br>
                            	<a href="user-booking-detail.php">></a>
                            </div>
                        </div>
                        <hr>
                        <div class="">
                        	<p class="txt-gray">Group Male</p>
                            <p class="txt-gray">Individual Male</p>
                            <p class="txt-gray">Lorem Merchandise</p>
                        </div>
                    </div>
                    <div class="event-news-box p-4 mb-3">
                        <div class="row">
                        	<div class="col-md-8">
                            	<a href="user-booking-detail.php"><h3>Booking No. 000001</h3></a>
                                <p>Event: Lorem Ipsum Dolor Event</p>
                            </div>
                            <div class="col-3 txt-right">
                            	<p>RM49.90</p>
                                <p class="txt-red">Failed</p>
                            </div>
                            <div class="col-1">
                            	<br>
                            	<a href="user-booking-detail.php">></a>
                            </div>
                        </div>
                        <hr>
                        <div class="">
                        	<p class="txt-gray">Group Male</p>
                            <p class="txt-gray">Individual Male</p>
                            <p class="txt-gray">Lorem Merchandise</p>
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
