<?php
/**
 * Class Post Type Configuration file
 */

// Set global var
global $gymx_ext_class_config;

// The class
class GymX_Ext_Class_Config {
	private $label;

	public function __construct() {

		// Update vars
		$this->label = get_theme_mod( 'class_labels' );
		$this->label = $this->label ? $this->label : esc_html_x( 'Classes', 'Class Post Type Label', 'ttbase-framework' );


		// Adds the class post type
		add_action( 'init', array( $this, 'gymx_ext_register_post_type' ), 0 );

		// Adds the class taxonomies
		add_action( 'init', array( $this, 'gymx_ext_register_tags' ), 5 );
		add_action( 'init', array( $this, 'gymx_ext_register_categories' ), 10 );
		
		//Add custom db table
		add_action( 'init', array( $this, 'gymx_ext_add_custom_db_table' ), 15 );
		
		//Add custom metaboxes
		add_action("add_meta_boxes", array( $this, 'gymx_add_classes_custom_box' ) );
		
		//Save post data
		add_action("save_post", array( $this, 'gymx_save_classes_postdata' ) );
		
		//Get class hour details
		add_action( 'wp_ajax_get_class_hour_details', array( $this, 'gymx_ext_get_class_hour_details' ) );

		// Adds columns in the admin view for taxonomies
		add_filter( 'manage_edit-class_columns', array( $this, 'gymx_ext_edit_columns' ) );
		add_action( 'manage_class_posts_custom_column', array( $this, 'gymx_ext_column_display' ), 10, 2 );

		// Allows filtering of posts by taxonomy in the admin view
		add_action( 'restrict_manage_posts', array( $this, 'gymx_ext_tax_filters' ) );

		// Create Editor for altering the post type arguments
		add_action( 'admin_menu', array( $this, 'gymx_ext_add_page' ) );
		add_action( 'admin_init', array( $this,'gymx_ext_register_page_options' ) );
		add_action( 'admin_notices', array( $this, 'gymx_ext_notices' ) );

		// Adds the class custom sidebar
		add_filter( 'widgets_init', array( $this, 'gymx_ext_register_sidebar' ), 10 );
		add_filter( 'gymx_ext_get_sidebar', array( $this, 'gymx_ext_display_sidebar' ), 11 );
		
	}
	
	/**
	 * Register post type.
	 */
	public function gymx_ext_register_post_type() {

		// Get values and sanitize
		$name           = $this->label;
		$singular_name  = get_theme_mod( 'class_singular_name' );
		$singular_name  = $singular_name ? $singular_name : esc_html__( 'Class', 'ttbase-framework' );
		$slug           = get_theme_mod( 'class_slug' );
		$slug           = $slug ? $slug : 'class';
		$menu_icon      = get_theme_mod( 'class_admin_icon' );
		$menu_icon      = $menu_icon ? $menu_icon : 'cart';
		$class_search   = get_theme_mod( 'class_search', true );
		$class_search   = ! $class_search ? true : false;

		// Labels
		$labels = array(
			'name' => $name,
			'singular_name' => $singular_name,
			'add_new' => esc_html__( 'Add New', 'ttbase-framework' ),
			'add_new_item' => esc_html__( 'Add New Class', 'ttbase-framework' ),
			'edit_item' => esc_html__( 'Edit Class', 'ttbase-framework' ),
			'new_item' => esc_html__( 'Add New Class', 'ttbase-framework' ),
			'view_item' => esc_html__( 'View Class', 'ttbase-framework' ),
			'search_items' => esc_html__( 'Search Classs', 'ttbase-framework' ),
			'not_found' => esc_html__( 'No Classs Found', 'ttbase-framework' ),
			'not_found_in_trash' => esc_html__( 'No Classs Found In Trash', 'ttbase-framework' )
		);

		// Args
		$args = array(
			'labels' => $labels,
			'public' => true,
			'supports' => array(
				'title',
				'editor',
				'thumbnail',
				'excerpt'
			),
			'capability_type' => 'post',
			'rewrite' => array(
				'slug' => $slug,
			),
			'has_archive' => false,
			'menu_icon' => 'dashicons-'. $menu_icon,
			'menu_position' => 34,
			'exclude_from_search' => $class_search,
		);

		// Apply filters
		$args = apply_filters( 'gymx_ext_class_args', $args );

		// Register the post type
		register_post_type( 'classes', $args );
		
		add_filter( 'single_template', array( $this, 'gymx_ext_register_class_template' ), 15 );

	}
	
	public function gymx_ext_register_class_template($single_template) {
		global $post;

		if ($post->post_type == 'classes') {
			$single_template = dirname( __FILE__ ) . '/single-class.php';
		}
		return $single_template;	
	}

