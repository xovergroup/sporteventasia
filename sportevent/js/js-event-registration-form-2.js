$(document).ready(function() {
    
    $('body').on('click', '.event-category-remove', removeEventCategory);
    $('body').on('click', '.slide-form', displaySlideForm);
    $('body').on('click', '.go-to-checkout', goToCheckout);
    $('body').on('click', '.check-item', checkItem);
    $('body').on('change', '.ic-format', icFormat);
    $('body').on('keyup', '.new-ic-prefix', prefixIcFormat);
    $('body').on('keyup', '.new-ic-middle', middleIcFormat);
    $('body').on('keyup', '.new-ic-suffix', suffixIcFormat);
   
            
    getTotalParticipants();
    getGrandTotal();
    assignSlideContainerNo();
    checkDatePicker();
    grabAllStates();
    processRegisterForNameAttr();
    preparePluginContact();
});

function goToCheckout(e){
    
    e.preventDefault();
    
    var eventId     = parseInt($('.event-name').attr('data-event'));
    
    var action      = 'saveParticipantData';
    var texts       = processInputTextsOrTextareas('.input-type-text');
    var textareas   = processInputTextsOrTextareas('.input-type-textarea');
    var dropdowns   = processInputDropdowns('.input-type-dropdown');
    var emergency   = processEmergencyData();
    var registerFor = processRegisterFor();
    var radios      = processInputRadios(); 
    var checkboxes  = processInputCheckboxes();
    var contacts    = processContactNo(); 
    var icNos       = processIcNo(); 
    
    //console.log(texts);
   
    
    
    
    $.ajax({
        type: "POST",
        url: "submits/submit-event-registration-form-2.php",
        data: {
            action:action,
            texts:texts,
            textareas:textareas,
            dropdowns:dropdowns,
            radios:radios,
            checkboxes:checkboxes,
            contacts:contacts,
            icNos:icNos,
            registerFor:registerFor,
            emergency:emergency
        },
        dataType:'JSON', 
        success: function(result){

            console.log(result);
            
            //redirect to 3nd page
            if(result.status == 'Success'){
                window.location.href = "http://x-cow.com/sportevent/event-registration-form-3.php?event_id="+eventId;
            }


        } 
    });
}

function processIcNo(){
    
    var icContainers = $(document).find('.ic-container');
    
    if(icContainers.length > 0){
        
        var values              = [];
        var valuesExtras        = [];
        var events              = [];
        var users               = [];
        var categories          = [];
        var participants        = [];
        var participantsOverall = [];
        var inputsNos           = [];
        var inputsTypes         = [];
        
        icContainers.each(function(i, obj) {
            
            var wrapper             = $(this).parent().parent();
            var event               = wrapper.attr('data-event');
            var user                = wrapper.attr('data-user');
            var category            = wrapper.attr('data-category');
            var participant         = wrapper.attr('data-participant');
            var participantOverall  = wrapper.attr('data-container');
            var container           = $(this).parent();
            var inputNo             = container.attr('data-input-no');
            var inputType           = container.attr('data-input-type');
            
            var newIcFormat         = $(this).find('.new-ic-format');
            var otherIcFormat       = $(this).find('.other-ic-format');
            if(newIcFormat.length > 0){
                
                var prefix = $(this).find('.new-ic-prefix').val();
                var middle = $(this).find('.new-ic-middle').val();
                var suffix = $(this).find('.new-ic-suffix').val();
                
                var value = prefix + "" + middle + "" + suffix;
                
            } else {
                
                var value = otherIcFormat.val();
            }
            
            var icFormat = $(this).find('.ic-format').find(":selected").val(); 
            
            
            values.push(value);
            valuesExtras.push(icFormat);
            events.push(event);
            users.push(user);
            categories.push(category);
            participants.push(participant);
            participantsOverall.push(participantOverall);
            inputsNos.push(inputNo);
            inputsTypes.push(inputType);
        });
        
        var data = {
        
            values:values,
            valuesExtras:valuesExtras,
            events:events,
            users:users,
            categories:categories,
            participants:participants,
            participantsOverall:participantsOverall,
            inputsNos:inputsNos,
            inputsTypes:inputsTypes

        }
        
    } else {
        var data = 0;
    }
    
    return data;
}

