/* KLB Addons for Elementor v1.0 */

jQuery.noConflict();
!(function ($) {
	"use strict";

	
	/* HOME SLIDER TWO*/
	function klb_home_slider($scope, $) {
		$('.hero-slide-two').not('.slick-initialized').slick({
			dots: false,
			arrows: false,
			infinite: true,
			autoplay: true,
			Speed: 10000,
			fade: true,
			slidesToShow: 1,
			slidesToScroll: 1
		});
	}

	function klb_home_slider_two($scope, $) {
		$('.hero-contnt-slide').not('.slick-initialized').slick({
			dots: false,
			arrows: false,
			infinite: true,
			autoplay: true,
			Speed: 5000,
			fade: true,
			slidesToShow: 1,
			slidesToScroll: 1
		});
	}
	
	
	
	
	function klb_image_carousel($scope, $) {
		$('.company-slide').not('.slick-initialized').slick({
			dots: false,
			arrows: true,
			infinite: true,
			autoplay: true,
			Speed: 10000,
			prevArrow: '<div class="prev"><i class="fal fa-arrow-left"></i></div>',
			nextArrow: '<div class="next"><i class="fal fa-arrow-right"></i></div>',
			slidesToShow: 6,
			slidesToScroll: 1,
			responsive: [{
					breakpoint: 1200,
					settings: {
						arrows: false,
						slidesToShow: 5
					}
				},
				{
					breakpoint: 992,
					settings: {
						arrows: false,
						slidesToShow: 3
					}
				},
				{
					breakpoint: 768,
					settings: {
						arrows: false,
						slidesToShow: 3
					}
				},
				{
					breakpoint: 480,
					settings: {
						arrows: false,
						slidesToShow: 2
					}
				}
			]
		});
	}
	
	function klb_product_carousel($scope, $) {
		$('.best-slide').not('.slick-initialized').slick({
			dots: false,
			arrows: true,
			infinite: true,
			autoplay: true,
			prevArrow: '<div class="prev"><i class="far fa-angle-left"></i></div>',
			nextArrow: '<div class="next"><i class="far fa-angle-right"></i></div>',
			Speed: 10000,
			slidesToShow: 4,
			slidesToScroll: 1,
			responsive: [
				{
					breakpoint: 992,
					settings: {
						arrows: false,
						slidesToShow: 3
					}
				},
				{
					breakpoint: 768,
					settings: {
						arrows: false,
						slidesToShow: 2
					}
				},
				{
					breakpoint: 480,
					settings: {
						arrows: false,
						slidesToShow: 1
					}
				}
			]
		});
	}
	
	function klb_testimonial_carousel($scope, $) {
		$('.testimonial-slide-two').not('.slick-initialized').slick({
			dots: false,
			arrows: false,
			infinite: true,
			autoplay: true,
			Speed: 10000,
			slidesToShow: 3,
			slidesToScroll: 1,
			responsive: [
				{
					breakpoint: 992,
					settings: {
						arrows: false,
						slidesToShow: 2
					}
				},
				{
					breakpoint: 768,
					settings: {
						arrows: false,
						slidesToShow: 1
					}
				},
				{
					breakpoint: 480,
					settings: {
						arrows: false,
						slidesToShow: 1
					}
				}
			]
		});
	}
	
	function klb_client_carousel($scope, $) {
		$('.sponsor-slide').not('.slick-initialized').slick({
			dots: false,
			arrows: false,
			infinite: true,
			autoplay: true,
			Speed: 10000,
			slidesToShow: 6,
			slidesToScroll: 1,
			responsive: [{
					breakpoint: 1200,
					settings: {
						arrows: false,
						slidesToShow: 5
					}
				},
				{
					breakpoint: 992,
					settings: {
						arrows: false,
						slidesToShow: 3
					}
				},
				{
					breakpoint: 768,
					settings: {
						arrows: false,
						slidesToShow: 3
					}
				},
				{
					breakpoint: 480,
					settings: {
						arrows: false,
						slidesToShow: 2
					}
				}
			]
		});
	}
	
	
	/* NICE SELECT */
	function klb_niceselect($scope, $) {
		$('select').niceSelect();
	}



    jQuery(window).on('elementor/frontend/init', function () {

        elementorFrontend.hooks.addAction('frontend/element_ready/chakta-home-slider.default', klb_home_slider);
        elementorFrontend.hooks.addAction('frontend/element_ready/chakta-home-slider-2.default', klb_home_slider_two);
        elementorFrontend.hooks.addAction('frontend/element_ready/chakta-home-slider-3.default', klb_home_slider);
        elementorFrontend.hooks.addAction('frontend/element_ready/chakta-home-slider.default', klb_niceselect);
        elementorFrontend.hooks.addAction('frontend/element_ready/chakta-home-slider-2.default', klb_niceselect);
        elementorFrontend.hooks.addAction('frontend/element_ready/chakta-home-slider-3.default', klb_niceselect);
        elementorFrontend.hooks.addAction('frontend/element_ready/chakta-image-carousel.default', klb_image_carousel);
        elementorFrontend.hooks.addAction('frontend/element_ready/chakta-product-carousel.default', klb_product_carousel);
        elementorFrontend.hooks.addAction('frontend/element_ready/chakta-testimonial.default', klb_testimonial_carousel);
        elementorFrontend.hooks.addAction('frontend/element_ready/chakta-client-carousel.default', klb_client_carousel);

    });

})(jQuery);
