<?php 

include_once "inc/app-top.php";
include_once "classes/CRUD.php";
include_once "classes/CustomDateTime.php";


$crud = new CRUD($mysqli);
$datetime = new CustomDateTime();

$crud->sql = "SELECT * FROM events WHERE event_organizer = ".$_SESSION["organizer_id"]." ORDER BY event_id DESC";
$crud->selectAll();

?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Manage Events</title>
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
                        <h2>Manage Events</h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="main-content">
            <div class="container-custom">

                <div class="content-box">
                    <div class="row">
                        <div class="col-md">
                            <select class="custom-select search-by" id="inputGroupSelect01">
                            	<option value="1" selected>Event Name</option>
                                <!--<option value="2">Organizer</option>-->
                            </select>
                        </div>
                        <div class="col-md-6">
                        	<div class="input-group mb-3">
                        		<div class="input-group">
                                	<input type="text" placeholder="Search event name" class="form-control input-line-bottom event-name">
                                </div>
                            </div>
                        </div>
                        <div class="col-md">
                            <button class="btn btn-red btn-block search-event"><i class="fas fa-search"></i>Search</button>
                        </div>
                    </div>
                    
                    <div class="row">
                    	<div class="col-md-auto">
                            <b class="align-middle">Filter</b>
                        </div>
                        <div class="col-md-3">
                            <select class="custom-select event-status">
                                <option value="0">All</option>
                                <option value="1">In Review</option>
                                <option value="2">Successful</option>
                                <option value="3">Rejected</option>
                        	</select>
                        </div>
                        <div class="col-md-3">
                            <select class="custom-select event-month">
                                <option value="0">All Months</option>
                                <option value="1">January</option>
                                <option value="2">February</option>
                                <option value="3">March</option>
                                <option value="4">April</option>
                                <option value="5">May</option>
                                <option value="6">June</option>
                                <option value="7">July</option>
                                <option value="8">August</option>
                                <option value="9">September</option>
                                <option value="10">October</option>
                                <option value="11">November</option>
                                <option value="12">December</option>
                        	</select>
                        </div>
                        <div class="col-md-3">
                            <select class="custom-select event-state">
                            	<option value="0">All State</option>
                            	<option value="1">Kuala Lumpur</option>
                        	</select>
                        </div>
                    </div>
                </div>


                <div class="content-box">
                	<p><?php echo $crud->total; ?> Results</p>
                    
                    <?php 
                        
                        if($crud->total > 0){
                            $counter = 1;
                            while($row = $crud->result->fetch_object()){
                            
                    ?>
                    <hr>
                    <div class="content-box-row row">
                        <div class="col-md">
                        	<img src="<?php echo $row->event_thumbnail; ?>">
                        </div>
                        <div class="col-md-6">
                        	<h2><?php echo $row->event_name; ?></h2>
                            <p><?php echo $row->event_date_start; ?> <?php echo $datetime->convertDateTime($row->event_time_start, "g:iA"); ?> - <?php echo $datetime->convertDateTime($row->event_time_end, "g:iA"); ?></p>
                            <p class="text-secondary">In Review</p>
                        </div>
                        <div class="col-md-3">
                            <a href="event-page-detail.php?event_id=<?php echo $row->event_id; ?>" class="btn-red btn-block">VIEW DETAIL</a>
                            <a href="../event-detail.php?event_id=<?php echo $row->event_id; ?>" target="_blank" class="btn-green btn-block">PREVIEW</a>
                        </div>
                    </div>
                    <?php $counter++; } $crud->result->close(); } ?>
                    
                    
                    <!--<hr>
                    <div class="content-box-row row">
                        <div class="col-md">
                        	<img src="../img/eventThumb.png">
                        </div>
                        <div class="col-md-6">
                        	<h2>Run Till Dark 15KM</h3>
                            <p>2018-05-05 7:00PM - 9:00PM</p>
                            <p class="text-secondary">In Review</p>
                        </div>
                        <div class="col-md-3">
                            <a href="event-page-detail.php" class="btn-red btn-block">VIEW DETAIL</a>
                            <a href="" class="btn-green btn-block">PREVIEW</a>
                        </div>
                    </div>
                    <hr>
                    <div class="content-box-row row">
                        <div class="col-md">
                        	<img src="../img/eventThumb.png">
                        </div>
                        <div class="col-md-6">
                        	<h2>Run Till Dark 15KM</h3>
                            <p>2018-05-05 7:00PM - 9:00PM</p>
                            <p class="text-success">Approved</p>
                        </div>
                        <div class="col-md-3">
                            <a href="event-page-detail.php" class="btn-red btn-block">VIEW DETAIL</a>
                            <a href="" class="btn-green btn-block">PREVIEW</a>
                        </div>
                    </div>
                    <hr>
                    <div class="content-box-row row">
                        <div class="col-md">
                        	<img src="../img/eventThumb.png">
                        </div>
                        <div class="col-md-6">
                        	<h2>Run Till Dark 15KM</h3>
                            <p>2018-05-05 7:00PM - 9:00PM</p>
                            <p class="text-danger">Rejected</p>
                        </div>
                        <div class="col-md-3">
                            <a href="event-page-detail.php" class="btn-red btn-block">VIEW DETAIL</a>
                            <a href="" class="btn-green btn-block">PREVIEW</a>
                        </div>
                    </div>-->
                    
                    
                    
                    
                </div>
                
                <div class="mb-5">
                    <nav aria-label="Page navigation example">
                      <ul class="pagination  justify-content-center">
                        <li class="page-item">
                          <a class="page-link" href="#" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                            <span class="sr-only">Previous</span>
                          </a>
                        </li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                          <a class="page-link" href="#" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                            <span class="sr-only">Next</span>
                          </a>
                        </li>
                      </ul>
                    </nav>
                </div>

                
                
                <p class="copyright">© Copyright 2018 Sports Events House Sdn. Bhd. (1100784-A)</p>

            </div>
        </div>
    </div>

</div>


<?php include_once "inc/inc-js.php"; ?>
<script type="text/javascript" src="js/organizer-app.js<?php echo '?'.mt_rand(); ?>"></script>
<script type="text/javascript" src="js/organizer-event-page-list.js<?php echo '?'.mt_rand(); ?>"></script>

</body>
</html>
<?php include_once "inc/app-bottom.php"; ?>