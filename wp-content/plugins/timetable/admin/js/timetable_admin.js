jQuery(document).ready(function($){
	
	var tt_fields = timetable_fields();
	
	if($("#timetable_settings").length)
		$("#timetable_settings")[0].reset();
	$(".tt_shortcode").val($(".tt_shortcode").data("default"));
	//events hours
	$("#add_event_hours").click(function(event){
		event.preventDefault();
		if($("#start_hour").val()!="" && $("#end_hour").val()!="")
		{
			var detailsDiv = "";
			var tooltip = $("#tooltip").val().replace(/"/g, "&quot;");
			var beforeHourText = $("#before_hour_text").val().replace(/"/g, "&quot;");
			var afterHourText = $("#after_hour_text").val().replace(/"/g, "&quot;");
			if(tooltip!="" || beforeHourText!="" || afterHourText || $("#event_hour_category").val()!="" || $("#available_places").val()!="")
			{
				detailsDiv = "<div>";
				if(tooltip!="")
					detailsDiv += "<br><strong>Tooltip:</strong> " + tooltip;
				if(beforeHourText!="")
					detailsDiv += "<br><strong>Description 1:</strong> " + beforeHourText;
				if($("#after_hour_text").val()!="")
					detailsDiv += "<br><strong>Description 2:</strong> " + afterHourText;
				if($("#available_places").val()!="")
					detailsDiv += "<br><strong>Available slots:</strong> " + $("#available_places").val();
				if($("#available_places").val()!="" && $("#slots_per_user").val()!="")
					detailsDiv += "<br><strong>Slots per user:</strong> " + $("#slots_per_user").val();
				if($("#event_hour_category").val()!="")
					detailsDiv += "<br><strong>Category:</strong> " + $("#event_hour_category").val();
				detailsDiv += '</div>';
			}
			$("#event_hours_list").css("display", "block").append('<li>' + $("#weekday_id :selected").html() + ' ' + $("#start_hour").val() + "-" + $("#end_hour").val() + '<input type="hidden" name="weekday_ids[]" value="' + $("#weekday_id").val() + '" /><input type="hidden" name="start_hours[]" value="' + $("#start_hour").val() + '" /><input type="hidden" name="end_hours[]" value="' + $("#end_hour").val() + '" /><input type="hidden" name="tooltips[]" value="' + tooltip + '" /><input type="hidden" name="event_hours_category[]" value="' + $("#event_hour_category").val() + '" /><input type="hidden" name="before_hour_texts[]" value="' + beforeHourText + '" /><input type="hidden" name="after_hour_texts[]" value="' + afterHourText + '" /><input type="hidden" name="available_places_array[]" value="' + $("#available_places").val() + '" /><input type="hidden" name="slots_per_user_array[]" value="' + $("#slots_per_user").val() + '" /><input type="hidden" name="event_hours_ids[]" value="' + $("#event_hours_id").val() + '" /><img class="operation_button delete_button" src="' + config.img_url + 'delete.png" alt="del" />' + detailsDiv + '</li>');
			$("#start_hour, #end_hour, #tooltip, #before_hour_text, #after_hour_text, #event_hour_category, #available_places, #slots_per_user").val("");
			$("#weekday_id :first").attr("selected", "selected");
			if($("#add_event_hours").val()=="Edit")
			{
				$("#add_event_hours").val("Add");
				$("#event_hours_" + $("#event_hours_id").val()).remove();
				$("#event_hours_id").val(0);
			}
		}
	});
	$(document.body).on("click", "#event_hours_list .delete_event_hour", function(event) {
		if(typeof($(this).parent().attr("id"))!="undefined")
			$("#event_hours_list").after('<input type="hidden" name="delete_event_hours_ids[]" value="' + $(this).parent().attr("id").substr(12) + '" />');
		$(this).parent().remove();
		if(!$("#event_hours_list li").length)
			$("#event_hours_list").css("display", "none");
	});
	
	$(document.body).on("click", "#event_hours_list .delete_booking", function(event) {
		if(typeof($(this).parent().attr("id"))!="undefined")
			$("#event_hours_list").after('<input type="hidden" name="delete_booking_ids[]" value="' + $(this).parent().attr("id").substr(11) + '" />');
		$(this).parent().remove();
//		if(!$("#event_hours_list li").length)
//			$("#event_hours_list").css("display", "none");
	});
	
	$(document.body).on("click", ".show_hide_bookings", function(event) {
		event.preventDefault();
		$(this).next(".booking_list").slideToggle(500);
	});
	
	$(document.body).on("click", "#event_hours_list .edit_button", function(event) {
		if(typeof($(this).parent().attr("id"))!="undefined")
		{
			var loader = $(this).next(".edit_hour_event_loader");
			var id = $(this).parent().attr("id").substr(12);
			loader.css("display", "inline");
			$.ajax({
					url: ajaxurl,
					type: "post",
					dataType: "html",
					data: {
						action: "get_event_hour_details",
						id: id,
						post_id: $("#post_ID").val()
					},
					success: function(json){
						json = $.trim(json);
						var indexStart = json.indexOf("event_hour_start")+16;
						var indexEnd = json.indexOf("event_hour_end")-indexStart;
						json = $.parseJSON(json.substr(indexStart, indexEnd));
						$("#event_hours_table #weekday_id").val(json.weekday_id);
						$("#event_hours_table #start_hour").val(json.start);
						$("#event_hours_table #end_hour").val(json.end);
						$("#event_hours_table #tooltip").val(json.tooltip);
						$("#event_hours_table #available_places").val(json.available_places);
						$("#event_hours_table #slots_per_user").val(json.slots_per_user);
						$("#before_hour_text").val(json.before_hour_text);
						$("#after_hour_text").val(json.after_hour_text);
						$("#event_hour_category").val(json.category);
//						$("#event_hours_id").remove();
//						$("#event_hours_table #add_event_hours").after("<input type='hidden' id='event_hours_id' name='event_hours_id' value='" + id + "' />");
						$("#event_hours_table #event_hours_id").val(id);
						
						loader.css("display", "none");
						var offset = $("#event_hours_table").offset();
						$("html, body").animate({scrollTop: offset.top-30}, 400);
						$("#add_event_hours").val("Edit");
					}
			});
		}
	});
	
	$(document.body).on("click", "#delete_event_bookings", function(event) {
		if(!confirm(config.delete_event_booking_confirmation))
			return;
		event.preventDefault();
		
		var event_id = $("#event_id").val(),
			booking_weekday_id = $("#booking_weekday_id").val();
		$.ajax({
				url: ajaxurl,
				type: "post",
				dataType: "html",
				data: {
					action: "delete_event_bookings",
					event_id: event_id,
					booking_weekday_id: booking_weekday_id
				},
				success: function(result){
					location.reload();
				}
		});
	});
	
	//colorpicker
	if($(".color").length)
	{
		$(".color").ColorPicker({
			onChange: function(hsb, hex, rgb, el) {
				$(el).val(hex).trigger("change");
				$(el).prev(".color_preview").css("background-color", "#" + hex);
				if($(el).attr("id")=="row1_color" || $(el).attr("id")=="row2_color" || $(el).attr("id")=="box_bg_color" || $(el).attr("id")=="box_hover_bg_color" || $(el).attr("id")=="box_txt_color" || $(el).attr("id")=="box_hover_txt_color" || $(el).attr("id")=="box_hours_txt_color" || $(el).attr("id")=="box_hours_hover_txt_color" || $(el).attr("id")=="filter_color" || $(el).attr("id")=="generate_pdf_text_color" || $(el).attr("id")=="generate_pdf_bg_color" || $(el).attr("id")=="generate_pdf_hover_text_color" || $(el).attr("id")=="generate_pdf_hover_bg_color" || $(el).attr("id")=="booking_text_color" || $(el).attr("id")=="booking_bg_color" || $(el).attr("id")=="booking_hover_text_color" || $(el).attr("id")=="booking_hover_bg_color" || $(el).attr("id")=="booked_text_color" || $(el).attr("id")=="booked_bg_color" || $(el).attr("id")=="unavailable_text_color" || $(el).attr("id")=="unavailable_bg_color" || $(el).attr("id")=="available_slots_color")
				{
					generateShortcode();
				}
			},
			onSubmit: function(hsb, hex, rgb, el){
				$(el).val(hex).trigger("change");
				$(el).ColorPickerHide();
			},
			onBeforeShow: function (){
				var color = (this.value!="" ? this.value : $(this).attr("data-default-color"));
				$(this).ColorPickerSetColor(color);
				$(this).prev(".color_preview").css("background-color", color);
				if($(this).attr("id")=="row1_color" || $(this).attr("id")=="row2_color" || $(this).attr("id")=="box_bg_color" || $(this).attr("id")=="box_hover_bg_color" || $(this).attr("id")=="box_txt_color" || $(this).attr("id")=="box_hover_txt_color" || $(this).attr("id")=="box_hours_txt_color" || $(this).attr("id")=="box_hours_hover_txt_color" || $(this).attr("id")=="filter_color" || $(this).attr("id")=="generate_pdf_text_color" || $(this).attr("id")=="generate_pdf_bg_color" || $(this).attr("id")=="generate_pdf_hover_text_color" || $(this).attr("id")=="generate_pdf_hover_bg_color" || $(this).attr("id")=="booking_text_color" || $(this).attr("id")=="booking_bg_color" || $(this).attr("id")=="booking_hover_text_color" || $(this).attr("id")=="booking_hover_bg_color" || $(this).attr("id")=="booked_text_color" || $(this).attr("id")=="booked_bg_color" || $(this).attr("id")=="unavailable_text_color" || $(this).attr("id")=="unavailable_bg_color" || $(this).attr("id")=="available_slots_color")
				{
					generateShortcode();
				}
			}
		}).on("keyup", function(event, param){
			$(this).ColorPickerSetColor(this.value);
			
			var default_color = $(this).attr("data-default-color");
			$(this).prev(".color_preview").css("background-color", (this.value!="none" ? (this.value!="" ? "#" + (typeof(param)=="undefined" ? $(".colorpicker:visible .colorpicker_hex input").val() : this.value) : (default_color!="transparent" ? "#" + default_color : default_color)) : "transparent"));
			if(($(this).attr("id")=="row1_color" || $(this).attr("id")=="row2_color" || $(this).attr("id")=="box_bg_color" || $(this).attr("id")=="box_hover_bg_color" || $(this).attr("id")=="box_txt_color" || $(this).attr("id")=="box_hover_txt_color" || $(this).attr("id")=="box_hours_txt_color" || $(this).attr("id")=="box_hours_hover_txt_color" || $(this).attr("id")=="filter_color" || $(this).attr("id")=="generate_pdf_text_color" || $(this).attr("id")=="generate_pdf_bg_color" || $(this).attr("id")=="generate_pdf_hover_text_color" || $(this).attr("id")=="generate_pdf_hover_bg_color" || $(this).attr("id")=="booking_text_color" || $(this).attr("id")=="booking_bg_color" || $(this).attr("id")=="booking_hover_text_color" || $(this).attr("id")=="booking_hover_bg_color" || $(this).attr("id")=="booked_text_color" || $(this).attr("id")=="booked_bg_color" || $(this).attr("id")=="unavailable_text_color" || $(this).attr("id")=="unavailable_bg_color" || $(this).attr("id")=="available_slots_color") && typeof(param)=="undefined")
			{
				generateShortcode();
			}
		});
	}
	//shortcode generator
	if($("#timetable_settings").length)
		$("#timetable_settings")[0].reset();
	
	$("#event, #event_category, #hour_category, #weekday, #measure, #filter_style, #filter_kind, #timetable_settings [name='time_format'], #timetable_settings [name='time_format_custom'], #hide_hours_column, #hide_all_events_view, #show_end_hour, #hide_empty, #disable_event_url, #text_align, #desktop_list_view, #responsive, #event_description_responsive, #collapse_event_hours_responsive, #colors_responsive_mode, #export_to_pdf_button, #pdf_font, #direction, #event_layout, #timetable_font, #timetable_font_subset, #show_booking_button, #show_available_slots, #allow_user_booking, #allow_guest_booking, #default_booking_view, #show_guest_name_field, #guest_name_field_required, #show_guest_phone_field, #guest_phone_field_required, #show_guest_message_field, #guest_message_field_required, #terms_checkbox").change(function(event, param){
		if(param=="skip")
			return;
		if($(this).attr("id")!="timetable_font" || ($(this).attr("id")=="timetable_font" && typeof(param)=="undefined"))
		{
			generateShortcode();
		}
	});
	$("#filter_label, #filter_label_2, #generate_pdf_label, #available_slots_singular_label, #available_slots_plural_label, #booking_label, #booked_label, #unavailable_label, #booking_popup_label, #login_popup_label, #cancel_popup_label, #continue_popup_label, #terms_message, #row_height, #id, #timetable_font_custom, #timetable_font_size, #booking_popup_message, #booking_popup_thank_you_message, #timetable_custom_css").on('change keyup', function(event, param){
		if(param=="skip")
			return;
		else
		{
			generateShortcode();
		}
	});
	
	$(".tt_shortcode").on("paste change", function(event){
		$("#timetable_settings")[0].reset();
		$(".fontSubsetRow").css("display", "none").find("#timetable_font_subset option").remove();
		$("#box_bg_color,#box_hover_bg_color,#box_hover_txt_color,#box_hours_txt_color,#box_hours_hover_txt_color,#filter_color,#row1_color,#row2_color,#generate_pdf_text_color,#generate_pdf_bg_color,#generate_pdf_hover_text_color,#generate_pdf_hover_bg_color,#booking_text_color,#booking_bg_color,#booking_hover_text_color,#booking_hover_bg_color,#booked_text_color,#booked_bg_color,#unavailable_text_color,#unavailable_bg_color,#available_slots_color").trigger("keyup", [1]);
		var self = $(this);
		setTimeout(function(){
			var shortcode = self.val();
			$(".tt_shortcode").not(self).val(shortcode);
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
			re2 = new RegExp(split_character+'\\s+', 'g');
			
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
			
			for(var prop in tt_fields) {
				if(!tt_fields.hasOwnProperty(prop) || typeof(tt_atts[prop])=="undefined")
					continue;

				var field = tt_fields[prop],
					$field = $(field.selector);

				if(tt_atts[prop].val!=null)
				{
					if(["tinymce"].indexOf(field.type)!==-1)
						setTinyMCEContent(field.selector, tt_atts[prop].val);
					if(["textfield", "textarea", "dropdown"].indexOf(field.type)!==-1)
						$field.val(tt_atts[prop].val).trigger("change", ["skip"]);
					if(["font"].indexOf(field.type)!==-1)
						$field.val(tt_atts[prop].val).trigger("change", (tt_atts['font_subset'].val!=null ? [tt_atts['font_subset'].val.split(",")] : ["skip"]));
					if(["time"].indexOf(field.type)!==-1)
					{
						$field.val(tt_atts[prop].val);
						$("[name='time_format'][value='" + tt_atts[prop].val + "']").prop("checked", true);
					}
					if(["multidropdown"].indexOf(field.type)!==-1)
						$field.val(tt_atts[prop].val.split(","));								
					if(["colorpicker"].indexOf(field.type)!==-1)
						$field.val(tt_atts[prop].val).trigger("keyup", [1]);
				}
			}
		}, 1);
	});

	//copy to clipboard
	var clipboard = new Clipboard('#copy_to_clipboard1, #copy_to_clipboard2');
	clipboard.on('success', function(e) {
		$(".copy_info").css("display", "inline").fadeOut(3000);
		e.clearSelection();
	});

	$("#timetable_settings [name='time_format']").change(function(){
		if($(this).val()!="custom")
		{
			$(this).parent().siblings("input:last").val($(this).val());
			$(this).parent().siblings(".example").html($(this).next().html());
		}
	});
	$("#timetable_settings [name='time_format_custom']").on("focus", function(){
		$(this).prev().children().prop("checked", true);
	});
	$("#timetable_settings [name='time_format_custom']").on("change", function(){
		var format = $(this).val();
		$(this).next().next().css("display", "inline-block");
		var self = $(this);
		$.ajax({
				url: ajaxurl,
				type: "post",
				data: {
					action: "time_format",
					date: format
				},
				success: function(data){
					self.next().html(data);
					self.next().next().css("display", "none");
				}
		});
	});
	//upcoming events widget	
//	$("#upcoming_events_time_from").live("change", function(){
	$(document.body).on("change", "#upcoming_events_time_from", function(){
		$(this).parent().next().css("display", ($(this).val()=="server" ? "block" : "none"));
	});
	$("#timetable_configuration_tabs").tabs({
		create: function(event, ui) {
			$(this).removeClass('tt_hide');
		}
	});
	//filter label 2
	$("#filter_kind").change(function(event, param){
		var self = $(this);
		if(self.val()=="event_and_event_category")
			$(".filter_label_2").removeClass("tt_hide");
		else
			$(".filter_label_2").addClass("tt_hide");		
	});
	
	$("#default_booking_view").change(function(event, param) {
		var self = $(this),
			value = self.val();
		
		if(value=="user")
		{
			$("#allow_user_booking_wrapper").addClass('tt_hide');
			$("#allow_guest_booking_wrapper").removeClass('tt_hide');
		}
		else if(value=="guest")
		{
			$("#allow_guest_booking_wrapper").addClass('tt_hide');
			$("#allow_user_booking_wrapper").removeClass('tt_hide');
			$("#allow_guest_booking").val('yes').trigger('change', (param=="skip" ? ["skip"] : null));
		}
	});
	
	$("#allow_guest_booking").change(function(event, param){
		var self = $(this);
		if(self.val()=="yes")
		{
			$(".show_guest_name_field").removeClass("tt_hide");
			$(".guest_name_field_required").removeClass("tt_hide");
			$(".show_guest_phone_field").removeClass("tt_hide");
			$(".guest_phone_field_required").removeClass("tt_hide");
			$(".show_guest_message_field").removeClass("tt_hide");
			$(".guest_message_field_required").removeClass("tt_hide");
		}
		else
		{
			$(".show_guest_name_field").addClass("tt_hide");
			$(".guest_name_field_required").addClass("tt_hide");
			$(".show_guest_phone_field").addClass("tt_hide");
			$(".guest_phone_field_required").addClass("tt_hide");
			$(".show_guest_message_field").addClass("tt_hide");
			$(".guest_message_field_required").addClass("tt_hide");
		}
	});
	//font subset
	$(".google_font_chooser").change(function(event, param){
		var self = $(this);
		if(self.val()!="")
		{
			self.next().css("display", "inline-block");
			$.ajax({
					url: ajaxurl,
					type: 'post',
					data: "action=timetable_get_font_subsets&font=" + $(this).val(),
					success: function(data){
						data = $.trim(data);
						var indexStart = data.indexOf("timetable_start")+15;
						var indexEnd = data.indexOf("timetable_end")-indexStart;
						data = data.substr(indexStart, indexEnd);
						self.next().css("display", "none");
						self.parent().parent().next().find(".fontSubset").css("display", "inline").html(data);
						self.parent().parent().next().css("display", "table-row");
						if(param!="skip")
						{
							for(val in param)
								self.parent().parent().next().find("[value='" + param[val] + "']").attr("selected", "selected");
						}
					}
			});
		}
		else
			self.parent().parent().next().css("display", "none");
	});
	
	//dummy content import
	$("#import_dummy").click(function(event){
		event.preventDefault();
		var self = $(this);
		$("#dummy_content_tick").css("display", "none");
		self.next().css({
			"display": "inline-block",
			"visibility": "visible",
		});
		$("#dummy_content_info").html("Please wait and don't reload the page when import is in progress!");
		$.ajax({
				url: ajaxurl,
				type: "post",
				data: "action=timetable_import_dummy",
				success: function(json){
					json = $.trim(json);
					var indexStart = json.indexOf("dummy_import_start")+18;
					var indexEnd = json.indexOf("dummy_import_end")-indexStart;
					json = $.parseJSON(json.substr(indexStart, indexEnd));
					self.next().css({
						"display": "none",
						"visibility": "hidden",
					});
					$("#dummy_content_tick").css("display", "inline");
					$("#dummy_content_info").html(json.info);
				},
				error: function(jqXHR, textStatus, errorThrown){
					self.next().css({
						"display": "none",
						"visibility": "hidden",
					});
					$("#dummy_content_info").html("Error during import:<br>" + jqXHR + "<br>" + textStatus + "<br>" + errorThrown);
					console.log(jqXHR);
					console.log(textStatus);
					console.log(errorThrown);
				}
		});
	});
	
	//save event settings
	$("#timetable_events_settings").on("submit", function(event) {
		event.preventDefault();
		var self = $(this);
		var spinner = self.find(".spinner");
		var events_slug = $("#timetable_events_settings_slug").val();
		var events_label_singular = $("#timetable_events_settings_label_singular").val();
		var events_label_plural = $("#timetable_events_settings_label_plural").val();
		var $event_slug_info = $("#event_slug_info");
		spinner.css({
			"display": "inline-block",
			"visibility": "visible",
		});
		$("#event_slug_info").html("Please wait and don't reload the page when saving is in progress!");
		$.ajax({
				url: ajaxurl,
				type: "post",
				data: "action=timetable_ajax_events_settings_save&events_slug=" + events_slug + "&events_label_singular=" + events_label_singular + "&events_label_plural=" + events_label_plural,
				success: function(json){
					json = $.trim(json);
					spinner.css({
						"display": "none",
						"visibility": "hidden",
					});
					$event_slug_info.html("Events settings changed ! Page will be refreshed automatically after 3 seconds.");
					$event_slug_info.closest("tr").removeClass("tt_hide");
					
					setTimeout(function() { window.location.reload(); }, 3000);
				},
				error: function(jqXHR, textStatus, errorThrown){
					console.log(jqXHR);
					console.log(textStatus);
					console.log(errorThrown);
				}
		});
	});
	
	//manage shortcodes list
	$("#edit_timetable_shortcode_id").on("change", function(event) {
		$("#timetable_shortcode_id").css({
			"background-color": "",
			"border": ""
		});
		$(".shortcode_info").css({
			"display": "",
			"border": ""
		})
		if($(this).val()!="-1")
		{
			var self = $(this);
			var spinner = self.parent().find(".spinner");
			var shortcodeId = $("#edit_timetable_shortcode_id :selected").text();
			$("#timetable_shortcode_id").val(shortcodeId).trigger("paste");
			$("#shortcode_delete").css("display", "none");
			spinner.css({
				"display": "inline-block",
				"visibility": "visible",
			});
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
						data = $("<span>").html(data).html();
						
						//replace square brackets with HTML entities
						var bracket1 = data.indexOf('[')+1;
						var bracket2 = data.lastIndexOf(']');
						data = data.substring(bracket1, bracket2);
						data = '[' + data.replace(/\[/g, '&#91;').replace(/\]/g, '&#93;') + ']';
						
						$(".tt_shortcode").val(data)
							.eq(0).trigger("change");	//trigger change only once
						spinner.css({
							"display": "none",
							"visibility": "hidden",
						});
						$("#shortcode_delete").css("display", "inline");
					} else {
						console.log("error occured");
					}			
				}
			});
		}
		else
		{
			$("input.tt_shortcode").val("[tt_timetable]").trigger("change")
			$("#shortcode_delete").css("display", "none");
			$("#timetable_shortcode_id").val("");
		}
	});
	
	//save timetable shortcode
	$("#timetable_shortcodes").on("submit", function(event) {
		event.preventDefault();
		var self = $(this);
		var spinner = self.find(".spinner");
		var shortcodeId = $("#timetable_shortcode_id").val();
		var shortcode = $("input.tt_shortcode").val();
		var validId = /^[a-zA-z0-9\_\-]+$/;
		
		$("#timetable_shortcode_id").css({
			"background-color": "",
			"border": ""
		});
		$(".shortcode_info").css({
			"display": "",
			"color": ""
		})
		if(!validId.test(shortcodeId))
		{
			$(".shortcode_info").css({
				"display": "inline-block",
				"color": "red"
			  }).html("Shortcode ID field accepts only the following characters: letters, numbers, hyphen(-) and underscore(_)").delay(8000).fadeOut(2000);
			$("#timetable_shortcode_id").css({
				"background-color": "#F7E5E6",
				"border": "1px solid #F0ACB0"
			});
			return;
		}
		if(!shortcode.length)
		{
			window.alert("Please make sure that timetable shortcode field isn't empty.");
			return;
		}
		var data = {
			'action': "timetable_save_shortcode",
			'timetable_shortcode_id': shortcodeId,
			'timetable_shortcode': shortcode
		};
		$("#shortcode_delete").css("display", "none");
		spinner.css({
			"display": "inline-block",
			"visibility": "visible",
		});
		//save shortcode to database
		$.ajax({
			url: ajaxurl,
			type: "post",
			data: data,
			success: function(data){
				//data returns the generated ID of saved shortcode
				//check if list includes the shortcode ID, if yes the edit it, otherwise create new row
				data = $.trim(data);
				var indexStart = data.indexOf("timetable_start")+15;
				var indexEnd = data.indexOf("timetable_end")-indexStart;
				data = data.substr(indexStart, indexEnd);
				if(data!==0)
				{
					spinner.css({
						"display": "none",
						"visibility": "hidden",
					});
					if($("#edit_timetable_shortcode_id option[value='" + shortcodeId + "']").length==0)
						$("#edit_timetable_shortcode_id").append($("<option>", {
							value: shortcodeId,
							text: shortcodeId
						}));
					$("#edit_timetable_shortcode_id").val(shortcodeId).trigger("change");
					$(".shortcode_info").css("display", "inline-block").html("Timetable shortcode saved.").fadeOut(3000);
				} else {
					console.log("error occured");
				}			
			}
		});
	});
	$("#timetable_shortcode_save1, #timetable_shortcode_save2").on("click", function(event) {
		event.preventDefault();
		$("#timetable_shortcodes").trigger("submit");
	})
	
	//delete shortcode
	$("#shortcode_delete").on("click", function(event) {
		event.preventDefault();
		var consent = confirm("Click OK to delete selected shortcode.");
		if(!consent)
			return;
		var self = $(this);
		var spinner = self.parent().find(".spinner");
		var shortcodeId = $("#timetable_shortcode_id").val();
		if(!shortcodeId.length)
			return;
		$("#shortcode_delete").css("display", "none");
		spinner.css({
			"display": "inline-block",
			"visibility": "visible",
		});
		var data = {
			'action': "timetable_delete_shortcode",
			'timetable_shortcode_id': shortcodeId
		};
		//delete shortcode
		$.ajax({
			url: ajaxurl,
			type: "post",
			data: data,
			success: function(data){
				//data returns the generated ID of saved shortcode
				//check if list includes the shortcode ID, if yes the edit it, otherwise create new row
				if(data!==0)
				{
					spinner.css({
						"display": "none",
						"visibility": "hidden",
					});
					$("#edit_timetable_shortcode_id option[value='" + shortcodeId + "']").remove();
					$("#edit_timetable_shortcode_id").val("-1").trigger("change");
					$(".shortcode_info").css("display", "inline-block").html("Timetable shortcode deleted.").fadeOut(3000);
					$("#shortcode_delete").css("display", "none");
					$("#timetable_shortcode_id").val("");
				} else {
					console.log("error occured");
				}			
			}
		});
	})
});

