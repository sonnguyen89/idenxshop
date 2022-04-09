/* ------------------------------------------------------------------------ */
/* Init
/* ------------------------------------------------------------------------ */
jQuery(document).ready(function($){
	'use strict';
	
    $(".testimonial-carousel").owlCarousel({
    	items: 1,
    	loop: true,
    	autoplay: false,
    	margin:10,
    	autoHeight:false
    });

    //Post Carousel
    $(".blog-carousel").owlCarousel({
    	items: 1,
    	loop: true,
    	margin:30,
    	autoHeight:false,
    	nav: true,
    	slideBy: 1,
    	navText: '',
    	responsive:{
	        767:{
	            items:2,
	            slideBy: 2
	        },
	        991:{
	        	items:3,
	        	slideBy: 3
	        }
	    }
    });
    //Post Carousel
    $(".half-carousel").owlCarousel({
    	items: 1,
    	autoHeight: false,
    	nav: true,
    	navText: '',
		dots: false,
		center: true,
		loop:true
    });
    //Post Carousel
    $(".image-carousel").owlCarousel({
    	items: 1,
		center: true,
		autoHeight: false,
    	nav: true,
    	dots: true,
		loop:true,
		responsive:{
		    // breakpoint from 480 up
		    480 : {
		        items : 1
		    },
		    // breakpoint from 768 up
		    992 : {
		        items : 3
		    }
	    }
    });

   /* $('.blog-item .blog-pic').hover(function() {
		$(this).find('.blog-overlay').stop().animate({'opacity' : 0.94}, 160);
		$(this).find('i').stop().animate({'margin-top' : '-33px', 'opacity' : 1}, 160, 'easeOutSine');
	}, function(){
		$(this).find('.blog-overlay').stop().animate({'opacity' : 0}, 160);
		$(this).find('i').stop().animate({'margin-top' : '23px', 'opacity' : 0}, 160);
	}); */

});