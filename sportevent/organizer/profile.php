<?php 

include_once "inc/app-top.php";
include_once "classes/CRUD.php";
include_once "classes/File.php";

// session check
if(isset($_SESSION["organizer_id"])){
    
    //instantiate
    $file = new File();
    
    //select profile
    $crud = new CRUD($mysqli); 
    $crud->sql = "SELECT * FROM `organizers` WHERE organizer_id = ".$_SESSION["organizer_id"];
    $the_organizer = $crud->selectOne();
    
    //select organizer tags
    $tags = new CRUD($mysqli);
    $selected_tags = array();
    $tags->sql = "SELECT organizer_tag_tag FROM organizer_tag WHERE organizer_tag_organizer = ".$_SESSION["organizer_id"];
    $tags->selectAll();
    if($tags->total > 0){
        while($row = $tags->result->fetch_object()){
            $selected_tags[] = $row->organizer_tag_tag;
        } 
        $tags->result->close(); 
    }
    
}


?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Organizer Profile</title>
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
                        <h2>Edit Profile</h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="main-content">
            <div class="container-custom">

                <input type="hidden" id="organizer-id" class="" value="<?php echo $_SESSION["organizer_id"]; ?>">
                <div class="content-box">
                    <div class="content-box-row">
                        <label>Name</label>
                        <input type="text" placeholder="Name" id="organizer-name" class="validate-input-text" value="<?php echo $the_organizer->organizer_name; ?>">
                    </div>
                    <div class="content-box-row">
                        <label>Email</label>
                        <input type="text" placeholder="Email" id="organizer-email" class="validate-input-text" value="<?php echo $the_organizer->organizer_email; ?>">
                    </div>
                    <div class="content-box-row">
                        <label>Contact Number</label>
                        <input type="text" placeholder="Contact" id="organizer-contact" class="validate-input-text" value="<?php echo $the_organizer->organizer_contact_no; ?>">
                    </div>
                    <div class="content-box-row">
                        <label>Description</label>
                        <input type="text" placeholder="Description" id="organizer-desc" class="validate-input-text" value="<?php echo $the_organizer->organizer_desc; ?>">
                    </div>
                    <div class="content-box-row">
                        <label>Organization Logo &amp; Banner</label>
                        
                        
                        <?php if(isset($the_organizer->organizer_logo)){?>
                        <div class="image-upload-wrap" style="display: none;">
                            <input class="file-upload-input upload-logo" type='file' accept="image/*" />
                            <div class="drag-text">
                              <h5>Upload your Logo here <br> 600x600</h5>
                            </div>
                        </div>
                        <div class="file-upload-content" style="display: inline-block;">
                            <img class="file-upload-image upload-logo-src" src="<?php echo $file->convertImageToBase64($the_organizer->organizer_logo, "png"); ?>" alt="your image" />
                            <div class="image-title-wrap">
                                <button type="button" class="remove-image">Remove <span class="image-title">Uploaded Image</span></button>
                            </div>
                        </div>
                        <?php } else { ?>
                        
                        <div class="image-upload-wrap">
                            <input class="file-upload-input upload-logo" type="file" accept="image/*">
                            <div class="drag-text">
                              <h5>Upload your Logo here <br> 600x600</h5>
                            </div>
                        </div>
                        <div class="file-upload-content">
                            <img class="file-upload-image upload-logo-src" src="#" alt="your image">
                            <div class="image-title-wrap">
                                <button type="button" class="remove-image">Remove <span class="image-title">Uploaded Image</span></button>
                            </div>
                        </div>
                        <?php }  ?>
                        
                        
                        <?php if(isset($the_organizer->organizer_banner)){?>
                        <div class="image-upload-wrap" style="display: none;">
                            <input class="file-upload-input upload-banner" type='file' accept="image/*" />
                            <div class="drag-text">
                              <h5>Upload your banner here <br> 1200x600</h5>
                            </div>
                        </div>
                        <div class="file-upload-content" style="display: inline-block;">
                            <img class="file-upload-image upload-banner-src" src="<?php echo $file->convertImageToBase64($the_organizer->organizer_banner, "png"); ?>" alt="your image" />
                            <div class="image-title-wrap">
                                <button type="button" class="remove-image">Remove <span class="image-title">Uploaded Image</span></button>
                            </div>
                        </div>
                        <?php } else { ?>
                        
                        <div class="image-upload-wrap">
                            <input class="file-upload-input upload-banner" type="file" accept="image/*">
                            <div class="drag-text">
                              <h5>Upload your banner here <br> 1200x600</h5>
                            </div>
                        </div>
                        <div class="file-upload-content">
                            <img class="file-upload-image upload-banner-src" src="#" alt="your image">
                            <div class="image-title-wrap">
                                <button type="button" class="remove-image">Remove <span class="image-title">Uploaded Image</span></button>
                            </div>
                        </div>
                        <?php }  ?>
                        
                    </div>
                    <div class="content-box-row">
                        <label>Facebook Link</label>
                        <input type="text" placeholder="Facebook Link" id="organizer-fb" class="" value="<?php echo $the_organizer->organizer_facebook; ?>">
                    </div>
                    <div class="content-box-row">
                        <label>Instagram Link</label>
                        <input type="text" placeholder="Instagram Link" id="organizer-ig" class="" value="<?php echo $the_organizer->organizer_instagram; ?>">
                    </div>
                    <div class="content-box-row">
                        <label>Twitter Link</label>
                        <input type="text" placeholder="Twitter Link" id="organizer-twitter" class="" value="<?php echo $the_organizer->organizer_twitter; ?>">
                    </div>
                    <div class="content-box-row">
                        <label>Youtube Link</label>
                        <input type="text" placeholder="Yotube Link" id="organizer-youtube" class="" value="<?php echo $the_organizer->organizer_youtube; ?>">
                    </div>
                    <div class="content-box-row">
                        <label>Website Link</label>
                        <input type="text" placeholder="Website Link" id="organizer-website" class="" value="<?php echo $the_organizer->organizer_website; ?>">
                    </div>
                    <div class="content-box-row">
                    	<label>Tag</label>
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
                    
                </div>
                
                <div class="content-box">
                    <div class="">
                        <!--<button class="btn-dgray save-general-information">Save</button>-->
                        <!--<a href="" class="btn-gray">Back</a>-->
                        <a href="#" class="btn-red float-right save-profile">Save</a>
                        <a href="../organizer-profile.php?organizer_id=<?php echo $_SESSION["organizer_id"]; ?>" class="btn-green ">Preview</a>
                    </div>
                </div>


                

                
                
                <p class="copyright">© Copyright 2018 Sports Events House Sdn. Bhd. (1100784-A)</p>

            </div>
        </div>
    </div>

</div>


<?php include_once "inc/inc-js.php"; ?>
<script type="text/javascript" src="js/organizer-app.js<?php echo '?'.mt_rand(); ?>"></script>
<script type="text/javascript" src="js/organizer-profile.js<?php echo '?'.mt_rand(); ?>"></script>

</body>
</html>
<?php include_once "inc/app-bottom.php"; ?>