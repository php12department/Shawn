
(function ($) {
"use strict";
$('.product-hover a:last-child').addClass('last');
/*------------------------------------
    01. Sticky Menu
-------------------------------------- */  
    var windows = $(window);
    var stick = $(".header-sticky");
	windows.on('scroll',function() {    
		var scroll = windows.scrollTop();
		if (scroll < 245) {
			stick.removeClass("sticky");
		}else{
			stick.addClass("sticky");
		}
	}); 
    
/*------------------------------------
    02. jQuery MeanMenu
-------------------------------------- */
	$('#mobile-menu-active').meanmenu({
        meanScreenWidth: "991",
        meanMenuContainer: ".mobile-menu-area .mobile-menu",
    });
    
/*----------------------------------------
    03. Owl Carousel
---------------------------------------- */
/*----------------------------------------
    Slider Carousel
---------------------------------------- */
    $('.slider-wrapper').owlCarousel({
        loop:true,
        animateOut: 'fadeOut',
        animateIn: 'fadeIn',
        smartSpeed: 2500,
        items:1,
        nav:false,
        dots: true
    });
/*----------------------------------------
    Product Carousel
---------------------------------------- */
    $('.product-carousel').owlCarousel({
        loop:true,
        items:5,
        nav:true,
        navText : ['<i class="fa fa-angle-left"></i>','<i class="fa fa-angle-right"></i>'],
        responsive:{
            0:{
                items:1
            },
            420:{
                items:2
            },
            600:{
                items:3
            },
            800:{
                items:3
            },
            1024:{
                items:4
            },
            1200:{
                items:5
            }
        }
    });
/*----------------------------------------
    Feature Product Carousel
---------------------------------------- */
    $('.feature-product-carousel').owlCarousel({
        items:5,
        mouseDrag: false,
        responsive:{
            0:{
                items:1,
                mouseDrag: true
            },
            420:{
                items:2,
                mouseDrag: true
            },
            600:{
                items:3,
                mouseDrag: true
            },
            800:{
                items:3,
                mouseDrag: true
            },
            1024:{
                items:4,
                mouseDrag: true
            },
            1200:{
                items:5
            }
        }
    });
/*----------------------------------------
    Blog Carousel
---------------------------------------- */
    $('.blog-carousel').owlCarousel({
        items:3,
        mouseDrag: false,
        responsive:{
            0:{
                items:1,
                mouseDrag: true
            },
            600:{
                items:2,
                mouseDrag: true
            },
            800:{
                items:3
            }
        }
    });
/*----------------------------------------
    Product Carousel Two
---------------------------------------- */
    $('.product-carousel-two').owlCarousel({
        loop:true,
        items:4,
        nav:true,
        navText : ['<i class="fa fa-angle-left"></i>','<i class="fa fa-angle-right"></i>'],
        responsive:{
            0:{
                items:1
            },
            420:{
                items:2
            },
            600:{
                items:3
            },
            800:{
                items:3
            },
            1024:{
                items:3
            },
            1200:{
                items:4
            }
        }
    });
/*----------------------------------------
    Related Product Carousel
---------------------------------------- */
    $('.related-product-carousel').owlCarousel({
        items:4,
        mouseDrag: false,
        nav:false,
        navText : ['<i class="fa fa-angle-left"></i>','<i class="fa fa-angle-right"></i>'],
        responsive:{
            0:{
                items:1,
                mouseDrag: true,
                nav:true
            },
            400:{
                items:2,
                mouseDrag: true,
                nav:true
            },
            600:{
                items:3,
                mouseDrag: true,
                nav:true
            },
            800:{
                items:3,
                mouseDrag: true,
                nav:true
            },
            1024:{
                items:4
            },
            1200:{
                items:4
            }
        }
    });
/*------------------------------------------
    04. ScrollUp
------------------------------------------- */	
	$.scrollUp({
        scrollText: '<i class="fa fa-chevron-up"></i>',
        easingType: 'linear',
        scrollSpeed: 900,
        animation: 'fade'
    });  
    
/*------------------------------------------

    
/*------------------------------------------
    06. Isotope
-------------------------------------------- */  
    $('.grid').isotope({
        itemSelector: '.grid-item',
        percentPosition: true,
        masonry: {
            columnWidth: '.grid-item'
        }
    });    
        
/*----------------------------------------
	07. Slick Slider
------------------------------------------*/
    $('.product-thumbnail-slider').slick({
        autoplay: false,
        infinite: true,
        centerPadding: '0px',
        focusOnSelect: true,
        slidesToShow: 5,
        slidesToScroll: 1,
        asNavFor: '.product-image-slider',
        arrows: false,
    });
    $('.product-image-slider').slick({
        prevArrow: '<button type="button" class="slick-prev"><i class="fa fa-angle-left"></i></button>',
        nextArrow: '<button type="button" class="slick-next"><i class="fa fa-angle-right"></i></button>',
        autoplay: false,
        infinite: true,
        slidesToShow: 1,
        asNavFor: '.product-thumbnail-slider',
    });
    
/*-----------------------------------------
    08. Newletter Modal On Load
----------------------------------------- */ 
    var win = $(window);
    win.on('load', function() {
        $('#newslettermodal').modal('show');
    });	
    
/*------------------------------------
    09. Scroll Down
-------------------------------------- */  
    $('.scroll-down').on('click', function() {
        $('html, body').animate({scrollTop: $('.scroll-area').offset().top - 100 }, 'slow');
        return false;
    });
    
})(jQuery);	

/*------------------------------------
    10. cart page quantity count bar
-------------------------------------- */  

 $(document).ready(function() {
              $('.num-in span').click(function () {
                  var $input = $(this).parents('.num-block').find('input.in-num');
                if($(this).hasClass('minus')) {
                  var count = parseFloat($input.val()) - 1;
                  count = count < 1 ? 1 : count;
                  if (count < 2) {
                    $(this).addClass('dis');
                  }
                  else {
                    $(this).removeClass('dis');
                  }
                  $input.val(count);
                }
                else {
                  var count = parseFloat($input.val()) + 1
                  $input.val(count);
                  if (count > 1) {
                    $(this).parents('.num-block').find(('.minus')).removeClass('dis');
                  }
                }
                
                $input.change();
                return false;
              });
              
            });


/*------------------------------------
    11. checkout page payment method radio button hide show 
-------------------------------------- */  
    function show2(){
        var get_st_needs = $('input[name=inlineRadioOptions]:checked').val();
        // alert(get_st_needs);
        if(get_st_needs == "option1")
        {
            $(".payment-information").show();
        }
        else if(get_st_needs == "option2")
        {
            $(".payment-information").hide();
        }
    }

/*------------------------------------
    12. search box animation
-------------------------------------- */  

// function searchToggle(obj, evt){
//     var container = $(obj).closest('.search-wrapper');
//         if(!container.hasClass('active')){
//             container.addClass('active');
//             evt.preventDefault();
//         }
//         else if(container.hasClass('active') && $(obj).closest('.input-holder').length == 0){
//             container.removeClass('active');
//             // clear input
//             container.find('.search-input').val('');
//         }
// }

    // 05. Wow js
// -------------------------------------------- */    
     new WOW().init();

