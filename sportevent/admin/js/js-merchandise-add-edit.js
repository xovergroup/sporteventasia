$(document).ready(function() {
    
    $(".add-merchandise").click(addMerchandise);
    $(".edit-merchandise").click(editMerchandise);
    $(".upload-merchandise").on("change", showPreviewMerchandise);
    $(".remove-image").on("click", removeTempMerchandise);
    $("body").on("click",".add-variable", addVariable);
    $("body").on("click",".remove-variable", removeVariable);
    $("body").on("click",".add-option", addOption);
    $("body").on("click",".remove-option", removeOption);
    $("body").on("change",".variable-select", processVariableType);
    $("body").on("click",".checkbox-required", variableIsRequiredByCheckBoxClick);
    $("body").on("click",".clickable-checkbox-required-label", variableIsRequiredByLabelClick);
    $("body").on("click",".checkbox-other-value", variableOtherValueByCheckBoxClick);
    $("body").on("click",".clickable-checkbox-other-value-label", variableOtherValueByLabelClick);
    $("body").on("click",".merchandise-name-to-modal", merchandiseNameToModal);
    $("body").on("keyup",".search-event-input", modalSearchEventByKeyup);
    $("body").on("click",".event-searched-checkbox", displaySelectedEvent);
    $("body").on("keyup",".search-category-input", modalSearchCategoryByKeyup);
    $("body").on("click",".category-searched-checkbox", displaySelectedCategory);
    
    removeFromLocalStorage('checkedIdsEvents');
    removeFromLocalStorage('checkedLabelsEvents');
    removeFromLocalStorage('checkedIdsCategories');
    removeFromLocalStorage('checkedLabelsCategories');
    
    grabSelectedEvent();

});

/* ---------------------------- Modal: CATEGORY ---------------------------- */
function modalSearchCategoryByKeyup(e){
    
    e.preventDefault();
    
    var input           = $(this).val();
    var lengthOfInput   = input.length;
    var action          = 'selectCategories';
    
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

                if(result.status == "Success"){
                    
                    
                    var total   = result.total;
                    var data    = result.data;
                    
                    //process html
                    var idsLS   = getDataFromLocalStorage('checkedIdsCategories');
                    var html    = htmlModalSearchCategoryByKeyup(total, data, idsLS);
                    
                    //show to html
                    var container = $('.tag-box-category');
                    $(container).empty();
                    $(container).append(html);
                    
                    //show total in html
                    var totalResult = totalModalSearchCategoryByKeyup(total);
                    $('.total-search-category').text(totalResult);
                    
                }
            } 
        });
    }
}

function displaySelectedCategory(){
    
    
    addSelectedCategory();
    
    var idsLS       = getDataFromLocalStorage('checkedIdsCategories');
    var labelsLS    = getDataFromLocalStorage('checkedLabelsCategories');
    
    var container = $('.event-category-so-far');
    if(container.length > 0){
        if(labelsLS.length > 0){
            var html = htmlForDisplaySelectedCategory(labelsLS, idsLS);
            container.find('.selected-category').remove();
            container.append(html);
        } else {
            container.find('.selected-category').remove();
        }
    }
}

function addSelectedCategory(){
    
    var labelsLS            = getDataFromLocalStorage('checkedLabelsCategories');
    var idsLS               = getDataFromLocalStorage('checkedIdsCategories');
    
    var notChosenIds        = [];
    var notChosenLabels     = [];
    var checked             = $("body").find(".category-searched-checkbox:checkbox:checked");
    var notChecked          = $("body").find(".category-searched-checkbox:checkbox:not(:checked)");
    
    //add chosen checbox
    if(checked.length > 0){
        checked.each(function(i, obj) {
            var id      = parseInt($(this).attr('data-category'));
            var label   = $(this).next().text();
            idsLS.push(id);
            labelsLS.push(label);
        });
    }
    
    //grab not chosen checkbox
    if(notChecked.length > 0){
        notChecked.each(function(i, obj) {
            var id      = parseInt($(this).attr('data-category'));
            var label   = $(this).next().text();
            notChosenIds.push(id);
            notChosenLabels.push(label);
        });
    }
    
    //uniqure the array
    idsLS       = _.uniq(idsLS);
    labelsLS    = _.uniq(labelsLS);
    
    //if unchecked is clicked
    idsLS       = _.difference(idsLS,notChosenIds);
    labelsLS    = _.difference(labelsLS,notChosenLabels);
    
    //add to local storage
    addArrayToLocalStorage('checkedIdsCategories', idsLS);
    addArrayToLocalStorage('checkedLabelsCategories', labelsLS);
    
}

