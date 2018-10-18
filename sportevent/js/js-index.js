$(document).ready(function() {
    
    //view upcoming events
    $('body').on('click', '.view-more-upcoming', viewMoreUpcomingEvents);
    $('body').on('click', '.view-less-upcoming', viewLessUpcomingEvents);
    
    //search upcoming events
    $('body').on('click', '.search-upcoming-event', searchUpcomingEvents);
    
    //go to event-detail page
    $('body').on('click', '.go-to-event-detail', goToEventDetail);
   
    generateStar();
    
});

function goToEventDetail(e){
    
    e.preventDefault();
    
    var eventId = parseInt($(this).attr('data-event'));
    
    window.location.href = "http://x-cow.com/sportevent/event-detail.php?event_id="+eventId;
}

function generateStar(){
    
    var rates = $(document).find('.avg-organizer-review');
    
    $(rates).each(function(i, obj) {
        
        var rate = parseFloat($(this).text());
        var rate = Math.floor(rate);
        
        var html = processStar(rate);
        
        //remove static star
        $(this).parent().find('.fa-star').remove();
        
        //insert to html
        $(html).insertBefore($(this));
        
        
    });
}

function processStar(rate){
    
    var filledStar = '';
    var emptyStar = '';
    var remaining = 5 - rate;
    
    for(i = 0; i < rate; i++) { 
        filledStar += `<i class="fas fa-star"></i>`;
    }
    
    for(i = 0; i < remaining; i++) { 
        emptyStar += `<i class="far fa-star"></i>`;
    }
    
    var html = filledStar+emptyStar;
    
    return html;
}

function searchUpcomingEvents(e){
    
    e.preventDefault();
    
    var action = 'searchUpcomingEvents';
    var eventState = parseInt($('.event-state').find(":selected").val());
    var eventTag = parseInt($('.event-tag').find(":selected").val());
    
    
    var upcomingEventsParent = $(this).parent().parent().next();
    var container = $(this).parent().parent().parent();
    var viewMoreUpcomingBtn = container.find('.view-more-upcoming');
    var viewLessUpcomingBtn = container.find('.view-less-upcoming');
    
    $.ajax({
        type: "POST",
        url: "submit-via-ajax.php",
        data: {
            action:action,
            event_state:eventState,
            event_tag:eventTag
        },
        dataType:'JSON', 
        success: function(result){

            console.log(result);
            
            if(result.status == "Success"){
                var upcomingEvents = $(document).find('.each-upcoming-event');
                upcomingEvents.remove();
                upcomingEventsParent.append(result.html).hide().fadeIn("slow");
                
                if(viewMoreUpcomingBtn.length > 0){
                    viewMoreUpcomingBtn.remove();
                }
                if(viewLessUpcomingBtn.length > 0){
                    viewLessUpcomingBtn.remove();
                }
                
            }

        } 
    });

}

function viewMoreUpcomingEvents(e){
    
    e.preventDefault();
    
    var action = 'viewMoreUpcomingEvents';
    var viewMoreUpcomingEventsBtn = $(this);
    var viewMoreUpcomingEventsBtnParent = viewMoreUpcomingEventsBtn.parent();
    var upcomingEventsParent = viewMoreUpcomingEventsBtnParent.prev();
    
    $.ajax({
        type: "POST",
        url: "submit-via-ajax.php",
        data: {
            action:action
        },
        dataType:'JSON', 
        success: function(result){

            //console.log(result);

            if(result.status == "Success"){
                var upcomingEvents = $(document).find('.each-upcoming-event');
                upcomingEvents.remove();
                upcomingEventsParent.append(result.html).hide().fadeIn("slow");
                viewMoreUpcomingEventsBtn.text('- View Less');
                viewMoreUpcomingEventsBtn.removeClass('view-more-upcoming');
                viewMoreUpcomingEventsBtn.addClass('view-less-upcoming');
            }

        } 
    });
}

function viewLessUpcomingEvents(e){
    
    e.preventDefault();
    
    var action = 'viewLessUpcomingEvents';
    var viewMoreUpcomingEventsBtn = $(this);
    var viewMoreUpcomingEventsBtnParent = viewMoreUpcomingEventsBtn.parent();
    var upcomingEventsParent = viewMoreUpcomingEventsBtnParent.prev();
    
    $.ajax({
        type: "POST",
        url: "submit-via-ajax.php",
        data: {
            action:action
        },
        dataType:'JSON', 
        success: function(result){

            //console.log(result);

            if(result.status == "Success"){
                var upcomingEvents = $(document).find('.each-upcoming-event');
                upcomingEvents.remove();
                upcomingEventsParent.append(result.html).hide().fadeIn("slow");
                viewMoreUpcomingEventsBtn.text('+ View More');
                viewMoreUpcomingEventsBtn.removeClass('view-less-upcoming');
                viewMoreUpcomingEventsBtn.addClass('view-more-upcoming');
            }

        } 
    });
}