function timetable_atts()
{
	return {
		event: { string: "event=", val: null},
		event_category: { string: "event_category=", val: null},
		hour_category: { string: "hour_category=", val: null},
		weekday: { string: "columns=", val: null},
		measure: { string: "measure=", val: null},
		filter_style: { string: "filter_style=", val: null},
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
		pdf_font: { string: "pdf_font=", val: null},
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
		terms_checkbox: { string: "terms_checkbox=", val: null},
		terms_message: { string: "terms_message=", val: null},
		booking_popup_message: { string: "booking_popup_message=", val: null},
		booking_popup_thank_you_message: { string: "booking_popup_thank_you_message=", val: null},
		custom_css: { string: "custom_css=", val: null},
	};
}

function timetable_fields()
{
	return {
		event: {
			default: "",
			selector: "#event",
			type: "multidropdown",
		},
		event_category: {
			default: "",
			selector: "#event_category",
			type: "multidropdown",
		},
		hour_category: {
			default: "",
			selector: "#hour_category",
			type: "multidropdown",
		},
		weekday: {
			default: "",
			selector: "#weekday",
			type: "multidropdown",
		},
		measure: {
			default: "1",
			selector: "#measure",
			type: "dropdown",
		},
		filter_style: {
			default: "dropdown_list",
			selector: "#filter_style",
			type: "dropdown",
		},
		filter_kind: {
			default: "event",
			selector: "#filter_kind",
			type: "dropdown",
		},
		filter_label: {
			default: "All Events",
			selector: "#filter_label",
			type: "textfield",
		},
		filter_label_2: {
			default: "All Events Categories",
			selector: "#filter_label_2",
			type: "textfield",
		},
		time_format: {
			default: "H.i",
			selector: "#time_format",
			type: "time",
		},
		hide_hours_column: {
			default: "0",
			selector: "#hide_hours_column",
			type: "dropdown",
		},
		hide_all_events_view: {
			default: "0",
			selector: "#hide_all_events_view",
			type: "dropdown",
		},
		show_end_hour: {
			default: "0",
			selector: "#show_end_hour",
			type: "dropdown",
		},
		event_layout: {
			default: "1",
			selector: "#event_layout",
			type: "dropdown",
		},
		hide_empty: {
			default: "0",
			selector: "#hide_empty",
			type: "dropdown",
		},
		disable_event_url: {
			default: "0",
			selector: "#disable_event_url",
			type: "dropdown",
		},
		text_align: {
			default: "center",
			selector: "#text_align",
			type: "dropdown",
		},
		row_height: {
			default: "31",
			selector: "#row_height",
			type: "textfield",
		},
		id: {
			default: "",
			selector: "#id",
			type: "textfield",
		},
		desktop_list_view: {
			default: "0",
			selector: "#desktop_list_view",
			type: "dropdown",
		},
		responsive: {
			default: "1",
			selector: "#responsive",
			type: "dropdown",
		},
		event_description_responsive: {
			default: "none",
			selector: "#event_description_responsive",
			type: "dropdown",
		},
		collapse_event_hours_responsive: {
			default: "0",
			selector: "#collapse_event_hours_responsive",
			type: "dropdown",
		},
		colors_responsive_mode: {
			default: "0",
			selector: "#colors_responsive_mode",
			type: "dropdown",
		},
		export_to_pdf_button: {
			default: "0",
			selector: "#export_to_pdf_button",
			type: "dropdown",
		},
		generate_pdf_label: {
			default: "Generate PDF",
			selector: "#generate_pdf_label",
			type: "textfield",
		},
		pdf_font: {
			default: "lato",
			selector: "#pdf_font",
			type: "dropdown",
		},
		box_bg_color: {
			default: "#00a27c",
			selector: "#box_bg_color",
			type: "colorpicker",
		},
		box_hover_bg_color: {
			default: "#1f736a",
			selector: "#box_hover_bg_color",
			type: "colorpicker",
		},
		box_txt_color: {
			default: "#ffffff",
			selector: "#box_txt_color",
			type: "colorpicker",
		},
		box_hover_txt_color: {
			default: "#ffffff",
			selector: "#box_hover_txt_color",
			type: "colorpicker",
		},
		box_hours_txt_color: {
			default: "#ffffff",
			selector: "#box_hours_txt_color",
			type: "colorpicker",
		},
		box_hours_hover_txt_color: {
			default: "#ffffff",
			selector: "#box_hours_hover_txt_color",
			type: "colorpicker",
		},
		filter_color: {
			default: "#00a27c",
			selector: "#filter_color",
			type: "colorpicker",
		},
		row1_color: {
			default: "#f0f0f0",
			selector: "#row1_color",
			type: "colorpicker",
		},
		row2_color: {
			default: "",
			selector: "#row2_color",
			type: "colorpicker",
		},
		generate_pdf_text_color: {
			default: "#ffffff",
			selector: "#generate_pdf_text_color",
			type: "colorpicker",
		},
		generate_pdf_bg_color: {
			default: "#00a27c",
			selector: "#generate_pdf_bg_color",
			type: "colorpicker",
		},
		generate_pdf_hover_text_color: {
			default: "#ffffff",
			selector: "#generate_pdf_hover_text_color",
			type: "colorpicker",
		},
		generate_pdf_hover_bg_color: {
			default: "#1f736a",
			selector: "#generate_pdf_hover_bg_color",
			type: "colorpicker",
		},
		booking_text_color: {
			default: "#ffffff",
			selector: "#booking_text_color",
			type: "colorpicker",
		},
		booking_bg_color: {
			default: "#05bb90",
			selector: "#booking_bg_color",
			type: "colorpicker",
		},
		booking_hover_text_color: {
			default: "#ffffff",
			selector: "#booking_hover_text_color",
			type: "colorpicker",
		},
		booking_hover_bg_color: {
			default: "#07b38a",
			selector: "#booking_hover_bg_color",
			type: "colorpicker",
		},
		booked_text_color: {
			default: "#aaaaaa",
			selector: "#booked_text_color",
			type: "colorpicker",
		},
		booked_bg_color: {
			default: "#eeeeee",
			selector: "#booked_bg_color",
			type: "colorpicker",
		},
		unavailable_text_color: {
			default: "#aaaaaa",
			selector: "#unavailable_text_color",
			type: "colorpicker",
		},
		unavailable_bg_color: {
			default: "#eeeeee",
			selector: "#unavailable_bg_color",
			type: "colorpicker",
		},
		available_slots_color: {
			default: "#ffd544",
			selector: "#available_slots_color",
			type: "colorpicker",
		},
		font_custom: {
			default: "",
			selector: "#timetable_font_custom",
			type: "textfield",
		},
		font: {
			default: "",
			selector: "#timetable_font",
			type: "font",
		},
		font_size: {
			default: "",
			selector: "#timetable_font_size",
			type: "textfield",
		},
		show_booking_button: {
			default: "no",
			selector: "#show_booking_button",
			type: "dropdown",
		},
		show_available_slots: {
			default: "no",
			selector: "#show_available_slots",
			type: "dropdown",
		},
		available_slots_singular_label: {
			default: "{number_available}/{number_total} slot available",
			selector: "#available_slots_singular_label",
			type: "textfield",
		},
		available_slots_plural_label: {
			default: "{number_available}/{number_total} slots available",
			selector: "#available_slots_plural_label",
			type: "textfield",
		},
		allow_user_booking: {
			default: "yes",
			selector: "#allow_user_booking",
			type: "dropdown",
		},
		allow_guest_booking: {
			default: "no",
			selector: "#allow_guest_booking",
			type: "dropdown",
		},
		default_booking_view: {
			default: "user",
			selector: "#default_booking_view",
			type: "dropdown",
		},
		show_guest_name_field: {
			default: "yes",
			selector: "#show_guest_name_field",
			type: "dropdown",
		},
		guest_name_field_required: {
			default: "yes",
			selector: "#guest_name_field_required",
			type: "dropdown",
		},
		show_guest_phone_field: {
			default: "no",
			selector: "#show_guest_phone_field",
			type: "dropdown",
		},
		guest_phone_field_required: {
			default: "no",
			selector: "#guest_phone_field_required",
			type: "dropdown",
		},
		show_guest_message_field: {
			default: "no",
			selector: "#show_guest_message_field",
			type: "dropdown",
		},
		guest_message_field_required: {
			default: "no",
			selector: "#guest_message_field_required",
			type: "dropdown",
		},
		booking_label: {
			default: "Book now",
			selector: "#booking_label",
			type: "textfield",
		},
		booked_label: {
			default: "Booked",
			selector: "#booked_label",
			type: "textfield",
		},
		unavailable_label: {
			default: "Unavailable",
			selector: "#unavailable_label",
			type: "textfield",
		},
		booking_popup_label: {
			default: "Book now",
			selector: "#booking_popup_label",
			type: "textfield",
		},
		login_popup_label: {
			default: "Log in",
			selector: "#login_popup_label",
			type: "textfield",
		},
		cancel_popup_label: {
			default: "Cancel",
			selector: "#cancel_popup_label",
			type: "textfield",
		},
		continue_popup_label: {
			default: "Continue",
			selector: "#continue_popup_label",
			type: "textfield",
		},
		terms_checkbox: {
			default: "no",
			selector: "#terms_checkbox",
			type: "dropdown",
		},
		terms_message: {
			default: "Please accept terms and conditions",
			selector: "#terms_message",
			type: "textfield",
		},
		booking_popup_message: {
			default: config.booking_popup_message,
			selector: "booking_popup_message",
			type: "tinymce",
		},
		booking_popup_thank_you_message: {
			default: config.booking_popup_thank_you_message,
			selector: "booking_popup_thank_you_message",
			type: "tinymce",
		},
		custom_css: {
			default: "",
			selector: "#timetable_custom_css",
			type: "textarea",
		},
	};
}

