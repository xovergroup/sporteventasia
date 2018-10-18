$(document).ready(function() {
    
    //view event
    $('body').on('click', '.view-more-event', viewMoreEvent);
    $('body').on('click', '.view-less-event', viewLessEvent);
    
    //view review
    $('body').on('click', '.view-more-review', viewMoreReview);
    $('body').on('click', '.view-less-review', viewLessReview);
    
    
});



/* ------------------------------------------ view review ------------------------------------------ */
function viewLessReview(e){
    
    e.preventDefault();
    
    var action = 'viewLessReview';
    var organizerId = parseInt($('.the-organizer').attr('data-organizer'));
    
    $.ajax({
        type: "POST",
        url: "submit-via-ajax.php",
        data: {
            action:action,
            organizerId:organizerId
        },
        dataType:'JSON', 
        success: function(result){

            //console.log(result);
            
            if(result.status == "Success"){
                
                //remove all reviews
                $(document).find('.each-review').remove();
                
                var viewLessReviewBtn = $(document).find('.view-less-review');
                $(result.html).insertBefore(viewLessReviewBtn).hide().fadeIn("slow");
                
                //generate star
                processStar();
                
                //change view more button to view less
                viewLessReviewBtn.addClass('view-more-review');
                viewLessReviewBtn.find('button').text('+ View More');
                viewLessReviewBtn.removeClass('view-less-review');
            }
        } 
    });
    
}

function viewMoreReview(e){
    
    e.preventDefault();
    
    var action = 'viewMoreReview';
    var organizerId = parseInt($('.the-organizer').attr('data-organizer'));
    
    $.ajax({
        type: "POST",
        url: "submit-via-ajax.php",
        data: {
            action:action,
            organizerId:organizerId
        },
        dataType:'JSON', 
        success: function(result){

            //console.log(result);
            
            if(result.status == "Success"){
                
                //remove all reviews
                $(document).find('.each-review').remove();
                
                var viewMoreReviewBtn = $(document).find('.view-more-review');
                $(result.html).insertBefore(viewMoreReviewBtn).hide().fadeIn("slow");
                
                //generate star
                processStar();
                
                //change view more button to view less
                viewMoreReviewBtn.addClass('view-less-review');
                viewMoreReviewBtn.find('button').text('- View Less');
                viewMoreReviewBtn.removeClass('view-more-review');
            }
        } 
    });
    
}

/* ------------------------------------------ Rate/Star ------------------------------------------ */
function processStar(){
    
    var findStar = $(document).find(".star-rating");
    if(findStar.length > 0){
        
        
        findStar.each(function(i, obj){
            
            var starElement = $(this);
            var rate =  $(this).attr("data-rate");
            var generatedStar = generateStar(rate);
            
            starElement.empty();
            starElement.append(generatedStar);
            
        });
    }
}

function generateStar(numOfStar){
    
    var html = '';
    for(i = 0; i < numOfStar; i++) {
        html += `<i class="fas fa-star"></i>`;
    }
    
    return html;
}





/* ------------------------------------------ view event ------------------------------------------ */

function viewLessEvent(e){
    
    e.preventDefault();
    
    var action = 'viewLessEvent';
    var organizerId = parseInt($('.event-list-for-organizer').attr('data-organizer'));
    
    $.ajax({
        type: "POST",
        url: "submit-via-ajax.php",
        data: {
            action:action,
            organizerId:organizerId
        },
        dataType:'JSON', 
        success: function(result){

            //console.log(result);
            
            if(result.status == "Success"){
                
                //remove all events
                $(document).find('.each-event').remove();
                
                var heading = $(document).find('.event-list-for-organizer');
                
                $(result.html).insertAfter(heading).hide().fadeIn("slow");
                
                var viewBtn = $(document).find('.view-less-event');
                viewBtn.addClass("view-more-event");
                viewBtn.removeClass("view-less-event");
                viewBtn.find('button').text('View More');
            }
        } 
    });
}


function viewMoreEvent(e){
    
    e.preventDefault();
    
    var action = 'viewMoreEvent';
    var organizerId = parseInt($('.event-list-for-organizer').attr('data-organizer'));
    
    $.ajax({
        type: "POST",
        url: "submit-via-ajax.php",
        data: {
            action:action,
            organizerId:organizerId
        },
        dataType:'JSON', 
        success: function(result){

            //console.log(result);
            
            if(result.status == "Success"){
                
                //remove all events
                $(document).find('.each-event').remove();
                
                var heading = $(document).find('.event-list-for-organizer');
                
                $(result.html).insertAfter(heading).hide().fadeIn("slow");
                
                var viewBtn = $(document).find('.view-more-event');
                viewBtn.addClass("view-less-event");
                viewBtn.removeClass("view-more-event");
                viewBtn.find('button').text('View Less');
            }
        } 
    });
    
}




