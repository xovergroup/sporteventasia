$(document).ready(function() {
    
            
    getTotalParticipants();
    getGrandTotal();
    getFinalGrandTotal();
    
});

function getFinalGrandTotal(){
    
    var subtotal = parseFloat($(document).find('.subtotal').text());
    var discount = parseFloat($(document).find('.discount').text());
    
    var finalGrandTotal = subtotal - discount;
    $(document).find('.final-grand-total').text(finalGrandTotal)
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








