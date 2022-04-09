<?php

define('BOOKING_POPUP_MESSAGE', "<h2>You are about to book event</h2>
<div class='event_details_wrapper'>
<p class='event_details bold'>{event_title}</p>
<p class='event_details'>{column_title}</p>
<p class='event_details'>{event_start} - {event_end}</p>
</div>
{booking_form}
<p>An initial receipt will be sent out automatically unless you decide not to do so below.</p>
<div class='tt_btn_wrapper'>{tt_btn_book}{tt_btn_cancel}</div>");
define('BOOKING_POPUP_THANK_YOU_MESSAGE', "<h2>Thank you for choosing our services!</h2>
<div class='event_details_wrapper'>
<p class='event_details bold'>{event_title}</p>
<p class='event_details'>{column_title}</p>
<p class='event_details'>{event_start} - {event_end}</p>
</div>
<p class='info'>This is a confirmation of your booking. Your booking is now complete and a confirmation email has been sent to you.</p>
<div class='tt_btn_wrapper'>{tt_btn_continue}</div>");

//timetable
function tt_timetable($atts, $content)
{
	$timetable_events_settings = timetable_events_settings();
	wp_register_style('timetable_inline_style', false);
	wp_enqueue_style('timetable_inline_style');
	$inline_style = '';
	
	$defaults = array(
		'event' => '',
		'event_category' => '',
		'events_page' => '',
		'filter_style' => 'dropdown_list',
		'filter_kind' => 'event',
		'measure' => 1,
		'show_booking_button' => 'no',
		'show_available_slots' => 'no',
		'available_slots_singular_label' => '{number_available}/{number_total} slot available',
		'available_slots_plural_label' => '{number_available}/{number_total} slots available',
	    'allow_user_booking' => 'yes',
	    'allow_guest_booking' => 'no',
	    'default_booking_view' => 'user',
		'show_guest_name_field' => 'yes',
		'guest_name_field_required' => 'yes',
		'show_guest_phone_field' => 'no',
		'guest_phone_field_required' => 'no',
		'show_guest_message_field' => 'no',
		'guest_message_field_required' => 'no',
		'booking_label' => 'Book now',
		'booked_label' => 'Booked',
		'unavailable_label' => 'Unavailable',
		'booking_popup_label' => 'Book now',
		'login_popup_label' => 'Log in',
		'cancel_popup_label' => 'Cancel',
		'continue_popup_label' => 'Continue',
		'terms_checkbox' => 'no',
		'terms_message' => 'Please accept terms and conditions',
		'booking_popup_message' => BOOKING_POPUP_MESSAGE,
		'booking_popup_thank_you_message' => BOOKING_POPUP_THANK_YOU_MESSAGE,
		'filter_label' => 'All Events',
		'filter_label_2' => 'All Events Categories',
		'hour_category' => '',
		'columns' => '',
		'time_format' => 'H.i',
		'hide_hours_column' => 0,
		'hide_all_events_view' => 0,
		'show_end_hour' => 0,
		'event_layout' => 1,
		'box_bg_color' => '00A27C',
		'box_hover_bg_color' => '1F736A',
		'box_txt_color' => 'FFFFFF',
		'box_hover_txt_color' => 'FFFFFF',
		'box_hours_txt_color' => 'FFFFFF',
		'box_hours_hover_txt_color' => 'FFFFFF',
		'filter_color' => '00A27C',
		'row1_color' => 'F0F0F0',
		'row2_color' => '',
		'generate_pdf_text_color' => 'FFFFFF',
		'generate_pdf_bg_color' => '00A27C',
		'generate_pdf_hover_text_color' => 'FFFFFF',
		'generate_pdf_hover_bg_color' => '1F736A',
		'booking_text_color' => 'FFFFFF',
		'booking_bg_color' => '05BB90',
		'booking_hover_text_color' => 'FFFFFF',
		'booking_hover_bg_color' => '07B38A',
		'booked_text_color' => 'AAAAAA',
		'booked_bg_color' => 'EEEEEE',
		'unavailable_text_color' => 'AAAAAA',
		'unavailable_bg_color' => 'EEEEEE',
		'available_slots_color' => 'FFD544',
		'hide_empty' => 0,
		'disable_event_url' => 0,
		'text_align' => 'center',
		'row_height' => 31,
		'id' => '',
		'shortcode_id' => '',
		'desktop_list_view' => 0,
		'responsive' => 1,
		'event_description_responsive' => 'none',
		'collapse_event_hours_responsive' => 0,
		'colors_responsive_mode' => 0,
		'export_to_pdf_button' => 0,
		'generate_pdf_label' => 'Generate PDF',
	    'pdf_font' => 'lato',
		'direction' => 'ltr',
		'font_custom' => '',
		'font' => '',
		'font_subset' => '',
		'font_size' => '',
		'custom_css' => ''
	);
	
	if(isset($atts['shortcode_id']) && strlen($atts['shortcode_id']))
	{
		$timetable_shortcodes_list = get_option("timetable_shortcodes_list");
		if($timetable_shortcodes_list!==false && !empty($timetable_shortcodes_list[$atts['shortcode_id']]))
		{
			$shortcode = $timetable_shortcodes_list[$atts['shortcode_id']];	
			$shortcode = html_entity_decode(substr($shortcode, strpos($shortcode, '[')+1, $bracket2 = strrpos($shortcode, ']')-1));
			$shortcode_atts = shortcode_parse_atts($shortcode);
			$defaults = array_merge($defaults, $shortcode_atts);
		}
	}
	
	//replace square entites to their applicable characters
	$attributes = shortcode_atts($defaults, $atts);
	array_walk($attributes, function(&$val, &$key) {
		$val = html_entity_decode($val);
	});
	
	//default_booking_view
	if($attributes['default_booking_view']=='user')
	    $attributes['allow_user_booking']='yes';
	elseif($attributes['default_booking_view']=='guest')
	   $attributes['allow_guest_booking']='yes';
	
	$atts = $atts2 = $attributes;
	extract($atts);
	
	//replace grave accent added by Visual Composer
	$atts2["terms_message"] = $terms_message = str_replace("``", "\"", $terms_message);
	$atts2["booking_popup_message"] = $booking_popup_message = str_replace("``", "\"", $booking_popup_message);
	$atts2["booking_popup_thank_you_message"] = $booking_popup_thank_you_message = str_replace("``", "\"", $booking_popup_thank_you_message);
	
	$custom_css = str_replace("``", "\"", $custom_css);

	//remove leading '#' hash character
	$color_params = array('box_bg_color','box_hover_bg_color','box_txt_color','box_hover_txt_color','box_hours_txt_color','box_hours_hover_txt_color','filter_color','row1_color','row2_color','generate_pdf_text_color','generate_pdf_bg_color','generate_pdf_hover_text_color','generate_pdf_hover_bg_color','booking_text_color','booking_bg_color','booking_hover_text_color','booking_hover_bg_color','booked_text_color','booked_bg_color','unavailable_text_color','unavailable_bg_color','available_slots_color');
	foreach($color_params as $color_param)
	{
		if(!empty($$color_param))
			$$color_param = ltrim($$color_param, "#");
	}
	
	$events_array = array_values(array_diff(array_filter(array_map('trim', explode(",", $event))), array("-")));
	$event_category_array = array_values(array_diff(array_filter(array_map('trim', explode(",", $event_category))), array("-")));
	
	if(!$hide_all_events_view)
	{
		$events_list_html = '<li><a href="#all-events' . ($id!='' ? '-' . urlencode($id) : '') . '" title="' . esc_attr($filter_label) . '">' . $filter_label . '</a></li>';
		$events_categories_list_html = '<li><a href="#all-events' . ($id!='' ? '-' . urlencode($id) : '') . '" title="' . esc_attr(($filter_kind=="event_and_event_category" ? $filter_label_2 : $filter_label)) . '">' . ($filter_kind=="event_and_event_category" ? $filter_label_2 : $filter_label) . '</a></li>';
	}
	else
	{
		$events_list_html = '';
		$events_categories_list_html = '';
	}
	if($filter_kind=="event" || !count($event_category_array) || ($filter_kind=="event_and_event_category" && !empty($event)))
	{
		$events_array_count = count($events_array);
		for($i=0; $i<$events_array_count; $i++)
		{
			$events_list = get_posts(array(
				"name" => $events_array[$i],
				'post_type' => $timetable_events_settings['slug'],
				'post_status' => 'publish'
			));
			if($events_list)
				$events_list_html .= '<li><a href="#' . urlencode($events_array[$i]) . ($id!='' ? '-' . urlencode($id) : '') . '" title="' . esc_attr($events_list[0]->post_title) . '">' . $events_list[0]->post_title . '</a></li>';
			if($hide_all_events_view && $filter_style=="dropdown_list" && ($filter_label=="All Events" || $filter_label=="") && !$i)
			{
				$filter_label = $events_list[$i]->post_title;
			}
		}
	}
	
	$events_category_array_count = 0;
	if($filter_kind=="event_category" || ($filter_kind=="event_and_event_category" && !empty($event_category)))
	{
		$events_category_array_count = count($event_category_array);
		for($i=0; $i<$events_category_array_count; $i++)
		{
			$category = get_term_by("slug", $event_category_array[$i], "events_category");
			if(!empty($category))
			{
				$events_categories_list_html .= '<li><a href="#' . urlencode($event_category_array[$i]) . ($id!='' ? '-' . urlencode($id) : '') . '" title="' . esc_attr($category->name) . '">' . $category->name . '</a></li>';
				if($hide_all_events_view && $filter_style=="dropdown_list" && !$i)
				{
					if($filter_kind!="event_and_event_category" && ($filter_label=="All Events" || $filter_label==""))
						$filter_label = $category->name;
					if($filter_kind=="event_and_event_category" && ($filter_label_2=="All Events Categories" || $filter_label_2==""))
						$filter_label_2 = $category->name;
				}
			}
		}
	}
	
	$events_array_verified = array();
	if(count($event_category_array))
	{
		//events array ids
		$events_array_id = array();
		for($i=0; $i<count($events_array); $i++)
		{
			$event_post = get_posts(array(
			  'name' => $events_array[$i],
			  'post_type' => $timetable_events_settings['slug'],
			  'post_status' => 'publish',
			  'numberposts' => 1
			));
			if(count($event_post))
			{
				$events_array_id[] = $event_post[0]->ID;
			}
		}
		$events_array_cat = get_posts(array(
			'include' => $events_array_id,
			'post_type' => $timetable_events_settings['slug'],
			'post_status' => 'publish',
			'posts_per_page' => -1,
			'nopaging' => true,
			'orderby' => 'menu_order',
			'order' => 'ASC',
			'events_category' => implode("','", array_map("tt_strtolower_urlencode", $event_category_array))
		));
		if(!empty($events_array_cat))
		{		
			
			for($i=0; $i<count($events_array_cat); $i++)
				$events_array_verified[] = urldecode($events_array_cat[$i]->post_name);
		}
		else
			$events_array_verified = -1;
	}
	$output = '';
	
	$output .= "<div " . ($id!="" ? "id='".urlencode($id)."'" : "") . " class='tt_wrapper " . ($direction=="rtl" ? "rtl" : "") . " " . ($show_booking_button=="on_hover" ? "booking_hover_buttons" : "") . "'>";
	
	if($filter_style=="dropdown_list")
	{
		$output .= '<div class="tt_navigation_wrapper ' . ($filter_kind=="event_and_event_category" ? "tt_double_buttons" : "") . '">
		<div class="tt_navigation_cell timetable_clearfix">';
		
		if($filter_kind=="event_category" || $filter_kind=="event_and_event_category")
		{
			$output .= '<ul class="timetable_clearfix tabs_box_navigation events_categories_filter' . ((int)$responsive ? " tt_responsive" : "") . ' sf-timetable-menu">
				<li class="tabs_box_navigation_selected" aria-haspopup="true"><label>' . ($filter_kind=="event_and_event_category" ? $filter_label_2 : $filter_label) . '</label><span class="tabs_box_navigation_icon"></span>' . (!$hide_all_events_view || !empty($event_category) ? '<ul class="sub-menu">' . $events_categories_list_html . '</ul>' : '') . '</li>
			</ul>';
		}
		
		if($filter_kind=="event" || $filter_kind=="event_and_event_category")
		{
			$output .= '<ul class="timetable_clearfix tabs_box_navigation events_filter' . ((int)$responsive ? " tt_responsive" : "") . ' sf-timetable-menu">
				<li class="tabs_box_navigation_selected" aria-haspopup="true"><label>' . $filter_label . '</label><span class="tabs_box_navigation_icon"></span>' . (!$hide_all_events_view || !empty($event) ? '<ul class="sub-menu">' . $events_list_html . '</ul>' : '') . '</li>
			</ul>';
		}
		
		$output .= '</div>';
		
		if($export_to_pdf_button && $responsive)
		{
			$pdf_text_color = (strtoupper($generate_pdf_text_color)!="FFFFFF" ? $generate_pdf_text_color : "");
			$pdf_bg_color = (strtoupper($generate_pdf_bg_color)!="00A27C" ? $generate_pdf_bg_color : "");
			$pdf_hover_text_color = (strtoupper($generate_pdf_hover_text_color)!="FFFFFF" || $pdf_text_color!="" ? $generate_pdf_hover_text_color : "");
			$pdf_hover_bg_color = (strtoupper($generate_pdf_hover_bg_color)!="1F736A" || $pdf_bg_color!="" ? $generate_pdf_hover_bg_color : "");
			
			$output .=
				"<div class='tt_navigation_cell timetable_clearfix'>
					<form class='tt_generate_pdf' action='' method='post'>
						<textarea class='tt_pdf_html' name='tt_pdf_html_content'></textarea>
						<input type='hidden' name='tt_action' value='tt_generate_pdf'/>
                        <input type='hidden' name='tt_pdf_font' value='" . $pdf_font . "'/>
						<input type='submit' value='" . $generate_pdf_label . "' style='" . (strlen($pdf_text_color) ? " color: #" . $pdf_text_color . " !important;" : "") . (strlen($pdf_bg_color) ? " background-color: #" . $pdf_bg_color . ";" : "") . "' onMouseOver='" . (strlen($pdf_hover_text_color) ? " this.style.setProperty(\"color\", \"#" . $pdf_hover_text_color . "\", \"important\");" : "") . (strlen($pdf_hover_bg_color) ? " this.style.setProperty(\"background\", \"#" . $pdf_hover_bg_color . "\", \"important\");" : "") . "' onMouseOut='" . (strlen($pdf_hover_text_color) ? (strlen($pdf_text_color) ? " this.style.setProperty(\"color\", \"#" . $pdf_text_color . "\", \"important\");" : " this.style.color=\"\";") : "") . (strlen($pdf_hover_bg_color) ? (strlen($pdf_bg_color) ? " this.style.setProperty(\"background\", \"#" . $pdf_bg_color . "\", \"important\");" : " this.style.background=\"\";") : "") . "'/>
					</form>
				</div>";
		}

		$output .= '</div>';
	}
	
	if((int)$row_height!=31 || strtoupper($box_bg_color)!="00A27C" || strtoupper($filter_color)!="00A27C" || strtoupper($available_slots_color)!="FFD544" || $custom_css!="")
	{
		$inline_style .= $custom_css . ((int)$row_height!=31 ? ($id!="" ? '#' . $id : '') . '.tt_tabs .tt_timetable td{height: ' . (int)$row_height . (substr($row_height, -2)!="px" ? 'px' : '') . ';}' : '') . (strtoupper($box_bg_color)!="00A27C" ? ($id!="" ? '#' . $id : '') . '.tt_tabs .tt_timetable .event{background: #' . $box_bg_color . ';}' : '') . (strtoupper($filter_color)!="00A27C" ? ($id!="" ? '#' . $id : '') . ' .tt_tabs_navigation li a:hover,' . ($id!="" ? '#' . $id : '') . ' .tt_tabs_navigation li a.selected,' . ($id!="" ? '#' . $id : '') . ' .tt_tabs_navigation li.ui-tabs-active a{border-color:#' . $filter_color . ' !important;}' . ($id!="" ? '.' . $id : '') . '.tabs_box_navigation.sf-timetable-menu .tabs_box_navigation_selected{background-color:#' . $filter_color . ';border-color:#' . $filter_color . ';}' . ($id!="" ? '.' . $id : '') . '.tabs_box_navigation.sf-timetable-menu .tabs_box_navigation_selected:hover{background-color: #FFF; border: 1px solid rgba(0, 0, 0, 0.1);}' . ($id!="" ? '.' . $id : '') . '.sf-timetable-menu li ul li a:hover, .sf-timetable-menu li ul li.selected a:hover{background-color:#' . $filter_color . ';}' : '') . (strtoupper($available_slots_color)!="FFD544" ? ($id!="" ? '#' . $id : '') . ' .tt_timetable .event span.available_slots,' . ($id!="" ? '#' . $id : '') . ' .tt_responsive .tt_timetable.small .tt_items_list span.available_slots,' . ($id!="" ? '#' . $id : '') . ' .tt_responsive .tt_timetable.small .tt_items_list span.available_slots span.count { color:#' . $available_slots_color . ' !important;}' : '');
	}
	if($font!="")
		$output .= '<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=' . $font . '&amp;subset=' . $font_subset . '">';
	if($font_custom!="" || $font!="" || (int)$font_size>0)
	{
		$font_explode = explode(":", $font);
			$font = '"' . $font_explode[0] . '"';
			
		$inline_style .= ($font_custom!="" || $font!="" ? ($id!="" ? '#' . $id : '') . '.tt_tabs .tt_timetable, #tt_booking_popup_message .tt_booking_message, #tt_booking_popup_message h2{font-family:' . ($font_custom!="" ? $font_custom : $font) . ' !important;}' : '') . ((int)$font_size>0 ? ($id!="" ? '#' . $id : '') . '.tt_tabs .tt_timetable th,' . ($id!="" ? '#' . $id : '') . '.tt_tabs .tt_timetable td,' . ($id!="" ? '#' . $id : '') . '.tt_tabs .tt_timetable .event .before_hour_text,' . ($id!="" ? '#' . $id : '') . '.tt_tabs .tt_timetable .event .after_hour_text,' . ($id!="" ? '#' . $id : '') . '.tt_tabs .tt_timetable .event .event_header{font-size:' . (int)$font_size . 'px !important;}' : '');
	}
	$output .= '<div class="timetable_clearfix tt_tabs' . ((int)$responsive ? " tt_responsive" : "") . " event_layout_" . $event_layout . '"' . ($id!="" ? ' id="' . $id . '"' : '') . '>';
	
	$output .= '<div class="tt_navigation_wrapper ' . ($filter_style=='tabs' ? '' : 'tt_hide') . '">
		<div class="tt_navigation_cell timetable_clearfix">';
	
	// we need to display all filter items, both events and events categories, so the filter buttons from both lists are working correctly
	if($filter_kind=="event_and_event_category")
	{
		$all_filters_list_html = $events_list_html . $events_categories_list_html;
		// filter list must be hidden
		$output .= '<ul class="timetable_clearfix tt_tabs_navigation all_filters" style="display: none !important;">' . $all_filters_list_html . '</ul>';
	}
	
	if($filter_kind=="event" || $filter_kind=="event_and_event_category")
	{
		$events_list_html_view_all = '';
		if($hide_all_events_view && empty($event))
			$events_list_html_view_all = '<li><a href="#all-events' . ($id!='' ? '-' . urlencode($id) : '') . '" title="' . esc_attr($filter_label) . '">' . $filter_label . '</a></li>';
		
		$output .= '<ul class="timetable_clearfix tt_tabs_navigation events_filter"' . ($filter_style=="dropdown_list" ? ' style="display: none;"' : '') . '>' . $events_list_html_view_all . $events_list_html . '</ul>';
	}
	if($filter_kind=="event_category" || $filter_kind=="event_and_event_category")
	{
		$events_categories_list_html_view_all = '';
		if($hide_all_events_view && empty($event_category))
			$events_categories_list_html_view_all = '<li><a href="#all-events' . ($id!='' ? '-' . urlencode($id) : '') . '" title="' . esc_attr(($filter_kind=="event_and_event_category" ? $filter_label_2 : $filter_label)) . '">' . ($filter_kind=="event_and_event_category" ? $filter_label_2 : $filter_label) . '</a></li>';
		
		$output .= '<ul class="timetable_clearfix tt_tabs_navigation events_categories_filter"' . ($filter_style=="dropdown_list" ? ' style="display: none;"' : '') . '>' .  $events_categories_list_html_view_all . $events_categories_list_html . '</ul>';
	}
	
	$output .= '</div>';
	
	if($export_to_pdf_button && $filter_style=='tabs' && $responsive)
	{
		$pdf_text_color = (strtoupper($generate_pdf_text_color)!="FFFFFF" ? $generate_pdf_text_color : "");
		$pdf_bg_color = (strtoupper($generate_pdf_bg_color)!="00A27C" ? $generate_pdf_bg_color : "");
		$pdf_hover_text_color = (strtoupper($generate_pdf_hover_text_color)!="FFFFFF" || $pdf_text_color!="" ? $generate_pdf_hover_text_color : "");
		$pdf_hover_bg_color = (strtoupper($generate_pdf_hover_bg_color)!="1F736A" || $pdf_bg_color!="" ? $generate_pdf_hover_bg_color : "");
		
		$output .=
			"<div class='tt_navigation_cell timetable_clearfix'>
				<form class='tt_generate_pdf' action='' method='post'>
					<textarea class='tt_pdf_html' name='tt_pdf_html_content'></textarea>
					<input type='hidden' name='tt_action' value='tt_generate_pdf'/>
					<input type='hidden' name='tt_pdf_font' value='" . $pdf_font . "'/>
					<input type='submit' value='" . $generate_pdf_label . "' style='" . (strlen($pdf_text_color) ? " color: #" . $pdf_text_color . " !important;" : "") . (strlen($pdf_bg_color) ? " background-color: #" . $pdf_bg_color . ";" : "") . "' onMouseOver='" . (strlen($pdf_hover_text_color) ? " this.style.setProperty(\"color\", \"#" . $pdf_hover_text_color . "\", \"important\");" : "") . (strlen($pdf_hover_bg_color) ? " this.style.setProperty(\"background\", \"#" . $pdf_hover_bg_color . "\", \"important\");" : "") . "' onMouseOut='" . (strlen($pdf_hover_text_color) ? (strlen($pdf_text_color) ? " this.style.setProperty(\"color\", \"#" . $pdf_text_color . "\", \"important\");" : " this.style.color=\"\";") : "") . (strlen($pdf_hover_bg_color) ? (strlen($pdf_bg_color) ? " this.style.setProperty(\"background\", \"#" . $pdf_bg_color . "\", \"important\");" : " this.style.background=\"\";") : "") . "'/>
				</form>
			</div>";
	}
	
	$output .= '</div>';
	
	if(!$hide_all_events_view)
	{
		$output .= '<div id="all-events' . ($id!='' ? '-' . urlencode($id) : '') . '">' . (empty($events_array_verified) ? tt_get_timetable($atts, $events_array) : ($events_array_verified!=-1 ? tt_get_timetable($atts, $events_array_verified) : sprintf(__('No %s available!' , 'timetable'), strtolower($timetable_events_settings['label_plural'])))) . '</div>';		
	}

	if($filter_kind=="event" || !count($event_category_array) || $filter_kind=="event_and_event_category")
	{
		for($i=0; $i<$events_array_count; $i++)
		{			
			$post = get_page_by_path($events_array[$i], ARRAY_A, $timetable_events_settings['slug']);					
			$categories = wp_get_post_terms($post["ID"], "events_category");
			$categories_str = "";
			foreach($categories as $category)
				$categories_str .= "tt-event-category-" . $category->slug . ($id!='' ? '-' . urlencode($id) : '') . " ";
			$output .= '<div id="' . urlencode($events_array[$i]) . ($id!='' ? '-' . urlencode($id) : '') . '" class="tt-ui-tabs-hide ' . $categories_str . '">' . (empty($events_array_verified) || ($events_array_verified!=-1 && in_array($events_array[$i], $events_array_verified)) ? tt_get_timetable($atts, $events_array[$i]) : sprintf(__('No %s available!' , 'timetable'), strtolower($timetable_events_settings['label_plural']))) . '</div>';			
		}
	}
	if($filter_kind=="event_category" || $filter_kind=="event_and_event_category")
	{
		for($i=0; $i<$events_category_array_count; $i++)
		{
			$events_array_posts = array();
			$events_array_posts = get_posts(array(
				'include' => (array)$events_array_id,
				'post_type' => $timetable_events_settings['slug'],
				'post_status' => 'publish',
				'events_category' => $event_category_array[$i],
				'posts_per_page' => -1,
				'nopaging' => true
			));
			$events_array_for_timetable = array();
			for($j=0; $j<count($events_array_posts); $j++)
				$events_array_for_timetable[] = urldecode($events_array_posts[$j]->post_name);
			$output .= '<div id="' . urlencode($event_category_array[$i]) . ($id!='' ? '-' . urlencode($id) : '') . '" class="tt-ui-tabs-hide">' . (count($events_array_posts) ? tt_get_timetable($atts, $events_array_for_timetable) : sprintf(__('No %1$s available in %2$s category!', 'timetable'), strtolower($timetable_events_settings['label_plural']), $event_category_array[$i])) . '</div>';			
		}
	}
	$output .= '</div>';
	
	$output .= "<div class='tt_error_message tt_hide'>" . sprintf(__('No %s available!' , 'timetable'), strtolower($timetable_events_settings['label_plural'])) . "</div>";
	
	$output .= 	
	"<div class='tt_booking_overlay tt_hide'>
	</div>
	<div class='tt_booking tt_hide'>
		<div class='tt_booking_message_wrapper'>
			<div class='tt_booking_message' data-event-hour-id>
			</div>
			<div class='tt_preloader tt_hide'>
				<div class='bounce1'></div>
				<div class='bounce2'></div>
				<div class='bounce3'></div>
			</div>
		</div>
	</div>";

	$output .= '<input type="hidden" class="timetable_atts" name="timetable_atts" value="' . htmlentities(json_encode($atts2)) . '" />';
	$output .= "</div>";
	
	wp_add_inline_style('timetable_inline_style', $inline_style);
	return $output;
}
add_shortcode("tt_timetable", "tt_timetable");

/**
 * Generates the Timetable HTML code
 * 
 * @param type $atts - timetable options
 * @param type $event - events that will be displayed
 * @return string - Timetable HTML code
 */
function tt_get_timetable($atts, $event = null)
{
	$timetable_events_settings = timetable_events_settings();
	
	extract(shortcode_atts(array(
		'events_page' => '',
		'measure' => 1,
		'filter_style' => 'dropdown_list',
		'filter_label' => 'All Events',
		'show_booking_button' => 'no',
		'show_available_slots' => 'no',
		'available_slots_singular_label' => '{number_available}/{number_total} slot available',
		'available_slots_plural_label' => '{number_available}/{number_total} slots available',
		'allow_user_booking' => 'yes',
	    'allow_guest_booking' => 'no',
	    'default_booking_view' => 'user',
		'show_guest_name_field' => 'yes',
		'guest_name_field_required' => 'yes',
		'show_guest_phone_field' => 'no',
		'guest_phone_field_required' => 'no',
		'show_guest_message_field' => 'no',
		'guest_message_field_required' => 'no',
		'booking_label' => 'Book now',
		'booked_label' => 'Booked',
		'unavailable_label' => 'Unavailable',
		'hour_category' => '',
		'columns' => '',
		'time_format' => 'H.i',
		'hide_hours_column' => 0,
		'show_end_hour' => 0,
		'event_layout' => 1,
		'box_bg_color' => '00A27C',
		'box_hover_bg_color' => '1F736A',
		'box_txt_color' => 'FFFFFF',
		'box_hover_txt_color' => 'FFFFFF',
		'box_hours_txt_color' => 'FFFFFF',
		'box_hours_hover_txt_color' => 'FFFFFF',
		'row1_color' => 'F0F0F0',
		'row2_color' => '',
		'generate_pdf_text_color' => 'FFFFFF',
		'generate_pdf_bg_color' => '00A27C',
		'generate_pdf_hover_text_color' => 'FFFFFF',
		'generate_pdf_hover_bg_color' => '1F736A',
		'booking_text_color' => 'FFFFFF',
		'booking_bg_color' => '05BB90',
		'booking_hover_text_color' => 'FFFFFF',
		'booking_hover_bg_color' => '07B38A',
		'booked_text_color' => 'AAAAAA',
		'booked_bg_color' => 'EEEEEE',
		'unavailable_text_color' => 'AAAAAA',
		'unavailable_bg_color' => 'EEEEEE',
		'available_slots_color' => 'FFD544',
		'hide_empty' => 0,
		'disable_event_url' => 0,
		'text_align' => 'center',
		'row_height' => 31,
		'id' => '',
		'desktop_list_view' => 0,
		'responsive' => 1,
		'event_description_responsive' => 'none',
		'collapse_event_hours_responsive' => 0,
		'colors_responsive_mode' => 0,
	), $atts));
	//remove leading '#' hash character
	$color_params = array('box_bg_color','box_hover_bg_color','box_txt_color','box_hover_txt_color','box_hours_txt_color','box_hours_hover_txt_color','filter_color','row1_color','row2_color','generate_pdf_text_color','generate_pdf_bg_color','generate_pdf_hover_text_color','generate_pdf_hover_bg_color','booking_text_color','booking_bg_color','booking_hover_text_color','booking_hover_bg_color','booked_text_color','booked_bg_color','unavailable_text_color','unavailable_bg_color','available_slots_color');
	foreach($color_params as $color_param)
	{
		if(!empty($$color_param))
			$$color_param = ltrim($$color_param, "#");
	}
	$measure = (double)$measure;
	
	$user_id = ($allow_user_booking=='yes' ? get_current_user_id() : 0);
	
	global $wpdb;
	if($columns!="")
	{
		$weekdays_explode = explode(",", $columns);
		$weekdays_in_query = "";
		foreach($weekdays_explode as $weekday_explode)
			$weekdays_in_query .= "'" . tt_strtolower_urlencode($weekday_explode) . "'" . ($weekday_explode!=end($weekdays_explode) ? "," : "");
	}
	if($hour_category!=null && $hour_category!="-")
		$hour_category = array_values(array_diff(array_filter(array_map('trim', explode(",", $hour_category))), array("-")));
	$output = "";
	$query = 
	"SELECT 
		TIME_FORMAT(t1.start, '%H.%i') AS start, 
		TIME_FORMAT(t1.end, '%H.%i') AS end, 
		t1.tooltip AS tooltip, 
		t1.before_hour_text AS before_hour_text, 
		t1.after_hour_text AS after_hour_text, 
		t1.available_places AS available_places, 
		t1.slots_per_user, 
		COALESCE(t4.booking_count,0) AS booking_count,		
		t1.event_hours_id AS event_hours_id, 
		t2.ID AS event_id, 
		t2.post_title AS event_title, 
		t2.post_name AS post_name, 
		t3.post_title, 
		t3.menu_order,
		COALESCE(t6.booking_count,0) AS current_user_booking_count	
	FROM " . $wpdb->prefix . "event_hours AS t1 
		LEFT JOIN {$wpdb->posts} AS t2 ON t1.event_id=t2.ID 
		LEFT JOIN {$wpdb->posts} AS t3 ON t1.weekday_id=t3.ID 
		LEFT JOIN (SELECT event_hours_id, COALESCE(COUNT(booking_id),0) as booking_count FROM " . $wpdb->prefix . "event_hours_booking GROUP BY event_hours_id) AS t4 ON t1.event_hours_id=t4.event_hours_id 
		LEFT JOIN (SELECT event_hours_id, user_id, COUNT(booking_id) as booking_count FROM " . $wpdb->prefix . "event_hours_booking where user_id= " . (int)$user_id . " and user_id!=0 GROUP BY event_hours_id) AS t6 ON t1.event_hours_id=t6.event_hours_id ";
	
	$query .=
	" WHERE 
		t2.post_type='" . $timetable_events_settings['slug'] . "'
		AND t2.post_status='publish'";
	if(is_array($event) && count($event))
		$query .= "
			AND t2.post_name IN('" . implode("','", array_map("tt_strtolower_urlencode", $event)) . "')";
	else if($event!=null)
		$query .= "
			AND t2.post_name='" . tt_strtolower_urlencode($event) . "'";
	if($hour_category!=null && $hour_category!="-")
		$query .= "
			AND t1.category IN('" . join("','", $hour_category) . "')";
	$query .= "
			AND 
			t3.post_type='timetable_weekdays'
			AND
			t3.post_status='publish'";
	if(isset($weekdays_in_query) && $weekdays_in_query!="")
		$query .= " AND t3.post_name IN(" . $weekdays_in_query . ")";
	//$query .= " ORDER BY FIELD(t3.menu_order,2,3,4,5,6,7,1), t1.start, t1.end";
	$query .= " ORDER BY t3.menu_order, t1.start, t1.end, t2.post_name";
	$event_hours = $wpdb->get_results($query);
	
	if(!count($event_hours))
		return sprintf(__('No %s hours available!' , 'timetable'), strtolower($timetable_events_settings['label_plural']));
	$event_hours_tt = array();
	foreach($event_hours as $event_hour)
	{
		//$event_hours_tt[($event_hour->menu_order>1 ? $event_hour->menu_order-1 : 7)][] = array(
		$event_hours_tt[$event_hour->menu_order][] = array(
			"start" => $event_hour->start,
			"end" => $event_hour->end,
			"tooltip" => $event_hour->tooltip,
			"before_hour_text" => $event_hour->before_hour_text,
			"after_hour_text" => $event_hour->after_hour_text,
			"available_places" => $event_hour->available_places,
			"slots_per_user" => $event_hour->slots_per_user,
			"booking_count" => (is_null($event_hour->booking_count) ? 0 : $event_hour->booking_count),
			"current_user_booking_count" => (isset($event_hour->current_user_booking_count) ? $event_hour->current_user_booking_count : 0),
			"event_hours_id" => $event_hour->event_hours_id,
			"tooltip" => $event_hour->tooltip,
			"id" => $event_hour->event_id,
			"title" => $event_hour->event_title,
			"name" => $event_hour->post_name
		);
	}
	
	//get weekdays
	$query = "SELECT post_title, menu_order FROM {$wpdb->posts}
			WHERE 
			post_type='timetable_weekdays'
			AND post_status='publish'";
	if(isset($weekdays_in_query) && $weekdays_in_query!="")
		$query .= " AND post_name IN(" . $weekdays_in_query . ")";
	//$query .= " ORDER BY FIELD(menu_order,2,3,4,5,6,7,1)";
	$query .= " ORDER BY menu_order";
	$weekdays = $wpdb->get_results($query);
	
	//get min anx max hour
	$query = "SELECT min(TIME_FORMAT(t1.start, '%H.%i')) AS min, max(REPLACE(TIME_FORMAT(t1.end, '%H.%i'), '00.00', '24.00')) AS max FROM " . $wpdb->prefix . "event_hours AS t1
			LEFT JOIN {$wpdb->posts} AS t2 ON t1.event_id=t2.ID 
			LEFT JOIN {$wpdb->posts} AS t3 ON t1.weekday_id=t3.ID 
			WHERE 
			t2.post_type='" . $timetable_events_settings['slug'] . "'
			AND t2.post_status='publish'";
	if(is_array($event) && count($event))
		$query .= "
			AND t2.post_name IN('" . implode("','", array_map("tt_strtolower_urlencode", $event)) . "')";
	else if($event!=null)
		$query .= "
			AND t2.post_name='" . tt_strtolower_urlencode($event) . "'";
	if($hour_category!=null && $hour_category!="-")
		$query .= "
			AND t1.category IN('" . join("','", $hour_category) . "')";
	$query .= "
			AND 
			t3.post_type='timetable_weekdays'
			AND
			t3.post_status='publish'";
	if(isset($weekdays_in_query) && $weekdays_in_query!="")
		$query .= " AND t3.post_name IN(" . $weekdays_in_query . ")";
	$hours = $wpdb->get_row($query);
	$drop_columns = array();
	$l = 0;
	$increment = 1;
	$hours_min = (int)$hours->min;
	
	if(!(int)$desktop_list_view)
	{
		$output .= '<table class="tt_timetable">
					<thead>
						<tr class="row_gray"' . ($row1_color!="" ? ' style="background-color: ' . ($row1_color!="transparent" ? '#' : '') . $row1_color . ' !important;"' : '') . '>';
						if(!(int)$hide_hours_column)
							$output .= '<th></th>';

		foreach($weekdays as $weekday)
		{
			$output .= '	<th>' . $weekday->post_title . '</th>';
		}
		$output .= '	</tr>
					</thead>
					<tbody>';

		if((int)$measure==1)
		{
			$max_explode = explode(".", $hours->max);
			$max_hour = (int)$hours->max + (!empty($max_explode[1]) && (int)$max_explode[1]>0 ? 1 : 0);
		}
		else
		{
			$max_hour = $hours->max;
			$max_hour = to_decimal_time($max_hour);
			$max_hour = get_next_row_hour($max_hour, $measure);
			$increment = (double)$measure;
			$hours_min = to_decimal_time(roundMin($hours->min, $measure, to_decimal_time($hours_min)));
		}
		for($i=$hours_min; $i<$max_hour; $i=$i+$increment)
		{
			if((int)$measure==1)
			{
				$start = str_pad($i, 2, '0', STR_PAD_LEFT) . '.00';
				$end = str_replace("24", "00", str_pad($i+1, 2, '0', STR_PAD_LEFT)) . '.00';
			}
			else
			{
				$i = number_format($i, 2);
				$hourIExplode = explode(".", $i);
				$hourI = $hourIExplode[0] . "." . ((int)$hourIExplode[1]>0 ? (int)$hourIExplode[1]*60/100 : "00");
				$start = number_format($i, 2);
				$end = number_format(str_replace("24", "00", $i+$measure), 2);
				$startExplode = explode(".", $start);
				$start = str_pad($startExplode[0], 2, '0', STR_PAD_LEFT) . "." . ((int)$startExplode[1]>0 ? (int)$startExplode[1]*60/100 : "00");
				$endExplode = explode(".", $end);
				$end = str_pad($endExplode[0], 2, '0', STR_PAD_LEFT) . "." . ((int)$endExplode[1]>0 ? (int)$endExplode[1]*60/100 : "00");
			}
			if($time_format!="H.i")
			{
				$start = date($time_format, strtotime($start));
				$end = date($time_format, strtotime($end));
			}

		/*$max_explode = explode(".", $hours->max);
		$max_hour = (int)$hours->max + ((int)$max_explode[1]>0 ? 1 : 0);
		for($i=(int)$hours->min; $i<$max_hour; $i++)
		{
			$start = str_pad($i, 2, '0', STR_PAD_LEFT) . '.00';
			$end = str_replace("24", "00", str_pad($i+1, 2, '0', STR_PAD_LEFT)) . '.00';
			if($time_format!="H.i")
			{
				$start = date($time_format, strtotime($start));
				$end = date($time_format, strtotime($end));
			}*/

			$row_empty = true;
			$temp_empty_count = 0;
			$row_content = "";
			for($j=0; $j<count($weekdays); $j++)
			{
				//$weekday_fixed_number = ($weekdays[$j]->menu_order>1 ? $weekdays[$j]->menu_order-1 : 7);
				$weekday_fixed_number = $weekdays[$j]->menu_order;
				if(!in_array($weekday_fixed_number, (array)(isset($drop_columns[$i]["columns"]) ? $drop_columns[$i]["columns"] : array())))
				{	
					if(tt_hour_in_array($i, (isset($event_hours_tt[$weekday_fixed_number]) ? $event_hours_tt[$weekday_fixed_number] : array()), $measure, $hours_min))
					{
						$rowspan = tt_get_rowspan_value($i, $event_hours_tt[$weekday_fixed_number], 1, $measure, $hours_min);
						if($rowspan>1)
						{
							if((int)$measure==1)
							{
								for($k=1; $k<$rowspan; $k++)
									$drop_columns[$i+$k]["columns"][] = $weekday_fixed_number;	
							}
							else
							{
								for($k=$measure; $k<$rowspan*$measure; $k=$k+$measure)
								{
									$tmp = number_format($i+$k, 2);
									$drop_columns["$tmp"]["columns"][] = $weekday_fixed_number;	
								}
							}
						}
						$array_count = count($event_hours_tt[$weekday_fixed_number]);
						$hours = array();
						if((int)$measure==1)
						{
							for($k=(int)$i; $k<(int)$i+$rowspan; $k++)
								$hours[] = $k;
						}
						else
						{
							for($k=(double)$i; $k<(double)$i+$rowspan*$measure; $k=$k+$measure)
								$hours[] = $k;
						}
						$events = array();
						for($k=0; $k<$array_count; $k++)
						{
							if(((int)$measure==1 && in_array((int)$event_hours_tt[$weekday_fixed_number][$k]["start"], $hours)) || ((int)$measure!=1 && in_array(to_decimal_time(roundMin($event_hours_tt[$weekday_fixed_number][$k]["start"], $measure, $hours_min)), $hours)))
							{
								$events[$k]["name"] = $event_hours_tt[$weekday_fixed_number][$k]["name"];
								$events[$k]["title"] = $event_hours_tt[$weekday_fixed_number][$k]["title"];
								$events[$k]["tooltip"][] = $event_hours_tt[$weekday_fixed_number][$k]["tooltip"];
								$events[$k]["before_hour_text"][] = $event_hours_tt[$weekday_fixed_number][$k]["before_hour_text"];
								$events[$k]["after_hour_text"][] = $event_hours_tt[$weekday_fixed_number][$k]["after_hour_text"];
								$events[$k]["available_places"][] = $event_hours_tt[$weekday_fixed_number][$k]["available_places"];
								$events[$k]["slots_per_user"][] = $event_hours_tt[$weekday_fixed_number][$k]["slots_per_user"];
								$events[$k]["booking_count"][] = $event_hours_tt[$weekday_fixed_number][$k]["booking_count"];
								$events[$k]["current_user_booking_count"][] = $event_hours_tt[$weekday_fixed_number][$k]["current_user_booking_count"];
								$events[$k]["event_hours_id"][] = $event_hours_tt[$weekday_fixed_number][$k]["event_hours_id"];
								$events[$k]["id"] = $event_hours_tt[$weekday_fixed_number][$k]["id"];
								$events[$k]["hours"][] = $event_hours_tt[$weekday_fixed_number][$k]["start"] . " - " . $event_hours_tt[$weekday_fixed_number][$k]["end"];
								$event_hours_tt[$weekday_fixed_number][$k]["displayed"] = true;
							}
						}
						$color = "";
						$text_color = "";
						$hover_color = "";
						$hover_text_color = "";
						$hours_text_color = "";
						$hours_hover_text_color = "";
						if(count($events)==1 && count($events[key($events)]['hours'])==1)
						{
							$color = get_post_meta($events[key($events)]["id"], "timetable_color", true);
							if($color=="" && strtoupper($box_bg_color)!="00A27C")
								$color = $box_bg_color;
							$hover_color = get_post_meta($events[key($events)]["id"], "timetable_hover_color", true);
							if($hover_color=="" && (strtoupper($box_hover_bg_color)!="1F736A" || $color!=""))
								$hover_color = $box_hover_bg_color;
							$text_color = get_post_meta($events[key($events)]["id"], "timetable_text_color", true);
							if($text_color=="" && strtoupper($box_txt_color)!="FFFFFF")
								$text_color = $box_txt_color;
							$hover_text_color = get_post_meta($events[key($events)]["id"], "timetable_hover_text_color", true);
							if($hover_text_color=="" && (strtoupper($box_hover_txt_color)!="FFFFFF" || $text_color!=""))
							{
								$hover_text_color = $box_hover_txt_color;
								if($text_color=="")
									$text_color = "FFFFFF";
							}
							$hours_text_color = get_post_meta($events[key($events)]["id"], "timetable_hours_text_color", true);
							if($hours_text_color=="" && strtoupper($box_hours_txt_color)!="FFFFFF")
								$hours_text_color = $box_hours_txt_color;
							$hours_hover_text_color = get_post_meta($events[key($events)]["id"], "timetable_hours_hover_text_color", true);
							if($hours_hover_text_color=="" && (strtoupper($box_hours_hover_txt_color)!="FFFFFF" || $hours_text_color!=""))
							{
								$hours_hover_text_color = $box_hours_hover_txt_color;
								if($hours_text_color=="")
									$hours_text_color = "FFFFFF";
							}
						}

						$booking_text_color = ($booking_text_color!="" && strtoupper($booking_text_color)!="FFFFFF" ? $booking_text_color : "");
						$booking_bg_color = ($booking_bg_color!="" && strtoupper( $booking_bg_color)!="05BB90" ? $booking_bg_color : "");
						$booking_hover_text_color = ($booking_hover_text_color!="" && (strtoupper($booking_hover_text_color)!="FFFFFF" || $booking_text_color!="") ? $booking_hover_text_color : "");
						$booking_hover_bg_color = ($booking_hover_bg_color!="" && (strtoupper($booking_hover_bg_color)!="07B38A" || $booking_bg_color!="") ? $booking_hover_bg_color : "");
						$unavailable_text_color = ($unavailable_text_color!="" && strtoupper($unavailable_text_color)!="AAAAAA" ? $unavailable_text_color : "");
						$unavailable_bg_color = ($unavailable_bg_color!="" && strtoupper($unavailable_bg_color)!="EEEEEE" ? $unavailable_bg_color : "");
						$booked_text_color = ($booked_text_color!="" && strtoupper($booked_text_color)!="AAAAAA" ? $booked_text_color : "");
						$booked_bg_color = ($booked_bg_color!="" && strtoupper($booked_bg_color)!="EEEEEE" ? $booked_bg_color : "");
						$available_slots_color = ($available_slots_color!="" && strtoupper($available_slots_color)!="FFD544" ? $available_slots_color : "");

						$global_colors = array(
							"box_bg_color" => $box_bg_color,
							"box_hover_bg_color" => $box_hover_bg_color,
							"box_txt_color" => $box_txt_color,
							"box_hover_txt_color" => $box_hover_txt_color,
							"box_hours_txt_color" => $box_hours_txt_color,
							"box_hours_hover_txt_color" => $box_hours_hover_txt_color,
							"booking_text_color" => ($booking_text_color),
							"booking_bg_color" => ($booking_bg_color),
							"booking_hover_text_color" => ($booking_hover_text_color),
							"booking_hover_bg_color" => ($booking_hover_bg_color),
							"booked_text_color" => ($booked_text_color),
							"booked_bg_color" => ($booked_bg_color),
							"unavailable_text_color" => ($unavailable_text_color),
							"unavailable_bg_color" => ($unavailable_bg_color),
							"available_slots_color" => ($available_slots_color),
						);
						$row_content .= '<td' . ($color!="" || $text_color!="" || $text_align!="center" ? ' style="' . ($text_align!="center" ? 'text-align:' . $text_align . ';' : '') . ($color!="" ? 'background: #' . $color . ';' : '') . ($text_color!="" ? 'color: #' . $text_color . ';' : '') . '"': '') . ($hover_color!="" || $hover_text_color!="" || $hours_hover_text_color!="" ? ' onMouseOver="' . ($hover_color!="" ? 'this.style.background=\'#'.$hover_color.'\';' : '') . ($hover_text_color!="" ? 'this.style.color=\'#'.$hover_text_color.'\';jQuery(this).find(\'.event_header\').css(\'cssText\', \'color: #'.$hover_text_color.' !important\');' : '') . ($hours_hover_text_color!="" ? 'jQuery(this).find(\'.hours\').css(\'color\',\'#'.$hours_hover_text_color.'\');' : '') . '" onMouseOut="' . ($hover_color!="" ? 'this.style.background=\'#'.$color.'\';' : '') . ($hover_text_color!="" ? 'this.style.color=\'#'.$text_color.'\';jQuery(this).find(\'.event_header\').css(\'cssText\',\'color: #'.$text_color.' !important\');' : '') . ($hours_hover_text_color!="" ? 'jQuery(this).find(\'.hours\').css(\'color\',\'#'.$hours_text_color.'\');' : '') . '"' : '') . ' class="event' . (count(array_filter(array_values($events[key($events)]['tooltip']))) && count($events)==1 && count($events[key($events)]['hours'])==1 ? ' tt_tooltip' : '' ) . (count($events)==1 && count($events[key($events)]['hours'])==1 ? ' tt_single_event' : '') . '"' . ($rowspan>1 ? ' rowspan="' . $rowspan . '"' : '') . '>';
						$row_content .= tt_get_row_content($events, compact("events_page", "time_format", "event_layout", "global_colors", "disable_event_url", "show_booking_button", "show_available_slots", "allow_user_booking", "allow_guest_booking", "default_booking_view", "booking_label", "available_slots_singular_label", "available_slots_plural_label", "booked_label", "unavailable_label"));
						$row_content .= '</td>';
						$row_empty = false;
					}
					else
						$row_content .= '<td></td>';
					$temp_empty_count++;
				}
			}
			if($temp_empty_count!=$j)
				$row_empty = false;
			if(((int)$hide_empty && !$row_empty) || !(int)$hide_empty)
			{
				$output .= '<tr class="row_' . ($l+1) . ($l%2==1 ? ' row_gray' : '') . '"' . ($l%2==1 && strtoupper($row1_color)!="F0F0F0" ? ' style="background: ' . ($row1_color!="transparent" ? '#' : '') . $row1_color . ' !important;"' : '') . ($l%2==0 && $row2_color!="" ? ' style="background: ' . ($row2_color!="transparent" ? '#' : '') . $row2_color . ' !important;"' : '') . '>';
				if(!(int)$hide_hours_column)
				{
					$output .= '<td class="tt_hours_column">
						' . $start . ((int)$show_end_hour ? ' - ' . $end : '') . '
					</td>';
				}
				$output .= $row_content;				
				$output .= '</tr>';
				$l++;
			}
		}
		$output .= '</tbody>
				</table>';
	}
	
	if((int)$desktop_list_view || (int)$responsive)
	{
		$output .= '<div class="tt_timetable small ' . ($colors_responsive_mode ? 'use_colors' : '') . ' ' . ((int)$desktop_list_view ? 'desktop' : '') . '">';
		$l = 0;
		foreach($weekdays as $weekday)
		{
			//$weekday_fixed_number = ($weekday->menu_order>1 ? $weekday->menu_order-1 : 7);
			$weekday_fixed_number = $weekday->menu_order;
			if(isset($event_hours_tt[$weekday_fixed_number]))
			{
				$output .= '<h3 class="box_header ' . ($collapse_event_hours_responsive ? 'plus ' : '') . ($l>0 ? ' page_margin_top' : '') . '">
					' . $weekday->post_title . '
				</h3>
				<ul class="tt_items_list thin page_margin_top timetable_clearfix' . (isset($mode) && $mode=='12h' ? ' mode12' : '') . '">';
					$event_hours_count = count($event_hours_tt[$weekday_fixed_number]);
						
					for($i=0; $i<$event_hours_count; $i++)
					{
						if($time_format!="H.i")
						{
							$event_hours_tt[$weekday_fixed_number][$i]["start"] = date($time_format, strtotime($event_hours_tt[$weekday_fixed_number][$i]["start"]));
							$event_hours_tt[$weekday_fixed_number][$i]["end"] = date($time_format, strtotime($event_hours_tt[$weekday_fixed_number][$i]["end"]));
						}
						$classes_url = "";
						$timetable_custom_url = get_post_meta($event_hours_tt[$weekday_fixed_number][$i]["id"], "timetable_custom_url", true);
						if(!(int)get_post_meta($event_hours_tt[$weekday_fixed_number][$i]["id"], "timetable_disable_url", true) && !(int)$disable_event_url)
							$classes_url = ($timetable_custom_url!="" ? $timetable_custom_url : get_permalink($event_hours_tt[$weekday_fixed_number][$i]["id"]));
						
						$colors_html = '';
						$list_colors_html = '';
						$text_colors_html = '';
						$hours_text_colors_html = '';
						
						if($colors_responsive_mode)
						{
							$color = get_post_meta($event_hours_tt[$weekday_fixed_number][$i]["id"], "timetable_color", true);
							if($color=="" && strtoupper($box_bg_color)!="00A27C")
								$color = $box_bg_color;
							$hover_color = get_post_meta($event_hours_tt[$weekday_fixed_number][$i]["id"], "timetable_hover_color", true);
							if($hover_color=="" && (strtoupper($box_hover_bg_color)!="1F736A" || $color!=""))
								$hover_color = $box_hover_bg_color;
							$text_color = get_post_meta($event_hours_tt[$weekday_fixed_number][$i]["id"], "timetable_text_color", true);
							if($text_color=="" && strtoupper($box_txt_color)!="FFFFFF")
								$text_color = $box_txt_color;
							$hover_text_color = get_post_meta($event_hours_tt[$weekday_fixed_number][$i]["id"], "timetable_hover_text_color", true);
							if($hover_text_color=="" && (strtoupper($box_hover_txt_color)!="FFFFFF" || $text_color!=""))
							{
								$hover_text_color = $box_hover_txt_color;
								if($text_color=="")
									$text_color = "FFFFFF";
							}
							$hours_text_color = get_post_meta($event_hours_tt[$weekday_fixed_number][$i]["id"], "timetable_hours_text_color", true);
							if($hours_text_color=="" && strtoupper($box_hours_txt_color)!="FFFFFF")
								$hours_text_color = $box_hours_txt_color;
							$hours_hover_text_color = get_post_meta($event_hours_tt[$weekday_fixed_number][$i]["id"], "timetable_hours_hover_text_color", true);
							if($hours_hover_text_color=="" && (strtoupper($box_hours_hover_txt_color)!="FFFFFF" || $hours_text_color!=""))
							{
								$hours_hover_text_color = $box_hours_hover_txt_color;
								if($hours_text_color=="")
									$hours_text_color = "FFFFFF";
							}
							
							$colors_html = ($color!="" || $text_color!="" ? ' style="' . ($color!="" ? 'background: #' . $color . ';' : '') . ($text_color!="" ? 'color: #' . $text_color . ';' : '') . '"': '') . ($hover_color!="" || $hover_text_color!="" || $hours_hover_text_color!="" ? ' onMouseOver="' . ($hover_color!="" ? 'this.style.background=\'#'.$hover_color.'\';' : '') . ($hover_text_color!="" ? 'this.style.color=\'#'.$hover_text_color.'\';jQuery(this).find(\'.event_header,.event_description\').css(\'cssText\', \'color: #'.$hover_text_color.' !important\');' : '') . ($hours_hover_text_color!="" ? 'jQuery(this).find(\'.value\').css(\'color\',\'#'.$hours_hover_text_color.'\');' : '') . '" onMouseOut="' . ($hover_color!="" ? 'this.style.background=\'#'.$color.'\';' : '') . ($hover_text_color!="" ? 'this.style.color=\'#'.$text_color.'\';jQuery(this).find(\'.event_header,.event_description\').css(\'cssText\',\'color: #'.$text_color.' !important\');' : '') . ($hours_hover_text_color!="" ? 'jQuery(this).find(\'.value\').css(\'color\',\'#'.$hours_text_color.'\');' : '') . '"' : '');
							$text_colors_html = ($text_color!="" ? ' style="color: #' . $text_color . ' !important;"' : '');
							$hours_text_colors_html = ($hours_text_color!="" ? ' style="color:#' . $hours_text_color . ';"' : '');
						}
						
						$output .= '
							<li ' . $colors_html . ' class="timetable_clearfix">
								<div class="event_container">
									<' . ($classes_url!="" ? 'a' : 'span') . ($classes_url!="" ? ' href="' . $classes_url . '"' : '') . ' title="' .  esc_attr($event_hours_tt[$weekday_fixed_number][$i]["title"]) . '"' . ' class="event_header" ' . $text_colors_html . '>' . $event_hours_tt[$weekday_fixed_number][$i]["title"] . ' </' . ($classes_url!="" ? 'a' : 'span') . '>';
						
						if(in_array($event_description_responsive, array("description-2", "description-1", "description-1-and-description-2")) && ($event_hours_tt[$weekday_fixed_number][$i]["before_hour_text"] || $event_hours_tt[$weekday_fixed_number][$i]["after_hour_text"]))
						{
							$output .= '<span class="event_description" ' . $text_colors_html . '>'.
								(in_array($event_description_responsive, array("description-1", "description-1-and-description-2")) ? '<span class="event_description_1">'.do_shortcode($event_hours_tt[$weekday_fixed_number][$i]["before_hour_text"]).'</span>' : '') .
								(in_array($event_description_responsive, array("description-1-and-description-2")) && $event_hours_tt[$weekday_fixed_number][$i]["before_hour_text"]!="" && $event_hours_tt[$weekday_fixed_number][$i]["after_hour_text"]!="" ? '<span class="event_description_dot"> &middot; </span>' : '') . 
								(in_array($event_description_responsive, array("description-2", "description-1-and-description-2")) ? '<span class="event_description_2">'.do_shortcode($event_hours_tt[$weekday_fixed_number][$i]["after_hour_text"]).'</span>' : '') .
							'</span>';
						}
						
						$taken_slots = $event_hours_tt[$weekday_fixed_number][$i]["booking_count"];
						$total_slots = $event_hours_tt[$weekday_fixed_number][$i]["available_places"];
						$available_slots = $total_slots-$taken_slots;

						if($show_booking_button!="no")
						{
							if($show_available_slots=="always" && $total_slots)
							{
								$booking_slots_label = prepare_booking_slots_label(array(
									'available_slots' => $available_slots,
									'taken_slots' => $taken_slots,
									'total_slots' => $total_slots,
									'available_slots_singular_label' => $available_slots_singular_label,
									'available_slots_plural_label' => $available_slots_plural_label,
								));
								
								$output .= "<span class='available_slots id-" . $event_hours_tt[$weekday_fixed_number][$i]["event_hours_id"] . "'>";
								$output .= $booking_slots_label;
								$output .=
								"</span>";
							}
						}
						
						$output .= '</div>';
						
						$output .= '<div class="value" ' . $hours_text_colors_html . '>
									<span class="start-hour">' . $event_hours_tt[$weekday_fixed_number][$i]["start"] . '</span><span class="hour-separator"> - </span><span class="end-hour">' . $event_hours_tt[$weekday_fixed_number][$i]["end"] . "</span>";
						
						if($show_booking_button!="no")
						{
							$output .= prepare_booking_button(array(
								'current_user_booking_count' => (int)$event_hours_tt[$weekday_fixed_number][$i]["current_user_booking_count"],
								'slots_per_user' => $event_hours_tt[$weekday_fixed_number][$i]["slots_per_user"],
								'event_hours_id' => $event_hours_tt[$weekday_fixed_number][$i]["event_hours_id"],
								'booked_text_color' => $booked_text_color,
								'booked_bg_color' => $booked_bg_color,
								'booked_label' => $booked_label,
								'available_slots' => $available_slots,
								'unavailable_text_color' => $unavailable_text_color,
								'unavailable_bg_color' => $unavailable_bg_color,
								'unavailable_label' => $unavailable_label,
								'booking_text_color' => $booking_text_color,
								'booking_bg_color' => $booking_bg_color,
								'booking_hover_text_color' => $booking_hover_text_color,
								'booking_hover_bg_color' => $booking_hover_bg_color,
								'booking_label' => $booking_label,
								'show_booking_button' => $show_booking_button,
							));
						}
						
						$output .= 	'</div>
							</li>';
					}
				$output .= '</ul>';
				$l++;
			}
		}
		$output .= '</div>';
	}
	return $output;
}

function tt_get_row_content($events, $args)
{
	extract($args);
	$content = "";
	foreach($events as $key=>$details)
	{
		$color = "";
		$hover_color = "";
		$textcolor = "";
		$hover_text_color = "";
		$hours_text_color = "";
		$hours_count = count($details["hours"]);
		if(count($events)>1 || (count($events)==1 && $hours_count>1))
		{
			$color = get_post_meta($details["id"], "timetable_color", true);
			$hover_color = get_post_meta($details["id"], "timetable_hover_color", true);
			if($color=="" && strtoupper($global_colors["box_bg_color"])!="00A27C")
				$color = $global_colors["box_bg_color"];
			if($hover_color=="" && (strtoupper($global_colors["box_hover_bg_color"])!="1F736A" || $color!=""))
				$hover_color = $global_colors["box_hover_bg_color"];
		}
		$text_color = get_post_meta($details["id"], "timetable_text_color", true);
		if($text_color=="" && strtoupper($global_colors["box_txt_color"])!="FFFFFF")
			$text_color = $global_colors["box_txt_color"];
		$hover_text_color = get_post_meta($details["id"], "timetable_hover_text_color", true);
		if($hover_text_color=="" && (strtoupper($global_colors["box_hover_txt_color"])!="FFFFFF" || $text_color!=""))
		{
			$hover_text_color = $global_colors["box_hover_txt_color"];
			if($text_color=="")
				$text_color = "FFFFFF";
		}
		$hours_text_color = get_post_meta($details["id"], "timetable_hours_text_color", true);
		if($hours_text_color=="" && strtoupper($global_colors["box_hours_txt_color"])!="FFFFFF")
			$hours_text_color = $global_colors["box_hours_txt_color"];
		$hours_hover_text_color = get_post_meta($details["id"], "timetable_hours_hover_text_color", true);
		if($hours_hover_text_color=="" && (strtoupper($global_colors["box_hours_hover_txt_color"])!="FFFFFF" || $hours_text_color!=""))
		{
			$hours_hover_text_color = $global_colors["box_hours_hover_txt_color"];
			if($hours_text_color=="")
				$hours_text_color = "FFFFFF";
		}
		
		extract($global_colors);
		
		$timetable_custom_url = get_post_meta($details["id"], "timetable_custom_url", true);
		$classes_url = "";
		if(!(int)get_post_meta($details["id"], "timetable_disable_url", true) && !(int)$disable_event_url)
			$classes_url = ($timetable_custom_url!="" ? $timetable_custom_url : get_permalink($details["id"]));
		
		$class_link = '<' . ($classes_url!="" ? 'a' : 'span') . ' class="event_header"' . ($classes_url!="" ? ' href="' . $classes_url /*. '#' . urldecode($details["name"])*/ . '"' : '') . ' title="' .  esc_attr($details["title"]) . '"' . ($text_color!="" ? ' style="color: #' . $text_color . ' !important;"' : '') . '>' . $details["title"] . '</' . ($classes_url!="" ? 'a' : 'span') . '>';
				
		for($i=0; $i<$hours_count; $i++)
		{
			$tooltip = "";
			$content .= '<div class="event_container id-' . $details["id"] . (count(array_filter(array_values($details['tooltip']))) && (count($events)>1 || (count($events)==1 && $hours_count>1)) ? ' tt_tooltip' : '' ) . '"' . ($color!="" || ($text_color!="" && (count($events)>1 || (count($events)==1 && $hours_count>1))) ? ' style="' . ($color!="" ? 'background-color: #' . $color . ';' : '') . ($text_color!="" && (count($events)>1 || (count($events)==1 && $hours_count>1)) ? 'color: #' . $text_color . ';' : '') . '"': '') . (($hover_color!="" || $hover_text_color!="" || $hours_hover_text_color!="") && (count($events)>1 || (count($events)==1 && $hours_count>1)) ? ' onMouseOver="' . ($hover_color!="" ? 'this.style.background=\'#'.$hover_color.'\';' : '') . ($hover_text_color!="" ? 'this.style.color=\'#'.$hover_text_color.'\';jQuery(this).find(\'.event_header\').css(\'cssText\', \'color: #'.$hover_text_color.' !important\');' : '') . ($hours_hover_text_color!="" ? 'jQuery(this).find(\'.hours\').css(\'color\',\'#'.$hours_hover_text_color.'\');' : '') . '" onMouseOut="' . ($hover_color!="" ? 'this.style.background=\'#'.$color.'\';' : '') . ($hover_text_color!="" ? 'this.style.color=\'#'.$text_color.'\';jQuery(this).find(\'.event_header\').css(\'cssText\',\'color: #'.$text_color.' !important\');' : '') . ($hours_hover_text_color!="" ? 'jQuery(this).find(\'.hours\').css(\'color\',\'#'.$hours_text_color.'\');' : '') . '"' : '') . '>';
			$hoursExplode = explode(" - ", $details["hours"][$i]);
			$startHour = date($time_format, strtotime($hoursExplode[0]));
			$endHour = date($time_format, strtotime($hoursExplode[1]));
			
			$description1_content = "";
			if($details["before_hour_text"][$i]!="")
				$description1_content = "<div class='before_hour_text'>" . do_shortcode($details["before_hour_text"][$i]) . "</div>";
			$description2_content = "";
			if($details["after_hour_text"][$i]!="")
				$description2_content = "<div class='after_hour_text'>" . do_shortcode($details["after_hour_text"][$i]) . "</div>";			
			
			$top_hour_content = '<div class="top_hour"><span class="hours"' . ($hours_text_color!="" ? ' style="color:#' . $hours_text_color . ';"' : '') . '>' . $startHour . '</span></div>';
			$bottom_hour_content = '<div class="bottom_hour"><span class="hours"' . ($hours_text_color!="" ? ' style="color:#' . $hours_text_color . ';"' : '') . '>' . $endHour . '</span></div>';
			$hours_content = '<div class="hours_container"><span class="hours"' . ($hours_text_color!="" ? ' style="color:#' . $hours_text_color . ';"' : '') . '>' . $startHour . ' - ' . $endHour . '</span></div>';
			$class_link_tooltip = '<' . ($classes_url!="" ? 'a' : 'span') . ' class="event_header"' . ($hover_text_color!="" ? ' style="color: #' . $hover_text_color . ';"': '') . ($classes_url!="" ? ' href="' . $classes_url /*. '#' . urldecode($details["name"])*/ . '"' : '') . ' title="' .  esc_attr($details["title"]) . '">' . $details["title"] . '</' . ($classes_url!="" ? 'a' : 'span') . '>';
			$tooltip = ($details["tooltip"][$i]!="" ? $class_link_tooltip : '') . $details["tooltip"][$i];
			
			$booking_content = '';
			$booking_slots_html = '';
			if($show_booking_button!='no')
			{
				$taken_slots = $details['booking_count'][$i];
				$total_slots = $details['available_places'][$i];
				$available_slots = $total_slots-$taken_slots;
				
				$booking_content = prepare_booking_button(array(
					'current_user_booking_count' => $details['current_user_booking_count'][$i],
					'slots_per_user' => $details['slots_per_user'][$i],
					'event_hours_id' => $details["event_hours_id"][$i],
					'booked_text_color' => $booked_text_color,
					'booked_bg_color' => $booked_bg_color,
					'booked_label' => $booked_label,
					'available_slots' => $available_slots,
					'unavailable_text_color' => $unavailable_text_color,
					'unavailable_bg_color' => $unavailable_bg_color,
					'unavailable_label' => $unavailable_label,
					'booking_text_color' => $booking_text_color,
					'booking_bg_color' => $booking_bg_color,
					'booking_hover_text_color' => $booking_hover_text_color,
					'booking_hover_bg_color' => $booking_hover_bg_color,
					'booking_label' => $booking_label,
					'show_booking_button' => $show_booking_button,
				));

				if($show_available_slots=="always" && $total_slots)
				{
					$booking_slots_label = prepare_booking_slots_label(array(
						'available_slots' => $available_slots,
						'taken_slots' => $taken_slots,
						'total_slots' => $total_slots,
						'available_slots_singular_label' => $available_slots_singular_label,
						'available_slots_plural_label' => $available_slots_plural_label,
					));
					$booking_slots_html = "<span class='available_slots id-" . $details["event_hours_id"][$i] . "'>";
					$booking_slots_html .= $booking_slots_label;
					$booking_slots_html .= "</span>";
				}
			}
			
			if((int)$event_layout==1)
			{
				$content .= $class_link;
				$content .= $description1_content;
				$content .= $top_hour_content;
				$content .= $bottom_hour_content;
				$content .= $description2_content;
			}
			else if((int)$event_layout==2)
			{
				$content .= $top_hour_content;
				$content .= $bottom_hour_content;
				$content .= $description1_content;
				$content .= $class_link;
				$content .= $description2_content;
			}
			else if((int)$event_layout==3)
			{
				$content .= $class_link;
				$content .= $description1_content;
				$content .= $hours_content;
				$content .= $description2_content;
			}
			else if((int)$event_layout==4)
			{
				$content .= $class_link;
				$content .= $description1_content;
				$content .= $top_hour_content;
				$content .= $description2_content;
			}
			else if((int)$event_layout==5)
			{
				$content .= $class_link;
				$content .= $description1_content;
				$content .= $description2_content;
			}
			
			$content .= $booking_slots_html;
			
			if(count($events)==1 && $hours_count==1)
				$content .= '</div>';
			
			if($show_booking_button!="no")
				$content .= $booking_content;
			
			if($tooltip!="")
			{
				$hover_color = get_post_meta($details["id"], "timetable_hover_color", true);
				if($hover_color=="" && strtoupper($global_colors["box_hover_bg_color"])!="1F736A")
					$hover_color = $global_colors["box_hover_bg_color"];
				$content .= '<div class="tt_tooltip_text"><div class="tt_tooltip_content"' . ($hover_color!="" || $hover_text_color!="" ? ' style="' . ($hover_color!="" ? 'background-color: #' . $hover_color . ';' : '') . ($hover_text_color!="" ? 'color: #' . $hover_text_color . ';' : '') . '"': '') . '>' . $tooltip . '</div><div class="tt_tooltip_arrow"' . ($hover_color!="" ? ' style="border-color: #' . $hover_color . ' transparent;"' : '') . '></div></div>';	
			}
			if(count($events)>1 || (count($events)==1 && $hours_count>1))
				$content .= '</div>' . (end($events)!=$details || (end($events)==$details && $i+1<$hours_count) ? '<hr>' : '');
		}
		
		
		/*$content .= $class_link;
		$hours_count = count($details["hours"]);
		for($i=0; $i<$hours_count; $i++)
		{
			if($time_format!="H.i")
			{
				$hoursExplode = explode(" - ", $details["hours"][$i]);
				$details["hours"][$i] = date($time_format, strtotime($hoursExplode[0])) . " - " . date($time_format, strtotime($hoursExplode[1]));
			}
			$content .= ($i!=0 ? '<br />' : '');
			if($details["before_hour_text"][$i]!="")
				$content .= "<div class='before_hour_text'>" . $details["before_hour_text"][$i] . "</div>";
			$content .= '<span class="hours"' . ($hours_text_color!="" ? ' style="color:#' . $hours_text_color . ';"' : '') . '>' . $details["hours"][$i] . '</span>';
			if($details["after_hour_text"][$i]!="")
				$content .= "<div class='after_hour_text'>" . $details["after_hour_text"][$i] . "</div>";
			$class_link_tooltip = '<a' . ($hover_text_color!="" ? ' style="color: #' . $hover_text_color . ';"': '') . ' href="' . $classes_url . '#' . urldecode($details["name"]) . '" title="' .  esc_attr($key) . '">' . $key . '</a>';
			$tooltip .= ($tooltip!="" && $details["tooltip"][$i]!="" ? '<br /><br />' : '' ) . ($details["tooltip"][$i]!="" ? $class_link_tooltip : '') . $details["tooltip"][$i];
		}*/
		/*if(count($events)==1)
			$content .= '</div>';
		if($tooltip!="")
		{
			$hover_color = get_post_meta($details["id"], "timetable_hover_color", true);
			$content .= '<div class="tooltip_text"><div class="tooltip_content"' . ($hover_color!="" || $hover_text_color!="" ? ' style="' . ($hover_color!="" ? 'background-color: #' . $hover_color . ';' : '') . ($hover_text_color!="" ? 'color: #' . $hover_text_color . ';' : '') . '"': '') . '>' . $tooltip . '</div><span class="tooltip_arrow"' . ($hover_color!="" ? ' style="border-color: #' . $hover_color . ' transparent;"' : '') . '></span></div>';	
		}
		
		if(count($events)>1)
			$content .= '</div>' . (end($events)!=$details ? '<hr>' : '');*/
	}
	return $content;
}

function tt_get_rowspan_value($hour, $array, $rowspan, $measure, $hours_min)
{
	$array_count = count($array);
	$found = false;
	$hours = array();
	if((int)$measure==1)
	{
		for($i=(int)$hour; $i<(int)$hour+$rowspan; $i++)
			$hours[] = $i;
		for($i=0; $i<$array_count; $i++)
		{
			if(in_array((int)$array[$i]["start"], $hours))
			{
				$end_explode = explode(".", $array[$i]["end"]);
				$end_hour = (int)$array[$i]["end"] + ((int)$end_explode[1]>0 ? 1 : 0);
				if($end_hour-(int)$hour>1 && $end_hour-(int)$hour>$rowspan)
				{
					$rowspan = $end_hour-(int)$hour;
					$found = true;
				}
			}
		}
	}
	else
	{
		for($i=(double)$hour; $i<(double)$hour+$rowspan*$measure; $i=$i+$measure)
			$hours[] = $i;
		for($i=0; $i<$array_count; $i++)
		{
			if(in_array(to_decimal_time(roundMin($array[$i]["start"], $measure, $hours_min)), $hours))
			{
				$end_hour = to_decimal_time($array[$i]["end"], false); //changed to false - wrong value for ex. 00:30 end hour
				//$end_hour = ($end_hour<24 ? get_next_row_hour($end_hour, $measure) : $end_hour);
				$end_hour = get_next_row_hour($end_hour, $measure);
				if($end_hour-(double)$hour>$measure && ($end_hour-(double)$hour)/$measure>$rowspan)
				{
					$rowspan = ($end_hour-(double)$hour)/$measure;
					$found = true;
				}
			}
		}
	}
	if(!$found)
		return $rowspan;
	else
		return tt_get_rowspan_value($hour, $array, $rowspan, $measure, $hours_min);
}

function roundMin($time, $measure, $hours_min)
{
	/*echo "TIME:" . $time . "<br>";
	echo "HOURS_MIN:" . $hours_min . "<br>";
	$roundTo = $measure*60;
	$seconds = date('U', strtotime($time));
	return date("H.i", floor($seconds / ($roundTo * 60)) * ($roundTo * 60));*/
	
	$decimal_time = to_decimal_time($time);
	$found = false;
	while(!$found)
	{
		$hours_min=$hours_min+$measure;
		if($hours_min>$decimal_time)
			$found = true;
	}
	$hours_min = number_format($hours_min-$measure, 2);
	$hours_min_explode = explode(".", $hours_min);
	return str_pad($hours_min_explode[0], 2, '0', STR_PAD_LEFT) . "." . ((int)$hours_min_explode[1]>0 ? (int)$hours_min_explode[1]*60/100 : "00");
}

function tt_hour_in_array($hour, $array, $measure, $hours_min)
{
	$array_count = count($array);
	for($i=0; $i<$array_count; $i++)
	{
		if((int)$measure==1)
		{
			if((!isset($array[$i]["displayed"]) || (bool)$array[$i]["displayed"]!=true) && (int)$array[$i]["start"]==(int)$hour)
				return true;
		}
		else
		{
			if((!isset($array[$i]["displayed"]) || (bool)$array[$i]["displayed"]!=true) && to_decimal_time(roundMin($array[$i]["start"], $measure, $hours_min))==(double)$hour)
				return true;
		}
	}
	return false;
}

function to_decimal_time($time, $midReplace = false)
{
	$timeExplode = explode(".", $time);
	return ($midReplace && (int)$timeExplode[0]==0 ? 24 : $timeExplode[0]) . "." . (isset($timeExplode[1]) && (int)$timeExplode[1]>0 ? sprintf("%02s", ceil($timeExplode[1]/60*100)) : "00");
}

function get_next_row_hour($hour, $measure)
{
	$hourExplode = explode(".", $hour);
	if((int)$hourExplode[1]>0)
	{
		if((int)$hourExplode[1]+$measure*100>100)
		{
			$hour = (int)$hourExplode[0]+1;
			if($hour==24)
				$hour = 0;
			$minutes = "00";
		}
		else if(fmod((int)$hourExplode[1],(double)$measure*100)!=0)
		{
			for($i=0; $i<100; $i=$i+$measure*100)
			{
				if((int)$hourExplode[1]<$i)
				{
					$minutes = $i;
					break;
				}
			}
			$hour = (int)$hourExplode[0];
		}
		else
		{
			$hour = (int)$hourExplode[0];
			$minutes = (int)$hourExplode[1];
		}
	}
	else
	{
		$hour = (int)$hourExplode[0];
		$minutes = (int)$hourExplode[1];
	}
	if($hour . "." . $minutes == "0.00")
		return "24.00";
	return $hour . "." . $minutes;
}

function tt_strtolower_urlencode($val)
{
	return strtolower(urlencode($val));
}

/*function get_next_row_hour($hour, $measure, $next = 1)
{
	$hourExplode = explode(".", $hour);
	if((int)$hourExplode[1]>0)
	{
		if((int)$hourExplode[1]+$measure*100>=100)
		{
			$hour = (int)$hourExplode[0]+1;
			//if($hour==24)
				//$hour = 0;
			if((int)$hourExplode[1]+$measure*100==100 || !$next)
				$minutes = "00";
			else
				$minutes = $measure*100;
		}
		else
		{
			if(fmod((int)$hourExplode[1],(double)$measure*100)==0)
				$minutes = (int)$hourExplode[1];
			else
				for($i=0; $i<100; $i=$i+$measure*100)
				{
					if((int)$hourExplode[1]<$i)
					{
						$minutes = $i;
						break;
					}
				}
			$hour = (int)$hourExplode[0];
			if($next)
				$minutes = $minutes+$measure*100;
			if($minutes>100-$measure*100)
			{
				$hour = $hour+1;
				if($minutes==100 || !$next)
					$minutes = "00";
				else
					$minutes = $measure*100;
			}
		}
	}
	else
	{
		$hour = (int)$hourExplode[0];
		if($next)
			$minutes = $measure*100;
		else
			$minutes = (int)$hourExplode[1];
	}
	return $hour . "." . $minutes;
}*/

function timetable_vc_init()
{
	include_once(ABSPATH . 'wp-admin/includes/plugin.php');
	if(!is_plugin_active('js_composer/js_composer.php') || !function_exists('vc_map') || !function_exists('vc_add_shortcode_param'))
		return;
	//add support for multiple select field
	vc_add_shortcode_param('dropdownmulti' , 'timetable_vc_dropdownmultiple_settings_field');

	global $wpdb;		
	$timetable_events_settings = timetable_events_settings();

	//get saved shortcodes
	$timetable_shortcodes_list = get_option('timetable_shortcodes_list');
	$timetable_shortcodes_array = array(__('choose...', 'timetable') => '-1');
	if(!empty($timetable_shortcodes_list))
	{
		foreach($timetable_shortcodes_list as $key=>$val)
			$timetable_shortcodes_array[$key] = $key;
	}

	//get events list
	$events_list = get_posts(array(
		'posts_per_page' => -1,
		'nopaging' => true,
		'orderby' => 'title',
		'order' => 'ASC',
		'post_type' => $timetable_events_settings['slug']
	));
	$events_array = array();
	$events_array["All"] ="";
	foreach($events_list as $event)
		$events_array[$event->post_title . " (id:" . $event->ID . ")"] = urldecode($event->post_name);

	//get events categories list		
	$events_categories = get_terms(array(
		'taxonomy' => 'events_category',
		'orderby' => 'name',
		'order' => 'ASC',
	));
	$events_categories_array = array();
	$events_categories_array["All"] ="";
	foreach($events_categories as $events_category)
		$events_categories_array[$events_category->name] =  urldecode($events_category->slug);

	//get hour categories
	$query = "SELECT distinct(category) AS category FROM " . $wpdb->prefix . "event_hours AS t1
			LEFT JOIN {$wpdb->posts} AS t2 ON t1.event_id=t2.ID 
			WHERE 
			t2.post_type='" . $timetable_events_settings['slug'] . "'
			AND t2.post_status='publish'
			AND category<>''
			ORDER BY category ASC";
	$hour_categories = $wpdb->get_results($query);
	$hour_categories_array = array();
	$hour_categories_array["All"] ="";
	foreach($hour_categories as $hour_category)
		$hour_categories_array[$hour_category->category] =  $hour_category->category;

	//get columns
	$weekdays_list = get_posts(array(
		'posts_per_page' => -1,
		'nopaging' => true,
		'orderby' => 'menu_order',
		'order' => 'ASC',
		'post_type' => 'timetable_weekdays'
	));
	$weekdays_array = array();
	$weekdays_array["All"] ="";
	foreach($weekdays_list as $weekday)
		$weekdays_array[$weekday->post_title . " (id:" . $weekday->ID . ")"] = urldecode($weekday->post_name);

	//get google fonts
	$fontsArray = timetable_get_google_fonts();
	$google_fonts_array=array();
	$google_fonts_array["Default"]="";
	if(isset($fontsArray))
	{
		$fontsCount = count((array)$fontsArray->items);
		for($i=0; $i<$fontsCount; $i++)
		{
			$variantsCount = count((array)$fontsArray->items[$i]->variants);
			if($variantsCount>1)
			{
				for($j=0; $j<$variantsCount; $j++)
				{
					$google_fonts_array[$fontsArray->items[$i]->family . ":" . $fontsArray->items[$i]->variants[$j]] = $fontsArray->items[$i]->family . ":" . $fontsArray->items[$i]->variants[$j];
				}
			}
			else
			{
				$google_fonts_array[$fontsArray->items[$i]->family] = $fontsArray->items[$i]->family;
			}
		}
	}

	vc_map(array(
		"name" => __("Timetable", 'timetable'),
		"base" => "tt_timetable",
		"class" => "",
		"controls" => "full",
		"show_settings_on_create" => true,
		"icon" => "icon-wpb-layer-timetable",
		"admin_enqueue_js"  => array(plugin_dir_url(__FILE__).'/admin/js/timetable_vc.js'),
		"front_enqueue_js"  => array(plugin_dir_url(__FILE__).'/admin/js/timetable_vc.js'),
		"params" => array(
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Choose shortcode id:", "timetable"),
				"param_name" => "shortcode_id",
				"value" => $timetable_shortcodes_array,
			),
			array(
				"type" => "dropdownmulti",
				"class" => "",
				"heading" => __("Events", "timetable"),
				"param_name" => "event",
				"value" => $events_array,
			),
			array(
				"type" => "dropdownmulti",
				"class" => "",
				"heading" => __("Event categories", "timetable"),
				"param_name" => "event_category",
				"value" => $events_categories_array,
			),
			array(
				"type" => "dropdownmulti",
				"class" => "",
				"heading" => __("Hour categories", "timetable"),
				"param_name" => "hour_category",
				"value" => $hour_categories_array,
			),
			array(
				"type" => "dropdownmulti",
				"class" => "",
				"heading" => __("Columns", "timetable"),
				"param_name" => "columns",
				"value" => $weekdays_array,
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Hour measure", "timetable"),
				"param_name" => "measure",
				"value" => array(
					__("Hour (1h)", "timetable") => "1",
					__("Half hour (30min)", "timetable") => "0.5",
					__("Quarter hour (15min)", "timetable") => "0.25",
				),
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Filter style", "timetable"),
				"param_name" => "filter_style",
				"value" => array(
					__("Dropdown list", "timetable") => "dropdown_list",
					__("Tabs", "timetable") => "tabs",
				),
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Filter kind", "timetable"),
				"param_name" => "filter_kind",
				"value" => array(
					__("By event", "timetable") => "event",
					__("By event category", "timetable") => "event_category",
					__("By event and event category", "timetable") => "event_and_event_category",
				),
			),
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __("Filter label", "timetable"),
				"param_name" => "filter_label",
				"value" => __("All Events", "timetable"),					
			),
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __("Filter label 2", "timetable"),
				"param_name" => "filter_label_2",
				"value" => __("All Events Categories", "timetable"),
				"dependency" => array(
					"element" => "filter_kind",
					"value" => array("event_and_event_category"),
				),
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Select time format", "timetable"),
				"param_name" => "select_time",
				"value" => array(						
					__("09.03 (H.i)", "timetable") => "H.i",
					__("09:03 (H:i)", "timetable") => "H:i",
					__("9:03 am (g:i a)", "timetable") => "g:i a",
					__("9:03 AM (g:i A)", "timetable") => "g:i A",
				),
			),
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __("Time format", "timetable"),
				"param_name" => "time_format",
				"value" => "H.i",					
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Hide 'All Events' view", "timetable"),
				"param_name" => "hide_all_events_view",
				"value" => array(
					__("No", "timetable") => "0",
					__("Yes", "timetable") => "1",
				),
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Hide first (hours) column", "timetable"),
				"param_name" => "hide_hours_column",
				"value" => array(
					__("No", "timetable") => "0",
					__("Yes", "timetable") => "1",
				),
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Show end hour in first (hours) column", "timetable"),
				"param_name" => "show_end_hour",
				"value" => array(
					__("No", "timetable") => "0",
					__("Yes", "timetable") => "1",
				),
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Event block layout", "timetable"),
				"param_name" => "event_layout",
				"value" => array(
					__("Type 1", "timetable") => "1",
					__("Type 2", "timetable") => "2",
					__("Type 3", "timetable") => "3",
					__("Type 4", "timetable") => "4",
					__("Type 5", "timetable") => "5",
				),
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Hide empty rows", "timetable"),
				"param_name" => "hide_empty",
				"value" => array(
					__("No", "timetable") => "0",
					__("Yes", "timetable") => "1",
				),
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Disable event url", "timetable"),
				"param_name" => "disable_event_url",
				"value" => array(
					__("No", "timetable") => "0",
					__("Yes", "timetable") => "1",
				),
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Text align", "timetable"),
				"param_name" => "text_align",
				"value" => array(
					__("center", "timetable") => "center",
					__("left", "timetable") => "left",
					__("right", "timetable") => "right",
				),
			),
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __("Id", "timetable"),
				"param_name" => "id",
				"value" => "",					
			),
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __("Row height (in px)", "timetable"),
				"param_name" => "row_height",
				"value" => "31",					
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Display list view on desktop", "timetable"),
				"param_name" => "desktop_list_view",
				"value" => array(
					__("No", "timetable") => "0",
					__("Yes", "timetable") => "1",
				),
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Responsive", "timetable"),
				"param_name" => "responsive",
				"value" => array(						
					__("Yes", "timetable") => "1",
					__("No", "timetable") => "0",
				),
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Event description in responsive mode", "timetable"),
				"param_name" => "event_description_responsive",
				"value" => array(						
					__("None", "timetable") => "none",
					__("Only Description 1", "timetable") => "description-1",
					__("Only Description 2", "timetable") => "description-2",
					__("Description 1 and Description 2", "timetable") => "description-1-and-description-2",
				),
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Collapse event hours in responsive mode", "timetable"),
				"param_name" => "collapse_event_hours_responsive",
				"value" => array(						
					__("No", "timetable") => "0",
					__("Yes", "timetable") => "1",
				),
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Use colors in responsive mode", "timetable"),
				"param_name" => "colors_responsive_mode",
				"value" => array(						
					__("No", "timetable") => "0",
					__("Yes", "timetable") => "1",
				),
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Export to PDF button", "timetable"),
				"param_name" => "export_to_pdf_button",
				"value" => array(						
					__("No", "timetable") => "0",
					__("Yes", "timetable") => "1",
				),
			),
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __("Generate PDF label", "timetable"),
				"param_name" => "generate_pdf_label",
				"value" => __("Generate PDF", "timetable"),					
			),
		    array(
		        "type" => "dropdown",
		        "class" => "",
		        "heading" => __("PDF Font", "timetable"),
		        "param_name" => "pdf_font",
		        "value" => array(
		            __("Lato", "timetable") => "lato",
		            __("DejaVu Sans", "timetable") => "dejavusans",
		        ),
		    ),
			array(
				"type" => "colorpicker",
				"class" => "",
				"heading" => __("Timetable box background color", "timetable"),
				"param_name" => "box_bg_color",
				"value" => "#00a27c",
			),
			array(
				"type" => "colorpicker",
				"class" => "",
				"heading" => __("Timetable box hover background color", "timetable"),
				"param_name" => "box_hover_bg_color",
				"value" => "#1f736a",
			),
			array(
				"type" => "colorpicker",
				"class" => "",
				"heading" => __("Timetable box text color", "timetable"),
				"param_name" => "box_txt_color",
				"value" => "#ffffff",
			),
			array(
				"type" => "colorpicker",
				"class" => "",
				"heading" => __("Timetable box hover text color", "timetable"),
				"param_name" => "box_hover_txt_color",
				"value" => "#ffffff",
			),
			array(
				"type" => "colorpicker",
				"class" => "",
				"heading" => __("Timetable box hours text color", "timetable"),
				"param_name" => "box_hours_txt_color",
				"value" => "#ffffff",
			),
			array(
				"type" => "colorpicker",
				"class" => "",
				"heading" => __("Timetable box hours hover text color", "timetable"),
				"param_name" => "box_hours_hover_txt_color",
				"value" => "#ffffff",
			),
			array(
				"type" => "colorpicker",
				"class" => "",
				"heading" => __("Filter control background color", "timetable"),
				"param_name" => "filter_color",
				"value" => "#00a27c",
			),
			array(
				"type" => "colorpicker",
				"class" => "",
				"heading" => __("Row 1 style background color", "timetable"),
				"param_name" => "row1_color",
				"value" => "#f0f0f0",
			),
			array(
				"type" => "colorpicker",
				"class" => "",
				"heading" => __("Row 2 style background color", "timetable"),
				"param_name" => "row2_color",
				"value" => "",
			),
			array(
				"type" => "colorpicker",
				"class" => "",
				"heading" => __("Generate PDF button text color", "timetable"),
				"param_name" => "generate_pdf_text_color",
				"value" => "#ffffff",
			),
			array(
				"type" => "colorpicker",
				"class" => "",
				"heading" => __("Generate PDF button background color", "timetable"),
				"param_name" => "generate_pdf_bg_color",
				"value" => "#00a27c",
			),
			array(
				"type" => "colorpicker",
				"class" => "",
				"heading" => __("Generate PDF button hover text color", "timetable"),
				"param_name" => "generate_pdf_hover_text_color",
				"value" => "#ffffff",
			),
			array(
				"type" => "colorpicker",
				"class" => "",
				"heading" => __("Generate PDF button hover background color", "timetable"),
				"param_name" => "generate_pdf_hover_bg_color",
				"value" => "#1f736a",
			),
			array(
				"type" => "colorpicker",
				"class" => "",
				"heading" => __("Booking button text color", "timetable"),
				"param_name" => "booking_text_color",
				"value" => "#ffffff",
			),
			array(
				"type" => "colorpicker",
				"class" => "",
				"heading" => __("Booking button background color", "timetable"),
				"param_name" => "booking_bg_color",
				"value" => "#05bb90",
			),
			array(
				"type" => "colorpicker",
				"class" => "",
				"heading" => __("Booking button hover text color", "timetable"),
				"param_name" => "booking_hover_text_color",
				"value" => "#ffffff",
			),
			array(
				"type" => "colorpicker",
				"class" => "",
				"heading" => __("Booking button hover background color", "timetable"),
				"param_name" => "booking_hover_bg_color",
				"value" => "#07b38a",
			),
			array(
				"type" => "colorpicker",
				"class" => "",
				"heading" => __("Booked button text color", "timetable"),
				"param_name" => "booked_text_color",
				"value" => "#aaaaaa",
			),
			array(
				"type" => "colorpicker",
				"class" => "",
				"heading" => __("Booked button background color", "timetable"),
				"param_name" => "booked_bg_color",
				"value" => "#eeeeee",
			),
			array(
				"type" => "colorpicker",
				"class" => "",
				"heading" => __("Unavailable button text color", "timetable"),
				"param_name" => "unavailable_text_color",
				"value" => "#aaaaaa",
			),
			array(
				"type" => "colorpicker",
				"class" => "",
				"heading" => __("Unavailable button background color", "timetable"),
				"param_name" => "unavailable_bg_color",
				"value" => "#eeeeee",
			),
			array(
				"type" => "colorpicker",
				"class" => "",
				"heading" => __("Available slots color", "timetable"),
				"param_name" => "available_slots_color",
				"value" => "#ffd544",
			),
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __("Table header font", "timetable"),
				"param_name" => "font_custom",
				"value" => "",					
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("or choose Google font", "timetable"),
				"param_name" => "font",
				"value" => $google_fonts_array,
			),
			array(
				"type" => "dropdownmulti",
				"class" => "",
				"heading" => __("Google font subset", "timetable"),
				"param_name" => "font_subset",
				"value" => array(
					"",
					"arabic",
					"hebrew",
					"telugu",
					"cyrillic-ext",
					"cyrillic",
					"devanagari",
					"greek-ext",
					"greek",
					"vietnamese",
					"latin-ext",
					"latin",
					"khmer",
				),
				"dependency" => array(
					"element" => "font",
					"not_empty" => true,
					"callback" => "timetable_font_subset_init",
				),
			),
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __("Font size (in px)", "timetable"),
				"param_name" => "font_size",
				"value" => "",					
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Show booking button", "timetable"),
				"param_name" => "show_booking_button",
				"value" => array(						
					__("No", "timetable") => "no",
					__("Always", "timetable") => "always",
					__("On hover", "timetable") => "on_hover",
				),
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Show available slots", "timetable"),
				"param_name" => "show_available_slots",
				"value" => array(						
					__("No", "timetable") => "no",
					__("Always", "timetable") => "always",
				),
			),
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __("Available slots singular label", "timetable"),
				"param_name" => "available_slots_singular_label",
				"value" => "{number_available}/{number_total} slot available",
				"description" => __("Specify text label for 'slot available' information (singular). Available placeholders: {number_available}, {number_taken}, {number_total}.", "timetable")
			),
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __("Available slots plural label", "timetable"),
				"param_name" => "available_slots_plural_label",
				"value" => "{number_available}/{number_total} slots available",
				"description" => __("Specify text label for 'slots available' information (plural). Available placeholders: {number_available}, {number_taken}, {number_total}.", "timetable")
			),
		    array(
		        "type" => "dropdown",
		        "class" => "",
		        "heading" => __("Default booking view", "timetable"),
		        "param_name" => "default_booking_view",
		        "value" => array(
		            __("User", "timetable") => "user",
		            __("Guest", "timetable") => "guest",
		        ),
		        "description" => __("Specify which booking view should be visible by default.", "timetable"),
		    ),
		    array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Allow user booking", "timetable"),
				"param_name" => "allow_user_booking",
				"value" => array(
				    __("Yes", "timetable") => "yes",
					__("No", "timetable") => "no",
				),
				"description" => __("Set to 'Yes' if you want to allow logged in users to make a booking.", "timetable"),
		        "dependency" => array(
		            "element" => "default_booking_view",
		            "value" => array("guest"),
		        ),
			),
		    array(
		        "type" => "dropdown",
		        "class" => "",
		        "heading" => __("Allow guest booking", "timetable"),
		        "param_name" => "allow_guest_booking",
		        "value" => array(
		            __("No", "timetable") => "no",
		            __("Yes", "timetable") => "yes",
		        ),
		        "description" => __("Set to 'Yes' if you want to allow guests to make a booking.", "timetable"),
		        /*"dependency" => array(
		            "element" => "default_booking_view",
		            "value" => array("user"),
		        ),*/
		    ),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Show guest name field", "timetable"),
				"param_name" => "show_guest_name_field",
				"value" => array(
					__("Yes", "timetable") => "yes",
					__("No", "timetable") => "no",
				),
				"dependency" => array(
					"element" => "allow_guest_booking",
					"value" => array("yes"),
				),
				"description" => __("Set to 'Yes' if you want to show 'Name' field in guest booking form.", "timetable"),
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Guest name field required", "timetable"),
				"param_name" => "guest_name_field_required",
				"value" => array(						
					__("Yes", "timetable") => "yes",
					__("No", "timetable") => "no",
				),
				"dependency" => array(
					"element" => "allow_guest_booking",
					"value" => array("yes"),
				),
				"description" => __("Set to 'Yes' if the 'Name' field should be required.", "timetable"),
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Show guest phone field", "timetable"),
				"param_name" => "show_guest_phone_field",
				"value" => array(						
					__("No", "timetable") => "no",
					__("Yes", "timetable") => "yes",
				),
				"dependency" => array(
					"element" => "allow_guest_booking",
					"value" => array("yes"),
				),
				"description" => __("Set to 'Yes' if you want to show 'Phone' field in guest booking form.", "timetable"),
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Guest phone field required", "timetable"),
				"param_name" => "guest_phone_field_required",
				"value" => array(						
					__("No", "timetable") => "no",
					__("Yes", "timetable") => "yes",
				),
				"dependency" => array(
					"element" => "allow_guest_booking",
					"value" => array("yes"),
				),
				"description" => __("Set to 'Yes' if the 'Phone' field should be required.", "timetable"),
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Show guest message field", "timetable"),
				"param_name" => "show_guest_message_field",
				"value" => array(						
					__("No", "timetable") => "no",
					__("Yes", "timetable") => "yes",
				),
				"dependency" => array(
					"element" => "allow_guest_booking",
					"value" => array("yes"),
				),
				"description" => __("Set to 'Yes' if you want to show 'Message' field in guest booking form.", "timetable"),
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Guest message field required", "timetable"),
				"param_name" => "guest_message_field_required",
				"value" => array(						
					__("No", "timetable") => "no",
					__("Yes", "timetable") => "yes",
				),
				"dependency" => array(
					"element" => "allow_guest_booking",
					"value" => array("yes"),
				),
				"description" => __("Set to 'Yes' if the 'Message' field should be required.", "timetable"),
			),
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __("Booking label", "timetable"),
				"param_name" => "booking_label",
				"value" => __("Book now", "timetable"),
			),
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __("Booked label", "timetable"),
				"param_name" => "booked_label",
				"value" => __("Booked", "timetable"),
			),
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __("Unavailable label", "timetable"),
				"param_name" => "unavailable_label",
				"value" => __("Unavailable", "timetable"),
			),
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __("Popup booking label", "timetable"),
				"param_name" => "booking_popup_label",
				"value" => __("Book now", "timetable"),
			),
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __("Popup login label", "timetable"),
				"param_name" => "login_popup_label",
				"value" => __("Log in", "timetable"),
			),
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __("Popup cancel label", "timetable"),
				"param_name" => "cancel_popup_label",
				"value" => __("Cancel", "timetable"),
			),
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __("Popup continue label", "timetable"),
				"param_name" => "continue_popup_label",
				"value" => __("Continue", "timetable"),
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Terms and conditions checkbox", "timetable"),
				"param_name" => "terms_checkbox",
				"value" => array(						
					__("No", "timetable") => "no",
					__("Yes", "timetable") => "yes",
				),
				"description" => __("Set to 'Yes' if you want to display 'Terms and conditions' checkbox.", "timetable"),
			),
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __("Terms and conditions message", "timetable"),
				"param_name" => "terms_message",
				"value" => __("Please accept terms and conditions", "timetable"),
				"description" => __("Specify text for 'Terms and conditions' checkbox.", "timetable"),
			),
			array(
				"type" => "textarea",
				"class" => "",
				"heading" => __("Booking pop-up message", "timetable"),
				"param_name" => "booking_popup_message",
				"value" => BOOKING_POPUP_MESSAGE,
				"description" => __("Specify text that will appear in pop-up window. Available placeholders: {event_title} {column_title} {event_start} {event_end} {event_description_1} {event_description_2} {user_name} {user_email} {tt_btn_book} {tt_btn_cancel} {tt_btn_continue}", 'timetable'),
			),
			array(
				"type" => "textarea",
				"class" => "",
				"heading" => __("Booking pop-up thank you message", "timetable"),
				"param_name" => "booking_popup_thank_you_message",
				"value" => BOOKING_POPUP_THANK_YOU_MESSAGE,
				"description" => __("Specify text that will appear in pop-up window. Available placeholders: {event_title} {column_title} {event_start} {event_end} {event_description_1} {event_description_2} {user_name} {user_email} {tt_btn_continue}", 'timetable'),
			),
			array(
				"type" => "textarea",
				"class" => "",
				"heading" => __("Custom CSS", "timetable"),
				"param_name" => "custom_css",
				"value" => "",					
			),
		),
	));
}
add_action('init', 'timetable_vc_init');

