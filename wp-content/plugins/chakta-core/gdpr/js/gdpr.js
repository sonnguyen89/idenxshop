(function ($) {
  "use strict";
  
		var body = $( 'body' );
		var popup = $( '.gdpr-content' );
		var popupClose = $( '.gdpr-content .btn' );
		var expiresDate = popup.data( 'expires' );


		if ( !( Cookies.get( 'cookie-popup-visible' ) ) ) {
			window.addEventListener('DOMContentLoaded', (event) => {
			popup.addClass( 'active' );
			});
		}

		 popupClose.on( 'click', function(e) {
			e.preventDefault();
			Cookies.set( 'cookie-popup-visible', 'disable', { expires: expiresDate, path: '/' });
			$('.gdpr-content').remove();
			popup.removeClass( 'active' );
			$.cookie("klb_gdpr", 'accepted');
		});
				

}(jQuery));
