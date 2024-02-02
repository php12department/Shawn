var swiper = new Swiper('.hero-banner', {
    speed:1000,
    autoplay: {
        delay: 3000,
    },
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },
  });

  AOS.init();