var mr_cookies = {
getItem: function (sKey) {
  if (!sKey) { return null; }
  return decodeURIComponent(document.cookie.replace(new RegExp("(?:(?:^|.*;)\\s*" + encodeURIComponent(sKey).replace(/[\-\.\+\*]/g, "\\$&") + "\\s*\\=\\s*([^;]*).*$)|^.*$"), "$1")) || null;
},
setItem: function (sKey, sValue, vEnd, sPath, sDomain, bSecure) {
  if (!sKey || /^(?:expires|max\-age|path|domain|secure)$/i.test(sKey)) { return false; }
  var sExpires = "";
  if (vEnd) {
    switch (vEnd.constructor) {
      case Number:
        sExpires = vEnd === Infinity ? "; expires=Fri, 31 Dec 9999 23:59:59 GMT" : "; max-age=" + vEnd;
        break;
      case String:
        sExpires = "; expires=" + vEnd;
        break;
      case Date:
        sExpires = "; expires=" + vEnd.toUTCString();
        break;
    }
  }
  document.cookie = encodeURIComponent(sKey) + "=" + encodeURIComponent(sValue) + sExpires + (sDomain ? "; domain=" + sDomain : "") + (sPath ? "; path=" + sPath : "") + (bSecure ? "; secure" : "");
  return true;
},
removeItem: function (sKey, sPath, sDomain) {
  if (!this.hasItem(sKey)) { return false; }
  document.cookie = encodeURIComponent(sKey) + "=; expires=Thu, 01 Jan 1970 00:00:00 GMT" + (sDomain ? "; domain=" + sDomain : "") + (sPath ? "; path=" + sPath : "");
  return true;
},
hasItem: function (sKey) {
  if (!sKey) { return false; }
  return (new RegExp("(?:^|;\\s*)" + encodeURIComponent(sKey).replace(/[\-\.\+\*]/g, "\\$&") + "\\s*\\=")).test(document.cookie);
},
keys: function () {
  var aKeys = document.cookie.replace(/((?:^|\s*;)[^\=]+)(?=;|$)|^\s*|\s*(?:\=[^;]*)?(?:\1|$)/g, "").split(/\s*(?:\=[^;]*)?;\s*/);
  for (var nLen = aKeys.length, nIdx = 0; nIdx < nLen; nIdx++) { aKeys[nIdx] = decodeURIComponent(aKeys[nIdx]); }
  return aKeys;
}
};

jQuery(function($){
	$(document).ready(function(){
	    
	    // Multipurpose Modals
		if(jQuery('.ttbase-modal').length){
			var modalScreen = jQuery('<div class="modal-screen">').appendTo('body');
		}
	    
		jQuery(document).on('wheel mousewheel scroll', '.ttbase-modal, .modal-screen', function(evt){
			jQuery(this).get(0).scrollTop += (evt.originalEvent.deltaY); 
			return false;
		});
		
		jQuery('.modal-container').each(function(index) {
		  if(jQuery(this).find('iframe[src]').length){
		  	jQuery(this).find('.ttbase-modal').addClass('iframe-modal');
		  	jQuery('iframe', this).appendTo('.iframe-modal');
		  	jQuery('.iframe-modal > div', this).remove();
		  	jQuery(this).find('.ttbase-modal').clone().appendTo('body');
		  }
		});
	
		jQuery('.btn-modal').click(function(){
			var linkedModal = jQuery('div').closest('body').find('.ttbase-modal[modal-link="' + jQuery(this).attr('modal-link') + '"]');
		  jQuery('.modal-screen').toggleClass('reveal-modal');
		  if(linkedModal.find('iframe').length){
	      	linkedModal.find('iframe').attr('src', linkedModal.find('iframe').attr('data-src'));
	      }
		  linkedModal.toggleClass('reveal-modal');
		  return false;
		});
	
	
		// Autoshow modals
		jQuery('.ttbase-modal[modal-link][data-time-delay]').each(function(){
			var modal = jQuery(this);
			var delay = modal.attr('data-time-delay');
			modal.prepend(jQuery('<i class="ti-close close-modal">'));
			if(typeof modal.attr('data-cookie') != "undefined"){
		  	if(!mr_cookies.hasItem(modal.attr('data-cookie'))){
		          setTimeout(function(){
		  			modal.addClass('reveal-modal');
		  			jQuery('.modal-screen').addClass('reveal-modal');
		  		},delay);
		      }
		  }else{
		      setTimeout(function(){
		      	  jQuery('.ttbase-modal').removeClass('reveal-modal');
		      	  jQuery('.modal-screen').removeClass('reveal-modal');
		          modal.addClass('reveal-modal');
		          jQuery('.modal-screen').addClass('reveal-modal');
		      }, delay);
		  }
		});
		
		jQuery('.close-modal:not(.modal-strip .close-modal)').click(function(){
			var modal = jQuery(this).closest('.ttbase-modal');
			modal.toggleClass('reveal-modal');
			if(typeof modal.attr('data-cookie') != "undefined"){
				mr_cookies.setItem(modal.attr('data-cookie'), "true", Infinity);
			}
			jQuery('.modal-screen').toggleClass('reveal-modal');
			modal.find('iframe').attr('data-src', modal.find('iframe').attr('src'));
			modal.find('iframe').attr('src', '');
		});
		
		jQuery('.modal-screen').click(function(){
			jQuery('.ttbase-modal.reveal-modal').toggleClass('reveal-modal');
			jQuery(this).toggleClass('reveal-modal');
		});
		
		jQuery(document).keyup(function(e) {
			 if (e.keyCode == 27) { // escape key maps to keycode `27`
				jQuery('.ttbase-modal').removeClass('reveal-modal');
				jQuery('.modal-screen').removeClass('reveal-modal');
			}
		});
	});
});

