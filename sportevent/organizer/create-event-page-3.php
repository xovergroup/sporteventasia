<?php 

include_once "inc/app-top.php";
include_once "classes/CRUD.php";
include_once "classes/CustomDateTime.php";
include_once "classes/Miscellaneous.php";

$crud = new CRUD($mysqli);
$misc = new Miscellaneous();
$customdatetime = new CustomDateTime();



if(isset($_GET["event_id"]) && !empty($_GET["event_id"])){
    $event_id = $crud->sanitizeInt($_GET["event_id"]);
    
    $categories = new CRUD($mysqli);
    $categories->sql = "SELECT * FROM event_category WHERE event_category_event = ".$event_id." ORDER BY event_category_id ASC";
    $categories->selectAll();
    
    if(isset($_SESSION["action_status"]) && isset($_SESSION["action_msg"])){
        $action_status = $_SESSION["action_status"];
        $action_msg = $_SESSION["action_msg"];
        $action_redirect = $_SESSION["action_redirect"];
        
        unset($_SESSION["action_status"]);
        unset($_SESSION["action_msg"]);
        unset($_SESSION["action_redirect"]);
    } else {
        $action_status = 0;
        $action_msg = "";
        $action_redirect = "";
    }
    
    $date_today = $customdatetime->dateTimeNow('Y-m-d');
    
} else {
    header("Location: create-event-page-1.php");
}

