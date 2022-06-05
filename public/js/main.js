$(function(){
    "use strict";
    //------- fixed navbar --------//  
    $(window).scroll(function () {
        var sticky = $('.main-header'),
            scroll = $(window).scrollTop();
        if (scroll >= 100) {
            $('.img-nav').addClass('img-nav-fixed')
            sticky.addClass('position-fixed');
            $('.header-cv').css('display','initial')
        }
        else {
            sticky.removeClass('position-fixed');
            $('.header-cv').css('display','none')
            $('.img-nav').removeClass('img-nav-fixed');
        }
    });
    // scroll to top
    $(document).on('click', '#mainMenu li a', function () {
        $('#mainMenu li a.active').removeClass('active')
        $(this).addClass('active')
    })
    AOS.init();

    //scroll active
    
})