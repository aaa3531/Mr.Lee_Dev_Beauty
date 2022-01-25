$(document).ready(function(){
    var mainMenuBtn = $('#main-menu-btn');
    var mainNav = $('.main-nav');
    var closeMainBtn = $('.close-menu');
    var sel = 0;
    mainMenuBtn.click(function(){
        mainMenuBtn.toggleClass('open');
        mainNav.toggleClass('open');
        $('.main-nav > ul > li:first-child').find('.sub').addClass('view');
        $('.main-nav > ul > li:first-child').addClass('focus');
    });
    closeMainBtn.click(function(){
        mainMenuBtn.toggleClass('open');
        mainNav.toggleClass('open');
        sel = 0;
    })
    var mainnavLi = $('.main-nav > ul > li');
    mainnavLi.each(function(index,item){
        var subMenu = $(this).find('.sub');      
        $('.main-nav > ul > li:first-child').find('.sub').addClass('view');
        $('.main-nav > ul > li:first-child').addClass('focus');
        $(this).mouseenter(function(){
            $('.main-nav > ul > li:first-child').find('.sub').removeClass('view');
            $('.main-nav > ul > li:first-child').removeClass('focus');
            subMenu.addClass('view');
            $(this).addClass('focus');
        });
        $(this).mouseleave(function(){
            subMenu.removeClass('view');
            $(this).removeClass('focus');
        });
        mainNav.mouseleave(function(){
           $('.main-nav > ul > li:first-child').find('.sub').addClass('view');
            $('.main-nav > ul > li:first-child').addClass('focus');
           subMenu.removeClass('view'); 
           $(this).removeClass('focus');
        });
    var mainsubnavLi = $('.main-nav > ul > li > ul.sub > li');
    mainsubnavLi.each(function(index,item){
        var sub2Menu = $(this).find('.sub-2');
        $(this).mouseenter(function(){
            sub2Menu.addClass('view');
            $(this).addClass('focus');
        });
        $(this).mouseleave(function(){
            sub2Menu.removeClass('view');
            $(this).removeClass('focus');
        });
        mainNav.mouseleave(function(){
           sub2Menu.toggleClass('view');
            $(this).removeClass('focus');
        });
    });
    });
    
});