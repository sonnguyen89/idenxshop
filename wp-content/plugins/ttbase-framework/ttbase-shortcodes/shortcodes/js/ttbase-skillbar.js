jQuery(function($){
	$(document).ready(function(){
		$('.ttbase-skillbar').each(function(){
			$(this).waypoint(function(){ 
	           $(this).find('.ttbase-skillbar-bar').animate({ width: $(this).attr('data-percent') }, 800 );
	        },{ 
	            triggerOnce: true,
	            offset: '99%' 
	        }); 
		});
	});
});