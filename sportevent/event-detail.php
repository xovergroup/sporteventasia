<?php 
include_once "inc/app-top-index.php";
include_once "organizer/classes/CRUD.php";
include_once "organizer/classes/CustomDateTime.php";

$crud = new CRUD($mysqli);
$review = new CRUD($mysqli);
$customDateTime = new CustomDateTime();

if(isset($_GET["event_id"])){
    
    $event_id = $crud->sanitizeInt($_GET["event_id"]);
    
    //check
    $crud->sql = "SELECT COUNT(event_id) AS total FROM events WHERE event_id = ".$event_id;
    $validate = $crud->selectOne();
    if($validate->total < 1){
        header("Location: index.php");
    }
    
    $crud->sql = "SELECT * FROM events, organizers, states WHERE event_state = state_id AND event_organizer = organizer_id AND event_id = ".$event_id;
    $the_event = $crud->selectOne();
    
    $review->sql = "SELECT AVG(review_rate) AS averageRate FROM event_review WHERE review_organizer = ".$the_event->organizer_id;
    $the_review = $review->selectOne();
    
} else {
    header("Location: index.php");
}

?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Event Detail</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php include_once "inc/inc-css.php"; ?>

</head>

<body>

<div id="main-body">

    <?php include_once "inc/header.php"; ?>

    <div class="event-header">
        <div class="container">
            <div class="event-header-left">
                <h1 class="event-name" data-event="<?php echo $the_event->event_id; ?>"><?php echo $the_event->event_name; ?></h1>
                <p><i class="far fa-clock"></i> <?php echo $customDateTime->convertDateTime($the_event->event_date_start, "d F Y"); ?></p>
                <p><i class="fas fa-map-marker-alt"></i> <?php echo $the_event->state_name; ?></p>
            </div>
            <div class="event-header-right">
                <a href="event-registration-form-1.php?event_id=<?php echo $event_id; ?>" class="header-oblique bg-red"><li>Register Now</li></a>
            </div>
        </div>
    </div>

    <div class="event-banner">
        <img src="<?php echo $the_event->event_banner; ?>">
    </div>

    <div class="container-2">
        <div class="event-title-left">
            <h1><?php echo $the_event->event_name; ?></h1>
            <p style="color:#e33f2c;"><?php echo $the_event->state_name; ?></p>
        </div>
        <div class="event-title-right">
            <button class="event-register-btn bg-red border-none font-dagger">Register Now</button>
        </div>
        <div class="event-title-btm">
           
            <?php 
            
                $crud->sql = "SELECT * FROM event_tag, tags WHERE event_tag_tag = tag_id AND event_tag_event = ".$event_id;
                $crud->selectAll();
                if($crud->total > 0){
                    while($row = $crud->result->fetch_object()){
            ?>
            <div class="tag-box"><p><?php echo $row->tag_title; ?></p></div>
            <?php } $crud->result->close(); }?>
            
        </div>
    </div>

    <div class="container-2">
        <div class="event-overview">
            <div class="event-overview-box">
            <div class="">
                <i class="fas fa-map-marker-alt"></i>
                <p><?php echo $the_event->event_location.", ".$the_event->state_name; ?></p>
            </div>
            </div>
            <div class="event-overview-box">
                <div class="mt-2 mb-2">
                    <i class="far fa-clock"></i>
                    <p><?php echo $customDateTime->convertDateTime($the_event->event_date_start, "d F Y"); ?><br><?php echo $customDateTime->convertDateTime($the_event->event_time_start, "gA"); ?> - <?php echo $customDateTime->convertDateTime($the_event->event_time_end, "gA"); ?><br></p>
                </div>
            </div>
            <div class="event-overview-box border-none">
                <div class="event-overview-share">
                    <label class="font-dagger">Share</label>
                    <li class="footer-icon"><a href=""><img src="img/Facebook_Color.png"></a></li>
                    <li class="footer-icon"><a href=""><img src="img/Twitter_Color.png"></a></li>
                </div>
            </div>
        </div>
    </div>

    <div class="container-2 mt-5 mb-5">
        <h2>Event Category</h2>
        <div class="event-category-table">
            <table class="">
                <tr class="border-none">
                    <th>Category</th>
                    <th>Description</th> 
                    <th>Registration Date</th>
                    <th>Price</th>
                </tr>
                <?php 
            
                    $crud->sql = "SELECT * FROM event_category WHERE event_category_event = ".$event_id."  ORDER BY event_category_id ASC";
                    $crud->selectAll();
                    if($crud->total > 0){
                        while($row = $crud->result->fetch_object()){
                ?>
                <tr>
                    <td><p class="font-dagger font-16"><?php echo $row->event_category_name; ?></p><p><?php echo $row->event_category_pax; ?> Pax | <?php echo $row->event_category_limited_slot; ?> Slots</p></td>
                    <td><p><?php echo $row->event_category_desc; ?></p></td>
                    <td><p>Start Date: <?php echo $customDateTime->convertDateTime($row->event_category_reg_date_start, "d F Y"); ?> <br>End Date: <?php echo $customDateTime->convertDateTime($row->event_category_reg_date_end, "d F Y"); ?> </p></td>
                    
                    <?php 
                        $customDateTime->getDateDiff(date("Y-m-d"), $row->event_category_fees_early_bird_date_end);
                        if($customDateTime->number >= 1){    
                    ?>
                    <td>
                        <p class="font-dagger font-16">MYR <?php echo $row->event_category_fees_early_bird; ?></p>
                        <p class="txt-dashed txt-gray">MYR <?php echo $row->event_category_fees; ?></p>
                        <p class="txt-orange"><?php echo $customDateTime->msg; ?> left at this price!</p>
                    </td>
                    <?php } else { ?>
                    <td>
                        <p class="font-dagger font-16">MYR <?php echo $row->event_category_fees; ?></p>
                    </td>
                    <?php } ?>
                    
                </tr>
                <?php } $crud->result->close(); } else {?>
                <tr>
                    <td colspan="4" class="cust-text-center"><p class="font-dagger font-16">No Category Yet</p></td>
                </tr>
                <?php } ?>
                
               
            </table>
        </div>
    </div>

    <div class="event-about">
        <div class="container-2">
            <div class="event-about-left">
                <h3>Event Description</h3>
                <p><?php echo $the_event->event_description; ?></p>
            </div>
            <div class="event-about-right">
                <h4 class="txt-gray">Organizer</h4>
                <img src="<?php echo $the_event->organizer_logo; ?>">
                <a href=""><h3><?php echo $the_event->organizer_name; ?></h3></a>
                <div class="event-about-review">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="far fa-star"></i>
                    <i class="far fa-star"></i> 
                    <span style="color:gray;" class="avg-organizer-review"> <?php echo number_format($the_review->averageRate, 1); ?></span>
                </div>
                <a href="#" class="txt-orange font-dagger">Contact</a>
            </div>
        </div>
    </div>   

    <div class="container-2 mt-5 mb-5">
        <div class="txt-center">
            <h2>Race Kit Information</h2>
        </div>
        <input type="hidden" class="db-racekit" value="<?php echo html_entity_decode($the_event->event_racekit);?>">
        <div class="rc-info">
        </div>
    </div>

    <hr>

    <div class="container-2 mt-5 mb-5">
        <div class="txt-center">
            <h2>Other Information</h2>
        </div>
        <input type="hidden" class="db-other-info" value="<?php echo html_entity_decode($the_event->event_other_information);?>">
        <div class="event-other-info">
        </div>
    </div>

    <div class="event-register-background">
    <!--<div class="event-register-bg-img"><img src="img/event-register.jpg"></div>-->
        <div class="event-register-content">
            <h2 class="txt-center">Sponsors</h2>
            <div class="container txt-center">
               
                <?php 
            
                    $crud->sql = "SELECT * FROM event_sponsor WHERE event_sponsor_event = ".$event_id. " ORDER BY event_sponsor_id ASC";
                    $crud->selectAll();
                    if($crud->total > 0){
                        while($row = $crud->result->fetch_object()){
                ?>
                <div class="event-sponsor-box">
                    <p class="txt-orange"><?php echo $row->event_sponsor_type; ?></p>
                    <img src="<?php echo $row->event_sponsor_image; ?>">
                    <!--<h4>Kampar Cycling Community</h4>-->
                </div>
                <?php } $crud->result->close(); } else { ?>
                <h2 class="txt-center">No Sponsor Available</h2>
                <?php }  ?>
                
            </div>
        </div>
    </div>
