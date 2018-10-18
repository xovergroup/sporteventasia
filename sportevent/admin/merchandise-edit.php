<?php 

include_once "inc/app-top.php"; 
include_once "../organizer/classes/CRUD.php"; 
include_once "../organizer/classes/File.php"; 

if(isset($_GET["merchandise_id"])){
    
    $crud               = new CRUD($mysqli);
    $merchandise_id     = $crud->sanitizeInt($_GET["merchandise_id"]);
    $crud->sql          = "SELECT * FROM `merchandises` WHERE `merchandises`.`merchandise_id` = ".$merchandise_id;
    $the_merchandise    = $crud->selectOne();
    if($the_merchandise == 0){
        header("Location: merchandise-list.php");
    }
    
    $variables          = new CRUD($mysqli);
    $options            = new CRUD($mysqli);
    
    $file = new File();
    
} else {
    header("Location: merchandise-list.php");
}



?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Edit Merchandise</title>
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
                        <h2>Edit Merchandise</h2>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="main-content" data-event="<?php echo $the_merchandise->merchandise_id; ?>">
            <div class="container-custom">

                <div class="content-box">
                	<div class="content-box-row">
                        <label>Merchandise Image</label>
                        
                        <?php if(isset($the_merchandise->merchandise_image)){?>
                        <div class="image-upload-wrap" style="display: none;">
                            <input class="file-upload-input upload-merchandise" type='file' accept="image/*" />
                            <div class="drag-text">
                              <h5>Upload your merchandise here <br> 1200x480</h5>
                            </div>
                        </div>
                        <div class="file-upload-content" style="display: inline-block;">
                            <img class="file-upload-image upload-merchandise-src" src="<?php echo $file->convertImageToBase64($the_merchandise->merchandise_image, "png"); ?>" alt="your image" />
                            <div class="image-title-wrap">
                                <button type="button" class="remove-image">Remove <span class="image-title">Uploaded Image</span></button>
                            </div>
                        </div>
                        <?php } else { ?>
                        <div class="image-upload-wrap">
                            <input class="file-upload-input upload-merchandise" type='file' accept="image/*" />
                            <div class="drag-text">
                                <h5>Upload your merchandise here <br> 1200x600</h5>
                            </div>
                        </div>
                        <div class="file-upload-content">
                            <img class="file-upload-image upload-merchandise-src" src="#" alt="your image" />
                            <div class="image-title-wrap">
                                <button type="button" class="remove-image">Remove <span class="image-title">Uploaded Image</span></button>
                            </div>
                        </div>
                        <?php } ?>

                        
                    </div>
                    <div class="content-box-row">
                        <label>Merchandise Name</label><input type="text" placeholder="" value="<?php echo $the_merchandise->merchandise_name; ?>" class="merchandise-name">
                    </div>
                    <div class="content-box-row">
                        <label>Merchandise Price</label><input type="text" placeholder="" value="<?php echo $the_merchandise->merchandise_price; ?>" class="merchandise-price">
                    </div>
                    <div class="content-box-row">
                        <label>Merchandise Description</label><textarea type="text" placeholder="" class="merchandise-description"><?php echo $the_merchandise->merchandise_desc; ?></textarea>
                    </div>
                    
                    <p class="text-danger">Merchandise Variables</p>
                    
                    
                        <?php 
                            $variables->sql = "SELECT * FROM `merchandise_variable` WHERE variable_merchandise = ".$merchandise_id. " ORDER BY variable_id ASC";
                            $variables->selectAll();
                            if($variables->total > 0){
                                
                                $counter_variable = 1;

                                while($variable = $variables->result->fetch_object()){
                        ?>
                    	<div class="content-box-gray position-relative each-variable" data-variable="<?php echo $counter_variable; ?>" data-required="<?php echo $variable->variable_require; ?>" data-type-other-value="<?php echo $variable->variable_other_value; ?>">
                            <div class="row">
                            	<div class="col-sm align-center content-box-reg">
                               		<label>Label Name</label><br><input type="text" placeholder="Label Name" class="variable-name" value="<?php echo $variable->variable_name; ?>">
                                </div>
                                <div class="col-sm align-center content-box-reg">
                               		<label>Input Type</label><br>
                                    <select class="variable-select">
                                        <option value="1" <?php echo $variable->variable_type == 1 ? "selected" : "";?>>Dropdown</option>
                                        <option value="2" <?php echo $variable->variable_type == 2 ? "selected" : "";?>>Single Line</option>
                                    </select>
                                </div>
                                <div class="col-sm align-center content-box-reg">
                               		<label>Remark</label><br><input type="text" placeholder="Remark" class="variable-remark" value="<?php echo $variable->variable_remark; ?>">
                                </div>
                                <div class="col-sm align-center content-box-reg">
                                	<label></label><br>
                                    <input type="checkbox" class="mt20 checkbox-required" <?php echo $variable->variable_require == 1 ? "checked" : "";?>>
                                    <span class="clickable-checkbox-required-label"> Required?</span>
                                </div>
                            </div>
                            
                            <?php if($variable->variable_type == 1){ ?>
                            <div class="row mt-2 mdn option-header">
                            	<div class="col content-box-reg">
                               		<label>Option Label</label>
                                </div>
                                <div class="col content-box-reg">
                               		<label>Set Limit</label>
                                </div>
                                <div class="col content-box-reg">
                                </div>
                            </div>
                            <?php } ?>
                            
                            <?php 
                            $options->sql = "SELECT * FROM `merchandise_option` WHERE `merchandise_option_merchandise` = ".$merchandise_id. " AND `merchandise_option_variable` = ".$counter_variable. " ORDER BY merchandise_option_no ASC";
                            $options->selectAll();
                            if($options->total > 0){
                                
                                $counter_option = 1;

                                while($option = $options->result->fetch_object()){
                            ?>
                            <div class="row mb-2 each-option" data-option="<?php echo $option->merchandise_option_no; ?>" data-option-at-variable="<?php echo $option->merchandise_option_variable; ?>">
                            	<div class="col-sm content-box-reg mt-1">
                               		<input type="text" placeholder="Option 1" class="option-title" value="<?php echo $option->merchandise_option_title; ?>">
                                </div>
                                <div class="col-sm content-box-reg mt-1">
                               		<input type="text" placeholder="Set Limit" class="option-limit" value="<?php echo $option->merchandise_option_limit; ?>">
                                </div>
                                <div class="col-sm content-box-reg remove-option">
                               		<button class="btn-close m-0 mt-1"><i class="fas fa-times"></i></button>
                                </div>
                            </div>
                            <?php $counter_option++; } $options->result->close(); } ?>
                            
                            <div class="option-end"></div>
                            
                            
                            
                            <button class="btn-reg-close remove-variable"><i class="fas fa-times"></i></button>
                            
                            <?php if($variable->variable_type == 1){ ?>
                            <div class="type-other-value-container">
                               <input type="checkbox" class="ml-1 checkbox-other-value" <?php echo $variable->variable_other_value == 1 ? "checked" : "";?>> 
                               <span class="clickable-checkbox-other-value-label"> Let user type other value?</span><br>
                            </div>
                            <button class="btn-green add-option" style="background:#2F2F2F;">+ Add Option</button>
                            <?php } ?>
                        </div>
                        <?php $counter_variable++; } $variables->result->close(); } ?>

                        
                        
                        
                        <button class="btn-green">+ Add Variables</button>
                        <button class="btn-red"><i class="fas fa-times"></i> Delete Variables</button>
                </div>
                
                <div class="content-box">
                	<p>Event Added</p>
                    <div class="row event-category-so-far">
                        <?php 
                            $crud->sql = "SELECT `events`.`event_id`, `events`.`event_name` FROM `merchandise_designate`, `events` WHERE `merchandise_designate`.`event_id` = `events`.`event_id` AND `merchandise_designate`.`merchandise_id` = ".$merchandise_id;
                            $crud->selectAll();
                            if($crud->total > 0){
                                while($row = $crud->result->fetch_object()){
                        ?>
                        <p class="col-md-auto selected-event" data-id="<?php echo $row->event_id; ?>" data-type="1"><span class="badge badge-light p-3"><?php echo $row->event_name; ?></span></p>
                        <?php } $crud->result->close(); } ?>
                    	
                    </div>
                     <a href="#" class="btn-red merchandise-name-to-modal" data-toggle="modal" data-target="#addToEventModal">Add to Event</a>
                    <!--<a href="#" class="btn-red">Add to Category</a>-->
                </div>

                <div class="content-box">
                	<a href="#" class="btn-red edit-merchandise">Edit Merchandise</a>
                </div>
               
            </div>
                
            <p class="copyright">© Copyright 2018 Sports Events House Sdn. Bhd. (1100784-A)</p>
        
    </div>
    
    <!-- MODAL: EVENT -->
    <div class="modal fade" id="addToEventModal" tabindex="-1" role="dialog" aria-labelledby="addToEventModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addToEventModalLabel">Add <span class="merchandise-name-for-modal"></span> to Event</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <h3><span aria-hidden="true">&times;</span></h3>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="">
                        <div class="input-group search-input-group">
                            <input type="text" class="form-control bg-gray search-event-input"  placeholder="Search" >
                            <span class="input-group-addon">
                                <button type="submit" class="bg-trans border-0 search-event-btn">
                                    <p><i class="fas fa-search"></i></p>
                                </button>  
                            </span>
                        </div>
                    </div>
                    <p class="small total-search-event"></p>
                    <div class="">
                        <div class="modal-inner">
                            <div class="create-tag-box tag-box-event">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-danger col-12" data-dismiss="modal">Save changes</button>
                </div>
            </div>
        </div>
    </div>
    
    
    
    
    
     <?php include_once "inc/inc-js.php"; ?>
     <script type="text/javascript" src="js/js-merchandise-add-edit.js<?php echo '?'.mt_rand(); ?>"></script>
     <script type="text/javascript" src="js/js-local-storage.js<?php echo '?'.mt_rand(); ?>"></script>
</body>
</html>
<?php include_once "inc/app-bottom.php"; ?>