function processContactNo(){
    
    var contactElements = $(document).find('.plugin-contact-no');
    
    if(contactElements.length > 0){
        
        var values              = [];
        var events              = [];
        var users               = [];
        var categories          = [];
        var participants        = [];
        var participantsOverall = [];
        var inputsNos           = [];
        var inputsTypes         = [];
        
        contactElements.each(function(i, obj) {
            
            var value               = $(this).val();
            var wrapper             = $(this).parent().parent().parent().parent();
            var event               = wrapper.attr('data-event');
            var user                = wrapper.attr('data-user');
            var category            = wrapper.attr('data-category');
            var participant         = wrapper.attr('data-participant');
            var participantOverall  = wrapper.attr('data-container');
            var container           = $(this).parent().parent().parent();
            var inputNo             = container.attr('data-input-no');
            var inputType           = container.attr('data-input-type');
            
            values.push(value);
            events.push(event);
            users.push(user);
            categories.push(category);
            participants.push(participant);
            participantsOverall.push(participantOverall);
            inputsNos.push(inputNo);
            inputsTypes.push(inputType);
        });
        
        var data = {
        
            values:values,
            events:events,
            users:users,
            categories:categories,
            participants:participants,
            participantsOverall:participantsOverall,
            inputsNos:inputsNos,
            inputsTypes:inputsTypes

        }
        
    } else {
        var data = 0;
    }
    
    return data;
}

function suffixIcFormat(){
    
    var input               = $(this);
    var inputValue          = $(this).val();
    var inputValueLength    = $(this).val().length;
    
    if(inputValueLength > 4){
        var limit = inputValue.substring(0,4);
        input.val(limit);
    }
    
    var regex=/^[0-9]+$/;
    if(!inputValue.match(regex)){
        input.val('');
    }
}

function middleIcFormat(){
    
    var input               = $(this);
    var inputValue          = $(this).val();
    var inputValueLength    = $(this).val().length;
    
    if(inputValueLength > 2){
        var limit = inputValue.substring(0,2);
        input.val(limit);
    }
    
    var regex=/^[0-9]+$/;
    if(!inputValue.match(regex)){
        input.val('');
    }
}

function prefixIcFormat(){
    
    var input               = $(this);
    var inputValue          = $(this).val();
    var inputValueLength    = $(this).val().length;
    
    if(inputValueLength > 6){
        var limit = inputValue.substring(0,6);
        input.val(limit);
    }
    
    var regex=/^[0-9]+$/;
    if(!inputValue.match(regex)){
        input.val('');
    }
}

function icFormat(){
    
    var format = parseInt($(this).find(':selected').val());
    
    var container = $(this).parent();
    container.find('.new-ic-format').remove();
    container.find('.other-ic-format').remove();
    container.find('.ic-form-hyphen').remove();
    
    var html            = generateIcInput(format);
    var spaceElement    = container.find('.extra-space-ic-form');
    $(html).insertAfter(spaceElement);

    
}

function generateIcInput(format){
    
    var html = ``;
    if(format == 1){
        html += `
            <input type="text" class="col-md-2 bg-gray no-border p-2 new-ic-format new-ic-prefix" placeholder="991231">
            <span class="col-md-1 ic-form-hyphen"> - </span>
            <input type="text" class="col-md-1 bg-gray no-border p-2 new-ic-format new-ic-middle" placeholder="14">
            <span class="col-md-1 ic-form-hyphen"> - </span>
            <input type="text" class="col-md-2 bg-gray no-border p-2 new-ic-format new-ic-suffix" placeholder="9999">
        `;
    } else {
        
        html += `<input type="text" class="col-md-8 bg-gray no-border p-2 other-ic-format" placeholder="">`;
        
    }
    
    return html;
}

function checkItem(e){
    
    e.preventDefault();
    
    var input = $(this).prev();
    
    if(input.is(":checked")){
        input.prop('checked',false);
    } else {
        input.prop('checked',true);

    }
}

