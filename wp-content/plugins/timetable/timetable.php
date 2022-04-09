<?php
/*
Plugin Name: Timetable Responsive Schedule For WordPress
Plugin URI: https://1.envato.market/timetable-responsive-schedule-for-wordpress
Description: Timetable Responsive Schedule For WordPress is a powerful and easy-to-use schedule plugin for WordPress. It will help you to create a timetable view of your events in minutes. It is perfect for gym classes, school or kindergarten classes, medical departments, nightclubs, lesson plans, meal plans etc. It comes with Events Manager, Event Occurrences Shortcode, Timetable Shortcode Generator and Upcoming Events Widget.
Author: QuanticaLabs
Author URI: https://1.envato.market/quanticalabs-portfolio-codecanyon
Version: 6.3
*/

//translation
function timetable_load_textdomain()
{
	load_plugin_textdomain("timetable", false, dirname(plugin_basename(__FILE__)) . '/languages');
}
add_action('plugins_loaded', 'timetable_load_textdomain');
function timetable_init_sp_bookings()
{
	if(!class_exists('WP_List_Table'))
		require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
	require_once('class/bookings-list.class.php');
	require_once('class/sp-bookings.class.php');
	SP_Bookings::get_instance();
}
add_action('plugins_loaded', 'timetable_init_sp_bookings');
require_once('class/db.class.php');
require_once('class/post.class.php');
require_once('class/event.class.php');
require_once('class/event-hour.class.php');
require_once('class/weekday.class.php');
require_once('post-type-weekdays.php');
require_once('post-type-events.php');
require_once('widget-upcoming-events.php');
require_once('shortcodes.php');
require_once('shortcode-timetable.php');
//Template fallback
add_action('template_redirect', 'timetable_redirect', 99);

if(function_exists("register_sidebar"))
{
	register_sidebar(array(
		"id" => "sidebar-event",
		"name" => "Sidebar Event",
		'before_widget' => '<div id="%1$s" class="widget %2$s timetable_sidebar_box timetable_clearfix">',
		'after_widget' => '</div>',
		'before_title' => '<h5 class="box_header">',
		'after_title' => '</h5>'
	));
}

function timetable_init()
{
	//phpMailer
	add_action('phpmailer_init', 'timetable_phpmailer_init');
	
	$timetable_contact_form_options = get_option("timetable_contact_form_options");
	if(!$timetable_contact_form_options)
	{
		$timetable_contact_form_options = array(
			"admin_name" => get_option("admin_email"),
			"admin_email" => get_option("admin_email"),
			"mail_debug" => "not",
			"smtp_host" => "",
			"smtp_username" => "",
			"smtp_password" => "",
			"smtp_port" => "",
			"smtp_secure" => "",
			"email_subject_client" => __("You have been booked for event {event_title}", 'timetable'),
			"template_client" => "<html>
<head>
</head>
<body>
	<div>Thank you for using our services.</div>
	<div>Booking details</div>
	<div><b>User</b>: {user_name}</div>
	<div><b>Mail</b>: {user_email}</div>
	<div><b>Date</b>: {booking_datetime}</div>
	<div>Event details</div>
	<div><b>Event</b>: {event_title}</div>
	<div><b>Day</b>: {column_title}</div>
	<div><b>Time</b>: {event_start} - {event_end}</div>
	<div><b>Description 1</b>: {event_description_1}</div>
	<div><b>Description 2</b>: {event_description_2}</div>
	<div><b>Slots number</b>: {slots_number}</div>
	<div>{cancel_booking}</div>
</body>
</html>",
			"email_subject_admin" => __("New booking for event: {event_title}", 'timetable'),
			"template_admin" => "<html>
<head>
</head>
<body>
	<div>New client</div>
	<div>Booking details</div>
	<div><b>User</b>: {user_name}</div>
	<div><b>Mail</b>: {user_email}</div>
	<div><b>Date</b>: {booking_datetime}</div>
	<div>Event details</div>
	<div><b>Event</b>: {event_title}</div>
	<div><b>Day</b>: {column_title}</div>
	<div><b>Time</b>: {event_start} - {event_end}</div>
	<div><b>Description 1</b>: {event_description_1}</div>
	<div><b>Description 2</b>: {event_description_2}</div>
	<div><b>Slots number</b>: {slots_number}</div>
</body>
</html>",
		);
		add_option('timetable_contact_form_options', $timetable_contact_form_options);
	}
	
	$timetable_google_calendar_options = get_option("timetable_google_calendar_options");
	if(!$timetable_google_calendar_options)
	{
		$timetable_google_calendar_options = array(
			"calendar_id" => "",
			"calendar_settings" => "",
		);
		add_option('timetable_google_calendar_options', $timetable_google_calendar_options);
	}
	
	if(!isset($timetable_contact_form_options['mail_debug']))
	{
		$timetable_contact_form_options['mail_debug'] = 'no';
		update_option('timetable_contact_form_options', $timetable_contact_form_options);
	}
}
add_action('init', 'timetable_init');

function timetable_cancel_booking()
{
	if(!(array_key_exists('action', $_GET) && $_GET['action']==='timetable_cancel_booking'))
		return;
	
	$booking_id = array_key_exists('booking_id', $_GET) ? $_GET['booking_id'] : 0;
	$validation_code = array_key_exists('validation_code', $_GET) ? $_GET['validation_code'] : '';
	$bookings_ids = array_key_exists('bookings_ids', $_GET) ? explode(',', $_GET['bookings_ids']) : array();
	$validation_codes = array_key_exists('validation_codes', $_GET) ? explode(',', $_GET['validation_codes']) : array();
	
	$bookings_ids[] = $booking_id;
	$validation_codes[] = $validation_code;
	
	//get all booking details
	$bookings = array();
	if(count($bookings_ids) && count($bookings_ids)==count($validation_codes))
	{
		for($i=0, $max_i = count($bookings_ids); $i<$max_i; $i++)
		{
			if($bookings_ids[$i]>0 && strlen($validation_codes[$i])==32)
			{
				$result = TT_DB::getBookings(array(
					'booking_id' => $bookings_ids[$i],
					'validation_code' => $validation_codes[$i],
				));
				if(isset($result[0]['booking_id']) && $result[0]['booking_id']==$bookings_ids[$i])
					$bookings[] = $result[0];
				else
					echo '<b>' . sprintf(__('Error: Booking #%d does not exist or validation code is incorrect.', 'timetable'), $bookings_ids[$i]) . '</b><br>';
			}
		}
	}
	if(!count($bookings))
		return;
	
	//delete bookings and display their details
	foreach($bookings as $booking)
	{
		//delete booking
		TT_DB::deleteBooking($booking['booking_id']);
		//display booking information
		echo '<b>' . sprintf(__('Booking #%d (%s) deleted', 'timetable'), $booking['booking_id'], $booking['booking_datetime']) . '</b><br>';		
		echo sprintf(__('Title: %s', 'timetable'), $booking['event_title']) . '<br>';
		echo sprintf(__('Time: %s', 'timetable'), $booking['start'] . '-' . $booking['end']) . '<br>';
		echo sprintf(__('Column: %s', 'timetable'), $booking['weekday']) . '<br>';
		if($booking['event_description_1'])
			echo sprintf(__('Description 1: %s', 'timetable'), $booking['event_description_1']) . '<br>';
		if($booking['event_description_2'])
			echo sprintf(__('Description 2: %s', 'timetable'), $booking['event_description_2']) . '<br>';
		echo '<br>';
	}
	
	//send email to administrator
	$timetable_contact_form_options = timetable_stripslashes_deep(get_option("timetable_contact_form_options"));
	$admin_name = $timetable_contact_form_options['admin_name'];
	$admin_email = $timetable_contact_form_options['admin_email'];
	$client_name = '';
	$client_email = '';
	$client_phone = '';
	if($bookings[0]['user_id']>0)
	{
		$client_name = $bookings[0]['user_name'];
		$client_email = $bookings[0]['user_email'];
	}
	else
	{
		$client_name = $bookings[0]['guest_name'];
		$client_email = $bookings[0]['guest_email'];
		$client_phone = $bookings[0]['guest_phone'];
	}
	
	$headers = array();
	$headers[] = 'Reply-To: ' . $client_name . ' <' . $client_email . '>' . "\r\n";
	$headers[] = 'From: ' . $admin_name . ' <' . $admin_email . '>' . "\r\n";
	$headers[] = 'Content-type: text/html';
	$subject = __('Bookings canceled', 'timetable');
	$body = '';
	
	$body .= '<h3>' . __('Client details', 'timetable') . '</h3>';
	$body .= sprintf(__('Name: %s', 'timetable'), $client_name) . '<br>';
	$body .= sprintf(__('Email: %s', 'timetable'), $client_email) . '<br>';
	if($client_phone)
		$body .= sprintf(__('Phone: %s', 'timetable'), $client_phone) . '<br>';
	$body .= '<br>';
	$body .= '<h3>' . __('Canceled Bookings', 'timetable') . '</h3>';
	foreach($bookings as $booking)
	{
		$body .= sprintf(__('Booking: #%d (%s)', 'timetable'), $booking['booking_id'], $booking['booking_datetime']) . '<br>';
		$body .= sprintf(__('Title: %s', 'timetable'), $booking['event_title']) . '<br>';
		$body .= sprintf(__('Time: %s', 'timetable'), $booking['start'] . '-' . $booking['end']) . '<br>';
		$body .= sprintf(__('Column: %s', 'timetable'), $booking['weekday']) . '<br>';
		if($booking['event_description_1'])
			$body .= sprintf(__('Description 1: %s', 'timetable'), $booking['event_description_1']) . '<br>';
		if($booking['event_description_2'])
			$body .= sprintf(__('Description 2: %s', 'timetable'), $booking['event_description_2']) . '<br>';
		$body .= '<br>';
	}
	
	wp_mail($admin_name . ' <' . $admin_email . '>', $subject, $body, $headers);
	die;
}
add_action('init', 'timetable_cancel_booking');

function timetable_phpmailer_init($mail) 
{
	$timetable_contact_form_options = timetable_stripslashes_deep(get_option("timetable_contact_form_options"));
	$mail->CharSet='UTF-8';
	$smtp = (isset($timetable_contact_form_options["smtp_host"]) ? $timetable_contact_form_options["smtp_host"] : null);
	if(!empty($smtp))
	{
		$mail->IsSMTP();
		$mail->SMTPAuth = true; 
//		$mail->SMTPDebug = 2;
		$mail->Host = $timetable_contact_form_options["smtp_host"];
		$mail->Username = $timetable_contact_form_options["smtp_username"];
		$mail->Password = $timetable_contact_form_options["smtp_password"];
		if((int)$timetable_contact_form_options["smtp_port"]>0)
			$mail->Port = (int)$timetable_contact_form_options["smtp_port"];
		$mail->SMTPSecure = $timetable_contact_form_options["smtp_secure"];
	}
}

function timetable_redirect()
{
    global $wp;
	$timetable_events_settings = timetable_events_settings();
    $plugindir = dirname( __FILE__ );

    //A Specific Custom Post Type
    if (isset($wp->query_vars["post_type"]) && $wp->query_vars["post_type"] == $timetable_events_settings["slug"])
	{
        $templatefilename = 'event-template.php';
		
        if(file_exists(STYLESHEETPATH . '/' . $templatefilename))
		{
            $return_template = STYLESHEETPATH . '/' . $templatefilename;
        }
		elseif(file_exists(TEMPLATEPATH . '/' . $templatefilename))
		{
			$return_template = TEMPLATEPATH . '/' . $templatefilename;
		}
		else
		{
            $return_template = $plugindir . '/' . $templatefilename;
        }
        do_timetable_redirect($return_template);

    //A Custom Taxonomy Page
    }
}

