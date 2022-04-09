<?php
/**
 * Class for the timetable importer used in the One Click Demo Import plugin.
 *
 * @package ocdi
 */

class OCDI_Timetable_Importer {

	/**
	 * Imports Timetable Event Hours and timetable shortcodes
	 */
	public static function import_timetable( ) {
        //import sample hours
		global $wpdb;
		$query = "INSERT INTO `" . $wpdb->prefix . "event_hours` (`event_hours_id`, `event_id`, `weekday_id`, `start`, `end`, `tooltip`, `before_hour_text`, `after_hour_text`, `category`, `available_places`) VALUES
			(611, 3473, 3418, '08:00:00', '09:00:00', '', '', 'Ben Smith', 'strength', 8),
			(612, 3473, 3420, '12:00:00', '13:00:00', '', '', 'Ben Smith', 'strength', 8),
			(613, 3473, 3421, '15:00:00', '16:00:00', '', '', 'Ben Smith', 'strength', 8),
			(622, 3472, 3418, '19:00:00', '20:30:00', '', '', 'Ben Smith', 'cardio', 25),
			(623, 3472, 3420, '11:00:00', '12:15:00', '', '', 'Ben Smith', 'cardio', 25),
			(624, 3472, 3420, '16:00:00', '17:00:00', '', '', 'Anna Strong', 'cardio', 25),
			(625, 3472, 3424, '14:00:00', '15:15:00', '', '', 'Anna Strong', 'cardio', 25),
			(631, 3471, 3418, '18:00:00', '19:15:00', '', '', 'Samantha Gains', 'strength', 12),
			(632, 3471, 3419, '11:00:00', '12:15:00', '', '', 'Samantha Gains', 'strength', 12),
			(633, 3471, 3422, '08:00:00', '09:15:00', '', '', 'Anna Strong', 'strength', 12),
			(634, 3471, 3423, '10:15:00', '11:30:00', '', '', 'Anna Strong', 'strength', 12),
			(644, 3470, 3418, '19:30:00', '10:30:00', '', '', 'Anna Strong', 'functional', 10),
			(645, 3470, 3420, '14:00:00', '15:00:00', '', '', 'Anna Strong', 'functional', 10),
			(646, 3470, 3421, '16:30:00', '17:30:00', '', '', 'Anna Strong', 'functional', 10),
			(655, 3469, 3418, '09:15:00', '10:00:00', '', '', 'Ben Smith', 'functional', 10),
			(656, 3469, 3420, '13:15:00', '14:00:00', '', '', 'Ben Smith', 'functional', 10),
			(657, 3469, 3422, '17:15:00', '18:00:00', '', '', 'Ben Smith', 'functional', 10),
			(658, 3469, 3424, '10:15:00', '11:00:00', '', '', 'Ben Smith', 'functional', 10),
			(663, 3468, 3418, '07:00:00', '08:00:00', '', '', 'Samantha Gains', 'cardio', 8),
			(664, 3468, 3419, '10:00:00', '11:00:00', '', '', 'Samantha Gains', 'cardio', 8),
			(665, 3468, 3420, '16:00:00', '17:00:00', '', '', 'Anna Strong', 'cardio', 8),
			(666, 3468, 3423, '14:00:00', '15:00:00', '', '', 'Anna Strong', 'cardio', 8);";
			
		$wpdb->query($query);
		
		//insert shortcodes from live preview
		$timetable_shortcodes_live_preview = array(
			"body_works"		=> "[tt_timetable event='body-works' filter_style='tabs' filter_label='All' time_format='g:i a' hide_all_events_view='1' booking_bg_color='f48460' booking_hover_bg_color='e66943' available_slots_color='f48460' box_bg_color='232a35' box_hover_bg_color='232a35' hide_empty='1' show_booking_button='always' show_available_slots='always' booking_popup_message='<h3>You are about to book event</h3><p class=\"event_details\">{event_title}</p><p class=\"event_details\">{column_title}</p><p class=\"event_details\">{event_start} - {event_end}</p><p>An initial receipt will be sent out automatically unless you decide not to do so below.</p><div>{tt_btn_book}{tt_btn_cancel}</div>' booking_popup_thank_you_message='<h3>Thank you for choosing our services!</h3><p class=\"event_details\">{event_title}</p><p class=\"event_details\">{column_title}</p><p class=\"event_details\">{event_start} - {event_end}</p><p class=\"info\">This is a confirmation of your booking. Your booking is now complete and a confirmation email has been sent to you.</p><div>{tt_btn_continue}</div>']",
			"core_power"		=> "[tt_timetable event='core-power' filter_style='tabs' filter_label='All' time_format='g:i a' hide_all_events_view='1' booking_bg_color='f48460' booking_hover_bg_color='e66943' available_slots_color='f48460' box_bg_color='232a35' box_hover_bg_color='232a35' hide_empty='1' show_booking_button='always' show_available_slots='always' booking_popup_message='<h3>You are about to book event</h3><p class=\"event_details\">{event_title}</p><p class=\"event_details\">{column_title}</p><p class=\"event_details\">{event_start} - {event_end}</p><p>An initial receipt will be sent out automatically unless you decide not to do so below.</p><div>{tt_btn_book}{tt_btn_cancel}</div>' booking_popup_thank_you_message='<h3>Thank you for choosing our services!</h3><p class=\"event_details\">{event_title}</p><p class=\"event_details\">{column_title}</p><p class=\"event_details\">{event_start} - {event_end}</p><p class=\"info\">This is a confirmation of your booking. Your booking is now complete and a confirmation email has been sent to you.</p><div>{tt_btn_continue}</div>']",
			"indoor_cycling"	=> "[tt_timetable event='indoor-cycling' filter_style='tabs' filter_label='All' time_format='g:i a' hide_all_events_view='1' booking_bg_color='f48460' booking_hover_bg_color='e66943' available_slots_color='f48460' box_bg_color='232a35' box_hover_bg_color='232a35' hide_empty='1' show_booking_button='always' show_available_slots='always' booking_popup_message='<h3>You are about to book event</h3><p class=\"event_details\">{event_title}</p><p class=\"event_details\">{column_title}</p><p class=\"event_details\">{event_start} - {event_end}</p><p>An initial receipt will be sent out automatically unless you decide not to do so below.</p><div>{tt_btn_book}{tt_btn_cancel}</div>' booking_popup_thank_you_message='<h3>Thank you for choosing our services!</h3><p class=\"event_details\">{event_title}</p><p class=\"event_details\">{column_title}</p><p class=\"event_details\">{event_start} - {event_end}</p><p class=\"info\">This is a confirmation of your booking. Your booking is now complete and a confirmation email has been sent to you.</p><div>{tt_btn_continue}</div>']",
			"kettleball_power"	=> "[tt_timetable event='kettlebell-power' filter_style='tabs' filter_label='All' time_format='g:i a' hide_all_events_view='1' booking_bg_color='f48460' booking_hover_bg_color='e66943' available_slots_color='f48460' box_bg_color='232a35' box_hover_bg_color='232a35' hide_empty='1' show_booking_button='always' show_available_slots='always' booking_popup_message='<h3>You are about to book event</h3><p class=\"event_details\">{event_title}</p><p class=\"event_details\">{column_title}</p><p class=\"event_details\">{event_start} - {event_end}</p><p>An initial receipt will be sent out automatically unless you decide not to do so below.</p><div>{tt_btn_book}{tt_btn_cancel}</div>' booking_popup_thank_you_message='<h3>Thank you for choosing our services!</h3><p class=\"event_details\">{event_title}</p><p class=\"event_details\">{column_title}</p><p class=\"event_details\">{event_start} - {event_end}</p><p class=\"info\">This is a confirmation of your booking. Your booking is now complete and a confirmation email has been sent to you.</p><div>{tt_btn_continue}</div>']",
			"mobility_circle"	=> "[tt_timetable event='mobility-circle' filter_style='tabs' filter_label='All' time_format='g:i a' hide_all_events_view='1' booking_bg_color='f48460' booking_hover_bg_color='e66943' available_slots_color='f48460' box_bg_color='232a35' box_hover_bg_color='232a35' hide_empty='1' show_booking_button='always' show_available_slots='always' booking_popup_message='<h3>You are about to book event</h3><p class=\"event_details\">{event_title}</p><p class=\"event_details\">{column_title}</p><p class=\"event_details\">{event_start} - {event_end}</p><p>An initial receipt will be sent out automatically unless you decide not to do so below.</p><div>{tt_btn_book}{tt_btn_cancel}</div>' booking_popup_thank_you_message='<h3>Thank you for choosing our services!</h3><p class=\"event_details\">{event_title}</p><p class=\"event_details\">{column_title}</p><p class=\"event_details\">{event_start} - {event_end}</p><p class=\"info\">This is a confirmation of your booking. Your booking is now complete and a confirmation email has been sent to you.</p><div>{tt_btn_continue}</div>']",
			"weightlifting" 	=> "[tt_timetable event='weightlifting' filter_style='tabs' filter_label='All' time_format='g:i a' hide_all_events_view='1' booking_bg_color='f48460' booking_hover_bg_color='e66943' available_slots_color='f48460' box_bg_color='232a35' box_hover_bg_color='232a35' hide_empty='1' show_booking_button='always' show_available_slots='always' booking_popup_message='<h3>You are about to book event</h3><p class=\"event_details\">{event_title}</p><p class=\"event_details\">{column_title}</p><p class=\"event_details\">{event_start} - {event_end}</p><p>An initial receipt will be sent out automatically unless you decide not to do so below.</p><div>{tt_btn_book}{tt_btn_cancel}</div>' booking_popup_thank_you_message='<h3>Thank you for choosing our services!</h3><p class=\"event_details\">{event_title}</p><p class=\"event_details\">{column_title}</p><p class=\"event_details\">{event_start} - {event_end}</p><p class=\"info\">This is a confirmation of your booking. Your booking is now complete and a confirmation email has been sent to you.</p><div>{tt_btn_continue}</div>']",
			"schedule"			=> "[tt_timetable event_category='cardio,functional,strength' filter_style='tabs' filter_kind='event_category' filter_label='All' time_format='g:i A' booking_bg_color='f48460' booking_hover_bg_color='e66943' available_slots_color='f48460' box_bg_color='232a35' box_hover_bg_color='232a35' show_booking_button='always' show_available_slots='always' booking_popup_message='<h3>You are about to book event</h3><p class=\"event_details\">{event_title}</p><p class=\"event_details\">{column_title}</p><p class=\"event_details\">{event_start} - {event_end}</p><p>An initial receipt will be sent out automatically unless you decide not to do so below.</p><div>{tt_btn_book}{tt_btn_cancel}</div>' booking_popup_thank_you_message='<h3>Thank you for choosing our services!</h3><p class=\"event_details\">{event_title}</p><p class=\"event_details\">{column_title}</p><p class=\"event_details\">{event_start} - {event_end}</p><p class=\"info\">This is a confirmation of your booking. Your booking is now complete and a confirmation email has been sent to you.</p><div>{tt_btn_continue}</div>']"
		);
		$timetable_shortcodes_list = get_option("timetable_shortcodes_list");
		if($timetable_shortcodes_list===false)
			$timetable_shortcodes_list = array();
		foreach($timetable_shortcodes_live_preview as $key=>$val)
		{
			if(!array_key_exists($key, $timetable_shortcodes_list))
				$timetable_shortcodes_list[$key] = $val;
		}
		ksort($timetable_shortcodes_list);
		update_option("timetable_shortcodes_list", $timetable_shortcodes_list);
	}

}
