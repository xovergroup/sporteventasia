<?php 

include_once "inc/app-top.php";
include_once "classes/CRUD.php";
include_once "classes/CustomDateTime.php";
include_once "classes/Miscellaneous.php";
include_once "classes/File.php";

$crud = new CRUD($mysqli);
$customdatetime = new CustomDateTime();
$misc = new Miscellaneous();
$file = new File();

if(isset($_GET["event_id"]) && !empty($_GET["event_id"])){
    $event_id = $crud->sanitizeInt($_GET["event_id"]);
    
    $crud->sql = "SELECT * FROM events WHERE event_id = ".$event_id;
    $the_event = $crud->selectOne();
    
    $one_day_event = $misc->checkIfSame($the_event->event_date_start, $the_event->event_date_end);
    if($one_day_event){ $checked = "checked"; } else { $checked = ""; }
    
    $form_action = "saveEvent";
    
    $date_start = $customdatetime->convertDateTime($the_event->event_date_start, 'Y-m-d');
    $date_end = $customdatetime->convertDateTime($the_event->event_date_end, 'Y-m-d');
    $time_start = $customdatetime->convertDateTime($the_event->event_time_start, 'H:i');
    $time_end = $customdatetime->convertDateTime($the_event->event_time_end, 'H:i');
    
    $tags = new CRUD($mysqli);
    $selected_tags = array();
    $tags->sql = "SELECT event_tag_tag FROM event_tag WHERE event_tag_event = ".$event_id;
    $tags->selectAll();
    if($tags->total > 0){
        while($row = $tags->result->fetch_object()){
            $selected_tags[] = $row->event_tag_tag;
        } 
        $tags->result->close(); 
    }
    
    
    
    
    
} else {
    $form_action  = "createEvent";
    
    $date_start = $customdatetime->dateTimeNow('Y-m-d');
    $date_end = $customdatetime->dateTimeNow('Y-m-d');
    $time_start = $customdatetime->dateTimeNow('h:i');
    $time_end = $customdatetime->dateTimeNow('h:i');
    
    $selected_tags = array();
}

