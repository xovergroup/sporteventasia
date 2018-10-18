$(document).ready(function() {
    
    //category
    $('body').on('click', '.add-category', addCategory);
    $('body').on('click', '.delete-category', deleteCategory);
    $('body').on('click', '.save-event-category', saveEventCategory);
    $('body').on('click', '.collapse-icon', rotateCaret);
    
    //option
    $('body').on('change', '.chosen-input-type', chosenInputType);
    $('body').on('click', '.add-more-option', addMoreOption);
    $('body').on('click', '.remove-option', removeOption);
    
    //control
    $("body").on("click",".add-control", addControl);
    $("body").on("click",".remove-control", removeControl);
    
    //prefix
    $('body').on('click', '.add-prefix', addPrefix);
    
    //radio
    $('body').on('click', '.event-input-radio', inputIsRequired);
    $('body').on('click', '.event-input-allow-type', inputIsAllowedType);
    
});

function addCategory(e){
    
    e.preventDefault();
    
    var countCategory = parseInt($("#counter-category").val()) + 1;
    $("#counter-category").val(countCategory);
    
    var html = `

    <div class="card content-box category-no" data-category="1">

        <div class="card-header" id="heading-${countCategory}">
            <h5 class="mb-0">
                <button class="btn btn-link collapsed btn-accordion" type="button" data-toggle="collapse" data-target="#collapse-${countCategory}" aria-expanded="false" aria-controls="collapse-${countCategory}">
                Event Category #<span class="count-category-title">${countCategory}</span> <i class="fa fa-caret-down float-right collapse-icon"></i>
                </button>
            </h5>
        </div>

        <div id="collapse-${countCategory}" class="collapse count-heading" aria-labelledby="heading-${countCategory}" data-parent="#accordionExample">
            <div class="card-body">
                <p class="txt-red">Category Information</p>
                <div class="content-box-gray">
                    <input type="hidden" name="event_category_number[]" class="event-category-number" value="">
                    <div class="content-box-gray-row">
                        <label>Category Name</label><input type="text" placeholder="Category Name" name="event_category_name[]" class="validate-input-text">
                    </div>
                    <div class="content-box-gray-row">
                        <label>Category Fees</label><input type="text" placeholder="MYR 50" name="event_category_fees[]" class="validate-input-text">
                    </div>
                    <div class="content-box-gray-row">
                        <label>Early Bird Price</label><input type="text" placeholder="Optional" class="early-input" name="event_category_fees_early_bird[]">Before<input type="date" class="date-picker set-date-today early-date" value="2018-01-01" name="event_category_fees_early_bird_date_end[]">
                    </div>
                    <div class="content-box-gray-row">
                        <label>Category Pax</label><input type="text" placeholder="Category Pax" name="event_category_pax[]" class="validate-input-text">
                    </div>
                    <div class="content-box-gray-row">
                        <label>Category Limited Slot</label><input type="text" placeholder="Category Limited Slot" name="event_category_limited_slot[]" class="validate-input-text">
                    </div>
                    <div class="content-box-gray-row">
                        <label>Registration Start Date</label><input type="date" class="date-picker set-date-today validate-date-picker validate-date-picker-start" value="2018-01-01" name="event_category_reg_date_start[]">
                    </div>
                    <div class="content-box-gray-row">
                        <label>Registration End Date</label><input type="date" class="date-picker set-date-today validate-date-picker validate-date-picker-end" value="2018-01-01" name="event_category_reg_date_end[]">
                    </div>
                    <div class="content-box-gray-row">
                        <label>Category Description</label><textarea type="text" placeholder="Describe your category" name="event_category_desc[]" class="validate-input-text"></textarea>
                    </div>
                    <div class="content-box-gray-row">
                        <label>Category Promo Code</label><input type="text" placeholder="8888" name="event_category_promo_code[]">
                    </div>
                </div>


                <p class="txt-red">Registration Form</p>
                <a href="#" class="add-prefix"><i class="fas fa-plus-square"></i> Use Prefix</a>

                <div class="content-box-gray position-relative control-container">
                    <input type="hidden" class="event-input-category" name="event_input_category[]" value="1">
                    <input type="hidden" class="event-input-number" name="event_input_number[]" value="1">
                    <input type="hidden" class="event-input-type" name="event_input_type[]" value="1">
                    <input type="hidden" class="event-input-allow-user-type" name="event_input_allow_user_type[]" value="0">
                    <div class="row">
                        <div class="col-sm align-center content-box-reg">
                            <label>Label Name</label><br><input type="text" placeholder="Label Name" name="event_input_label_name[]" class="validate-input-text-category">
                        </div>
                        <div class="col-sm align-center content-box-reg">
                            <label>Input Type</label><br>
                            <select class="chosen-input-type">
                                <option value="1">Single Line</option>
                                <option value="2">Multi Line</option>
                                <option value="10">NRIC/Passport</option>
                                <option value="11">Gender</option>
                                <option value="12">Contact</option>
                                <option value="3">Date</option>
                                <option value="4">Time</option>
                                <option value="5">Dropdown</option>
                                <option value="6">Check Box</option>
                                <option value="7">Radio Button</option>
                                <option value="8">Malaysian States</option>
                                <option value="9">Countries</option>
                            </select>
                        </div>
                        <div class="col align-center content-box-reg">
                            <label>Remark</label><br><input type="text" placeholder="Remark" name="event_input_remark[]">
                        </div>
                        <div class="col-sm align-center content-box-reg">
                            <label></label><br>
                            <input type="radio" class="mt20 event-input-radio">Required?
                            <input type="hidden" class="event-input-required" name="event_input_required[]" value="0">
                        </div>
                    </div>

                    <div class="input-type-end"></div>
                    <button class="btn-reg-close remove-control"><i class="fas fa-times"></i></button>
                </div>



                <div class="control-end"></div>

                <button class="btn-green add-control">+ Add Control</button>
                <button class="btn-red delete-category"><i class="fas fa-times"></i> Delete Category</button>
            </div>
        </div>
    </div>

    `;
    
    var categoryEnd = $(this).prev().find(".category-end");
    $(html).insertBefore(categoryEnd);
    
    $(".card-header").each(function(i, obj) {
        $(this).attr("id", "heading-" + (i + 1));
    });
    
    $(".count-heading").each(function(i, obj) {
        $(this).attr("aria-labelledby", "heading-" + (i + 1));
    });
    
    $(".count-category-title").each(function(i, obj) {
         $(this).text((i + 1));
    });
    
    $(".category-no").each(function(i, obj) {
        $(this).attr("data-category", (i + 1));
    });
    
    $(".event-category-number").each(function(i, obj) {
        $(this).val(i + 1);
    });
    
    
    
    
    var categories = $(this).prev().find(".category-no");
    categories.each(function(i, obj) {
        
        var catagoryNo = $(this).attr("data-category");
        $(this).find(".event-input-category").val(catagoryNo);

    });
    
    //set today date on date picker
    setTodayDate();
}