function timetable_vc_dropdownmultiple_settings_field($settings, $value)
{
	$value = ($value==null ? array() : $value);
	if(!is_array($value))
		$value = explode(",", $value);
	$output = '<select name="'.$settings['param_name'].'" class="wpb_vc_param_value wpb-input wpb-select '.$settings['param_name'].' '.$settings['type'].'" multiple>';
			foreach ( $settings['value'] as $text_val => $val ) {
				if ( is_numeric($text_val) && is_string($val) || is_numeric($text_val) && is_numeric($val) ) {
					$text_val = $val;
				}
				$text_val = __($text_val, "js_composer");				   
				$selected = '';
				if ( in_array($val,$value) ) $selected = ' selected="selected"';
				$output .= '<option class="'.$val.'" value="'.$val.'"'.$selected.'>'.$text_val.'</option>';
			}
			$output .= '</select>';
	return $output;
}

function prepare_booking_button($args)
{
	$args = shortcode_atts(array(
		'show_booking_button' => 'no',
		'show_available_slots' => 'no',
		'available_slots_singular_label' => '{number_available}/{number_total} slot available',
		'available_slots_plural_label' => '{number_available}/{number_total} slots available',
		'booking_label' => 'Book now',
		'booked_label' => 'Booked',
		'unavailable_label' => 'Unavailable',
		'booking_text_color' => 'FFFFFF',
		'booking_bg_color' => '05BB90',
		'booking_hover_text_color' => 'FFFFFF',
		'booking_hover_bg_color' => '07B38A',
		'booked_text_color' => 'AAAAAA',
		'booked_bg_color' => 'EEEEEE',
		'unavailable_text_color' => 'AAAAAA',
		'unavailable_bg_color' => 'EEEEEE',
		'available_slots_color' => 'FFD544',
		'timetable_page_id' => '',
		'event_hours_id' => '',
		'redirect' => 'no',
		'current_user_booking_count' => '',
		'slots_per_user' => '',
		'available_slots' => '',
	), $args);
	
	
	$output = '';
	$booking_url = '#';
	if($args['timetable_page_id']>0)
		$booking_url = get_permalink($args['timetable_page_id']) . '#book-event-hour-' . $args['event_hours_id'];

	if($args['current_user_booking_count']>=$args['slots_per_user'] && $args['slots_per_user']>0)
	{
		$output .= "<a href='' class='event_hour_booking id-" . $args['event_hours_id'] . " booked' style='" . (strlen($args['booked_text_color']) ? " color: #" . $args['booked_text_color'] . " !important;" : "") . (strlen($args['booked_bg_color']) ? " background-color: #" . $args['booked_bg_color'] . " !important;" : "") . "' title='" . $args['booked_label'] . "'>" . $args['booked_label'] . "</a>";
	}
	elseif(!$args['available_slots'])
	{
		$output .= "<a href='' class='event_hour_booking id-" . $args['event_hours_id'] . " unavailable' style='" . (strlen($args['unavailable_text_color']) ? " color: #" . $args['unavailable_text_color'] . " !important;" : "") . (strlen($args['unavailable_bg_color']) ? " background-color: #" . $args['unavailable_bg_color'] . " !important;" : "") . "' title='" . $args['unavailable_label'] . "'>" . $args['unavailable_label'] . "</a>";
	}
	else
	{
		$output .= "<a href='" . $booking_url . "' class='event_hour_booking id-" . $args['event_hours_id'] . " " . ($args['redirect']=='yes' ? 'redirect' : '') . " ' data-event-hour-id='" . $args['event_hours_id'] . "' style='" . (strlen($args['booking_text_color']) ? " color: #" . $args['booking_text_color'] . " !important;" : "") . (strlen($args['booking_bg_color']) ? " background-color: #" . $args['booking_bg_color'] . ";" : "") . "' onMouseOver='" . (strlen($args['booking_hover_text_color']) ? " this.style.setProperty(\"color\", \"#" . $args['booking_hover_text_color'] . "\", \"important\");" : "") . (strlen($args['booking_hover_bg_color']) ? " this.style.setProperty(\"background\", \"#" . $args['booking_hover_bg_color'] . "\", \"important\");" : "") . "' onMouseOut='" . (strlen($args['booking_hover_text_color']) ? (strlen($args['booking_hover_text_color']) ? " this.style.setProperty(\"color\", \"#" . $args['booking_text_color'] . "\", \"important\");" : " this.style.color=\"\";") : "") . (strlen($args['booking_hover_bg_color']) ? (strlen($args['booking_hover_bg_color']) ? " this.style.setProperty(\"background\", \"#" . $args['booking_bg_color'] . "\", \"important\");" : " this.style.background=\"\";") : "") . "' title='" . $args['booking_label'] . "'>" . $args['booking_label'] . "</a>";
	}
	
	$output = "<div class='event_hour_booking_wrapper " . $args['show_booking_button'] . "'>" . $output . "</div>";
	
	return $output;
}