function do_timetable_redirect($url) {
    global $post, $wp_query;
    if (have_posts()) {
        include($url);
        die();
    } else {
        $wp_query->is_404 = true;
    }
}

//register event post thumbnail
add_theme_support("post-thumbnails");
add_image_size("event-post-thumb", 630, 300, true);
add_image_size("event-post-thumb-box", 300, 240, true);
function timetable_image_sizes($sizes)
{
	$addsizes = array(
		"event-post-thumb" => __("Event post thumbnail", 'timetable'),
		"event-post-thumb-box" => __("Event post box thumbnail", 'timetable')
	);
	$newsizes = array_merge($sizes, $addsizes);
	return $newsizes;
}
add_filter("image_size_names_choose", "timetable_image_sizes");

//documentation link
function timetable_documentation_link($links) 
{ 
  $documentation_link = '<a href="' . plugins_url('documentation/index.html', __FILE__) . '" title="Documentation">Documentation</a>'; 
  array_unshift($links, $documentation_link); 
  return $links;
}
 
$plugin = plugin_basename(__FILE__); 
add_filter("plugin_action_links_$plugin", 'timetable_documentation_link');

//settings link
function timetable_settings_link($links) 
{
  $settings_link = '<a href="admin.php?page=timetable_admin" title="Settings">Settings</a>'; 
  array_unshift($links, $settings_link); 
  return $links;
}
 
$plugin = plugin_basename(__FILE__); 
add_filter("plugin_action_links_$plugin", 'timetable_settings_link');

function timetable_enqueue_scripts()
{
	wp_enqueue_script('jquery');
	wp_enqueue_script('jquery-ui-core');
	wp_enqueue_script('jquery-ui-tabs');
	wp_enqueue_script("jquery-qtip2", plugins_url('js/jquery.qtip.min.js', __FILE__), array('jquery'), false, true);
	
	wp_enqueue_script("jquery-ba-bqq", plugins_url('js/jquery.ba-bbq.min.js', __FILE__), array('jquery'), false, true);
	wp_enqueue_script("jquery-carouFredSel", plugins_url('js/jquery.carouFredSel-6.2.1-packed.js', __FILE__), array('jquery'), false, true);
	if(function_exists("is_customize_preview") && !is_customize_preview())
		wp_enqueue_script('timetable_main', plugins_url('js/timetable.js', __FILE__), array("jquery"), false, true);
	wp_enqueue_style('timetable_sf_style', plugins_url('style/superfish.css', __FILE__));
	wp_enqueue_style('timetable_gtip2_style', plugins_url('style/jquery.qtip.css', __FILE__));
	wp_enqueue_style('timetable_style', plugins_url('style/style.css', __FILE__));
	wp_enqueue_style('timetable_event_template', plugins_url('style/event_template.css', __FILE__));
	wp_enqueue_style('timetable_responsive_style', plugins_url('style/responsive.css', __FILE__));
	wp_enqueue_style('timetable_font_lato', '//fonts.googleapis.com/css?family=Lato:400,700');
	
	$data = array();
	$data["ajaxurl"] = admin_url("admin-ajax.php");
	
	//pass data to javascript
	$params = array(
		'l10n_print_after' => 'tt_config = ' . json_encode($data) . ';'
	);
	wp_localize_script("timetable_main", "tt_config", $params);
}
add_action('wp_enqueue_scripts', 'timetable_enqueue_scripts');