function deleteCategory(e){
    
    e.preventDefault();
    
    var accordion = $(this).parent().parent().parent().parent();
    var card = $(this).parent().parent().parent();
    card.remove();
    
    $(".card-header").each(function(i, obj) {
        $(this).attr("id", "heading-" + (i + 1));
    });
    
    $(".count-heading").each(function(i, obj) {
        $(this).attr("aria-labelledby", "heading-" + (i + 1));
    });
    
    $(".count-category-title").each(function(i, obj) {
         $(this).text((i + 1));
    });
    
    $(".category-no").each(function(i, obj) {
        $(this).attr("data-category", (i + 1));
    });
    
    var cards = accordion.find(".card");
    cards.each(function(i, obj) {
        var catagoryNo = $(this).attr("data-category");
        $(this).find(".event-input-category").val(catagoryNo);
        $(this).find(".event-option-category").val(catagoryNo);
    });
}

function saveEventCategory(e){
    
    e.preventDefault();
    
    var categories = countEventCategory();
    
    if(categories > 0){
        
        var gotError = validateEventCategory();

        if(!gotError){
            $("#form-event-category").submit();
        } else {
            swalCustomMessage("error", "Error!", "Please check the form again.");
        }
    } else {
        
        swalCustomMessage("error", "Error!", "Please create at least one Category.");
    }
}

