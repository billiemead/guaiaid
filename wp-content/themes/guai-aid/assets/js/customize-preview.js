(function( $ ) {
	// Link color hue.
	wp.customize( 'guai_aid_link_color', function( value ) {
		value.bind( function( to ) {
			$( 'body.custom-background a').css('color',to);
		});
	});
	wp.customize( 'guai_aid_text_color', function( value ) {
		value.bind( function( to ) {
			$( 'body.custom-background').css('color',to);
		});
	});
})( jQuery );