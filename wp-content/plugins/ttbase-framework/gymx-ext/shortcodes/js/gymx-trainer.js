jQuery(function($){
	$(document).ready(function(){
		var $teamcontainer = $('.ttbase-trainer-items');
   		$('.ttbase-trainer-item-wrapper').css({visibility: "visible", opacity: "0"});

	    $teamcontainer.imagesLoaded( function() {
	        $teamcontainer.fadeIn(1000).isotope({
	            transitionDuration: '0.6s',
	            itemSelector: '.ttbase-trainer-item-wrapper',
	            resizable: false,
	            layoutMode: 'fitRows',
	            sortBy: 'origorder'
	        });

	        // Fade In
	        $('.ttbase-trainer-item-wrapper').each(function(index){
	            $(this).delay(80*index).animate({opacity: 1}, 200);
	        });
	    });

	    /*$(window).resize(function() {
	        $portfoliocontainer.isotope('layout');
	    });*/

	    $('.ttbase-trainer-filters a').click(function(){
	        $('.ttbase-trainer-items').addClass('animatedcontainer');
	        $(this).closest('.ttbase-trainer-filters').find('a').removeClass('active');
	        $(this).addClass('active');
	        var selector = $(this).attr('data-filter');
	        var teamID = $(this).closest('.ttbase-trainer-filters').attr("data-id");
	        $('.ttbase-trainer-items[data-id=' + teamID + ']').isotope({ filter: selector });
	        return false;
	    });
	});
});