jQuery(function($){
	$(document).ready(function(){
		var $teamcontainer = $('.ttbase-service-items');
   		$('.ttbase-service-item-wrapper').css({visibility: "visible", opacity: "0"});

	    $teamcontainer.imagesLoaded( function() {
	        $teamcontainer.fadeIn(1000).isotope({
	            transitionDuration: '0.6s',
	            itemSelector: '.ttbase-service-item-wrapper',
	            resizable: false,
	            layoutMode: 'fitRows',
	            sortBy: 'origorder'
	        });

	        // Fade In
	        $('.ttbase-service-item-wrapper').each(function(index){
	            $(this).delay(80*index).animate({opacity: 1}, 200);
	        });
	    });

	    /*$(window).resize(function() {
	        $portfoliocontainer.isotope('layout');
	    });*/

	    $('.ttbase-service-filters a').click(function(){
	        $('.ttbase-service-items').addClass('animatedcontainer');
	        $(this).closest('.ttbase-service-filters').find('a').removeClass('active');
	        $(this).addClass('active');
	        var selector = $(this).attr('data-filter');
	        var teamID = $(this).closest('.ttbase-service-filters').attr("data-id");
	        $('.ttbase-service-items[data-id=' + teamID + ']').isotope({ filter: selector });
	        return false;
	    });
	});
});