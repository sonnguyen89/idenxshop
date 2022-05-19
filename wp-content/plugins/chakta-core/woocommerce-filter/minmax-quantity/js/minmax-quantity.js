(function ($) {
	"use strict";
  
	$(document).ready(function() {
		$( 'input#_klb_quantity_check' ).on( 'change', function() {
			if ( $( this ).is( ':checked' ) ) {
				$( 'div.quantity_fields' ).show();
			} else {
				$( 'div.quantity_fields' ).hide();
			}
		}).trigger( 'change' );
	});
	
})(jQuery);