function processRegisterFor(){
    
    var parentElements = $(document).find('.register-for-radio-input');
    if(parentElements.length > 0){
        
        var values          = [];
        var events          = [];
        var users           = [];
        var categories      = [];
        var participants    = [];
        
        parentElements.each(function(i, obj) {
            
            var value;
            value = $(this).find(":checked").val();
            if(value == undefined){
                value = "";
            }
            
            var wrapper         = $(this).parent().parent();
            var event           = wrapper.attr('data-event');
            var user            = wrapper.attr('data-user');
            var category        = wrapper.attr('data-category');
            var participant     = wrapper.attr('data-container');
            
            values.push(value);
            events.push(event);
            users.push(user);
            categories.push(category);
            participants.push(participant);
            
        });
        
        var data = {
            values:values,
            events:events,
            users:users,
            categories:categories,
            participants:participants
        }
        
        
    } else {
        var data = 0;
    }
    
    return data;
    
} 

function processEmergencyData(){
    
    
    
    var isLeader = 0;
    if ($("input[name='is_leader']:checked").is(':checked')) {
        isLeader = 1;
    } 
    
    var event = $('.event-name').attr('data-event');
    var name = $('.emergency-name').val();
    var relationship = $('.emergency-relationship').find(":selected").val();
    var number = $('.emergency-number').val();
    var email = $('.emergency-email').val();
    
    var data = {
        
        event:event,
        isLeader:isLeader,
        name:name,
        relationship:relationship,
        number:number,
        email:email
    }
    
    return data;

}

function processInputCheckboxes(){
    
    var values              = [];
    var events              = [];
    var users               = [];
    var categories          = [];
    var participants        = [];
    var participantsOverall = [];
    var inputsNos           = [];
    var inputsTypes         = [];
    
    var checkBoxesElements = $(document).find('.checkbox-input');
    if(checkBoxesElements.length > 0){
        
        $('input[name=checkbox_value]:checked').each(function(){
            
            var value               = $(this).val();
            var wrapper             = $(this).parent().parent().parent();
            var event               = wrapper.attr('data-event');
            var user                = wrapper.attr('data-user');
            var category            = wrapper.attr('data-category');
            var participant         = wrapper.attr('data-participant');
            var participantOverall  = wrapper.attr('data-container');
            var container           = $(this).parent().parent();
            var inputNo             = container.attr('data-input-no');
            var inputType           = container.attr('data-input-type');
            
            values.push(value);
            events.push(event);
            users.push(user);
            categories.push(category);
            participants.push(participant);
            participantsOverall.push(participantOverall);
            inputsNos.push(inputNo);
            inputsTypes.push(inputType);
        });
        
        var data = {
            values:values,
            events:events,
            users:users,
            categories:categories,
            participants:participants,
            participantsOverall:participantsOverall,
            inputsNos:inputsNos,
            inputsTypes:inputsTypes
        }
    } else {
        var data = 0;
    }
    
    return data;
}

function processInputRadios(){
    
    var values              = [];
    var events              = [];
    var users               = [];
    var categories          = [];
    var participants        = [];
    var participantsOverall = [];
    var inputsNos           = [];
    var inputsTypes         = [];
    
    var radiosElements = $(document).find('.radio-input');
    if(radiosElements.length > 0){
        
    
        radiosElements.each(function(i, obj) {

            var value;
            value = $(this).find(":checked").val();
            if(value == undefined){
                value = "";
            }

            var wrapper             = $(this).parent().parent();
            var event               = wrapper.attr('data-event');
            var user                = wrapper.attr('data-user');
            var category            = wrapper.attr('data-category');
            var participant         = wrapper.attr('data-participant');
            var participantOverall  = wrapper.attr('data-container');
            var container           = $(this).parent();
            var inputNo             = container.attr('data-input-no');
            var inputType           = container.attr('data-input-type');

            values.push(value);
            events.push(event);
            users.push(user);
            categories.push(category);
            participants.push(participant);
            participantsOverall.push(participantOverall);
            inputsNos.push(inputNo);
            inputsTypes.push(inputType);
        });
        
        var data = {
            values:values,
            events:events,
            users:users,
            categories:categories,
            participants:participants,
            participantsOverall:participantsOverall,
            inputsNos:inputsNos,
            inputsTypes:inputsTypes
        }
    } else {
        var data = 0;
    }
    
    return data;
}