//admin
if(is_admin())
{
	function timetable_admin_menu()
	{
		$page = add_menu_page(__('Timetable', 'timetable'), __('Timetable', 'timetable'), 'manage_options', 'timetable_admin', 'timetable_admin_page', '', 20);
		$shortcode_generator_page = add_submenu_page('timetable_admin', __('Shortcode Generator', 'timetable'), __('Shortcode Generator', 'timetable'), 'manage_options', 'timetable_admin', 'timetable_admin_page');
		$event_config_page = add_submenu_page('timetable_admin', __('Event Post Type', 'timetable'), __('Event Post Type', 'timetable'), 'manage_options', 'timetable_admin_page_event_post_type', 'timetable_admin_page_event_post_type');
		$email_config_page = add_submenu_page('timetable_admin', __('Email config', 'timetable'), __('Email config', 'timetable'), 'manage_options', 'timetable_admin_page_email_config', 'timetable_admin_page_email_config');
		$import_dummy_data_page = add_submenu_page('timetable_admin', __('Import Dummy Data', 'timetable'), __('Import Dummy Data', 'timetable'), 'manage_options', 'timetable_admin_page_import_dummy_data', 'timetable_admin_page_import_dummy_data');
		$google_calendar_page = add_submenu_page('timetable_admin', __('Google Calendar', 'timetable'), __('Google Calendar', 'timetable'), 'manage_options', 'timetable_admin_page_google_calendar', 'timetable_admin_page_google_calendar');
		
		add_action('admin_enqueue_scripts', 'timetable_admin_enqueue_scripts');
	}
	add_action('admin_menu', 'timetable_admin_menu');

	function timetable_admin_init()
	{
		wp_register_script('timetable-colorpicker', plugins_url('admin/js/colorpicker.js', __FILE__));
		wp_register_script('timetable-clipboard', plugins_url('admin/js/clipboard.min.js', __FILE__), array("jquery"));
		wp_register_script('timetable-admin', plugins_url('admin/js/timetable_admin.js', __FILE__), array("jquery", "timetable-clipboard"));
		wp_register_style('timetable-colorpicker', plugins_url('admin/style/colorpicker.css', __FILE__));
		wp_register_style('timetable-admin', plugins_url('admin/style/style.css', __FILE__));
	}
	add_action('admin_init', 'timetable_admin_init');

	function timetable_admin_enqueue_scripts($hook)
	{
		$admin_pages = array('post.php', 'post-new.php', 'widgets.php');
		
		if(strpos($hook, 'page_timetable_admin')!=FALSE || in_array($hook, $admin_pages))
		{
			wp_enqueue_script('jquery');
			wp_enqueue_script('jquery-ui-core');
			wp_enqueue_script('jquery-ui-tabs');
			wp_enqueue_script('timetable-colorpicker');
			wp_enqueue_script('timetable-clipboard');
			wp_enqueue_script('timetable-admin');
			wp_enqueue_style('timetable-colorpicker');
			$data = array(
				'img_url' => plugins_url("admin/images/", __FILE__),
				'js_url' => plugins_url("admin/js/", __FILE__),
				'delete_event_booking_confirmation' => __('Please confirm that you want to delete event bookings.', 'timetable'),
				'booking_popup_message' => BOOKING_POPUP_MESSAGE,
				'booking_popup_thank_you_message' => BOOKING_POPUP_THANK_YOU_MESSAGE,
			);
			//pass data to javascript
			$params = array(
				'l10n_print_after' => 'config = ' . json_encode($data) . ';'
			);
			wp_localize_script('timetable-admin', 'config', $params);
		}
		
		wp_enqueue_style('timetable-admin');
	}
	
	function timetable_admin_print_scripts()
	{
		wp_enqueue_script('jquery');
		wp_enqueue_script('jquery-ui-core');
		wp_enqueue_script('jquery-ui-tabs');
		wp_enqueue_script('timetable-colorpicker');
		wp_enqueue_script('timetable-clipboard');
		wp_enqueue_script('timetable-admin');
		wp_enqueue_style('timetable-colorpicker');
		$data = array(
			'img_url' => plugins_url("admin/images/", __FILE__),
			'js_url' => plugins_url("admin/js/", __FILE__),
			'booking_popup_message' => BOOKING_POPUP_MESSAGE,
			'booking_popup_thank_you_message' => BOOKING_POPUP_THANK_YOU_MESSAGE,
		);
		//pass data to javascript
		$params = array(
			'l10n_print_after' => 'config = ' . json_encode($data) . ';'
		);
		wp_localize_script("timetable-admin", "config", $params);
	}
	
	function timetable_admin_print_scripts_all()
	{
		wp_enqueue_style('timetable-admin');
	}
	
	function timetable_ajax_get_font_subsets()
	{
		if($_POST["font"]!="")
		{
			$subsets = '';
			$fontExplode = explode(":", $_POST["font"]);
			//get google fonts
			$fontsArray = timetable_get_google_fonts();
			$fontsCount = count((array)$fontsArray->items);
			for($i=0; $i<$fontsCount; $i++)
			{
				if($fontsArray->items[$i]->family==$fontExplode[0])
				{
				    for($j=0, $max_j=count((array)$fontsArray->items[$i]->subsets); $j<$max_j; $j++)
					{
						$subsets .= '<option value="' . $fontsArray->items[$i]->subsets[$j] . '">' . $fontsArray->items[$i]->subsets[$j] . '</option>';
					}
					break;
				}
			}
			echo "timetable_start" . $subsets . "timetable_end";
		}
		exit();
	}
	add_action('wp_ajax_timetable_get_font_subsets', 'timetable_ajax_get_font_subsets');
	
	function timetable_ajax_event_hour_details()
	{
		$result = array();
		$result['msg'] = '';
		$result['error'] = 0;
		
		if(!(isset($_POST['event_hour_id']) && $event_hour_id=$_POST['event_hour_id']))
		{
			$result["msg"] = __("<h2>Invalid event hour</h2>
<p>Selected event hour doesn't exist.<br>Please select different event.</p>", "timetable");
			$result["error"] = 1;
			timetable_ajax_response($result);
		}
		
		$redirect_url = (isset($_POST['redirect_url']) ? $_POST['redirect_url'] : '');
		$allow_user_booking = (isset($_POST['atts']['allow_user_booking']) ? $_POST['atts']['allow_user_booking'] : 'yes');
		$booking_popup_message_template = (isset($_POST['atts']['booking_popup_message']) ? $_POST['atts']['booking_popup_message'] : '');
		$booking_popup_message_template = timetable_stripslashes_deep($booking_popup_message_template);
		$booking_popup_label = (isset($_POST['atts']['booking_popup_label']) ? $_POST['atts']['booking_popup_label'] : '');
		$login_popup_label = (isset($_POST['atts']['login_popup_label']) ? $_POST['atts']['login_popup_label'] : '');
		$cancel_popup_label = (isset($_POST['atts']['cancel_popup_label']) ? $_POST['atts']['cancel_popup_label'] : '');
		$continue_popup_label = (isset($_POST['atts']['continue_popup_label']) ? $_POST['atts']['continue_popup_label'] : '');
		
		$user_id = ($allow_user_booking=='yes' ? get_current_user_id() : 0);
		
		$event_hour_details = TT_DB::getEventHours(array(
			'event_hours_id' => $event_hour_id,
			'user_id' => $user_id,
		));
		
		$event_hour_details = $event_hour_details[0];
		
		if(!$event_hour_details)
		{
			$result['msg'] = __('<h2>Invalid event hour</h2><p>Selected event hour doesn\'t exist.<br>Please select different event.</p>', 'timetable');
			$result['error'] = 1;
			timetable_ajax_response($result);
		}

		
		$time_format = (isset($_POST['atts']['time_format']) ? $_POST['atts']['time_format'] : 'H.i');
		$booking_form_config = array(
		    'allow_user_booking' => $allow_user_booking,
			'allow_guest_booking' => (isset($_POST['atts']['allow_guest_booking']) ? $_POST['atts']['allow_guest_booking'] : 'no'),
		    'default_booking_view' => (isset($_POST['atts']['default_booking_view']) ? $_POST['atts']['default_booking_view'] : 'user'),
			'show_guest_name_field' => (isset($_POST['atts']['show_guest_name_field']) ? $_POST['atts']['show_guest_name_field'] : 'no'),
			'guest_name_field_required' => (isset($_POST['atts']['guest_name_field_required']) ? $_POST['atts']['guest_name_field_required'] : 'no'),
			'show_guest_phone_field' => (isset($_POST['atts']['show_guest_phone_field']) ? $_POST['atts']['show_guest_phone_field'] : 'no'),
			'guest_phone_field_required' => (isset($_POST['atts']['guest_phone_field_required']) ? $_POST['atts']['guest_phone_field_required'] : 'no'),
			'show_guest_message_field' => (isset($_POST['atts']['show_guest_message_field']) ? $_POST['atts']['show_guest_message_field'] : 'no'),
			'guest_message_field_required' => (isset($_POST['atts']['guest_message_field_required']) ? $_POST['atts']['guest_message_field_required'] : 'no'),
			'terms_checkbox' => (isset($_POST['atts']['terms_checkbox']) ? $_POST['atts']['terms_checkbox'] : 'no'),
			'terms_message' => (isset($_POST['atts']['terms_message']) ? stripslashes($_POST['atts']['terms_message']) : 'Please accept terms and conditions'),
			'current_user_booking_count' => $event_hour_details->current_user_booking_count,
			'slots_per_user' => $event_hour_details->slots_per_user,
			'remaining_places' => $event_hour_details->available_places-$event_hour_details->booking_count,
		);
		
		$btn_book_config = array(
			'booking_label' => $booking_popup_label,
			'login_label' => $login_popup_label,
			'redirect_url' => $redirect_url,
			'allow_user_booking' => $booking_form_config['allow_user_booking'],
		    'allow_guest_booking' => $booking_form_config['allow_guest_booking'],
		    'default_booking_view' => $booking_form_config['default_booking_view'],
		);
		
		//insert values into the template
		$result['msg'] = $booking_popup_message_template;
		$result['msg'] = str_replace('{event_title}', $event_hour_details->event_title, $result['msg']);
		$result['msg'] = str_replace('{column_title}', $event_hour_details->column_title, $result['msg']);
		$result['msg'] = str_replace('{event_start}', date($time_format, strtotime($event_hour_details->start)), $result['msg']);
		$result['msg'] = str_replace('{event_end}', date($time_format, strtotime($event_hour_details->end)), $result['msg']);
		$result['msg'] = str_replace('{event_description_1}', $event_hour_details->description_1, $result['msg']);
		$result['msg'] = str_replace('{event_description_2}', $event_hour_details->description_2, $result['msg']);
		$result['msg'] = str_replace('{booking_form}', tt_booking_form($booking_form_config), $result['msg']);
		$result['msg'] = str_replace('{tt_btn_book}', tt_btn_book($btn_book_config), $result['msg']);
		$result['msg'] = str_replace('{tt_btn_cancel}', tt_btn_cancel($cancel_popup_label), $result['msg']);
		$result['msg'] = str_replace('{tt_btn_continue}', tt_btn_continue($continue_popup_label), $result['msg']);
		
		if(!$user_id && $booking_form_config['allow_guest_booking']=='yes')
		{
		    //show additional label 'Continue as guest.'
		    $guestOptionHidden = false;
		    if($booking_form_config['default_booking_view']=='guest')
		        $guestOptionHidden = true;
		    
		        $result['msg'] .= sprintf(__('<p class="tt_guest_option ' . ($guestOptionHidden ? 'tt_hide' : '') . '">Don\'t have an account? <a href="%s">Continue as guest</a></p>', 'timetable'), '#');
		}
		
		
		if(!$user_id && $booking_form_config['allow_user_booking']=='yes')
		{
		    //show additional label 'Got an account? Login'
		    $loginOptionHidden = false;
		    if($booking_form_config['default_booking_view']=='user')
		        $loginOptionHidden = true;
		    
		        $result['msg'] .= sprintf(__('<p class="tt_login_option ' . ($loginOptionHidden ? 'tt_hide' : '') . '">Got an account? <a href="%s">Login</a></p>', 'timetable'), wp_login_url($redirect_url));
		    
		}
		
		timetable_ajax_response($result);
	}
	
	add_action('wp_ajax_timetable_ajax_event_hour_details', 'timetable_ajax_event_hour_details');
	add_action('wp_ajax_nopriv_timetable_ajax_event_hour_details', 'timetable_ajax_event_hour_details');
	
	function timetable_ajax_event_hour_booking()
	{
		$result = array();
		$result['msg'] = '';
		$result['error'] = 0;
		$result['booking_id'] = 0;
		$result['event_hour_active'] = 1;

		$allow_user_booking = (isset($_POST['atts']['allow_user_booking']) ? filter_var($_POST['atts']['allow_user_booking'], FILTER_SANITIZE_STRING) : 'yes');
		$user_id = ($allow_user_booking=='yes' ? get_current_user_id() : 0);
		$terms_checkbox_required = (isset($_POST['atts']['terms_checkbox']) ? filter_var($_POST['atts']['terms_checkbox'], FILTER_SANITIZE_STRING) : 'no');
		$terms_checkbox = (isset($_POST["terms_checkbox"]) ? filter_var($_POST["terms_checkbox"], FILTER_VALIDATE_BOOLEAN) : false);

		if(!$user_id && $terms_checkbox_required=='yes' && !$terms_checkbox)
		{
			$result['event_hour_active'] = 0;
			$result['msg'] = __('<h2>Booking couldn\'t be made</h2>
<p>Please accept terms and conditions checkbox.</p>', 'timetable');
			$result['error'] = 1;
			timetable_ajax_response($result);
		}
		
		$event_hour_id = (int)$_POST['event_hour_id'];
		$guest_id = 0;
		$time_format = (isset($_POST['atts']['time_format']) ? $_POST['atts']['time_format'] : 'H.i');
		$guest_config = array(
			'allow_guest_booking' => (isset($_POST['atts']['allow_guest_booking']) ? $_POST['atts']['allow_guest_booking'] : 'no'),
			'show_guest_name_field' => (isset($_POST['atts']['show_guest_name_field']) ? $_POST['atts']['show_guest_name_field'] : 'no'),
			'guest_name_field_required' => (isset($_POST['atts']['guest_name_field_required']) ? $_POST['atts']['guest_name_field_required'] : 'no'),
			'show_guest_phone_field' => (isset($_POST['atts']['show_guest_phone_field']) ? $_POST['atts']['show_guest_phone_field'] : 'no'),
			'guest_phone_field_required' => (isset($_POST['atts']['guest_phone_field_required']) ? $_POST['atts']['guest_phone_field_required'] : 'no'),
			'show_guest_message_field' => (isset($_POST['atts']['show_guest_message_field']) ? $_POST['atts']['show_guest_message_field'] : 'no'),
			'guest_message_field_required' => (isset($_POST['atts']['guest_message_field_required']) ? $_POST['atts']['guest_message_field_required'] : 'no'),
		);
		
		$slots_number = (isset($_POST["slots_number"]) ? sanitize_text_field($_POST["slots_number"]) : 1);
		$guest_name = (isset($_POST["guest_name"]) ? stripslashes(sanitize_text_field($_POST["guest_name"])) : '');
		$guest_email = (isset($_POST["guest_email"]) ? sanitize_email($_POST["guest_email"]) : '');
		$guest_phone = (isset($_POST["guest_phone"]) ? stripslashes(sanitize_text_field($_POST["guest_phone"])) : '');
		$guest_message = (isset($_POST["guest_message"]) ? stripslashes(sanitize_textarea_field($_POST["guest_message"])) : '');

		$available_slots_singular_label = (isset($_POST["atts"]["available_slots_singular_label"]) ? $_POST["atts"]["available_slots_singular_label"] : "{number_available}/{number_total} slot available");
		$available_slots_plural_label = (isset($_POST["atts"]["available_slots_plural_label"]) ? $_POST["atts"]["available_slots_plural_label"] : "{number_available}/{number_total} slots available");
		$continue_popup_label = (isset($_POST["atts"]["continue_popup_label"]) ? $_POST["atts"]["continue_popup_label"] : "");
		$booking_popup_thank_you_message_template = (isset($_POST["atts"]["booking_popup_thank_you_message"]) ? $_POST["atts"]["booking_popup_thank_you_message"] : "");
		$booking_popup_thank_you_message_template = timetable_stripslashes_deep($booking_popup_thank_you_message_template);
		
		$args = array(
			'event_hours_id' => $event_hour_id,
			'user_id' => $user_id,
			'guest_email' => $guest_email,
		);

		$event_hour_details = TT_DB::getEventHours($args);
		$event_hour_details = $event_hour_details[0];

		$result["available_places"] = $event_hour_details->available_places;
		$result["booking_count"] = $event_hour_details->booking_count;
		$result["remaining_places"] = $event_hour_details->available_places-$event_hour_details->booking_count;
		if(!($event_hour_details->available_places>0 && $event_hour_details->booking_count<$event_hour_details->available_places))
		{
			$result['event_hour_active'] = 0;
			$result['msg'] = __('<h2>Booking couldn\'t be made</h2>
<p>No place available for selected event hour.</p>', 'timetable');
			$result['error'] = 1;
			timetable_ajax_response($result);
		}
		
		//check if user/guest already booked max slots
		$remaining_slots = $event_hour_details->slots_per_user-$event_hour_details->current_user_booking_count-$event_hour_details->current_guest_booking_count;
		
		if($remaining_slots<1)
		{
			$result['msg'] = __('<h2>Booking couldn\'t be made</h2>
<p>You\'ve already reached maximum number of slots.</p>', 'timetable');
			$result['error'] = 1;
			timetable_ajax_response($result);
		}
		
		if($slots_number>$remaining_slots)
		{
			$result['msg'] = __('<h2>Booking couldn\'t be made</h2>
<p>You have selected too many slots.</p>', 'timetable');
			$result['error'] = 1;
			timetable_ajax_response($result);
		}
		
		if(!$user_id && $guest_config['allow_guest_booking']=='yes')
		{
			if($guest_config['guest_name_field_required']=='yes' && $guest_name=='')
			{
				$result['msg'] = __('<h2>Error</h2>
<p>You must fill name field.</p>', 'timetable');
				$result['error'] = 1;
				timetable_ajax_response($result);
			}
			if($guest_email=='')
			{
				$result['msg'] = __('<h2>Error</h2>
<p>You must fill email field.</p>', 'timetable');
				$result['error'] = 1;
				timetable_ajax_response($result);
			}
			if(!filter_var($guest_email, FILTER_VALIDATE_EMAIL))
			{
				$result['msg'] = __('<h2>Error</h2>
<p>Please provide valid email.</p>', 'timetable');
				$result['error'] = 1;
				timetable_ajax_response($result);
			}
			if($guest_config['guest_phone_field_required']=='yes' && $guest_phone=='')
			{
				$result['msg'] = __('<h2>Error</h2>
<p>You must fill phone field.</p>', 'timetable');
				$result['error'] = 1;
				timetable_ajax_response($result);
			}
			if($guest_config['guest_message_field_required']=='yes' && $guest_message=='')
			{
				$result['msg'] = __('<h2>Error</h2>
<p>You must fill message field.</p>', 'timetable');
				$result['error'] = 1;
				timetable_ajax_response($result);
			}
			
			$guest_id = TT_DB::createGuest(array(
				'guest_name' => $guest_name,
				'guest_email' => $guest_email,
				'guest_phone' => $guest_phone,
				'guest_message' => $guest_message,
			));
		}
		
		//create bookings
		$bookings_ids = array();
		$booking_date = date_i18n('Y-m-d H:i:s');
		for($i=0; $i<$slots_number; $i++)
		{
			$validation_code = md5(time()+$event_hour_id+$user_id+mt_rand()*$i+timetable_random_string());			
			$bookings_ids[] = TT_DB::createBooking(array(
				'event_hour_id' => $event_hour_id,
				'user_id' => $user_id,
				'booking_date' => $booking_date,
				'guest_id' => $guest_id,
				'validation_code' => $validation_code,
			));
		}
		
		if(!$bookings_ids)
		{
			$result['msg'] = __('<h2>Booking couldn\'t be made</h2>
<p>You can\'t register for this event hour.</p>', 'timetable');
			$result['error'] = 1;
			timetable_ajax_response($result);
		}
		
		$result['msg'] = $booking_popup_thank_you_message_template;
		$result['msg'] = str_replace('{event_title}', $event_hour_details->event_title, $result['msg']);
		$result['msg'] = str_replace('{column_title}', $event_hour_details->column_title, $result['msg']);
		$result['msg'] = str_replace('{event_start}', date($time_format, strtotime($event_hour_details->start)), $result['msg']);
		$result['msg'] = str_replace('{event_end}', date($time_format, strtotime($event_hour_details->end)), $result['msg']);
		$result['msg'] = str_replace('{event_description_1}', $event_hour_details->description_1, $result['msg']);
		$result['msg'] = str_replace('{event_description_2}', $event_hour_details->description_2, $result['msg']);
		$result['msg'] = str_replace('{tt_btn_continue}', tt_btn_continue($continue_popup_label), $result['msg']);
		
		$result['booking_count'] += $slots_number;
		$result['remaining_places'] -= $slots_number;
		
		$current_user_booking_count = ($user_id ? $event_hour_details->current_user_booking_count+$slots_number : 0);
		
		$result['booking_button'] = prepare_booking_button(array(
			'current_user_booking_count' => $current_user_booking_count,
			'slots_per_user' => $event_hour_details->slots_per_user,
			'event_hours_id' => $event_hour_id,
			'booked_text_color' => $_POST['atts']['booked_text_color'],
			'booked_bg_color' => $_POST['atts']['booked_bg_color'],
			'booked_label' => $_POST['atts']['booked_label'],
			'available_slots' => $result['remaining_places'],
			'unavailable_text_color' => $_POST['atts']['unavailable_text_color'],
			'unavailable_bg_color' => $_POST['atts']['unavailable_bg_color'],
			'unavailable_label' => $_POST['atts']['unavailable_label'],
			'booking_text_color' => $_POST['atts']['booking_text_color'],
			'booking_bg_color' => $_POST['atts']['booking_bg_color'],
			'booking_hover_text_color' => $_POST['atts']['booking_hover_text_color'],
			'booking_hover_bg_color' => $_POST['atts']['booking_hover_bg_color'],
			'booking_label' => $_POST['atts']['booking_label'],
			'show_booking_button' => $_POST['atts']['show_booking_button'],
		));
		
		$result['available_slots_label'] = prepare_booking_slots_label(array(
			'available_slots' => $result['remaining_places'],
			'taken_slots' => $result['booking_count'],
			'total_slots' => $result['available_places'],
			'available_slots_singular_label' => $available_slots_singular_label,
			'available_slots_plural_label' => $available_slots_plural_label,
		));
		
		$result['event_hour_active'] = (int)($event_hour_details->booking_count+1<$event_hour_details->available_places);
		
		if($user_id || $guest_email)
		{
			$debug_info = timetable_booking_notification($bookings_ids, array('time_format' => $time_format));
			if($debug_info['msg'])
			{
				$result['msg'] .= '<p class="debug-info">' . $debug_info['msg'] . '</p>';
			}
		}
		
		timetable_ajax_response($result);
	}
	add_action('wp_ajax_timetable_ajax_event_hour_booking', 'timetable_ajax_event_hour_booking');
	add_action('wp_ajax_nopriv_timetable_ajax_event_hour_booking', 'timetable_ajax_event_hour_booking');
	
	function timetable_ajax_response($result)
	{
		echo "timetable_start" . json_encode($result) . "timetable_end";
		exit();
	}
	
	function timetable_booking_notification($bookings_ids, $options = array())
	{
		$result = array(
			'error' => 0,
			'msg' => '',
		);
		$timetable_contact_form_options = timetable_stripslashes_deep(get_option("timetable_contact_form_options"));
		$time_format = isset($options['time_format']) ? $options['time_format'] : 'H.i';
		
		$bookings = TT_DB::getBookings(array(
			'bookings_ids' => $bookings_ids,
		));
		$booking_details = $bookings[0];
		$slots_number = count($bookings);
		
		$values = array(
			'booking_id' => $booking_details['booking_id'],
			'validation_code' => $booking_details['validation_code'],
			'event_title' => $booking_details['event_title'],
			'column_title' => $booking_details['weekday'],
			'event_start' => $booking_details['start'],
			'event_end' => $booking_details['end'],
			'event_description_1' => $booking_details['event_description_1'],
			'event_description_2' => $booking_details['event_description_2'],
			'booking_datetime' => $booking_details['booking_datetime'],
			'user_id' => $booking_details['user_id'],
			'user_name' => $booking_details['user_name'],
			'user_email' => $booking_details['user_email'],
			'guest_id' => $booking_details['guest_id'],
			'guest_name' => $booking_details['guest_name'],
			'guest_email' => $booking_details['guest_email'],
			'guest_phone' => $booking_details['guest_phone'],
			'guest_message' => $booking_details['guest_message'],
		);
		
		if(get_magic_quotes_gpc()) 
			$values = array_map('stripslashes', $values);
		$values = array_map('htmlspecialchars', $values);
		
		$user_name = '';
		$user_email = '';
		$user_phone = '';
		$user_message = '';
		if($values['user_id'])
		{
			$user_name = $values['user_name'];
			$user_email = $values['user_email'];
		}
		elseif($values['guest_id'])
		{
			$user_name = $values['guest_name'];
			$user_email = $values['guest_email'];
			$user_phone = $values['guest_phone'];
			$user_message = $values['guest_message'];
		}
		
		$cancel_booking = '';
		$booking_ids = array();
		$validation_codes = array();
		foreach($bookings as $index=>$booking)
		{
			$booking_ids[] = (int)$booking['booking_id'];
			$validation_codes[] = $booking['validation_code'];
			$cancel_booking .= '<a href="' . get_site_url() . '?action=timetable_cancel_booking&booking_id=' . $booking['booking_id'] . '&validation_code=' . $booking['validation_code'] . '">' . sprintf(__('Cancel booking #%d', 'timetable'), $booking['booking_id']) . '</a><br>';
		}
		if(count($bookings)>1)
			$cancel_booking .= '<a href="' . get_site_url() . '?action=timetable_cancel_booking&bookings_ids=' . implode(',', $booking_ids) . '&validation_codes=' . implode(',', $validation_codes) . '">' . __('Cancel all bookings', 'timetable') . '</a><br>';
		
		//SEND EMAIL TO CLIENT
		$headers = array();
		$headers[] = 'Reply-To: ' . $timetable_contact_form_options['admin_name'] . ' <' . $timetable_contact_form_options['admin_email'] . '>' . "\r\n";
		$headers[] = 'From: ' . $timetable_contact_form_options['admin_name'] . ' <' . $timetable_contact_form_options['admin_email'] . '>' . "\r\n";
		$headers[] = 'Content-type: text/html';
		$subject = $timetable_contact_form_options['email_subject_client'];
		$subject = str_replace('{booking_id}', $values['booking_id'], $subject);
		$subject = str_replace('{event_title}', $values['event_title'], $subject);
		$subject = str_replace('{column_title}', $values['column_title'], $subject);
		$subject = str_replace('{event_start}', date($time_format, strtotime($values['event_start'])), $subject);
		$subject = str_replace('{event_end}', date($time_format, strtotime($values['event_end'])), $subject);
		$subject = str_replace('{event_description_1}', $values['event_description_1'], $subject);
		$subject = str_replace('{event_description_2}', $values['event_description_2'], $subject);
		$subject = str_replace('{slots_number}', $slots_number, $subject);
		$subject = str_replace('{booking_datetime}', $values['booking_datetime'], $subject);
		$subject = str_replace('{user_name}', $user_name, $subject);
		$subject = str_replace('{user_email}', $user_email, $subject);
		$subject = str_replace('{user_phone}', $user_phone, $subject);
		$subject = str_replace('{user_message}', nl2br($user_message), $subject);
		$body = $timetable_contact_form_options['template_client'];
		$body = str_replace('{booking_id}', $values['booking_id'], $body);
		$body = str_replace('{event_title}', $values['event_title'], $body);
		$body = str_replace('{column_title}', $values['column_title'], $body);
		$body = str_replace('{event_start}', date($time_format, strtotime($values['event_start'])), $body);
		$body = str_replace('{event_end}', date($time_format, strtotime($values['event_end'])), $body);
		$body = str_replace('{event_description_1}', $values['event_description_1'], $body);
		$body = str_replace('{event_description_2}', $values['event_description_2'], $body);
		$body = str_replace('{slots_number}', $slots_number, $body);
		$body = str_replace('{booking_datetime}', $values['booking_datetime'], $body);
		$body = str_replace('{user_name}', $user_name, $body);
		$body = str_replace('{user_email}', $user_email, $body);
		$body = str_replace('{user_phone}', $user_phone, $body);
		$body = str_replace('{user_message}', nl2br($user_message), $body);
		$body = str_replace('{cancel_booking}', $cancel_booking, $body);
		
		$result['error'] = !(int)wp_mail($user_name . ' <' . $user_email . '>', $subject, $body, $headers);
		
		//SEND EMAIL TO ADMIN
		$headers = array();
		$headers[] = 'Reply-To: ' . $values["user_name"] . ' <' . $values["user_email"] . '>' . "\r\n";
		$headers[] = 'From: ' . $timetable_contact_form_options["admin_name"] . ' <' . $timetable_contact_form_options["admin_email"] . '>' . "\r\n";
		$headers[] = 'Content-type: text/html';
		$subject = $timetable_contact_form_options["email_subject_admin"];
		$subject = str_replace("{booking_id}", $values["booking_id"], $subject);
		$subject = str_replace("{event_title}", $values["event_title"], $subject);
		$subject = str_replace("{column_title}", $values["column_title"], $subject);
		$subject = str_replace("{event_start}", date($time_format, strtotime($values["event_start"])), $subject);
		$subject = str_replace("{event_end}", date($time_format, strtotime($values["event_end"])), $subject);
		$subject = str_replace("{event_description_1}", $values["event_description_1"], $subject);
		$subject = str_replace("{event_description_2}", $values["event_description_2"], $subject);
		$subject = str_replace("{slots_number}", $slots_number, $subject);
		$subject = str_replace("{booking_datetime]", $values["booking_datetime"], $subject);
		$subject = str_replace("{user_name}", $user_name, $subject);
		$subject = str_replace("{user_email}", $user_email, $subject);
		$subject = str_replace("{user_phone}", $user_phone, $subject);
		$subject = str_replace("{user_message}", nl2br($user_message), $subject);
		$body = $timetable_contact_form_options["template_admin"];
		$body = str_replace("{booking_id}", $values["booking_id"], $body);
		$body = str_replace("{event_title}", $values["event_title"], $body);
		$body = str_replace("{column_title}", $values["column_title"], $body);
		$body = str_replace("{event_start}", date($time_format, strtotime($values["event_start"])), $body);
		$body = str_replace("{event_end}", date($time_format, strtotime($values["event_end"])), $body);
		$body = str_replace("{event_description_1}", $values["event_description_1"], $body);
		$body = str_replace("{event_description_2}", $values["event_description_2"], $body);
		$body = str_replace("{slots_number}", $slots_number, $body);
		$body = str_replace("{booking_datetime}", $values["booking_datetime"], $body);
		$body = str_replace("{user_name}", $user_name, $body);
		$body = str_replace("{user_email}", $user_email, $body);
		$body = str_replace("{user_phone}", $user_phone, $body);
		$body = str_replace("{user_message}", nl2br($user_message), $body);
		$body = str_replace("{cancel_booking}", $cancel_booking, $body);

		$result['error'] = !(int)wp_mail($timetable_contact_form_options['admin_name'] . ' <' . $timetable_contact_form_options['admin_email'] . '>', $subject, $body, $headers);
		
		if($timetable_contact_form_options['mail_debug']=='yes')
		{
			if($result['error']==0)
			{
				$result['msg'] .= __('Email message sent.', 'timetable');
			}
			else
			{
				$result['msg'] .= sprintf(__('Email message not sent.<br>%s', 'timetable'), $GLOBALS['phpmailer']->ErrorInfo);
			}
		}
		return $result;
	}
	
	//add new mimes for upload dummy content files (code can be removed after dummy content import)
	function tt_custom_upload_files($mimes) 
	{
		$mimes = array_merge($mimes, array('xml' => 'application/xml'), array('json' => 'application/json'));
		return $mimes;
	}
	add_filter('upload_mimes', 'tt_custom_upload_files');
	
	function tt_get_new_widget_name( $widget_name, $widget_index ) 
	{
		$current_sidebars = get_option( 'sidebars_widgets' );
		$all_widget_array = array( );
		foreach ( $current_sidebars as $sidebar => $widgets ) {
			if ( !empty( $widgets ) && is_array( $widgets ) && $sidebar != 'wp_inactive_widgets' ) {
				foreach ( $widgets as $widget ) {
					$all_widget_array[] = $widget;
				}
			}
		}
		while ( in_array( $widget_name . '-' . $widget_index, $all_widget_array ) ) {
			$widget_index++;
		}
		$new_widget_name = $widget_name . '-' . $widget_index;
		return $new_widget_name;
	}
	
	function tt_download_import_file($file)
	{
		$url = "http://quanticalabs.com/wp_plugins/timetable/files/2014/02/" . $file["name"] . "." . $file["extension"];
		$attachment = get_page_by_title($file["name"], "OBJECT", "attachment");
		
		if($attachment!=null)
			$id = $attachment->ID;
		else
		{
			$tmp = download_url($url);
			
			$file_array = array(
				'name' => basename($url),
				'tmp_name' => $tmp
			);

			// Check for download errors
			if(is_wp_error($tmp)) 
			{
				@unlink($file_array['tmp_name']);
				return $tmp;
			}

			$id = media_handle_sideload($file_array, 0);
			
			// Check for handle sideload errors.
			if(is_wp_error($id))
			{
				@unlink($file_array['tmp_name']);
				return $id;
			}
		}
		return get_attached_file($id);
	}
	
	function timetable_import_dummy()
	{
		$result = array("info" => "");
		//import dummy content
		$fetch_attachments = true;
		$file = tt_download_import_file(array(
			"name" => "dummy-timetable",
			"extension" => "xml"
		));
		
		if(is_wp_error($file))
		{
			$file = plugin_dir_path( __FILE__ ) . "dummy-content-files/dummy-timetable.xml";
		}
		if(!is_wp_error($file))
			require_once 'importer/importer.php';
		else
		{
			$result["info"] .= __("Import file: dummy-timetable.xml not found! Please upload import file manually into Media library. You can find this file inside zip archive downloaded from CodeCanyon.", 'timetable');
			exit();
		}
		//widget import
		$response = array(
			'what' => 'widget_import_export',
			'action' => 'import_submit'
		);

		$widgets = isset( $_POST['widgets'] ) ? $_POST['widgets'] : false;
		$json_file = tt_download_import_file(array(
			"name" => "widget_data",
			"extension" => "json"
		));
		if(is_wp_error($json_file))
		{
			$json_file = plugin_dir_path( __FILE__ ) . "dummy-content-files/widget_data.json";
		}
		$json_data = file_get_contents($json_file);
		if($json_data!=false)
		{
			$json_data = json_decode( $json_data, true );
			$sidebars_data = $json_data[0];
			$widget_data = $json_data[1];
			$current_sidebars = get_option( 'sidebars_widgets' );
			//remove inactive widgets
			$current_sidebars['wp_inactive_widgets'] = array();
			update_option('sidebars_widgets', $current_sidebars);
			$new_widgets = array( );
			foreach ( $sidebars_data as $import_sidebar => $import_widgets ) :

				foreach ( $import_widgets as $import_widget ) :
					//if the sidebar exists
					//if ( isset( $current_sidebars[$import_sidebar] ) ) :
						$title = trim( substr( $import_widget, 0, strrpos( $import_widget, '-' ) ) );
						$index = trim( substr( $import_widget, strrpos( $import_widget, '-' ) + 1 ) );
						$current_widget_data = get_option( 'widget_' . $title );
						$new_widget_name = tt_get_new_widget_name( $title, $index );
						$new_index = trim( substr( $new_widget_name, strrpos( $new_widget_name, '-' ) + 1 ) );

						if ( !empty( $new_widgets[ $title ] ) && is_array( $new_widgets[$title] ) ) {
							while ( array_key_exists( $new_index, $new_widgets[$title] ) ) {
								$new_index++;
							}
						}
						$current_sidebars[$import_sidebar][] = $title . '-' . $new_index;
						if ( array_key_exists( $title, $new_widgets ) ) {
							$new_widgets[$title][$new_index] = $widget_data[$title][$index];
							$multiwidget = $new_widgets[$title]['_multiwidget'];
							unset( $new_widgets[$title]['_multiwidget'] );
							$new_widgets[$title]['_multiwidget'] = $multiwidget;
						} else {
							$current_widget_data[$new_index] = $widget_data[$title][$index];
							$current_multiwidget = $current_widget_data['_multiwidget'];
							$new_multiwidget = $widget_data[$title]['_multiwidget'];
							$multiwidget = ($current_multiwidget != $new_multiwidget) ? $current_multiwidget : 1;
							unset( $current_widget_data['_multiwidget'] );
							$current_widget_data['_multiwidget'] = $multiwidget;
							$new_widgets[$title] = $current_widget_data;
						}

					//endif;
				endforeach;
			endforeach;
			if ( isset( $new_widgets ) && isset( $current_sidebars ) ) {
				update_option( 'sidebars_widgets', $current_sidebars );

				foreach ( $new_widgets as $title => $content )
					update_option( 'widget_' . $title, $content );

			}
		}
		else
		{
			$result["info"] .= __("Widgets data file not found! Please upload widgets data file manually.", 'timetable');
			exit();
		}
		//import sample hours
		global $wpdb;
		$query = "INSERT INTO `" . $wpdb->prefix . "event_hours` (`event_hours_id`, `event_id`, `weekday_id`, `start`, `end`, `tooltip`, `before_hour_text`, `after_hour_text`, `category`, `available_places`) VALUES
			(242, 2146, 1217, '11:00:00', '13:00:00', 'Reaction time training with sparring partners.', 'Boxing class', 'Robert Bandana', '', 0),
			(247, 15, 1214, '15:00:00', '15:45:00', '', 'High impact', 'Mark Moreau', '', 2),
			(238, 2148, 1217, '17:00:00', '18:30:00', '', 'Advanced', 'Kevin Nomak', '', 0),
			(222, 2148, 1218, '15:00:00', '16:00:00', '', 'Beginners', 'Kevin Nomak', '', 0),
			(223, 2148, 1213, '15:00:00', '16:00:00', '', 'Intermediate', 'Kevin Nomak', '', 1),
			(244, 2144, 1217, '15:00:00', '16:00:00', 'Basic exercises for kids.', 'Preschool class', 'Emma Brown', '', 0),
			(183, 15, 2132, '16:00:00', '17:00:00', '', 'Low impact', 'Mark Moreau', '', 0),
			(184, 15, 1213, '16:00:00', '17:00:00', '', 'High impact', 'Trevor Smith', '', 5),
			(199, 2139, 1216, '07:00:00', '09:00:00', 'Open entry to the fitness room with wide variety of equipment.', 'Open entry', 'Mark Moreau', '', 3),
			(185, 15, 1214, '16:00:00', '17:00:00', '', 'Low impact', 'Mark Moreau', '', 1),
			(228, 2142, 1218, '13:00:00', '15:00:00', '', 'Body works', 'Kevin Nomak', '', 0),
			(239, 2148, 2132, '15:00:00', '16:00:00', 'Advanced stamina workout.', 'Advanced', 'Kevin Nomak', '', 0),
			(205, 2139, 1213, '07:00:00', '11:00:00', 'Open entry to the fitness room with wide variety of equipment.', 'Open entry', 'Mark Moreau', '', 3),
			(163, 2146, 1216, '14:00:00', '15:00:00', '', 'Thai boxing', 'Robert Bandana', '', 3),
			(156, 2146, 1213, '11:00:00', '13:00:00', '', 'MMA beginners', 'Robert Bandana', '', 0),
			(243, 2144, 1216, '15:00:00', '16:00:00', 'Basic exercises for kids.', 'Preschool class', 'Emma Brown', '', 0),
			(162, 2146, 1215, '14:00:00', '15:00:00', '', 'Thai boxing', 'Robert Bandana', '', 0),
			(190, 2142, 1213, '18:00:00', '19:30:00', '', 'Weightlifting', 'Kevin Nomak', '', 8),
			(141, 2144, 1216, '17:00:00', '18:30:00', '', 'Fitness and fun', 'Emma Brown', '', 0),
			(139, 2144, 1214, '17:00:00', '18:30:00', '', 'Zumba dance', 'Emma Brown', '', 0),
			(144, 2144, 1217, '17:00:00', '18:30:00', '', 'Fitness and fun', 'Emma Brown', '', 0),
			(164, 2148, 1214, '07:00:00', '09:00:00', '', 'Weightlifting', 'Kevin Nomak', '', 0),
			(193, 2148, 1215, '17:00:00', '18:30:00', '', 'Beginners', 'Kevin Nomak', '', 6),
			(231, 15, 1217, '16:00:00', '17:00:00', '', 'High impact', 'Trevor Smith', '', 0),
			(152, 2146, 1213, '13:00:00', '14:00:00', '', 'MMA all levels', 'Robert Bandana', '', 3),
			(153, 2146, 1217, '13:00:00', '14:00:00', '', 'MMA all levels', 'Robert Bandana', '', 0),
			(157, 2146, 2132, '11:00:00', '13:00:00', '', 'Boxing class', 'Robert Bandana', '', 3),
			(214, 2148, 1217, '14:00:00', '15:00:00', '', 'Weightlifting', 'Kevin Nomak', '', 12),
			(204, 2139, 2132, '07:00:00', '11:00:00', 'Open entry to the fitness room with wide variety of equipment.', 'Open entry', 'Mark Moreau', '', 5),
			(189, 2142, 2132, '18:00:00', '19:30:00', '', 'Weightlifting', 'Kevin Nomak', '', 0),
			(175, 2144, 1215, '17:00:00', '18:30:00', '', 'Advanced', 'Emma Brown', '', 0),
			(229, 2139, 1218, '07:00:00', '11:00:00', 'Open entry to the fitness room with wide variety of equipment.', 'Open entry', 'Mark Moreau', '', 5),
			(221, 2139, 1215, '07:00:00', '12:00:00', 'Open entry to the fitness room with wide variety of equipment.', 'Open entry', 'Mark Moreau', '', 4),
			(227, 2142, 1218, '11:00:00', '13:00:00', '', 'Weightlifting', 'Kevin Nomak', '', 0),
			(232, 2144, 1213, '08:00:00', '09:00:00', '', 'Advanced', 'Emma Brown', '', 0),
			(191, 2142, 1215, '12:30:00', '14:00:00', '', 'Weightlifting', 'Kevin Nomak', '', 6),
			(192, 2142, 1216, '12:30:00', '14:00:00', '', 'Weightlifting', 'Kevin Nomak', '', 2),
			(207, 2144, 1214, '11:00:00', '13:00:00', '', 'Beginners', 'Emma Brown', '', 0),
			(210, 2144, 2132, '08:00:00', '09:00:00', '', 'Beginners', 'Emma Brown', '', 0),
			(246, 2148, 1214, '13:00:00', '15:00:00', '', 'Beginners', 'Kevin Nomak', '', 1),
			(230, 2146, 1218, '16:00:00', '17:00:00', '', 'Thai boxing', 'Robert Bandana', '', 0),
			(315, 2159, 2132, '11:00:00', '12:45:00', '', '', '<strong>Instructor:</strong> M. Moreau<br/>\r\n<strong>Room:</strong> 6<br/>\r\n<strong>Level:</strong> Beginner', '', 4),
			(329, 2164, 1214, '09:00:00', '10:30:00', 'Mixed Martial Arts training with Muay Thai and Thai Boxing.', '', '<strong>Instructor:</strong> R. Bandana<br/>\r\n<strong>Room:</strong> 24<br/>\r\n<strong>Level:</strong> Beginner', '', 10),
			(313, 2164, 2132, '09:00:00', '10:30:00', '', '', '<strong>Instructor:</strong> R. Bandana<br/>\r\n<strong>Room:</strong> 24<br/>\r\n<strong>Level:</strong> Beginner', '', 3),
			(331, 2177, 1215, '14:00:00', '17:00:00', 'Super stamina workout and weightlifting.', '', '<strong>Instructor:</strong> K. Nomak<br/>\r\n<strong>Room:</strong> 305A<br/>\r\n<strong>Level:</strong> All Levels', '', 5),
			(319, 2159, 1215, '11:00:00', '12:45:00', '', '', '<strong>Instructor:</strong> M. Moreau<br/>\r\n<strong>Room:</strong> 6<br/>\r\n<strong>Level:</strong> Beginner', '', 2),
			(493, 2244, 2229, '16:00:00', '18:22:00', '', 'Horror', 'Free Entry<br/>\r\n142 min.', '', 8),
			(330, 2159, 1214, '11:00:00', '14:00:00', '', '', '<strong>Instructor:</strong> M. Moreau<br/>\r\n<strong>Room:</strong> 6<br/>\r\n<strong>Level:</strong> Advanced', '', 0),
			(314, 2164, 1213, '11:00:00', '12:45:00', '', '', '<strong>Instructor:</strong> R. Bandana<br/>\r\n<strong>Room:</strong> 24<br/>\r\n<strong>Level:</strong> Intermediate', '', 0),
			(459, 2298, 2230, '12:30:00', '14:00:00', '', 'Catering', 'Free Entry<br/>\r\n90 min.', '', 10),
			(327, 2164, 1217, '09:00:00', '12:45:00', 'Mixed Martial Arts training with Muay Thai and Thai Boxing.', '', '<strong>Instructor:</strong> R. Bandana<br/>\r\n<strong>Room:</strong> 24<br/>\r\n<strong>Level:</strong> All Levels', '', 5),
			(473, 2243, 2227, '16:30:00', '17:56:00', '', 'Animation', 'Free Entry<br/>\r\n86 min.', '', 10),
			(323, 2177, 1217, '14:00:00', '18:00:00', '', '', '<strong>Instructor:</strong> K. Nomak<br/>\r\n<strong>Room:</strong> 305A<br/>\r\n<strong>Level:</strong> All Levels', '', 3),
			(325, 2164, 1215, '09:00:00', '10:30:00', '', '', '<strong>Instructor:</strong> R. Bandana<br/>\r\n<strong>Room:</strong> 24<br/>\r\n<strong>Level:</strong> Beginner', '', 2),
			(301, 2177, 1213, '13:00:00', '14:00:00', '', '', '<strong>Instructor:</strong> K. Nomak<br/>\r\n<strong>Room:</strong> 305A<br/>\r\n<strong>Level:</strong> All Levels', '', 4),
			(300, 2177, 2132, '13:00:00', '14:00:00', '', '', '<strong>Instructor:</strong> K. Nomak<br/>\r\n<strong>Room:</strong> 305A<br/>\r\n<strong>Level:</strong> All Levels', '', 3),
			(309, 2159, 2132, '15:00:00', '16:30:00', '', '', '<strong>Instructor:</strong> M. Moreau<br/>\r\n<strong>Room:</strong> 6<br/>\r\n<strong>Level:</strong> Advanced', '', 7),
			(332, 2191, 1213, '09:00:00', '09:45:00', '', '', 'Class Leader<br/>Ann Smith', '', 0),
			(333, 2191, 1214, '10:00:00', '10:45:00', '', '', 'Class Leader<br/>Emma White', '', 0),
			(324, 2159, 1217, '13:00:00', '14:00:00', '', '', '<strong>Instructor:</strong> M. Moreau<br/>\r\n<strong>Room:</strong> 6<br/>\r\n<strong>Level:</strong> All Levels', '', 3),
			(310, 2159, 1213, '15:00:00', '16:30:00', '', '', '<strong>Instructor:</strong> M. Moreau<br/>\r\n<strong>Room:</strong> 6<br/>\r\n<strong>Level:</strong> Advanced', '', 1),
			(417, 2242, 2229, '14:40:00', '16:30:00', '', 'Animation', 'G Rating<br/>\r\n110 min.', '', 0),
			(433, 2264, 2229, '16:30:00', '17:30:00', '', 'Free Snacks', 'Festival Pass', '', 0),
			(492, 2244, 2227, '14:00:00', '16:22:00', '', 'Horror', 'Free Entry<br/>\r\n142 min.', '', 20),
			(488, 2266, 2227, '09:00:00', '12:30:00', '', 'Concert', '$60 Entry<br/>\r\n210 min.<br/><br/>\r\nUnder 16\'s to be accompanied by an adult.', '', 0),
			(467, 2239, 2231, '14:00:00', '16:15:00', '', 'Adventure', '$10 Entry<br/>\r\n135 min.', '', 0),
			(560, 2353, 2343, '11:30:00', '12:45:00', '', '', 'Performance', '', 0),
			(434, 2264, 2231, '16:30:00', '17:30:00', '', 'Free Snacks', 'Festival Pass', '', 0),
			(466, 2236, 2230, '14:00:00', '16:10:00', '', 'Thriller', 'Free Entry<br/>\r\n130 min.', '', 10),
			(460, 2298, 2231, '12:30:00', '14:00:00', '', 'Catering', 'Free Entry<br/>\r\n90 min.', '', 10),
			(479, 2310, 2231, '16:30:00', '18:30:00', '', 'Thriller', '$20 Entry<br/>\r\n120 min.', '', 0),
			(474, 2238, 2231, '09:00:00', '10:45:00', '', 'Action', 'Free Entry<br/>\r\n105 min.', '', 10),
			(458, 2298, 2229, '12:30:00', '14:00:00', '', 'Catering', 'Free Entry<br/>\r\n90 min.', '', 15),
			(435, 2264, 2232, '16:30:00', '17:30:00', '', 'Free Snacks', 'Festival Pass', '', 0),
			(477, 2245, 2232, '16:30:00', '17:56:00', '', 'Horror', '$10 Entry<br/>\r\n86 min.', '', 0),
			(438, 2264, 2227, '16:30:00', '17:30:00', '', 'Free Snacks', 'Festival Pass', '', 0),
			(471, 2243, 2231, '11:00:00', '12:26:00', '', 'Animation', 'Free Entry<br/>\r\n86 min.', '', 10),
			(448, 2234, 2230, '11:00:00', '12:25:00', '', 'Animation', 'Free Entry<br/>\r\n85 min.', '', 10),
			(496, 2237, 2229, '18:30:00', '20:10:00', '', 'Action', 'Free Entry<br/>\r\n100 min.', '', 15),
			(461, 2298, 2227, '12:30:00', '14:00:00', '', 'Catering', 'Free Entry<br/>\r\n90 min.', '', 15),
			(490, 2235, 2230, '09:00:00', '10:42:00', '', 'Comedy', 'Free Entry<br/>\r\n102 min.', '', 20),
			(436, 2264, 2230, '16:30:00', '17:30:00', '', 'Free Snacks', 'Festival Pass', '', 0),
			(476, 2245, 2232, '11:00:00', '12:26:00', '', 'Horror', '$10 Entry<br/>\r\n86 min.', '', 0),
			(485, 2241, 2232, '12:30:00', '16:30:00', '', 'Concert', '$50 ticket<br/>\r\n240 min.<br/><br/>\r\nWith special guest Kevin Numan and Markus Smith.', '', 0),
			(491, 2235, 2229, '14:00:00', '15:42:00', '', 'Comedy', 'Free Entry<br/>\r\n102 min.', '', 20),
			(486, 2240, 2229, '09:00:00', '12:10:00', '', 'Concert', '$50 ticket<br/>\r\n190 min.<br/><br/>\r\nWith special guest Kevin Numan and Markus Smith.', '', 30),
			(489, 2266, 2230, '16:30:00', '20:00:00', '', 'Concert', '$60 Entry<br/>\r\n210 min.<br/><br/>\r\nUnder 16\'s to be accompanied by an adult.', '', 0),
			(495, 2237, 2232, '09:00:00', '10:40:00', '', 'Action', 'Free Entry<br/>\r\n100 min.', '', 15),
			(573, 2365, 2342, '09:00:00', '12:00:00', '', '', 'Registration and General Information', '', 0),
			(561, 2350, 2343, '12:45:00', '14:00:00', '', '', 'Performance', '', 0),
			(581, 2375, 2342, '16:30:00', '19:00:00', '', '', 'Conference Banquet With Closing Ceremony. John Williams Speech.', '', 0),
			(570, 2351, 2343, '15:30:00', '16:45:00', '', '', 'Performance', '', 0),
			(519, 2359, 2346, '12:00:00', '13:15:00', '', '', 'Screening', '', 0),
			(536, 2367, 2344, '12:00:00', '15:00:00', '', '', 'Display', '', 0),
			(537, 2366, 2344, '15:00:00', '17:30:00', '', '', 'Display', '', 0),
			(526, 2362, 2346, '10:00:00', '12:00:00', '', '', 'Screening', '', 0),
			(558, 2355, 2343, '09:00:00', '10:15:00', '', '', 'Performance', '', 0),
			(520, 2361, 2346, '13:15:00', '14:40:00', '', '', 'Screening', '', 0),
			(554, 2357, 2345, '13:30:00', '14:15:00', '', '', 'Panel with Josh Kowalsky', '', 0),
			(535, 2368, 2344, '09:00:00', '12:00:00', '', '', 'Display', '', 0),
			(556, 2374, 2342, '08:30:00', '09:00:00', '', '', '', '', 0),
			(564, 2363, 2345, '09:00:00', '10:15:00', '', '', 'Panel with Ann Perkins', '', 0),
			(572, 2352, 2346, '15:30:00', '17:15:00', '', '', 'Performance', '', 0),
			(566, 2358, 2345, '11:30:00', '13:30:00', '', '', 'Panel with Robin Watson, Chris Prochaska and Shawn Georges', '', 0),
			(562, 2364, 2347, '09:00:00', '12:30:00', '', '', 'Free Entry', '', 0),
			(551, 2373, 2347, '12:30:00', '16:30:00', '', '', 'Luch Menu', '', 0),
			(567, 2356, 2345, '14:15:00', '16:15:00', '', '', 'Panel with Helena Howington, Frank Kasper and John Williams ', '', 0),
			(559, 2354, 2343, '10:15:00', '11:30:00', '', '', 'Performance', '', 0),
			(565, 2360, 2345, '10:15:00', '11:30:00', '', '', 'Panel with Robin Landrum', '', 0),
			(576, 2365, 2342, '13:30:00', '15:00:00', '', '', 'Registration and General Information', '', 0),
			(588, 2367, 2344, '14:30:00', '15:00:00', '', 'Comments', 'Comments on Display Session', '', 0),
			(589, 2366, 2344, '17:00:00', '17:30:00', '', 'Comments', 'Comments on Display Session', '', 0),
			(587, 2368, 2344, '11:30:00', '12:00:00', '', 'Comments', 'Comments on Display Session', '', 0);";
		$wpdb->query($query);
		
		//insert shortcodes from live preview
		$timetable_shortcodes_live_preview = array(
			"timetable-for-wordpress" => "[tt_timetable event='body-building,boxing,cardio-fitness,crossfit,open-gym,zumba' columns='sunday,monday,tuesday,wednesday,thursday,friday,saturday' time_format='g:i a' export_to_pdf_button='1' show_booking_button='always' show_available_slots='always' event_description_responsive='description-1-and-description-2']",
			"timetable-for-wordpress-sample-2" => "[tt_timetable event='banquet,big-data-symposium,case-studies-in-rcts,charles-choice,crisis-archives,donna-wright,elizabeth-wallace,food-and-drinks,general-information,world-economy,gold-standard-overview,impact-investing,janice-watson,lunch-menu,market-overview-symposium,money-as-debt,nola-sollars,robert-duncan,smart-investment,taxes-from-prices,welcome-reception,who-leads-world-economic-rebound' event_category='bar,display,panel,performance,registration,screening' columns='reception,floor-2,lounge-bar,floor-4,speakers-room,campus-green' measure='0.25' filter_kind='event_and_event_category' filter_label_2='All Locations' time_format='H:i' box_bg_color='96235B' filter_color='353C40' disable_event_url='1' custom_css='.tt_timetable .event .event_header {font-size:16px;font-weight:normal;}' export_to_pdf_button='1' colors_responsive_mode='1' generate_pdf_bg_color='353C40' generate_pdf_hover_bg_color='FF9935']",
			"timetable-for-wordpress-sample-3" => "[tt_timetable event='power-fitness,martial-arts,body-works' columns='monday,tuesday,wednesday,thursday,saturday' filter_style='tabs' time_format='g.i a' hide_hours_column='1' event_layout='3' box_bg_color='2B363D' box_hover_bg_color='A13230' filter_color='D74340' hide_empty='1' text_align='left' show_booking_button='on_hover' show_available_slots='always']",
			"timetable-for-wordpress-sample-4" => "[tt_timetable event_category='action,animation,catering,comedy,concert,horror,thriller' columns='bay-plaza-cinema,lakewood-cinema,north-park-theatre,old-capitol-arts,music-hall' measure='0.5' filter_kind='event_category' time_format='H:i' hide_hours_column='1' show_end_hour='1' event_layout='4' box_bg_color='DF4432' box_hover_bg_color='DF4432' filter_color='DF4432' disable_event_url='1' row_height='40' font='Open Sans:regular' font_subset='latin-ext' custom_css='.tt_timetable .hours {font-weight:400;font-size:24px;}' booking_label='Buy Ticket' booking_popup_label='Buy Ticket' show_booking_button='always' unavailable_label='Tickets Sold' booking_popup_message='<h2>You are about to book event</h2><div class=\"event_details_wrapper\"><p class=\"event_details bold\">{event_title}</p><p class=\"event_details\">{column_title}</p><p class=\"event_details\">{event_start} - {event_end}</p><p class=\"event_details\">{event_description_2}</p></div>{booking_form}<p>An initial receipt will be sent out automatically unless you decide not to do so below.</p><div class=\"tt_btn_wrapper\">{tt_btn_book}{tt_btn_cancel}</div>' booking_bg_color='61a22d' unavailable_text_color='999999' unavailable_bg_color='f0f0f0']",
			"timetable-for-wordpress-sample-5" => "[tt_timetable event='body-building,boxing,cardio-fitness,crossfit,open-gym,zumba' columns='monday,tuesday,wednesday,thursday,friday,saturday,sunday' show_end_hour='1' event_layout='3' generate_pdf_bg_color='496EBB' generate_pdf_hover_bg_color='42B3E5' box_bg_color='3156A3' box_hover_bg_color='42B3E5' box_hours_txt_color='A6C3FF' filter_color='3156A3' disable_event_url='1' text_align='left' export_to_pdf_button='1']",
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
		
		if($result["info"]=="")
			$result["info"] = __("dummy-timetable.xml file content and widgets settings has been imported successfully!", 'timetable');
		echo "dummy_import_start" . json_encode($result) . "dummy_import_end";
		exit();
	}
	add_action('wp_ajax_timetable_import_dummy', 'timetable_import_dummy');
	
	function timetable_ajax_events_settings_save()
	{
		$timetable_events_settings = get_option("timetable_events_settings");
		$slug_old = $timetable_events_settings["slug"];
		$timetable_slug_old = $timetable_events_settings["slug"];
		$timetable_events_settings["slug"] = (!empty($_POST["events_slug"]) ? sanitize_title($_POST["events_slug"]) : __("events", "timetable"));
		$timetable_events_settings["label_singular"] = (!empty($_POST["events_label_singular"]) ? $_POST["events_label_singular"] : __("Event", "timetable"));
		$timetable_events_settings["label_plural"] = (!empty($_POST["events_label_plural"]) ? $_POST["events_label_plural"] : __("Events", "timetable"));
		if(update_option("timetable_events_settings", $timetable_events_settings) && $timetable_slug_old!=$_POST["events_slug"])
		{
			require_once("post-type-events.php");
			$events = get_posts(array(
				'post_type' => $slug_old,
				'posts_per_page' => -1
			));
			foreach($events as $event)
				set_post_type($event->ID, $timetable_events_settings["slug"]);
			//delete rewrite rules, they will be regenerated automatically by WP on next request
			delete_option('rewrite_rules');
		}
		exit();
	}
	add_action('wp_ajax_timetable_ajax_events_settings_save', 'timetable_ajax_events_settings_save');
	
	function timetable_admin_page()
	{
		$timetable_events_settings = timetable_events_settings();
		
		//get events list
		$events_list = get_posts(array(
			'posts_per_page' => -1,
			'nopaging' => true,
			'orderby' => 'title',
			'order' => 'ASC',
			'post_type' => $timetable_events_settings['slug']
		));
		
		//get weekdays list
		$weekdays_list = get_posts(array(
			'posts_per_page' => -1,
			'nopaging' => true,
			'orderby' => 'menu_order',
			'order' => 'ASC',
			'post_type' => 'timetable_weekdays'
		));
		
		//get all hour categories
		global $wpdb;
		$query = "SELECT distinct(category) AS category FROM " . $wpdb->prefix . "event_hours AS t1
				LEFT JOIN {$wpdb->posts} AS t2 ON t1.event_id=t2.ID 
				WHERE 
				t2.post_type='" . $timetable_events_settings['slug'] . "'
				AND t2.post_status='publish'
				AND category<>''
				ORDER BY category ASC";
		$hour_categories = $wpdb->get_results($query);
		//events string
		$events_string = "";
		$events_select_list = "";
		foreach($events_list as $event)
		{
			$events_select_list .= '<option value="' . urldecode($event->post_name) . '">' . $event->post_title . ' (id: ' . $event->ID . ')' . '</option>';
			$events_string .= $event->post_name . (end($events_list)!=$event ? "," : "");
		}
		//events categories string
		$events_categories_list = "";
		$events_categories = get_terms(array(
			"taxonomy" => "events_category",
			"orderby" => "name",
			"order" => "ASC",
		));
		foreach($events_categories as $events_category)
			$events_categories_list .= '<option value="' . urldecode(esc_attr($events_category->slug)) . '">' . $events_category->name . '</option>';
		//weekdays string
		$weekdays_string = "";
		$weekdays_select_list = "";
		foreach($weekdays_list as $weekday)
		{
			$weekdays_select_list .= '<option value="' . urldecode($weekday->post_name) . '">' . $weekday->post_title . ' (id: ' . $weekday->ID . ')' . '</option>';
			$weekdays_string .= $weekday->post_name . (end($weekdays_list)!=$weekday ? "," : "");
		}
		//get google fonts
		$fontsArray = timetable_get_google_fonts();		
		$fontsHtml = "";
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
						$fontsHtml .= '<option value="' . $fontsArray->items[$i]->family . ":" . $fontsArray->items[$i]->variants[$j] . '">' . $fontsArray->items[$i]->family . ":" . $fontsArray->items[$i]->variants[$j] . '</option>';
					}
				}
				else
				{
					$fontsHtml .= '<option value="' . $fontsArray->items[$i]->family . '">' . $fontsArray->items[$i]->family . '</option>';
				}
			}
		}
		require(__DIR__ . "/admin-page.php");
	}
	
	function timetable_admin_page_email_config()
	{
		if(isset($_POST["action"]) && $_POST["action"]=="save")
		{
			$timetable_contact_form_options = array(
				"email_subject_client" => $_POST["email_subject_client"],
				"email_subject_admin" => $_POST["email_subject_admin"],
				"admin_name" => $_POST["admin_name"],
				"admin_email" => $_POST["admin_email"],
				"mail_debug" => $_POST["mail_debug"],
				"template_client" => $_POST["template_client"],
				"template_admin" => $_POST["template_admin"],
				"smtp_host" => $_POST["smtp_host"],
				"smtp_username" => $_POST["smtp_username"],
				"smtp_password" => $_POST["smtp_password"],
				"smtp_port" => $_POST["smtp_port"],
				"smtp_secure" => $_POST["smtp_secure"]
			);
			update_option("timetable_contact_form_options", $timetable_contact_form_options);
		}
		$timetable_contact_form_options = timetable_stripslashes_deep(get_option("timetable_contact_form_options"));
		require(__DIR__ . "/admin-page-email-config.php");
	}
	
	function timetable_admin_page_event_post_type()
	{
		$timetable_events_settings = timetable_events_settings();
		require(__DIR__ . "/admin-page-event-post-type.php");
	}
	
	function timetable_admin_page_import_dummy_data()
	{
		require(__DIR__ . "/admin-page-import-dummy-data.php");
	}
	
	function timetable_admin_page_google_calendar()
	{
		require_once(__DIR__ . '/class/google-calendar.class.php');
		$googleCalendar = new TT_Google_Calendar();
		
		if(isset($_POST["action"]) && $_POST["action"]=="save")
		{
			$googleCalendar->id = filter_input(INPUT_POST, 'calendar_id');
			$googleCalendar->service_account_encoded = filter_input(INPUT_POST, 'service_account_encoded');
			$googleCalendar->SaveOptions();
		}
		
		if(isset($_POST["action"]) && $_POST["action"]=="export")
		{
			$event = (isset($_POST['event']) ? $_POST['event'] : array());
			$weekday = (isset($_POST['weekday']) ? $_POST['weekday'] : array());
			$eventsHours = TT_Event_Hour::Fetch(array(
				'event' => $event,
				'weekday' => $weekday,
			));
			$exportResult = $googleCalendar->ExportEvents($eventsHours, $weekday);
		}
		
		if(isset($_POST["action"]) && $_POST["action"]=="get_calendar_data")
		{
			$importResult = $googleCalendar->LoadEventsData();
		}
		
		if(isset($_POST["action"]) && $_POST["action"]=="import")
		{
			$weekday = (isset($_POST['weekday']) ? $_POST['weekday'] : array());
			$calendar_event = (isset($_POST['calendar_event']) ? $_POST['calendar_event'] : array());
			$importResult = $googleCalendar->ImportEvents($calendar_event, $weekday);
		}
		
		$Events = TT_Event::Fetch();
		$Weekdays = TT_Weekday::Fetch();
		$UniqueCalendarEvents = $googleCalendar->UniqueCalendarEvents();

		require(__DIR__ . "/admin-page-google-calendar.php");
	}
}

function timetable_ajax_timetable_save_shortcode()
{	
	$shortcode = (!empty($_POST["timetable_shortcode"]) ? stripslashes($_POST["timetable_shortcode"]) : "");
	$shortcode_id = (!empty($_POST["timetable_shortcode_id"]) ? $_POST["timetable_shortcode_id"] : "");
	
	if($shortcode_id!=="" && $shortcode!=="")
	{
		$timetable_shortcodes_list = get_option("timetable_shortcodes_list");
		if($timetable_shortcodes_list===false)
			$timetable_shortcodes_list = array();
		$timetable_shortcodes_list[$shortcode_id] = $shortcode;
		ksort($timetable_shortcodes_list);
		if(update_option("timetable_shortcodes_list", $timetable_shortcodes_list))
			echo "timetable_start" . $shortcode_id . "timetable_end";
		else
			echo 0;		
	}
	exit();
}
add_action('wp_ajax_timetable_save_shortcode', 'timetable_ajax_timetable_save_shortcode');

function timetable_ajax_timetable_delete_shortcode()
{
	if(!empty($_POST["timetable_shortcode_id"]))
	{
		$shortcode_id = $_POST["timetable_shortcode_id"];
		$timetable_shortcodes_list = get_option("timetable_shortcodes_list");
		if($timetable_shortcodes_list!==false && !empty($timetable_shortcodes_list[$shortcode_id]))
		{
			unset($timetable_shortcodes_list[$shortcode_id]);
			if(update_option("timetable_shortcodes_list", $timetable_shortcodes_list))
			{
				echo 1;
				exit();
			}
		}
	}
	echo 0;
	exit();
}
add_action('wp_ajax_timetable_delete_shortcode', 'timetable_ajax_timetable_delete_shortcode');

function timetable_ajax_timetable_get_shortcode()
{
	if(!empty($_POST["timetable_shortcode_id"]))
	{
		$shortcode_id = $_POST["timetable_shortcode_id"];
		$timetable_shortcodes_list = get_option("timetable_shortcodes_list");
		if($timetable_shortcodes_list!==false && !empty($timetable_shortcodes_list[$shortcode_id]))
		{
			echo "timetable_start" . html_entity_decode($timetable_shortcodes_list[$shortcode_id]) . "timetable_end";
			exit();
		}
	}
	echo 0;
	exit();
}
add_action('wp_ajax_timetable_get_shortcode', 'timetable_ajax_timetable_get_shortcode');

function tt_slots_number($slots_number_config)
{	
	$output = '';
	if($slots_number_config['slots_per_user']>1 && $slots_number_config['remaining_places']>1)
	{
		$max_slosts = ($slots_number_config['remaining_places']<=$slots_number_config['slots_per_user'] ? $slots_number_config['remaining_places'] : $slots_number_config['slots_per_user']);
		$output .= 
		'<p>
			<label>' . __('Slots number', 'timetable') . '</label>
			<select class="tt_slots_number" name="slots_number">';
		for($i=1; $i<=$max_slosts; $i++)
		{
			$output .= 
				'<option value="' . $i . '">' . $i . '</option>';
		}
		$output .= 
			'</select>
		</p>';
	}
	return $output;
}

function tt_booking_form($args)
{
	$output = '';
	$max_slots = 0;
	$remaining_slots = $args['slots_per_user']-$args['current_user_booking_count'];
	if($remaining_slots>1 && $args['remaining_places']>1)
	{
		$max_slots = ($args['remaining_places']<=$remaining_slots ? $args['remaining_places'] : $remaining_slots);
	}
	
	if($args['allow_user_booking']=='yes')
	{
    	//CREATE USER FORM
    	
	    $formHidden = false;
	    if($max_slots==0)
	        $formHidden = true;
	    if($args['default_booking_view']!='user' && !is_user_logged_in())
	       $formHidden = true;
	    
    	$output .=
    	'<form class="tt_booking_form user ' . ($formHidden ? 'tt_hide' : '') . '">';
    	
    	//slots field
    	if($max_slots>1)
    	{
    	    $output .=
    	    '<div class="tt_field_wrapper " data-max-slots="' . $max_slots . '">
    			<label for="tt_slots_number">' . __('Slots number', 'timetable') . '</label>
    			<div class="tt_slots_number_wrapper">
    				<input id="tt_slots_number" class="tt_field tt_slots_number" name="slots_number" type="number" min="1" max="' . $max_slots . '" step="1" value="1" autocomplete="off"/>
    				<input type="button" class="tt_slots_number_plus" value="+">
    				<input type="button" class="tt_slots_number_minus" value="-">
    			</div>
    		</div>';
    	}
    	
    	$output .=
    	'</form>';
	}
	
	if($args['allow_guest_booking']=='yes')
	{
    	//CREATE GUEST FORM
    	
	    $formHidden = false;
	    if($args['default_booking_view']!='guest')
	        $formHidden = true;
	    elseif($args['allow_user_booking']=='yes' && is_user_logged_in())
	        $formHidden = true;
        
    	$output .= 
    	'<form class="tt_booking_form guest ' . ($formHidden ? 'tt_hide' : '') . '">';
    	
    	//name field
    	if($args['show_guest_name_field']=='yes')
    	{
    		$placeholder = ($args['guest_name_field_required']=='yes' ? __('Name *', 'timetable') : __('Name', 'timetable'));
    		$output .= 
    		'<div class="tt_field_wrapper ">
    			<label for="tt_guest_name">' . $placeholder . '</label>
    			<input id="tt_guest_name" class="tt_field tt_guest_name" name="name" type="text"  value="" autocomplete="off"/>
    		</div>';
    	}
    	
    	//email field(required)
    	$placeholder = __('Email *', 'timetable');
    	$output .= 
    	'<div class="tt_field_wrapper ">
    		<label for="tt_guest_email">' . $placeholder . '</label>
    		<input id="tt_guest_email" class="tt_field tt_guest_email" name="email" type="email"  value="" autocomplete="off"/>
    	</div>';
    	
    	//phone field
    	if($args['show_guest_phone_field']=='yes')
    	{
    		$placeholder = ($args['guest_phone_field_required']=='yes' ? __('Phone *', 'timetable') : __('Phone', 'timetable'));
    		$output .= 
    		'<div class="tt_field_wrapper ">
    			<label for="tt_guest_phone">' . $placeholder . '</label>
    			<input id="tt_guest_phone" class="tt_field tt_guest_phone" name="phone" type="text"  value="" autocomplete="off"/>
    		</div>';
    	}
    	
    	//slots field
    	if($max_slots>1)
    	{
    		$output .= 
    		'<div class="tt_field_wrapper" data-max-slots="'.$max_slots.'">
    			<label for="tt_slots_number">' . __('Slots number', 'timetable') . '</label>
    			<div class="tt_slots_number_wrapper">
    				<input id="tt_slots_number" class="tt_field tt_slots_number" name="slots_number" type="number" min="1" max="' . $max_slots . '" step="1" value="1" autocomplete="off"/>
    				<input type="button" class="tt_slots_number_plus" value="+">
    				<input type="button" class="tt_slots_number_minus" value="-">
    			</div>
    		</div>';
    	}
    	
    	//message field
    	if($args['show_guest_message_field']=='yes')
    	{
    		$placeholder = ($args['guest_message_field_required']=='yes' ? __('Message *', 'timetable') : __('Message', 'timetable'));
    		$output .= 
    		'<div class="tt_field_wrapper wide ">
    			<label for="tt_guest_message">' . $placeholder . '</label>
    			<textarea id="tt_guest_message" class="tt_field tt_guest_message" name="message" autocomplete="off"></textarea>
    		</div>';
    	}
    
    	//terms checkbox field
    	if($args['terms_checkbox']=='yes')
    	{
    		$output .= 
    		'<div class="tt_field_wrapper wide terms_checkbox_wrapper ">
    			<input id="tt_terms_checkbox" class="tt_field tt_terms_checkbox" name="terms_checkbox" type="checkbox" value="1" autocomplete="off"/>
    			<label for="tt_terms_checkbox">' . $args['terms_message'] . '</label>
    		</div>';
    	}
    	
    	$output .= 
    	'</form>';
	}
	
	return $output;
}

function tt_btn_book($args)
{
	$args = shortcode_atts(array(
		'booking_label' => '',
		'login_label' => '',
		'redirect_url' => '',
		'allow_user_booking' => '',
	    'allow_guest_booking' => '',
	    'default_booking_view' => '',
	), $args);
	
	$bookingHidden = false;
	if(!is_user_logged_in() && 
        $args['default_booking_view']=='user' && 
	    $args['allow_user_booking']=='yes')
	{
	    $bookingHidden = true;
	}
	
	$loginHidden = false;
    if(is_user_logged_in())
        $loginHidden = true;
    if($args['allow_user_booking']=='no')
        $loginHidden = true;
    if($args['default_booking_view']=='guest')
        $loginHidden = true;
    
	$output = '';
	$output .= '<a href="#" class="tt_btn book ' . ($bookingHidden ? 'tt_hide' : '') . '">' . $args['booking_label'] . '</a>';
	$output .= '<a href="' . wp_login_url($args['redirect_url']) . '" class="tt_btn login ' . ($loginHidden ? 'tt_hide' : '') . '">' . $args['login_label'] . '</a>';
	
	return $output;
}

function tt_btn_continue($continue_label)
{
	$output = '';
	$output .= "<a href='#' class='tt_btn continue'>" . $continue_label . "</a>";
	return $output;
}

function tt_btn_cancel($cancel_label)
{
	$output = '';
	$output .= "<a href='#' class='tt_btn cancel'>" . $cancel_label . "</a>";
	return $output;
}

/**
 * Returns array of Google Fonts
 * @return array of Google Fonts
 */
function timetable_get_google_fonts()
{
	//get google fonts
	$fontsArray = get_option("timetable_google_fonts");
	//update if option doesn't exist or it was modified more than 2 weeks ago
	if($fontsArray===FALSE || count((array)$fontsArray)==0 || (time()-$fontsArray->last_update>2*7*24*60*60)) {
		$google_api_url = 'http://quanticalabs.com/.tools/GoogleFont/font.txt';
		$fontsJson = wp_remote_retrieve_body(wp_remote_get($google_api_url, array('sslverify' => false )));
		$fontsArray = json_decode($fontsJson);
		$fontsArray->last_update = time();		
		update_option("timetable_google_fonts", $fontsArray);
	}
	return $fontsArray;
}

function timetable_random_string($length=12)
{
	$code = '';
	$chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$chars_length = strlen($chars);
	for($i=0; $i<$length; $i++)
		$code .= $chars[mt_rand(0,$chars_length-1)];
	return $code;
}

function timetable_stripslashes_deep($value)
{
	$value = is_array($value) ?
				array_map('stripslashes_deep', $value) :
				stripslashes($value);
	
	return $value;
}

function tiny_mce_on_change($settings)
{
	if(array_key_exists('selector', $settings) && in_array($settings['selector'], array('#booking_popup_message', '#booking_popup_thank_you_message')))
	{
		$settings['setup'] = 'function(ed){
			ed.on("keyup change", function(){
				generateShortcode();				
			});
		}';
	}
	return $settings;
}
add_filter('tiny_mce_before_init', 'tiny_mce_on_change');

function tt_generate_pdf()
{
	if(!($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tt_action']) && $_POST['tt_action']=='tt_generate_pdf'))
		return;
	
	require_once(__DIR__ . '/libraries/dompdf/autoload.inc.php');
	$pdf_font = filter_input(INPUT_POST, 'tt_pdf_font');
	$tt_pdf_html_content=(isset($_POST['tt_pdf_html_content']) ? stripslashes($_POST['tt_pdf_html_content']) : '');
	$timetable_html = require(__DIR__ . '/pdf-template.php');
	
	$options = new Dompdf\Options();
	$options->set('defaultFont', 'Lato');
	$dompdf = new Dompdf\Dompdf($options);
	$dompdf->loadHtml($timetable_html);
	$dompdf->setPaper('A4', 'portrait');
	$dompdf->render();
	$dompdf->stream("timetable.pdf");
	exit();
}
add_action('wp_loaded','tt_generate_pdf');
?>