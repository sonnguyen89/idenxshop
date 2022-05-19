jQuery(document).ready(function($) {
	"use strict";

	$(document).on('click', 'a.detail-bnt', function(event){
		event.preventDefault(); 
        var data = {
            action: 'quick_view',
			beforeSend: function() {
				$('body').append('<div class="loader-overlay"></div><div class="loader-image"></div>');
			},
			'id': $(this).attr('href'),
        };

        // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
		$.post(MyAjax.ajaxurl, data, function(response) {
            $.magnificPopup.open({
                type: 'inline',
                items: {
                    src: response
                }
            })
			
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
		
			
			$("form.cart.grouped_form .input-text.qty").attr("value", "0");
			
			$( document.body ).trigger( 'chaktaSinglePageInit' );
			
			$(".loader-image").remove();
			$(".loader-overlay").remove();
			
			$('.input-text.qty').closest('.ajax_quick_view').find( '.input-text.qty' ).val($('.input-text.qty').closest('.ajax_quick_view').find( '.input-text.qty' ).attr('min'));
			
        });
    });	

});