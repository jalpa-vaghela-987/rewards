jQuery(document).ready(function($) {

/*------------------------------------------------
            DECLARATIONS
------------------------------------------------*/

    var menu_toggle = $('.menu-toggle');
    var scroll = $(window).scrollTop();  
    var scrollup = $('.backtotop');
    var nav_menu = $('.main-navigation ul.nav-menu');
    var featured_slider = $('.featured-slider-wrapper');
    var testimonial_slider = $('.testimonial-slider');
    var posts_height = $('.blog-posts-wrapper article .post-item');

    /*------------------------------------------------
            BACK TO TOP
    ------------------------------------------------*/

    $(window).scroll(function() {
        if ($(this).scrollTop() > 1) {
            scrollup.css({bottom:"25px"});
        } 
        else {
            scrollup.css({bottom:"-100px"}); 
        }
    });

    scrollup.click(function() {
        $('html, body').animate({scrollTop: '0px'}, 800);
        return false;
    });


/*------------------------------------------------
            MAIN NAVIGATION
------------------------------------------------*/

    menu_toggle.click(function(){
        nav_menu.slideToggle();
    });

    $('.main-navigation .nav-menu .menu-item-has-children > a').after( $('<button class="dropdown-toggle"><i class="fa fa-angle-down"></i></button>') );

    $('button.dropdown-toggle').click(function() {
        $(this).toggleClass('active');
       $(this).parent().find('.sub-menu').first().slideToggle();
    });

     $(window).scroll(function() {
        if ($(this).scrollTop() > 1) {
            $('.menu-sticky #masthead').addClass('nav-shrink');
        }
        else {
            $('.menu-sticky #masthead').removeClass('nav-shrink');
        }
    });

     if( $(window).width() < 1024 ) {
        $( '#primary-menu > li:last-child' ).bind( 'keydown', function(e) {
            if( e.which === 9 ) {
                e.preventDefault();
                $('#masthead').find('.menu-toggle').focus();
            }
        });
    }
    else {
        $( '#primary-menu > li:last-child' ).unbind('keydown');
    }
    $(window).resize(function() {
        if( $(window).width() < 1024 ) {
            $( '#primary-menu > li:last-child' ).bind( 'keydown', function(e) {
                if( e.which === 9 ) {
                    e.preventDefault();
                    $('#masthead').find('.menu-toggle').focus();
                }
            });
        }
        else {
            $( '#primary-menu > li:last-child' ).unbind('keydown');
        }
    });
/*------------------------------------------------
            SLICK SLIDER
------------------------------------------------*/

    featured_slider.slick();
    testimonial_slider.slick({
        responsive: [{
            breakpoint: 1200,
                settings: {
                    slidesToShow: 2
                }
            },
            {
            breakpoint: 767,
                settings: {
                    slidesToShow: 1
                }
            },
            {
            breakpoint: 480,
                settings: {
                slidesToShow: 1,
                slidesToScroll: 1
            }
        }]
    });

    $('.posts-slider').slick({
    responsive: [{
        breakpoint: 1024,
            settings: {
            slidesToShow: 2
        }
    },
    {
        breakpoint: 767,
        settings: {
            slidesToShow: 1
        }
    }]
});

    
/*------------------------------------------------
            MATCH HEIGHT
------------------------------------------------*/

    posts_height.matchHeight();
    $('#courses article').matchHeight();


/*------------------------------------------------
                END JQUERY
------------------------------------------------*/

});