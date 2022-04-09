<?php
class TT_DB
{
	public static function getEventHours($args)
	{
		$args = shortcode_atts(array(
			'event_hours_id' => 0,
			'user_id' => 0,
			'guest_email' => '',
		), $args);
		
		global $wpdb;
		$query = '';
		$queryArgs = array();
		
		$query .= 
		'SELECT 
			TIME_FORMAT(eh.start, "%H.%i") AS start, 
			TIME_FORMAT(eh.end, "%H.%i") AS end, 
			eh.before_hour_text AS description_1, 
			eh.after_hour_text AS description_2, 
			e.post_title AS event_title,
			w.post_title AS column_title, 
			COUNT(ehb.booking_id) AS booking_count, 
			eh.available_places,
			eh.slots_per_user,
			COALESCE(ub.booking_count, 0) AS current_user_booking_count,
			COALESCE(gb.booking_count, 0) AS current_guest_booking_count
		FROM 
			' . $wpdb->prefix . 'event_hours AS eh
		LEFT JOIN
			' . $wpdb->prefix . 'event_hours_booking AS ehb ON(ehb.event_hours_id=eh.event_hours_id)
		LEFT JOIN
			' . $wpdb->posts . ' AS e ON(eh.event_id=e.ID)
		LEFT JOIN
			' . $wpdb->posts . ' AS w ON(eh.weekday_id=w.ID)
		LEFT JOIN
			(SELECT event_hours_id, user_id, COUNT(booking_id) as booking_count 
			FROM ' . $wpdb->prefix . 'event_hours_booking 
			WHERE user_id= ' . (int)$args['user_id'] . ' AND user_id!=0
			GROUP BY event_hours_id) AS ub ON eh.event_hours_id=ub.event_hours_id 
		LEFT JOIN
			(SELECT b.event_hours_id, count(b.booking_id) AS booking_count
			FROM ' . $wpdb->prefix . 'event_hours_booking AS b 
			LEFT JOIN ' . $wpdb->prefix . 'timetable_guests AS g ON (b.guest_id=g.guest_id)
			WHERE g.email="%s" 
			GROUP BY b.event_hours_id) AS gb ON eh.event_hours_id=gb.event_hours_id
		WHERE 1=1';
		$queryArgs[] = $args['guest_email'];
		
		if($args['event_hours_id'])
		{
			$query .= 
			' AND eh.event_hours_id=%d';
			$queryArgs[] = $args['event_hours_id'];
		}
		$query = $wpdb->prepare($query, $queryArgs);
		
		$event_hour_details = $wpdb->get_results($query);
		
		return $event_hour_details;
	}
	
