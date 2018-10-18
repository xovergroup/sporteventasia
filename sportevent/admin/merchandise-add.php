<?php 

include_once "inc/app-top.php"; 
include_once "../organizer/classes/CRUD.php"; 


$crud = new CRUD($mysqli);

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Add Merchandise</title>
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
                        <h2>Add Merchandise</h2>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="main-content">
            <div class="container-custom">

                <div class="content-box">
                	<div class="content-box-row">
                        <label>Merchandise Image</label>
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
                    </div>
                    <div class="content-box-row">
                        <label>Merchandise Name</label><input type="text" placeholder="" class="merchandise-name">
                    </div>
                    <div class="content-box-row">
                        <label>Merchandise Price</label><input type="text" placeholder="" class="merchandise-price">
                    </div>
                    <div class="content-box-row">
                        <label>Merchandise Description</label><textarea type="text" placeholder="" class="merchandise-description"></textarea>
                    </div>
                    
                    
                    
                    
                    <p class="text-danger">Merchandise Variables</p>
                    
                    	<div class="content-box-gray position-relative each-variable" data-variable="1" data-required="0" data-type-other-value="0">
                            <div class="row">
                            	<div class="col-sm align-center content-box-reg">
                               		<label>Label Name</label><br><input type="text" placeholder="Label Name" class="variable-name">
                                </div>
                                <div class="col-sm align-center content-box-reg">
                               		<label>Input Type</label><br>
                                    <select class="variable-select">
                                        <option value="1">Dropdown</option>
                                        <option value="2">Single Line</option>
                                    </select>
                                </div>
                                <div class="col-sm align-center content-box-reg">
                               		<label>Remark</label><br><input type="text" placeholder="Remark" class="variable-remark">
                                </div>
                                <div class="col-sm align-center content-box-reg">
                                	<label></label><br>
                                    <input type="checkbox" class="mt20 checkbox-required">
                                    <span class="clickable-checkbox-required-label"> Required?</span>
                                </div>
                            </div>
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
                            <div class="row mb-2 each-option" data-option="1" data-option-at-variable="1">
                            	<div class="col-sm content-box-reg mt-1">
                               		<input type="text" placeholder="Option 1" class="option-title">
                                </div>
                                <div class="col-sm content-box-reg mt-1">
                               		<input type="text" placeholder="Set Limit" class="option-limit">
                                </div>
                                <div class="col-sm content-box-reg remove-option">
                               		<button class="btn-close m-0 mt-1"><i class="fas fa-times"></i></button>
                                </div>
                            </div>
                            <div class="option-end"></div>
                            
                            
                            
                            <button class="btn-reg-close remove-variable"><i class="fas fa-times"></i></button>
                            <div class="type-other-value-container">
                               <input type="checkbox" class="ml-1 checkbox-other-value"> 
                               <span class="clickable-checkbox-other-value-label"> Let user type other value?</span><br>
                            </div>
                            <button class="btn-green add-option" style="background:#2F2F2F;">+ Add Option</button>
                        </div>
                        
                        
                        
                        
                        
                        <button class="btn-green add-variable">+ Add Variables</button>
                        <button class="btn-red"><i class="fas fa-times"></i> Delete Variables</button>
                </div>
                
                <div class="content-box">
                	<p>Event Added</p>
                    <div class="row event-category-so-far">
                    </div>
                    <a href="#" class="btn-red merchandise-name-to-modal" data-toggle="modal" data-target="#addToEventModal">Add to Event</a>
                    <!--<a href="#" class="btn-red merchandise-name-to-modal" data-toggle="modal" data-target="#addToCategoryModal">Add to Category</a>-->
                </div>

                <div class="content-box">
                	<a href="#" class="btn-red add-merchandise">Add Merchandise</a>
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
    
    <!-- MODAL: EVENT CATEGORY -->
    <div class="modal fade" id="addToCategoryModal" tabindex="-1" role="dialog" aria-labelledby="addToCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addToCategoryModalLabel">Add <span class="merchandise-name-for-modal"></span> to Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <h3><span aria-hidden="true">&times;</span></h3>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="">
                        <div class="input-group search-input-group">
                            <input type="text" class="form-control bg-gray search-category-input"  placeholder="Search" >
                            <span class="input-group-addon">
                                <button type="submit" class="bg-trans border-0 search-event-btn">
                                    <p><i class="fas fa-search"></i></p>
                                </button>  
                            </span>
                        </div>
                    </div>
                    <p class="small total-search-category"></p>
                    <div class="">
                        <div class="modal-inner">
                            <div class="create-tag-box tag-box-category">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-danger col-12">Save changes</button>
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