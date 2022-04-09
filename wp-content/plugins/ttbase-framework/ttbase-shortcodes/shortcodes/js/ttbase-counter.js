/*!
 * jquery.countTo()
 * https://github.com/mhuggins/jquery-countTo
 *
 * Copyright 2013 Adam Coulombe
 * @license http://www.opensource.org/licenses/mit-license.html MIT License
 */
(function(e){function t(e,t){return e.toFixed(t.decimals)}e.fn.countTo=function(t){t=t||{};return e(this).each(function(){function l(){a+=i;u++;c(a);if(typeof n.onUpdate=="function"){n.onUpdate.call(s,a)}if(u>=r){o.removeData("countTo");clearInterval(f.interval);a=n.to;if(typeof n.onComplete=="function"){n.onComplete.call(s,a)}}}function c(e){var t=n.formatter.call(s,e,n);o.text(t)}var n=e.extend({},e.fn.countTo.defaults,{from:e(this).data("from"),to:e(this).data("to"),speed:e(this).data("speed"),refreshInterval:e(this).data("refresh-interval"),decimals:e(this).data("decimals")},t);var r=Math.ceil(n.speed/n.refreshInterval),i=(n.to-n.from)/r;var s=this,o=e(this),u=0,a=n.from,f=o.data("countTo")||{};o.data("countTo",f);if(f.interval){clearInterval(f.interval)}f.interval=setInterval(l,n.refreshInterval);c(a)})};e.fn.countTo.defaults={from:0,to:0,speed:1e3,refreshInterval:100,decimals:0,formatter:t,onUpdate:null,onComplete:null}})(jQuery)

jQuery(function($){
	$(document).ready(function(){
		$(".ttbase-counter-number").each(function() {
	        var $countNumber = parseInt($(this).text());
	        $(this).waypoint(function(){ 
	            $(this).countTo({
	                from: 0,
	                to: $countNumber,
	                speed: 900,
	                refreshInterval: 25
	            });
	        },{ 
	            triggerOnce: true,
	            offset: '99%' 
	        }); 
	    });
	});
});