	public static function getBookings($args)
	{
		$args = shortcode_atts(array(
			'booking_id' => 0,
			'bookings_ids' => null,
			'weekdays_ids' => null,
			'event_hours_ids' => null,
			'booked_past' => 0,
			'validation_code' => '',
			'event_id' => 0,
			'events_ids' => null,
			'per_page' => 0,
			'page_number' => 1,
			'order' => 'DESC',
			'orderby' => 'booking',
		), $args);

		global $wpdb;
		
		$query = '';
		$queryArgs = array();
		
		$query .= 
		'SELECT 
			booking.booking_id AS booking_id,
			booking.booking_datetime AS booking_datetime,
			booking.validation_code,
			event.ID AS event_id, 
			event.post_title AS event_title, 
			event_hour.event_hours_id,
			TIME_FORMAT(event_hour.start, "%H:%i") AS start,
			TIME_FORMAT(event_hour.end, "%H:%i") AS end,
			event_hour.before_hour_text as event_description_1, 
			event_hour.after_hour_text as event_description_2, 
			weekday.post_title AS weekday,
			user.ID AS user_id,
			user.user_login,
			user.display_name AS user_name,
			user.user_email, 
			guest.guest_id AS guest_id,
			guest.name AS guest_name,
			guest.email AS guest_email,
			guest.phone AS guest_phone,
			guest.message AS guest_message
		FROM 
			' . $wpdb->prefix . 'event_hours_booking AS booking
		LEFT JOIN 
			' . $wpdb->prefix . 'event_hours AS event_hour 
			ON (event_hour.event_hours_id=booking.event_hours_id)
		LEFT JOIN 
			' . $wpdb->posts . ' AS event 
			ON (event.ID=event_hour.event_id)
		LEFT JOIN 
			' . $wpdb->posts . ' AS weekday 
			ON (weekday.ID=event_hour.weekday_id)
		LEFT JOIN 
			' . $wpdb->users . ' AS user 
			ON (user.ID=booking.user_id)
		LEFT JOIN 
			' . $wpdb->prefix . 'timetable_guests AS guest
			ON (guest.guest_id=booking.guest_id)
		WHERE 1=1 ';
		
		if($args['event_id'])
		{
			$query .= 
			' AND event_hour.event_id=%d';
			$queryArgs[] = (int)$args['event_id'];
		}

		if($args['events_ids'])
		{
			$query .= 
			' AND event.ID IN (';
			foreach($args['events_ids'] as $event_ids)
			{
				$query .=  '%d,';
				$queryArgs[] = (int)$event_ids;
			}
			$query = rtrim($query, ',');
			$query .= ')';
		}
		
		if($args['booking_id'])
		{
			$query .= 
			' AND booking.booking_id=%d';
			$queryArgs[] = (int)$args['booking_id'];
		}
		
		if($args['bookings_ids'])
		{
			$query .= 
			' AND booking.booking_id IN (';
			foreach($args['bookings_ids'] as $booking_id)
			{
				$query .=  '%d,';
				$queryArgs[] = (int)$booking_id;
			}
			$query = rtrim($query, ',');
			$query .= ')';
		}
		
		if($args['validation_code'])
		{
			$query .= 
			' AND booking.validation_code=%s';
			$queryArgs[] = $args['validation_code'];
		}

		if($args['weekdays_ids'])
		{
			$query .= 
			' AND weekday.ID IN (';
			foreach($args['weekdays_ids'] as $weekday_ids)
			{
				$query .=  '%d,';
				$queryArgs[] = (int)$weekday_ids;
			}
			$query = rtrim($query, ',');
			$query .= ')';
		}
		
		if($args['event_hours_ids'])
		{
			$query .= 
			' AND event_hour.event_hours_id IN (';
			foreach($args['event_hours_ids'] as $event_hours_ids)
			{
				$query .=  '%d,';
				$queryArgs[] = (int)$event_hours_ids;
			}
			$query = rtrim($query, ',');
			$query .= ')';
		}
		
		if((int)$args['booked_past'])
		{
			$query .= ' AND booking_datetime<(STR_TO_DATE(CONCAT(CURDATE(), start), "%%Y-%%m-%%d %%H:%%i"))';
		}
		
		$order = ($args && strtolower($args['order'])!='desc' ? 'ASC' : 'DESC');
		
		if($args['orderby'])
		{
			switch($args['orderby'])
			{
				case 'booking':
					$query .= ' ORDER BY booking_datetime ' . $order . ',  booking_id ' . $order;
					break;
				case 'date':
					$query .= ' ORDER BY weekday.menu_order ' . $order . ', start ' . $order . ', end ' . $order . '';
					break;
				case 'event':
					$query .= ' ORDER BY event_title ' . $order;
					break;
				case 'user':
					$query .= ' ORDER BY user_name ' . $order;
					break;
			}
		}
		else
		{
			$query .= ' ORDER BY booking_id ' . $order;
		}
		
		if($args['per_page'])
		{
			$query .= ' LIMIT %d';
			$queryArgs[] = $args['per_page'];
		}
		
		if($offset = ($args['page_number'] - 1) * $args['per_page'])
		{
			$query .= ' OFFSET %d';
			$queryArgs[] = $offset;
		}
		
		$query = $wpdb->prepare($query, $queryArgs);
		$result = $wpdb->get_results($query, 'ARRAY_A');

		return $result;
	}
	