function processInputDropdowns(className){
    
    var elements = $(document).find(className);
    if(elements.length > 0){
        
        var values              = [];
        var events              = [];
        var users               = [];
        var categories          = [];
        var participants        = [];
        var participantsOverall = [];
        var inputsNos           = [];
        var inputsTypes         = [];
        
        elements.each(function(i, obj) {
            var value               = $(this).find(":selected").val();
            var wrapper             = $(this).parent().parent().parent();
            var event               = wrapper.attr('data-event');
            var user                = wrapper.attr('data-user');
            var category            = wrapper.attr('data-category');
            var participant         = wrapper.attr('data-participant');
            var participantOverall  = wrapper.attr('data-container');
            var container           = $(this).parent().parent();
            var inputNo             = container.attr('data-input-no');
            var inputType           = container.attr('data-input-type');
            
            values.push(value);
            events.push(event);
            users.push(user);
            categories.push(category);
            participants.push(participant);
            participantsOverall.push(participantOverall);
            inputsNos.push(inputNo);
            inputsTypes.push(inputType);
        });
        
        var data = {
            values:values,
            events:events,
            users:users,
            categories:categories,
            participants:participants,
            participantsOverall:participantsOverall,
            inputsNos:inputsNos,
            inputsTypes:inputsTypes
        }

    } else {
        var data = 0;
    }
    
    return data;
    
}

function processInputTextsOrTextareas(className){
    
    var elements = $(document).find(className);
    if(elements.length > 0){
        
        var values              = [];
        var events              = [];
        var users               = [];
        var categories          = [];
        var participants        = [];
        var participantsOverall = [];
        var inputsNos           = [];
        var inputsTypes         = [];
        
        elements.each(function(i, obj) {
            
            var value               = $(this).val();
            var wrapper             = $(this).parent().parent().parent();
            var event               = wrapper.attr('data-event');
            var user                = wrapper.attr('data-user');
            var category            = wrapper.attr('data-category');
            var participant         = wrapper.attr('data-participant');
            var participantOverall  = wrapper.attr('data-container');
            var container           = $(this).parent().parent();
            var inputNo             = container.attr('data-input-no');
            var inputType           = container.attr('data-input-type');
            
            values.push(value);
            events.push(event);
            users.push(user);
            categories.push(category);
            participants.push(participant);
            participantsOverall.push(participantOverall);
            inputsNos.push(inputNo);
            inputsTypes.push(inputType);
        });
        
        var data = {
        
            values:values,
            events:events,
            users:users,
            categories:categories,
            participants:participants,
            participantsOverall:participantsOverall,
            inputsNos:inputsNos,
            inputsTypes:inputsTypes

        }
        
    } else {
        var data = 0;
    }
    
    return data;
}




function displaySlideForm(e){
    
    e.preventDefault();
    
    processParticipantContainer($(this));
    processSlide($(this));
    
}

function processParticipantContainer(clickedElement){
    
    var slide = $(clickedElement);
    var slideId = slide.attr('data-slide');
    
    var participantContainer = $(document).find('.participant-detail-container');
    if(participantContainer.length > 0){
        participantContainer.each(function(i, obj) {
            
            $(this).removeClass("cust-no-display");
            
            var containerNo = i + 1;
            if(containerNo != slideId){
                $(this).addClass("cust-no-display");
            }
        });
    }
}

function processSlide(clickedElement){
    
    var slide = $(clickedElement);
    var slides = $(document).find('.slide-form');
    if(slides.length > 0){
        
        //set all slides to default color
        slides.each(function(i, obj) {
            $(this).removeClass('bg-red txt-white');
            $(this).removeClass('bg-white');
            $(this).addClass('bg-white');
        });
        
        //set clicked slide
        slide.removeClass('bg-white');
        slide.addClass('bg-red txt-white');
    }
}

function assignSlideContainerNo(){
    
    var slides = $(document).find('.slide-form');
    var participantContainer = $(document).find('.participant-detail-container');
    if(slides.length > 0){
        slides.each(function(i, obj) {
            $(this).attr('data-slide', (i+1));
        });
    }
    if(participantContainer.length > 0){
        participantContainer.each(function(i, obj) {
            $(this).attr('data-container', (i+1));
            
            var containerNo = i + 1;
            if(containerNo != 1){
                $(this).addClass("cust-no-display");
            }
        });
    }
}

