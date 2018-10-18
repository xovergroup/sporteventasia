$(document).ready(function() {
    
    $('body').on('click', '.event-register-btn', redirectToRegisterPage);
    
    generateStar();
    
    
});


function redirectToRegisterPage(e){
    
    e.preventDefault();
    
    var eventId = $('.event-name').attr('data-event');
    var url = 'http://x-cow.com/sportevent/event-registration-form-1.php?event_id='+eventId;
    window.location.href = url;
    
}


function generateStar(){
    
    var rateElement = $(document).find('.avg-organizer-review');
    
    if(rateElement.length > 0){
        
        var rate = parseFloat(rateElement.text());
        var rate = Math.floor(rate);
        var html = processStar(rate);
        
        //remove static star
        rateElement.parent().find('.fa-star').remove();
        
        //insert to html
        $(html).insertBefore(rateElement);

    }
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


