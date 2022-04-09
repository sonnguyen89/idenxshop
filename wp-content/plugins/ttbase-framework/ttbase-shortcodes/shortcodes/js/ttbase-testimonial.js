jQuery(function($){
	$(document).ready(function(){
		var $teamcontainer = $('.ttbase-testimonial-items');
   		$('.ttbase-testimonial-item-wrapper').css({visibility: "visible", opacity: "0"});

	    $teamcontainer.imagesLoaded( function() {
	        $teamcontainer.fadeIn(1000).isotope({
	            transitionDuration: '0.6s',
	            itemSelector: '.ttbase-testimonial-item-wrapper',
	            resizable: false,
	            layoutMode: 'fitRows',
	            sortBy: 'origorder'
	        });

	        // Fade In
	        $('.ttbase-testimonial-item-wrapper').each(function(index){
	            $(this).delay(80*index).animate({opacity: 1}, 200);
	        });
	    });

	    /*$(window).resize(function() {
	        $portfoliocontainer.isotope('layout');
	    });*/

	    $('.ttbase-testimonial-filters a').click(function(){
	        $('.ttbase-testimonial-items').addClass('animatedcontainer');
	        $(this).closest('.ttbase-testimonial-filters').find('a').removeClass('active');
	        $(this).addClass('active');
	        var selector = $(this).attr('data-filter');
	        var testimonialID = $(this).closest('.ttbase-testimonial-filters').attr("data-id");
	        $('.ttbase-testimonial-items[data-id=' + testimonialID + ']').isotope({ filter: selector });
	        return false;
	    });
	});
});