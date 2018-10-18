<?php 

include_once "inc/app-top.php";
include_once "organizer/classes/CRUD.php";
include_once "organizer/classes/CustomDateTime.php";
include_once "organizer/classes/State.php";
include_once "organizer/classes/Review.php";

if(isset($_GET["organizer_id"])){
    
    $crud = new CRUD($mysqli);
    $reviews = new CRUD($mysqli);
    $customDateTime = new CustomDateTime();
    $state = new State();
    $starReview = new Review();
    
    $organizer_id = intval($_GET["organizer_id"]);
    
    //check
    $crud->sql = "SELECT COUNT(organizer_id) AS total FROM organizers WHERE organizer_id = ".$organizer_id;
    $validate = $crud->selectOne();
    if($validate->total < 1){
        header("Location: index.php");
    }
    
    $crud->sql = "SELECT * FROM organizers WHERE organizer_id = ".$organizer_id;
    $the_organizer = $crud->selectOne();
    
    $crud->sql = "SELECT COUNT(review_id) AS total FROM event_review WHERE review_organizer = ".$organizer_id;
    $total_reviews = $crud->selectOne();
    
    $reviews->sql = "SELECT `users`.`user_full_name`, `events`.`event_name`, `event_review`.`review_rate`, `event_review`.`review_desc`, `event_review`.`review_desc`, `event_review`.`review_created_at` 
    FROM users, events, event_review WHERE 
    `users`.`user_id` = `event_review`.`review_user` AND 
    `events`.`event_id` = `event_review`.`review_event` AND 
    `events`.`event_organizer` = ".$organizer_id." 
    ORDER BY `event_review`.`review_created_at` DESC LIMIT 3";

    $reviews->selectAll();
    
} else {
    header("Location: index.php");
}



?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Organizer Profile </title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<?php include_once "inc/inc-css.php"; ?>
</head>
<body>

