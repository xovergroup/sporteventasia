$(document).ready(function() {
    
    //general information
    $("#event-one-day").on("change", eventIsOneDay);
    $("#event-date-start").on("click", eventOnlyOneDayChangedDayStart);
    $("#event-date-start").on("change", eventOnlyOneDayChangedDayStart);
    $("#event-date-end").on("click", eventOnlyOneDayChangedDayEnd);
    $("#event-date-end").on("change", eventOnlyOneDayChangedDayEnd);
    $(".save-racekit-otherinfo").on("click", saveRaceKitOtherInfo);
    
    //banner & thumbnail
    $(".upload-banner").on("change", showPreviewBannerThumbnail);
    $(".upload-thumbnail").on("change", showPreviewBannerThumbnail);
    $(".remove-image").on("click", removeTempBannerThumbnail);

    
    
    //input error removal
    $('body').on('keyup', '.validate-input-text', removeErrorInputText);
    $('body').on('keyup', '.validate-input-text-category', removeErrorInputText);
    $('body').on('keyup', '.validate-input-text-option', removeErrorInputText);
    $('body').on('click', '.event-tag', removeErrorCheckBoxes);
    $('body').on('change', '.upload-banner', removeErrorBannerThumbnail);
    $('body').on('change', '.upload-thumbnail', removeErrorBannerThumbnail);
    $('body').on('change', '.upload-sponsor', removeErrorSponsorImage);
    $('body').on('keyup', '.sponsor-type', removeErrorSponsorType);
    $('body').on('click', '.validate-date-picker-start', removeErrorDatePicker);
    $('body').on('click', '.validate-date-picker-end', removeErrorDatePicker);
    $('body').on('click', '.validate-time-picker', removeErrorTimePicker);
    
    //quill setting
    if($('body').find('.db-racekit').length > 0 && $('body').find('.db-other-info').length > 0){setQuillContent();}
    
    //go back to racekit & other info
    $('body').on('click', '.ask-if-want-save-event-category', popupAskIfWantSaveEventCategory);
    
    //swal popup
    //note: swal2 does not support more than 2 btns, so have to do like this for now
    $(document).on('click', '.save-goback', saveGoBack);
    $(document).on('click', '.no-save-goback', noSaveGoBack);
    $(document).on('click', '.cancel-go-back', cancelGoBack);
        
    //msg
    checkAction();
    
    //activity
    $(document).on('click', 'body', addActivity);
    $(document).on('keyup', 'body', addActivity);
    
    
   
    
});



/* ------------------------------------------ INPUT ERROR REMOVAL ------------------------------------------ */
function removeErrorTimePicker(){
    
    var contentBox = $(this).parent();
    var errorMsg = contentBox.find(".input-has-error");
    errorMsg.remove();
    
    //remove red border
    contentBox.find(".validate-time-picker").removeAttr("style");
}

function removeErrorDatePicker(){
    
    var contentBox = $(this).parent();
    var errorMsg = contentBox.find(".input-has-error");
    errorMsg.remove();
    
    //remove red border
    $(this).removeAttr("style");
    
    
}

function removeErrorSponsorType(){
    
    var sponsorField = $(this).parent().parent();
    var errorMsg = sponsorField.find(".input-has-error");
    
    errorMsg.remove();
}

function removeErrorSponsorImage(){
    
    var sponsorField = $(this).parent().parent().parent();
    var errorMsg = sponsorField.find(".input-has-error");
    errorMsg.remove();
    
}

