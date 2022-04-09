jQuery(document).ready(function($){
	//classes hours
	$("#add_class_hours").click(function(event){
		event.preventDefault();
		if($("#start_hour").val()!='' && $("#end_hour").val()!='')
		{
			var trainersString = "", trainersStringId = "";
			var trainersLength = $("#class_hour_trainers :selected").length;
			var trainers = $("#class_hour_trainers :selected").each(function(index){
				trainersString += $(this).text() + (index+1<trainersLength ? "," : "");
				trainersStringId += $(this).val() + (index+1<trainersLength ? "," : "");
			});
			var detailsDiv = "";
			if($("#tooltip").val()!="" || $("#before_hour_text").val()!="" || $("#after_hour_text").val()!="" || trainersString!="" || $("#class_hour_category").val()!="")
			{
				detailsDiv = '<div>';
				if($("#tooltip").val()!="")
					detailsDiv += '<br /><strong>Tooltip:</strong> ' + $("#tooltip").val();
				if($("#before_hour_text").val()!="")
					detailsDiv += '<br /><strong>Before hour text:</strong> ' + $("#before_hour_text").val();
				if($("#after_hour_text").val()!="")
					detailsDiv += '<br /><strong>After hour text:</strong> ' + $("#after_hour_text").val();
				if(trainersString)
					detailsDiv += '<br /><strong>Trainers:</strong> ' + trainersString;
				if($("#class_hour_category").val()!="")
					detailsDiv += '<br /><strong>Category:</strong> ' + $("#class_hour_category").val();
				detailsDiv += '</div>';
			}
			$("#class_hours_list").css("display", "block").append('<li>' + $("#weekday_id :selected").html() + ' ' + $("#start_hour").val() + "-" + $("#end_hour").val() + '<input type="hidden" name="weekday_ids[]" value="' + $("#weekday_id").val() + '" /><input type="hidden" name="start_hours[]" value="' + $("#start_hour").val() + '" /><input type="hidden" name="end_hours[]" value="' + $("#end_hour").val() + '" /><input type="hidden" name="tooltips[]" value="' + $("#tooltip").val() + '" /><input type="hidden" name="class_hours_category[]" value="' + $("#class_hour_category").val() + '" /><input type="hidden" name="before_hour_texts[]" value="' + $("#before_hour_text").val() + '" /><input type="hidden" name="after_hour_texts[]" value="' + $("#after_hour_text").val() + '" /><input type="hidden" name="class_hours_trainers[]" value="' + trainersStringId + '" /><i class="fa fa-trash operation_button delete_button"></i>' + detailsDiv + '</li>');
			$("#start_hour, #end_hour, #tooltip, #before_hour_text, #after_hour_text, #class_hour_trainers, #class_hour_category").val("");
			$("#weekday_id :first").attr("selected", "selected");
			if($("#add_class_hours").val()=="Edit")
			{
				$("#add_class_hours").val("Add");
				$("#class_hours_" + $("#class_hours_id").val() + " .delete_button").trigger("click");
				$("#class_hours_id").remove();
			}
		}
	});
	$(document.body).on("click", "#class_hours_list .delete_button", function(event) {
		if(typeof($(this).parent().attr("id"))!="undefined")
			$("#class_hours_list").after('<input type="hidden" name="delete_class_hours_ids[]" value="' + $(this).parent().attr("id").substr(12) + '" />');
		$(this).parent().remove();
		if(!$("#class_hours_list li").length)
			$("#class_hours_list").css("display", "none");
	});
	$(document.body).on("click", "#class_hours_list .edit_button", function(event) {
		if(typeof($(this).parent().attr("id"))!="undefined")
		{
			var loader = $(this).next(".edit_hour_class_loader");
			var id = $(this).parent().attr("id").substr(12);
			loader.css("display", "inline");
			$.ajax({
					url: ajaxurl,
					type: 'post',
					dataType: 'html',
					data: {
						action: 'get_class_hour_details',
						id: id,
						post_id: $("#post_ID").val()
					},
					success: function(json){
						var indexStart = json.indexOf("class_hour_start")+16;
						var indexEnd = json.indexOf("class_hour_end")-indexStart;
						json = $.parseJSON(json.substr(indexStart, indexEnd));
						$("#class_hours_table #weekday_id").val(json.weekday_id);
						$("#class_hours_table #start_hour").val(json.start);
						$("#class_hours_table #end_hour").val(json.end);
						$("#class_hours_table #tooltip").val(json.tooltip);
						$("#before_hour_text").val(json.before_hour_text);
						$("#after_hour_text").val(json.after_hour_text);
						$("#class_hour_trainers").val(json.trainers.split(","));
						$("#class_hour_category").val(json.category);
						$("#class_hours_id").remove();
						$("#class_hours_table #add_class_hours").after("<input type='hidden' id='class_hours_id' name='class_hours_id' value='" + id + "' />");
						loader.css("display", "none");
						var offset = $("#class_hours_table").offset();
						$("html, body").animate({scrollTop: offset.top-30}, 400);
						$("#add_class_hours").val("Edit");
					}
			});
		}
	});
	
	//colorpicker
	if($(".color").length)
	{
		$(".color").ColorPicker({
			onChange: function(hsb, hex, rgb, el) {
				$(el).val(hex);
				$(el).prev(".color_preview").css("background-color", "#" + hex);
			},
			onSubmit: function(hsb, hex, rgb, el){
				$(el).val(hex);
				$(el).ColorPickerHide();
			},
			onBeforeShow: function (){
				var color = (this.value!="" ? this.value : $(this).attr("data-default-color"));
				$(this).ColorPickerSetColor(color);
				$(this).prev(".color_preview").css("background-color", color);
			}
		}).on('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
			var default_color = $(this).attr("data-default-color");
			$(this).prev(".color_preview").css("background-color", (this.value!="none" ? (this.value!="" ? "#" + (typeof(param)=="undefined" ? $(".colorpicker:visible .colorpicker_hex input").val() : this.value) : (default_color!="transparent" ? "#" + default_color : default_color)) : "transparent"));
		});
	}
	//google font subset
	$("#header_font, #subheader_font").change(function(event, param){
		var self = $(this);
		if(self.val()!="")
		{
			self.parent().find(".theme_font_subset_preloader").css("display", "inline-block");
			$.ajax({
					url: ajaxurl,
					type: 'post',
					data: "action=gymbase_get_font_subsets&font=" + $(this).val(),
					success: function(data){
						data = $.trim(data);
						var indexStart = data.indexOf("gb_start")+8;
						var indexEnd = data.indexOf("gb_end")-indexStart;
						data = data.substr(indexStart, indexEnd);
						self.parent().find(".theme_font_subset_preloader").css("display", "none");
						self.parent().find(".font_subset").css("display", "block");
						self.parent().find("select.font_subset").html(data)
					}
			});
		}
		else
			self.parent().find(".font_subset").css("display", "none").find("option").remove();
	});
	//upcoming classes widget
	$(document.body).on("change", "#upcoming_classes_time_from", function(){
		$(this).parent().next().css("display", ($(this).val()=="server" ? "block" : "none"));
	});
});