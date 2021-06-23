require(['jquery'], function() {       
    jQuery(window).load(function() {
        setTimeout(function(){  
            if(!jQuery('.nav-sections').hasClass('menu-loaded')){
                jQuery('.nav-sections').addClass('menu-loaded');
                
                jQuery('.nav-toggle').click(function() {
                    jQuery('.nav-sections').toggleClass('nav-visible');
                });

                jQuery('.nav-sections').mouseleave(function (e){
                    jQuery(this).removeClass('nav-visible');
                });    
            }         
        }, 700);
    });

    jQuery(document).ready(function() {
        setTimeout(function(){  
            if(!jQuery('.nav-sections').hasClass('menu-loaded')){
                jQuery('.nav-sections').addClass('menu-loaded');

                jQuery('.nav-toggle').click(function() {
                    jQuery('.nav-sections').toggleClass('nav-visible');
                });

                jQuery('.nav-sections').mouseleave(function (e){
                    jQuery(this).removeClass('nav-visible');
                });    
            }                       
        }, 700);
    });
});