function removeErrorBannerThumbnail(){
    
    var contentBoxRow = $(this).parent().parent();
    var errorMsg = contentBoxRow.find(".input-has-error");
    errorMsg.remove();
    
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

function removeErrorInputText(){
    ifKeyUpOnInputText($(this));
}

function ifKeyUpOnInputText(element){
    
    if(element.val().length > 0){
        var contentBoxRow = element.parent();
        contentBoxRow.find(".input-has-error").remove();
        
        //remove red border
        $(element).removeAttr("style");
    }
}

/* ------------------------------------------ VALIDATION: Event General Information ------------------------------------------ */
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
    
    //check if event date is empty (both start & end)
    var datePicker = $("body").find(".validate-date-picker");
    if(datePicker.length > 0){
        datePicker.each(function(e){
            var lengthStatus = checkLength($(this).val());
            var status = textErrorMessage($(this).parent(), lengthStatus, "This field is required.", true);
            
            //add red border
            if(!lengthStatus){
                $(this).attr("style", "border: 1px solid red !important");
            }
            
            validateAll.push(status);
        });
    }
    
    //compare Event start time & end time
    var startDate = $("#event-date-start").val();
    var endDate = $("#event-date-end").val();
    var checkBothDate = checkStartEndDate(startDate, endDate);
    if(!checkBothDate){
        datePicker.each(function(e){
            var status = textErrorMessage($(this).parent(), false, "Submitted dates are invalid.", true);
            
            //add red border
            $(this).attr("style", "border: 1px solid red !important");
            
            validateAll.push(status);
        });
    } else {
        datePicker.each(function(e){
            var status = "passed";
            
            validateAll.push(status);
        });
    }
    
    //check event time if empty
    var timePickerRow = $("body").find(".time-picker-row");
    var timePicker = $("body").find(".validate-time-picker");
    if(timePicker.length > 0){
        var timePickerArray = [];
        timePicker.each(function(e){
            var lengthStatus = checkLength($(this).val());
            timePickerArray.push(lengthStatus);
            
            //add red border
            if(!lengthStatus){
                $(this).attr("style", "border: 1px solid red !important");
            }
        });
        var timePickerStatuses = timePickerArray.includes(false); //if has has false in the array, it will return true
        if(timePickerStatuses){ 
            var status = textErrorMessage(timePickerRow, false, "These two fields are both required.", true);
            
            validateAll.push(status);
        }
    }
    
    //compare start time and end time
    var startTime= $("#event-time-start").val();
    var endTime = $("#event-time-end").val();
    var checkBothTime = checkStartEndTime(startTime, endTime);
    if(!checkBothTime){
        var status = textErrorMessage(timePickerRow, false, "Submitted times are invalid.", true);
        validateAll.push(status);
    } else {
        var status = "passed";
        validateAll.push(status);
    }
    
    //check banner & thumbnail
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
    var thumbnail = $("body").find(".upload-thumbnail-src");
    var thumbnailSrc = thumbnail.attr("src");
    if(thumbnail.length > 0){
        if(thumbnailSrc.length < 1){
            var contentBoxRow = thumbnail.parent().parent();
            var status = textErrorMessage(contentBoxRow, false, "Please upload a thumbnail image.", true);
        } else {
            var status = "passed";
        }
        validateAll.push(status);
    }
    
    //check sponsor image & sponsor text
    var sponsorFields = $("body").find(".sponsor-field");
    if(sponsorFields.length > 0){
        sponsorFields.each(function(e){
            var sponsorImageLength = $(this).find(".sponsor-image").length; //the img element doesn't exist if no image was chosen. 
            var sponsorTypeLength = $(this).find(".sponsor-type").val().length;
            
            if(sponsorImageLength < 1 && sponsorTypeLength < 1){
                var status = textErrorMessage($(this).append(), false, "Please upload a sponsor image and input the sponsor type.", false);
            } else if(sponsorImageLength < 1){
                var status = textErrorMessage($(this).append(), false, "Please upload a sponsor image.", false);
            } else if(sponsorTypeLength < 1){
                var status = textErrorMessage($(this).append(), false, "Please upload a sponsor type.", false);
            } else {
                var status = "passed";
            }
            
            validateAll.push(status);
        });
    }
    
    //console.log(validateAll);
    
    //final validation process
    var finalValidationStatus = validateAll.includes("failed"); //if has has "failed" in the array, it will return true
    
    return finalValidationStatus;
    
}

