
jQuery(document).ready(function ($) {
   var count = 2;
   var total = loadmore.max_page;
   
	$(window).data('ajaxready', true).scroll(function(e) {
		if ($(window).data('ajaxready') == false) return;
		
		if($(window).scrollTop() >= $('.shop-grid-v2 .row.columns-3').offset().top + $('.shop-grid-v2 .row.columns-3').outerHeight() - window.innerHeight) {
			$(window).data('ajaxready', false);

			if (count > total) {
				return false;
			} else {
				klb_infinite_pagination(count);
			}
			
			count++;
		 }
		
	});

   function klb_infinite_pagination() {
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
			$(window).data('ajaxready', true);
        });

     return false;
   }
 });