function prepare_booking_slots_label($args)
{
	$args = shortcode_atts(array(
		'available_slots' => '',
		'taken_slots' => '',
		'total_slots' => '',
		'available_slots_singular_label' => '',
		'available_slots_plural_label' => '',
	), $args);
	
	$placeholders = array(
		'number' => strpos($args['available_slots_singular_label'], '{number}'),
		'number_available' => strpos($args['available_slots_singular_label'], '{number_available}'),
		'number_taken' => strpos($args['available_slots_singular_label'], '{number_taken}'),
		'number_total' => strpos($args['available_slots_singular_label'], '{number_total}'),
	);
	asort($placeholders);
	foreach($placeholders as $key=>$val)
	{
		if($val===false)
			unset($placeholders[$key]);
	}
	reset($placeholders);
	$placeholder = key($placeholders);

	//decide whether use singular or plural label
	$placeholder_val = 0;
	switch($placeholder)
	{
		case 'number':
			$placeholder_val = $args['available_slots'];
			break;
		case 'number_available':
			$placeholder_val = $args['available_slots'];
			break;
		case 'number_taken':
			$placeholder_val = $args['total_slots'];
			break;
		case 'number_total':
			$placeholder_val = $args['total_slots'];
			break;
	}
	$booking_slots_label = ($placeholder_val==1 ? $args['available_slots_singular_label'] : $args['available_slots_plural_label']);
	$booking_slots_label = str_replace('{number}', '<span class="count available">' . $args['available_slots'] . '</span>', $booking_slots_label);
	$booking_slots_label = str_replace('{number_available}', '<span class="count available">' . $args['available_slots'] . '</span>', $booking_slots_label);
	$booking_slots_label = str_replace('{number_taken}', '<span class="count taken">' . $args['taken_slots'] . '</span>', $booking_slots_label);
	$booking_slots_label = str_replace('{number_total}', '<span class="count total">' . $args['total_slots'] . '</span>', $booking_slots_label);
	
	return $booking_slots_label;
}
