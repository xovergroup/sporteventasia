<?php 

include_once "inc/app-top.php";
include_once "classes/CRUD.php";
include_once "classes/CustomDateTime.php";
include_once "classes/State.php";
include_once "classes/Miscellaneous.php";


if(isset($_GET["event_id"])){
    
    $event_id   = intval($_GET["event_id"]);
    $crud       = new CRUD($mysqli);
    $tags       = new CRUD($mysqli);
    $sponsors   = new CRUD($mysqli);
    $categories = new CRUD($mysqli);
    $datetime   = new CustomDateTime();
    $state      = new State();
    $misc       = new Miscellaneous();
    
    //check
    $crud->sql = "SELECT COUNT(event_id) AS total FROM events WHERE event_id = ".$event_id." AND event_organizer = ".$_SESSION["organizer_id"];
    $validate = $crud->selectOne();
    if($validate->total < 1){
        header("Location: event-page-list.php");
    }
    
    //select event detail
    $crud->sql = "SELECT * FROM events WHERE event_id = ".$event_id;
    $the_event = $crud->selectOne();
    
    //state name
    $state_name = $state->getStateName($the_event->event_state);
    
    //event tags
    $tags->sql = "SELECT * FROM tags, event_tag WHERE `tags`.`tag_id` = `event_tag`.`event_tag_tag` AND `event_tag`.`event_tag_event` = ".$event_id;
    $tags->selectAll();
    
    //event sponsors
    $sponsors->sql = "SELECT * FROM `event_sponsor` WHERE `event_sponsor`.`event_sponsor_event` = ".$event_id." ORDER BY `event_sponsor_id` ASC";
    $sponsors->selectAll();
    
    //event category
    $categories->sql = "SELECT * FROM `event_category` WHERE `event_category`.`event_category_event` = ".$event_id." ORDER BY `event_category_id` ASC";
    $categories->selectAll();
  
} else {
    header("Location: event-page-list.php");
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
                        <h2>Lorem Ipsum Dolor Event Detail</h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="main-content">
            <div class="container-custom">

                <div class="content-box">
                    <div class="row">
                        <div class="col-lg-3">
                            <h5 class="mt-2 align-middle">Status <span class="text-success">Approved</span></h5>
                        </div>
                        <div class="col-lg-3">
                        	<button class="btn-dgray btn-block">POST NEWS</button>
                        </div>
                        <div class="col-lg-3">
                        	<button class="btn-green btn-block go-preview" data-event="<?php echo $event_id; ?>">PREVIEW</button>
                        </div>
                        <div class="col-lg-3">
                            <button class="btn-red btn-block go-edit" data-event="<?php echo $event_id; ?>">EDIT EVENT</button>
                        </div>
                    </div>
                </div>
                
                <div class="accordion" id="accordionExample">
                    <div class="card content-box">
                        <div class="card-header" id="headingOne">
                        <h5 class="mb-0">
                        <button class="btn btn-link btn-accordion" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne" onclick="$('.collapseOne-icon').toggleClass('fa-rotate-180')">
                        Basic Information <i class="fa fa-caret-up float-right collapseOne-icon"></i>
                        </button>
                        </h5>
                        </div>
                    
                        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                            <div class="card-body">
                                <div class="content-box-row">
                                    <p>Thumbnails & Banner</p>
                                    <div class="row">
                                        <div class="col-md-5">
                                            <img src="<?php echo $the_event->event_thumbnail; ?>">
                                        </div>
                                        <div class="col-md-7">
                                            <img src="<?php echo $the_event->event_banner; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="content-box-row">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <p>Event Name</p>
                                        </div>
                                        <div class="col-md-9">
                                            <p><?php echo $the_event->event_name; ?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="content-box-row">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <p>Event Start Date</p>
                                        </div>
                                        <div class="col-md-9">
                                            <p><?php echo $the_event->event_date_start; ?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="content-box-row">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <p>Event Start Time</p>
                                        </div>
                                        <div class="col-md-9">
                                            <p><?php echo $datetime->convertDateTime($the_event->event_time_start, "g:iA"); ?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="content-box-row">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <p>Event End Time</p>
                                        </div>
                                        <div class="col-md-9">
                                            <p><?php echo $datetime->convertDateTime($the_event->event_time_end, "g:iA"); ?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="content-box-row">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <p>Event Tag</p>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="row">
                                                <?php 
                                                if($tags->total > 0){
                                                    $counter_tag = 1;
                                                    while($tag = $tags->result->fetch_object()){
                                                ?>
                                                <p class="col-md-auto"><span class="badge badge-light p-3"><?php echo $tag->tag_title; ?></span></p>
                                                <?php $counter_tag++; } $tags->result->close(); } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="content-box-row">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <p>Event State</p>
                                        </div>
                                        <div class="col-md-9">
                                            <p><?php echo $state_name; ?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="content-box-row">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <p>Event Location</p>
                                        </div>
                                        <div class="col-md-9">
                                            <p><?php echo $the_event->event_location; ?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="content-box-row">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <p>Event Description</p>
                                        </div>
                                        <div class="col-md-9">
                                            <p><?php echo $the_event->event_description; ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="accordion" id="accordionExample">
                    <div class="card content-box">
                        <div class="card-header" id="headingTwo">
                        <h5 class="mb-0">
                        <button class="btn btn-link btn-accordion" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo" onclick="$('.collapseTwo-icon').toggleClass('fa-rotate-180')">
                        Race Kit & Other Information <i class="fa fa-caret-up float-right collapseTwo-icon"></i>
                        </button>
                        </h5>
                        </div>
                    
                        <div id="collapseTwo" class="collapse show" aria-labelledby="headingTwo" data-parent="#accordionExample">
                            <div class="card-body">
                            	<div class="">
                                	<p class="text-danger">Race Kit Information</p>
                                    <input type="hidden" class="db-racekit" value="<?php echo html_entity_decode($the_event->event_racekit);?>">
                                    <div class="rc-info"></div>
                                    <p class="text-danger">Other Information</p>
                                    <input type="hidden" class="db-other-info" value="<?php echo html_entity_decode($the_event->event_other_information);?>">
                                    <div class="event-other-info"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="accordion" id="accordionExample">
                    <div class="card content-box">
                        <div class="card-header" id="headingThree">
                        <h5 class="mb-0">
                        <button class="btn btn-link btn-accordion" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree" onclick="$('.collapseThree-icon').toggleClass('fa-rotate-180')">
                        Event Category <i class="fa fa-caret-up float-right collapseThree-icon"></i>
                        </button>
                        </h5>
                        </div>
                    
                        <div id="collapseThree" class="collapse show" aria-labelledby="headingThree" data-parent="#accordionExample">
                            <div class="card-body">
                                <div class="event-category-table">
                                    <table class="">
                                        <tr class="border-none">
                                            <th>Category</th>
                                            <th>Description</th> 
                                            <th>Registration Date</th>
                                            <th>Price</th>
                                        </tr>
                                        
                                        <?php 
                                            if($categories->total > 0){
                                                $counter_category = 1;
                                                while($category = $categories->result->fetch_object()){
                                                    
                                                    $datetime->getDateDiff(date('Y-m-d'), $category->event_category_fees_early_bird_date_end);
                                        ?>
                                        <tr>
                                            <td><p class=""><?php echo $category->event_category_name; ?></p><p><?php echo $category->event_category_pax; ?> Pax | <?php echo $category->event_category_limited_slot; ?> <?php echo $misc->singularPlural($category->event_category_limited_slot, "Slot", "Slots"); ?></p></td>
                                            <td><p><?php echo $category->event_category_desc; ?></p></td>
                                            <td><p>Start Date: <?php echo $datetime->convertDateTime($category->event_category_reg_date_start, "d F Y"); ?> <br>End Date: <?php echo $datetime->convertDateTime($category->event_category_reg_date_end, "d F Y"); ?> </p></td>
                                            
                                            <?php if($category->event_category_fees_early_bird == 0){?>
                                            <td><p class="">MYR <?php echo $category->event_category_fees; ?></p>
                                            <?php } else { if($datetime->number > 0){?>
                                            <td><p class="">MYR <?php echo $category->event_category_fees_early_bird; ?></p><p class="txt-dashed text-secondary">MYR <?php echo $category->event_category_fees; ?></p><p class="text-danger"><?php echo $datetime->msg; ?> left at this price!</p></td>
                                            <?php } else { ?>
                                            <td><p class="">MYR <?php echo $category->event_category_fees; ?></p></td>
                                            <?php } } ?>
                                            
                                            
                                            
                                            
                                        </tr>
                                        <?php $counter_category++; } $categories->result->close(); } ?>
                                        
                                        <!--
                                        <tr>
                                            <td><p class="">Indiviual Male</p><p>1 Pax | 100 Slots</p></td>
                                            <td><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua</p></td>
                                            <td><p>Start Date: 19 July 2019 <br>End Date: 19 July 2019 </p></td>
                                            <td><p class="">MYR 50</p><p class="txt-dashed text-secondary">MYR 30</p><p class="text-danger">2 days left at this price!</p></td>
                                        </tr>
                                        <tr>
                                            <td><p class="">Indiviual Male</p><p>1 Pax | 100 Slots</p></td>
                                            <td><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua</p></td>
                                            <td><p>Start Date: 19 July 2019 <br>End Date: 19 July 2019 </p></td>
                                            <td><p class="">MYR 50</p><p class="txt-dashed text-secondary">MYR 30</p><p class="text-danger">2 days left at this price!</p></td>
                                        </tr>
                                        <tr>
                                            <td><p class="">Indiviual Male</p><p>1 Pax | 100 Slots</p></td>
                                            <td><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua</p></td>
                                            <td><p>Start Date: 19 July 2019 <br>End Date: 19 July 2019 </p></td>
                                            <td><p class="">MYR 50</p><p class="txt-dashed text-secondary">MYR 30</p><p class="text-danger">2 days left at this price!</p></td>
                                        </tr>
                                        -->
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="accordion" id="accordionExample">
                    <div class="card content-box">
                        <div class="card-header" id="headingFour">
                        <h5 class="mb-0">
                        <button class="btn btn-link btn-accordion" type="button" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour" onclick="$('.collapseFour-icon').toggleClass('fa-rotate-180')">
                        Sponsor <i class="fa fa-caret-up float-right collapseFour-icon"></i>
                        </button>
                        </h5>
                        </div>
                    
                        <div id="collapseFour" class="collapse show" aria-labelledby="headingFour" data-parent="#accordionExample">
                            <div class="card-body">
                            	<div class="row">
                                    <?php 
                                    if($sponsors->total > 0){
                                        $counter_sponsor = 1;
                                        while($sponsor = $sponsors->result->fetch_object()){
                                    ?>
                                    <div class="col-md-3">
                                        <p class="text-danger text-center">Medal By <?php echo $sponsor->event_sponsor_type; ?></p>
                                        <img src="<?php echo $sponsor->event_sponsor_image; ?>">
                                    </div>
                                    <?php $counter_sponsor++; } $sponsors->result->close(); } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="accordion" id="accordionExample">
                    <div class="card content-box">
                        <div class="card-header" id="headingFive">
                        <h5 class="mb-0">
                        <button class="btn btn-link btn-accordion" type="button" data-toggle="collapse" data-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive" onclick="$('.collapseFive-icon').toggleClass('fa-rotate-180')">
                        Latest News <i class="fa fa-caret-up float-right collapseFive-icon"></i>
                        </button>
                        </h5>
                        </div>
                    
                        <div id="collapseFive" class="collapse show" aria-labelledby="headingFive" data-parent="#accordionExample">
                            <div class="card-body">
                            	<div>
                                	<div class="p-2">
                                        <h5>UPDATE: Lorem Ipsum Dolor Sit Amet</h5>
                                        <p class="text-danger">20 July 2018</p>
                                        <p>Lorem Ipsum Dolor Sit Amet</p>
                                    </div>
                                    <button class="btn-red">EDIT NEWS</button>
                                    <button class="btn-dgray">REMOVE NEWS</button>
                                </div>
                            </div>
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
<script type="text/javascript" src="js/organizer-event-page-detail.js<?php echo '?'.mt_rand(); ?>"></script>

</body>
</html>
<?php include_once "inc/app-bottom.php"; ?>