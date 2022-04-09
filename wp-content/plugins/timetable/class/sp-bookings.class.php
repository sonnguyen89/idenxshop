<?php
class SP_Bookings
{
	static $instance;
	public $BookingsList;

	public static function get_instance()
	{
		if(!isset(self::$instance))
		{
			self::$instance = new self();
		}
		return self::$instance;
	}
	
	public function __construct()
	{
		add_filter('set-screen-option', array(__CLASS__, 'set_screen'), 10, 3);
		add_action('admin_menu', array($this, 'plugin_menu'));
		add_action('wp_loaded', array($this, 'handle_booking_export'));
	}
	
	public static function set_screen($status, $option, $value)
	{
		return $value;
	}
	
	public function plugin_menu()
	{
		$admin_booking_hook = add_menu_page(__('Timetable Bookings', 'timetable'), __('Timetable Bookings', 'timetable'), 'manage_options', 'timetable_admin_bookings', array($this, 'bookings_page'), '', 20);
		add_action('load-' . $admin_booking_hook, array($this, 'screen_option'));
		add_submenu_page('timetable_admin_bookings', __('Export Bookings', 'timetable'), __('Export Bookings', 'timetable'), 'manage_options', 'timetable_admin_bookings_export', array($this, 'bookings_export_page'));
	}
	
	public function screen_option()
	{
		$option = 'per_page';
		$args   = array(
			'label' => 'Bookings',
			'default' => 20,
			'option' => 'bookings_per_page',
		);
		
		add_screen_option($option, $args);
		
		$this->BookingsList = new TT_Bookings_List();
		$this->BookingsList->process_bulk_action();
	}
	
	public function bookings_page()
	{
		?>
		<div class="wrap">
			<h2><?php _e('Bookings list', 'timetable'); ?></h2>
				<form method="post">
					<?php
					$this->BookingsList->prepare_items();
					$this->BookingsList->display();
					?>
				</form>
		</div>
		<?php
	}

	public function bookings_export_page()
	{
		//fetch a list of events
		$timetable_events_settings = timetable_events_settings();
		$events_list = get_posts(array(
			'posts_per_page' => -1,
			'nopaging' => true,
			'orderby' => 'title',
			'order' => 'ASC',
			'post_type' => $timetable_events_settings['slug']
		));

		//fetch a list of weekdays
		$weekdays_list = get_posts(array(
			'posts_per_page' => -1,
			'nopaging' => true,
			'orderby' => 'menu_order',
			'order' => 'ASC',
			'post_type' => 'timetable_weekdays'
		));

		?>
		<div class="wrap timetable_settings_section first">
			<h2><?php _e('Bookings export', 'timetable'); ?></h2>
			<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" id="timetable_bookings_export">
				<div>
					<table class="timetable_table form-table">
						<tr valign="top">
							<th>
								<label for="booking_export_events"><?php _e("Events: ", "timetable"); ?></label>
							</th>
							<td>
								<select id="booking_export_events" name="booking_export_events[]" multiple>
									<?php
									for ($i=0, $max_i=count($events_list); $i < $max_i ; $i++)
									{ 
										?>
										<option value="<?php echo esc_attr($events_list[$i]->ID); ?>"><?php echo esc_html($events_list[$i]->post_title); ?></option>
										<?php
									}
									?>
								</select>
							</td>
						</tr>
						<tr valign="top">
							<th>
								<label for="booking_export_weekdays"><?php _e("Columns: ", "timetable"); ?></label>
							</th>
							<td>
								<select id="booking_export_weekdays" name="booking_export_weekdays[]" multiple>
									<?php
									for ($i=0, $max_i=count($weekdays_list); $i < $max_i ; $i++)
									{ 
										?>
										<option value="<?php echo esc_attr($weekdays_list[$i]->ID); ?>"><?php echo esc_html($weekdays_list[$i]->post_title); ?></option>
										<?php
									}
									?>
								</select>
							</td>
						</tr>						
						<tr valign="top" class="no-border">
							<td colspan="3">
								<input type="hidden" name="action" value="export-bookings"/>
								<input type="submit" class="button button-primary" name="bookings_export" id="bookings_export" value="<?php _e('Export', 'timetable'); ?>" />
								
							</td>
						</tr>
						<tr valign="top" class="tt_hide no-border">
							<td colspan="3">
								<div id="event_slug_info"></div>
							</td>
						</tr>
					</table>
				</div>
			</form>
		</div>
		<?php
	}

	public function handle_booking_export()
	{
		$action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_STRING);

		if($action!='export-bookings')
			return;
		
		$events = filter_input(INPUT_POST, 'booking_export_events', FILTER_SANITIZE_NUMBER_INT, FILTER_REQUIRE_ARRAY);
		$weekdays = filter_input(INPUT_POST, 'booking_export_weekdays', FILTER_SANITIZE_NUMBER_INT, FILTER_REQUIRE_ARRAY);

		$bookings = TT_DB::getBookings(array(
			'events_ids' => $events,
			'weekdays_ids' => $weekdays,
		));

		$exportFileName = 'bookings.csv';

		$data = '';
		$dataArray = array();
		$dataArray[] = __('ID','timetable');
		$dataArray[] = __('Event','timetable');
		$dataArray[] = __('Weekday','timetable');
		$dataArray[] = __('Start','timetable');
		$dataArray[] = __('End','timetable');
		$dataArray[] = __('Type','timetable');
		$dataArray[] = __('Name','timetable');
		$dataArray[] = __('E-mail','timetable');
		$dataArray[] = __('Phone','timetable');
		$dataArray[] = __('Message','timetable');
				
        $data .= implode(chr(9),$dataArray) . "\r\n";
        
		if($bookings)
		{
			foreach($bookings as $booking)
			{
				$dataArray = array();
				$dataArray[] = $booking['booking_id'];
				$dataArray[] = $booking['event_title'];
				$dataArray[] = $booking['weekday'];
				$dataArray[] = $booking['start'];
				$dataArray[] = $booking['end'];
				if($booking['user_id'])
				{
					$dataArray[] = sprintf(__('Logged in (%s)', 'timetable'), $booking['user_login']);
					$dataArray[] = $booking['user_name'];
					$dataArray[] = $booking['user_email'];
					$dataArray[] = '';	//empty for phone column
					$dataArray[] = '';	//empty for message column
				}
				else
				{
					$dataArray[] = __('Guest', 'timetable');
					$dataArray[] = $booking['guest_name'];
					$dataArray[] = $booking['guest_email'];
					$dataArray[] = $booking['guest_phone'];
					$dataArray[] = $booking['guest_message'];
				}

				for($i=0, $max_i=count($dataArray); $i<$max_i; $i++)
					$dataArray[$i] = preg_replace('/\s+/', ' ', $dataArray[$i]);

                $data .= implode(chr(9),$dataArray)."\r\n";
			}
		}

		header($_SERVER['SERVER_PROTOCOL'] . ' 200 OK');
		header('Cache-Control: public');
		header('Content-Encoding: UTF-8');
		header('Content-Type: text/csv; charset=UTF-8');
		header('Content-Transfer-Encoding: Binary');
		header('Content-Length:' . strlen($data));
		header('Content-Disposition: attachment;filename=' . $exportFileName);
		echo "\xEF\xBB\xBF";
		echo $data;
		die();
	}
	
}