function generateShortcode()
{
	var $ = jQuery;
	var params = "";
	var booking_popup_message = getTinyMCEContent("booking_popup_message").replace(/'/g, '"');
	var booking_popup_message_default = $('<input [type="text"]/>').val(config.booking_popup_message).val().replace(/'/g, '"');
	var booking_popup_thank_you_message = getTinyMCEContent("booking_popup_thank_you_message").replace(/'/g, '"');
	var booking_popup_thank_you_message_default =$('<input [type="text"]/>').val(config.booking_popup_thank_you_message).val().replace(/'/g, '"');
	
	$(".tt_shortcode").val("[tt_timetable" + 
		params + 
		($("#event").val()!=null ? " event='" + $("#event").val().join() + "'" : "") + 
		($("#event_category").val()!=null ? " event_category='" + $("#event_category").val().join() + "'" : "") + 
		($("#weekday").val()!=null ? " columns='" + $("#weekday").val().join() + "'" : "") + 
		($("#hour_category").val()!=null ? " hour_category='" + $("#hour_category").val().join() + "'" : "") + 
		(parseInt($("#measure").val())!=1 ? " measure='" + $("#measure").val() + "'" : "") + 
		($("#filter_style").val()=='tabs' ? " filter_style='tabs'" : "") + 
		($("#direction").val()=='rtl' ? " direction='rtl'" : "") + 
		($("#filter_kind").val()=='event_category' ? " filter_kind='event_category'" : ($("#filter_kind").val()=='event_and_event_category' ? " filter_kind='event_and_event_category'" : "")) + 
		($("#filter_label").val()!='All Events' ? " filter_label='" + $("#filter_label").val() + "'" : "") + 
		($("#filter_label_2").val()!='All Events Categories' ? " filter_label_2='" + $("#filter_label_2").val() + "'" : "") + 
		($("#available_slots_singular_label").val()!='{number_available}/{number_total} slot available' ? " available_slots_singular_label='" + $("#available_slots_singular_label").val() + "'" : "") + 
		($("#available_slots_plural_label").val()!='{number_available}/{number_total} slots available' ? " available_slots_plural_label='" + $("#available_slots_plural_label").val() + "'" : "") + 
		($("#booking_label").val()!='Book now' ? " booking_label='" + $("#booking_label").val() + "'" : "") + 
		($("#booked_label").val()!='Booked' ? " booked_label='" + $("#booked_label").val() + "'" : "") + 
		($("#unavailable_label").val()!='Unavailable' ? " unavailable_label='" + $("#unavailable_label").val() + "'" : "") + 
		($("#booking_popup_label").val()!='Book now' ? " booking_popup_label='" + $("#booking_popup_label").val() + "'" : "") + 
		($("#login_popup_label").val()!='Log in' ? " login_popup_label='" + $("#login_popup_label").val() + "'" : "") + 
		($("#cancel_popup_label").val()!='Cancel' ? " cancel_popup_label='" + $("#cancel_popup_label").val() + "'" : "") + 
		($("#continue_popup_label").val()!='Continue' ? " continue_popup_label='" + $("#continue_popup_label").val() + "'" : "") + 		
		($("#terms_message").val()!='Please accept terms and conditions' ? " terms_message='" + $("#terms_message").val() + "'" : "") + 
		($("#timetable_settings [name='time_format']:checked").val()!='H.i' && $("#timetable_settings [name='time_format']:checked").val()!='custom' ? " time_format='" + $("#timetable_settings [name='time_format']:checked").val() + "'" : ($("#timetable_settings [name='time_format']:checked").val()=="custom" && $("#timetable_settings [name='time_format_custom']").val()!="H.i" ? " time_format='" + $("#timetable_settings [name='time_format_custom']").val() + "'" : "")) + 
		(parseInt($("#hide_hours_column").val())==1 ? " hide_hours_column='1'" : "") + 
		(parseInt($("#hide_all_events_view").val())==1 ? " hide_all_events_view='1'" : "") + 
		(parseInt($("#show_end_hour").val())==1 ? " show_end_hour='1'" : "") + 
		(parseInt($("#event_layout").val())!=1 ? " event_layout='" + parseInt($("#event_layout").val()) + "'" : "") + 
		($("#row1_color").val().toUpperCase()!="F0F0F0" ? " row1_color='" + $("#row1_color").val() + "'" : "") + 
		($("#row2_color").val()!="" ? " row2_color='" + $("#row2_color").val() + "'" : "") + 
		($("#generate_pdf_text_color").val().toUpperCase()!="FFFFFF" ? " generate_pdf_text_color='" + $("#generate_pdf_text_color").val() + "'" : "") +
		($("#generate_pdf_bg_color").val().toUpperCase()!="00A27C" ? " generate_pdf_bg_color='" + $("#generate_pdf_bg_color").val() + "'" : "") +
		($("#generate_pdf_hover_text_color").val().toUpperCase()!="FFFFFF" ? " generate_pdf_hover_text_color='" + $("#generate_pdf_hover_text_color").val() + "'" : "") +
		($("#generate_pdf_hover_bg_color").val().toUpperCase()!="1F736A" ? " generate_pdf_hover_bg_color='" + $("#generate_pdf_hover_bg_color").val() + "'" : "") +
		($("#booking_text_color").val().toUpperCase()!="FFFFFF" ? " booking_text_color='" + $("#booking_text_color").val() + "'" : "") +
		($("#booking_bg_color").val().toUpperCase()!="05BB90" ? " booking_bg_color='" + $("#booking_bg_color").val() + "'" : "") +
		($("#booking_hover_text_color").val().toUpperCase()!="FFFFFF" ? " booking_hover_text_color='" + $("#booking_hover_text_color").val() + "'" : "") +
		($("#booking_hover_bg_color").val().toUpperCase()!="07B38A" ? " booking_hover_bg_color='" + $("#booking_hover_bg_color").val() + "'" : "") +
		($("#booked_text_color").val().toUpperCase()!="AAAAAA" ? " booked_text_color='" + $("#booked_text_color").val() + "'" : "") +
		($("#booked_bg_color").val().toUpperCase()!="EEEEEE" ? " booked_bg_color='" + $("#booked_bg_color").val() + "'" : "") +
		($("#unavailable_text_color").val().toUpperCase()!="AAAAAA" ? " unavailable_text_color='" + $("#unavailable_text_color").val() + "'" : "") +
		($("#unavailable_bg_color").val().toUpperCase()!="EEEEEE" ? " unavailable_bg_color='" + $("#unavailable_bg_color").val() + "'" : "") +
		($("#available_slots_color").val().toUpperCase()!="FFD544" ? " available_slots_color='" + $("#available_slots_color").val() + "'" : "") +
		($("#box_bg_color").val().toUpperCase()!="00A27C" ? " box_bg_color='" + $("#box_bg_color").val() + "'" : "") + 
		($("#box_hover_bg_color").val().toUpperCase()!="1F736A" ? " box_hover_bg_color='" + $("#box_hover_bg_color").val() + "'" : "") + 
		($("#box_txt_color").val().toUpperCase()!="FFFFFF" ? " box_txt_color='" + $("#box_txt_color").val() + "'" : "") + 
		($("#box_hover_txt_color").val().toUpperCase()!="FFFFFF" ? " box_hover_txt_color='" + $("#box_hover_txt_color").val() + "'" : "") + 
		($("#box_hours_txt_color").val().toUpperCase()!="FFFFFF" ? " box_hours_txt_color='" + $("#box_hours_txt_color").val() + "'" : "") + 
		($("#box_hours_hover_txt_color").val().toUpperCase()!="FFFFFF" ? " box_hours_hover_txt_color='" + $("#box_hours_hover_txt_color").val() + "'" : "") + 
		($("#filter_color").val().toUpperCase()!="00A27C" ? " filter_color='" + $("#filter_color").val() + "'" : "") + 
		(parseInt($("#hide_empty").val())==1 ? " hide_empty='1'" : "") + 
		(parseInt($("#disable_event_url").val())==1 ? " disable_event_url='1'" : "") + 
		($("#text_align").val()!="center" ? " text_align='" + $("#text_align").val() + "'" : "") + 
		(parseInt($("#row_height").val())!=31 ? " row_height='" + parseInt($("#row_height").val()) + "'" : "") + 
		($("#id").val()!="" ? " id='" + $("#id").val() + "'" : "") + 
		(parseInt($("#desktop_list_view").val())==1 ? " desktop_list_view='1'" : "") + 
		(parseInt($("#responsive").val())==0 ? " responsive='0'" : "") + 
		($("#event_description_responsive").val()!="none" ? " event_description_responsive='" + $("#event_description_responsive").val() + "'" : "") + 
		(parseInt($("#collapse_event_hours_responsive").val())==1 ? " collapse_event_hours_responsive='1'" : "") + 
		(parseInt($("#colors_responsive_mode").val())==1 ? " colors_responsive_mode='1'" : "") + 
		(parseInt($("#export_to_pdf_button").val())==1 ? " export_to_pdf_button='1'" : "") + 
		($("#generate_pdf_label").val()!='Generate PDF' ? " generate_pdf_label='" + $("#generate_pdf_label").val() + "'" : "") + 
		($("#pdf_font").val()!='lato' ? " pdf_font='" + $("#pdf_font").val() + "'" : "") +
		($("#timetable_font_custom").val()!="" && $("#timetable_font").val()=="" ? " font_custom='" + $("#timetable_font_custom").val() + "'" : "") + 
		($("#timetable_font").val()!="" ? " font='" + $("#timetable_font").val() + "'" : "") + 
		($("#timetable_font_subset").val()!=null ? " font_subset='" + $("#timetable_font_subset").val().join() + "'" : "") + 
		($("#timetable_font_size").val()!="" ? " font_size='" + $("#timetable_font_size").val() + "'" : "") + 
		($("#show_booking_button").val()!='no' ? " show_booking_button='" + $("#show_booking_button").val() + "'" : "") + 
		($("#show_available_slots").val()!='no' ? " show_available_slots='" + $("#show_available_slots").val() + "'" : "") + 
		($("#allow_user_booking").val()!='yes' ? " allow_user_booking='" + $("#allow_user_booking").val() + "'" : "") +
		($("#allow_guest_booking").val()!='no' ? " allow_guest_booking='" + $("#allow_guest_booking").val() + "'" : "") +
		($("#default_booking_view").val()!='user' ? " default_booking_view='" + $("#default_booking_view").val() + "'" : "") +
		($("#show_guest_name_field").val()!='yes' ? " show_guest_name_field='" + $("#show_guest_name_field").val() + "'" : "") + 
		($("#guest_name_field_required").val()!='yes' ? " guest_name_field_required='" + $("#guest_name_field_required").val() + "'" : "") + 
		($("#show_guest_phone_field").val()!='no' ? " show_guest_phone_field='" + $("#show_guest_phone_field").val() + "'" : "") + 
		($("#guest_phone_field_required").val()!='no' ? " guest_phone_field_required='" + $("#guest_phone_field_required").val() + "'" : "") + 
		($("#show_guest_message_field").val()!='no' ? " show_guest_message_field='" + $("#show_guest_message_field").val() + "'" : "") + 
		($("#guest_message_field_required").val()!='no' ? " guest_message_field_required='" + $("#guest_message_field_required").val() + "'" : "") + 
		($("#terms_checkbox").val()!='no' ? " terms_checkbox='" + $("#terms_checkbox").val() + "'" : "") + 
		(booking_popup_message!=booking_popup_message_default ? " booking_popup_message='" + booking_popup_message + "'" : "") + 
		(booking_popup_thank_you_message!=booking_popup_thank_you_message_default ? " booking_popup_thank_you_message='" + booking_popup_thank_you_message + "'" : "") +
		($("#timetable_custom_css").val()!="" ? " custom_css='" + $("#timetable_custom_css").val().replace(/'/g, '"') + "'" : "") + 
	"]");
}

function getTinyMCEContent(editor_id)
{
	var $ = jQuery;
	var content = $("#" + editor_id).val().trim();
	return $('<input [type="text"]/>').val(content).val();
}

function setTinyMCEContent(editor_id, content)
{
	var $ = jQuery;
	$('#' + editor_id).val(content);
}

