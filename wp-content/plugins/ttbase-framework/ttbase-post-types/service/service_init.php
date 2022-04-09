<?php
/**
 * Service Post Type Configuration file
 */

// Set global var
global $ttbase_framework_service_config;

// The class
class TTBase_Framework_Service_Config {
	private $label;

	public function __construct() {

		// Update vars
		$this->label = get_theme_mod( 'service_labels' );
		$this->label = $this->label ? $this->label : esc_html_x( 'Services', 'Service Post Type Label', 'ttbase-framework' );


		// Adds the service post type
		add_action( 'init', array( $this, 'ttbase_framework_register_post_type' ), 0 );

		// Adds the service taxonomies
		add_action( 'init', array( $this, 'ttbase_framework_register_tags' ), 5 );
		add_action( 'init', array( $this, 'ttbase_framework_register_categories' ), 10 );

		// Adds columns in the admin view for taxonomies
		add_filter( 'manage_edit-service_columns', array( $this, 'ttbase_framework_edit_columns' ) );
		add_action( 'manage_service_posts_custom_column', array( $this, 'ttbase_framework_column_display' ), 10, 2 );

		// Allows filtering of posts by taxonomy in the admin view
		add_action( 'restrict_manage_posts', array( $this, 'ttbase_framework_tax_filters' ) );

		// Create Editor for altering the post type arguments
		add_action( 'admin_menu', array( $this, 'ttbase_framework_add_page' ) );
		add_action( 'admin_init', array( $this,'ttbase_framework_register_page_options' ) );
		add_action( 'admin_notices', array( $this, 'ttbase_framework_notices' ) );

		// Adds the service custom sidebar
		add_filter( 'widgets_init', array( $this, 'ttbase_framework_register_sidebar' ), 10 );
		add_filter( 'ttbase_framework_get_sidebar', array( $this, 'ttbase_framework_display_sidebar' ), 11 );
		
	}
	
	/**
	 * Register post type.
	 */
	public function ttbase_framework_register_post_type() {

		// Get values and sanitize
		$name           = $this->label;
		$singular_name  = get_theme_mod( 'service_singular_name' );
		$singular_name  = $singular_name ? $singular_name : esc_html__( 'Service', 'ttbase-framework' );
		$slug           = get_theme_mod( 'service_slug' );
		$slug           = $slug ? $slug : 'service';
		$menu_icon      = get_theme_mod( 'service_admin_icon' );
		$menu_icon      = $menu_icon ? $menu_icon : 'cart';
		$service_search   = get_theme_mod( 'service_search', true );
		$service_search   = ! $service_search ? true : false;

		// Labels
		$labels = array(
			'name' => $name,
			'singular_name' => $singular_name,
			'add_new' => esc_html__( 'Add New', 'ttbase-framework' ),
			'add_new_item' => esc_html__( 'Add New Service', 'ttbase-framework' ),
			'edit_item' => esc_html__( 'Edit Service', 'ttbase-framework' ),
			'new_item' => esc_html__( 'Add New Service', 'ttbase-framework' ),
			'view_item' => esc_html__( 'View Service', 'ttbase-framework' ),
			'search_items' => esc_html__( 'Search Services', 'ttbase-framework' ),
			'not_found' => esc_html__( 'No Services Found', 'ttbase-framework' ),
			'not_found_in_trash' => esc_html__( 'No Services Found In Trash', 'ttbase-framework' )
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
			'menu_position' => 20,
			'exclude_from_search' => $service_search,
		);

		// Apply filters
		$args = apply_filters( 'ttbase_framework_service_args', $args );

		// Register the post type
		register_post_type( 'service', $args );
		
		add_filter( 'single_template', array( $this, 'ttbase_framework_register_service_template' ), 15 );

	}
	
	public function ttbase_framework_register_service_template($single_template) {
		global $post;

		if ($post->post_type == 'service') {
			$single_template = dirname( __FILE__ ) . '/single-service.php';
		}
		return $single_template;	
	}

