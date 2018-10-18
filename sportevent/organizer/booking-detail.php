<?php 

include_once "inc/app-top.php";
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


<div>

    <?php include_once "inc/inc-sidebar.php"; ?>

    <div class="main-body">
        <div class="main-background">
            <img src="img/org-background.jpg">
            <div class="main-header">
                <div class="container-custom">
                    <?php include_once "inc/inc-header.php"; ?>
                    <img src="">
                    <div class="main-title">
                        <h2>Booking Detail</h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="main-content">
            <div class="container-custom">

                <div class="content-box">
                    <b>Booking No. 000001</b>
                    <p>Lorem Ipsum Dolor Event</p>
                </div>

                <div class="content-box">
                	<div class="row">
                    	<div class="col-md">
                        	<p class="text-danger">Registered By</p>
                            <p>User Name: Kelvin Tan Wei Kok</p>
                            <p>NRIC/Passport: 123456789</p>
                            <p>Email: abc@gmail.com</p>
                            <p>Contact: 012456789</p>
                            <p>Gender: Male</p>
                        </div>
                        <div class="col-md bg-light rounded m-2 p-2">
                        	<p class="text-danger">Summary</p>
                            <p>Subtotal: RM129.90</p>
                            <p>Discount: RM20.90 (Coupons: 12345)</p>
                            <p>Grand Total: 109.00</p>
                            <p>Status: Failed <a href="" class="small text-danger">Change Status</a></p>
                        </div>
                    </div>
                </div>

				<div class="content-box">
                	<p class="text-danger">Participants Information</p>
                    <p>Group Male / 2 Participants</p>
                    <div class="row bg-light rounded m-1 p-2">
                    	<div class="col-md">
                        	<b>Azmir Abdul Wahab</b>
                        </div>
                        <div class="col-md">
                        	<p>User Name: Kelvin Tan Wei Kok</p>
                            <p>NRIC/Passport: 123456789</p>
                            <p>Email: abc@gmail.com</p>
                            <p>Contact: 012456789</p>
                            <p>Gender: Male</p>
                            <p>T-shirt Size: L</p>
                        </div>
                        <div class="col-md rounded">
                        	<p class="text-danger">Emergency Person</p>
                            <p>Name:Azmir (Father)</p>
                            <p>Email: abc@gmail.com</p>
                            <p>Contact: 012456789</p>
                        </div>
                    </div>
                    <div class="row bg-light rounded m-1 p-2">
                    	<div class="col-md">
                        	<b>Azmir Abdul Wahab</b>
                        </div>
                        <div class="col-md">
                        	<p>User Name: Kelvin Tan Wei Kok</p>
                            <p>NRIC/Passport: 123456789</p>
                            <p>Email: abc@gmail.com</p>
                            <p>Contact: 012456789</p>
                            <p>Gender: Male</p>
                            <p>T-shirt Size: L</p>
                        </div>
                        <div class="col-md">
                        	<p class="text-danger">Emergency Person</p>
                            <p>Name:Azmir (Father)</p>
                            <p>Email: abc@gmail.com</p>
                            <p>Contact: 012456789</p>
                        </div>
                    </div>
                    <p>Individual Male / 1 Participants</p>
                    <div class="row bg-light rounded m-1 p-2">
                    	<div class="col-md">
                        	<b>Azmir Abdul Wahab</b>
                        </div>
                        <div class="col-md">
                        	<p>User Name: Kelvin Tan Wei Kok</p>
                            <p>NRIC/Passport: 123456789</p>
                            <p>Email: abc@gmail.com</p>
                            <p>Contact: 012456789</p>
                            <p>Gender: Male</p>
                            <p>T-shirt Size: L</p>
                        </div>
                        <div class="col-md">
                        	<p class="text-danger">Emergency Person</p>
                            <p>Name:Azmir (Father)</p>
                            <p>Email: abc@gmail.com</p>
                            <p>Contact: 012456789</p>
                        </div>
                    </div>
                </div>
                
                <div class="content-box">
                	<p class="text-danger">Merchandise Information</p>
                	<div class="row bg-light rounded m-1 p-2">
                    	<div class="col-md">
                        	<b>Lorem Ipsum Merchandise</b>
                            <p>RM39.90 | Quantity: 1</p>
                        </div>
                        <div class="col-md">
                        	<p>Size: L</p>
                            <p>Size: Red</p>
                        </div>
                    </div>
                </div>

                <p class="copyright">© Copyright 2018 Sports Events House Sdn. Bhd. (1100784-A)</p>

            </div>
        </div>
    </div>

</div>


<?php include_once "inc/inc-js.php"; ?>
<script type="text/javascript" src="js/organizer-app.js<?php echo '?'.mt_rand(); ?>"></script>
<script type="text/javascript" src="js/organizer-custom.js<?php echo '?'.mt_rand(); ?>"></script>

</body>
</html>
<?php include_once "inc/app-bottom.php"; ?>