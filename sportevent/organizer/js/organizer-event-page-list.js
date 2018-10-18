$(document).ready(function() {
    
    
    $('body').on('click', '.search-event', searchEvent);
    
    
    
});

function searchEvent(e){
    
    e.preventDefault();
    
    var action = 'searchEvent';
    var eventName = $('.event-name').val(); 
    var searchBy = parseInt($('.search-by').find(":selected").val());
    var eventStatus = parseInt($('.event-status').find(":selected").val());
    var eventMonth = parseInt($('.event-month').find(":selected").val());
    var eventState = parseInt($('.event-state').find(":selected").val());
    
    
    $.ajax({
        type: "POST",
        url: "submit-via-ajax.php",
        data: {
            action:action,
            event_name:eventName,
            search_by:searchBy,
            event_status:eventStatus,
            event_month:eventMonth,
            event_state:eventState
        },
        dataType:'JSON', 
        success: function(result){

            console.log(result);


        } 
    });
    
    
}

