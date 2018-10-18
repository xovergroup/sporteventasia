$(document).ready(function() {
    
    
    $("body").on("click",".display-merchandise-modal", processModalMerchandise);
    $("body").on("keyup",".search-event-input", modalSearchEventByKeyup);
    $("body").on("click",".event-searched-checkbox", processEventSearchedCheckboxClicked);
    $("body").on("click",".save-event-merchandise", saveEventMerchandise);
    
    //removeFromLocalStorage('checkedIdsEvents');
    //removeFromLocalStorage('checkedLabelsEvents');
    //removeFromLocalStorage('checkedIdsCategories');
    //removeFromLocalStorage('checkedLabelsCategories');
    //removeFromLocalStorage('modalForMerchandise');
    

});

function saveEventMerchandise(){
    
    var merchandiseId   = parseInt($(this).parent().parent().parent().parent().attr('data-modal-merchandise'));
    var container       = findElementByAttr(merchandiseId);
    var eventData       = merchandiseEventData(container);
    
    
    if(eventData.length == 0){
        var action = 'removeMerchandiseFromEvent';
    } else {
        var action = 'addMerchandiseToEvent';
    }
    
    $.ajax({
        type: "POST",
        url: "submits/submit-merchandise.php",
        data: {
            action:action,
            merchandiseId:merchandiseId,
            eventData:eventData
        },
        dataType:'JSON', 
        success: function(result){

            //if(result.status == "Success"){

            //}
        } 
    });
    
}

function processEventSearchedCheckboxClicked(){
    
    
    var checkedElements     = $("body").find(".event-searched-checkbox:checkbox:checked");
    var uncheckedElements   = $("body").find(".event-searched-checkbox:checkbox:not(:checked)");
    
    //get all checked | get all unchecked
    var checked     = getAllCheckedUnchecked(checkedElements);
    var unchecked   = getAllCheckedUnchecked(uncheckedElements);
    
    //get all db selected events
    var merchandiseId   = parseInt($(this).parent().parent().parent().parent().parent().parent().parent().attr('data-modal-merchandise'));
    var container       = findElementByAttr(merchandiseId);
    var eventData       = merchandiseEventData(container);
    
    //prepare show at html
    var AllIds      = processArrayEventIds(eventData, checked, unchecked);
    var AllLabels   = processArrayEventLabels(eventData, checked, unchecked);
    var html        = htmlSelectedEventOfMerchandise(AllIds, AllLabels);
    
    //show at html
    var eventListContainer = container.find('.merchandise-event-list');
    if(eventListContainer.length > 0){
        eventListContainer.find('.each-event').remove();
        eventListContainer.append(html);
    }
}

function htmlSelectedEventOfMerchandise(ids, labels){
    
    var total = ids.length;
    
    
    var html = ``;
    
    if(total > 0){
        for(i = 0; i < total; i++) { 
            html += `<p class="col-md-auto each-event"><span class="badge badge-light p-3 selected-event-for-merchandise" data-event="${ids[i]}">${labels[i]}</span></p>`; 
        }
    }
    return html;
}

function processArrayEventIds(dbChecked, htmlChecked, htmlUnchecked){
    
    var htmlUnchecked   = htmlUnchecked.ids;
    
    if(dbChecked.length != 0){
        var dbChecked = dbChecked.ids;
    } else {
        var dbChecked = [];
    }
    
    if(htmlChecked.length != 0){
        var htmlChecked = htmlChecked.ids;
    } else {
        var htmlChecked = [];
    }
    
    
    
    dbChecked.push(...htmlChecked);
    
    //uniqure the array
    var allData = _.uniq(dbChecked);
    
    //if unchecked is clicked
    allData = _.difference(allData,htmlUnchecked);
    
    return allData;
}

function processArrayEventLabels(dbChecked, htmlChecked, htmlUnchecked){
    
    var htmlUnchecked   = htmlUnchecked.labels;
    
    if(dbChecked.length != 0){
        var dbChecked = dbChecked.labels;
    } else {
        var dbChecked = [];
    }
    
    if(htmlChecked.length != 0){
        var htmlChecked = htmlChecked.labels;
    } else {
        var htmlChecked = [];
    }
    
    dbChecked.push(...htmlChecked);
    
    //uniqure the array
    var allData = _.uniq(dbChecked);
    
    //if unchecked is clicked
    allData = _.difference(allData,htmlUnchecked);
    
    return allData;
}

function getAllCheckedUnchecked(elements){

    var ids     = [];
    var labels  = [];
    
    if(elements.length > 0){
        elements.each(function(i, obj) {
            var id      = parseInt($(this).attr('data-event'));
            var label   = $(this).next().text();
            ids.push(id);
            labels.push(label);
        });
        
        var data =  {
            ids:ids,
            labels:labels
        }
    } else {
        var data = [];
    }
    return data;
}