function rotateCaret(e){
    
    e.preventDefault();
    
    $(this).toggleClass('fa-rotate-180');
    
    //Notes: the caret will only rotate if the i tag is clicked, not the button(it's parent). probably not a big deal, later will amend if requested
}

function chosenInputType(){
    
    var nextElement = $(this).parent().parent().next();
    if(nextElement.hasClass("sub-input-dynamic")){
        nextElement.remove();
    }
    
    var selected = parseInt($(this).find(":selected").val());
    
    var contentBox  = $(this).parent().parent().parent();
    var category    = contentBox.find(".event-input-category").val();
    var number      = contentBox.find(".event-input-number").val();
    
    contentBox.find(".event-input-type").val(selected);
    
    if(selected == 5  || selected == 6 || selected == 7) {
        var inputEnd = contentBox.find(".input-type-end");
        createSubInput(inputEnd, selected, category, number);
    }
}

function createSubInput(element, type, category, number){
    
    var html = `
        <div class="sub-input-dynamic">
            <div class="row mt-2 mdn">
                <div class="col content-box-reg">
                    <label>Option Label</label>
                </div>
                <div class="col content-box-reg">
                    <label>Set Limit</label>
                </div>
                <div class="col content-box-reg">
                </div>
            </div>

            <div class="row mb-2 option-container">
                <input type="hidden" class="event-option-category" name="event_option_category[]" value="${category}">
                <input type="hidden" class="event-option-number" name="event_option_number[]" value="${number}">
                <input type="hidden" class="event-option-type" name="event_option_type[]" value="${type}">
                <div class="col-sm content-box-reg mt-1">
                    <input type="text" placeholder="Option 1" class="counter-option validate-input-text-option" name="event_option_title[]">
                </div>
                <div class="col-sm content-box-reg mt-1">
                    <input type="text" placeholder="Set Limit" name="event_option_limit[]">
                </div>
                <div class="col-sm content-box-reg">
                    <button class="btn-close m-0 mt-1 remove-option"><i class="fas fa-times"></i></button>
                </div>
            </div>

            <div class="option-end"></div>

            <button class="btn-reg-close"><i class="fas fa-times"></i></button>
            <input type="radio" class="ml-1 event-input-allow-type"> Let user type other value?<br>
            <button class="btn-green add-more-option" style="background:#2F2F2F;">+ Add Option</button>

        </div>

    `;
    
    $(html).insertBefore(element);
}

/* ------------------------------------------ OPTION ------------------------------------------ */
function addMoreOption(e){
    
    e.preventDefault();
    
    var subInputContainer   = $(this).parent();
    var contentBox          = $(this).parent().parent();
    
    var optionEnd           = subInputContainer.find(".option-end");
    
    var html = `
        <div class="row mb-2 option-container">
            <input type="hidden" class="event-option-category" name="event_option_category[]" value="1">
            <input type="hidden" class="event-option-number" name="event_option_number[]" value="1">
            <input type="hidden" class="event-option-type" name="event_option_type[]" value="1">
            <div class="col-sm content-box-reg mt-1">
                <input type="text" placeholder="Option 1" class="counter-option validate-input-text-option" name="event_option_title[]">
            </div>
            <div class="col-sm content-box-reg mt-1">
                <input type="text" placeholder="Set Limit" name="event_option_limit[]">
            </div>
            <div class="col-sm content-box-reg">
                <button class="btn-close m-0 mt-1 remove-option"><i class="fas fa-times"></i></button>
            </div>
        </div>`;
    
    $(html).insertBefore(optionEnd);
    
    //reassign option numbering
    subInputContainer.find(".counter-option").each(function(i, obj) {
        $(this).attr("placeholder", "Option " + (i + 1));
    });
    
    
    //assign every options category, number, type
    var category    = contentBox.find(".event-input-category").val();
    var number      = contentBox.find(".event-input-number").val();
    var type        = contentBox.find(".event-input-type").val();
    subInputContainer.find(".event-option-category").val(category);
    subInputContainer.find(".event-option-number").val(number);
    subInputContainer.find(".event-option-type").val(type);
    
}

function removeOption(e){
    e.preventDefault();
    
    var subInput = $(this).parent().parent().parent();
    $(this).parent().parent().remove();
    
    subInput.find(".counter-option").each(function(i, obj) {
        $(this).attr("placeholder", "Option " + (i + 1));
    });
    
}

