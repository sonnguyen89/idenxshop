jQuery(document).ready(function($) {
	"use strict";
	
	$('form#klb-vehicle-filter select#make-select').on('change',function(){
        var data = {
			cache: false,
            action: 'klb_models_output',
			beforeSend: function () {
				$('.select-model-wrap').append('<div class="loader-ajax"></div>');
			},
			selected_id : $(this).children(":selected").attr("value"),

        };

        // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
		$.post(MyAjax.ajaxurl, data, function(response) {
			$('select#model-select').html(response);
			$('select#model-select').removeAttr('disabled');
			$('select#klb_year').removeAttr('disabled');
			$('.model-select select, .select-year select').niceSelect('update');
			$('.loader-ajax').remove();
        });
    });
	
	$('form#klb-vehicle-filter').submit(function() {
		$(this).find(':input').filter(function() { return !this.value; }).attr('disabled', 'disabled');
		return true; // make sure that the form is still submitted
	});
});