<div id="main-body">

	<?php include_once "inc/header.php"; ?>
    
    <div class="org-profile-banner">
        <img src="<?php echo $the_organizer->organizer_banner; ?>">
    </div>
    
    <div class="container">
        <div class="org-profile-header row">
            <div class="org-profile-pic mb-3">
                <img src="<?php echo $the_organizer->organizer_logo; ?>">
            </div>
            <div class="col-md-7 p-3 ml-2">
            	<h2 class="the-organizer" data-organizer="<?php echo $the_organizer->organizer_id; ?>"><?php echo $the_organizer->organizer_name; ?></h2>
                <div class="txt-yellow"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i> <span style="color:gray;">3.0</span></div>
            </div>
            <div class="col-md-2 mt-3 mb-3">
            	<button class="bg-red txt-white no-border col p-3 font-dagger">Contact</button>
            </div>
        </div>
    </div>
    
    <div class="bg-gray pt-5 pb-5">
        <div class="container">
        	<div class="row">
            	<div class="col-md-3 no-gutters p-0 mb-3">
                	<div class="p-3 bg-white">
                    	<h2>About us</h2>
                    	<p><?php echo $the_organizer->organizer_desc; ?></p>
                        <p class="mt-3">Email:</p>
                        <a href="" class="txt-orange"><?php echo $the_organizer->organizer_email; ?></a>
                        <p class="mt-3">Contact:</p>
                        <p><?php echo $the_organizer->organizer_contact_no; ?></p>
                        <div class="mt-3">
                            <li class="footer-icon"><a href=""><img src="img/Facebook_Color.png"></a></li>
                            <li class="footer-icon"><a href=""><img src="img/Twitter_Color.png"></a></li>
                        </div>
                        <div class="mt-3">
                           
                            <?php 
                            $crud->sql = "SELECT tag_title FROM `tags`, `organizer_tag` WHERE `tags`.`tag_id` = `organizer_tag`.`organizer_tag_tag` AND `organizer_tag`.`organizer_tag_organizer` = ".$organizer_id;
                            $crud->selectAll();
                            if($crud->total > 0){
                                while($row = $crud->result->fetch_object()){
                            ?>
                            <div class="tag-box mb-1"><p><?php echo $row->tag_title; ?></p></div>
                            <?php } $crud->result->close(); } ?>
                            
                        </div>
                    </div>
                	
                </div>
                
                <div class="col-md ml-3 p-0 ml-0-m">
                    <div class="p-3 bg-white">
                    	<h2 class="event-list-for-organizer" data-organizer="<?php echo $the_organizer->organizer_id; ?>">Event List</h2>
                       
                       
                        <?php 
                            $crud->sql = "SELECT * FROM `events` WHERE `events`.`event_organizer` = ".$organizer_id. " ORDER BY `events`.`event_date_start` DESC LIMIT 3 ";
                            $crud->selectAll();
                            if($crud->total > 0){
                                while($row = $crud->result->fetch_object()){
                        ?>
                        <div class="event-box-3 each-event">
                            <div class="event-img-box">
                                <a href="event-detail.php">
                                    <img src="<?php echo $row->event_thumbnail; ?>">
                                    <div class="corner-left-wrapper">
                                        <div class="corner-left"></div>
                                    </div>
                                    <div class="corner-right-wrapper">
                                        <div class="corner-right"></div>
                                    </div>
                                </a>
                            </div>
                            <div class="event-content">
                                <p class="text-red"><?php echo $customDateTime->convertDateTime($row->event_date_start, "j F Y"); ?></p>
                                <h2><?php echo $row->event_name; ?></h2>
                                <p><?php echo $row->event_location; ?>, <?php echo $state->getStateName($row->event_state); ?></p>
                            </div>
                        </div>
                        <?php } $crud->result->close(); } ?>
                        
                        <div class="txt-center view-more-event">
                        	<hr>
                            <button class="txt-gray no-border bg-trans">View More</button>
                        </div>
                    </div>
                    <div class="row mt-3 p-3">
                    	<p class="col-md txt-gray"><?php echo $total_reviews->total; ?> Reviews</p>
                        <button class="col-md-3 bg-red txt-white no-border col p-3 font-dagger"><i class="far fa-edit"></i> Write Review</button>
                    </div>
                    <div class="row mt-1">
                    	<div class="col">
                            <?php 
                                if($reviews->total > 0){
                                    while($review = $reviews->result->fetch_object()){
                            ?>
                        	<div class="p-3 mb-3 bg-white each-review">
                                <div class="row">
                                    <div class="col-auto review-profile">
                                        <img src="img/Facebook_Color.png">
                                    </div>
                                    <div class="col-md">
                                        <p><a href="" class="font-weight-bold"><?php echo $review->user_full_name; ?></a> Reviewed <?php echo $review->review_rate; ?> star on <a href="" class="txt-orange"><?php echo $review->event_name; ?></a></p>
                                        <p class="text-secondary"><?php echo $customDateTime->convertDateTime($review->review_created_at, "Y-m-d"); ?> <?php echo $customDateTime->convertDateTime($review->review_created_at, "g:iA"); ?></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <p class="txt-yellow col-auto">
                                        <?php echo $starReview->showRateStar($review->review_rate, '<i class="fas fa-star"></i>'); ?>
                                    </p> 
                                    
                                    <p class=""><?php echo number_format($review->review_rate, 1); ?></p>
                                </div>
                                <div>
                                 <p><?php echo $review->review_desc; ?></p>
                                </div>
                            </div>
                            <?php } $reviews->result->close(); } ?>
                            
                            <div class="txt-center view-more-review">
                                <button class="col bg-dgray no-border p-3">+ View More</button>
                            </div>
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
<script type="text/javascript" src="js/js-organizer-profile.js<?php echo '?'.mt_rand(); ?>"></script>


</body>
</html>
