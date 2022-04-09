jQuery(function($){
	$(document).ready(function(){
		$('.tabbed-content').each(function() {
        	$('li', this).eq(0).addClass('active');
            $(this).append('<ul class="content"></ul>');
        });
    
        $('.tabs li').each(function() {
            var originalTab = $(this),
                activeClass = "";
            if (originalTab.is('.tabs > li:first-child')) {
                activeClass = ' class="active"';
            }
            var tabContent = originalTab.find('.tab-content').detach().wrap('<li' + activeClass + '></li>').parent();
            originalTab.closest('.tabbed-content').find('.content').append(tabContent);
        });
        
        $('.tabs li').click(function() {
        $(this).closest('.tabs').find('li').removeClass('active');
        $(this).addClass('active');
        var liIndex = $(this).index() + 1;
        $(this).closest('.tabbed-content').find('.content>li').removeClass('active');
        $(this).closest('.tabbed-content').find('.content>li:nth-of-type(' + liIndex + ')').addClass('active');
    });
	});
});