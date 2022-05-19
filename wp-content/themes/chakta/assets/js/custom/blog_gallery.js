(function ($) {
  "use strict";

	$(document).ready(function () {
		$('.blog-gallery').slick({
			dots: false,
			arrows: false,
			infinite: true,
			autoplay: true,
			Speed: 5000,
			fade: true,
			slidesToShow: 1,
			slidesToScroll: 1
		});

	});

})(jQuery);
