function readURL(input) {
    if (input.files && input.files[0]) {

        var reader = new FileReader();

        reader.onload = function(e) {
              $('.image-upload-wrap').hide();

              $('.file-upload-image').attr('src', e.target.result);
              $('.file-upload-content').show();

              $('.image-title').html(input.files[0].name);
        };

        reader.readAsDataURL(input.files[0]);

    } else {
        removeUpload();
    }
}

function removeUpload() {
    $('.file-upload-input').replaceWith($('.file-upload-input').clone());
    $('.file-upload-content').hide();
    $('.image-upload-wrap').show();
}


$('.image-upload-wrap').bind('dragover', function () {
    $('.image-upload-wrap').addClass('image-dropping');
});
$('.image-upload-wrap').bind('dragleave', function () {
    $('.image-upload-wrap').removeClass('image-dropping');
});

$('.btn-menu').click(function(){
	var clicks = $(this).data('clicks');
	if (clicks) {
		$('.sidebar').css({'left':'0%'});
		$('.main-body').css({'width':'80%'});
		$('.main-body').css({'margin-left':'20%'});
	} else {
		$('.sidebar').css({'left':'-20%'});
		$('.main-body').css({'width':'100%'});
		$('.main-body').css({'margin-left':'0%'});
	}
	$(this).data("clicks", !clicks);
});

$('.btn-menu-mobile').click(function(){
	var clicks = $(this).data('clicks');
	if (clicks) {
		$('.sidebar').css({'left':'-100%'});
		$('.main-body').css({'width':'100%'});
		$('.main-body').css({'margin-left':'0%'});
	} else {
		$('.sidebar').css({'left':'0%'});
		$('.main-body').css({'width':'80%'});
		$('.main-body').css({'margin-left':'80%'});
	}
	$(this).data("clicks", !clicks);
});


if($('[type="date"]').length >0){
    
    if ( $('[type="date"]').prop('type') != 'date' ) {
        $('[type="date"]').datepicker();
    }

}

if($('[type="time"]').length >0){
    if ( $('[type="time"]').prop('type') != 'time' ) {
        $('[type="time"]').timepicker();
    }
    
}
    
    