/* ------------------------------------------ VALIDATION: Event Category ------------------------------------------ */
function validateEventCategory(){
    
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
    
    //check if event date is empty (both start & end)
    var datePicker = $("body").find(".validate-date-picker");
    if(datePicker.length > 0){
        datePicker.each(function(e){
            var lengthStatus = checkLength($(this).val());
            var status = textErrorMessage($(this).parent(), lengthStatus, "This field is required.", true);
            
            //add red border
            if(!lengthStatus){
                $(this).attr("style", "border: 1px solid red !important");
            } else {
                //remove red border
                $(this).removeAttr("style");
            }
            
            validateAll.push(status);
            
        });
    }
    
    //validate register start & end date
    var startDates = $(".validate-date-picker-start");
    startDates.each(function(e){
        
        var startDate = $(this).val(); 
        var endDate = $(this).parent().next().find(".validate-date-picker-end").val(); 
        var checkBothDate = checkStartEndDate(startDate, endDate);
        if(!checkBothDate){
            var status = textErrorMessage($(this).parent(), false, "Start date cannot be greater than the End date.", true);
            
            //add red border
            $(this).attr("style", "border: 1px solid red !important");
            
            validateAll.push(status);
        }else {
            var status = "passed";
            validateAll.push(status);
        }
    });
    
    //check text input if empty
    var textInputCategory = $("body").find(".validate-input-text-category");
    if(textInputCategory.length > 0){
        textInputCategory.each(function(e){
            var lengthStatus = checkLength($(this).val());
            var status = textErrorMessage($(this).parent(), lengthStatus, "This field is required.", false);
            
            //add red border
            if(!lengthStatus){
                $(this).attr("style", "border: 1px solid red !important");
            }
            validateAll.push(status);
            
        });
    }
    var textInputOption = $("body").find(".validate-input-text-option");
    if(textInputOption.length > 0){
        textInputOption.each(function(e){
            var lengthStatus = checkLength($(this).val());
            var status = textErrorMessage($(this).parent(), lengthStatus, "This field is required.", false);
            
            //add red border
            if(!lengthStatus){
                $(this).attr("style", "border: 1px solid red !important");
            }
            
            validateAll.push(status);
            
        });
    }
    
    //final validation process
    var finalValidationStatus = validateAll.includes("failed"); //if has has "failed" in the array, it will return true
    
    return finalValidationStatus;
    
    
}


/* ------------------------------------------ VALIDATION: Reusable ------------------------------------------ */
function checkStartEndTime(timeStart,timeEnd){

    var jdt1=Date.parse('20 Aug 2000 '+timeStart);
    var jdt2=Date.parse('20 Aug 2000 '+timeEnd);

    if(isNaN(jdt1)){
        alert('invalid start time');
        return false;
    }
    if(isNaN(jdt2)){
        alert('invalid end time');
        return false;
    }
    if(jdt1>jdt2){
        return false;
    }
    else{
        return true;
    }


}