	/**
	 * Register Service tags.
	 */
	public function ttbase_framework_register_tags() {

		// Define and sanitize options
		$name = get_theme_mod( 'service_tag_labels');
		$name = $name ? $name : esc_html__( 'Service Tags', 'ttbase-framework' );
		$slug = get_theme_mod( 'service_tag_slug' );
		$slug = $slug ? $slug : 'service-tag';

		// Define service tag labels
		$labels = array(
			'name' => $name,
			'singular_name' => $name,
			'menu_name' => $name,
			'search_items' => esc_html__( 'Search Service Tags', 'ttbase-framework' ),
			'popular_items' => esc_html__( 'Popular Service Tags', 'ttbase-framework' ),
			'all_items' => esc_html__( 'All Service Tags', 'ttbase-framework' ),
			'parent_item' => esc_html__( 'Parent Service Tag', 'ttbase-framework' ),
			'parent_item_colon' => esc_html__( 'Parent Service Tag:', 'ttbase-framework' ),
			'edit_item' => esc_html__( 'Edit Service Tag', 'ttbase-framework' ),
			'update_item' => esc_html__( 'Update Service Tag', 'ttbase-framework' ),
			'add_new_item' => esc_html__( 'Add New Service Tag', 'ttbase-framework' ),
			'new_item_name' => esc_html__( 'New Service Tag Name', 'ttbase-framework' ),
			'separate_items_with_commas' => esc_html__( 'Separate service tags with commas', 'ttbase-framework' ),
			'add_or_remove_items' => esc_html__( 'Add or remove service tags', 'ttbase-framework' ),
			'choose_from_most_used' => esc_html__( 'Choose from the most used service tags', 'ttbase-framework' ),
		);

		// Define service tag arguments
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
		$args = apply_filters( 'ttbase_framework_taxonomy_service_tag_args', $args );

		// Register the service tag taxonomy
		register_taxonomy( 'service_tag', array( 'service' ), $args );

	}

	/**
	 * Register Service category.
	 */
	public function ttbase_framework_register_categories() {

		// Define and sanitize options
		$name = get_theme_mod( 'service_cat_labels');
		$name = $name ? $name : esc_html__( 'Service Categories', 'ttbase-framework' );
		$slug = get_theme_mod( 'service_cat_slug' );
		$slug = $slug ? $slug : 'service-category';

		// Define service category labels
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

		// Define service category arguments
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
		$args = apply_filters( 'ttbase_framework_taxonomy_service_category_args', $args );

		// Register the service category taxonomy
		register_taxonomy( 'service_category', array( 'service' ), $args );

	}


	/**
	 * Adds columns to the WP dashboard edit screen.
	 */
	public static function ttbase_framework_edit_columns( $columns ) {
		$columns['service_category'] = esc_html__( 'Category', 'ttbase-framework' );
		$columns['service_tag']      = esc_html__( 'Tags', 'ttbase-framework' );
		return $columns;
	}
	

	/**
	 * Adds columns to the WP dashboard edit screen.
	 */
	public static function ttbase_framework_column_display( $column, $post_id ) {

		switch ( $column ) :

			// Display the service categories in the column view
			case 'service_category':

				if ( $category_list = get_the_term_list( $post_id, 'service_category', '', ', ', '' ) ) {
					echo $category_list;
				} else {
					echo '&mdash;';
				}

			break;

			// Display the service tags in the column view
			case 'service_tag':

				if ( $tag_list = get_the_term_list( $post_id, 'service_tag', '', ', ', '' ) ) {
					echo $tag_list;
				} else {
					echo '&mdash;';
				}

			break;

		endswitch;

	}

