<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Add Promo Code</title>
<?php include_once "inc/inc-css.php"; ?>
</head>

<body>

 <?php include_once "inc/inc-sidebar.php"; ?>

    <div class="main-body">
        <div class="main-background">
            <img src="../organizer/img/org-background.jpg">
            <div class="main-header">
                <div class="container-custom">
                    <?php include_once "inc/inc-header.php"; ?>
                    <img src="">
                    <div class="main-title">
                        <h2>Add Promo Code</h2>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="main-content">
            <div class="container-custom">

                <div class="content-box">
                    <div class="content-box-row">
                        <label>Promo Code Name</label><input type="text" placeholder="Name">
                    </div>
                    <div class="content-box-row">
                        <label>Promo Code Quantity</label><input type="text" placeholder="Email">
                    </div>
                    <div class="content-box-row">
                        <label>Promo Code Start Date</label><input type="date" class="date-picker validate-date-picker validate-date-picker-start" value="2018-10-04" id="event-date-start">
                    </div>
                    <div class="content-box-row">
                        <label>Promo Code End Date</label><input type="date" class="date-picker validate-date-picker validate-date-picker-start" value="2018-10-04" id="event-date-start">
                    </div>
                    <div class="content-box-row">
                        <label>Discount Amount</label>
                        <select id="event-state">
							<option value="1">Percentage</option>
                            <option value="2">Amount</option>
                        </select>
                        <input type="number" name="quantity" value="1%" class="col-md-3 date-picker">
                    </div>
                    <div class="content-box-row">
                     	<label>Discount Type</label>
                        <select id="event-state">
							<option value="1">Per Group</option>
                            <option value="2">Per Person</option>
                        </select>
                    </div>
                </div>
                
                <div class="content-box">
                	<p>Event or Category Added</p>
                    <div class="row">
                    	<p class="col-md-auto"><span class="badge badge-light p-3">Lorem Ipsum Event</span></p>
                        <p class="col-md-auto"><span class="badge badge-light p-3">Lorem Ipsum Event</span></p>
                        <p class="col-md-auto"><span class="badge badge-light p-3">Lorem Ipsum Event</span></p>
                        <p class="col-md-auto"><span class="badge badge-light p-3">Lorem Ipsum Event</span></p>
                    </div>
                    <a href="#" class="btn-red">Add to Event</a>
                    <a href="#" class="btn-red">Add to Category</a>
                </div>

                <div class="content-box">
                	<a href="#" class="btn-red">Save</a>
                </div>
               
            </div>
                
            <p class="copyright">© Copyright 2018 Sports Events House Sdn. Bhd. (1100784-A)</p>
        
    </div>
    
     <?php include_once "inc/inc-js.php"; ?>
</body>
</html>