/* ------------------------------------------ CONTROL ------------------------------------------ */
function addControl(e){
    
    e.preventDefault();
    
    var html = `
            <div class="content-box-gray position-relative control-container">
                <input type="hidden" class="event-input-category" name="event_input_category[]" value="1">
                <input type="hidden" class="event-input-number" name="event_input_number[]" value="1">
                <input type="hidden" class="event-input-type" name="event_input_type[]" value="1">
                <input type="hidden" class="event-input-allow-user-type" name="event_input_allow_user_type[]" value="0">
                <div class="row">
                    <div class="col-sm align-center content-box-reg">
                        <label>Label Name</label><br><input type="text" placeholder="Label Name" name="event_input_label_name[]" class="validate-input-text-category">
                    </div>
                    <div class="col-sm align-center content-box-reg">
                        <label>Input Type</label><br>
                        <select class="chosen-input-type">
                            <option value="1">Single Line</option>
                            <option value="2">Multi Line</option>
                            <option value="10">NRIC/Passport</option>
                            <option value="11">Gender</option>
                            <option value="12">Contact</option>
                            <option value="3">Date</option>
                            <option value="4">Time</option>
                            <option value="5">Dropdown</option>
                            <option value="6">Check Box</option>
                            <option value="7">Radio Button</option>
                            <option value="8">Malaysian States</option>
                            <option value="9">Countries</option>
                        </select>
                    </div>
                    <div class="col align-center content-box-reg">
                        <label>Remark</label><br><input type="text" placeholder="Remark" name="event_input_remark[]">
                    </div>
                    <div class="col-sm align-center content-box-reg">
                        <label></label><br>
                        <input type="radio" class="mt20 event-input-radio">Required?
                        <input type="hidden" class="event-input-required" name="event_input_required[]" value="0">
                    </div>
                </div>

                <div class="input-type-end"></div>
                <button class="btn-reg-close remove-control"><i class="fas fa-times"></i></button>
            </div>
    `;
    
    var parent      = $(this).parent();
    var controlEnd  = parent.find(".control-end");
    
    $(html).insertBefore(controlEnd);
    
    var controls = $(this).parent().find(".event-input-number");
    controls.each(function(i, obj) {
        $(this).attr("value", (i + 1));
    });
    
    var card        = $(this).parent().parent().parent();
    var catagoryNo  = card.attr("data-category");
    card.find(".event-input-category").val(catagoryNo);
}

function removeControl(e){
    
    e.preventDefault();
    
    var cardBody    = $(this).parent().parent();
    var contentBox  = $(this).parent();
    
    
    contentBox.remove();
    
    var controls = cardBody.find(".event-input-number");
    
    controls.each(function(i, obj) {
        $(this).attr("value", (i + 1));
    });
    
    
    var contentBoxes = cardBody.find(".control-container");
    contentBoxes.each(function(i, obj) {
        var category = $(this).find(".event-input-category").val();
        var number = $(this).find(".event-input-number").val();
        var type = $(this).find(".event-input-type").val();
        
        var options = $(this).find(".option-container");
        if(options.length > 0){
            options.each(function(i, obj) {
                $(this).find(".event-option-category").val(category);
                $(this).find(".event-option-number").val(number);
                $(this).find(".event-option-type").val(type);
            });
        }
    });
}

