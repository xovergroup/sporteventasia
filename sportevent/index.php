<?php 
include_once "inc/app-top-index.php";
include_once "organizer/classes/CRUD.php";
include_once "organizer/classes/CustomDateTime.php";
include_once "organizer/classes/State.php";
    
$crud = new CRUD($mysqli);
$dateTime = new CustomDateTime();
$state = new State();

?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Sport Event </title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php include_once "inc/inc-css.php"; ?>
</head>
<body>

<div id="main-body">

	<?php include_once "inc/header.php"; ?>
    
    <div class="header-transparent">
    	<div class="container">
            <div class="header-trans-left">
                <a href="index.php"><img src="img/logo-white.png"></a>
            </div>
            <div class="header-trans-right">
            	<!--<a class="btn-menu"><li class=""><i class="fas fa-bars"></i></li></a>-->
                <?php if(isset($_SESSION["id"])){ ?>
                <a href="user-profile.php" class="login-button"><li><i class="fas fa-user-circle"></i>  &nbsp My Account</li></a>    
                <?php } else { ?>
                <a href="login.php" class="login-button"><li><i class="fas fa-user-circle"></i>  &nbsp Register / Login</li></a> 
                <?php } ?>
                <a href="organizer/login-organizer.php"><li class=""><i class="fas fa-user-tie"></i>  &nbsp For Organizer</li></a>
                <a href="explore.php"><li class=""><i class="fas fa-search"></i>  &nbsp Explore</li></a>
            </div>
        </div>
    </div>
    
    <div class="banner">
    	<img src="img/homebanner.png">
        <div class="banner-content">
        	<h1>Find Your Next Challenge Here</h1>
            <form id="searchform" method="post" action="explore.php">
            <input type="text" class="txtfield-oblique" name="search" placeholder="Search Event here">
            <button class="btn-oblique">Search</button>
            </form>
            <div class="banner-tag">
            	<p>Popular Tag</p>
                <?php 
                    $crud->sql = "SELECT * FROM tags";
                    $crud->selectAll();
                    if($crud->total > 0){
                        while($row = $crud->result->fetch_object()){
                ?>
                <a href="explore.php?tag=<?php echo $row->tag_id; ?>"><?php echo $row->tag_title; ?></a>
                <?php } $crud->result->close(); } ?>
            </div>
        </div>
        
    </div>
    
    <div class="container">
        <div class="event-box-header-1">
        	<h1><span class="text-red">TRENDING</span> EVENT</h1>
        </div>
        
        <?php 
            $crud->sql = "SELECT event_id, event_thumbnail, event_date_start, event_name, event_location, event_state FROM events WHERE event_date_start >= '".date('Y-m-d')."' ORDER BY RAND() LIMIT 3";
            $crud->selectAll();
            if($crud->total > 0){
                while($row = $crud->result->fetch_object()){
        ?>
        <div class="event-box">
            <div class="event-img-box">
                <a href="event-detail.php?event_id=<?php echo $row->event_id; ?>">
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
                <p class="text-red"><?php echo $dateTime->convertDateTime($row->event_date_start, "j F Y"); ?></p>
                <h2><?php echo $row->event_name; ?></h2>
                <p><?php echo $row->event_location; ?>, <?php echo $state->getStateName($row->event_state); ?></p>
                <button class="btn-outline-red go-to-event-detail" data-event="<?php echo $row->event_id; ?>"></button>
            </div>
        </div>
        <?php } $crud->result->close(); } ?>
        
    </div>
    
    <hr class="mt-5 mb-5" style="background-color: #EFEFEF" >
    
    <div class="container-2">
    	<div class="txt-center">
        	<h1><span class="text-red">UPCOMING</span> EVENT</h1>
        </div>
        
        <div class="home-search">
            <div>
                <label></label>
                <select class="event-state">
                	<option value="0">All State</option>
                    <?php 
                        $crud->sql = "SELECT * FROM states";
                        $crud->selectAll();
                        if($crud->total > 0){
                            while($row = $crud->result->fetch_object()){
                    ?>
                    <option value="<?php echo $row->state_id; ?>"><?php echo $row->state_name; ?></option>
                    <?php } $crud->result->close(); } ?>
                </select>
            </div>
            <div>
                <label></label>
                <select class="event-tag">
                    <option value="">All Tag</option>
                    <?php 
                        $crud->sql = "SELECT * FROM tags";
                        $crud->selectAll();
                        if($crud->total > 0){
                            while($row = $crud->result->fetch_object()){
                    ?>
                    <option value="<?php echo $row->tag_id; ?>"><?php echo $row->tag_title; ?></option>
                    <?php } $crud->result->close(); } ?>
                </select>
            </div>
            <div>
                <button class="bg-red search-upcoming-event"><i class="fas fa-search"></i> Search</button>
            </div>
        </div>
        
        <div class="txt-center">
            <?php 
                $crud->sql = "SELECT event_id, event_thumbnail, event_date_start, event_name, event_location, event_state FROM events WHERE event_date_start >= '".date('Y-m-d')."' ORDER BY event_date_start ASC LIMIT 9";
                $crud->selectAll();
                if($crud->total > 0){
                    while($row = $crud->result->fetch_object()){
            ?>
            <div class="event-box-3 each-upcoming-event">
                <div class="event-img-box">
                    <a href="event-detail.php?event_id=<?php echo $row->event_id; ?>">
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
                    <p class="text-red"><?php echo $dateTime->convertDateTime($row->event_date_start, "j F Y"); ?></p>
                    <h2><?php echo $row->event_name; ?></h2>
                    <p><?php echo $row->event_location; ?>, <?php echo $state->getStateName($row->event_state); ?></p>
                    <button class="btn-outline-red go-to-event-detail" data-event="<?php echo $row->event_id; ?>"></button>
                </div>
            </div>
            <?php } $crud->result->close(); } ?>

        </div>
        <div class="txt-center"><button class="btn-upcoming view-more-upcoming font-dagger">+ View More</button></div>
    </div>
    
    <div class="img-moutain"><img src="img/moutain-banner.png"></div>
    
    <div class="home-sponsor">
    	<div class="container">
        	<p>Our Sponsors</p>
            <div class="home-sponsor-img">
                <img src="img/sponsor-1.png">
                <img src="img/sponsor-1.png">
                <img src="img/sponsor-1.png">
                <img src="img/sponsor-1.png">
                <img src="img/sponsor-1.png">
                <img src="img/sponsor-1.png">
            </div>
    	</div>
    </div>
    
    <div class="mt-5 mb-5">
    <h1 class="txt-center container m-5"><span class="text-red">Most</span> Rating Organizer</h1>
    	<div class="swiper-container swiper-index-org">
            <div class="swiper-wrapper">
                
                
                <?php 
                    $crud->sql = "SELECT `organizers`.`organizer_id`, `organizers`.`organizer_name`, `organizers`.`organizer_logo`, `event_review`.`review_organizer`, AVG(`event_review`.`review_rate`) AS review_average FROM `organizers`, `event_review` WHERE `organizers`.`organizer_id` = `event_review`.`review_organizer` GROUP BY `event_review`.`review_organizer` ORDER BY review_average DESC";
                    $crud->selectAll();
                    if($crud->total > 0){
                        while($row = $crud->result->fetch_object()){
                ?>
                <div class="swiper-slide">
                    <div class="event-box-2 event-news-box">
                        <div class="event-content">
                           <a href="#">
                                <img src="<?php echo $row->organizer_logo; ?>">
                                <h4><?php echo $row->organizer_name; ?></h4>
                                <div class="event-about-review">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="far fa-star"></i>
                                    <i class="far fa-star"></i> 
                                    <span class="avg-organizer-review" style="color:gray;"> <?php echo number_format($row->review_average, 1); ?></span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <?php } $crud->result->close(); } ?>
                
                
                
            </div>
            <!--Add Pagination -->
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
    </div>
    
    <div class="act">
    	<img src="img/act-banner.png">
        <div class="act-content">
        	<h1>About Us</h1>
            <p>CyclingEvents.my is an online cycling event registration and payment platform owned by Sports Events House Sdn. Bhd. It was organised with the objective of creating a simple, effective, user-friendly and hassle-free platform for.. </p>
            <a href="" class="btn-about"><img src="img/btn-about.png"></a>
        </div>
    </div>
    
	<?php include_once "inc/footer.php"; ?>
    