?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Create Event 1</title>
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
                        <div class="circular-num-red">1</div>
                        <h5 style="color:#e04e3d;">General Information</h5>
                    </div>
                    <div class="create-step-box">
                        <div class="circular-num">2</div>
                        <h5>Race Kit & Other Information</h5>
                    </div>
                    <div class="create-step-box">
                        <div class="circular-num">3</div>
                        <h5>Category Types & Registration Form</h5>
                    </div>
                </div>


                <div class="content-box">

                    <input type="hidden" id="event-organizer" value="<?php echo $_SESSION["organizer_id"]; ?>">
                    <input type="hidden" id="event-id" value="<?php echo $event_id; ?>">
                    <input type="hidden" id="event-action" value="<?php echo $form_action; ?>">
                    <div class="content-box-row">
                        <label>Event Name</label><input type="text" placeholder="Event Name" id="event-name" class="validate-input-text" value="<?php echo $the_event->event_name; ?>">
                    </div>
                    <div class="content-box-row">
                        <label>Event Tag</label>
                        <div class="create-tag-field">
                            <div class="create-tag-box">

                                <?php 
                                    $crud->sql = "SELECT * FROM tags";
                                    $crud->selectAll();
                                    $counter = 1;
                                    if($crud->total > 0){
                                        while($row = $crud->result->fetch_object()){
                                            if(in_array($row->tag_id, $selected_tags)){
                                ?>
                                <input id="create-tag-<?php echo $counter; ?>" type="checkbox" class="event-tag validate-checkbox-tag" value="<?php echo $row->tag_id; ?>" name="event_tag[]" checked>
                                <label for="create-tag-<?php echo $counter; ?>"><?php echo $row->tag_title; ?></label>
                                <?php }else {?>
                                <input id="create-tag-<?php echo $counter; ?>" type="checkbox" class="event-tag validate-checkbox-tag" value="<?php echo $row->tag_id; ?>" name="event_tag[]">
                                <label for="create-tag-<?php echo $counter; ?>"><?php echo $row->tag_title; ?></label>

                                <?php }$counter++; } $crud->result->close(); } ?>

                            </div>
                        </div>
                    </div>
                    <div class="content-box-row">
                        <label>Event Location</label><input type="text" placeholder="Event Location" id="event-location" class="validate-input-text" value="<?php echo $the_event->event_location; ?>">
                    </div>
                    <div class="content-box-row">
                        <label>Event State</label>
                        <select id="event-state">
                        
                            <?php 
                                $crud->sql = "SELECT * FROM `states` ORDER BY `states`.`state_id` ASC";
                                $crud->selectAll();
                                if($crud->total > 0){
                                    while($row = $crud->result->fetch_object()){
                            ?>
							<option value="<?php echo $row->state_id; ?>" <?php echo $the_event->event_state == $row->state_id ? "selected" : "";?>><?php echo $row->state_name; ?></option>
                            <?php } $crud->result->close(); } ?>
                        </select>
                    </div>
                    <div class="content-box-row">
                        <label>Event Start Date</label>
                        <input type="date" class="date-picker validate-date-picker validate-date-picker-start" value="<?php echo $date_start; ?>" id="event-date-start">
                        <div class="content-box-radio">
                            <input type="checkbox" class="radio" id="event-one-day" <?php echo $checked; ?> > 1 Day Event
                        </div>
                    </div>
                    <div class="content-box-row">
                        <label>Event End Date</label>
                        <input type="date" class="date-picker validate-date-picker validate-date-picker-end" value="<?php echo $date_end; ?>" id="event-date-end">
                    </div>
                    <div class="content-box-row time-picker-row">
                        <label>Event Time</label>
                        <input type="time" class="date-picker validate-time-picker" value="<?php echo $time_start; ?>" id="event-time-start"> to <input type="time" class="date-picker validate-time-picker" value="<?php echo $time_end; ?>" id="event-time-end">
                    </div>
                    <div class="content-box-row">
                        <label>Event Banner & Thumbnails</label>

                        <?php if(isset($the_event->event_banner)){?>
                        <div class="image-upload-wrap" style="display: none;">
                            <input class="file-upload-input upload-banner" type='file' accept="image/*" />
                            <div class="drag-text">
                              <h5>Upload your banner here <br> 1200x480</h5>
                            </div>
                        </div>
                        <div class="file-upload-content" style="display: inline-block;">
                            <img class="file-upload-image upload-banner-src" src="<?php echo $file->convertImageToBase64($the_event->event_banner, "png"); ?>" alt="your image" />
                            <div class="image-title-wrap">
                                <button type="button" class="remove-image">Remove <span class="image-title">Uploaded Image</span></button>
                            </div>
                        </div>
                        <?php } else { ?>
                        <div class="image-upload-wrap">
                            <input class="file-upload-input upload-banner" type='file' accept="image/*" />
                            <div class="drag-text">
                              <h5>Upload your banner here <br> 1200x480</h5>
                            </div>
                        </div>
                        <div class="file-upload-content">
                            <img class="file-upload-image upload-banner-src" src="#" alt="your image" />
                            <div class="image-title-wrap">
                                <button type="button" class="remove-image">Remove <span class="image-title">Uploaded Image</span></button>
                            </div>
                        </div>
                        <?php } ?>


                        <?php if(isset($the_event->event_thumbnail)){?>
                        <div class="image-upload-wrap" style="display: none;">
                            <input class="file-upload-input upload-thumbnail" type='file' accept="image/*" />
                            <div class="drag-text">
                              <h5>Upload your thumbnail here <br> 600x600</h5>
                            </div>
                        </div>
                        <div class="file-upload-content" style="display: inline-block;">
                            <img class="file-upload-image upload-thumbnail-src" src="<?php echo $file->convertImageToBase64($the_event->event_thumbnail, "png"); ?>" alt="your image" />
                            <div class="image-title-wrap">
                                <button type="button" class="remove-image">Remove <span class="image-title">Uploaded Image</span></button>
                            </div>
                        </div>
                        <?php } else { ?>
                        <div class="image-upload-wrap">
                            <input class="file-upload-input upload-thumbnail" type='file' accept="image/*" />
                            <div class="drag-text">
                              <h5>Upload your thumbnail here <br> 600x600</h5>
                            </div>
                        </div>
                        <div class="file-upload-content">
                            <img class="file-upload-image upload-thumbnail-src" src="#" alt="your image" />
                            <div class="image-title-wrap">
                                <button type="button" class="remove-image">Remove <span class="image-title">Uploaded Image</span></button>
                            </div>
                        </div>
                        <?php } ?>

                    </div>
                    <div class="content-box-row">
                        <label>Event Description</label><textarea type="text" placeholder="Describe your event" id="event-description" class="validate-input-text"><?php echo $the_event->event_description; ?></textarea>
                    </div>
                    <div class="content-box-row">
                        <label>Event Page URL</label><input type="text" placeholder="Event Page URL" id="event-url" class="validate-input-text" value="<?php echo $the_event->event_url; ?>">
                    </div>
                </div>


                <div class="content-box">
                    <div class="content-box-header">
                        <label>Sponsors</label>
                        <button class="float-right btn-gray-outline add-sponsor">+ Add Sponsors</button>
                    </div>
                    <div class="">

                        <?php 

                        if(isset($_GET["event_id"]) && !empty($_GET["event_id"])){

                            $crud->sql = "SELECT * FROM event_sponsor WHERE event_sponsor_event = ".$crud->sanitizeInt($_GET["event_id"]). " ORDER BY event_sponsor_id ASC";
                            $crud->selectAll();
                            if($crud->total > 0){
                                while($row = $crud->result->fetch_object()){
                        ?>
                        <div class="sponsor-field">
                            <div class="sponsor-box">
                                <div class="image-upload-wrap" style="width:100%; display: none;">
                                    <input class="file-upload-input upload-sponsor" type='file' accept="image/*" />
                                    <div class="drag-text">
                                      <h5>Upload your sponsor logo here <br> 600x600</h5>
                                    </div>
                                </div>
                                <img src="<?php echo $file->convertImageToBase64($row->event_sponsor_image, "png"); ?>" class="sponsor-image">
                                <input type="text" placeholder="Sponsor Type" class="sponsor-type" value="<?php echo $row->event_sponsor_type; ?>">
                            </div>
                            <button class="btn-close upload-sponsor-cancel"><i class="fas fa-times"></i></button>
                        </div>
                        <?php } $crud->result->close(); } else {?>
                        <div class="sponsor-field">
                            <div class="sponsor-box">
                                <div class="image-upload-wrap" style="width:100%;">
                                    <input class="file-upload-input upload-sponsor" type='file' accept="image/*" />
                                    <div class="drag-text">
                                      <h5>Upload your sponsor logo here <br> 600x600</h5>
                                    </div>
                                </div>
                                <input type="text" placeholder="Sponsor Type" class="sponsor-type">
                            </div>
                            <button class="btn-close upload-sponsor-cancel"><i class="fas fa-times"></i></button>
                        </div>
                        <?php } } else { ?>
                        <div class="sponsor-field">
                            <div class="sponsor-box">
                                <div class="image-upload-wrap" style="width:100%;">
                                    <input class="file-upload-input upload-sponsor" type='file' accept="image/*" />
                                    <div class="drag-text">
                                      <h5>Upload your sponsor logo here <br> 600x600</h5>
                                    </div>
                                </div>
                                <input type="text" placeholder="Sponsor Type" class="sponsor-type">
                            </div>
                            <button class="btn-close upload-sponsor-cancel"><i class="fas fa-times"></i></button>
                        </div>
                        <?php } ?>


                        <div class="sponsor-field-end"></div>
                    </div>
                </div>



                <div class="content-box">
                    <div class="">
                        <button class="btn-dgray save-general-information">Save</button>
                        <!--<a href="" class="btn-gray">Back</a>-->
                        <a href="#" class="btn-red float-right to-racekit-other">Next</a>
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
<script type="text/javascript" src="js/organizer-create-event-page-1.js<?php echo '?'.mt_rand(); ?>"></script>

</body>
</html>
<?php include_once "inc/app-bottom.php"; ?>