function addPrefix(e){
    
    e.preventDefault();
    
    var card                = $(this).parent().parent().parent();
    var category            = card.attr("data-category");
    var cardBody            = $(this).parent();
    var controlContainers   = cardBody.find(".control-container");
    var controlEnd          = cardBody.find(".control-end");
    
    //remove default control-container
    controlContainers.remove();
    
    //set html
    var html = "";
    
    var labels = ["Full Name", "Gender", "NRIC/Passport", "Contact No", "Email"];
    var loop = labels.length;
    
    for(i = 0; i < loop; i++) { 
        
        if(i == 1){
            
            html += `

            <div class="content-box-gray position-relative control-container">
                <input type="hidden" class="event-input-category" name="event_input_category[]" value="1">
                <input type="hidden" class="event-input-number" name="event_input_number[]" value="1">
                <input type="hidden" class="event-input-type" name="event_input_type[]" value="11">
                <input type="hidden" class="event-input-allow-user-type" name="event_input_allow_user_type[]" value="0">
                <div class="row">
                    <div class="col-sm align-center content-box-reg">
                        <label>Label Name</label><br><input type="text" placeholder="Label Name" name="event_input_label_name[]" class="validate-input-text-category" value="${labels[i]}">
                    </div>
                    <div class="col-sm align-center content-box-reg">
                        <label>Input Type</label><br>
                        <select class="chosen-input-type">
                            <option value="1">Single Line</option>
                            <option value="2">Multi Line</option>
                            <option value="10">NRIC/Passport</option>
                            <option value="11" selected>Gender</option>
                            <option value="12">Contact</option>
                            <option value="3">Date</option>
                            <option value="4">Time</option>
                            <option value="5">Dropdown</option>
                            <option value="6">Check Box</option>
                            <option value="7">Radio Button</option>
                            <option value="8">Malaysian States</option>
                            <option value="9">Countries</option>
                        </select>
                    </div>
                    <div class="col align-center content-box-reg">
                        <label>Remark</label><br><input type="text" placeholder="Remark" name="event_input_remark[]">
                    </div>
                    <div class="col-sm align-center content-box-reg">
                        <label></label><br>
                        <input type="radio" class="mt20 event-input-radio" checked>Required?
                        <input type="hidden" class="event-input-required" name="event_input_required[]" value="1">
                    </div>
                </div>

                <div class="input-type-end"></div>
                <button class="btn-reg-close remove-control"><i class="fas fa-times"></i></button>
            </div>

            `;
            
        } else if(i == 2){ 
            
            html += `

            <div class="content-box-gray position-relative control-container">
                <input type="hidden" class="event-input-category" name="event_input_category[]" value="1">
                <input type="hidden" class="event-input-number" name="event_input_number[]" value="1">
                <input type="hidden" class="event-input-type" name="event_input_type[]" value="10">
                <input type="hidden" class="event-input-allow-user-type" name="event_input_allow_user_type[]" value="0">
                <div class="row">
                    <div class="col-sm align-center content-box-reg">
                        <label>Label Name</label><br><input type="text" placeholder="Label Name" name="event_input_label_name[]" class="validate-input-text-category" value="${labels[i]}">
                    </div>
                    <div class="col-sm align-center content-box-reg">
                        <label>Input Type</label><br>
                        <select class="chosen-input-type">
                            <option value="1">Single Line</option>
                            <option value="2">Multi Line</option>
                            <option value="10" selected>NRIC/Passport</option>
                            <option value="11">Gender</option>
                            <option value="12">Contact</option>
                            <option value="3">Date</option>
                            <option value="4">Time</option>
                            <option value="5">Dropdown</option>
                            <option value="6">Check Box</option>
                            <option value="7">Radio Button</option>
                            <option value="8">Malaysian States</option>
                            <option value="9">Countries</option>
                        </select>
                    </div>
                    <div class="col align-center content-box-reg">
                        <label>Remark</label><br><input type="text" placeholder="Remark" name="event_input_remark[]">
                    </div>
                    <div class="col-sm align-center content-box-reg">
                        <label></label><br>
                        <input type="radio" class="mt20 event-input-radio" checked>Required?
                        <input type="hidden" class="event-input-required" name="event_input_required[]" value="1">
                    </div>
                </div>

                <div class="input-type-end"></div>
                <button class="btn-reg-close remove-control"><i class="fas fa-times"></i></button>
            </div>

            `;
            
        } else if(i == 3){ 
            
            html += `

            <div class="content-box-gray position-relative control-container">
                <input type="hidden" class="event-input-category" name="event_input_category[]" value="1">
                <input type="hidden" class="event-input-number" name="event_input_number[]" value="1">
                <input type="hidden" class="event-input-type" name="event_input_type[]" value="12">
                <input type="hidden" class="event-input-allow-user-type" name="event_input_allow_user_type[]" value="0">
                <div class="row">
                    <div class="col-sm align-center content-box-reg">
                        <label>Label Name</label><br><input type="text" placeholder="Label Name" name="event_input_label_name[]" class="validate-input-text-category" value="${labels[i]}">
                    </div>
                    <div class="col-sm align-center content-box-reg">
                        <label>Input Type</label><br>
                        <select class="chosen-input-type">
                            <option value="1">Single Line</option>
                            <option value="2">Multi Line</option>
                            <option value="10">NRIC/Passport</option>
                            <option value="11">Gender</option>
                            <option value="12" selected>Contact</option>
                            <option value="3">Date</option>
                            <option value="4">Time</option>
                            <option value="5">Dropdown</option>
                            <option value="6">Check Box</option>
                            <option value="7">Radio Button</option>
                            <option value="8">Malaysian States</option>
                            <option value="9">Countries</option>
                        </select>
                    </div>
                    <div class="col align-center content-box-reg">
                        <label>Remark</label><br><input type="text" placeholder="Remark" name="event_input_remark[]">
                    </div>
                    <div class="col-sm align-center content-box-reg">
                        <label></label><br>
                        <input type="radio" class="mt20 event-input-radio" checked>Required?
                        <input type="hidden" class="event-input-required" name="event_input_required[]" value="1">
                    </div>
                </div>

                <div class="input-type-end"></div>
                <button class="btn-reg-close remove-control"><i class="fas fa-times"></i></button>
            </div>

            `;
            
        } else {
            
            html += `

            <div class="content-box-gray position-relative control-container">
                <input type="hidden" class="event-input-category" name="event_input_category[]" value="1">
                <input type="hidden" class="event-input-number" name="event_input_number[]" value="1">
                <input type="hidden" class="event-input-type" name="event_input_type[]" value="1">
                <input type="hidden" class="event-input-allow-user-type" name="event_input_allow_user_type[]" value="0">
                <div class="row">
                    <div class="col-sm align-center content-box-reg">
                        <label>Label Name</label><br><input type="text" placeholder="Label Name" name="event_input_label_name[]" class="validate-input-text-category" value="${labels[i]}">
                    </div>
                    <div class="col-sm align-center content-box-reg">
                        <label>Input Type</label><br>
                        <select class="chosen-input-type">
                            <option value="1">Single Line</option>
                            <option value="2">Multi Line</option>
                            <option value="10">NRIC/Passport</option>
                            <option value="11">Gender</option>
                            <option value="12">Contact</option>
                            <option value="3">Date</option>
                            <option value="4">Time</option>
                            <option value="5">Dropdown</option>
                            <option value="6">Check Box</option>
                            <option value="7">Radio Button</option>
                            <option value="8">Malaysian States</option>
                            <option value="9">Countries</option>
                        </select>
                    </div>
                    <div class="col align-center content-box-reg">
                        <label>Remark</label><br><input type="text" placeholder="Remark" name="event_input_remark[]">
                    </div>
                    <div class="col-sm align-center content-box-reg">
                        <label></label><br>
                        <input type="radio" class="mt20 event-input-radio" checked>Required?
                        <input type="hidden" class="event-input-required" name="event_input_required[]" value="1">
                    </div>
                </div>

                <div class="input-type-end"></div>
                <button class="btn-reg-close remove-control"><i class="fas fa-times"></i></button>
            </div>

            `;
        }
    }
    
    //insert before
    $(html).insertBefore(controlEnd);
    
    var generatedControlContainers  = cardBody.find(".control-container");
    var inputNumbers                = generatedControlContainers.find(".event-input-number");
    
    //set category
    generatedControlContainers.each(function(i, obj) {
        $(this).find(".event-input-category").val(category);
    });
    
    //set input number
    inputNumbers.each(function(i, obj) {
        $(this).val(i+1);
    });
    
    console.log(generatedControlContainers.length);
    
}


/* ------------------------------------------ RADIO ------------------------------------------ */

function inputIsRequired(){
    
    var input                       = $(this);
    var eventInputRequiredElement   = $(this).next();
    var eventInputRequiredValue     = parseInt($(this).next().val());
    
    if(eventInputRequiredValue == 0){
        eventInputRequiredElement.val(1);
        input.prop('checked',true);
        
    } else {
        eventInputRequiredElement.val(0);
        input.prop('checked',false);
    }
}


function inputIsAllowedType(){
    
    var contentBox = $(this).parent().parent();
    contentBox.find(".event-input-allow-user-type").val(1);
}