	/**
	 * Register Class tags.
	 */
	public function gymx_ext_register_tags() {

		// Define and sanitize options
		$name = get_theme_mod( 'class_tag_labels');
		$name = $name ? $name : esc_html__( 'Class Tags', 'ttbase-framework' );
		$slug = get_theme_mod( 'class_tag_slug' );
		$slug = $slug ? $slug : 'class-tag';

		// Define class tag labels
		$labels = array(
			'name' => $name,
			'singular_name' => $name,
			'menu_name' => $name,
			'search_items' => esc_html__( 'Search Class Tags', 'ttbase-framework' ),
			'popular_items' => esc_html__( 'Popular Class Tags', 'ttbase-framework' ),
			'all_items' => esc_html__( 'All Class Tags', 'ttbase-framework' ),
			'parent_item' => esc_html__( 'Parent Class Tag', 'ttbase-framework' ),
			'parent_item_colon' => esc_html__( 'Parent Class Tag:', 'ttbase-framework' ),
			'edit_item' => esc_html__( 'Edit Class Tag', 'ttbase-framework' ),
			'update_item' => esc_html__( 'Update Class Tag', 'ttbase-framework' ),
			'add_new_item' => esc_html__( 'Add New Class Tag', 'ttbase-framework' ),
			'new_item_name' => esc_html__( 'New Class Tag Name', 'ttbase-framework' ),
			'separate_items_with_commas' => esc_html__( 'Separate class tags with commas', 'ttbase-framework' ),
			'add_or_remove_items' => esc_html__( 'Add or remove class tags', 'ttbase-framework' ),
			'choose_from_most_used' => esc_html__( 'Choose from the most used class tags', 'ttbase-framework' ),
		);

		// Define class tag arguments
		$args = array(
			'labels' => $labels,
			'public' => true,
			'show_in_nav_menus' => true,
			'show_ui' => true,
			'show_tagcloud' => true,
			'hierarchical' => false,
			'rewrite' => array(
				'slug' => $slug,
			),
			'query_var' => true
		);

		// Apply filters for child theming
		$args = apply_filters( 'gymx_ext_taxonomy_class_tag_args', $args );

		// Register the class tag taxonomy
		register_taxonomy( 'class_tag', array( 'classes' ), $args );

	}

	/**
	 * Register Class category.
	 */
	public function gymx_ext_register_categories() {

		// Define and sanitize options
		$name = get_theme_mod( 'class_cat_labels');
		$name = $name ? $name : esc_html__( 'Class Categories', 'ttbase-framework' );
		$slug = get_theme_mod( 'class_cat_slug' );
		$slug = $slug ? $slug : 'class-category';

		// Define class category labels
		$labels = array(
			'name' => $name,
			'singular_name' => $name,
			'menu_name' => $name,
			'search_items' => esc_html__( 'Search','ttbase-framework' ),
			'popular_items' => esc_html__( 'Popular', 'ttbase-framework' ),
			'all_items' => esc_html__( 'All', 'ttbase-framework' ),
			'parent_item' => esc_html__( 'Parent', 'ttbase-framework' ),
			'parent_item_colon' => esc_html__( 'Parent', 'ttbase-framework' ),
			'edit_item' => esc_html__( 'Edit', 'ttbase-framework' ),
			'update_item' => esc_html__( 'Update', 'ttbase-framework' ),
			'add_new_item' => esc_html__( 'Add New', 'ttbase-framework' ),
			'new_item_name' => esc_html__( 'New', 'ttbase-framework' ),
			'separate_items_with_commas' => esc_html__( 'Separate with commas', 'ttbase-framework' ),
			'add_or_remove_items' => esc_html__( 'Add or remove', 'ttbase-framework' ),
			'choose_from_most_used' => esc_html__( 'Choose from the most used', 'ttbase-framework' ),
		);

		// Define class category arguments
		$args = array(
			'labels' => $labels,
			'public' => true,
			'show_in_nav_menus' => true,
			'show_ui' => true,
			'show_tagcloud' => true,
			'hierarchical' => true,
			'rewrite' => array(
				'slug'  => $slug
			),
			'query_var' => true
		);

		// Apply filters for child theming
		$args = apply_filters( 'gymx_ext_taxonomy_class_category_args', $args );

		// Register the class category taxonomy
		register_taxonomy( 'class_category', array( 'classes' ), $args );

	}
	
