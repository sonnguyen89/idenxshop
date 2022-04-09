<?php
function tt_remove_wpautop($content) 
{
  return do_shortcode(shortcode_unautop($content));
}

//items list
function tt_event_items_list($atts, $content)
{
	extract(shortcode_atts(array(
		"class" => "",
	), $atts));
	
	$output = '';
	$output .= '
	<ul class="tt_event_items_list' . ($class!='' ? ' ' . $class : '') . '">
		' . tt_remove_wpautop($content) . '
	</ul>';
	return $output;
}
add_shortcode("tt_items_list", "tt_event_items_list");

//items list
function tt_event_item($atts, $content)
{
	extract(shortcode_atts(array(
		"type" => "",
		"border_color" => "",
		"text_color" => "",
		"value" => ""
	), $atts));
	
	$output = '';
	$output .= '
	<li' . ($type=="info" ? ' class="timetable_clearfix type_info"' : '') . ($border_color!='' ? ' style="border-bottom: ' . ($border_color=='none' ? 'none' : '1px solid #' . $border_color . '') . ';"' : '') . '>
		<' . ($type=="info" ? 'label' : 'span') . ($text_color!='' ? ' style="color: #' . $text_color . ';"' : '') . '>' . tt_remove_wpautop($content) . '</' . ($type=="info" ? 'label' : 'span') . '>';
		if($value!="")
			$output .= '<div class="tt_event_text">' . $value . '</div>';
	$output .= '
	</li>';
	return $output;
}
add_shortcode("tt_item", "tt_event_item");

//columns
function tt_event_columns($atts, $content)
{	
	extract(shortcode_atts(array(
		"class" => ""
	), $atts));
	return '<div class="tt_event_columns' . ($class!='' ? ' ' . $class : '') . '">' . tt_remove_wpautop($content) . '</div>';
}
add_shortcode("tt_columns", "tt_event_columns");

//column left
function tt_event_column_left($atts, $content)
{
	return '<div class="tt_event_column_left">' . tt_remove_wpautop($content) . '</div>';
}
add_shortcode("tt_column_left", "tt_event_column_left");

//column right
function tt_event_column_right($atts, $content)
{
	return '<div class="tt_event_column_right">' . tt_remove_wpautop($content) . '</div>';
}
add_shortcode("tt_column_right", "tt_event_column_right");

