$(document).ready(function() {
	
	//Mouse cursor js
	$('#main-body').on('mousedown mouseup', function mouseState(e) {
        if (e.type == "mousedown") {
            $('#main-body').addClass('cursorClicked');
			$('#main-body').removeClass('curosrNormal');
        }else{
			$('#main-body').addClass('curosrNormal');
			$('#main-body').removeClass('cursorClicked');
		}
    });
	
	//Mobile view menu
	$('.btn-menu').click(function(){
		$('.full-menu').css({'right':'0%'});
	});
	
	$('#close-menu').click(function(){
		$('.full-menu').css({'right':'-100%'});
	});
	
	//Most rating organizer slider js
	var swiper = new Swiper('.swiper-index-org', {
	  slidesPerView: 4,
	  spaceBetween: 30,
	  loop: false,
	  autoplay: {
		delay: 2500,
	  },
	  pagination: {
		el: '.swiper-pagination',
		clickable: true,
	  },
	  navigation: {
		nextEl: '.swiper-button-next',
		prevEl: '.swiper-button-prev',
	  },
	  
	  breakpoints: {
		1024: {
		  slidesPerView: 4,
		  spaceBetween: 30,
		},
		768: {
		  slidesPerView: 2,
		  spaceBetween: 20,
		},
		640: {
		  slidesPerView: 1,
		  spaceBetween: 20,
		},
		320: {
		  slidesPerView: 1,
		  spaceBetween: 10,
		}
	  }
	});
	
	//Most event registration form category slider js
	var swiper = new Swiper('.swiper-event-category', {
	  slidesPerView: 'auto',
	  spaceBetween: 5,
	  loop: false,
	  scrollbar: {
		el: '.swiper-scrollbar',
		hide: false,
	  },
	  freeMode: true,
	  
	  breakpoints: {
		1024: {
		  slidesPerView: 'auto',
		  spaceBetween: 5,
		},
		768: {
		  slidesPerView:'auto',
		  spaceBetween: 5,
		},
		640: {
		  slidesPerView: 'auto',
		  spaceBetween: 5,
		},
		320: {
		  slidesPerView:'auto',
		  spaceBetween: 5,
		}
	  }
	});
	
    
    
    
});