	/**
	 * Add custom db table
	 */
	public function gymx_ext_add_custom_db_table() {
		global $wpdb;
		
		if(!get_option("gymx_class_hours_table_installed"))
		{
			//create custom db table
			$query = "CREATE TABLE IF NOT EXISTS `".$wpdb->prefix."class_hours` (
				`class_hours_id` BIGINT( 20 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
				`class_id` BIGINT( 20 ) NOT NULL ,
				`weekday_id` BIGINT( 20 ) NOT NULL ,
				`start` TIME NOT NULL ,
				`end` TIME NOT NULL,
				`tooltip` text NOT NULL,
				`before_hour_text` text NOT NULL,
				`after_hour_text` text NOT NULL,
				`trainers` varchar(255) NOT NULL,
				`category` varchar(255) NOT NULL,
				INDEX ( `class_id` ),
				INDEX ( `weekday_id` )
			) ENGINE = MYISAM DEFAULT CHARSET=utf8;";
			$wpdb->query($query);
			//insert sample data
			$query = "INSERT INTO `".$wpdb->prefix."class_hours` (`class_hours_id`, `class_id`, `weekday_id`, `start`, `end`, `tooltip`, `before_hour_text`, `after_hour_text`, `trainers`, `category`) VALUES
				(1, 3261, 3240, '06:00:00', '07:00:00', '', '', '', '', ''),
				(2, 3261, 3241, '06:00:00', '07:00:00', '', '', '', '', ''),
				(58, 3260, 3244, '16:00:00', '17:30:00', '', '', '', '', ''),
				(57, 3260, 3246, '11:00:00', '12:00:00', '', '', '', '', ''),
				(5, 3261, 3245, '17:00:00', '18:00:00', '', '', '', '', ''),
				(6, 3261, 3246, '17:00:00', '18:00:00', '', '', '', '', ''),
				(7, 3260, 3240, '16:00:00', '17:30:00', '', '', '', '', ''),
				(8, 3260, 3241, '16:00:00', '17:30:00', '', '', '', '', ''),
				(9, 3260, 3243, '16:00:00', '17:30:00', '', '', '', '', ''),
				(10, 3260, 3245, '08:00:00', '09:30:00', '', '', '', '', ''),
				(11, 3260, 3246, '08:00:00', '09:30:00', '', '', '', '', ''),
				(71, 3261, 3246, '10:00:00', '11:00:00', '', '', '', '', ''),
				(70, 3261, 3245, '10:00:00', '11:00:00', '', '', '', '', ''),
				(69, 3259, 3244, '18:00:00', '20:00:00', '', '', '', '', ''),
				(68, 3261, 3245, '12:00:00', '13:00:00', '', '', '', '', ''),
				(67, 3261, 3246, '12:00:00', '13:00:00', '', '', '', '', ''),
				(66, 3261, 3243, '12:00:00', '13:00:00', '', '', '', '', ''),
				(65, 3261, 3242, '12:00:00', '13:00:00', '', '', '', '', ''),
				(19, 3250, 3240, '07:00:00', '08:00:00', '', '', '', '', ''),
				(20, 3250, 3241, '07:00:00', '08:00:00', '', '', '', '', ''),
				(21, 3250, 3243, '10:00:00', '11:30:00', '', '', '', '', ''),
				(22, 3250, 3244, '10:00:00', '11:30:00', '', '', '', '', ''),
				(23, 3250, 3245, '14:00:00', '16:00:00', '', '', '', '', ''),
				(24, 3250, 3246, '14:00:00', '16:00:00', '', '', '', '', ''),
				(27, 3261, 3240, '14:00:00', '16:15:00', '', '', '', '', ''),
				(28, 3261, 3241, '14:00:00', '16:15:00', '', '', '', '', ''),
				(29, 3261, 3244, '17:30:00', '20:00:00', '', '', '', '', ''),
				(30, 3260, 3240, '09:00:00', '11:25:00', '', '', '', '', ''),
				(31, 3260, 3241, '09:00:00', '11:25:00', '', '', '', '', ''),
				(32, 3260, 3245, '11:00:00', '12:00:00', '', '', '', '', ''),
				(44, 3259, 3245, '12:00:00', '15:45:00', '', '', '', '', ''),
				(41, 3259, 3240, '05:00:00', '06:00:00', '', '', '', '', ''),
				(43, 3259, 3244, '12:00:00', '15:45:00', '', '', '', '', ''),
				(40, 3259, 3240, '18:00:00', '19:00:00', '', '', '', '', ''),
				(42, 3259, 3241, '05:00:00', '06:00:00', '', '', '', '', ''),
				(45, 3259, 3241, '18:00:00', '19:00:00', '', '', '', '', ''),
				(46, 3259, 3242, '18:00:00', '20:00:00', '', '', '', '', ''),
				(47, 3259, 3243, '18:00:00', '20:00:00', '', '', '', '', ''),
				(52, 3261, 3242, '06:00:00', '08:30:00', '', '', '', '', ''),
				(56, 3260, 3244, '09:00:00', '10:00:00', '', '', '', '', ''),
				(55, 3260, 3243, '09:00:00', '10:00:00', '', '', '', '', ''),
				(53, 3261, 3243, '06:00:00', '08:30:00', '', '', '', '', ''),
				(54, 3261, 3244, '06:00:00', '08:30:00', '', '', '', '', ''),
				(59, 3249, 3240, '18:30:00', '20:00:00', '', '', '', '', ''),
				(60, 3249, 3241, '18:30:00', '20:00:00', '', '', '', '', ''),
				(61, 3249, 3242, '18:30:00', '20:00:00', '', '', '', '', ''),
				(62, 3249, 3243, '18:30:00', '20:00:00', '', '', '', '', ''),
				(63, 3249, 3245, '19:00:00', '20:30:00', '', '', '', '', ''),
				(64, 3249, 3246, '19:00:00', '20:30:00', '', '', '', '', ''),
				(75, 3250, 3243, '06:00:00', '08:30:00', '', '', '', '', ''),
				(74, 3250, 3242, '06:00:00', '08:30:00', '', '', '', '', ''),
				(78, 3247, 3246, '10:00:00', '11:30:00', '', '', '', '', ''),
				(79, 3247, 3243, '10:00:00', '11:30:00', '', '', '', '', ''),
				(77, 3247, 3242, '10:00:00', '11:30:00', '', '', '', '', ''),
				(76, 3250, 3244, '06:00:00', '08:30:00', '', '', '', '', '');";
			$wpdb->query($query);
			add_option("gymx_class_hours_table_installed", 1);
			add_option("gymx_class_hours_table_updated_new", 1);
		}
		else if(!get_option("gymx_class_hours_table_updated_new"))
		{
			$query = "ALTER TABLE `".$wpdb->prefix."class_hours` 
				ADD `tooltip` TEXT NOT NULL ,
				ADD `before_hour_text` TEXT NOT NULL ,
				ADD `after_hour_text` TEXT NOT NULL ,
				ADD `trainers` VARCHAR( 255 ) NOT NULL ,
				ADD `category` VARCHAR( 255 ) NOT NULL";
			$wpdb->query($query);
			add_option("gymx_class_hours_table_updated_new", 1);
		}
		
	}
	