//event hours
function tt_event_hours($atts, $content)
{
	global $post;
	wp_register_style('timetable_inline_style', false);
	wp_enqueue_style('timetable_inline_style');
	$inline_style = '';
	
	extract(shortcode_atts(array(
		'event_id' => $post->ID,
		'title' => 'Event Hours',
		'time_format' => 'H.i',
		'class' => '',
		'hour_category' => '',
		'text_color' => '',
		'border_color' => '',
		'columns' => '',
		'timetable_page_id' => '',
		'show_booking_button' => 'no',
		'show_available_slots' => 'no',
		'available_slots_singular_label' => '{number_available}/{number_total} slot available',
		'available_slots_plural_label' => '{number_available}/{number_total} slots available',
		'booking_label' => __('Book now', 'timetable'),
		'booked_label' => __('Booked', 'timetable'),
		'unavailable_label' => __('Unavailable', 'timetable'),
		'booking_text_color' => 'FFFFFF',
		'booking_bg_color' => '05BB90',
		'booking_hover_text_color' => 'FFFFFF',
		'booking_hover_bg_color' => '07B38A',
		'booked_text_color' => 'AAAAAA',
		'booked_bg_color' => 'EEEEEE',
		'unavailable_text_color' => 'AAAAAA',
		'unavailable_bg_color' => 'EEEEEE',
		'available_slots_color' => '34495E',
	), $atts));
	
	if($hour_category!=null && $hour_category!="-")
		$hour_category = array_values(array_diff(array_filter(array_map('trim', explode(",", $hour_category))), array("-")));
		
	if($columns!="")
	{
		$weekdays_explode = explode(",", $columns);
		$weekdays_in_query = "";
		foreach($weekdays_explode as $weekday_explode)
			$weekdays_in_query .= "'" . $weekday_explode . "'" . ($weekday_explode!=end($weekdays_explode) ? "," : "");
	}
	
	$user_id = get_current_user_id();
	
	global $wpdb;
	$output = '';
	//The actual fields for data entry
	$query = 
	"SELECT 
		t1.event_hours_id,
		t1.event_id,
		t1.start,
		t1.end,
		t1.before_hour_text,
		t1.after_hour_text,
		t1.slots_per_user,
		t1.available_places AS available_places, 
		t2.post_title AS weekday,
		t2.menu_order,
		COALESCE(t4.booking_count,0) AS booking_count,
		COALESCE(t6.booking_count,0) AS current_user_booking_count		
		FROM `" . $wpdb->prefix . "event_hours` AS t1 
		LEFT JOIN " . $wpdb->posts . " AS t2 ON (t1.weekday_id=t2.ID)		
		LEFT JOIN (SELECT event_hours_id, COALESCE(COUNT(booking_id),0) as booking_count FROM " . $wpdb->prefix . "event_hours_booking GROUP BY event_hours_id) AS t4 ON (t1.event_hours_id=t4.event_hours_id) 
		LEFT JOIN (SELECT event_hours_id, user_id, COUNT(booking_id) as booking_count FROM " . $wpdb->prefix . "event_hours_booking where user_id= " . (int)$user_id . " and user_id!=0 GROUP BY event_hours_id) AS t6 ON t1.event_hours_id=t6.event_hours_id		
		WHERE t1.event_id='" . (int)$event_id . "'";
	
	if($hour_category!=null && $hour_category!="-")
		$query .= "
			AND t1.category IN('" . join("','", $hour_category) . "')";
	if(isset($weekdays_in_query) && $weekdays_in_query!="")
		$query .= " AND t2.post_name IN(" . $weekdays_in_query . ")";
	$query .= " ORDER BY t2.menu_order, t1.start, t1.end";
	
	$event_hours = $wpdb->get_results($query);
	$event_hours_count = count($event_hours);
	
	if(!$event_hours_count)
		return $output;
	
	if($title!="")
		$output .= '<h3 class="tt_event_margin_top_27">' . $title . '<span class="tt_event_hours_count">(' . $event_hours_count . ')</span></h3>';
	
	//custom styles
	if(strtoupper($available_slots_color)!="34495E")
	{
		$inline_style .= (strtoupper($available_slots_color)!="34495E" ? ' .tt_event_hours .available_slots_wrapper span.available_slots { color:#' . $available_slots_color . ' !important;}' : '');
	}
	
	$output .= '
	<ul id="event_hours_list" class="timetable_clearfix tt_event_hours' . ($class!="" ? ' ' . $class : '') . '">';
		for($i=0; $i<$event_hours_count; $i++)
		{
			//get event color
			if($border_color=="")
				$border_color = "#" . get_post_meta($event_hours[$i]->event_id, "timetable_color", true);
			$output .= '<li' . ($border_color!="" ? ' style="border-left-color:' . $border_color . ';"' : '') . ' id="event_hours_' . $event_hours[$i]->event_hours_id . '" class="event_hours_' . ($i%2==0 ? 'left' : 'right') . '"><h4' . ($text_color!="" ? ' style="color:' . $text_color . ';"' : '') . '>' . $event_hours[$i]->weekday . '</h4><h4' . ($text_color!="" ? ' style="color:' . $text_color . ';"' : '') . '>' . date($time_format, strtotime($event_hours[$i]->start)) . ' - ' . date($time_format, strtotime($event_hours[$i]->end)) . '</h4>';
			if($event_hours[$i]->before_hour_text!="" || $event_hours[$i]->after_hour_text!="")
			{
				$output .= '<p' . ($text_color!="" ? ' style="color:' . $text_color . ';"' : '') . ' class="tt_event_padding_bottom_0">';
				if($event_hours[$i]->before_hour_text!="")
					$output .= $event_hours[$i]->before_hour_text;
				if($event_hours[$i]->after_hour_text!="")
					$output .= ($event_hours[$i]->before_hour_text!="" ? '<br>' : '') . $event_hours[$i]->after_hour_text;
				$output .= '</p>';
			}
			//display booking button
			if($show_booking_button=='yes')
			{
				$taken_slots = $event_hours[$i]->booking_count;
				$total_slots = $event_hours[$i]->available_places;
				$available_slots = $total_slots-$taken_slots;
				
				$booking_content = prepare_booking_button(array(
					'timetable_page_id' => $timetable_page_id,
					'redirect' => 'yes',
					'current_user_booking_count' => $event_hours[$i]->current_user_booking_count,
					'slots_per_user' => $event_hours[$i]->slots_per_user,
					'event_hours_id' => $event_hours[$i]->event_hours_id,
					'show_booking_button' => $show_booking_button,
					'booking_label' => $booking_label,
					'booked_label' => $booked_label,
					'unavailable_label' => $unavailable_label,
					'booking_text_color' => $booking_text_color,
					'booking_bg_color' => $booking_bg_color,
					'booking_hover_text_color' => $booking_hover_text_color,
					'booking_hover_bg_color' => $booking_hover_bg_color,
					'booked_text_color' => $booked_text_color,
					'booked_bg_color' => $booked_bg_color,
					'unavailable_text_color' => $unavailable_text_color,
					'unavailable_bg_color' => $unavailable_bg_color,					
					'available_slots' => $available_slots,
				));
				$booking_slots_label = '';
				if($show_available_slots=='yes' && $total_slots>0)
				{
					$booking_slots_label = prepare_booking_slots_label(array(
						'available_slots' => $available_slots,
						'taken_slots' => $taken_slots,
						'total_slots' => $total_slots,
						'available_slots_singular_label' => $available_slots_singular_label,
						'available_slots_plural_label' => $available_slots_plural_label,
					));
					$booking_slots_label = 
						"<p class='available_slots_wrapper'>
							<span class='available_slots id-" . $event_hours[$i]->event_hours_id . "'>" . 
								$booking_slots_label .
							"</span>
						</p>";
				}
				$output .= 
					$booking_slots_label .
					$booking_content;
			}
			
			$output .= '</li>';
		}
	$output .= '</ul>';
	
	wp_add_inline_style('timetable_inline_style', $inline_style);
	return $output;
}
add_shortcode("tt_event_hours", "tt_event_hours");
?>