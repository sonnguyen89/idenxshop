
(function ($) {
	"use strict";
	
    // Document Ready
    $(document).ready(function() {
        mainmenu_init();
        sidebarmenu_init();
        magnificpopup_init();
        backtotop_init();
        niceselect_init();
		hero_sliderthree_init();
		trendy_slide_init();
		popular_slider_init();
		offer_slider_init();
		offer_slider_two_init();
		testimonial_slide_one_init();
		testimonial_slide_three_init();
		feature_slide_init();
		service_slide_init();
		shop_big_slide_init();
		shop_thumb_slide_init();
    });

    //===== Prealoder
    $(window).on('load', function(event) {
        $('.preloader').delay(500).fadeOut('500');
    })

    //===== Sticky
    $(window).on('scroll', function(event) {
        var scroll = $(window).scrollTop();
        if (scroll < 190) {
            $(".header-navigation").removeClass("sticky");
        } else {
            $(".header-navigation").addClass("sticky");
        }
    });
	
    //===== Back to top
    $(window).on('scroll', function(event) {
        if ($(this).scrollTop() > 600) {
            $('.back-to-top').fadeIn(200)
        } else {
            $('.back-to-top').fadeOut(200)
        }
    });
	
    //===== 01. Main Menu
    function mainmenu_init() {
        // Variables
        var var_window = $(window),
            navContainer = $('.nav-container'),
            pushedWrap = $('.nav-pushed-item'),
            pushItem = $('.nav-push-item'),
            pushedHtml = pushItem.html(),
            pushBlank = '',
            navbarToggler = $('.navbar-toggler'),
            navMenu = $('.nav-menu'),
            navMenuLi = $('.nav-menu ul li ul li'),
            closeIcon = $('.navbar-close');
        // navbar toggler
        navbarToggler.on('click', function() {
            navbarToggler.toggleClass('active');
            navMenu.toggleClass('menu-on');
        });
        // close icon
        closeIcon.on('click', function() {
            navMenu.removeClass('menu-on');
            navbarToggler.removeClass('active');
        });

        // adds toggle button to li items that have children
        navMenu.find('li a').each(function() {
            if ($(this).next().length > 0) {
                $(this)
                    .parent('li')
                    .append(
                        '<span class="dd-trigger"><i class="fas fa-angle-down"></i></span>'
                    );
            }
        });
        // expands the dropdown menu on each click
        navMenu.find('li .dd-trigger').on('click', function(e) {
            e.preventDefault();
            $(this)
                .parent('li')
                .children('ul')
                .stop(true, true)
                .slideToggle(350);
            $(this).parent('li').toggleClass('active');
        });

        // check browser width in real-time
        function breakpointCheck() {
            var windoWidth = window.innerWidth;
            if (windoWidth <= 1199) {
                navContainer.addClass('breakpoint-on');

                pushedWrap.html(pushedHtml);
                pushItem.hide();
            } else {
                navContainer.removeClass('breakpoint-on');

                pushedWrap.html(pushBlank);
                pushItem.show();
            }
        }

        breakpointCheck();
        var_window.on('resize', function() {
            breakpointCheck();
        });
    };


    //====== Sidebar menu
	function sidebarmenu_init(){
		$.sidebarMenu = function(menu) {
		  var animationSpeed = 300,
		  subMenuSelector = '.sub-menu';
		  $(menu).on('click', 'li a', function(e) {
			var $this = $(this);
			var checkElement = $this.next();

			if (checkElement.is(subMenuSelector) && checkElement.is(':visible')) {
			  checkElement.slideUp(animationSpeed, function() {
				checkElement.removeClass('menu-open');
			  });
			  checkElement.parent("li").removeClass("active");
			}
			//If the menu is not visible
			else if ((checkElement.is(subMenuSelector)) && (!checkElement.is(':visible'))) {
			  var parent = $this.parents('ul').first();
			  var ul = parent.find('ul:visible').slideUp(animationSpeed);
			  ul.removeClass('menu-open');
			  var parent_li = $this.parent("li");
			  checkElement.slideDown(animationSpeed, function() {
				checkElement.addClass('menu-open');
				parent.find('li.active').removeClass('active');
				parent_li.addClass('active');
			  });
			}
			if (checkElement.is(subMenuSelector)) {
			  e.preventDefault();
			}
		  });
		};

		$(".menu-icon,.cross-icon,.panel-overly").on('click', function (e) {
		  e.preventDefault();
		  $(".sidebar-sidemenu").toggleClass("active");
		});
		$.sidebarMenu($('.sidebar-menu'))
	};
	
    //====== Magnific Popup
	function magnificpopup_init(){
		$('.video-popup').magnificPopup({
			type: 'iframe'
		});

	
		$('.img-popup').magnificPopup({
			type: 'image',
			gallery: {
				enabled: true
			}
		});
	};


    //Animate the scroll to top
	function backtotop_init(){
		$('.back-to-top').on('click', function(event) {
			event.preventDefault();
			$('html, body').animate({
				scrollTop: 0,
			}, 1500);
		});
	};
	
    // jquery nice select js
	function niceselect_init(){
		$('select').niceSelect();
	}
	
	function hero_sliderthree_init(){
		$('.hero-slide-three').not('.slick-initialized').slick({
			dots: false,
			arrows: false,
			infinite: true,
			autoplay: true,
			Speed: 500,
			fade: true,
			slidesToShow: 1,
			slidesToScroll: 1
		});
	};
	
	function trendy_slide_init(){
		$('.trendy-slide').not('.slick-initialized').slick({
			dots: false,
			arrows: true,
			infinite: true,
			autoplay: true,
			prevArrow: '<div class="prev"><i class="far fa-angle-left"></i></div>',
			nextArrow: '<div class="next"><i class="far fa-angle-right"></i></div>',
			Speed: 2500,
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
	};
	
	function popular_slider_init(){
		var sliderArrows = $('.arrows');
		$('.popular-slide').not('.slick-initialized').slick({
			dots: false,
			arrows: true,
			infinite: true,
			autoplay: true,
			Speed: 2500,
			appendArrows: sliderArrows,
			prevArrow: '<div class="prev"><i class="far fa-angle-left"></i></div>',
			nextArrow: '<div class="next"><i class="far fa-angle-right"></i></div>',
			slidesToShow: 4,
			slidesToScroll: 1,
			responsive: [
				{
					breakpoint: 1024,
					settings: {
						arrows: false,
						slidesToShow: 2
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
	};
	
	function offer_slider_init(){
		$('.offer-slide').not('.slick-initialized').slick({
			dots: false,
			arrows: false,
			infinite: true,
			autoplay: true,
			Speed: 2500,
			slidesToShow: 3,
			slidesToScroll: 1,
			responsive: [
				{
					breakpoint: 1200,
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
	};
	
	function offer_slider_two_init(){
		$('.offer-slide-two').not('.slick-initialized').slick({
			dots: false,
			arrows: false,
			infinite: true,
			autoplay: true,
			Speed: 2500,
			slidesToShow: 3,
			slidesToScroll: 1,
			responsive: [
				{
					breakpoint: 1200,
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
	};
	
	function offer_slider_two_init(){
		$('.testimonial-thumb-slide').not('.slick-initialized').slick({
			dots: true,
			arrows: false,
			infinite: true,
			autoplay: true,
			Speed: 2500,
			asNavFor: '.testimonial-slide-one',
			focusOnSelect: true,
			slidesToShow: 3,
			slidesToScroll: 1
		});
	};
	
	function testimonial_slide_one_init(){
		$('.testimonial-slide-one').not('.slick-initialized').slick({
			dots: true,
			arrows: false,
			infinite: true,
			autoplay: true,
			asNavFor: '.testimonial-thumb-slide',
			Speed: 2500,
			slidesToShow: 1,
			slidesToScroll: 1
		});
	};
	
	function testimonial_slide_three_init(){
		$('.testimonial-slide-three').not('.slick-initialized').slick({
			dots: false,
			arrows: false,
			infinite: true,
			autoplay: true,
			Speed: 2500,
			slidesToShow: 1,
			slidesToScroll: 1
		});
	};


	function feature_slide_init(){
		$('.features-slide').not('.slick-initialized').slick({
			dots: false,
			arrows: false,
			infinite: true,
			autoplay: true,
			Speed: 2500,
			slidesToShow: 4,
			slidesToScroll: 1,
			responsive: [
				{
					breakpoint: 1200,
					settings: {
						arrows: false,
						slidesToShow: 3
					}
				},
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
	};
	
	function service_slide_init(){
		$('.service-slide').not('.slick-initialized').slick({
			dots: false,
			arrows: false,
			infinite: true,
			autoplay: true,
			Speed: 2500,
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
	};
	

	
	function shop_big_slide_init(){
		$('.shop_big_slide').not('.slick-initialized').slick({
		  dots: false,
		  arrows: false,
		  infinite: true,
		  autoplay: true,
		  Speed: 2500,
		  asNavFor: '.shop_thumb_slide',
		  slidesToShow: 1,
		  slidesToScroll: 1
		});
	};
	
	function shop_thumb_slide_init(){
		$(".flex-control-thumbs").addClass("shop_thumb_slide");
		
		$('.shop_thumb_slide').not('.slick-initialized').slick({
		  dots: false,
		  arrows: true,
		  prevArrow: '<div class="prev"><i class="far fa-angle-left"></i></div>',
		  nextArrow: '<div class="next"><i class="far fa-angle-right"></i></div>',
		  infinite: false,
		  autoplay: false,
		  Speed: 5000,
		  slidesToShow: 4,
		  slidesToScroll: 1
		});
	}
})(jQuery);