	//get class hour details
	public function gymx_ext_get_class_hour_details()
	{
		global $blog_id;
		global $wpdb;
		$query = "SELECT * FROM `".$wpdb->prefix."class_hours` AS t1 LEFT JOIN {$wpdb->posts} AS t2 ON t1.weekday_id=t2.ID WHERE t1.class_id='" . $_POST["post_id"] . "' AND t1.class_hours_id='" . $_POST["id"] . "'";
		$class_hour = $wpdb->get_row($query);
		$class_hour->start = date("H:i", strtotime($class_hour->start));
		$class_hour->end = date("H:i", strtotime($class_hour->end));
		echo "class_hour_start" . json_encode($class_hour) . "class_hour_end";
		exit();
	}
	
	//Adds a box to the right column and to the main column on the Classes edit screens
	public function gymx_add_classes_custom_box() 
	{
	    add_meta_box(
	        "class_hours",
	       esc_attr__("Class hours", 'ttbase-framework'),
	        array($this,"gymx_inner_classes_custom_box_side"),
	        "classes",
			"normal"
	    );
	}
	
	// Prints the box content
	public function gymx_inner_classes_custom_box_side($post) 
	{
		global $blog_id;
		global $wpdb;
		
		//Use nonce for verification
		wp_nonce_field(plugin_basename( __FILE__ ), "gymx_classes_noncename");
	
		//The actual fields for data entry
		$query = "SELECT * FROM `".$wpdb->prefix."class_hours` AS t1 LEFT JOIN {$wpdb->posts} AS t2 ON t1.weekday_id=t2.ID WHERE t1.class_id='" . $post->ID . "' ORDER BY FIELD(t2.menu_order,1,2,3,4,5,6,7), t1.start, t1.end";
		$class_hours = $wpdb->get_results($query);
		$class_hours_count = count($class_hours);
		
		//get weekdays
		$query = "SELECT ID, post_title FROM {$wpdb->posts}
				WHERE 
				post_type='gymx_weekdays'
				ORDER BY FIELD(menu_order,1,2,3,4,5,6,7)";
		$weekdays = $wpdb->get_results($query);
		
		echo '
		<ul id="class_hours_list"' . (!$class_hours_count ? ' style="display: none;"' : '') . '>';
			for($i=0; $i<$class_hours_count; $i++)
			{
				//get day by id
				$current_day = get_post($class_hours[$i]->weekday_id);
				echo '<li id="class_hours_' . $class_hours[$i]->class_hours_id . '">' . $current_day->post_title . ' ' . date("H:i", strtotime($class_hours[$i]->start)) . '-' . date("H:i", strtotime($class_hours[$i]->end)) . '<i class="fa fa-trash operation_button delete_button"></i><i class="fa fa-edit operation_button edit_button"></i><i class="fa fa-spinner fa-pulse fa-2x fa-fw operation_button edit_hour_class_loader"></i>';
				$trainersString = "";
				if($class_hours[$i]->trainers!="")
				{
					query_posts(array( 
						'post__in' => explode(",", $class_hours[$i]->trainers),
						'post_type' => 'trainers',
						'posts_per_page' => '-1',
						'post_status' => 'publish',
						'orderby' => 'post_title', 
						'order' => 'DESC'
					));
					while(have_posts()): the_post();
						$trainersString .= get_the_title() . ", ";
					endwhile;
					if($trainersString!="")
						$trainersString = substr($trainersString, 0, -2);
				}
				if($class_hours[$i]->tooltip!="" || $class_hours[$i]->before_hour_text!="" || $class_hours[$i]->after_hour_text!="" || $trainersString!="" || $class_hours[$i]->category!="")
				{
					echo '<div>';
					if($class_hours[$i]->tooltip!="")
						echo '<br /><strong>' .esc_html__('Tooltip', 'ttbase-framework') . ':</strong> ' . $class_hours[$i]->tooltip;
					if($class_hours[$i]->before_hour_text!="")
						echo '<br /><strong>' .esc_html__('Before hour text', 'ttbase-framework') . ':</strong> ' . $class_hours[$i]->before_hour_text;
					if($class_hours[$i]->after_hour_text!="")
						echo '<br /><strong>' .esc_html__('After hour text', 'ttbase-framework') . ':</strong> ' . $class_hours[$i]->after_hour_text;
					if($trainersString)
						echo '<br /><strong>' .esc_html__('Trainers', 'ttbase-framework') . ':</strong> ' . $trainersString;
					if($class_hours[$i]->category!="")
						echo '<br /><strong>' .esc_html__('Category', 'ttbase-framework') . ':</strong> ' . $class_hours[$i]->category;
					echo '</div>';
				}
				echo '</li>';
			}
		echo '
		</ul>
		<table id="class_hours_table">
			<tr>
				<td>
					<label for="weekday_id">' .esc_html__('Day', 'ttbase-framework') . ':</label>
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
					<label for="start_hour">' .esc_html__('Start hour', 'ttbase-framework') . ':</label>
				</td>
				<td>
					<input size="5" maxlength="5" type="text" id="start_hour" name="start_hour" value="" />
					<span class="description">hh:mm</span>
				</td>
			</tr>
			<tr>
				<td>
					<label for="end_hour">' .esc_html__('End hour', 'ttbase-framework') . ':</label>
				</td>
				<td>
					<input size="5" maxlength="5" type="text" id="end_hour" name="end_hour" value="" />
					<span class="description">hh:mm</span>
				</td>
			</tr>
			<tr>
				<td>
					<label for="before_hour_text">' .esc_html__('Before hour text', 'ttbase-framework') . ':</label>
				</td>
				<td>
					<textarea id="before_hour_text" name="before_hour_text"></textarea>
				</td>
			</tr>
			<tr>
				<td>
					<label for="after_hour_text">' .esc_html__('After hour text', 'ttbase-framework') . ':</label>
				</td>
				<td>
					<textarea id="after_hour_text" name="after_hour_text"></textarea>
				</td>
			</tr>
			<tr>
				<td>
					<label for="tooltip">' .esc_html__('Tooltip', 'ttbase-framework') . ':</label>
				</td>
				<td>
					<textarea id="tooltip" name="tooltip"></textarea>
				</td>
			</tr>';
			if(wp_count_posts("trainers"))
			{
				echo '
			<tr>
				<td>
					<label for="trainers">' .esc_html__('Trainers', 'ttbase-framework') . ':</label>
				</td>
				<td>
					<select id="class_hour_trainers" name="class_hour_trainers[]" multiple="multiple">';
						query_posts(array( 
							'post_type' => 'trainers',
							'posts_per_page' => '-1',
							'post_status' => 'publish',
							'orderby' => 'post_title', 
							'order' => 'DESC'
						));
						while(have_posts()): the_post();
							echo '<option value="' . get_the_ID() . '"' . (!empty($trainers) && in_array(get_the_ID(), (array)$trainers) ? ' selected="selected"' : '') . '>' . get_the_title() . '</option>';
						endwhile;
				echo '
					</select>
				</td>
			</tr>';
			}
			echo '
			<tr>
				<td>
					<label for="class_hour_category">' .esc_html__('Category', 'ttbase-framework') . ':</label>
				</td>
				<td>
					<input type="text" id="class_hour_category" name="class_hour_category" value="" />
				</td>
			</tr>
			<tr>
				<td colspan="2" style="text-align: right;">
					<input id="add_class_hours" type="button" class="button" value="' .esc_html__("Add", 'ttbase-framework') . '" />
				</td>
			</tr>
		</table>
		';
		//Reset Query
		wp_reset_query();
	}
	
