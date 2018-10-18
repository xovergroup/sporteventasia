$(document).ready(function() {
    
    
    quillConvert();
    
    
    
});




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