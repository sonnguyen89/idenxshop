(function ($) {
  "use strict";

	$(document).ready(function () {
 
		

		const qty = () => {

			const quantityButtons = document.querySelectorAll( '.qtybutton' );

			quantityButtons.forEach( (index) => {
			  index.addEventListener( 'click', (event) => {
				let quantity = event.target.closest( '.quantity' );
				let quantityInput = quantity.querySelector( '.input-text.qty' );
				
				let val = parseFloat( quantityInput.value );
				let min = parseFloat( quantityInput.min );
				let max = parseFloat( quantityInput.max );
				let step = parseFloat( quantityInput.step );

				if ( ! val || val === '' || val === 'NaN' ) { val = 0; }
				if ( max === '' || max === 'NaN' ) { max = ''; }
				if ( min === '' || min === 'NaN' ) { min = 0; }
				if ( step === 'any' || step === '' || step === undefined || parseFloat( step ) === 'NaN' ) { step = 1; }

				if ( event.target.classList.contains( 'inc' ) ) {
				  if ( max && ( max === val || val > max ) ) {
					quantityInput.value = max;
				  } else {
					quantityInput.value = val + parseFloat( step );
				  }
				} else {
				  if ( min && ( min === val || val < min ) ) {
					quantityInput.value = min;
				  } else {
					quantityInput.value = val - parseFloat( step );
				  }
				}
				$('.quantity .qty').trigger( 'change' );
				return false;
			  });
			  
			});

		}

		qty();
		
		$('body').on( 'updated_cart_totals', qty );
 
 
	});

})(jQuery);
