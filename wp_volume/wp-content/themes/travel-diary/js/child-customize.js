jQuery(document).ready(function($) {
    $('#sub-accordion-section-slider_layout_settings').on( 'click', '.slider_banner_layout_text', function(e){
        e.preventDefault();
        wp.customize.control( 'ed_banner_section' ).focus();        
    }); 

    $('#sub-accordion-section-header_image').on( 'click', '.slider_banner_text', function(e){
        e.preventDefault();
        wp.customize.control( 'slider_layout' ).focus();        
    }); 
});