	//When the post is saved, saves our custom data
	public static function gymx_save_classes_postdata($post_id) 
	{
		global $themename;
		global $blog_id;
		global $wpdb;
		//verify if this is an auto save routine. 
		//if it is our form has not been submitted, so we dont want to do anything
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) 
			return;
	
		//verify this came from the our screen and with proper authorization,
		//because save_post can be triggered at other times
		if (!isset($_POST['gymx_classes_noncename']) || !wp_verify_nonce($_POST['gymx_classes_noncename'], plugin_basename( __FILE__ )))
			return;
	
	
		//Check permissions
		if(!current_user_can('edit_post', $post_id))
			return;
	
		//OK, we're authenticated: we need to find and save the data
		if (isset($_POST["weekday_ids"])) {
			$hours_count = count($_POST["weekday_ids"]);
			for($i=0; $i<$hours_count; $i++)
			{
				$query = "INSERT INTO `".$wpdb->prefix."class_hours` VALUES(
					NULL,
					'" . $post_id . "',
					'" . $_POST["weekday_ids"][$i] . "',
					'" . $_POST["start_hours"][$i] . "',
					'" . $_POST["end_hours"][$i] . "',
					'" . $_POST["tooltips"][$i] . "',
					'" . $_POST["before_hour_texts"][$i] . "',
					'" . $_POST["after_hour_texts"][$i] . "',
					'" . $_POST["class_hours_trainers"][$i] . "',
					'" . $_POST["class_hours_category"][$i] . "'
				);";
				$wpdb->query($query);
			}
		}
		
		//removing data if needed
		if (isset($_POST["delete_class_hours_ids"])) {
			$delete_class_hours_ids_count = count($_POST["delete_class_hours_ids"]);
			if($delete_class_hours_ids_count)
				$wpdb->query("DELETE FROM `".$wpdb->prefix."class_hours` WHERE class_hours_id IN(" . implode(",", $_POST["delete_class_hours_ids"]) . ");");
		}
		
		//post meta
		//update_post_meta($post_id, "gymx_subtitle", $_POST["subtitle"]);
		//update_post_meta($post_id, "gymx_trainers", $_POST["trainers"]);
		//update_post_meta($post_id, "gymx_color", $_POST["color"]);
		//update_post_meta($post_id, "gymx_text_color", $_POST["text_color"]);
	}


	/**
	 * Adds columns to the WP dashboard edit screen.
	 */
	public static function gymx_ext_edit_columns( $columns ) {
		$columns['class_category'] = esc_html__( 'Category', 'ttbase-framework' );
		$columns['class_tag']      = esc_html__( 'Tags', 'ttbase-framework' );
		return $columns;
	}
	

	/**
	 * Adds columns to the WP dashboard edit screen.
	 */
	public static function gymx_ext_column_display( $column, $post_id ) {

		switch ( $column ) :

			// Display the class categories in the column view
			case 'class_category':

				if ( $category_list = get_the_term_list( $post_id, 'class_category', '', ', ', '' ) ) {
					echo $category_list;
				} else {
					echo '&mdash;';
				}

			break;

			// Display the class tags in the column view
			case 'class_tag':

				if ( $tag_list = get_the_term_list( $post_id, 'class_tag', '', ', ', '' ) ) {
					echo $tag_list;
				} else {
					echo '&mdash;';
				}

			break;

		endswitch;

	}

	/**
	 * Adds taxonomy filters to the class admin page.
	 */
	public static function gymx_ext_tax_filters() {
		global $typenow;

		// An array of all the taxonomyies you want to display. Use the taxonomy name or slug
		$taxonomies = array( 'class_category', 'class_tag' );

		// must set this to the post type you want the filter(s) displayed on
		if ( 'classes' == $typenow ) {

			foreach ( $taxonomies as $tax_slug ) {
				$current_tax_slug = isset( $_GET[$tax_slug] ) ? $_GET[$tax_slug] : false;
				$tax_obj = get_taxonomy( $tax_slug );
				$tax_name = $tax_obj->labels->name;
				$terms = get_terms($tax_slug);
				if ( count( $terms ) > 0) {
					echo "<select name='$tax_slug' id='$tax_slug' class='postform'>";
					echo "<option value=''>$tax_name</option>";
					foreach ( $terms as $term ) {
						echo '<option value=' . $term->slug, $current_tax_slug == $term->slug ? ' selected="selected"' : '','>' . $term->name .' (' . $term->count .')</option>';
					}
					echo "</select>";
				}
			}
		}
	}

	/**
	 * Add sub menu page for the Class Editor.
	 */
	public function gymx_ext_add_page() {
		add_submenu_page(
			'edit.php?post_type=classes',
			esc_html__( 'Post Type Editor', 'ttbase-framework' ),
			esc_html__( 'Post Type Editor', 'ttbase-framework' ),
			'administrator',
			'ttbase-class-editor',
			array( $this, 'gymx_ext_create_admin_page' )
		);
	}

	/**
	 * Function that will register the class editor admin page.
	 */
	public function gymx_ext_register_page_options() {
		register_setting( 'gymx_ext_class_options', 'gymx_ext_class_branding', array( $this, 'gymx_ext_sanitize' ) );
	}

	/**
	 * Displays saved message after settings are successfully saved.
	 */
	public static function gymx_ext_notices() {
		settings_errors( 'gymx_ext_class_editor_page_notices' );
	}

	/**
	 * Sanitizes input and saves theme_mods.
	 */
	public static function gymx_ext_sanitize( $options ) {

		// Save values to theme mod
		if ( ! empty ( $options ) ) {
			foreach( $options as $key => $value ) {
				if ( $value ) {
					set_theme_mod( $key, $value );
				} else {
					remove_theme_mod( $key );
				}
			}
		}

		// Add notice
		add_settings_error(
			'gymx_ext_class_editor_page_notices',
			esc_attr( 'settings_updated' ),
			esc_html__( 'Settings saved.', 'ttbase-framework' ),
			'updated'
		);

		// Lets delete the options as we are saving them into theme mods
		$options = '';
		return $options;
	}

	/**
	 * Output for the actual Class Editor admin page.
	 */
	public function gymx_ext_create_admin_page() { ?>
		<div class="wrap">
			<h2><?php esc_html_e( 'Post Type Editor', 'ttbase-framework' ); ?></h2>
			<form method="post" action="options.php">
				<?php settings_fields( 'gymx_ext_class_options' ); ?>
				<p><?php esc_html_e( 'If you change any slug\'s you must reset your permalinks to prevent 404 errors.', 'ttbase-framework' ); ?></p>
				<table class="form-table">
					<tr valign="top">
						<th scope="row"><?php esc_html_e( 'Admin Icon', 'ttbase-framework' ); ?></th>
						<td>
							<?php
							// Dashicons select
							$dashicons = array('admin-appearance','admin-collapse','admin-comments','admin-generic','admin-home','admin-media','admin-network','admin-page','admin-plugins','admin-settings','admin-site','admin-tools','admin-users','align-center','align-left','align-none','align-right','analytics','arrow-down','arrow-down-alt','arrow-down-alt2','arrow-left','arrow-left-alt','arrow-left-alt2','arrow-right','arrow-right-alt','arrow-right-alt2','arrow-up','arrow-up-alt','arrow-up-alt2','art','awards','backup','book','book-alt','businessman','calendar','camera','cart','category','chart-area','chart-bar','chart-line','chart-pie','clock','cloud','dashboard','desktop','dismiss','download','edit','editor-aligncenter','editor-alignleft','editor-alignright','editor-bold','editor-customchar','editor-distractionfree','editor-help','editor-indent','editor-insertmore','editor-italic','editor-justify','editor-kitchensink','editor-ol','editor-outdent','editor-paste-text','editor-paste-word','editor-quote','editor-removeformatting','editor-rtl','editor-spellcheck','editor-strikethrough','editor-textcolor','editor-ul','editor-underline','editor-unlink','editor-video','email','email-alt','exerpt-view','facebook','facebook-alt','feedback','flag','format-aside','format-audio','format-chat','format-gallery','format-image','format-links','format-quote','format-standard','format-status','format-video','forms','googleplus','groups','hammer','id','id-alt','image-crop','image-flip-horizontal','image-flip-vertical','image-rotate-left','image-rotate-right','images-alt','images-alt2','info','leftright','lightbulb','list-view','location','location-alt','lock','marker','menu','migrate','minus','networking','no','no-alt','performance','plus','class','post-status','pressthis','products','redo','rss','screenoptions','search','share','share-alt','share-alt2','share1','shield','shield-alt','slides','smartphone','smiley','sort','sos','star-empty','star-filled','star-half','tablet','tag','testimonial','translation','trash','twitter','undo','update','upload','vault','video-alt','video-alt2','video-alt3','visibility','welcome-add-page','welcome-comments','welcome-edit-page','welcome-learn-more','welcome-view-site','welcome-widgets-menus','wordpress','wordpress-alt','yes');
							$dashicons = array_combine( $dashicons, $dashicons ); ?>
							<select name="gymx_ext_class_branding[class_admin_icon]">
								<option value=""><?php esc_html_e( 'Default', 'ttbase-framework' ); ?></option>
								<?php foreach ( $dashicons as $dashicon ) { ?>
									<option value="<?php echo esc_attr($dashicon); ?>" <?php selected( get_theme_mod( 'class_admin_icon' ), $dashicon, true ); ?>><?php echo esc_html($dashicon); ?></option>
								<?php } ?>
							</select>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php esc_html_e( 'Post Type: Name', 'ttbase-framework' ); ?></th>
						<td><input type="text" name="gymx_ext_class_branding[class_labels]" value="<?php echo get_theme_mod( 'class_labels' ); ?>" /></td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php esc_html_e( 'Post Type: Singular Name', 'ttbase-framework' ); ?></th>
						<td><input type="text" name="gymx_ext_class_branding[class_singular_name]" value="<?php echo get_theme_mod( 'class_singular_name' ); ?>" /></td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php esc_html_e( 'Post Type: Slug', 'ttbase-framework' ); ?></th>
						<td><input type="text" name="gymx_ext_class_branding[class_slug]" value="<?php echo get_theme_mod( 'class_slug' ); ?>" /></td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php esc_html_e( 'Tags: Label', 'ttbase-framework' ); ?></th>
						<td><input type="text" name="gymx_ext_class_branding[class_tag_labels]" value="<?php echo get_theme_mod( 'class_tag_labels' ); ?>" /></td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php esc_html_e( 'Tags: Slug', 'ttbase-framework' ); ?></th>
						<td><input type="text" name="gymx_ext_class_branding[class_tag_slug]" value="<?php echo get_theme_mod( 'class_tag_slug' ); ?>" /></td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php esc_html_e( 'Categories: Label', 'ttbase-framework' ); ?></th>
						<td><input type="text" name="gymx_ext_class_branding[class_cat_labels]" value="<?php echo get_theme_mod( 'class_cat_labels' ); ?>" /></td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php esc_html_e( 'Categories: Slug', 'ttbase-framework' ); ?></th>
						<td><input type="text" name="gymx_ext_class_branding[class_cat_slug]" value="<?php echo get_theme_mod( 'class_cat_slug' ); ?>" /></td>
					</tr>
				</table>
				<?php submit_button(); ?>
			</form>
		</div>
	<?php }

	/**
	 * Registers a new custom class sidebar.
	 */
	public static function gymx_ext_register_sidebar() {


		// Return if custom sidebar is disabled
		if ( ! get_theme_mod( 'class_custom_sidebar', true ) ) {
			return;
		}

		// Get post type object to name sidebar correctly
		$obj            = get_post_type_object( 'classes' );
		$post_type_name = $obj->labels->name;

		// Register team_sidebar
		register_sidebar( array (
			'name'          => $post_type_name .' '. esc_html__( 'Sidebar', 'ttbase-framework' ),
			'id'            => 'sidebar-class',
			'before_widget' => '<aside id="%1$s" class="sidebar class widget %2$s">',
            'after_widget' => '</aside>',
            'before_title' => '<h5 class="title">',
            'after_title' => '</h5>',
		) );
	}

	/**
	 * Alter main sidebar to display class sidebar.
	 */
	public static function gymx_ext_display_sidebar( $sidebar ) {
		if ( get_theme_mod( 'class_custom_sidebar', true ) && ( is_singular( 'classes' ) || gymx_ext_is_class_tax() ) ) {
			$sidebar = 'class_sidebar';
		}
		return $sidebar;
	}
}
$gymx_ext_class_config = new GymX_Ext_Class_Config;