<?php 

include_once "inc/app-top.php";

include_once "classes/CRUD.php";
include_once "classes/CustomDateTime.php";
include_once "classes/Review.php";


$crud = new CRUD($mysqli);
$events = new CRUD($mysqli);
$datetime = new CustomDateTime();
$review = new Review();

$crud->sql = "SELECT `users`.`user_full_name`, `events`.`event_name`, `event_review`.`review_rate`, `event_review`.`review_desc`, `event_review`.`review_desc`, `event_review`.`review_created_at` 
FROM users, events, event_review WHERE 
`users`.`user_id` = `event_review`.`review_user` AND 
`events`.`event_id` = `event_review`.`review_event` AND 
`events`.`event_organizer` = ".$_SESSION["organizer_id"]." 
ORDER BY `event_review`.`review_created_at` DESC";

$crud->selectAll();

$events->sql = "SELECT `events`.`event_id`, `events`.`event_name` FROM events WHERE `events`.`event_organizer` = ".$_SESSION["organizer_id"]." ORDER BY `events`.`event_created_at` DESC";
$events->selectAll();



?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>My Reviews</title>
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
                        <h2>Reviews</h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="main-content">
            <div class="container-custom">

                <div class="content-box">
                    <div class="row mt-1">
                        <div class="col-md-3">
                            <select class="custom-select search-event-id" id="inputGroupSelect01">
                            	<option value="0" selected>Select All</option>
                               
                                <?php 
                                    if($events->total > 0){
                                    while($event = $events->result->fetch_object()){
                                ?>
                                <option value="<?php echo $event->event_id; ?>"><?php echo $event->event_name; ?></option>
                                <?php } $events->result->close(); } ?>
                                
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select class="custom-select search-event-star" id="inputGroupSelect01">
                            	<option value="0" selected>All Star</option>
                            	<option value="5" >5 Star</option>
                                <option value="4" >4 Star</option>
                                <option value="3" >3 Star</option>
                                <option value="2" >2 Star</option>
                                <option value="1" >1 Star</option>
                            </select>
                        </div>
                        <div class="col-md-5">
                        	<div class="input-group mb-1">
                        		<div class="input-group">
                                	<input type="text" placeholder="Search user name" class="form-control input-line-bottom search-event-username">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-auto">
                            <button class="btn btn-red btn-block search-event"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                </div>

                
                <?php 
                    if($crud->total > 0){
                        while($row = $crud->result->fetch_object()){
                ?>
                <div class="content-box search-result">
                	<div class="content-box-row">
                    	<div class="row">
                        	<div class="col-md-auto">
                            	<img src="../img/Facebook_Color.png">
                            </div>
                            <div class="col-md">
                            	<p><a href="" class="font-weight-bold"><?php echo $row->user_full_name; ?></a> Reviewed <?php echo $row->review_rate; ?> star on <a href="" class="text-danger"><?php echo $row->event_name; ?></a></p>
                                <p class="text-secondary"><?php echo $datetime->convertDateTime($row->review_created_at, "Y-m-d"); ?> <?php echo $datetime->convertDateTime($row->review_created_at, "g:iA"); ?></p>
                            </div>
                        </div>
                        <div class="row">
                            <p class="text-warning align-top col-md-auto">
                                <?php echo $review->showRateStar($row->review_rate, '<i class="fas fa-star"></i>'); ?>
                                
                            </p> 
                            <p class="align-top col-md-auto p-0"><?php echo number_format($row->review_rate, 1); ?></p>
                        </div>
                        <div>
                       	 <p><?php echo $row->review_desc; ?></p>
                        </div>
                    </div>
                </div>
                <?php } $crud->result->close(); } ?>
                
                <div class="search-result-end"></div>
                
                
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
<script type="text/javascript" src="js/organizer-review-list.js<?php echo '?'.mt_rand(); ?>"></script>

</body>
</html>
<?php include_once "inc/app-bottom.php"; ?>