function checkStartEndDate(startDate, endDate){
    
    var status;
    
    if(Date.parse(startDate) > Date.parse(endDate)){
        status = false;
    } else {
        status = true;
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

function checkLength(val){
    
    var status;
    
    if(val.length > 0){
        status = true;
    } else {
        status = false;
    }
    
    return status;
}


/* ------------------------------------------ CATEGORY ------------------------------------------ */


function saveEventCategoryCalled(){
    
    var gotError = validateEventCategory();
    
    if(!gotError){
        $("#form-event-category").submit();
    } else {
        swalCustomMessage("error", "Error!", "Please check the form again.");
    }
}

function countEventCategory(){
    
    var cards = $(document).find(".card");
    
    return cards.length;
    
}

/*function checkEventCategorySavedOrNot(){
    
    var action = 'checkEventCategorySavedOrNot';
    var eventId = parseInt($(".event-id").val());
    
    $.ajax({
        type: "POST",
        url: "submit-via-ajax.php",
        data: {
            action:action,
            event_id:eventId
        },
        dataType:'JSON', 
        success: function(result){

            if(result.status == 'Success'){
                if(result.total == 0){
                    $('.back-to-racekit-other').addClass('ask-if-want-save-event-category');
                }
            }
        } 
    });
}*/

function popupAskIfWantSaveEventCategory(e){
    
    e.preventDefault();
    
    var categories = countEventCategory();
    
    if(categories > 0){
        
        swal({
            title: 'Wait',
            type: 'warning',
            html: "There are unsaved changes. Do you really want to leave the page?" +
                "<br><br>" +
                '<button type="button" role="button" tabindex="0" class="save-goback cswal-confirm-btn">' + 'Save & Go Back' + '</button>' +
                '<button type="button" role="button" tabindex="0" class="no-save-goback cswal-danger-btn">' + 'Don\'t Save & Go Back' + '</button>' +
                '<button type="button" role="button" tabindex="0" class="cancel-go-back cswal-warning-btn">' + 'Cancel' + '</button>',
            showCancelButton: false,
            showConfirmButton: false
        });
    } else {
        var eventId = parseInt(getEventId());
        window.location.href = "create-event-page-2.php?event_id="+eventId;
    }
    
    
}

function saveGoBack(){
    swal.clickConfirm();
    
    var elementEventId = $('.event-id');
    var url = $(".back-to-racekit-other").attr("href");
    var html = `
                <input type="hidden" name="event_save_extra_action" value="goBack">
                <input type="hidden" name="event_save_url" value="${url}">
    `;
    $(html).insertBefore(elementEventId);
    
    saveEventCategoryCalled();
}

function noSaveGoBack(){
    swal.clickConfirm();
    var url = $(".back-to-racekit-other").attr("href");
    window.location.href = url;
}

function cancelGoBack(){
    swal.clickConfirm();
}


/* ------------------------------------------ EVENT ------------------------------------------ */
function saveRaceKitOtherInfo(e){
    
    e.preventDefault();
    
    var action = 'saveRacekitOtherInfo';
    var eventId = $("#event-id").val();
    var raceKit = JSON.stringify(raceKitEditor.getContents())
    var otherInfo = JSON.stringify(otherInfoEditor.getContents())
    
    //console.log(eventorganizer);
    
    $.ajax({
        type: "POST",
        url: "submit-via-ajax.php",
        data: {
            action:action,
            event_id:eventId,
            event_racekit:raceKit,
            event_other_information:otherInfo
        },
        dataType:'JSON', 
        success: function(result){

            console.log(result.status);

            if(result.status == "Success"){
                swalCustomMessage("success", "Success!", "Race Kit & Other Information Saved Successfully.");
            }
        } 
    });
}

function eventIsOneDay(e){
    
    var eventDateStart = $("#event-date-start").val();
    $("#event-date-end").val(eventDateStart);
}

function eventOnlyOneDayChangedDayStart(e){
    
    if($('#event-one-day').is(':checked')) { 
        
        var day = $('#event-date-start').val();
        $("#event-date-end").val(day);
    } 
}

function eventOnlyOneDayChangedDayEnd(e){
    
    if($('#event-one-day').is(':checked')) { 
        
        var day = $('#event-date-end').val();
        $("#event-date-start").val(day);
    } 
}

function grabAllCheckedEventTag(){
    
    var tags = [];
    $('.event-tag:checkbox:checked').each(function () {
       
        tags.push($(this).val());
       
    });
    
    return tags;
}

function getEventId(){
    
    var element = $(document).find(".event-id");
    
    if(element.length > 0){
        var id = element.val();
    } else {
        console.log("No Event ID in page");
        var id = null;
    }
    
    return id;
}

/* ------------------------------------------ Banner & Thumbnail ------------------------------------------ */

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

/* ------------------------------------------ MISC ------------------------------------------ */
function swalCustomMessage(type, title, text){
    
    swal({
      type: type,
      title: title,
      text: text
    });
}

function getValuesFromElementByClass(theClassName){
    
    var emptyArray = [];
    
     $(theClassName).each(function(e) {
        var item =  $(this).val();
        emptyArray.push(item);
    });
    
    return emptyArray;
}

function getAttributesFromElementByClass(theClassName, attribute){
    
    var emptyArray = [];
    
     $(theClassName).each(function(e) {
        var item =  $(this).attr(attribute);
        emptyArray.push(item);
    });
    
    return emptyArray;
}

function getImageInformation(className){
    
    var imageSrc = $(className).attr("src");
    
    return imageSrc;
    
}

function setQuillContent(){
    
    var racekit = JSON.parse($(".db-racekit").val());
    var other = JSON.parse($(".db-other-info").val());
    raceKitEditor.setContents(racekit);
    otherInfoEditor.setContents(other);

}

function checkAction(){
    
    if($(document).find('.action-status').length > 0 && $(document).find('.action-msg').length > 0){
        
        var status = $(document).find('.action-status').val();
        var msg = $(document).find('.action-msg').val();
        var redirect = $(document).find('.action-redirect').val();
        
        
        if(status == 1){
            if(redirect.length == 0){
                swalCustomMessage("success", "Success!", msg);
            } else {
                swal({
                    title: 'Success!',
                    text: msg,
                    type: 'success',
                    showCancelButton: false,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'OK',
                }).then(function () {
                    document.location = redirect;
                });
            }
            
        }
        
    }
}

function addActivity(){
    
    var activityElement = $(document).find(".activity-count");
    
    if(activityElement.length > 0){
        
        var activityValue = parseInt(activityElement.val()) + 1;

        activityElement.val(activityValue);

        if(activityValue > 1){
            $('.back-to-racekit-other').addClass('ask-if-want-save-event-category');
        } 
    }
}

function setTodayDate(){
    
    var dateTodayIsElement = $(document).find(".date-today-is");
    if(dateTodayIsElement.length > 0){
        $(document).find(".set-date-today").val(dateTodayIsElement.val());
    }
}




