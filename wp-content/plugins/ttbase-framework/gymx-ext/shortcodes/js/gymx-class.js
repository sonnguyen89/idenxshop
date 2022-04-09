jQuery(function($){
	$(document).ready(function(){
		var $teamcontainer = $('.ttbase-class-items');
   		$('.ttbase-class-item-wrapper').css({visibility: "visible", opacity: "0"});

	    $teamcontainer.imagesLoaded( function() {
	        $teamcontainer.fadeIn(1000).isotope({
	            transitionDuration: '0.6s',
	            itemSelector: '.ttbase-class-item-wrapper',
	            resizable: false,
	            layoutMode: 'fitRows',
	            sortBy: 'origorder'
	        });

	        // Fade In
	        $('.ttbase-class-item-wrapper').each(function(index){
	            $(this).delay(80*index).animate({opacity: 1}, 200);
	        });
	    });

	    /*$(window).resize(function() {
	        $portfoliocontainer.isotope('layout');
	    });*/

	    $('.ttbase-class-filters a').click(function(){
	        $('.ttbase-class-items').addClass('animatedcontainer');
	        $(this).closest('.ttbase-class-filters').find('a').removeClass('active');
	        $(this).addClass('active');
	        var selector = $(this).attr('data-filter');
	        var teamID = $(this).closest('.ttbase-class-filters').attr("data-id");
	        $('.ttbase-class-items[data-id=' + teamID + ']').isotope({ filter: selector });
	        return false;
	    });
	});
});