/* -------------------------- WHEN SEARCHED IN MODAL: SEARCH -------------------------- */

function modalSearchEventByKeyup(e){
    
    e.preventDefault();
    
    var input           = $(this).val();
    var lengthOfInput   = input.length;
    var action          = 'selectEvents';
    
    var merchandiseId   = merchandiseIdFromModal($(this));
    var container       = findElementByAttr(merchandiseId);
    var eventData       = merchandiseEventData(container);
    
    
    if(lengthOfInput > 2){
        
        $.ajax({
            type: "POST",
            url: "submits/submit-merchandise.php",
            data: {
                action:action,
                input:input
            },
            dataType:'JSON', 
            success: function(result){
                
                //console.log(result);

                if(result.status == "Success"){
                    
                    
                    var total       = result.total;
                    var data        = result.data;
                    var eventIds    = eventData.ids;
                    
                    //process html
                    var html    = htmlModalResultSearchEventByKeyup(total, data, eventIds);
                    
                    //show to html
                    var container = $('.tag-box-event');
                    $(container).empty();
                    $(container).append(html);
                    
                    //show total in html
                    var totalResult = totalModalSearchEventByKeyup(total);
                    $('.total-search-event').text(totalResult);
                    

                    
                }
            } 
        });
        
    }
    
}

function htmlModalResultSearchEventByKeyup(total, data, checkedArray){
    
    var html = ``;
    
    for(i = 0; i < total; i++) {
        
        if(jQuery.inArray(parseInt(data[i].event_id), checkedArray) !== -1){
            
            html += `
                <input id="create-tag-${data[i].event_id}" class="event-searched-checkbox" type="checkbox" data-event="${data[i].event_id}" checked>
                <label for="create-tag-${data[i].event_id}" class="event-searched-label">${data[i].event_name}</label>
            `;
            
            
        } else {
            
            html += `
                <input id="create-tag-${data[i].event_id}" class="event-searched-checkbox" type="checkbox" data-event="${data[i].event_id}">
                <label for="create-tag-${data[i].event_id}" class="event-searched-label">${data[i].event_name}</label>
            `;
        }
    }
    return html;
}


/* -------------------------- WHEN SEARCHED IN MODAL: MERCHANDISE DATA -------------------------- */

function findElementByAttr(id){
    
    var container = $('body').find(`[data-merchandise="${id}"]`);
    
    return container;
    
}

function merchandiseEventData(container){
    
    var eventData = grabEventData(container);
    
    return eventData;
    
}

function grabEventData(container){
    
    var events      = container.find('.selected-event-for-merchandise');
    var data        = processEventData(events);
    return data;
    
}

function processEventData(events){
    
    if(events.length > 0){
        
        ids     = [];
        labels  = [];
        
        events.each(function(i, obj) {
            
            var id      = parseInt($(this).attr('data-event'));
            var label   = $(this).text();
            
            ids.push(id);
            labels.push(label);
        });
        
        var data = {
            ids:ids,
            labels:labels
        }
    } else {
        var data = [];
    }
    
    return data;
}

function merchandiseIdFromModal(element){
    
    var merchandiseId = parseInt(element.parent().parent().parent().parent().parent().parent().attr('data-modal-merchandise'));
    
    return merchandiseId;
}

/* -------------------------- WHEN CLICKED AT TO EVENT BUTTON -------------------------- */

function processModalMerchandise(){
    
    
    
    var clickedElement = $(this);
    
    clearModal();
    merchandiseNameToModal(clickedElement);
    merchandiseIdToModal(clickedElement);
    
}

function clearModal(){
    
    var modal = $('body').find('#addToEvent');
    
    modal.find('.search-event-input').val('');
    modal.find('.total-search-event').text('');
    modal.find('.tag-box-event').empty();
    
}


function merchandiseIdToModal(element){
    
    var merchandiseId = element.parent().parent().parent().attr('data-merchandise');
    $('body').find('#addToEvent').attr('data-modal-merchandise', merchandiseId);
    
}

function merchandiseNameToModal(element){
    
    var merchandiseName = element.parent().parent().find('h2').text();
    $('#addToEventLabel').text('Add ' + merchandiseName + ' to Event');
    
}


/* -------------------------- SHOW TOTAL AFTER SEARCHED AT MODAL -------------------------- */
function totalModalSearchEventByKeyup(total){
    
    var result = "";
    if(total == 1){
        result = "1 result";
    } else if(total == 0) {
        result = "0 result";
    } else {
        result = total + " results";
    }
    
    return result;
}