	/**
	 * Adds taxonomy filters to the service admin page.
	 */
	public static function ttbase_framework_tax_filters() {
		global $typenow;

		// An array of all the taxonomyies you want to display. Use the taxonomy name or slug
		$taxonomies = array( 'service_category', 'service_tag' );

		// must set this to the post type you want the filter(s) displayed on
		if ( 'service' == $typenow ) {

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
	 * Add sub menu page for the Service Editor.
	 */
	public function ttbase_framework_add_page() {
		add_submenu_page(
			'edit.php?post_type=service',
			esc_html__( 'Post Type Editor', 'ttbase-framework' ),
			esc_html__( 'Post Type Editor', 'ttbase-framework' ),
			'administrator',
			'ttbase-service-editor',
			array( $this, 'ttbase_framework_create_admin_page' )
		);
	}

	/**
	 * Function that will register the service editor admin page.
	 */
	public function ttbase_framework_register_page_options() {
		register_setting( 'ttbase_framework_service_options', 'ttbase_framework_service_branding', array( $this, 'ttbase_framework_sanitize' ) );
	}

	/**
	 * Displays saved message after settings are successfully saved.
	 */
	public static function ttbase_framework_notices() {
		settings_errors( 'ttbase_framework_service_editor_page_notices' );
	}

	/**
	 * Sanitizes input and saves theme_mods.
	 */
	public static function ttbase_framework_sanitize( $options ) {

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
			'ttbase_framework_service_editor_page_notices',
			esc_attr( 'settings_updated' ),
			esc_html__( 'Settings saved.', 'ttbase-framework' ),
			'updated'
		);

		// Lets delete the options as we are saving them into theme mods
		$options = '';
		return $options;
	}

	/**
	 * Output for the actual Service Editor admin page.
	 */
	public function ttbase_framework_create_admin_page() { ?>
		<div class="wrap">
			<h2><?php esc_html_e( 'Post Type Editor', 'ttbase-framework' ); ?></h2>
			<form method="post" action="options.php">
				<?php settings_fields( 'ttbase_framework_service_options' ); ?>
				<p><?php esc_html_e( 'If you change any slug\'s you must reset your permalinks to prevent 404 errors.', 'ttbase-framework' ); ?></p>
				<table class="form-table">
					<tr valign="top">
						<th scope="row"><?php esc_html_e( 'Admin Icon', 'ttbase-framework' ); ?></th>
						<td>
							<?php
							// Dashicons select
							$dashicons = array('admin-appearance','admin-collapse','admin-comments','admin-generic','admin-home','admin-media','admin-network','admin-page','admin-plugins','admin-settings','admin-site','admin-tools','admin-users','align-center','align-left','align-none','align-right','analytics','arrow-down','arrow-down-alt','arrow-down-alt2','arrow-left','arrow-left-alt','arrow-left-alt2','arrow-right','arrow-right-alt','arrow-right-alt2','arrow-up','arrow-up-alt','arrow-up-alt2','art','awards','backup','book','book-alt','businessman','calendar','camera','cart','category','chart-area','chart-bar','chart-line','chart-pie','clock','cloud','dashboard','desktop','dismiss','download','edit','editor-aligncenter','editor-alignleft','editor-alignright','editor-bold','editor-customchar','editor-distractionfree','editor-help','editor-indent','editor-insertmore','editor-italic','editor-justify','editor-kitchensink','editor-ol','editor-outdent','editor-paste-text','editor-paste-word','editor-quote','editor-removeformatting','editor-rtl','editor-spellcheck','editor-strikethrough','editor-textcolor','editor-ul','editor-underline','editor-unlink','editor-video','email','email-alt','exerpt-view','facebook','facebook-alt','feedback','flag','format-aside','format-audio','format-chat','format-gallery','format-image','format-links','format-quote','format-standard','format-status','format-video','forms','googleplus','groups','hammer','id','id-alt','image-crop','image-flip-horizontal','image-flip-vertical','image-rotate-left','image-rotate-right','images-alt','images-alt2','info','leftright','lightbulb','list-view','location','location-alt','lock','marker','menu','migrate','minus','networking','no','no-alt','performance','plus','service','post-status','pressthis','products','redo','rss','screenoptions','search','share','share-alt','share-alt2','share1','shield','shield-alt','slides','smartphone','smiley','sort','sos','star-empty','star-filled','star-half','tablet','tag','testimonial','translation','trash','twitter','undo','update','upload','vault','video-alt','video-alt2','video-alt3','visibility','welcome-add-page','welcome-comments','welcome-edit-page','welcome-learn-more','welcome-view-site','welcome-widgets-menus','wordpress','wordpress-alt','yes');
							$dashicons = array_combine( $dashicons, $dashicons ); ?>
							<select name="ttbase_framework_service_branding[service_admin_icon]">
								<option value=""><?php esc_html_e( 'Default', 'ttbase-framework' ); ?></option>
								<?php foreach ( $dashicons as $dashicon ) { ?>
									<option value="<?php echo esc_attr($dashicon); ?>" <?php selected( get_theme_mod( 'service_admin_icon' ), $dashicon, true ); ?>><?php echo esc_html($dashicon); ?></option>
								<?php } ?>
							</select>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php esc_html_e( 'Post Type: Name', 'ttbase-framework' ); ?></th>
						<td><input type="text" name="ttbase_framework_service_branding[service_labels]" value="<?php echo get_theme_mod( 'service_labels' ); ?>" /></td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php esc_html_e( 'Post Type: Singular Name', 'ttbase-framework' ); ?></th>
						<td><input type="text" name="ttbase_framework_service_branding[service_singular_name]" value="<?php echo get_theme_mod( 'service_singular_name' ); ?>" /></td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php esc_html_e( 'Post Type: Slug', 'ttbase-framework' ); ?></th>
						<td><input type="text" name="ttbase_framework_service_branding[service_slug]" value="<?php echo get_theme_mod( 'service_slug' ); ?>" /></td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php esc_html_e( 'Tags: Label', 'ttbase-framework' ); ?></th>
						<td><input type="text" name="ttbase_framework_service_branding[service_tag_labels]" value="<?php echo get_theme_mod( 'service_tag_labels' ); ?>" /></td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php esc_html_e( 'Tags: Slug', 'ttbase-framework' ); ?></th>
						<td><input type="text" name="ttbase_framework_service_branding[service_tag_slug]" value="<?php echo get_theme_mod( 'service_tag_slug' ); ?>" /></td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php esc_html_e( 'Categories: Label', 'ttbase-framework' ); ?></th>
						<td><input type="text" name="ttbase_framework_service_branding[service_cat_labels]" value="<?php echo get_theme_mod( 'service_cat_labels' ); ?>" /></td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php esc_html_e( 'Categories: Slug', 'ttbase-framework' ); ?></th>
						<td><input type="text" name="ttbase_framework_service_branding[service_cat_slug]" value="<?php echo get_theme_mod( 'service_cat_slug' ); ?>" /></td>
					</tr>
				</table>
				<?php submit_button(); ?>
			</form>
		</div>
	<?php }

	/**
	 * Registers a new custom service sidebar.
	 */
	public static function ttbase_framework_register_sidebar() {


		// Return if custom sidebar is disabled
		if ( ! get_theme_mod( 'service_custom_sidebar', true ) ) {
			return;
		}

		// Get post type object to name sidebar correctly
		$obj            = get_post_type_object( 'service' );
		$post_type_name = $obj->labels->name;

		// Register team_sidebar
		register_sidebar( array (
			'name'          => $post_type_name .' '. esc_html__( 'Sidebar', 'ttbase-framework' ),
			'id'            => 'sidebar-service',
			'before_widget' => '<aside id="%1$s" class="sidebar service widget %2$s">',
            'after_widget' => '</aside>',
            'before_title' => '<h5 class="title">',
            'after_title' => '</h5>',
		) );
	}

	/**
	 * Alter main sidebar to display service sidebar.
	 */
	public static function ttbase_framework_display_sidebar( $sidebar ) {
		if ( get_theme_mod( 'service_custom_sidebar', true ) && ( is_singular( 'service' ) || ttbase_framework_is_service_tax() ) ) {
			$sidebar = 'service_sidebar';
		}
		return $sidebar;
	}
}
$ttbase_framework_service_config = new TTBase_Framework_Service_Config;