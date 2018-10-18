<?php

include "inc/app-top.php";
include_once "../organizer/classes/CRUD.php";
include_once "../organizer/classes/File.php";

$crud = new CRUD($mysqli);
$file = new File();

$sql_tag = "SELECT * FROM tags";
$query_tag = $mysqli->query($sql_tag);
for($tag = 0; $query_tag_arr = $query_tag->fetch_assoc(); $tag++) {
  $tag_id[$tag] = $query_tag_arr["tag_id"];
  $tag_title[$tag] = $query_tag_arr["tag_title"];
}

?>


<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Add Organizer</title>
<?php include_once "inc/inc-css.php"; ?>
<link rel="stylesheet" href="../libs/intlTelInput/css/intlTelInput.css">    
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
                        <h2>Add Organizer</h2>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="main-content">
            <div class="container-custom">

                <div class="content-box">
                    <div class="content-box-row">
                        <label>Organizer Name</label><input type="text" name="organizer_name" id="organizer_name" placeholder="Organizer Name" class="validate-input-text">
                    </div>
                    <div class="content-box-row">
                        <label>Email</label><input type="text" name="organizer_email" id="organizer_email" placeholder="Email" class="validate-input-text">
                    </div>
                    <div class="content-box-row">
                        <label>Password</label><input type="password" name="organizer_password" id="organizer_password" placeholder="Password" class="validate-input-text">
                    </div>
                    <div class="content-box-row">
                        <label>Confirm Password</label><input type="password" name="organizer_confirm_password" id="organizer_confirm_password" placeholder="Confirm Password" class="validate-input-text">
                    </div>
                    <div class="content-box-row">
                        <label>Contact Number</label><input type="tel" name="organizer_contact_no" id="organizer_contact_no" placeholder="Contact Number" class="validate-input-text input-tel">
                    </div>
                    <div class="content-box-row">
                        <label>Description</label><textarea type="text" name="organizer_desc" id="organizer_desc" placeholder="Describe your organization" class="validate-input-text"></textarea>
                    </div>
                    
                    
                    <div class="content-box-row">
                        <label>Banner & Logo</label>

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

                        <div class="image-upload-wrap">
                            <input class="file-upload-input upload-logo" type='file' accept="image/*" />
                            <div class="drag-text">
                              <h5>Upload your logo here <br> 600x600</h5>
                            </div>
                        </div>
                        <div class="file-upload-content">
                            <img class="file-upload-image upload-logo-src" src="#" alt="your image" />
                            <div class="image-title-wrap">
                                <button type="button" class="remove-image">Remove <span class="image-title">Uploaded Image</span></button>
                            </div>
                        </div>

                    </div>
                    
                    
                    <div class="content-box-row">
                        <label>Facebook Link</label><input type="text" name="organizer_facebook" id="organizer_facebook" placeholder="Facebook Link">
                    </div>
                    <div class="content-box-row">
                        <label>Youtube Link</label><input type="text" name="organizer_youtube" id="organizer_youtube" placeholder="Youtube Link">
                    </div>
                    <div class="content-box-row">
                        <label>Twitter Link</label><input type="text" name="organizer_twitter" id="organizer_twitter" placeholder="Twitter Link">
                    </div>
                    <div class="content-box-row">
                        <label>Instagram Link</label><input type="text" name="organizer_instagram" id="organizer_instagram" placeholder="Instagram Link">
                    </div>
                    <div class="content-box-row">
                        <label>Website Link</label><input type="text" name="organizer_website" id="organizer_website" placeholder="Website Link">
                    </div>
                    <div class="content-box-row">
                        <label>Tag</label>
                        <div class="create-tag-field">
                            <div class="create-tag-box">
                                <?php for($j = 0; $j < $tag; $j++) { ?>
                                <input id="create-tag-<?php echo $tag_id[$j]; ?>" type="checkbox" name="event_tag" class="event-tag validate-checkbox-tag" value="<?php echo $tag_id[$j]; ?>">
                                <label for="create-tag-<?php echo $tag_id[$j]; ?>"><?php echo $tag_title[$j]; ?></label>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="content-box">
                	<a href="#" class="btn-red add-organizer">Save</a>
                </div>
               
            </div>
                
            <p class="copyright">© Copyright 2018 Sports Events House Sdn. Bhd. (1100784-A)</p>
        
</div>

</div>
    
 <script src="../libs/intlTelInput/js/intlTelInput.js"></script>   
    
<?php include_once "inc/inc-js.php"; ?>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>  

<script>
  var input = document.querySelector("#organizer_contact_no");
  window.intlTelInput(input, {
      // allowDropdown: false,
      // autoHideDialCode: false,
      // autoPlaceholder: "off",
      // dropdownContainer: document.body,
      // excludeCountries: ["us"],
      // formatOnDisplay: false,
      // geoIpLookup: function(callback) {
      //   $.get("http://ipinfo.io", function() {}, "jsonp").always(function(resp) {
      //     var countryCode = (resp && resp.country) ? resp.country : "";
      //     callback(countryCode);
      //   });
      // },
      // hiddenInput: "full_number",
      // initialCountry: "auto",
      // localizedCountries: { 'de': 'Deutschland' },
      // nationalMode: true,
      // onlyCountries: ['us', 'gb', 'ch', 'ca', 'do'],
      // placeholderNumberType: "MOBILE",
       preferredCountries: ['my'],
      // separateDialCode: true,
      nationalMode: false,
      autoHideDialCode: true,
      utilsScript: "../libs/intlTelInput/js/utils.js",
    });
</script>         
    
<script>
    
$(document).ready(function() {
    
    //general information
    $(".add-organizer").click(addOrganizer);
    
    //banner & thumbnail
    $(".upload-banner").on("change", showPreviewBannerThumbnail);
    $(".upload-logo").on("change", showPreviewBannerThumbnail);
    $(".remove-image").on("click", removeTempBannerThumbnail);
    
    //input error removal
    $('body').on('keyup', '.validate-input-text', removeErrorInputText);
    $('body').on('click', '.event-tag', removeErrorCheckBoxes);
    $('body').on('change', '.upload-banner', removeErrorBannerLogo);
    $('body').on('change', '.upload-logo', removeErrorBannerLogo);   
    
    
    <?php if(isset($_GET["msg"]) && intval($_GET["msg"]) == 1) {?>
	swal("Success", "Organizer added successfully.", "success");
	<?php } ?>
    
    window.history.replaceState(null, null, window.location.pathname);
    
});  

function removeErrorInputText(){
    ifKeyUpOnInputText($(this));
}


function removeErrorCheckBoxes(){
    
    var createTagField = $("body").find(".create-tag-field");
    var checkboxesTag = $("body").find(".validate-checkbox-tag");
    var checkboxesTagChecked = $("body").find(".validate-checkbox-tag:checkbox:checked");
    if(checkboxesTag.length > 0){
        if(checkboxesTagChecked.length > 0){
            if(createTagField.length > 0){
                var errorMsg = createTagField.next(); 
                if(errorMsg.length > 0){
                    errorMsg.remove();
                }
            }
        }
    }
}
    
    
function checkLength(val){
    
    var status;
    
    if(val.length > 0){
        status = true;
    } else {
        status = false;
    }
    
    return status;
}    
    
    
function ifKeyUpOnInputText(element){
    
    if(element.val().length > 0){
        var contentBoxRow = element.parent();
        contentBoxRow.find(".input-has-error").remove();
        
        //remove red border
        $(element).removeAttr("style");
    }
}    
    
function readURL(input) {
    if (input.files && input.files[0]) {

        var reader = new FileReader();

        reader.onload = function(e) {
              $('.image-upload-wrap').hide();

              $('.file-upload-image').attr('src', e.target.result);
              $('.file-upload-content').show();

              $('.image-title').html(input.files[0].name);
        };

        reader.readAsDataURL(input.files[0]);

    } else {
        removeUpload();
    }
}

function removeUpload() {
    $('.file-upload-input').replaceWith($('.file-upload-input').clone());
    $('.file-upload-content').hide();
    $('.image-upload-wrap').show();
}


$('.image-upload-wrap').bind('dragover', function () {
    $('.image-upload-wrap').addClass('image-dropping');
});
$('.image-upload-wrap').bind('dragleave', function () {
    $('.image-upload-wrap').removeClass('image-dropping');
});


function grabAllCheckedEventTag(){
    
    var tags = [];
    $('.event-tag:checkbox:checked').each(function () {
       
        tags.push($(this).val());
       
    });
    
    return tags;
}    
    
    
function getImageInformation(className){
    
    var imageSrc = $(className).attr("src");
    
    return imageSrc;
    
}  


function removeErrorBannerLogo(){
    
    var contentBoxRow = $(this).parent().parent();
    var errorMsg = contentBoxRow.find(".input-has-error");
    errorMsg.remove();
    
}  

    
    
function validateOrganizerInformation(){
    
    $(".input-has-error").remove();
    
    //collect passed OR failed
    var validateAll = [];
    
    //check text input if empty
    var textInput = $("body").find(".validate-input-text");
    if(textInput.length > 0){
        textInput.each(function(e){
            var lengthStatus = checkLength($(this).val());
            var status = textErrorMessage($(this).parent(), lengthStatus, "This field is required.", true);
            
            //add red border
            if(!lengthStatus){
                $(this).attr("style", "border: 1px solid red !important");
            }
            
            validateAll.push(status);
        });
    }
    
    //check checkboxes if not checked
    var checkboxesTag = $("body").find(".validate-checkbox-tag");
    var checkboxesTagChecked = $("body").find(".validate-checkbox-tag:checkbox:checked");
    if(checkboxesTag.length > 0){
        
        if(checkboxesTagChecked.length < 1){
            var status = textErrorMessage($("body").find(".create-tag-field").parent(), false, "Please select at least one tag.", true);
        } else {
            var status = "passed";
        }
        validateAll.push(status);
    }
    
    
    //check banner & logo
    var banner = $("body").find(".upload-banner-src");
    var bannerSrc = banner.attr("src");
    if(banner.length > 0){
        if(bannerSrc.length < 1){
            var contentBoxRow = banner.parent().parent();
            var status = textErrorMessage(contentBoxRow, false, "Please upload a banner image.", true);
        } else {
            var status = "passed";
        }
        validateAll.push(status);
    }
    var logo = $("body").find(".upload-logo-src");
    var logoSrc = logo.attr("src");
    if(logo.length > 0){
        if(logoSrc.length < 1){
            var contentBoxRow = logo.parent().parent();
            var status = textErrorMessage(contentBoxRow, false, "Please upload a logo image.", true);
        } else {
            var status = "passed";
        }
        validateAll.push(status);
    }
    
    //console.log(validateAll);
    
    //final validation process
    var finalValidationStatus = validateAll.includes("failed"); //if has has "failed" in the array, it will return true
    
    return finalValidationStatus;
    
}
    
    
function textErrorMessage(element, status, msg, padding){
    
    if(!status){
        
        if(padding){
            var html = `<p  class="input-has-error" style="font-size:12px; color:red; padding-left:35%; margin-top: 0; ">${msg}</p>`;
        } else {
            var html = `<p  class="input-has-error" style="font-size:12px; color:red; margin-top: 0; ">${msg}</p>`;
        }
        
        
        $(element).append(html);
        var status = "failed";
    } else {
        var status = "passed";
    }
    
    return status;
    
}    
    
    
function swalCustomMessage(type, title, text){
    
    swal({
      type: type,
      title: title,
      text: text
    });
}    
    

function addOrganizer(e){
    
    e.preventDefault();
    
    var gotError = validateOrganizerInformation(); //if true, got incomplete input
    
    if(!gotError){
        
        var organizer_name = $("#organizer_name").val();
        var organizer_email = $("#organizer_email").val();
        var organizer_contact_no = $("#organizer_contact_no").val();
        var organizer_desc = $("#organizer_desc").val();
        var organizer_facebook = $("#organizer_facebook").val();
        var organizer_youtube = $("#organizer_youtube").val();
        var organizer_twitter = $("#organizer_twitter").val();
        var organizer_instagram = $("#organizer_instagram").val();
        var organizer_website = $("#organizer_website").val();
        
        var organizer_password = $("#organizer_password").val();

        var organizer_tags = JSON.stringify(grabAllCheckedEventTag());
        var organizer_banner = getImageInformation(".upload-banner-src");
        var organizer_logo = getImageInformation(".upload-logo-src");

        $.ajax({
            type: "POST",
            url: "submit-organizer-add.php",
            data: {
                organizer_name:organizer_name,
                organizer_email:organizer_email,
                organizer_password:organizer_password,
                organizer_contact_no:organizer_contact_no,
                organizer_desc:organizer_desc,
                organizer_facebook:organizer_facebook,
                organizer_youtube:organizer_youtube,
                organizer_twitter:organizer_twitter,
                organizer_instagram:organizer_instagram,
                organizer_website:organizer_website,
                organizer_tags:organizer_tags,
                organizer_banner:organizer_banner,
                organizer_logo:organizer_logo             
            },
            dataType:'JSON', 
            success: function(result){

                if(result.status == "Success"){
                    
                    $(location).attr('href', 'http://x-cow.com/sportevent/admin/organizer-add.php?msg=1');
                }
            } 
        });
        
    } else {
        swalCustomMessage("error", "Error!", "Please check the form again.");
    }
}
    
    

function showPreviewBannerThumbnail(){
    
    var $input = $(this);
    var inputFiles = this.files;
    if(inputFiles == undefined || inputFiles.length == 0) return;
    var inputFile = inputFiles[0];

    var reader = new FileReader();
    reader.onload = function(event) {

        //console.log(inputFiles[0].name);
        //console.log(event.target.result);

        $input.parent().hide();
        $input.parent().next().css("display", "inline-block");
        $input.parent().next().find(".file-upload-image").attr("src", event.target.result);
        $input.parent().next().find(".image-title").text(inputFiles[0].name);


    };
    reader.onerror = function(event) {
        alert("I AM ERROR: " + event.target.error.code);
    };
    reader.readAsDataURL(inputFile);
}

function removeTempBannerThumbnail(){
    
    var fileUploadContent = $(this).parent().parent();
    var imageUploadWrap = $(this).parent().parent().prev();
    
    fileUploadContent.find(".file-upload-image").attr("src", "");
    fileUploadContent.css("display", "none");
    imageUploadWrap.css("display", "inline-block");
}    
    
    
</script>    
    
    <style>

    .error {
        color: red;
        padding-left: 5%;
        font-size: 14px;
    }    
    
    .new-ic-prefix {
        width: 27% !important;
        display: inline-block;
    }
    .new-ic-middle {
        width: 12.5% !important;
        display: inline-block;
    }
    .new-ic-suffix {
        width: 22% !important;
        display: inline-block;
    }
    
    .ic-form-hyphen {
        display: inline-block;
    }
    
    .iti-flag {
        background-image: url("../libs/intlTelInput/img/flags.png");
        margin-left: 15px !important;
    }
 
    @media (-webkit-min-device-pixel-ratio: 2), (min-resolution: 192dpi) {
      .iti-flag {background-image: url("../libs/intlTelInput/img/flags@2x.png");}
    }
    
    .intl-tel-input {
        padding-top: 15px;
        display: inline-block !important;
    }
    
    .flag-container {
        padding-top: inherit !important;
    }
    
    .input-tel {
        text-indent: 50px;
    }
    
    .intl-tel-input {
        width: 60%;
        padding-top: 0px;
    }
    
    .selected-flag {
        width: 80px !important;
        height: 40px !important;
    }
    
    .flag-box {
        width: 70px !important;
    }
    
</style>    
    
</body>
</html>