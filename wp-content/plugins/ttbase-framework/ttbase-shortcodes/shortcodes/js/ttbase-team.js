jQuery(function($){
	$(document).ready(function(){
		var $teamcontainer = $('.ttbase-team-items');
   		$('.ttbase-team-item-wrapper').css({visibility: "visible", opacity: "0"});

	    $teamcontainer.imagesLoaded( function() {
	        $teamcontainer.fadeIn(1000).isotope({
	            transitionDuration: '0.6s',
	            itemSelector: '.ttbase-team-item-wrapper',
	            resizable: false,
	            layoutMode: 'fitRows',
	            sortBy: 'origorder'
	        });

	        // Fade In
	        $('.ttbase-team-item-wrapper').each(function(index){
	            $(this).delay(80*index).animate({opacity: 1}, 200);
	        });
	    });

	    /*$(window).resize(function() {
	        $portfoliocontainer.isotope('layout');
	    });*/

	    $('.ttbase-team-filters a').click(function(){
	        $('.ttbase-team-items').addClass('animatedcontainer');
	        $(this).closest('.ttbase-team-filters').find('a').removeClass('active');
	        $(this).addClass('active');
	        var selector = $(this).attr('data-filter');
	        var teamID = $(this).closest('.ttbase-team-filters').attr("data-id");
	        $('.ttbase-team-items[data-id=' + teamID + ']').isotope({ filter: selector });
	        return false;
	    });
	});
});