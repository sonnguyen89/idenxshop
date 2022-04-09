jQuery(document).ready(function($){
	
	var vc_tt_fields = vc_timetable_fields();
	
	//visual composer - trigger change on shortcode_id when editor loads	
	$(document).ajaxComplete(function(event, xhr, settings) {
		if(typeof(settings.data)==="undefined")
			return;
		var request_params=settings.data.split("&");
		if(request_params.indexOf("tag=tt_timetable")!==-1 && request_params.indexOf("action=vc_edit_form")!==-1 && $(".vc_ui-panel-content .vc_shortcode-param select[name='shortcode_id']").val()!=-1)
		{
			vc_timetable_load_settings(true);
		}
		else if(request_params.indexOf("tag=tt_timetable")!==-1 && request_params.indexOf("action=vc_edit_form")!==-1)
		{
			$(".vc_ui-panel-content .vc_shortcode-param select[name='default_booking_view']").trigger('change');
		}
	});
	
	//visual composer - google font subset
	$(document).on("change", ".vc_ui-panel-content .vc_shortcode-param select[name='font']", function(event, param) {
		var $this = $(this);
		var font = $this.val();
		if(font==="")
			return;
		$.ajax({
			url: ajaxurl,
			type: "post",
			data: "action=timetable_get_font_subsets&font=" + font,
			success: function(data){
				data = $.trim(data);
				var indexStart = data.indexOf("timetable_start")+15;
				var indexEnd = data.indexOf("timetable_end")-indexStart;
				data = data.substr(indexStart, indexEnd);
				var options = $.parseHTML(data);				
				var $subset = $(".vc_ui-panel-content .vc_shortcode-param select.font_subset");
				$subset.find("option").remove();
				$subset.append(options);
				if(param!=null)
				{
					$subset.val(param);
				}
			}
		});
	});
	
	//visual composer - time format
	$(document).on("change", ".vc_ui-panel-content .vc_shortcode-param select[name='select_time']", function(event) {
		var $this = $(this);
		var $time_format = $(".vc_ui-panel-content .vc_shortcode-param input[name='time_format']");
		var value = $this.val();
		$time_format.val(value);
	});
	
	$(document).on("change", ".vc_ui-panel-content .vc_shortcode-param select[name='shortcode_id']", function(event) {
		vc_timetable_load_settings();
	});
	
	$(document).on("change", ".vc_ui-panel-content .vc_shortcode-param select[name='default_booking_view']", function(event) {
		if($(this).val()=='guest')
			$(".vc_ui-panel-content .vc_shortcode-param select[name='allow_guest_booking']").val("yes").trigger('change').parent().parent().addClass('hidden');
		else
			$(".vc_ui-panel-content .vc_shortcode-param select[name='allow_guest_booking']").parent().parent().removeClass('hidden');
	});
	
	/**
	 * Function will load shortcode settings for selected ID.
	 * 
	 * @param bool on_editor_load - informs us if the function was triggered after 
	 * loading VC popup window. If it's set to 'false', then the user has selected 
	 * a shortcode ID from the dropdown field and the function was executed.
	 * @returns bool
	 */
	function vc_timetable_load_settings(on_editor_load)
	{
		if(typeof(on_editor_load)==="undefined")
			on_editor_load = false;

		var shortcodeId = $(".vc_ui-panel-content .vc_shortcode-param select[name='shortcode_id']").val();

		if(!on_editor_load)
			vc_timetable_settings_reset();

		if(shortcodeId!="-1")
		{
			var data = {
				'action': "timetable_get_shortcode",
				'timetable_shortcode_id': shortcodeId
			};
			$.ajax({
				url: ajaxurl,
				type: "post",
				data: data,
				dataType: "html",
				success: function(data){
					//data returns the generated ID of saved shortcode
					//check if list includes the shortcode ID, if yes the edit it, otherwise create new row
					if(data!==0)
					{
						data = $.trim(data);
						var indexStart = data.indexOf("timetable_start")+15;
						var indexEnd = data.indexOf("timetable_end")-indexStart;
						data = data.substr(indexStart, indexEnd);
						//helps to decode HTML entities
						var shortcode = $("<span>").html(data).html();
						
						//replace square brackets with HTML entities
						var bracket1 = shortcode.indexOf('[')+1;
						var bracket2 = shortcode.lastIndexOf(']');
						shortcode = shortcode.substring(bracket1, bracket2);
						shortcode = '[' + shortcode.replace(/\[/g, '&#91;').replace(/\]/g, '&#93;') + ']';
						
						var split_character, re, re2;
						if((shortcode.indexOf("\"")!==-1 && shortcode.indexOf("\'")!==-1 && shortcode.indexOf("\'")<shortcode.indexOf("\"")) || (shortcode.indexOf("\"")===-1))
						{
							split_character = "\'";
							re = new RegExp("\'","g");
						}
						else
						{
							split_character = "\"";
							re = new RegExp("\"","g");
						}
						re2 = new RegExp(split_character + "\\s+", "g");
						shortcode = shortcode.replace("[tt_timetable ", "");
						shortcode = shortcode.substring(0, shortcode.lastIndexOf("]"));
						var attributes = shortcode.split(re2);

						var tt_atts = timetable_atts();
						for(var i=0; i<attributes.length; i++)
						{
							for(var prop in tt_atts) {
								if(!tt_atts.hasOwnProperty(prop))
									continue;
								var att = tt_atts[prop];
								if(attributes[i].indexOf(att.string)==0)
								{
									att.val = attributes[i].replace(att.string, "").replace(re , "");
									break;
								}
							}
						}
						
						for(var prop in vc_tt_fields) {
							if(!vc_tt_fields.hasOwnProperty(prop) || typeof(tt_atts[prop])=="undefined")
								continue;
							
							var field = vc_tt_fields[prop],
								$field = $(field.selector);
						
							/*
							 * if on_editor_load is true, then the value will be
							 * replaced only if field has default or null value 
							 */
							if(tt_atts[prop].val!=null && ((!on_editor_load) || (on_editor_load && ($field.val()==null || $field.val()==field.default))))
							{
								if(["textfield", "textarea", "dropdown"].indexOf(field.type)!==-1)
									$field.val(tt_atts[prop].val).trigger("change");
								if(["font"].indexOf(field.type)!==-1)
									$field.val(tt_atts[prop].val).trigger("change", (tt_atts['font_subset'].val!=null ? [tt_atts['font_subset'].val.split(",")] : null));
								if(["multidropdown"].indexOf(field.type)!==-1)
									$field.val(tt_atts[prop].val.split(","));								
								if(["colorpicker"].indexOf(field.type)!==-1)
									$field.val(tt_atts[prop].val).trigger("keyup", [1]);
							}
						}
					} else {
						console.log("error occured");
					}
				}
			});
		}
	}
	
	//visual composer - clear timetable configuration
	function vc_timetable_settings_reset()
	{
		for(var prop in vc_tt_fields) {
			if(!vc_tt_fields.hasOwnProperty(prop))
				continue;
			var field = vc_tt_fields[prop],
				$field = $(field.selector);
			if(["textfield", "textarea","multidropdown", "dropdown"].indexOf(field.type)!==-1)
				$field.val(field.default);
			if(["font"].indexOf(field.type)!==-1)
				$field.val(field.default).trigger("change");
			if(["colorpicker"].indexOf(field.type)!==-1)
				$field.val(field.default).trigger("keyup", [1]);
		}
	}

	function timetable_atts()
	{
		return {
			event: { string: "event=", val: null},
			event_category: { string: "event_category=", val: null},
			hour_category: { string: "hour_category=", val: null},
			weekday: { string: "columns=", val: null},
			measure: { string: "measure=", val: null},
			filter_style: { string: "filter_style=", val: null},
			direction: { string: "direction=", val: null},
			filter_kind: { string: "filter_kind=", val: null},
			filter_label: { string: "filter_label=", val: null},
			filter_label_2: { string: "filter_label_2=", val: null},
			time_format: { string: "time_format=", val: null},
			hide_hours_column: { string: "hide_hours_column=", val: null},
			hide_all_events_view: { string: "hide_all_events_view=", val: null},
			show_end_hour: { string: "show_end_hour=", val: null},
			event_layout: { string: "event_layout=", val: null},
			hide_empty: { string: "hide_empty=", val: null},
			disable_event_url: { string: "disable_event_url=", val: null},
			text_align: { string: "text_align=", val: null},
			row_height: { string: "row_height=", val: null},
			id: { string: "id=", val: null},
			desktop_list_view: { string: "desktop_list_view=", val: null},
			responsive: { string: "responsive=", val: null},
			event_description_responsive: { string: "event_description_responsive=", val: null},
			collapse_event_hours_responsive: { string: "collapse_event_hours_responsive=", val: null},
			colors_responsive_mode: { string: "colors_responsive_mode=", val: null},
			export_to_pdf_button: { string: "export_to_pdf_button=", val: null},
			generate_pdf_label: { string: "generate_pdf_label=", val: null},
			box_bg_color: { string: "box_bg_color=", val: null},
			box_hover_bg_color: { string: "box_hover_bg_color=", val: null},
			box_txt_color: { string: "box_txt_color=", val: null},
			box_hover_txt_color: { string: "box_hover_txt_color=", val: null},
			box_hours_txt_color: { string: "box_hours_txt_color=", val: null},
			box_hours_hover_txt_color: { string: "box_hours_hover_txt_color=", val: null},
			filter_color: { string: "filter_color=", val: null},
			row1_color: { string: "row1_color=", val: null},
			row2_color: { string: "row2_color=", val: null},
			generate_pdf_text_color: { string: "generate_pdf_text_color=", val: null},
			generate_pdf_bg_color: { string: "generate_pdf_bg_color=", val: null},
			generate_pdf_hover_text_color: { string: "generate_pdf_hover_text_color=", val: null},
			generate_pdf_hover_bg_color: { string: "generate_pdf_hover_bg_color=", val: null},
			booking_text_color: { string: "booking_text_color=", val: null},
			booking_bg_color: { string: "booking_bg_color=", val: null},
			booking_hover_text_color: { string: "booking_hover_text_color=", val: null},
			booking_hover_bg_color: { string: "booking_hover_bg_color=", val: null},
			booked_text_color: { string: "booked_text_color=", val: null},
			booked_bg_color: { string: "booked_bg_color=", val: null},
			unavailable_text_color: { string: "unavailable_text_color=", val: null},
			unavailable_bg_color: { string: "unavailable_bg_color=", val: null},
			available_slots_color: { string: "available_slots_color=", val: null},
			font_custom: { string: "font_custom=", val: null},
			font: { string: "font=", val: null},
			font_subset: { string: "font_subset=", val: null},
			font_size: { string: "font_size=", val: null},
			show_booking_button: { string: "show_booking_button=", val: null},
			show_available_slots: { string: "show_available_slots=", val: null},
			available_slots_singular_label: { string: "available_slots_singular_label=", val: null},
			available_slots_plural_label: { string: "available_slots_plural_label=", val: null},
			allow_user_booking: { string: "allow_user_booking=", val: null},
			allow_guest_booking: { string: "allow_guest_booking=", val: null},
			default_booking_view: { string: "default_booking_view=", val: null},
			show_guest_name_field: { string: "show_guest_name_field=", val: null},
			guest_name_field_required: { string: "guest_name_field_required=", val: null},
			show_guest_phone_field: { string: "show_guest_phone_field=", val: null},
			guest_phone_field_required: { string: "guest_phone_field_required=", val: null},
			show_guest_message_field: { string: "show_guest_message_field=", val: null},
			guest_message_field_required: { string: "guest_message_field_required=", val: null},
			booking_label: { string: "booking_label=", val: null},
			booked_label: { string: "booked_label=", val: null},
			unavailable_label: { string: "unavailable_label=", val: null},
			booking_popup_label: { string: "booking_popup_label=", val: null},
			login_popup_label: { string: "login_popup_label=", val: null},
			cancel_popup_label: { string: "cancel_popup_label=", val: null},
			continue_popup_label: { string: "continue_popup_label=", val: null},
			booking_popup_message: { string: "booking_popup_message=", val: null},
			booking_popup_thank_you_message: { string: "booking_popup_thank_you_message=", val: null},
			custom_css: { string: "custom_css=", val: null},
		};
	}

	function vc_timetable_fields()
	{
		/* 
		 * we return field selector instead of object, because the fields are only 
		 * available when the VC editor popup is visible.
		*/
		return {
			event: {
				default: "",
				selector: ".vc_ui-panel-content .vc_shortcode-param select[name='event']",
				type: "multidropdown",
			},
			event_category: {
				default: "",
				selector: ".vc_ui-panel-content .vc_shortcode-param select[name='event_category']",
				type: "multidropdown",
			},
			hour_category: {
				default: "",
				selector: ".vc_ui-panel-content .vc_shortcode-param select[name='hour_category']",
				type: "multidropdown",
			},
			weekday: {
				default: "",
				selector: ".vc_ui-panel-content .vc_shortcode-param select[name='columns']",
				type: "multidropdown",
			},
			measure: {
				default: "1",
				selector: ".vc_ui-panel-content .vc_shortcode-param select[name='measure']",
				type: "dropdown",
			},
			filter_style: {
				default: "dropdown_list",
				selector: ".vc_ui-panel-content .vc_shortcode-param select[name='filter_style']",
				type: "dropdown",
			},
			filter_kind: {
				default: "event",
				selector: ".vc_ui-panel-content .vc_shortcode-param select[name='filter_kind']",
				type: "dropdown",
			},
			filter_label: {
				default: "All Events",
				selector: ".vc_ui-panel-content .vc_shortcode-param input[name='filter_label']",
				type: "textfield",
			},
			filter_label_2: {
				default: "All Events Categories",
				selector: ".vc_ui-panel-content .vc_shortcode-param input[name='filter_label_2']",
				type: "textfield",
			},
			time_format: {
				default: "H.i",
				selector: ".vc_ui-panel-content .vc_shortcode-param input[name='time_format']",
				type: "textfield",
			},
			time_format_2: {
				default: "H.i",
				selector: ".vc_ui-panel-content .vc_shortcode-param select[name='select_time']",
				type: "dropdown",
			},
			hide_hours_column: {
				default: "0",
				selector: ".vc_ui-panel-content .vc_shortcode-param select[name='hide_hours_column']",
				type: "dropdown",
			},
			hide_all_events_view: {
				default: "0",
				selector: ".vc_ui-panel-content .vc_shortcode-param select[name='hide_all_events_view']",
				type: "dropdown",
			},
			show_end_hour: {
				default: "0",
				selector: ".vc_ui-panel-content .vc_shortcode-param select[name='show_end_hour']",
				type: "dropdown",
			},
			event_layout: {
				default: "1",
				selector: ".vc_ui-panel-content .vc_shortcode-param select[name='event_layout']",
				type: "dropdown",
			},
			hide_empty: {
				default: "0",
				selector: ".vc_ui-panel-content .vc_shortcode-param select[name='hide_empty']",
				type: "dropdown",
			},
			disable_event_url: {
				default: "0",
				selector: ".vc_ui-panel-content .vc_shortcode-param select[name='disable_event_url']",
				type: "dropdown",
			},
			text_align: {
				default: "center",
				selector: ".vc_ui-panel-content .vc_shortcode-param select[name='text_align']",
				type: "dropdown",
			},
			row_height: {
				default: "31",
				selector: ".vc_ui-panel-content .vc_shortcode-param input[name='row_height']",
				type: "textfield",
			},
			id: {
				default: "",
				selector: ".vc_ui-panel-content .vc_shortcode-param input[name='id']",
				type: "textfield",
			},
			desktop_list_view: {
				default: "0",
				selector: ".vc_ui-panel-content .vc_shortcode-param select[name='desktop_list_view']",
				type: "dropdown",
			},
			responsive: {
				default: "1",
				selector: ".vc_ui-panel-content .vc_shortcode-param select[name='responsive']",
				type: "dropdown",
			},
			event_description_responsive: {
				default: "none",
				selector: ".vc_ui-panel-content .vc_shortcode-param select[name='event_description_responsive']",
				type: "dropdown",
			},
			collapse_event_hours_responsive: {
				default: "0",
				selector: ".vc_ui-panel-content .vc_shortcode-param select[name='collapse_event_hours_responsive']",
				type: "dropdown",
			},
			colors_responsive_mode: {
				default: "0",
				selector: ".vc_ui-panel-content .vc_shortcode-param select[name='colors_responsive_mode']",
				type: "dropdown",
			},
			export_to_pdf_button: {
				default: "0",
				selector: ".vc_ui-panel-content .vc_shortcode-param select[name='export_to_pdf_button']",
				type: "dropdown",
			},
			generate_pdf_label: {
				default: "Generate PDF",
				selector: ".vc_ui-panel-content .vc_shortcode-param input[name='generate_pdf_label']",
				type: "textfield",
			},
			box_bg_color: {
				default: "#00a27c",
				selector: ".vc_ui-panel-content .vc_shortcode-param input[name='box_bg_color']",
				type: "colorpicker",
			},
			box_hover_bg_color: {
				default: "#1f736a",
				selector: ".vc_ui-panel-content .vc_shortcode-param input[name='box_hover_bg_color']",
				type: "colorpicker",
			},
			box_txt_color: {
				default: "#ffffff",
				selector: ".vc_ui-panel-content .vc_shortcode-param input[name='box_txt_color']",
				type: "colorpicker",
			},
			box_hover_txt_color: {
				default: "#ffffff",
				selector: ".vc_ui-panel-content .vc_shortcode-param input[name='box_hover_txt_color']",
				type: "colorpicker",
			},
			box_hours_txt_color: {
				default: "#ffffff",
				selector: ".vc_ui-panel-content .vc_shortcode-param input[name='box_hours_txt_color']",
				type: "colorpicker",
			},
			box_hours_hover_txt_color: {
				default: "#ffffff",
				selector: ".vc_ui-panel-content .vc_shortcode-param input[name='box_hours_hover_txt_color']",
				type: "colorpicker",
			},
			filter_color: {
				default: "#00a27c",
				selector: ".vc_ui-panel-content .vc_shortcode-param input[name='filter_color']",
				type: "colorpicker",
			},
			row1_color: {
				default: "#f0f0f0",
				selector: ".vc_ui-panel-content .vc_shortcode-param input[name='row1_color']",
				type: "colorpicker",
			},
			row2_color: {
				default: "",
				selector: ".vc_ui-panel-content .vc_shortcode-param input[name='row2_color']",
				type: "colorpicker",
			},
			generate_pdf_text_color: {
				default: "#ffffff",
				selector: ".vc_ui-panel-content .vc_shortcode-param input[name='generate_pdf_text_color']",
				type: "colorpicker",
			},
			generate_pdf_bg_color: {
				default: "#00a27c",
				selector: ".vc_ui-panel-content .vc_shortcode-param input[name='generate_pdf_bg_color']",
				type: "colorpicker",
			},
			generate_pdf_hover_text_color: {
				default: "#ffffff",
				selector: ".vc_ui-panel-content .vc_shortcode-param input[name='generate_pdf_hover_text_color']",
				type: "colorpicker",
			},
			generate_pdf_hover_bg_color: {
				default: "#1f736a",
				selector: ".vc_ui-panel-content .vc_shortcode-param input[name='generate_pdf_hover_bg_color']",
				type: "colorpicker",
			},
			booking_text_color: {
				default: "#ffffff",
				selector: ".vc_ui-panel-content .vc_shortcode-param input[name='booking_text_color']",
				type: "colorpicker",
			},
			booking_bg_color: {
				default: "#05bb90",
				selector: ".vc_ui-panel-content .vc_shortcode-param input[name='booking_bg_color']",
				type: "colorpicker",
			},
			booking_hover_text_color: {
				default: "#ffffff",
				selector: ".vc_ui-panel-content .vc_shortcode-param input[name='booking_hover_text_color']",
				type: "colorpicker",
			},
			booking_hover_bg_color: {
				default: "#07b38a",
				selector: ".vc_ui-panel-content .vc_shortcode-param input[name='booking_hover_bg_color']",
				type: "colorpicker",
			},
			booked_text_color: {
				default: "#aaaaaa",
				selector: ".vc_ui-panel-content .vc_shortcode-param input[name='booked_text_color']",
				type: "colorpicker",
			},
			booked_bg_color: {
				default: "#eeeeee",
				selector: ".vc_ui-panel-content .vc_shortcode-param input[name='booked_bg_color']",
				type: "colorpicker",
			},
			unavailable_text_color: {
				default: "#aaaaaa",
				selector: ".vc_ui-panel-content .vc_shortcode-param input[name='unavailable_text_color']",
				type: "colorpicker",
			},
			unavailable_bg_color: {
				default: "#eeeeee",
				selector: ".vc_ui-panel-content .vc_shortcode-param input[name='unavailable_bg_color']",
				type: "colorpicker",
			},
			available_slots_color: {
				default: "#ffd544",
				selector: ".vc_ui-panel-content .vc_shortcode-param input[name='available_slots_color']",
				type: "colorpicker",
			},
			font_custom: {
				default: "",
				selector: ".vc_ui-panel-content .vc_shortcode-param input[name='font_custom']",
				type: "textfield",
			},
			font: {
				default: "",
				selector: ".vc_ui-panel-content .vc_shortcode-param select[name='font']",
				type: "font",
			},
			font_size: {
				default: "",
				selector: ".vc_ui-panel-content .vc_shortcode-param input[name='font_size']",
				type: "textfield",
			},
			show_booking_button: {
				default: "no",
				selector: ".vc_ui-panel-content .vc_shortcode-param select[name='show_booking_button']",
				type: "dropdown",
			},
			show_available_slots: {
				default: "no",
				selector: ".vc_ui-panel-content .vc_shortcode-param select[name='show_available_slots']",
				type: "dropdown",
			},
			available_slots_singular_label: {
				default: "{number_available}/{number_total} slot available",
				selector: ".vc_ui-panel-content .vc_shortcode-param input[name='available_slots_singular_label']",
				type: "textfield",
			},
			available_slots_plural_label: {
				default: "{number_available}/{number_total} slots available",
				selector: ".vc_ui-panel-content .vc_shortcode-param input[name='available_slots_plural_label']",
				type: "textfield",
			},
			allow_user_booking: {
				default: "yes",
				selector: ".vc_ui-panel-content .vc_shortcode-param select[name='allow_user_booking']",
				type: "dropdown",
			},
			allow_guest_booking: {
				default: "no",
				selector: ".vc_ui-panel-content .vc_shortcode-param select[name='allow_guest_booking']",
				type: "dropdown",
			},
			default_booking_view: {
				default: "user",
				selector: ".vc_ui-panel-content .vc_shortcode-param select[name='default_booking_view']",
				type: "dropdown",
			},
			show_guest_name_field: {
				default: "no",
				selector: ".vc_ui-panel-content .vc_shortcode-param select[name='show_guest_name_field']",
				type: "dropdown",
			},
			guest_name_field_required: {
				default: "no",
				selector: ".vc_ui-panel-content .vc_shortcode-param select[name='guest_name_field_required']",
				type: "dropdown",
			},
			show_guest_phone_field: {
				default: "no",
				selector: ".vc_ui-panel-content .vc_shortcode-param select[name='show_guest_phone_field']",
				type: "dropdown",
			},
			guest_phone_field_required: {
				default: "no",
				selector: ".vc_ui-panel-content .vc_shortcode-param select[name='guest_phone_field_required']",
				type: "dropdown",
			},
			show_guest_message_field: {
				default: "no",
				selector: ".vc_ui-panel-content .vc_shortcode-param select[name='show_guest_message_field']",
				type: "dropdown",
			},
			guest_message_field_required: {
				default: "no",
				selector: ".vc_ui-panel-content .vc_shortcode-param select[name='guest_message_field_required']",
				type: "dropdown",
			},
			booking_label: {
				default: "Book now",
				selector: ".vc_ui-panel-content .vc_shortcode-param input[name='booking_label']",
				type: "textfield",
			},
			booked_label: {
				default: "Booked",
				selector: ".vc_ui-panel-content .vc_shortcode-param input[name='booked_label']",
				type: "textfield",
			},
			unavailable_label: {
				default: "Unavailable",
				selector: ".vc_ui-panel-content .vc_shortcode-param input[name='unavailable_label']",
				type: "textfield",
			},
			booking_popup_label: {
				default: "Book now",
				selector: ".vc_ui-panel-content .vc_shortcode-param input[name='booking_popup_label']",
				type: "textfield",
			},
			login_popup_label: {
				default: "Log in",
				selector: ".vc_ui-panel-content .vc_shortcode-param input[name='login_popup_label']",
				type: "textfield",
			},
			cancel_popup_label: {
				default: "Cancel",
				selector: ".vc_ui-panel-content .vc_shortcode-param input[name='cancel_popup_label']",
				type: "textfield",
			},
			continue_popup_label: {
				default: "Continue",
				selector: ".vc_ui-panel-content .vc_shortcode-param input[name='continue_popup_label']",
				type: "textfield",
			},
			booking_popup_message: {
				default: config.booking_popup_message,
				selector: ".vc_ui-panel-content .vc_shortcode-param textarea[name='booking_popup_message']",
				type: "textarea",
			},
			booking_popup_thank_you_message: {
				default: config.booking_popup_thank_you_message,
				selector: ".vc_ui-panel-content .vc_shortcode-param textarea[name='booking_popup_thank_you_message']",
				type: "textarea",
			},
			custom_css: {
				default: "",
				selector: ".vc_ui-panel-content .vc_shortcode-param textarea[name='custom_css']",
				type: "textarea",
			},
		};
	}
});

//visual composer - google font subset initialization
function timetable_font_subset_init() {
	var $ = jQuery;
	var $google_font = $(".vc_shortcode-param select.font");
	var font = $google_font.val();
	if(font==="")
		return;
	$.ajax({
		url: ajaxurl,
		type: "post",
		data: "action=timetable_get_font_subsets&font=" + font,
		success: function(data){
			data = $.trim(data);
			var indexStart = data.indexOf("timetable_start")+15;
			var indexEnd = data.indexOf("timetable_end")-indexStart;
			data = data.substr(indexStart, indexEnd);
			var options = $.parseHTML(data);
			var $subset = $(".vc_shortcode-param select.font_subset");
			var old_value = $subset.find("option:selected").val();
			$subset.find("option").remove();
			$subset.append(options);
			$subset.val(old_value);
		}
	});	
}