</div><!--END OF MAIN BODY-->

<!--<div class="event-register-background">
	<div class="event-register-bg-img"><img src="img/event-register.jpg"></div>
    <div class="event-register-content">
        <h2 class="txt-center">Get Started Now!</h2>
        <p class="txt-center txt-white"><i class="far fa-clock"></i> 2 days left at this early bird price!</p>
        <div class="swiper-container swiper-event-merchandise">
            <div class="swiper-wrapper">
                <div class="swiper-slide register-box-outer">
                    <div class="txt-center register-box">
                        <h3>Individual Male</h3>
                        <p>21KM, Male, All Age</p>
                        <h3 class="txt-orange event-price">RM30</h3>
                        <p class="price-rm">RM50</p>
                    </div>
                    <div class="register-tick"><i class="fas fa-check"></i></div>
                </div>
                <div class="swiper-slide register-box-outer">
                    <div class="txt-center register-box">
                        <h3>Individual Male</h3>
                        <p>21KM, Male, All Age</p>
                        <h3 class="txt-orange event-price">RM30</h3>
                        <p class="price-rm">RM50</p>
                    </div>
                    <div class="register-tick"><i class="fas fa-check"></i></div>
                </div>
                <div class="swiper-slide register-box-outer">
                    <div class="txt-center register-box">
                        <h3>Individual Male</h3>
                        <p>21KM, Male, All Age</p>
                        <h3 class="txt-orange event-price">RM30</h3>
                        <p class="price-rm">RM50</p>
                    </div>
                    <div class="register-tick"><i class="fas fa-check"></i></div>
                </div>
                <div class="swiper-slide register-box-outer">
                    <div class="txt-center register-box">
                        <h3>Individual Male</h3>
                        <p>21KM, Male, All Age</p>
                        <h3 class="txt-orange event-price">RM30</h3>
                        <p class="price-rm">RM50</p>
                    </div>
                    <div class="register-tick"><i class="fas fa-check"></i></div>
                </div>
                <div class="swiper-slide register-box-outer">
                    <div class="txt-center register-box">
                        <h3>Individual Male</h3>
                        <p>21KM, Male, All Age</p>
                        <h3 class="txt-orange event-price">RM30</h3>
                        <p class="price-rm">RM50</p>
                    </div>
                    <div class="register-tick"><i class="fas fa-check"></i></div>
                </div>
            </div>
        </div>	
        
        <div class="txt-center event-register-btn"><button class="bg-red btn-event-register font-dagger">Register Now</button></div>
    </div>
