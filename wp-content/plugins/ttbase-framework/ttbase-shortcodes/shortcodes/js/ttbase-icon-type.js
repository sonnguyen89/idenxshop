(function($) {
	"use strict";

	var iconKeyUpTimeout = null;

	//Font Awesome
	$('.wpb_edit_form_elements .font_awesome_icon_field').each(function() {
		var paramValue = $(this).val();
		var paramName = $(this).data('param-name');
		$(this).prev().html('<span class="fa fa-' + paramValue + '"></span>');
	}).on('keyup', function() {
		var paramValue = $(this).val();
		var currentIcon = '.fa-' + paramValue;
		$(this).prev().html('<span class="fa fa-' + paramValue + '"></span>');
		$(this).next('.wpb_edit_form_elements .font_awesome_icon_field ~ .ttbase-font-awesome-icon-select-window').children('.fa').removeClass('active');
		$(this).next('.wpb_edit_form_elements .font_awesome_icon_field ~ .ttbase-font-awesome-icon-select-window').find($(currentIcon)).addClass('active');
		if ( iconKeyUpTimeout != null ) {
			clearTimeout( iconKeyUpTimeout );
			iconKeyUpTimeout = null;
		}
	});

	$('.wpb_edit_form_elements .font_awesome_icon_field ~ .ttbase-font-awesome-icon-select-window').on('click', '.fa', function() {
		var $field = $(this).parents('.ttbase-font-awesome-icon-select-window').parent().find('input');
		$('.wpb_edit_form_elements .font_awesome_icon_field ~ .ttbase-font-awesome-icon-select-window .fa').removeClass('active');
		if ( $(this).data('name') == 'clear' ) {
			$field.val('').prev().html('');
		} else {
			$(this).addClass('active');
			$field.val($(this).data('name')).prev().html('<span class="fa fa-' + $field.val() + '"></span>');
		}
	});

	$('.wpb_edit_form_elements .ttbase-font-awesome-icon-filter').change(function() {
		var $field = $(this).parent().find('input');
		if ( $(this).val() == '' || $(this).data('name') == 'clear' ) {
			// nothing
		} else if ( $(this).val() == 'all' ) {
			$field.val('').trigger('keyup');
		} else {
			$field.val($(this).val()).trigger('keyup');
		}
	});
	
	
	//Icons Mind
	$('.wpb_edit_form_elements .iconsmind_icon_field').each(function() {
		var paramValue = $(this).val();
		var paramName = $(this).data('param-name');
		$(this).prev().html('<span class="im im-' + paramValue + '"></span>');
	}).on('keyup', function() {
		var paramValue = $(this).val();
		var currentIcon = '.im-' + paramValue;
		$(this).prev().html('<span class="im im-' + paramValue + '"></span>');
		$(this).next('.wpb_edit_form_elements .iconsmind_icon_field ~ .ttbase-iconsmind-icon-select-window').children('.im').removeClass('active');
		$(this).next('.wpb_edit_form_elements .iconsmind_icon_field ~ .ttbase-iconsmind-icon-select-window').find($(currentIcon)).addClass('active');
		if ( iconKeyUpTimeout != null ) {
			clearTimeout( iconKeyUpTimeout );
			iconKeyUpTimeout = null;
		}
	});

	$('.wpb_edit_form_elements .iconsmind_icon_field ~ .ttbase-iconsmind-icon-select-window').on('click', '.im', function() {
		var $field = $(this).parents('.ttbase-iconsmind-icon-select-window').parent().find('input');
		$('.wpb_edit_form_elements .iconsmind_icon_field ~ .ttbase-iconsmind-icon-select-window .im').removeClass('active');
		if ( $(this).data('name') == 'clear' ) {
			$field.val('').prev().html('');
		} else {
			$(this).addClass('active');
			$field.val($(this).data('name')).prev().html('<span class="im im-' + $field.val() + '"></span>');
		}
	});
	$('.wpb_edit_form_elements .iconsmind_icon_field ~ .ttbase-iconsmind-icon-select-window').on('click', '.fa', function() {
		var $field = $(this).parents('.ttbase-iconsmind-icon-select-window').parent().find('input');
		$('.wpb_edit_form_elements .iconsmind_icon_field ~ .ttbase-iconsmind-icon-select-window .im').removeClass('active');
		if ( $(this).data('name') == 'clear' ) {
			$field.val('').prev().html('');
		}
	});

	$('.wpb_edit_form_elements .ttbase-iconsmind-icon-filter').change(function() {
		var $field = $(this).parent().find('input');
		if ( $(this).val() == '' || $(this).data('name') == 'clear' ) {
			// nothing
		} else if ( $(this).val() == 'all' ) {
			$field.val('').trigger('keyup');
		} else {
			$field.val($(this).val()).trigger('keyup');
		}
	});
	
	//Streamline
	$('.wpb_edit_form_elements .streamline_icon_field').each(function() {
		var paramValue = $(this).val();
		var paramName = $(this).data('param-name');
		$(this).prev().html('<span class="sl sl-' + paramValue + '"></span>');
	}).on('keyup', function() {
		var paramValue = $(this).val();
		var currentIcon = '.sl-' + paramValue;
		$(this).prev().html('<span class="sl sl-' + paramValue + '"></span>');
		$(this).next('.wpb_edit_form_elements .streamline_icon_field ~ .ttbase-streamline-icon-select-window').children('.sl').removeClass('active');
		$(this).next('.wpb_edit_form_elements .streamline_icon_field ~ .ttbase-streamline-icon-select-window').find($(currentIcon)).addClass('active');
		if ( iconKeyUpTimeout != null ) {
			clearTimeout( iconKeyUpTimeout );
			iconKeyUpTimeout = null;
		}
	});

	$('.wpb_edit_form_elements .streamline_icon_field ~ .ttbase-streamline-icon-select-window').on('click', '.sl', function() {
		var $field = $(this).parents('.ttbase-streamline-icon-select-window').parent().find('input');
		$('.wpb_edit_form_elements .streamline_icon_field ~ .ttbase-streamline-icon-select-window .sl').removeClass('active');
		if ( $(this).data('name') == 'clear' ) {
			$field.val('').prev().html('');
		} else {
			$(this).addClass('active');
			$field.val($(this).data('name')).prev().html('<span class="sl sl-' + $field.val() + '"></span>');
		}
	});
	$('.wpb_edit_form_elements .streamline_icon_field ~ .ttbase-streamline-icon-select-window').on('click', '.fa', function() {
		var $field = $(this).parents('.ttbase-streamline-icon-select-window').parent().find('input');
		$('.wpb_edit_form_elements .streamline_icon_field ~ .ttbase-streamline-icon-select-window .sl').removeClass('active');
		if ( $(this).data('name') == 'clear' ) {
			$field.val('').prev().html('');
		}
	});

	$('.wpb_edit_form_elements .ttbase-streamline-icon-filter').change(function() {
		var $field = $(this).parent().find('input');
		if ( $(this).val() == '' || $(this).data('name') == 'clear' ) {
			// nothing
		} else if ( $(this).val() == 'all' ) {
			$field.val('').trigger('keyup');
		} else {
			$field.val($(this).val()).trigger('keyup');
		}
	});

})(jQuery);