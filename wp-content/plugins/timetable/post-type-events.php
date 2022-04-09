<?php
function timetable_events_settings()
{
	$timetable_events_settings = get_option("timetable_events_settings");
	if(!$timetable_events_settings)
	{
		$timetable_events_settings = array(
			"slug" => "events",
			"label_singular" => "Event",
			"label_plural" => "Events",
		);
		add_option("timetable_events_settings", $timetable_events_settings);
	}
	return $timetable_events_settings;
}

//custom post type - events
function timetable_events_init()
{
	global $wpdb;
	$timetable_events_settings = timetable_events_settings();
	$labels = array(
		'name' => $timetable_events_settings['label_plural'],
		'singular_name' => $timetable_events_settings['label_singular'],
		'add_new' => _x('Add New', $timetable_events_settings["slug"], 'timetable'),
		'add_new_item' => sprintf(__('Add New %s' , 'timetable') , $timetable_events_settings['label_singular']),
		'edit_item' => sprintf(__('Edit %s', 'timetable'), $timetable_events_settings['label_singular']),
		'new_item' => sprintf(__('New %s', 'timetable'), $timetable_events_settings['label_singular']),
		'all_items' => sprintf(__('All %s', 'timetable'), $timetable_events_settings['label_plural']),
		'view_item' => sprintf(__('View %s', 'timetable'), $timetable_events_settings['label_singular']),
		'search_items' => sprintf(__('Search %s', 'timetable'), $timetable_events_settings['label_singular']),
		'not_found' =>  sprintf(__('No %s found', 'timetable'), strtolower($timetable_events_settings['label_plural'])),
		'not_found_in_trash' => sprintf(__('No %s found in Trash', 'timetable'), strtolower($timetable_events_settings['label_plural'])), 
		'parent_item_colon' => '',
		'menu_name' => $timetable_events_settings['label_plural']
	);
	$args = array(  
		"labels" => $labels, 
		"public" => true,  
		"show_ui" => true,  
		"capability_type" => "post",  
		"menu_position" => 20,
		"hierarchical" => false,  
		"rewrite" => true,
		"supports" => array("title", "editor", "excerpt", "thumbnail", "page-attributes")  
	);
	register_post_type($timetable_events_settings["slug"], $args);
	
	register_taxonomy("events_category", array($timetable_events_settings["slug"]), array("label" => __("Categories", 'timetable'), "singular_label" => __("Category", 'timetable'), "rewrite" => true, "hierarchical" => true));
	
	if(array_key_exists("timetable_warning", $_GET) && $_GET["timetable_warning"]=="available_places")
	{
		add_action("admin_notices", "timetable_warning_available_places");
	}
	
	
	if(!get_option("timetable_event_hours_table_installed"))
	{
		//create custom db table
		$query = "CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix . "event_hours` (
			`event_hours_id` BIGINT( 20 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
			`event_id` BIGINT( 20 ) NOT NULL ,
			`weekday_id` BIGINT( 20 ) NOT NULL ,
			`start` TIME NOT NULL ,
			`end` TIME NOT NULL,
			`tooltip` text NOT NULL,
			`before_hour_text` text NOT NULL,
			`after_hour_text` text NOT NULL,
			`category` varchar(255) NOT NULL,
			`available_places` int(11) NOT NULL DEFAULT 0,
			KEY `event_id` (`event_id`),
			KEY `weekday_id` (`weekday_id`)
		) ENGINE = MYISAM DEFAULT CHARSET=utf8;";
		$wpdb->query($query);
		update_option("timetable_event_hours_table_installed", 1);
		global $wp_rewrite;
		$wp_rewrite->flush_rules(); 
	}
	
	if(!get_option("timetable_event_hours_table_column_available_places"))
	{
		$query = "SHOW COLUMNS FROM " . $wpdb->prefix . "event_hours LIKE 'available_places'";
		$result=$wpdb->get_results($query);
		if(!$result)
		{
			$query = "ALTER TABLE " . $wpdb->prefix . "event_hours ADD available_places int(11) NOT NULL DEFAULT 0";
			$wpdb->query($query);
		}
		update_option("timetable_event_hours_table_column_available_places", 1);
	}
	
	if(!get_option("timetable_event_hours_table_column_slots_per_user"))
	{
		$query = "SHOW COLUMNS FROM " . $wpdb->prefix . "event_hours LIKE 'slots_per_user'";
		$result=$wpdb->get_results($query);
		if(!$result)
		{
			$query = "ALTER TABLE " . $wpdb->prefix . "event_hours ADD slots_per_user int(11) NOT NULL DEFAULT 1";
			$wpdb->query($query);
		}
		update_option("timetable_event_hours_table_column_slots_per_user", 1);
	}
	
	if(!get_option("timetable_event_hours_booking_table_installed"))
	{
		//create custom db table
		$query = "CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix . "event_hours_booking` (
			`booking_id` BIGINT( 20 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
			`event_hours_id` BIGINT( 20 ) UNSIGNED NOT NULL,
			`user_id` BIGINT( 20 ) UNSIGNED NOT NULL DEFAULT 0,
			`booking_datetime` DATETIME NOT NULL,
			`validation_code` VARCHAR(32) NOT NULL,
			`guest_id` BIGINT( 20 ) UNSIGNED NOT NULL DEFAULT 0
		) ENGINE = MYISAM DEFAULT CHARSET=utf8;";
		
		$wpdb->query($query);
		update_option("timetable_event_hours_booking_table_installed", 1);
	}
	
	if(!get_option('timetable_event_hours_booking_table_modify_1'))
	{
		$query = 'SHOW COLUMNS FROM ' . $wpdb->prefix . 'event_hours_booking LIKE "guest_id"';
		$result=$wpdb->get_results($query);
		if(!$result)
		{
			$query = 'ALTER TABLE ' . $wpdb->prefix . 'event_hours_booking ADD guest_id BIGINT(20) UNSIGNED';
			$wpdb->query($query);
		}
		
		$query = 'SHOW INDEX FROM ' . $wpdb->prefix . 'event_hours_booking WHERE Key_name="unique_index"';
		$result = $wpdb->get_results($query);
		if($result)
		{
			$query = 'ALTER TABLE ' . $wpdb->prefix . 'event_hours_booking DROP INDEX unique_index';
			$wpdb->query($query);
		}
		update_option('timetable_event_hours_booking_table_modify_1', 1);
	}
	
	if(!get_option("timetable_timetable_guests_table_installed"))
	{
		//create custom db table
		$query = "CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix . "timetable_guests` (
			`guest_id` BIGINT( 20 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
			`name` VARCHAR(250),
			`email` VARCHAR(100),
			`phone` VARCHAR(50),
			`message` TEXT
		) ENGINE = MYISAM DEFAULT CHARSET=utf8;";
		$wpdb->query($query);
		update_option("timetable_timetable_guests_table_installed", 1);
	}
	
}  
add_action("init", "timetable_events_init"); 

//Adds a box to the right column and to the main column on the Events edit screens
function timetable_add_events_custom_box() 
{
	$timetable_events_settings = timetable_events_settings();
    add_meta_box(
        "event_hours",
        __("Event hours", 'timetable'),
        "timetable_inner_events_custom_box_side",
        $timetable_events_settings["slug"],
		"normal"
    );
	add_meta_box( 
        "event_config",
        __("Options", 'timetable'),
        "timetable_inner_events_custom_box_main",
        $timetable_events_settings["slug"],
		"normal",
		"high"
    );
}
add_action("add_meta_boxes", "timetable_add_events_custom_box");
//backwards compatible (before WP 3.0)
//add_action("admin_init", "timetable_add_custom_box", 1);

//get event hour details
function timetable_get_event_hour_details()
{
	global $wpdb;
	$query = $wpdb->prepare("SELECT * FROM `" . $wpdb->prefix . "event_hours` AS t1 LEFT JOIN {$wpdb->posts} AS t2 ON t1.weekday_id=t2.ID WHERE t1.event_id='%d' AND t1.event_hours_id='%d'", $_POST["post_id"], $_POST["id"]);
	$event_hour = $wpdb->get_row($query);
	$event_hour->start = date("H:i", strtotime($event_hour->start));
	$event_hour->end = date("H:i", strtotime($event_hour->end));
	echo "event_hour_start" . json_encode($event_hour) . "event_hour_end";
	exit();
}
add_action('wp_ajax_get_event_hour_details', 'timetable_get_event_hour_details');

function timetable_delete_event_bookings()
{
	$result = array(
		'error' => 0,
		'msg' => '',
	);
	
	global $wpdb;
	$event_id = (isset($_POST["event_id"]) ? $_POST["event_id"] : '');
	$booking_weekday_id = (isset($_POST["booking_weekday_id"]) ? $_POST["booking_weekday_id"] : '');
	
	$query = "";
	$query_args = array();
	
	$query .= 
	"SELECT booking_id FROM `" . $wpdb->prefix . "event_hours_booking` 
	WHERE event_hours_id IN (
		SELECT event_hours_id 
		FROM `" . $wpdb->prefix . "event_hours`
		WHERE event_id=%d";
	$query_args[] = $event_id;
	if((int)$booking_weekday_id)
	{
		$query .= " AND weekday_id=%d";
		$query_args[] = $booking_weekday_id;
	}
	$query .= ")";
	
	$query = $wpdb->prepare($query, $query_args);
	$bookings_ids = $wpdb->get_col($query);
	
	for($i=0, $max_i=count($bookings_ids); $i<$max_i; $i++)
	{
		TT_DB::deleteBooking($bookings_ids[$i]);
	}

	timetable_ajax_response($result);
}
add_action('wp_ajax_delete_event_bookings', 'timetable_delete_event_bookings');

// Prints the box content
function timetable_inner_events_custom_box_side($post) 
{
	global $wpdb;
	//Use nonce for verification
	wp_nonce_field(plugin_basename( __FILE__ ), "timetable_events_noncename");

	//The actual fields for data entry
	$query = "SELECT * FROM `" . $wpdb->prefix . "event_hours` AS t1 LEFT JOIN {$wpdb->posts} AS t2 ON t1.weekday_id=t2.ID WHERE t1.event_id='" . $post->ID . "' ORDER BY t2.menu_order, t1.start, t1.end";
	$event_hours = $wpdb->get_results($query);
	$event_hours_count = count($event_hours);
	
	//get weekdays
	$query = "SELECT ID, post_title FROM {$wpdb->posts}
			WHERE 
			post_type='timetable_weekdays'
			AND post_status='publish'
			ORDER BY menu_order";
	$weekdays = $wpdb->get_results($query);
	
	//get booking details
	$args = array(
		'event_id' => $post->ID,
	);
	$bookings = TT_DB::getBookings($args);
	$bookings_array = array();
	for($i=0, $max_i=count($bookings); $i<$max_i; $i++)
	{
		$bookings_array[$bookings[$i]['event_hours_id']][] = $bookings[$i];
	}

	echo '
	<ul id="event_hours_list"' . (!$event_hours_count ? ' style="display: none;"' : '') . '>';
		for($i=0; $i<$event_hours_count; $i++)
		{
			$booking_count=(isset($bookings_array[$event_hours[$i]->event_hours_id]) ? count($bookings_array[$event_hours[$i]->event_hours_id]) : 0);
			//get day by id
			$current_day = get_post($event_hours[$i]->weekday_id);
			echo '<li id="event_hours_' . $event_hours[$i]->event_hours_id . '">' . $current_day->post_title . ' ' . date("H:i", strtotime($event_hours[$i]->start)) . '-' . date("H:i", strtotime($event_hours[$i]->end)) . '<img class="operation_button delete_button delete_event_hour" src="' . plugins_url('/admin/images/delete.png', __FILE__) . '" alt="del" /><img class="operation_button edit_button" src="' . plugins_url('/admin/images/edit.png', __FILE__) . '" alt="edit" /><img class="operation_button edit_hour_event_loader" src="' . plugins_url('/admin/images/ajax-loader.gif', __FILE__) . '" alt="loader" />';
			if($event_hours[$i]->tooltip!="" || $event_hours[$i]->before_hour_text!="" || $event_hours[$i]->after_hour_text!="" || $event_hours[$i]->category!="" || $event_hours[$i]->available_places!="")
			{
				echo '<div>';
				if($event_hours[$i]->tooltip!="")
					echo '<br /><strong>' . __('Tooltip', 'timetable') . ':</strong> ' . $event_hours[$i]->tooltip;
				if($event_hours[$i]->before_hour_text!="")
					echo '<br /><strong>' . __('Description 1', 'timetable') . ':</strong> ' . $event_hours[$i]->before_hour_text;
				if($event_hours[$i]->after_hour_text!="")
					echo '<br /><strong>' . __('Description 2', 'timetable') . ':</strong> ' . $event_hours[$i]->after_hour_text;
				if($event_hours[$i]->available_places!=0)
					echo '<br /><strong>' . __('Available slots', 'timetable') . ':</strong> ' . ($booking_count>0 ? $event_hours[$i]->available_places-$booking_count . '/' : '') . $event_hours[$i]->available_places;
				if($event_hours[$i]->available_places!=0 && $event_hours[$i]->slots_per_user!=0)
					echo '<br /><strong>' . __('Slots per user', 'timetable') . ':</strong> ' . $event_hours[$i]->slots_per_user;
				if($booking_count)
				{
					echo '<br><a href="#" class="show_hide_bookings">' . __('Show/Hide booked users', 'timetable') . '</a>
						<ul class="booking_list">';
					foreach($bookings_array[$event_hours[$i]->event_hours_id] as $booking)
					{
						echo '<li id="booking_id_' . $booking['booking_id'] . '">';
						if($booking['user_id'])
						{
							echo sprintf(__('<a href="%s">%s</a> on %s', 'timetable'), get_edit_user_link($booking['user_id']), $booking['user_name'], $booking['booking_datetime']);
						}
						elseif($booking['guest_id'])
						{
							echo sprintf(__('Guest: %s on %s', 'timetable'), $booking['guest_name'], $booking['booking_datetime']);
						}
						echo	'<img class="operation_button delete_button delete_booking" src="' . plugins_url('/admin/images/delete.png', __FILE__) . '" alt="del" />
							</li>';
					}
					echo '</ul>';
				}
				if($event_hours[$i]->category!="")
					echo '<br /><strong>' . __('Category', 'timetable') . ':</strong> ' . $event_hours[$i]->category;
				echo '</div>';
			}
			echo '</li>';
		}
	echo '
	</ul>
	<table id="event_hours_table">
		<tr>
			<td>
				<label for="weekday_id">' . __('Timetable column', 'timetable') . ':</label>
			</td>
			<td>
				<select name="weekday_id" id="weekday_id">';
				foreach($weekdays as $weekday)
					echo '<option value="' . $weekday->ID . '">' . $weekday->post_title . '</option>';
	echo '		</select>
			</td>
		</tr>
		<tr>
			<td>
				<label for="start_hour">' . __('Start hour', 'timetable') . ':</label>
			</td>
			<td>
				<input size="5" maxlength="5" type="text" id="start_hour" name="start_hour" value="" />
				<span class="description">hh:mm</span>
			</td>
		</tr>
		<tr>
			<td>
				<label for="end_hour">' . __('End hour', 'timetable') . ':</label>
			</td>
			<td>
				<input size="5" maxlength="5" type="text" id="end_hour" name="end_hour" value="" />
				<span class="description">hh:mm</span>
			</td>
		</tr>
		<tr>
			<td>
				<label for="before_hour_text">' . __('Description 1', 'timetable') . ':</label>
			</td>
			<td>
				<textarea id="before_hour_text" name="before_hour_text"></textarea>
			</td>
		</tr>
		<tr>
			<td>
				<label for="after_hour_text">' . __('Description 2', 'timetable') . ':</label>
			</td>
			<td>
				<textarea id="after_hour_text" name="after_hour_text"></textarea>
			</td>
		</tr>
		<tr>
			<td>
				<label for="tooltip">' . __('Tooltip', 'timetable') . ':</label>
			</td>
			<td>
				<textarea id="tooltip" name="tooltip"></textarea>
			</td>
		</tr>
		<tr>
			<td>
				<label for="event_hour_category">' . __('Category', 'timetable') . ':</label>
			</td>
			<td>
				<input type="text" id="event_hour_category" name="event_hour_category" value="" />
			</td>
		</tr>
		<tr>
			<td>
				<label for="available_places">' . __('Available slots', 'timetable') . ':</label>
			</td>
			<td>
				<input type="text" id="available_places" name="available_places" value="" />
			</td>
		</tr>
		<tr>
			<td>
				<label for="slots_per_user">' . __('Slots per user', 'timetable') . ':</label>
			</td>
			<td>
				<input type="text" id="slots_per_user" name="slots_per_user" value="" />
			</td>
		</tr>
		<tr>
			<td colspan="2" style="text-align: right;">
				<input id="add_event_hours" type="button" class="button" value="' . __("Add", 'timetable') . '" />
				<input type="hidden" id="event_hours_id" name="event_hours_id" value="0"/>
			</td>
		</tr>
	</table>
	<table id="event_bookings_table">
		<tr>
			<td colspan="2">
				<h3>' . __('Delete event bookings', 'timetable') . '</h3>
			</td>
		</tr>
		<tr>
			<td>
				<label for="booking_weekday_id">' . __('Timetable column', 'timetable') . ':</label>
			</td>
			<td>
				<select name="booking_weekday_id" id="booking_weekday_id">
					<option value="all">' . __('All', 'timetable') . '</option>';
	
				foreach($weekdays as $weekday)
					echo '<option value="' . $weekday->ID . '">' . $weekday->post_title . '</option>';
	echo '		</select>
			</td>
		</tr>
		<tr>	
			<td colspan="2" style="text-align: right;">
				<input type="hidden" id="event_id" name="event_id" value="' . $post->ID . '"/>
				<input id="delete_event_bookings" type="button" class="button" value="' . __("Delete", 'timetable') . '" />
			</td>
		</tr>
	</table>
	';
	//Reset Query
	wp_reset_query();
}

function timetable_inner_events_custom_box_main($post)
{
	//Use nonce for verification
	wp_nonce_field(plugin_basename( __FILE__ ), "timetable_events_noncename");
	
	//The actual fields for data entry
	$timetable_disable_url = get_post_meta($post->ID, "timetable_disable_url", true);
	echo '
	<table>
		<tr>
			<td>
				<label for="color">' . __('Subtitle', 'timetable') . ':</label>
			</td>
			<td>
				<input class="regular-text" type="text" id="subtitle" name="subtitle" value="' . esc_attr(get_post_meta($post->ID, "timetable_subtitle", true)) . '" />
			</td>
		</tr>
		<tr>
			<td>
				<label for="color">' . __('Timetable box background color', 'timetable') . ':</label>
			</td>
			<td>
				<span class="color_preview" style="background-color: #' . (get_post_meta($post->ID, "timetable_color", true)!="" ? esc_attr(get_post_meta($post->ID, "timetable_color", true)) : 'transparent') . '"></span>
				<input class="regular-text color" type="text" id="color" name="color" value="' . esc_attr(get_post_meta($post->ID, "timetable_color", true)) . '" data-default-color="transparent" />
				<span class="description">' . __('Required when \'Timetable box hover color\' isn\'t empty', 'timetable') . '</span>
			</td>
		</tr>
		<tr>
			<td>
				<label for="color">' . __('Timetable box hover background color', 'timetable') . ':</label>
			</td>
			<td>
				<span class="color_preview" style="background-color: #' . (get_post_meta($post->ID, "timetable_hover_color", true)!="" ? esc_attr(get_post_meta($post->ID, "timetable_hover_color", true)) : 'transparent') . '"></span>
				<input class="regular-text color" type="text" id="hover_color" name="hover_color" value="' . esc_attr(get_post_meta($post->ID, "timetable_hover_color", true)) . '" data-default-color="transparent" />
			</td>
		</tr>
		<tr>
			<td>
				<label for="text_color">' . __('Timetable box text color', 'timetable') . ':</label>
			</td>
			<td>
				<span class="color_preview" style="background-color: #' . (get_post_meta($post->ID, "timetable_text_color", true)!="" ? esc_attr(get_post_meta($post->ID, "timetable_text_color", true)) : 'transparent') . '"></span>
				<input class="regular-text color" type="text" id="text_color" name="text_color" value="' . esc_attr(get_post_meta($post->ID, "timetable_text_color", true)) . '" data-default-color="transparent" />
				<span class="description">' . __('Required when \'Timetable box hover text color\' isn\'t empty', 'timetable') . '</span>
			</td>
		</tr>
		<tr>
			<td>
				<label for="text_color">' . __('Timetable box hover text color', 'timetable') . ':</label>
			</td>
			<td>
				<span class="color_preview" style="background-color: #' . (get_post_meta($post->ID, "timetable_hover_text_color", true)!="" ? esc_attr(get_post_meta($post->ID, "timetable_hover_text_color", true)) : 'transparent') . '"></span>
				<input class="regular-text color" type="text" id="hover_text_color" name="hover_text_color" value="' . esc_attr(get_post_meta($post->ID, "timetable_hover_text_color", true)) . '" data-default-color="transparent" />
			</td>
		</tr>
		<tr>
			<td>
				<label for="text_color">' . __('Timetable box hours text color', 'timetable') . ':</label>
			</td>
			<td>
				<span class="color_preview" style="background-color: #' . (get_post_meta($post->ID, "timetable_hours_text_color", true)!="" ? esc_attr(get_post_meta($post->ID, "timetable_hours_text_color", true)) : 'transparent') . '"></span>
				<input class="regular-text color" type="text" id="hours_text_color" name="hours_text_color" value="' . esc_attr(get_post_meta($post->ID, "timetable_hours_text_color", true)) . '" data-default-color="transparent" />
				<span class="description">' . __('Required when \'Timetable box hover hours text color\' isn\'t empty', 'timetable') . '</span>
			</td>
		</tr>
		<tr>
			<td>
				<label for="text_color">' . __('Timetable box hover hours text color', 'timetable') . ':</label>
			</td>
			<td>
				<span class="color_preview" style="background-color: #' . (get_post_meta($post->ID, "timetable_hours_hover_text_color", true)!="" ? esc_attr(get_post_meta($post->ID, "timetable_hours_hover_text_color", true)) : 'transparent') . '"></span>
				<input class="regular-text color" type="text" id="hours_hover_text_color" name="hours_hover_text_color" value="' . esc_attr(get_post_meta($post->ID, "timetable_hours_hover_text_color", true)) . '" data-default-color="transparent" />
			</td>
		</tr>
		<tr>
			<td>
				<label for="color">' . __('Timetable custom URL', 'timetable') . ':</label>
			</td>
			<td>
				<input class="regular-text" type="text" id="timetable_custom_url" name="timetable_custom_url" value="' . esc_attr(get_post_meta($post->ID, "timetable_custom_url", true)) . '" />
			</td>
		</tr>
		<tr>
			<td>
				<label for="color">' . __('Disable timetable event URL', 'timetable') . ':</label>
			</td>
			<td>
				<select name="timetable_disable_url">
					<option value="0"' . (!(int)$timetable_disable_url ? ' selected="selected"' : '') . '>' . __("No", 'timetable') . '</option>
					<option value="1"' . ((int)$timetable_disable_url ? ' selected="selected"' : '') . '>' . __("Yes", 'timetable') . '</option>
				</select>
			</td>
		</tr>
	</table>';
}

//When the post is saved, saves our custom data
function timetable_save_events_postdata($post_id) 
{
	global $wpdb;
	$query = "";
	//verify if this is an auto save routine. 
	//if it is our form has not been submitted, so we dont want to do anything
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) 
		return;

	//verify this came from the our screen and with proper authorization,
	//because save_post can be triggered at other times
	if (isset($_POST['timetable_events_noncename']) && !wp_verify_nonce($_POST['timetable_events_noncename'], plugin_basename( __FILE__ )) || !isset($_POST['timetable_events_noncename']))
		return;
	
	//Check permissions
	if(!current_user_can('edit_post', $post_id))
		return;
	
	//OK, we're authenticated: we need to find and save the data
	
	if(isset($_POST["weekday_ids"]))
	{
		$hours_count = count($_POST["weekday_ids"]);
		for($i=0; $i<$hours_count; $i++)
		{
			$slots_per_user = $_POST["slots_per_user_array"][$i];
			if($slots_per_user<1)
				$slots_per_user = 1;
			if($slots_per_user>$_POST["available_places_array"][$i])
				$slots_per_user = $_POST["available_places_array"][$i];
			
			$event_hour_id = (isset($_POST["event_hours_ids"][$i]) ? $_POST["event_hours_ids"][$i] : 0);
			$weekday_id = $_POST["weekday_ids"][$i];
			$start_hour = $_POST["start_hours"][$i];
			$end_hour = $_POST["end_hours"][$i];
			$tooltip = stripslashes($_POST["tooltips"][$i]);
			$before_hour_text = stripslashes($_POST["before_hour_texts"][$i]);
			$after_hour_text = stripslashes($_POST["after_hour_texts"][$i]);
			$event_hours_category = $_POST["event_hours_category"][$i];
			$available_places = $_POST["available_places_array"][$i];
			
			if(!($event_hour_id>0))
			{
				$query = $wpdb->prepare(
					"INSERT INTO `" . $wpdb->prefix . "event_hours`(event_id, weekday_id, start, end, tooltip, before_hour_text, after_hour_text, category, available_places, slots_per_user) VALUES(%s, %s, %s, %s, %s, %s, %s, %s, %s, %s)", 
					$post_id, $weekday_id, $start_hour, $end_hour, $tooltip, $before_hour_text, $after_hour_text, $event_hours_category, $available_places, $slots_per_user);
			}
			else
			{
				//update only if the available_places is equal or grater than the count of existing bookings
				$booking_count = $wpdb->get_var($wpdb->prepare("SELECT COUNT(booking_id) FROM `" . $wpdb->prefix . "event_hours_booking` WHERE event_hours_id=%d", $event_hour_id));
				if($available_places>=$booking_count)
				{
					$query = $wpdb->prepare(
						"UPDATE `" . $wpdb->prefix . "event_hours` SET weekday_id=%s, start=%s, end=%s, tooltip=%s, before_hour_text=%s, after_hour_text=%s, category=%s, available_places=%s, slots_per_user=%s WHERE event_hours_id=%s", 
						$weekday_id,  $start_hour, $end_hour, $tooltip, $before_hour_text, $after_hour_text, $event_hours_category, $available_places, $slots_per_user, $event_hour_id);
				}
				else
				{
					add_filter("redirect_post_location", "timetable_set_warning_available_places");
				}
			}
			
			if(strlen($query))
				$wpdb->query($query);
		}
	}
	//removing data if needed
	if(isset($_POST["delete_event_hours_ids"]))
	{
		$delete_event_hours_ids_count = count($_POST["delete_event_hours_ids"]);
		if($delete_event_hours_ids_count)
		{
			$wpdb->query("DELETE FROM `" . $wpdb->prefix . "event_hours` WHERE event_hours_id IN(" . implode(",", esc_sql($_POST["delete_event_hours_ids"])) . ")");
			$wpdb->query("DELETE FROM `" . $wpdb->prefix . "event_hours_booking` WHERE event_hours_id IN(" . implode(",", esc_sql($_POST["delete_event_hours_ids"])) . ")");
		}
	}
	if(isset($_POST["delete_booking_ids"]))
	{
		for($i=0, $max_i=count($_POST["delete_booking_ids"]); $i<$max_i; $i++)
			TT_DB::deleteBooking($_POST["delete_booking_ids"][$i]);
	}
	
	//post meta
	update_post_meta($post_id, "timetable_subtitle", $_POST["subtitle"]);
	update_post_meta($post_id, "timetable_color", $_POST["color"]);
	update_post_meta($post_id, "timetable_hover_color", $_POST["hover_color"]);
	update_post_meta($post_id, "timetable_text_color", $_POST["text_color"]);
	update_post_meta($post_id, "timetable_hover_text_color", $_POST["hover_text_color"]);
	update_post_meta($post_id, "timetable_hours_text_color", $_POST["hours_text_color"]);
	update_post_meta($post_id, "timetable_hours_hover_text_color", $_POST["hours_hover_text_color"]);	
	update_post_meta($post_id, "timetable_custom_url", $_POST["timetable_custom_url"]);
	update_post_meta($post_id, "timetable_disable_url", $_POST["timetable_disable_url"]);
}
add_action("save_post", "timetable_save_events_postdata");

function timetable_delete_events($post_id)
{
	global $wpdb;
	//delete event hour bookings associated with the event
	$query = $wpdb->prepare("DELETE FROM `" . $wpdb->prefix . "event_hours_booking` WHERE event_hours_id IN (
		SELECT event_hours_id FROM `" . $wpdb->prefix . "event_hours` WHERE event_id=%d
	)", $post_id);
	$wpdb->query($query);
	
	//delete event hours associated with the event
	$query = $wpdb->prepare("DELETE FROM `" . $wpdb->prefix . "event_hours` WHERE event_id=%d", $post_id);
	$wpdb->query($query);	
}
add_action("delete_post", "timetable_delete_events");

//custom events items list
function events_edit_columns($columns)
{
	$columns = array(  
		"cb" => "<input type=\"checkbox\" />",  
		"title" => _x('Title', 'post type singular name', 'timetable'),
		"events_category" => __('Categories', 'timetable'),
		"date" => __('Date', 'timetable')
	);    

	return $columns;  
}  
$timetable_events_settings = timetable_events_settings();
add_filter("manage_edit-" . $timetable_events_settings["slug"] . "_columns", "events_edit_columns"); 
function manage_events_posts_custom_column($column)
{
	global $post;
	switch ($column)
	{
		case "events_category":
			$events_category_list = (array)get_the_terms($post->ID, "events_category");
			foreach($events_category_list as $events_category)
			{
				if(empty($events_category->slug))
					continue;
				echo '<a href="' . esc_url(admin_url("edit.php?post_type=events&events_category=" . $events_category->slug)) . '">' . $events_category->name . '</a>' . (end($events_category_list)!=$events_category ? ", " : "");;
			}
			break;
	}
}
add_action("manage_" . $timetable_events_settings["slug"] . "_posts_custom_column", "manage_events_posts_custom_column");

function filter_events_by_taxonomies($post_type)
{
	$timetable_events_settings = timetable_events_settings();
	//Apply this only on a specific post type
	if($timetable_events_settings["slug"]!==$post_type)
		return;

	//A list of taxonomy slugs to filter by
	$taxonomies = array('events_category');

	foreach($taxonomies as $taxonomy_slug)
	{
		// Retrieve taxonomy data
		$taxonomy_obj = get_taxonomy($taxonomy_slug);
		$taxonomy_name = $taxonomy_obj->labels->name;

		// Retrieve taxonomy terms
		$terms = get_terms( $taxonomy_slug );

		// Display filter HTML
		echo "<select name='" . esc_attr($taxonomy_slug) . "' id='" . esc_attr($taxonomy_slug) . "' class='postform'>";
		echo '<option value="">' . sprintf(esc_html__('Show All %s', 'timetable'), $taxonomy_name) . '</option>';
		foreach($terms as $term)
		{
			printf('<option value="%1$s" %2$s>%3$s (%4$s)</option>', $term->slug, ((isset($_GET[$taxonomy_slug]) && ($_GET[$taxonomy_slug]==$term->slug)) ? ' selected="selected"' : ''), $term->name, $term->count);
		}
		echo '</select>';
	}
}
add_action('restrict_manage_posts', 'filter_events_by_taxonomies', 10, 2);

function timetable_set_warning_available_places($location)
{
	return add_query_arg("timetable_warning", "available_places", $location);
}

function timetable_warning_available_places()
{
	echo "
	<div class='notice notice-error'>
		<p>" . __("Error: Available slots value must be equal or greater than the number of existing bookings.", "timetable") . "</p>
	</div>";
}

?>