</div>-->

<!--<div class="mt-5 mb-5">
	<h2 class="txt-center">Latest News</h2>
    <div class="swiper-container swiper-event-news">
        <div class="swiper-wrapper">
            <div class="swiper-slide">
                <div class="txt-center event-news-box mt-5 mb-5"><a href="">
                    <h3>UPDATE: Lorem Ipsum Dolor Sit Amet</h3>
                    <p class="txt-orange">17 July 2018</p>
                    <p class="txt-gray">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p></a>
                </div>
            </div>
            <div class="swiper-slide">
                <div class="txt-center event-news-box mt-5 mb-5"><a href="">
                    <h3>UPDATE: Lorem Ipsum Dolor Sit Amet</h3>
                    <p class="txt-orange">17 July 2018</p>
                    <p class="txt-gray">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p></a>
                </div>
            </div>
            <div class="swiper-slide">
                <div class="txt-center event-news-box mt-5 mb-5"><a href="">
                    <h3>UPDATE: Lorem Ipsum Dolor Sit Amet</h3>
                    <p class="txt-orange">17 July 2018</p>
                    <p class="txt-gray">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p></a>
                </div>
            </div>
            <div class="swiper-slide">
                <div class="txt-center event-news-box mt-5 mb-5"><a href="">
                    <h3>UPDATE: Lorem Ipsum Dolor Sit Amet</h3>
                    <p class="txt-orange">17 July 2018</p>
                    <p class="txt-gray">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p></a>
                </div>
            </div>
        </div>
        <div class="swiper-scrollbar"></div>
    </div>	
</div>-->

<div class="event-merchandise">
	<h2 class="txt-center">Merchandise</h2>
    
    <div class="swiper-container swiper-event-merchandise">
        <div class="swiper-wrapper">
            <div class="swiper-slide">
                <div><a href="">
                	<img src="img/merchandise.jpg">
                    <h3>Lorem Ipsum Dolor Sit Amet</h3>
                    <h5 class="txt-orange">RM30</h5></a>
                </div>
            </div>
            <div class="swiper-slide">
                <div><a href="">
                	<img src="img/merchandise.jpg">
                    <h3>Lorem Ipsum Dolor Sit Amet</h3>
                    <h5 class="txt-orange">RM30</h5></a>
                </div>
            </div>
            <div class="swiper-slide">
                <div><a href="">
                	<img src="img/merchandise.jpg">
                    <h3>Lorem Ipsum Dolor Sit Amet</h3>
                    <h5 class="txt-orange">RM30</h5></a>
                </div>
            </div>
            <div class="swiper-slide">
                <div><a href="">
                	<img src="img/merchandise.jpg">
                    <h3>Lorem Ipsum Dolor Sit Amet</h3>
                    <h5 class="txt-orange">RM30</h5></a>
                </div>
            </div>
            <div class="swiper-slide">
                <div><a href="">
                	<img src="img/merchandise.jpg">
                    <h3>Lorem Ipsum Dolor Sit Amet</h3>
                    <h5 class="txt-orange">RM30</h5></a>
                </div>
            </div>
            <div class="swiper-slide">
                <div><a href="">
                	<img src="img/merchandise.jpg">
                    <h3>Lorem Ipsum Dolor Sit Amet</h3>
                    <h5 class="txt-orange">RM30</h5></a>
                </div>
            </div>
        </div>
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
    </div>	
</div>

<?php include_once "inc/footer.php"; ?>



<?php include_once "inc/inc-js.php"; ?>

<script type="text/javascript" src="js/custom.js<?php echo '?'.mt_rand(); ?>"></script>
<script type="text/javascript" src="js/js-event-detail.js"></script>
<script type="text/javascript" src="js/js-event-detail-custom.js<?php echo '?'.mt_rand(); ?>"></script>
<script type="text/javascript" src="js/js-quill.js<?php echo '?'.mt_rand(); ?>"></script>

</body>
</html>
<?php include_once "inc/app-bottom.php"; ?>