</div>

<?php include_once "inc/inc-js.php"; ?>
<script type="text/javascript" src="js/custom.js<?php echo '?'.mt_rand(); ?>"></script>
<script type="text/javascript" src="js/js-index.js<?php echo '?'.mt_rand(); ?>"></script>

<script type="text/javascript">	
	document.write('<link href="css/style.css?v='+ Math.floor(Math.random()*100) +'" rel="stylesheet" type="text/css" />');

	//For homepage transparent header
	
	if(window.innerWidth >= 800) {
		$('.header').css({'display':'none'});
		 $(window).scroll( function() {
			var value = $(this).scrollTop();
			if ( value > 120 ){
				$(".header").fadeIn();
				$(".header-transparent").hide();
			}else{
				$(".header").hide();
				$(".header-transparent").show();
			}
		});
    }
	
	/*
	//Most rating organizer slider js
	var swiper = new Swiper('.swiper-index-event', {
	  slidesPerView: 4,
	  spaceBetween: 30,
	  loop: true,
	  autoplay: {
		delay: 2500,
	  },
	  pagination: {
		el: '.swiper-pagination',
		clickable: true,
	  },
	  navigation: {
		nextEl: '.swiper-button-next',
		prevEl: '.swiper-button-prev',
	  },
	  
	  breakpoints: {
		1024: {
		  slidesPerView: 4,
		  spaceBetween: 30,
		},
		768: {
		  slidesPerView: 2,
		  spaceBetween: 20,
		},
		640: {
		  slidesPerView: 1,
		  spaceBetween: 20,
		},
		320: {
		  slidesPerView: 1,
		  spaceBetween: 10,
		}
	  }
	});
	
	//Mobile View
	
	$('.btn-menu').click(function(){
		$('.full-menu').css({'right':'0%'});
	});
	
	$('#close-menu').click(function(){
		$('.full-menu').css({'right':'-100%'});
	});*/

	