function htmlForDisplaySelectedCategory(labels, ids){
    
    var total = labels.length;
    var html = ``;
    for(i = 0; i < total; i++) {
        html += `<p class="col-md-auto selected-category" data-id="${ids[i]}" data-type="2"><span class="badge badge-light p-3">${labels[i]}</span></p>`;
    }
    
    return html;
    
}

function htmlModalSearchCategoryByKeyup(total, data, checkedArray){
    
    var html = ``;
    
    for(i = 0; i < total; i++) {
        
        if(jQuery.inArray(parseInt(data[i].event_category_id), checkedArray) !== -1){
            
            html += `
                <input id="create-tag-${data[i].event_category_id}" class="category-searched-checkbox" type="checkbox" data-category="${data[i].event_category_id}" checked>
                <label for="create-tag-${data[i].event_category_id}" class="category-searched-label">${data[i].event_category_name}</label>
            `;
            
            
        } else {
            
            html += `
                <input id="create-tag-${data[i].event_category_id}" class="category-searched-checkbox" type="checkbox" data-category="${data[i].event_category_id}">
                <label for="create-tag-${data[i].event_category_id}" class="category-searched-label">${data[i].event_category_name}</label>
            `;
        }
    }
    return html;
}

function totalModalSearchCategoryByKeyup(total){
    
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



/* ---------------------------- Modal: EVENT ---------------------------- */
function modalSearchEventByKeyup(e){
    
    e.preventDefault();
    
    var input           = $(this).val();
    var lengthOfInput   = input.length;
    var action          = 'selectEvents';
    
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

                if(result.status == "Success"){
                    
                    
                    var total   = result.total;
                    var data    = result.data;
                    
                    //process html
                    var idsLS   = getDataFromLocalStorage('checkedIdsEvents');
                    var html    = htmlModalSearchEventByKeyup(total, data, idsLS);
                    
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

function displaySelectedEvent(){
    
    addSelectedEvent();
    
    var labelsLS    = getDataFromLocalStorage('checkedLabelsEvents');
    var idsLS       = getDataFromLocalStorage('checkedIdsEvents');
    
    var container = $('.event-category-so-far');
    if(container.length > 0){
        if(labelsLS.length > 0){
            var html = htmlForDisplaySelectedEvent(labelsLS, idsLS);
            container.find('.selected-event').remove();
            container.append(html);
        } else {
            container.find('.selected-event').remove();
        }
    }
}

function addSelectedEvent(){
    
    var labelsLS            = getDataFromLocalStorage('checkedLabelsEvents');
    var idsLS               = getDataFromLocalStorage('checkedIdsEvents');
    
    var notChosenIds        = [];
    var notChosenLabels     = [];
    
    var checked             = $("body").find(".event-searched-checkbox:checkbox:checked");
    var notChecked          = $("body").find(".event-searched-checkbox:checkbox:not(:checked)");
    
    //add chosen checbox
    if(checked.length > 0){
        checked.each(function(i, obj) {
            var id      = parseInt($(this).attr('data-event'));
            var label   = $(this).next().text();
            idsLS.push(id);
            labelsLS.push(label);
        });
    }
    
    //grab not chosen checkbox
    if(notChecked.length > 0){
        notChecked.each(function(i, obj) {
            var id      = parseInt($(this).attr('data-event'));
            var label   = $(this).next().text();
            notChosenIds.push(id);
            notChosenLabels.push(label);
        });
    }
    
    processArrayEvent(idsLS, labelsLS, notChosenIds, notChosenLabels);
    
}

function processArrayEvent(idsLS, labelsLS, notChosenIds, notChosenLabels){
    
    //uniqure the array
    idsLS       = _.uniq(idsLS);
    labelsLS    = _.uniq(labelsLS);
    
    //if unchecked is clicked
    idsLS       = _.difference(idsLS,notChosenIds);
    labelsLS    = _.difference(labelsLS,notChosenLabels);
    
    //add to local storage
    addArrayToLocalStorage('checkedIdsEvents', idsLS);
    addArrayToLocalStorage('checkedLabelsEvents', labelsLS);
    
    //join
    //grabEventCategory(idsLS);
    
}

/*
function grabEventCategory(ids){
    
    var ids     = ids.join();
    var action  = 'grabEventCategory';
    $.ajax({
        type: "POST",
        url: "submits/submit-merchandise.php",
        data: {
            action:action,
            ids:ids
        },
        dataType:'JSON', 
        success: function(result){

            console.log(result);
            
            if(result.status == "Success"){


                var total   = result.total;
                var data    = result.data;
                
                //show to html
                var container = $('.event-category-so-far');
                if(container.length > 0){
                    var html    = htmlEventCategoryAfterSelectingEvent(data);
                    //container.find('.selected-category').remove();
                    container.append(html);
                }
                
                //show total in html
                //var totalResult = totalModalSearchEventByKeyup(total);
                //$('.total-search-event').text(totalResult);
            }
        } 
    });
}
*/

function grabSelectedEvent(){
    
    var ids     = [];
    var labels  = [];
    
    var events = $('.selected-event');
    events.each(function(i, obj) {
        
        var id      = parseInt($(this).attr('data-id'));
        var label   = $(this).text();
        
        ids.push(id);
        labels.push(label);
    });
    
    //add to local storage
    addArrayToLocalStorage('checkedIdsEvents', ids);
    addArrayToLocalStorage('checkedLabelsEvents', labels);
    
    
}


function htmlForDisplaySelectedEvent(labels, ids){
    
    
    var total = labels.length;
    var html = ``;
    for(i = 0; i < total; i++) {
        html += `<p class="col-md-auto selected-event" data-id="${ids[i]}" data-type="1"><span class="badge badge-light p-3">${labels[i]}</span></p>`;
    }
    
    return html;
    
}

function htmlEventCategoryAfterSelectingEvent(data){
    
    
    var total   = data.length;
    var html    = ``;
    
    for(i = 0; i < total; i++) {
        
        var id      = data[i].event_category_id;
        var label   = data[i].event_category_name;
        html += `<p class="col-md-auto selected-category" data-id="${id}" data-type="2"><span class="badge badge-light p-3">${label}</span></p>`;
    }
    
    return html;
    
}

function htmlModalSearchEventByKeyup(total, data, checkedArray){
    
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



/* ---------------------------- Modal: Event & Category ---------------------------- */

function merchandiseNameToModal(){
    
    var merchandiseName = $('.merchandise-name').val();
    
    //set title
    $('.merchandise-name-for-modal').text(merchandiseName);
    
}






/* ---------------------------- Merchandise ---------------------------- */

function addMerchandise(e){
    
    e.preventDefault();
    
    var action      = 'addMerchandise';
    var name        = $('.merchandise-name').val();
    var price       = $('.merchandise-price').val();
    var description = $('.merchandise-description').val();
    var image       = getImageInformation(".upload-merchandise-src");
    
    var names       = getAllTextDataByClassName('.variable-name');
    var remarks     = getAllTextDataByClassName('.variable-remark');
    var types       = getAllSelectDataByClassName('.variable-select');
    var variables   = getAllAttrDataByClassName('.each-variable', 'data-variable');
    var requires    = getAllAttrDataByClassName('.each-variable', 'data-required');
    var otherValues = getAllAttrDataByClassName('.each-variable', 'data-type-other-value');
    
    var variableData = {
        
        names:names,
        remarks:remarks,
        types:types,
        variables:variables,
        requires:requires,
        otherValues:otherValues
    }
    
    var optionData          = getAllOptionData();
    var eventMerchandise    = getAllEventMerchandise();
    
    $.ajax({
        type: "POST",
        url: "submits/submit-merchandise-add.php",
        data: {
            action:action,
            name:name,
            price:price,
            description:description,
            image:image,
            variableData:variableData,
            optionData:optionData,
            eventMerchandise:eventMerchandise
        },
        dataType:'JSON', 
        success: function(result){
            if(result.status == "Success"){
                swal({
                    type: 'success',
                    title: 'Success',
                    text: 'Merchandise added successfully!'
                });
            }
        } 
    });
}

function editMerchandise(e){
    
    e.preventDefault();
    
    var action      = 'editMerchandise';
    var id          = parseInt($('.main-content').attr('data-event'));
    var name        = $('.merchandise-name').val();
    var price       = $('.merchandise-price').val();
    var description = $('.merchandise-description').val();
    var image       = getImageInformation(".upload-merchandise-src");
    
    var names       = getAllTextDataByClassName('.variable-name');
    var remarks     = getAllTextDataByClassName('.variable-remark');
    var types       = getAllSelectDataByClassName('.variable-select');
    var variables   = getAllAttrDataByClassName('.each-variable', 'data-variable');
    var requires    = getAllAttrDataByClassName('.each-variable', 'data-required');
    var otherValues = getAllAttrDataByClassName('.each-variable', 'data-type-other-value');
    
    var variableData = {
        
        names:names,
        remarks:remarks,
        types:types,
        variables:variables,
        requires:requires,
        otherValues:otherValues
    }
    
    var optionData          = getAllOptionData();
    var eventMerchandise    = getAllEventMerchandise();
    
    $.ajax({
        type: "POST",
        url: "submits/submit-merchandise-edit.php",
        data: {
            action:action,
            id:id,
            name:name,
            price:price,
            description:description,
            image:image,
            variableData:variableData,
            optionData:optionData,
            eventMerchandise:eventMerchandise
        },
        dataType:'JSON', 
        success: function(result){
            
            console.log(result);
            
            if(result.status == "Success"){
                swal({
                    type: 'success',
                    title: 'Success',
                    text: 'Merchandise edited successfully!'
                });
            }
        } 
    });
    
    
}


/* ---------------------------- Data ---------------------------- */
function getAllTextDataByClassName(className){
    
    var emptyArray  = [];
    var elements    = $(className);
    
    elements.each(function(i, obj) {
        var value = $(this).val();
        emptyArray.push(value);
    });
    
    return emptyArray;
}

function getAllSelectDataByClassName(className){
    
    var emptyArray  = [];
    var elements    = $(className);
    
    elements.each(function(i, obj) {
        var value = parseInt($(this).find(":selected").val());
        emptyArray.push(value);
    });
    
    return emptyArray;
    
}

function getAllAttrDataByClassName(className, attributeName){
    
    var emptyArray  = [];
    var elements    = $(className);
    
    elements.each(function(i, obj) {
        var value = $(this).attr(attributeName);
        emptyArray.push(value);
    });
    
    return emptyArray;
}

function getAllOptionData(){
    
    var options = $(document).find('.each-option');
    if(options.length > 0){
        
        var optionNos   = [];
        var variables   = [];
        var titles      = [];
        var limits      = [];
        
        options.each(function(i, obj) {
            
            var optionNo = $(this).attr('data-option');
            var variable = $(this).attr('data-option-at-variable');
            var title = $(this).find('.option-title').val();
            var limit = $(this).find('.option-limit').val();
            
            optionNos.push(optionNo);
            variables.push(variable);
            titles.push(title);
            limits.push(limit);
        });
        
        var optionData = {
            
            optionNos:optionNos,
            variables:variables,
            titles:titles,
            limits:limits
        }
    } else {
        var optionData = 0;
    }
    
    return optionData;
}

function getAllEventMerchandise(){
    
    var events = $('body').find('.selected-event');
    if(events.length > 0){
        
        var ids     = [];
        var types   = [];
        events.each(function(i, obj) {
            var id = $(this).attr('data-id');
            var type = $(this).attr('data-type');
            
            ids.push(id);
            types.push(type);
        });
        
        var data = {
            eventIds:ids,
            types:types
        }
    } else {
        var data = 0;
    }
    return data;
}



/* ---------------------------- Variable Let User Type Other Value ---------------------------- */
function variableOtherValueByCheckBoxClick(){
    
    var variableContainer   = $(this).parent().parent();
    var OtherValueAttr      = parseInt(variableContainer.attr('data-type-other-value'));
    
    if(OtherValueAttr == 0){
        variableContainer.attr('data-type-other-value', 1);
    } else {
        variableContainer.attr('data-type-other-value', 0);
    }
}

function variableOtherValueByLabelClick(){
    
    
    var variableContainer   = $(this).parent().parent();
    var RequiredAttr        = parseInt(variableContainer.attr('data-required'));
    
    var checkbox = $(this).prev();
    if(checkbox.is(':checked')){
        checkbox.prop( "checked", false );
        variableContainer.attr('data-type-other-value', 0);
    } else {
        checkbox.prop( "checked", true );
        variableContainer.attr('data-type-other-value', 1);
    }
}




/* ---------------------------- Variable Required ---------------------------- */
function variableIsRequiredByLabelClick(){
    
    
    var variableContainer   = $(this).parent().parent().parent();
    var RequiredAttr        = parseInt(variableContainer.attr('data-required'));
    
    var checkbox = $(this).prev();
    if(checkbox.is(':checked')){
        checkbox.prop( "checked", false );
        variableContainer.attr('data-required', 0);
    } else {
        checkbox.prop( "checked", true );
        variableContainer.attr('data-required', 1);
    }
}

function variableIsRequiredByCheckBoxClick(){
    
    var variableContainer   = $(this).parent().parent().parent();
    var RequiredAttr        = parseInt(variableContainer.attr('data-required'));
    
    if(RequiredAttr == 0){
        variableContainer.attr('data-required', 1);
    } else {
        variableContainer.attr('data-required', 0);
    }
}

/* ---------------------------- Variable Dropdown ---------------------------- */
function processVariableType(e){
    
    e.preventDefault();
    
    var selectedType        = parseInt($(this).find(":selected").val());
    var variableContainer   = $(this).parent().parent().parent();
    
    
    removeVariableOption(selectedType, variableContainer);
    //console.log(selectedType);
    
}

function removeVariableOption(selectedType, variableContainer){
    
    variableContainer.find('.option-header').remove();
    variableContainer.find('.each-option').remove();
    variableContainer.find('.type-other-value-container').remove();
    variableContainer.find('.add-option').remove();
    
    var optionEnd               = variableContainer.find('.option-end');
    var removeVariableElement   = variableContainer.find('.remove-variable');
    
    if(selectedType == 1){
        
        var html = optionHeaderOptionInputHTML();
        $(html).insertBefore(optionEnd);
        
        var html = otherValueContainerAddOptionHTML();
        $(html).insertAfter(removeVariableElement);
        
    }
}

function otherValueContainerAddOptionHTML(){
    
    var html = `

        <div class="type-other-value-container">
            <input type="checkbox" class="ml-1 checkbox-other-value">
            <span class="clickable-checkbox-other-value-label"> Let user type other value?</span><br>
        </div>
        <button class="btn-green add-option" style="background:#2F2F2F;">+ Add Option</button>

    `;
    
    return html;
}

function optionHeaderOptionInputHTML(){
    
    var html = `
    
        <div class="row mt-2 mdn option-header">
            <div class="col content-box-reg">
                <label>Option Label</label>
            </div>
            <div class="col content-box-reg">
                <label>Set Limit</label>
            </div>
            <div class="col content-box-reg">
            </div>
        </div>
        <div class="row mb-2 each-option" data-option="1" data-option-at-variable="1">
            <div class="col-sm content-box-reg mt-1">
                <input type="text" placeholder="Option 1" class="option-title">
            </div>
            <div class="col-sm content-box-reg mt-1">
                <input type="text" placeholder="Set Limit" class="option-limit">
            </div>
            <div class="col-sm content-box-reg remove-option">
                <button class="btn-close m-0 mt-1"><i class="fas fa-times"></i></button>
            </div>
        </div>

        `;
    
    return html;
}


/* ---------------------------- Option ---------------------------- */

function removeOption(e){
    
    e.preventDefault();
    
    var optionContainer = $(this).parent();
    var variableContainer = $(this).parent().parent();
    optionContainer.remove();
    
    reassignOptionNo(variableContainer);

}


function addOption(e){
    
    e.preventDefault();

    var html = `

    <div class="row mb-2 each-option" data-option="1" data-option-at-variable="1">
        <div class="col-sm content-box-reg mt-1">
            <input type="text" placeholder="Option 1" class="option-title">
        </div>
        <div class="col-sm content-box-reg mt-1">
            <input type="text" placeholder="Set Limit" class="option-limit">
        </div>
        <div class="col-sm content-box-reg remove-option">
            <button class="btn-close m-0 mt-1"><i class="fas fa-times"></i></button>
        </div>
    </div>

    `;
    
    var variableContainer = $(this).parent();
    var optionEnd = variableContainer.find('.option-end');
    
    $(html).insertBefore(optionEnd);
    
    reassignOptionNo(variableContainer);
    reassignOptionAtVariable();

}

function reassignOptionNo(container){
    
    var options = container.find('.each-option');
    if(options.length > 0){
        
        options.each(function(i, obj) {
            $(this).attr('data-option', (i + 1));
            reassignOptionPlaceholder($(this), (i + 1));
        });
    }
}

function reassignOptionPlaceholder(optionContainer, number){
    
    var title = optionContainer.find('.option-title');
    if(title.length > 0){
        title.attr('placeholder', 'Option '+number);
    }
}


/* ---------------------------- Variable ---------------------------- */



function addVariable(e){
    
    e.preventDefault();
    
    var html = `
    
    <div class="content-box-gray position-relative each-variable" data-variable="1" data-required="0" data-type-other-value="0">
        <div class="row">
            <div class="col-sm align-center content-box-reg">
                <label>Label Name</label><br><input type="text" placeholder="Label Name" class="variable-name">
            </div>
            <div class="col-sm align-center content-box-reg">
                <label>Input Type</label><br>
                <select class="variable-select">
                    <option value="1">Dropdown</option>
                    <option value="2">Single Line</option>
                </select>
            </div>
            <div class="col-sm align-center content-box-reg">
                <label>Remark</label><br><input type="text" placeholder="Remark" class="variable-remark">
            </div>
            <div class="col-sm align-center content-box-reg">
                <label></label><br>
                <input type="checkbox" class="mt20 checkbox-required">
                <span class="clickable-checkbox-required-label"> Required?</span>
            </div>
        </div>
        <div class="row mt-2 mdn option-header">
            <div class="col content-box-reg">
                <label>Option Label</label>
            </div>
            <div class="col content-box-reg">
                <label>Set Limit</label>
            </div>
            <div class="col content-box-reg">
            </div>
        </div>
        <div class="row mb-2 each-option" data-option="1" data-option-at-variable="1">
            <div class="col-sm content-box-reg mt-1">
                <input type="text" placeholder="Option 1" class="option-title">
            </div>
            <div class="col-sm content-box-reg mt-1">
                <input type="text" placeholder="Set Limit" class="option-limit">
            </div>
            <div class="col-sm content-box-reg">
                <button class="btn-close m-0 mt-1"><i class="fas fa-times"></i></button>
            </div>
        </div>
        <div class="option-end"></div>
        
        <button class="btn-reg-close remove-variable"><i class="fas fa-times"></i></button>
        <div class="type-other-value-container">
           <input type="checkbox" class="ml-1 checkbox-other-value"> 
           <span class="clickable-checkbox-other-value-label"> Let user type other value?</span><br>
        </div>
        <button class="btn-green add-option" style="background:#2F2F2F;">+ Add Option</button>
    </div>
    `;
    
    var addVariableBtn = $('.add-variable');
    $(html).insertBefore(addVariableBtn);
    
    reassignVariableNo();
    reassignOptionAtVariable();
    
}

function removeVariable(e){
    
    e.preventDefault();
    
    var variableContainer = $(this).parent();
    variableContainer.remove();
    
    reassignVariableNo();
    reassignOptionAtVariable();
}

/* ---------------------------- Reassign ---------------------------- */


function reassignVariableNo(){
    
    variableElements = $(document).find('.each-variable');
    if(variableElements.length > 0){
        
        variableElements.each(function(i, obj) {
            $(this).attr('data-variable', (i + 1));
        });
    }
}


function reassignOptionAtVariable(){
    
    variableElements = $(document).find('.each-variable');
    if(variableElements.length > 0){
        
        variableElements.each(function(i, obj) {
            
            var variable = $(this).attr('data-variable');
            var options = $(this).find('.each-option');
            
            if(options.length > 0){
                
                options.each(function(i, obj) {
                    $(this).attr('data-option-at-variable', variable);
                });
                
            }
        });
    }
    
}


/* ---------------------------- Image ---------------------------- */

function showPreviewMerchandise(){
    
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

function removeTempMerchandise(){
    
    var fileUploadContent = $(this).parent().parent();
    var imageUploadWrap = $(this).parent().parent().prev();
    
    fileUploadContent.find(".file-upload-image").attr("src", "");
    fileUploadContent.css("display", "none");
    imageUploadWrap.css("display", "inline-block");
}

function getImageInformation(className){
    
    var imageSrc = $(className).attr("src");
    
    return imageSrc;
    
}