jQuery(document).ready(function($){

    var rtl;
    
    if ( travel_diary_data.rtl == '1' ) {
        rtl = true;
    } else {
        rtl = false;
    }

    $('.banner-layout-eight').owlCarousel({
        loop: true,
        autoplay: true,
        nav: true,
        dots: false,
        rtl: rtl,
        items: 1,
        margin: 8,
        thumbs: false,
        navText: ['<svg xmlns="http://www.w3.org/2000/svg" viewBox="-19991 -11813 18 12"><path id="path" class="cls-1" d="M353.6,392.8v2H339.4l3.6,3.6-1.4,1.4-6-6,6-6,1.4,1.4-3.6,3.6Z" transform="translate(-20326.6 -12200.8)"/></svg> ', ' <svg xmlns="http://www.w3.org/2000/svg" viewBox="-18147 -11813 18 12"><path id="path" class="cls-1" d="M353.6,392.8v2H339.4l3.6,3.6-1.4,1.4-6-6,6-6,1.4,1.4-3.6,3.6Z" transform="translate(-17793.4 -11413.2) rotate(180)"/></svg> '],
        autoplaySpeed : 800,
        responsive:{
            768: {
                stagePadding: 20

            },
            1200: {
                stagePadding: 150
            },
            1400: {
                stagePadding: 235
            }
        }
    });

});