</script>

<!--<link href="css/style.css?v=666" rel="stylesheet" type="text/css" />

<link rel="stylesheet" href="libs/fontawesome/all.css">
<script src="libs/fontawesome/all.js"></script>

<link rel="stylesheet" href="libs/swiper/css/swiper.min.css">
<script src="libs/swiper/js/swiper.min.js"></script>

<script type="text/javascript" src="libs/tilt/vanilla-tilt.js"></script>

<script src="libs/jquery/jquery-3.3.1.min.js"></script>
<link rel="stylesheet" href="libs/jquery/jquery-ui.min.css">
<script src="libs/jquery/jquery-ui.min.js"></script>


<script type="text/javascript">
	document.write('<link href="css/style.css?v='+ Math.floor(Math.random()*100) +'" rel="stylesheet" type="text/css" />');
	
	if(window.innerWidth >= 800) {
		//header
		$('.header').css({'display':'none'});
		 $(window).scroll( function() {
			var value = $(this).scrollTop();
			if ( value > 120 ){
				$(".header").fadeIn();
				$(".header-transparent").hide();
			}else{
				$(".header").hide();
				$(".header-transparent").show();
			}
		});
    }
	
	$('.btn-menu').click(function(){
		$('.full-menu').css({'right':'0%'});
	});
	
	$('#close-menu').click(function(){
		$('.full-menu').css({'right':'-100%'});
	});
	
	//mouse cursor js
	$('#main-body').on('mousedown mouseup', function mouseState(e) {
        if (e.type == "mousedown") {
            $('#main-body').addClass('cursorClicked');
			$('#main-body').removeClass('curosrNormal');
        }else{
			$('#main-body').addClass('curosrNormal');
			$('#main-body').removeClass('cursorClicked');
		}
    });
	
	/*//tag change js
	$(function() {
		$('.btn-prev').click(function(){
			var clicks = $(this).data('clicks');
			if (clicks) {
				tagRow1();
			} else {
				tagRow2();
			}
			$(this).data("clicks", !clicks);
		});
	});
	
	$(function() {
		$('.btn-next').click(function(){
			var clicks = $(this).data('clicks');
			if (clicks) {
				tagRow1();
			} else {
				tagRow2();
			}
			$(this).data("clicks", !clicks);
		});
	});
	
	function tagRow1(){
		$(".tag-1").attr('src',"img/tag-2.png");
		$(".tag-2").attr('src',"img/tag-1.png");
		$(".tag-3").attr('src',"img/tag-4.png");
		$(".tag-4").attr('src',"img/tag-3.png");
		//$('.tag-1, .tag-2, .tag-3, .tag-4').effect( "slide",{direction: 'right',times:1,distance:20}, 500 );
	}
	
	function tagRow2(){
		$(".tag-1").attr('src',"img/tag-1.png");
		$(".tag-2").attr('src',"img/tag-2.png");
		$(".tag-3").attr('src',"img/tag-3.png");
		$(".tag-4").attr('src',"img/tag-4.png");
		//$('.tag-1, .tag-2, .tag-3, .tag-4').effect( "slide",{direction: 'right',times:1,distance:20}, 500 );
	}*/
	
	/*VanillaTilt.init(document.querySelector("#tilt-1"), {
		max: 35,
		speed: 400,
		reverse: true
	});
	VanillaTilt.init(document.querySelector("#tilt-2"), {
		max: 35,
		speed: 400,
		reverse: true
	});
	VanillaTilt.init(document.querySelector("#tilt-3"), {
		max: 35,
		speed: 400,
		reverse: true
	});
	VanillaTilt.init(document.querySelector("#tilt-4"), {
		max: 35,
		speed: 400,
		reverse: true
	});*/
	
	
	//event slider js
	var swiper = new Swiper('.swiper-index-event', {
	  slidesPerView: 4,
	  spaceBetween: 30,
	  loop: true,
	  autoplay: {
		delay: 2500,
	  },
	  pagination: {
		el: '.swiper-pagination',
		clickable: true,
	  },
	  navigation: {
		nextEl: '.swiper-button-next',
		prevEl: '.swiper-button-prev',
	  },
	  
	  breakpoints: {
		1024: {
		  slidesPerView: 4,
		  spaceBetween: 30,
		},
		768: {
		  slidesPerView: 2,
		  spaceBetween: 20,
		},
		640: {
		  slidesPerView: 1,
		  spaceBetween: 20,
		},
		320: {
		  slidesPerView: 1,
		  spaceBetween: 10,
		}
	  }
	});
	
</script>
-->
<script type="text/javascript">

$(document).ready(function() {
    
    <?php if(isset($_GET["msg"]) && intval($_GET["msg"]) == 1) {?>
	swal("Success", "Login successfully.", "success");
	<?php } else if(isset($_GET["msg"]) && intval($_GET["msg"]) == 2) {?>
	swal("Success", "Registered successfully.", "success");
	<?php } else if(isset($_GET["msg"]) && intval($_GET["msg"]) == 3) {?>
	swal("Success", "Signuout successfully.", "success");
	<?php } ?>
    
    window.history.replaceState(null, null, window.location.pathname);
    
});
    
</script>    

</body>
</html>