function removeEventCategory(e){
    
    e.preventDefault();
    
    var action = 'deleteRegisterCategory';
    var id = $(this).attr('data-register');
    var categoryId = $(this).attr('data-register-category');
    var slide = $(this).parent().parent();
    
    
    $.ajax({
        type: "POST",
        url: "submits/submit-event-registration-form-2.php",
        data: {
            action:action,
            id:id
        },
        dataType:'JSON', 
        success: function(result){

            console.log(result);
            
            //remove slide
            slide.remove();
            
            //remove participant form
            removeParticipantForm(categoryId);
            
            //check got category or not
            var slides = $(document).find('.swiper-slide');
            if(slides.length < 1){
                var eventId = $('.event-name').attr('data-event');
                window.location.href = "http://x-cow.com/sportevent/event-registration-form-1.php?event_id="+eventId;
            }
    

        } 
    });
}

function removeParticipantForm(categoryId){
    
    var categoryId = parseInt(categoryId);
    
    var participantContainer = $(document).find('.participant-detail-container');
    if(participantContainer.length > 0){
            participantContainer.each(function(i, obj) {
                
                var category = parseInt($(this).attr('data-category'));
                if(category == categoryId){
                    $(this).remove();
                }
            });
        }
}

function getTotalParticipants(){
    
    var categoryParticipants = $(document).find('.category-participant');
    if(categoryParticipants.length > 0){
        participants = 0;
        categoryParticipants.each(function(i, obj) {
            participants += parseInt($(this).text());
        });
        $('.total-participant').text(participants);
    }
}

function getGrandTotal(){
    
    var dropdownGrandTotalElement = $(document).find('.dropdown-grand-total'); 
    if(dropdownGrandTotalElement.length > 0){
        var dropdownGrandTotal = dropdownGrandTotalElement.text();
        $('.grand-total').text(dropdownGrandTotal);
    }
}

function getDataFromStorage(key) {
    
    var array;
    
    if(localStorage.getItem(key) === null) {
        array = [];
    } else {
        array = JSON.parse(localStorage.getItem(key));
    }
    return array;
}

function checkDatePicker(){
    
    var datepickers = $(document).find('.date-picker');
    
    if(datepickers.length > 0){
        
        datepickers.each(function(i, obj) {
            
            var date = $(this).val();
            
            if(date.length == 0){
                var todayDate = $(this).parent().attr('data-date-today');
                $(this).val(todayDate)
            }
        });
    }
}

function grabAllStates(){
    
    var action = 'grabAllStates';
    
    $.ajax({
        type: "POST",
        url: "submits/submit-event-registration-form-2.php",
        data: {
            action:action
        },
        dataType:'JSON', 
        success: function(result){

            var statesArray = result.states;
            var processHTML = statesDropdownHTML(statesArray);
            
            var dropdowns = $(document).find('.state-dropdown');
            if(dropdowns.length > 0){
                
                dropdowns.each(function(i, obj) {
                    $(this).empty();
                    $(this).append(processHTML);
                });
            }
            

        } 
    });
}

function statesDropdownHTML(theArrayOfStates){
    
    var html = ``;
    
    $.each(theArrayOfStates, function( key, value ) {
        html += `<option value="${value.state_name}">${value.state_name}</option>`;

    });
    
    return html;
}

function processRegisterForNameAttr(){
    
    var registerForElements = $(document).find('.radio-name-process');
    if(registerForElements.length > 0){
        
        registerForElements.each(function(i, obj) {
            var containerNo = $(this).parent().parent().parent().attr('data-container');
            
            //rename name attr
            $(this).attr('name', 'register_for_'+containerNo);
            
        });
    }
    
}

function preparePluginContact(){
    
   
    var contactElements = $('body').find('.plugin-contact-no');
    
    if(contactElements.length > 0){
        
        //assign unique id
        contactElements.each(function(i, obj) {
            
            $(this).attr('id', 'contact-no-'+(i+1));
            
        });
        
        //initialise 
        contactElements.each(function(i, obj) {
            
            var input = document.querySelector("#contact-no-"+(i+1));
            
            window.intlTelInput(input, {

                nationalMode: false,
                autoHideDialCode: true,
                utilsScript: "libs/intlTelInput/js/utils.js"

            });
            
        });
    }
}