	public static function deleteBooking($booking_id)
	{
		global $wpdb;

		$query = $wpdb->prepare('DELETE FROM `' . $wpdb->prefix . 'event_hours_booking` WHERE booking_id=%d', $booking_id);
		$result = $wpdb->query($query);	
		return $result;
	}
	
	public static function createBooking($args)
	{
		$args = shortcode_atts(array(
			'event_hour_id' => 0,
			'user_id' => 0,
			'booking_date' => '',
			'guest_id' => 0,
			'validation_code' => ''
		), $args);
		
		global $wpdb;
		$query = '';
		$queryArgs = array();
		
		$query = 'INSERT INTO ' . $wpdb->prefix . 'event_hours_booking(event_hours_id, user_id, booking_datetime, validation_code, guest_id) 
				VALUES (%d, %d, %s, %s, %d)';
		$queryArgs[] = $args['event_hour_id'];
		$queryArgs[] = $args['user_id'];
		$queryArgs[] = $args['booking_date'];
		$queryArgs[] = $args['validation_code'];
		$queryArgs[] = $args['guest_id'];
		
		$query = $wpdb->prepare($query, $queryArgs);
		$wpdb->query($query);
		return $wpdb->insert_id;
	}
	
	public static function createGuest($args)			
	{
		$args = shortcode_atts(array(
			'guest_name' => '',
			'guest_email' => '',
			'guest_phone' => '',
			'guest_message' => '',
		), $args);
		
		global $wpdb;
		$query = '';
		$queryArgs = array();
		
		$query .= 
		'INSERT INTO ' . $wpdb->prefix . 'timetable_guests(name, email, phone, message) VALUES (%s, %s, %s, %s)';
		$queryArgs[] = $args['guest_name'];
		$queryArgs[] = $args['guest_email'];
		$queryArgs[] = $args['guest_phone'];
		$queryArgs[] = $args['guest_message'];
		
		$query = $wpdb->prepare($query, $queryArgs);
		$wpdb->query($query);
		$guest_id = $wpdb->insert_id;
		return $guest_id;			
	}
	
	public static function getEventHoursForGoogleCalendar($event, $weekday)
	{
		global $wpdb;
		$query = '';
		$queryArgs = array();

		$query .= 
		'SELECT 
			eh.event_hours_id AS event_hour_id, 
			TIME_FORMAT(eh.start, "%H:%i") AS start, 
			TIME_FORMAT(eh.end, "%H:%i") AS end, 
			eh.before_hour_text AS description_1, 
			eh.after_hour_text AS description_2, 
			e.ID AS event_id,
			e.post_title AS event_title,
			w.post_title AS column_title,
			w.post_name AS column_name
		FROM 
			' . $wpdb->prefix . 'event_hours AS eh
		LEFT JOIN
			' . $wpdb->posts . ' AS e ON(eh.event_id=e.ID)
		LEFT JOIN
			' . $wpdb->posts . ' AS w ON(eh.weekday_id=w.ID)
		WHERE 
			1 = 1';
		if($event)
		{
			$query .= 
				' AND e.post_name IN (';
			$temp = array();
			foreach($event as $val)
			{
				$temp[] = '%s';
				$queryArgs[] = $val;
			}
			$query .= implode(',', $temp);
			$query .= ')';
		}
		if($weekday)
		{
			$query .= 
				' AND w.post_name IN (';
			$temp = array();
			foreach($weekday as $val)
			{
				if($val=='')
					continue;
				$temp[] = '%s';
				$queryArgs[] = $val;
			}
			$query .= implode(',', $temp);
			$query .= ')';
		}
		$query = $wpdb->prepare($query, $queryArgs);
		$result = $wpdb->get_results($query, 'ARRAY_A');
		return $result;
	}
	
	
}
