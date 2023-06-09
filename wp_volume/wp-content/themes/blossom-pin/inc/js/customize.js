jQuery(document).ready(function($){

    $( 'input[name=blossom-pin-flush-local-fonts-button]' ).on( 'click', function( e ) {
        var data = {
            wp_customize: 'on',
            action: 'blossom_pin_flush_fonts_folder',
            nonce: blossom_pin_cdata.flushFonts
        };  
        $( 'input[name=blossom-pin-flush-local-fonts-button]' ).attr('disabled', 'disabled');

        $.post( ajaxurl, data, function ( response ) {
            if ( response && response.success ) {
                $( 'input[name=blossom-pin-flush-local-fonts-button]' ).val( 'Successfully Flushed' );
            } else {
                $( 'input[name=blossom-pin-flush-local-fonts-button]' ).val( 'Failed, Reload Page and Try Again' );
            }
        });
    });
});

( function( api ) {

	// Extends our custom "example-1" section.
	api.sectionConstructor['blossom-pin-pro-section'] = api.Section.extend( {

		// No events for this type of section.
		attachEvents: function () {},

		// Always make the section active.
		isContextuallyActive: function () {
			return true;
		}
	} );

} )( wp.customize );