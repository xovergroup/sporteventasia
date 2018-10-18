$(document).ready(function() {
    
    
    quillConvert();
    
    $('body').on('click', '.go-preview', goToPreviewPage);
    $('body').on('click', '.go-edit', goToEditPage);
    
    
    
});

function goToPreviewPage(e){
    
    e.preventDefault();
    
    var eventId = parseInt($(this).attr('data-event'));
    var url = "http://x-cow.com/sportevent/event-detail.php?event_id="+eventId;
    
    window.open(url, '_blank');
    
}

function goToEditPage(e){

    e.preventDefault();
    
    var eventId = parseInt($(this).attr('data-event'));
    window.location.href = "http://x-cow.com/sportevent/organizer/create-event-page-1.php?event_id="+eventId;
}


function quillGetHTML(inputDelta) {
    
    var tempCont = document.createElement("div");
    (new Quill(tempCont)).setContents(inputDelta);
    return tempCont.getElementsByClassName("ql-editor")[0].innerHTML;
}

function quillConvert(){
    
    if($('body').find('.db-racekit').length > 0){
        
        var dbRaceKit = JSON.parse($('body').find('.db-racekit').val());
        var converted = quillGetHTML(dbRaceKit);
        $(".rc-info").append(converted);
    }
    
    if($('body').find('.db-other-info').length > 0){
        
        var dbOtherInfo = JSON.parse($('body').find('.db-other-info').val());
        var converted = quillGetHTML(dbOtherInfo);
        $(".event-other-info").append(converted);
    }
    
    
    
}