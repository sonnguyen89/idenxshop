jQuery(document).ready(function($) {
	"use strict";
	
	$(document).on('click', '.klb-load-more', function(event){
		event.preventDefault(); 
        var data = {
			cache: false,
            action: 'load_more',
			beforeSend: function() {
				$('.row.columns-3').append('<div class="klb-load-more loader-image"></div>');
			},
			'current_page': loadmore.current_page,
			'per_page': loadmore.per_page,
			'cat_id': loadmore.cat_id,
			'filter_cat': loadmore.filter_cat,
			'layered_nav': loadmore.layered_nav,
			'on_sale': loadmore.on_sale,
			'orderby': loadmore.orderby,
			'shop_view': loadmore.shop_view,

        };

        // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
		$.post(loadmore.ajaxurl, data, function(response) {
            $('.row.columns-3').append(response);
			loadmore.current_page++;
			
			if ( loadmore.current_page == loadmore.max_page ){
				$('.klb-load-more').remove();
			}
			
			$(".loader-image").remove();
        });
    });	

});