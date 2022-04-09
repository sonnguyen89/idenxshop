<?php
class TT_Bookings_List extends WP_List_Table
{
	public function __construct()
	{
		parent::__construct(array(
			'singular' => __('Booking', 'timetable'),
			'plural'   => __('Bookings', 'timetable'),
			'ajax'     => false,
		));
		
		if(isset($_REQUEST['deleted']) && $_REQUEST['deleted'])
		{
			add_action('admin_notices', array($this, 'booking_deleted_notice'));
		}	
	}
	
	/**
	* Retrieve bookings data from the database
	*
	* @param int $per_page
	* @param int $page_number
	*
	* @return mixed
	*/
	public static function get_bookings($per_page=5, $page_number=1)
	{
		$args = array(
			'per_page' => $per_page,
			'page_number' => $page_number,
		);
		
		if(isset($_REQUEST['order']))
			$args['order'] = $_REQUEST['order'];
		if(isset($_REQUEST['orderby']))
			$args['orderby'] = $_REQUEST['orderby'];
		
		$bookings = TT_DB::getBookings($args);
		return $bookings;
	}
	
	/**
	* Delete a booking record.
	*
	* @param int $id booking ID
	*/
	public static function delete_booking($id)
	{
		TT_DB::deleteBooking($id);
	}
	
	public function booking_deleted_notice()
	{
		$output = '';
		$output .= 
			'<div class="notice notice-success is-dismissible">
				<p>' . __('Booking deleted.', 'timetable') . '</p>
			</div>';
		echo $output;
	}
	
	/**
	* Returns the count of records in the database.
	*
	* @return null|string
	*/
	public static function record_count()
	{
		global $wpdb;
		$query = 'SELECT COUNT(*) FROM ' . $wpdb->prefix . 'event_hours_booking';
		return $wpdb->get_var( $query );
	}
   
	/** Text displayed when no booking data is available */
	public function no_items()
	{
		_e('No bookings avaliable.', 'timetable');
	}
	
	/**
	* Method for name column
	*
	* @param array $item an array of DB data
	*
	* @return string
	*/
	function column_booking($item)
	{
		$delete_nonce = wp_create_nonce('sp_delete_booking');
		$title = '<strong>' . sprintf(__('Booking #%d (%s)', 'timetable'), $item['booking_id'], $item['booking_datetime']) . '</strong>';
		$actions = array(
			'delete' => sprintf('<a href="?page=%s&action=%s&booking=%s&_wpnonce=%s">Delete</a>', esc_attr($_REQUEST['page']), 'delete', absint($item['booking_id']), $delete_nonce),
		);
		return $title . $this->row_actions($actions);
   }
   
   /**
	* Render a column when no column specific method exists.
	*
	* @param array $item
	* @param string $column_name
	*
	* @return mixed
	*/
	public function column_default($item, $column_name)
	{
		switch($column_name)
		{
			case 'booking':
				return sprintf(__('Booking #%d (%s)', 'timetable'), $item['bookign_id'], $item['booking_datetime']);
			case 'date':
				return $item['weekday'] . '<br>' . $item['start'] . '-' . $item['end'];
			case 'event':
				return '<a href="' . get_edit_post_link($item['event_id']) . '">' . $item['event_title'] . '</a>';
			case 'user':
				if($item['user_id'])
				{
					return '<a href="' . get_edit_user_link($item['user_id']) . '">' . $item['user_name'] . '</a>';
				}
				else
				{
					$guest_info = array();
					$guest_info[] = '<a href="mailto:' . $item['guest_email'] . '">' . $item['guest_email'] . '</a>';
					if($item['guest_name']!='')
						$guest_info[] = $item['guest_name'];
					if($item['guest_phone']!='')
						$guest_info[] = $item['guest_phone'];
					$guest_info = implode(', ', $guest_info);
					
					return sprintf(__('Guest (%s)', 'timetable'), $guest_info);
				}
			case 'message':
				return nl2br($item['guest_message']);
			default:
				return print_r($item, true); //Show the whole array for troubleshooting purposes
		}
	}
	
	/**
	* Render the bulk edit checkbox
	*
	* @param array $item
	*
	* @return string
	*/
	function column_cb($item)
	{
		return sprintf(
			'<input type="checkbox" name="bulk-delete[]" value="%s" />', $item['booking_id']
		);
	}
	
	/**
	*  Associative array of columns
	*
	* @return array
	*/
	function get_columns()
	{
		$columns = array(
			'cb' => '<input type="checkbox" />',
			'booking' => __('Booking', 'timetable'),
			'date' => __('Date', 'timetable'),
			'event' => __('Event', 'timetable'),
			'user' => __('User', 'timetable'),
			'message' => __('Message', 'timetable'),
		);
		
		return $columns;
	}

	/**
	* Columns to make sortable.
	*
	* @return array
	*/
	public function get_sortable_columns()
	{
		$sortable_columns = array(
			'booking' => array('booking', true),
			'date' => array('date', true),
			'event' => array('event', true),
			'user' => array('user', true),
		);
		return $sortable_columns;
	}

	/**
	* Returns an associative array containing the bulk action
	*
	* @return array
	*/
	public function get_bulk_actions()
	{
		$actions = array(
			'bulk-delete' => 'Delete',
		);
		return $actions;
	}
	
	/**
	* Handles data query and filter, sorting, and pagination.
	*/
	public function prepare_items()
	{
		$this->_column_headers = $this->get_column_info();

		$per_page     = $this->get_items_per_page('bookings_per_page', 20);
		$current_page = $this->get_pagenum();
		$total_items  = self::record_count();

		$this->set_pagination_args(array(
		  'total_items' => $total_items,
		  'per_page'    => $per_page,
		));
		$this->items = self::get_bookings($per_page, $current_page);
	}

	public function  process_bulk_action()
	{
		if('delete'===$this->current_action())
		{
			$nonce = esc_attr($_REQUEST['_wpnonce']);
			if(!wp_verify_nonce($nonce, 'sp_delete_booking'))
			{
				die(__('You\'re not allowed to perform this action.','timetable'));
			}
			else
			{
				self::delete_booking(absint($_GET['booking']));
				$redirectUrl = add_query_arg(array(
					'page' => 'timetable_admin_bookings',
					'deleted' => 1,
				), get_admin_url(get_current_blog_id(), 'admin.php'));
				wp_redirect($redirectUrl);
				exit;
			}
		}

		// If the delete bulk action is triggered
		if((isset($_POST['action']) && $_POST['action']=='bulk-delete')
			 || (isset($_POST['action2']) && $_POST['action2'] == 'bulk-delete'))
		{
			$delete_ids = esc_sql($_POST['bulk-delete']);

			foreach($delete_ids as $id)
			{
				self::delete_booking($id);
			}

			$redirectUrl = add_query_arg(array(
				'page' => 'timetable_admin_bookings',
				'deleted' => 1,
			), get_admin_url(get_current_blog_id(), 'admin.php'));
			wp_redirect($redirectUrl);
			exit;
		}
	}

}
