/*

TOC:-

Search
DateTime
Rate/Star
SWAL

*/



$(document).ready(function() {
    
    //search
    $(".search-event").on("click", searchEvent);
    
    
    
});

/* ------------------------------------------ Search ------------------------------------------ */

function searchEvent(e){
    
    e.preventDefault();
    
    var action = 'searchOrganizerEvent';
    var event = parseInt($('.search-event-id').find(":selected").val());
    var star = parseInt($('.search-event-star').find(":selected").val());
    var name = $('.search-event-username').val();
    
    $.ajax({
        type: "POST",
        url: "submit-via-ajax.php",
        data: {
            action:action,
            event:event,
            star:star,
            name:name
            
        },
        dataType:'JSON', 
        success: function(result){

            console.log(result);
            
            var data = result.data;
            
            //remove previous result
            $('.search-result').remove();
            
            //loop result
            var html = '';
            for(i = 0; i < result.total; i++) { 
                
                var star = parseInt(data[i].review_rate);
                var formatStar = star.toFixed(1);
                
                html += `
                <div class="content-box search-result">
                	<div class="content-box-row">
                    	<div class="row">
                        	<div class="col-md-auto">
                            	<img src="../img/Facebook_Color.png">
                            </div>
                            <div class="col-md">
                            	<p><a href="" class="font-weight-bold">${data[i].user_full_name}</a> Reviewed ${data[i].review_rate} star on <a href="" class="text-danger">${data[i].event_name}</a></p>
                                <p class="text-secondary date-time">${data[i].review_created_at} </p>
                            </div>
                        </div>
                        <div class="row">
                            <p class="text-warning align-top col-md-auto">
                                
                            </p> 
                            <p class="align-top col-md-auto p-0 star-rating" data-rate="${star}">${formatStar}</p>
                        </div>
                        <div>
                       	 <p>${data[i].review_desc}</p>
                        </div>
                    </div>
                </div>
                `;
                
            }
            
            //insert result to html
            var resultEnd = $(document).find(".search-result-end");
            $(html).insertBefore(resultEnd);
            
            //process star
            processStar();
            
            //process datetime
            processDateTimeReview();
            
        } 
    });
    
    
   /* console.log(event);
    console.log(star);
    console.log(name);
    */

}

/* ------------------------------------------ DateTime ------------------------------------------ */
function processDateTimeReview(){
    
    var datetimes = $(document).find(".date-time");
    
    
    if(datetimes.length > 0){
        
        datetimes.each(function(i, obj){
            
            var datetime = $(this).text();
            var datetime = customDateTime(datetime);
            
            var format = datetime.year + '-' + datetime.monthNumber + '-' + datetime.date + ' ' + datetime.hourNumber + ':' + datetime.minutesNumber + datetime.clockFormatBig;
            
            $(this).text(format);
            
        });
        
        
    }
    
}

function customDateTime(datetime){
    
    var timestamp = new Date(datetime);
    
    var date = timestamp.getDate();
    var month = timestamp.getMonth() + 1; //0-11
    var year = timestamp.getFullYear();
    var hour = timestamp.getHours();
    var minutes = timestamp.getMinutes();
    
    var monthNameArray =  ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
    var monthNumberArray =  ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'];
    var minutesArray = ['00', '01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31', '32', '33', '34', '35', '36', '37', '38', '39', '40', '41', '42', '43', '44', '45', '46', '47', '48', '49', '50', '51', '52', '53', '54', '55', '56', '57', '58', '59', '60'];
    var hourArray = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'];
    var monthName = monthNameArray[timestamp.getMonth()];
    var monthNumber = monthNumberArray[timestamp.getMonth()];
    var minutesNumber = minutesArray[timestamp.getMinutes()];
    var hourNumber = hourArray[timestamp.getHours()];
    
    
    if(hour > 11){
        var clockFormatBig = 'PM';
        var clockFormatSmall = 'pm';
    } else {
        var clockFormatBig = 'AM';
        var clockFormatSmall = 'am';
    }
    
    var data = {
        
        date:date,
        month:month,
        monthNumber:monthNumber,
        monthName:monthName,
        year:year,
        hour:hour,
        hourNumber:hourNumber,
        minutes:minutes,
        minutesNumber:minutesNumber,
        dataUsed:datetime,
        clockFormatBig:clockFormatBig,
        clockFormatSmall:clockFormatSmall
    }
    
    
    return data;
}





/* ------------------------------------------ Rate/Star ------------------------------------------ */
function processStar(){
    
    var findStar = $(document).find(".star-rating");
    if(findStar.length > 0){
        
        findStar.each(function(i, obj){
            
            var starElement = $(this).prev();
            var rate =  $(this).attr("data-rate");
            var generatedStar = generateStar(rate);
            
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



/* ------------------------------------------ SWAL ------------------------------------------ */

function swalCustomMessage(type, title, text){
    
    swal({
      type: type,
      title: title,
      text: text
    });
}




