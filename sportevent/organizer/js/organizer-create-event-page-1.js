$(document).ready(function() {
    
    
    $(".save-general-information").click(createEvent);
    $(".to-racekit-other").on("click", createEventNextPage);
    
    //sponsor
    $("body").on("change",".upload-sponsor", showPreviewSponsor);
    $(".add-sponsor").on("click", addSponsor);
    $("body").on("click",".upload-sponsor-cancel", cancelSponsor);
    
    
});

function createEvent(e){
    
    e.preventDefault();
    
    var gotError = validateGeneralInformation(); //if true, got incomplete input
    
    if(!gotError){
        
        var check = checkEventId();

        var action = $("#event-action").val();
        var eventId = check.id;
        var eventOrganizer = $("#event-organizer").val();
        var eventName = $("#event-name").val();
        var eventLocation = $("#event-location").val();
        var eventState = $("#event-state").val();
        var eventDateStart = $("#event-date-start").val();
        var eventDateEnd = $("#event-date-end").val();
        var eventTimeStart = $("#event-time-start").val();
        var eventTimeEnd = $("#event-time-end").val();
        var eventDescription = $("#event-description").val();
        var eventUrl = $("#event-url").val();
    
        var event = {
            
            action:action,
            eventId:eventId,
            eventOrganizer:eventOrganizer,
            eventName:eventName,
            eventLocation:eventLocation,
            eventState:eventState,
            eventDateStart:eventDateStart,
            eventDateEnd:eventDateEnd,
            eventTimeStart:eventTimeStart,
            eventTimeEnd:eventTimeEnd,
            eventDescription:eventDescription,
            eventUrl:eventUrl
        }

        var eventTags       = grabAllCheckedEventTag();
        var eventBanner     = getImageInformation(".upload-banner-src");
        var eventThumbnail  = getImageInformation(".upload-thumbnail-src");
        var sponsorImages   = getAttributesFromElementByClass(".sponsor-image", "src");
        var sponsorTypes    = getValuesFromElementByClass(".sponsor-type");
        
        
        createSavingMsg();
    
    
        $.ajax({
            type: "POST",
            url: "submits/submit-create-event-page-1.php",
            data: {
                event:event,
                event_banner:eventBanner,
                event_thumbnail:eventThumbnail,
                tags:eventTags,
                sponsor_images:sponsorImages,
                sponsor_types:sponsorTypes
            },
            dataType:'JSON', 
            success: function(result){

                console.log(result);
                
                removeSavingMsg();

                if(result.status == "Success"){
                    swalCustomMessage("success", "Success!", "Event Data Saved Successfully.");
                    
                    $("#event-action").val('saveEvent');
                    if(result.eventId != null){
                        $("#event-id").val(result.eventId);
                    }
                }
            } 
        });
        
    } else {
        swalCustomMessage("error", "Error!", "Please check the form again.");
    }
}

function createEventNextPage(e){
    
    e.preventDefault();
    
    
    var gotError = validateGeneralInformation(); //if true, got incomplete input
    
    if(!gotError){
        
        var check = checkEventId();
        var action = $("#event-action").val();
        var eventId = check.id;
        var eventOrganizer = $("#event-organizer").val();
        var eventName = $("#event-name").val();
        var eventLocation = $("#event-location").val();
        var eventState = $("#event-state").val();
        var eventDateStart = $("#event-date-start").val();
        var eventDateEnd = $("#event-date-end").val();
        var eventTimeStart = $("#event-time-start").val();
        var eventTimeEnd = $("#event-time-end").val();
        var eventDescription = $("#event-description").val();
        var eventUrl = $("#event-url").val();
    
        var event = {
            
            action:action,
            eventId:eventId,
            eventOrganizer:eventOrganizer,
            eventName:eventName,
            eventLocation:eventLocation,
            eventState:eventState,
            eventDateStart:eventDateStart,
            eventDateEnd:eventDateEnd,
            eventTimeStart:eventTimeStart,
            eventTimeEnd:eventTimeEnd,
            eventDescription:eventDescription,
            eventUrl:eventUrl
        }

        var eventTags       = grabAllCheckedEventTag();
        var eventBanner     = getImageInformation(".upload-banner-src");
        var eventThumbnail  = getImageInformation(".upload-thumbnail-src");
        var sponsorImages   = getAttributesFromElementByClass(".sponsor-image", "src");
        var sponsorTypes    = getValuesFromElementByClass(".sponsor-type");
        
        createSavingMsg();
    
        $.ajax({
            type: "POST",
            url: "submits/submit-create-event-page-1.php",
            data: {
                event:event,
                event_banner:eventBanner,
                event_thumbnail:eventThumbnail,
                tags:eventTags,
                sponsor_images:sponsorImages,
                sponsor_types:sponsorTypes
            },
            dataType:'JSON', 
            success: function(result){

                console.log(result);
                
                removeSavingMsg();

                if(result.status == "Success"){
                    
                    $("#event-id").val(result.eventId);
                    
                    swal({
                        title: 'Success!',
                        text: "Event Data Saved Successfully.",
                        type: 'success'
                    }).then(function () {
                        document.location = 'http://x-cow.com/sportevent/organizer/create-event-page-2.php?event_id='+result.eventId;
                    })

                }
            } 
        });
        
    } else {
        swalCustomMessage("error", "Error!", "Please check the form again.");
    }
    
    
}

function createSavingMsg(){
    
    var html    = `<span class="saving-msg">Saving...</span>`;
    var saveBtn = $("body").find(".save-general-information");
    
    $(html).insertAfter(saveBtn);
    
}

function removeSavingMsg(){
    
    $("body").find(".saving-msg").remove();
}

/* ------------------------------------------ Sponsor ------------------------------------------ */
function addSponsor(e){
    
    e.preventDefault();
    
    html = `
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
            </div>`;
    
    
    $(html).insertBefore(".sponsor-field-end");
    
}

function cancelSponsor(e){
    
    $(this).parent().remove();
    
}

function showPreviewSponsor(){
    
    var $input = $(this);
    var inputFiles = this.files;
    if(inputFiles == undefined || inputFiles.length == 0) return;
    var inputFile = inputFiles[0];

    var reader = new FileReader();
    reader.onload = function(event) {

        //console.log(inputFiles[0].name);
        //console.log(event.target.result);
        
        
        var src = event.target.result;
        var img = `<img src="${src}" class="sponsor-image">`;
        var parent =  $input.parent();
        
        parent.hide();
        $(img).insertAfter(parent);
    };
    reader.onerror = function(event) {
        alert("I AM ERROR: " + event.target.error.code);
    };
    reader.readAsDataURL(inputFile);
}


/* ------------------------------------------ Misc ------------------------------------------ */
function checkEventId(){
    
    var status;
    var event = $("#event-id").val();
    
    if(event.length > 0){
        var check = {status:true, id:event};
    } else {
        var check = {status:false, id:""};
    }
    return check;
}
