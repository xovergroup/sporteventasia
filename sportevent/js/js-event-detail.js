document.write('<link href="css/style.css?v='+ Math.floor(Math.random()*100) +'" rel="stylesheet" type="text/css" />');
//$(".header").css({'position':'initial'});

if(window.innerWidth >= 800) {
     $(window).scroll( function() {
        var value = $(this).scrollTop();
        if ( value > 500 ){
            $(".event-header").fadeIn();
            $(".header").hide();
        }else{
            $(".event-header").hide();
            $(".header").show();
        }
    });
}

var swiper = new Swiper('.swiper-event-merchandise', {
  slidesPerView: 4,
  spaceBetween: 30,
  loop: false,
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
      spaceBetween: 30,
    },
    640: {
      slidesPerView: 2,
      spaceBetween: 10,
    },
    320: {
      slidesPerView: 1.2,
      spaceBetween: 10,
    }
  }
});

var swiper = new Swiper('.swiper-event-news', {
  slidesPerView: 3,
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
  scrollbar: {
    el: '.swiper-scrollbar',
    hide: true,
  },

  breakpoints: {
    1024: {
      slidesPerView: 3,
      spaceBetween: 30,
    },
    768: {
      slidesPerView: 2,
      spaceBetween: 30,
    },
    640: {
      slidesPerView: 1,
      spaceBetween: 30,
    },
    320: {
      slidesPerView: 1,
      spaceBetween: 20,
    }
  }
});

$(function() {
    $('.btn-prev').click(function(){
        var clicks = $(this).data('clicks');
        if (clicks) {
            tagRow1();
        } else {
            tagRow2();
        }
        $(this).data("clicks", !clicks);
    });
});

$('.register-box-outer').click(function() {
    var selectedTick = $(this).find('.register-tick');
    $(this).css({
        'border': '3px solid #e33f2c'
    });
    selectedTick.css({
        'display': 'block'
    });
    $('.register-box-outer').not(this).css({
        'border': '3px solid white'
    });
    $('.register-tick').not(selectedTick).css({
        'display': 'none'
    });

});

$(".event-category-table tr").click(function(){
   $(this).addClass('event-category-selected').siblings().removeClass('event-category-selected'); 
   //var value=$(this).find('td:first').html();
   //alert(value);    
});