/*

TOC:-

Save Profile
Image
SWAL
Validation

*/



$(document).ready(function() {
    
    //save
    $(".save-profile").on("click", saveProfile);
    
    //input error removal
    $('body').on('keyup', '.validate-input-text', removeErrorInputText);
    $('body').on('change', '.upload-banner', removeErrorBannerLogo);
    $('body').on('change', '.upload-logo', removeErrorBannerLogo);
    
    //banner & logo  
    $(".upload-banner").on("change", showPreviewImage);
    $(".upload-logo").on("change", showPreviewImage);
    $(".remove-image").on("click", removeTempImage);
    
    
    
    
    
});

/* ------------------------------------------ Save Profile ------------------------------------------ */

function saveProfile(e){
    
    e.preventDefault();
    
    var gotError = validateGeneralInformation();
    
    if(!gotError){
    
        var action = 'saveProfile';
        var id = $('#organizer-id').val();
        var name = $('#organizer-name').val();
        var email = $('#organizer-email').val();
        var contact = $('#organizer-contact').val();
        var desc = $('#organizer-desc').val();
        var fb = $('#organizer-fb').val();
        var ig = $('#organizer-ig').val();
        var twitter = $('#organizer-twitter').val();
        var youtube = $('#organizer-youtube').val();
        var website = $('#organizer-website').val();

        var organizerTags = JSON.stringify(grabAllCheckedEventTag());

        var organizerBanner = getImageInformation(".upload-banner-src");
        var organizerLogo = getImageInformation(".upload-logo-src");

        

        $.ajax({
            type: "POST",
            url: "submit-via-ajax.php",
            data: {
                action:action,
                organizer_id:id,
                organizer_name:name,
                organizer_email:email,
                organizer_contact_no:contact,
                organizer_desc:desc,
                organizer_facebook:fb,
                organizer_instagram:ig,
                organizer_twitter:twitter,
                organizer_youtube:youtube,
                organizer_website:website,
                organizer_tag_tag:organizerTags,
                organizer_banner:organizerBanner,
                organizer_logo:organizerLogo
            },
            dataType:'JSON', 
            success: function(result){

                console.log(result);
                if(result.status == "Success"){
                    swalCustomMessage("success", "Success!", "Profile Saved Successfully.");
                }
            } 
        });
    
    } else {
        swalCustomMessage("error", "Error!", "Please check the form again.");
    }

}

function grabAllCheckedEventTag(){
    
    var tags = [];
    $('.event-tag:checkbox:checked').each(function () {
       
        tags.push($(this).val());
       
    });
    
    return tags;
}

/* ------------------------------------------ Validation ------------------------------------------ */

function validateGeneralInformation(){
    
    
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
                $(this).addClass("warning-border");
            }
            
            validateAll.push(status);
        });
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
    
    //final validation process
    var finalValidationStatus = validateAll.includes("failed"); //if has has "failed" in the array, it will return true
    
    return finalValidationStatus;
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

function removeErrorInputText(){
    ifKeyUpOnInputText($(this));
}

function ifKeyUpOnInputText(element){
    
    if(element.val().length > 0){
        var contentBoxRow = element.parent();
        contentBoxRow.find(".input-has-error").remove();
        
        //remove red border
        $(element).removeClass("warning-border");

    }
}

function removeErrorBannerLogo(){
    
    var contentBoxRow = $(this).parent().parent();
    var errorMsg = contentBoxRow.find(".input-has-error");
    errorMsg.remove();
    
}



/* ------------------------------------------ Image ------------------------------------------ */

function showPreviewImage(){
    
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

function removeTempImage(){
    
    var fileUploadContent = $(this).parent().parent();
    var imageUploadWrap = $(this).parent().parent().prev();
    
    fileUploadContent.find(".file-upload-image").attr("src", "");
    fileUploadContent.css("display", "none");
    imageUploadWrap.css("display", "inline-block");
}

function getImageInformation(className){
    
    var imageSrc = $(className).attr("src");
    
    return imageSrc;
    
}

/* ------------------------------------------ SWAL ------------------------------------------ */

function swalCustomMessage(type, title, text){
    
    swal({
      type: type,
      title: title,
      text: text
    });
}