?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Create Event 3</title>
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
                    <h2>Create Event</h2>
                </div>
            </div>
        </div>
    </div>
    
    <div class="main-content">
    	<div class="container-custom">
        
    		<div class="content-box">
            	<div class="create-step-box">
                	<div class="circular-num-gray">1</div>
                	<h5>General Information</h5>
                </div>
                <div class="create-step-box">
                	<div class="circular-num-gray">2</div>
                	<h5>Race Kit & Other Information</h5>
                </div>
                <div class="create-step-box">
                	<div class="circular-num-red">3</div>
                	<h5 style="color:#e04e3d;">Category Types & Registration Form</h5>
                </div>
            </div>
            
            <input type="hidden" class="action-status" value="<?php echo $action_status; ?>">
            <input type="hidden" class="action-msg" value="<?php echo $action_msg; ?>">
            <input type="hidden" class="action-redirect" value="<?php echo $action_redirect; ?>">
            <input type="hidden" class="activity-count" value="0">
            <input type="hidden" class="date-today-is" value="<?php echo $date_today; ?>">
            
            <form id="form-event-category" action="submit-via-form.php" method="post">
                <div class="accordion" id="accordionExample"><!--<!--ALL CATEGORY STARTS-->

                    <input type="hidden" name="action" value="saveEventCategory">
                    <input type="hidden" name="event_id" class="event-id" value="<?php echo $event_id; ?>">
                    <input type="hidden" id="counter-category" value="<?php echo $categories->total; ?>">
                    
                    
                    <!--STATIC CATEGORY STARTS-->
                    <?php 
                        
                        if($categories->total > 0){
                            $counter_category = 1;
                            while($category = $categories->result->fetch_object()){
                            
                    ?>
                    <div class="card content-box category-no" data-category="<?php echo $counter_category; ?>">

                        <div class="card-header" id="heading-<?php echo $counter_category; ?>">
                            <h5 class="mb-0">
                                <button class="btn btn-link btn-accordion" type="button" data-toggle="collapse" data-target="#collapse-<?php echo $counter_category; ?>" aria-expanded="true" aria-controls="collapse-<?php echo $counter_category; ?>">
                                Event Category #<span class="count-category-title"><?php echo $counter_category; ?></span> <i class="fa fa-caret-up float-right collapse-icon"></i>
                                </button>
                            </h5>
                        </div>

                        <div id="collapse-<?php echo $counter_category; ?>" class="collapse show count-heading" aria-labelledby="heading-<?php echo $counter_category; ?>" data-parent="#accordionExample">
                            <div class="card-body">
                                <p class="txt-red">Category Information</p>
                                <div class="content-box-gray">
                                   
                                   
                                    <input type="hidden" name="event_category_number[]" class="event-category-number" value="<?php echo $counter_category; ?>">
                                    <div class="content-box-gray-row">
                                        <label>Category Name</label><input type="text" placeholder="Category Name" name="event_category_name[]" class="validate-input-text" value="<?php echo $category->event_category_name; ?>">
                                    </div>
                                    <div class="content-box-gray-row">
                                        <label>Category Fees</label><input type="text" placeholder="MYR 50" name="event_category_fees[]" class="validate-input-text" value="<?php echo $category->event_category_fees; ?>">
                                    </div>
                                    <div class="content-box-gray-row">
                                        <label>Early Bird Price</label><input type="text" placeholder="Optional" class="early-input" name="event_category_fees_early_bird[]" value="<?php echo $category->event_category_fees_early_bird; ?>">Before<input type="date" class="date-picker early-date" value="<?php echo $category->event_category_fees_early_bird_date_end; ?>" name="event_category_fees_early_bird_date_end[]">
                                    </div>
                                    <div class="content-box-gray-row">
                                        <label>Category Pax</label><input type="text" placeholder="Category Pax" name="event_category_pax[]" class="validate-input-text" value="<?php echo $category->event_category_pax; ?>">
                                    </div>
                                    <div class="content-box-gray-row">
                                        <label>Category Limited Slot</label><input type="text" placeholder="Category Limited Slot" name="event_category_limited_slot[]" class="validate-input-text" value="<?php echo $category->event_category_limited_slot; ?>">
                                    </div>
                                    <div class="content-box-gray-row">
                                        <label>Registration Start Date</label><input type="date" class="date-picker validate-date-picker validate-date-picker-start" value="<?php echo $category->event_category_reg_date_start; ?>" name="event_category_reg_date_start[]">
                                    </div>
                                    <div class="content-box-gray-row">
                                        <label>Registration End Date</label><input type="date" class="date-picker validate-date-picker validate-date-picker-end" value="<?php echo $category->event_category_reg_date_end; ?>" name="event_category_reg_date_end[]">
                                    </div>
                                    <div class="content-box-gray-row">
                                        <label>Category Description</label><textarea type="text" placeholder="Describe your category" name="event_category_desc[]" class="validate-input-text"><?php echo $category->event_category_desc; ?></textarea>
                                    </div>
                                    <div class="content-box-gray-row">
                                        <label>Category Promo Code</label><input type="text" placeholder="8888" name="event_category_promo_code[]" value="<?php echo $category->event_category_promo_code; ?>">
                                    </div>
                                </div>


                                <p class="txt-red">Registration Form</p>

                                <!--Static Control STARTS-->
                                <?php 
                                
                                    $inputs = new CRUD($mysqli);
                                    $inputs->sql = "SELECT * FROM event_input WHERE event_input_event = ".$event_id." AND event_input_category = ".$counter_category." ORDER BY event_input_id ASC";
                                    $inputs->selectAll();
                                
                                    if($inputs->total > 0){
                                        $counter_input = 1;
                                        while($input = $inputs->result->fetch_object()){

                                ?>
                                <div class="content-box-gray position-relative control-container">
                                    <input type="hidden" class="event-input-category" name="event_input_category[]" value="<?php echo $counter_category; ?>">
                                    <input type="hidden" class="event-input-number" name="event_input_number[]" value="<?php echo $counter_input; ?>">
                                    <input type="hidden" class="event-input-type" name="event_input_type[]" value="<?php echo $input->event_input_type; ?>">
                                    <input type="hidden" class="event-input-allow-user-type" name="event_input_allow_user_type[]" value="<?php echo $input->event_input_allow_user_type; ?>">
                                    <div class="row">
                                        <div class="col-sm align-center content-box-reg">
                                            <label>Label Name</label><br><input type="text" placeholder="Label Name" name="event_input_label_name[]" class="validate-input-text-category" value="<?php echo $input->event_input_label_name; ?>">
                                        </div>
                                        <div class="col-sm align-center content-box-reg">
                                            <label>Input Type</label><br>
                                            <select class="chosen-input-type">
                                                <option value="1" <?php echo $input->event_input_type == 1 ? "selected" : "";?> >Single Line</option>
                                                <option value="2" <?php echo $input->event_input_type == 2 ? "selected" : "";?> >Multi Line</option>
                                                <option value="10" <?php echo $input->event_input_type == 10 ? "selected" : "";?> >NRIC/Passport</option>
                                                <option value="11" <?php echo $input->event_input_type == 11 ? "selected" : "";?> >Gender</option>
                                                <option value="12" <?php echo $input->event_input_type == 12 ? "selected" : "";?> >Contact</option>
                                                <option value="3" <?php echo $input->event_input_type == 3 ? "selected" : "";?> >Date</option>
                                                <option value="4" <?php echo $input->event_input_type == 4 ? "selected" : "";?> >Time</option>
                                                <option value="5" <?php echo $input->event_input_type == 5 ? "selected" : "";?> >Dropdown</option>
                                                <option value="6" <?php echo $input->event_input_type == 6 ? "selected" : "";?> >Check Box</option>
                                                <option value="7" <?php echo $input->event_input_type == 7 ? "selected" : "";?> >Radio Button</option>
                                                <option value="8" <?php echo $input->event_input_type == 8 ? "selected" : "";?> >Malaysian States</option>
                                                <option value="9" <?php echo $input->event_input_type == 9 ? "selected" : "";?> >Countries</option>
                                            </select>
                                        </div>
                                        <div class="col align-center content-box-reg">
                                            <label>Remark</label><br><input type="text" placeholder="Remark" name="event_input_remark[]" value="<?php echo $input->event_input_remark; ?>">
                                        </div>
                                        <div class="col-sm align-center content-box-reg">
                                            <label></label><br>
                                            <input type="radio" class="mt20 event-input-radio" <?php echo $input->event_input_required == 1 ? "checked" : "";?> >Required?
                                            <input type="hidden" class="event-input-required" name="event_input_required[]" value="<?php echo $input->event_input_required; ?>">
                                        </div>
                                    </div>
                                    
                                    <?php if($input->event_input_type == 5 || $input->event_input_type == 6 || $input->event_input_type == 7){?>
                                    <div class="sub-input-dynamic">
                                        <div class="row mt-2 mdn">
                                            <div class="col content-box-reg">
                                                <label>Option Label</label>
                                            </div>
                                            <div class="col content-box-reg">
                                                <label>Set Limit</label>
                                            </div>
                                            <div class="col content-box-reg">
                                            </div>
                                        </div>

                                        <?php 
                                            $options = new CRUD($mysqli);
                                            $options->sql = "SELECT * FROM event_option WHERE event_option_event = ".$event_id." AND event_option_category = ".$counter_category." AND event_option_number = ".$counter_input." ORDER BY event_option_id ASC";
                                            $options->selectAll();
                                    
                                            if($options->total > 0){
                                                $counter_option = 1;
                                                while($option = $options->result->fetch_object()){
                                        ?>
                                        <div class="row mb-2 option-container">
                                            <input type="hidden" class="event-option-category" name="event_option_category[]" value="<?php echo $counter_category; ?>">
                                            <input type="hidden" class="event-option-number" name="event_option_number[]" value="<?php echo $counter_input; ?>">
                                            <input type="hidden" class="event-option-type" name="event_option_type[]" value="<?php echo $option->event_option_type; ?>">
                                            <div class="col-sm content-box-reg mt-1">
                                                <input type="text" placeholder="Option 1" class="counter-option validate-input-text-option" name="event_option_title[]" value="<?php echo $option->event_option_title; ?>">
                                            </div>
                                            <div class="col-sm content-box-reg mt-1">
                                                <input type="text" placeholder="Set Limit" name="event_option_limit[]" value="<?php echo $misc->convertZeroToNull($option->event_option_limit); ?>">
                                            </div>
                                            <div class="col-sm content-box-reg">
                                                <button class="btn-close m-0 mt-1 remove-option"><i class="fas fa-times"></i></button>
                                            </div>
                                        </div>
                                        <?php $counter_option++; } $options->result->close(); } else { ?>
                                        <?php } ?>


                                        <div class="option-end"></div>

                                        <button class="btn-reg-close"><i class="fas fa-times"></i></button>
                                        <input type="radio" class="ml-1 event-input-allow-type" <?php echo $input->event_input_allow_user_type == 1 ? "checked" : "";?> > Let user type other value?<br>
                                        <button class="btn-green add-more-option" style="background:#2F2F2F;">+ Add Option</button>

                                    </div>
                                    <?php } ?>

                                    <div class="input-type-end"></div>
                                    <button class="btn-reg-close remove-control"><i class="fas fa-times"></i></button>
                                </div>
                                <?php $counter_input++; } $inputs->result->close(); } else { ?>
                                <div class="content-box-gray position-relative control-container">
                                    <input type="hidden" class="event-input-category" name="event_input_category[]" value="<?php echo $counter_category; ?>">
                                    <input type="hidden" class="event-input-number" name="event_input_number[]" value="1">
                                    <input type="hidden" class="event-input-type" name="event_input_type[]" value="1">
                                    <input type="hidden" class="event-input-allow-user-type" name="event_input_allow_user_type[]" value="0">
                                    <div class="row">
                                        <div class="col-sm align-center content-box-reg">
                                            <label>Label Name</label><br><input type="text" placeholder="Label Name" name="event_input_label_name[]" class="validate-input-text-category">
                                        </div>
                                        <div class="col-sm align-center content-box-reg">
                                            <label>Input Type</label><br>
                                            <select class="chosen-input-type">
                                                <option value="1">Single Line</option>
                                                <option value="2">Multi Line</option>
                                                <option value="10">NRIC/Passport</option>
                                                <option value="11">Gender</option>
                                                <option value="12">Contact</option>
                                                <option value="3">Date</option>
                                                <option value="4">Time</option>
                                                <option value="5">Dropdown</option>
                                                <option value="6">Check Box</option>
                                                <option value="7">Radio Button</option>
                                                <option value="8">Malaysian States</option>
                                                <option value="9">Countries</option>
                                            </select>
                                        </div>
                                        <div class="col align-center content-box-reg">
                                            <label>Remark</label><br><input type="text" placeholder="Remark" name="event_input_remark[]">
                                        </div>
                                        <div class="col-sm align-center content-box-reg">
                                            <label></label><br>
                                            <input type="radio" class="mt20 event-input-radio">Required?
                                            <input type="hidden" class="event-input-required" name="event_input_required[]" value="0">
                                        </div>
                                    </div>

                                    <div class="input-type-end"></div>
                                    <button class="btn-reg-close remove-control"><i class="fas fa-times"></i></button>
                                </div>
                                <?php } ?>
                                <!--Static Control ENDS-->


                                <div class="control-end"></div>

                                <button class="btn-green add-control">+ Add Control</button>
                                <button class="btn-red delete-category"><i class="fas fa-times"></i> Delete Category</button>
                            </div>
                        </div>
                    </div>
                    <?php $counter_category++; } $categories->result->close(); } ?>
                    
                    
                    
                    
                    
                    
                    
                    
                    <!--STATIC CATEGORY ENDS-->
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    <div class="category-end"></div>

                </div><!--ALL CATEGORY ENDS-->
            
                <button class="btn-addCategory add-category">+ Add Category</button>
            </form>
            
            <div class="content-box">
            	<div class="">
                	<button class="btn-dgray save-event-category">Save</button>
                    <a href="create-event-page-2.php?event_id=<?php echo $event_id; ?>" class="btn-gray back-to-racekit-other">Back</a>
                    <a href="" class="btn-red float-right">Submit to Review</a>
                    <!--<a href="" class="btn-green float-right">Preview</a>-->
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
<script type="text/javascript" src="js/organizer-create-event-page-3.js<?php echo '?'.mt_rand(); ?>"></script>

</body>
</html>
