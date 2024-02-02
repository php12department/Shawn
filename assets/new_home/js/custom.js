// Banner carousel Js

$('.banner-carousel').slick({
    dots: false,
    infinite: true,
    speed: 500,
    fade: true,
    autoplay: true,
    autoplaySpeed: 2000,
    arrows: true,
    cssEase: 'linear'
  });

  // Project carousel js 

  $('.project-carousel').slick({
    dots: false,
    infinite: true,
    speed: 500,
    fade: true,
    autoplay: false,
    autoplaySpeed: 2000,
    arrows: true,
    cssEase: 'linear'
  });

  // New Arrivals js 

  $('.new-arrivals-carousel').slick({
    dots: true,
    infinite: true,
    centerPadding: '60px',
    autoplay: true,
    autoplaySpeed: 2000,
    speed: 500,
    slidesToShow: 3,
    slidesToScroll: 3,
    responsive: [
      {
        breakpoint: 1024,
        settings: {
          slidesToShow: 3,
          slidesToScroll: 3,
          infinite: true,
          dots: true
        }
      },
      {
        breakpoint: 600,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 2
        }
      },
      {
        breakpoint: 480,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1
        }
      }
    ]
  });

    // Brand carousel js 

    $('.brand-carousel').slick({
      dots: true,
      infinite: true,
      centerPadding: '60px',
      autoplay: true,
      autoplaySpeed: 2000,
      speed: 500,
      slidesToShow: 5,
      slidesToScroll: 5,
      responsive: [
        {
          breakpoint: 1024,
          settings: {
            slidesToShow: 3,
            slidesToScroll: 3,
            infinite: true,
            dots: true
          }
        },
        {
          breakpoint: 600,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 2
          }
        },
        {
          breakpoint: 480,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1
          }
        }
      ]
    });
    

    // Mobile Menu Dropdown JS

    $(function(){
      var $ul   =   $('.sidebar-navigation > ul');
      
      $ul.find('li a').click(function(e){
        var $li = $(this).parent();
        
        if($li.find('ul').length > 0){
          e.preventDefault();
          
          if($li.hasClass('selected')){
            $li.removeClass('selected').find('li').removeClass('selected');
            $li.find('ul').slideUp(400);
            $li.find('a em').removeClass('mdi-flip-v');
          }else{
            
            if($li.parents('li.selected').length == 0){
              $ul.find('li').removeClass('selected');
              $ul.find('ul').slideUp(400);
              $ul.find('li a em').removeClass('mdi-flip-v');
            }else{
              $li.parent().find('li').removeClass('selected');
              $li.parent().find('> li ul').slideUp(400);
              $li.parent().find('> li a em').removeClass('mdi-flip-v');
            }
            
            $li.addClass('selected');
            $li.find('>ul').slideDown(400);
            $li.find('>a>em').addClass('mdi-flip-v');
          }
        }
      });
      
      
      $('.sidebar-navigation > ul ul').each(function(i){
        if($(this).find('>li>ul').length > 0){
          var paddingLeft = $(this).parent().parent().find('>li>a').css('padding-left');
          var pIntPLeft   = parseInt(paddingLeft);
          var result      = pIntPLeft + 10;
          
          $(this).find('>li>a').css('padding-left',result);
        }else{
          var paddingLeft = $(this).parent().parent().find('>li>a').css('padding-left');
          var pIntPLeft   = parseInt(paddingLeft);
          var result      = pIntPLeft + 10;
          
          $(this).find('>li>a').css('padding-left',result).parent().addClass('selected--last');
        }
      });
      
      var t = ' li > ul ';
      for(var i=1;i<=10;i++){
        $('.sidebar-navigation > ul > ' + t.repeat(i)).addClass('subMenuColor' + i);
      }
      
      var activeLi = $('li.selected');
      if(activeLi.length){
        opener(activeLi);
      }
      
      function opener(li){
        var ul = li.closest('ul');
        if(ul.length){
          
            li.addClass('selected');
            ul.addClass('open');
            li.find('>a>em').addClass('mdi-flip-v');
          
          if(ul.closest('li').length){
            opener(ul.closest('li'));
          }else{
            return false;
          }
          
        }
      }
      
    });

    // video popup Js

    $(document).ready(function(){
      if($('.popup-youtube').length ) {
        $('.popup-youtube').magnificPopup({
          type: 'inline',
          midClick: true,
          contentposition: true,
          callbacks: {
            open: function() {
              $(this.content).find('video')[0].play();
            },
            close: function() {
              $(this.content).find('video')[0].load();
            }
          }
        });
      }
    });    