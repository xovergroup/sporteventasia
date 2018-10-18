$(document).ready(function() {
    
    $('body').on('click', '.select-category', selectCategory);
    $('body').on('click', '.add-one', addOne);
    $('body').on('click', '.minus-one', minusOne);
    $('body').on('click', '.go-to-fill-information', goToFillInformation);
    
    
});

function goToFillInformation(e){
    
    e.preventDefault();
    
    //remove class
    $('.go-to-fill-information').removeClass('go-to-fill-information');
    
    var grandTotal = getGrandTotal();
    if(grandTotal == 0){
        swalCustomMessage('error', 'Something went wrong!', 'Please select at least 1 category.');
    } else {
        var action = 'registerEventFormOne';
        var selectedCategory = getDataFromLocalStorage('selectedCategory');
        var selectedCategory = JSON.stringify(selectedCategory[0]);
        var eventId = $('.event-name').attr('data-event');
        
        //console.log(selectedCategory);
        
        $.ajax({
            type: "POST",
            url: "submits/submit-event-registration-form-1.php",
            data: {
                action:action,
                selectedCategory:selectedCategory
            },
            dataType:'JSON', 
            success: function(result){

                
                console.log(result);
                
                //redirect to 2nd page
                if(result.status == 'Success'){
                    window.location.href = "http://x-cow.com/sportevent/event-registration-form-2.php?event_id="+eventId;
                }
                
                
            } 
        });
    }
    
}

function getGrandTotal(){
    
    var grandTotal = 0;
    var grandTotalElement = $(document).find('.grand-total');
    if(grandTotalElement.length > 0){
        grandTotal = parseFloat(grandTotalElement.text());
    }
    
    return grandTotal;
    
}

function getDataFromLocalStorage(key) {
    
    var array;
    
    if(localStorage.getItem(key) === null) {
        array = [];
    } else {
        array = JSON.parse(localStorage.getItem(key));
    }
    return array;
}

function addDataToLocalStorage(key, value){
    
    var array =  [];
    
    array.push(value);
    
    localStorage.setItem(key, JSON.stringify(array));
     
}

function processCalcAndCart(){
    
    var categories = $(document).find('.each-category'); 
    if(categories.length > 0){
        
        var subTotals = 0;
        var totalPax = 0;
        var subTotalsForDisplay = 0;
        var totalPaxForDisplay = 0;
        var html = '';
        var dataArray = [];
        categories.each(function(i, obj) {
            var id = parseInt($(this).attr('data-id'));
            var price = parseFloat($(this).attr('data-price'));
            var quantity = parseInt($(this).attr('data-quantity'));
            var categoryNo = parseInt($(this).attr('data-category'));
            var pax = parseInt($(this).find('.category-pax').text());
            var categoryName = $(this).find('.category-name').text();

            subTotals += price * quantity;
            totalPax += quantity * pax;
            subTotalsForDisplay = price * quantity;
            totalPaxForDisplay = quantity * pax;
            
            //cart dropdown || prepare to save to LS
            if(quantity > 0){
                
                html += `
                    <div class="bg-white row m-1 p-2">
                        <div class="col-md">
                            <h4>${categoryName}</h4>
                            <p class="txt-orange">${totalPaxForDisplay} Pax</p>
                        </div>
                        <div class="col-md-auto">
                            <h5>RM ${subTotalsForDisplay}</h5>
                        </div>
                    </div>
                `;
                
                
                var selectedCategoryData = {
                    id:id,
                    price:price,
                    quantity:quantity,
                    pax:pax,
                    categoryName:categoryName,
                    categoryNo:categoryNo
                }
                dataArray.push(selectedCategoryData);
            }
            
        });
        
        //set grand total
        var grandTotal = subTotals;
        $(document).find('.grand-total').text(grandTotal);
        $(document).find('.dropdown-grand-total').text(grandTotal);
        
        //set pax total
        $(document).find('.total-pax').text(totalPax);
        
        //dropdown
        var dropdown = $(document).find('.price-dropdown-inner');
        dropdown.empty();
        dropdown.append(html);
        
        //save to ls
        addDataToLocalStorage('selectedCategory', dataArray);
    }
    
}

function processSelectedCategory(tr){
    
    var earlyBirdPriceElement = tr.find('.price-early-bird');
    var normalPriceElement = tr.find('.price-normal');
    
    //check early bird price
    if(earlyBirdPriceElement.length > 0){
        var price = parseFloat(earlyBirdPriceElement.text());
        var earlyBirdPriceStatus = true;
    } else {
        
        var earlyBirdPriceStatus = false;
        
        if(normalPriceElement.length > 0){
            var price = parseFloat(normalPriceElement.text());
        }
    }
    
    tr.attr('data-price', price);
    tr.attr('data-earlyBird', earlyBirdPriceStatus);
    tr.attr('data-quantity', 1);
    
    processCalcAndCart();
    
}

function selectCategory(e){
    
    e.preventDefault();
    
    var html = `
        <div class="number-input">
            <button class="bg-dgray txt-black minus-one"></button>
            <input class="quantity" min="0" name="quantity" value="1" type="number">
            <button class="plus add-one"></button>
        </div>
    `;
    
    var td = $(this);
    var tr = $(this).parent();
    
    td.removeClass('select-category'); //have to remove or cannot click add/subtract button
    td.empty();
    td.append(html);
    
    processSelectedCategory(tr);
    
}

function addOne(e){
    
    e.preventDefault();
    
    //add one to input
    var input = $(this).prev();
    var addByOne = parseInt(input.val()) + 1;
    input.val(addByOne);
    
    //add one to tr element
    var tr = $(this).parent().parent().parent();
    var prevQuantity = parseInt(tr.attr('data-quantity'));
    var newQuantity = prevQuantity + 1;
    tr.attr('data-quantity', newQuantity);
    
    processCalcAndCart();
}

function minusOne(e){
    
    e.preventDefault();
    
    var input = $(this).next();
    var minusByOne = parseInt(input.val()) - 1;
    
    var tr = $(this).parent().parent().parent();
    var prevQuantity = parseInt(tr.attr('data-quantity'));
    
    if(minusByOne < 1){
        var html = `<button class="bg-red no-border p-3 txt-white font-dagger col-6">Select</button>`;
        
        var td = $(this).parent().parent();
        td.addClass('select-category'); //add back to allow clicking event
        td.empty();
        td.append(html);
        
        //zero to tr element
        tr.attr('data-quantity', 0);
        
    } else {
        //minus one to input
        input.val(minusByOne);
        
        //minus one to tr element
        var newQuantity = prevQuantity - 1;
        tr.attr('data-quantity', newQuantity);
    }
    
    processCalcAndCart();
 
}

function swalCustomMessage(type, title, text){
    
    swal({
      type: type,
      title: title,
      text: text
    });
}







