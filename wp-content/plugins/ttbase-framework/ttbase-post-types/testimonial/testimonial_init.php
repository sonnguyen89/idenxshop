<?php
/**
 * Testimonial Post Type Configuration file
 *
 */

// Set global var
global $ttbase_framework_framework_testimonial_config;

// The class
class TTBase_Framework_Testimonial_Config {

	public function __construct() {

		// Adds the testimonial post type
		add_action( 'init', array( $this, 'ttbase_framework_register_post_type' ), 0 );

		// Adds the testimonial taxonomies
		add_action( 'init', array( $this, 'ttbase_framework_register_categories' ), 0 );

		// Adds columns in the admin view for testimonial
		add_filter( 'manage_edit-testimonial_columns', array( $this, 'ttbase_framework_edit_columns' ) );
		add_action( 'manage_testimonial_posts_custom_column', array( $this, 'ttbase_framework_column_display' ), 10, 2 );

		// Allows filtering of posts by taxonomy in the admin view
		add_action( 'restrict_manage_posts', array( $this, 'ttbase_framework_tax_filters' ) );

		// Create Editor for altering the post type arguments
		add_action( 'admin_menu', array( $this, 'ttbase_framework_add_page' ) );
		add_action( 'admin_init', array( $this,'ttbase_framework_register_page_options' ) );
		add_action( 'admin_notices', array( $this, 'ttbase_framework_notices' ) );
		
		// Adds the team custom sidebar
		add_filter( 'widgets_init', array( $this, 'ttbase_framework_register_sidebar' ), 10 );
		add_filter( 'ttbase_framework_get_sidebar', array( $this, 'ttbase_framework_display_sidebar' ), 11 );
		
	}
	
	/**
	 * Register post type
	 */
	public function ttbase_framework_register_post_type() {

		// Get values and sanitize
		$name                = get_theme_mod( 'testimonial_labels' );
		$name                = $name ? $name : esc_html__( 'Testimonials', 'ttbase-framework' );
		$singular_name       = get_theme_mod( 'testimonial_singular_name' );
		$singular_name       = $singular_name ? $singular_name : esc_html__( 'Testimonial Item', 'ttbase-framework' );
		$slug                = get_theme_mod( 'testimonial_slug' );
		$slug                = $slug ? $slug : 'testimonial';
		$menu_icon           = get_theme_mod( 'testimonial_admin_icon' );
		$menu_icon           = $menu_icon ? $menu_icon : 'testimonial';
		$testimonial_search = get_theme_mod( 'testimonial_search', true );
		$testimonial_search = ! $testimonial_search ? true : false;

		// Labels
		$labels = array(
			'name'               => $name,
			'singular_name'      => $singular_name,
			'add_new'            => esc_html__( 'Add New', 'ttbase-framework' ),
			'add_new_item'       => esc_html__( 'Add New Item', 'ttbase-framework' ),
			'edit_item'          => esc_html__( 'Edit Item', 'ttbase-framework' ),
			'new_item'           => esc_html__( 'Add New Testimonial Item', 'ttbase-framework' ),
			'view_item'          => esc_html__( 'View Item', 'ttbase-framework' ),
			'search_items'       => esc_html__( 'Search Items', 'ttbase-framework' ),
			'not_found'          => esc_html__( 'No Items Found', 'ttbase-framework' ),
			'not_found_in_trash' => esc_html__( 'No Items Found In Trash', 'ttbase-framework' )
		);

		// Args
		$args = array(
			'labels'              => $labels,
			'public'              => true,
			'capability_type'     => 'post',
			'has_archive'         => false,
			'menu_icon'           => 'dashicons-'. $menu_icon,
			'menu_position'       => 20,
			'exclude_from_search' => $testimonial_search,
			'rewrite'             => array(
				'slug'  => $slug,
			),
			'supports'            => array(
				'title',
				'editor',
				'thumbnail',
			),
		);

		// Apply filters
		$args = apply_filters( 'ttbase_framework_testimonial_args', $args );

		// Register the post type
		register_post_type( 'testimonial', $args );
		
		// add filter to style single template
		add_filter( 'single_template', array( $this, 'ttbase_framework_register_testimonial_template' ), 15 );

	}

	/**
	 * Register Testimonial category
	 *
	 * @since 2.0.0
	 */
	public function ttbase_framework_register_categories() {

		// Define and sanitize options
		$name = get_theme_mod( 'testimonial_cat_labels');
		$name = $name ? $name : esc_html__( 'Testimonial Categories', 'ttbase-framework' );
		$slug = get_theme_mod( 'testimonial_cat_slug' );
		$slug = $slug ? $slug : 'testimonial-category';

		// Define testimonial category labels
		$labels = array(
			'name'                       => $name,
			'singular_name'              => $name,
			'menu_name'                  => $name,
			'search_items'               => esc_html__( 'Search','ttbase-framework' ),
			'popular_items'              => esc_html__( 'Popular', 'ttbase-framework' ),
			'all_items'                  => esc_html__( 'All', 'ttbase-framework' ),
			'parent_item'                => esc_html__( 'Parent', 'ttbase-framework' ),
			'parent_item_colon'          => esc_html__( 'Parent', 'ttbase-framework' ),
			'edit_item'                  => esc_html__( 'Edit', 'ttbase-framework' ),
			'update_item'                => esc_html__( 'Update', 'ttbase-framework' ),
			'add_new_item'               => esc_html__( 'Add New', 'ttbase-framework' ),
			'new_item_name'              => esc_html__( 'New', 'ttbase-framework' ),
			'separate_items_with_commas' => esc_html__( 'Separate with commas', 'ttbase-framework' ),
			'add_or_remove_items'        => esc_html__( 'Add or remove', 'ttbase-framework' ),
			'choose_from_most_used'      => esc_html__( 'Choose from the most used', 'ttbase-framework' ),
		);

		// Define testimonial category arguments
		$args = array(
			'labels'            => $labels,
			'public'            => true,
			'show_in_nav_menus' => true,
			'show_ui'           => true,
			'show_tagcloud'     => true,
			'hierarchical'      => true,
			'query_var'         => true,
			'rewrite'           => array(
				'slug' => $slug,
			),
		);

		// Apply filters for child theming
		$args = apply_filters( 'ttbase_framework_taxonomy_testimonial_category_args', $args );

		// Register the testimonials category taxonomy
		register_taxonomy( 'testimonial_category', array( 'testimonial' ), $args );

	}
	
	/**
	 * Register Single Team Template.
	 */
	public function ttbase_framework_register_testimonial_template($single_template) {
		global $post;

		if ($post->post_type == 'testimonial') {
			$single_template = dirname( __FILE__ ) . '/single-testimonial.php';
		}
		return $single_template;	
	}

	/**
	 * Adds columns to the WP dashboard edit screen
	 */
	public function ttbase_framework_edit_columns( $columns ) {
		$columns['testimonial_category'] = esc_html__( 'Category', 'ttbase-framework' );
		return $columns;
	}
	
	/**
	 * Adds columns to the WP dashboard edit screen
	 */
	public function ttbase_framework_column_display( $column, $post_id ) {

		switch ( $column ) :

			// Display the testimonial categories in the column view
			case 'testimonial_category':

				if ( $category_list = get_the_term_list( $post_id, 'testimonial_category', '', ', ', '' ) ) {
					echo $category_list;
				} else {
					echo '&mdash;';
				}

			break;

		endswitch;

	}

	/**
	 * Adds taxonomy filters to the testimonial admin page
	 */
	function ttbase_framework_tax_filters() {
		global $typenow;

		// An array of all the testimonials you want to display. Use the testimonial name or slug
		$taxonomies = array( 'testimonial_category' );

		// must set this to the post type you want the filter(s) displayed on
		if ( 'testimonial' == $typenow ) {

			foreach ( $taxonomies as $tax_slug ) {
				$current_tax_slug   = isset( $_GET[$tax_slug] ) ? $_GET[$tax_slug] : false;
				$tax_obj            = get_taxonomy( $tax_slug );
				$tax_name           = $tax_obj->labels->name;
				$terms              = get_terms( $tax_slug );
				if ( count( $terms ) > 0 ) {
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
	 * Add sub menu page for the Testimonial Post Type Editor
	 */
	function ttbase_framework_add_page() {
		add_submenu_page(
			'edit.php?post_type=testimonial',
			esc_html__( 'Post Type Editor', 'ttbase-framework' ),
			esc_html__( 'Post Type Editor', 'ttbase-framework' ),
			'administrator',
			'ttbase-testimonial-editor',
			array( $this, 'ttbase_framework_create_admin_page' )
		);
	}

	/**
	 * Function that will register the testimonial editor admin page
	 */
	function ttbase_framework_register_page_options() {
		register_setting( 'ttbase_framework_testimonial_options', 'ttbase_framework_testimonial_branding', array( $this, 'ttbase_framework_sanitize' ) );
	}

	/**
	 * Displays saved message after settings are successfully saved
	 */
	function ttbase_framework_notices() {
		settings_errors( 'ttbase_framework_testimonial_editor_page_notices' );
	}

	/**
	 * Sanitizes input and saves theme_mods
	 */
	function ttbase_framework_sanitize( $options ) {

		// Save values to theme mod
		if ( ! empty ( $options ) ) {
			foreach( $options as $key => $value ) {
				if ( $value ) {
					set_theme_mod( $key, $value );
				}
			}
		}

		// Add notice
		add_settings_error(
			'ttbase_framework_testimonial_editor_page_notices',
			esc_attr( 'settings_updated' ),
			esc_html__( 'Settings saved.', 'ttbase-framework' ),
			'updated'
		);

		// Lets delete the options as we are saving them into theme mods
		$options = '';
		return $options;
	}
	
	/**
	 * Registers a new custom team sidebar.
	 */
	public static function ttbase_framework_register_sidebar() {


		// Return if custom sidebar is disabled
		if ( ! get_theme_mod( 'testimonial_custom_sidebar', true ) ) {
			return;
		}

		// Get post type object to name sidebar correctly
		$obj            = get_post_type_object( 'testimonial' );
		$post_type_name = $obj->labels->name;

		// Register team_sidebar
		register_sidebar( array (
			'name'          => $post_type_name .' '. esc_html__( 'Sidebar', 'ttbase-framework' ),
			'id'            => 'sidebar-testimonial',
			'before_widget' => '<aside id="%1$s" class="sidebar testimonial widget %2$s">',
            'after_widget' => '</aside>',
            'before_title' => '<h5 class="title">',
            'after_title' => '</h5>',
		) );
	}

	/**
	 * Alter main sidebar to display team sidebar.
	 *
	 * @since 2.0.0
	 */
	public static function ttbase_framework_display_sidebar( $sidebar ) {
		if ( get_theme_mod( 'testimonial_custom_sidebar', true ) && ( is_singular( 'testimonial' ) || ttbase_framework_is_testimonial_tax() ) ) {
			$sidebar = 'testimonial_sidebar';
		}
		return $sidebar;
	}

	/**
	 * Output for the actual Testimonial Editor admin page
	 */
	function ttbase_framework_create_admin_page() { ?>
		<div class="wrap">
			<h2><?php esc_html_e( 'Post Type Editor', 'ttbase-framework' ); ?></h2>
			<form method="post" action="options.php">
				<?php settings_fields( 'ttbase_framework_testimonial_options' ); ?>
				<p><?php esc_html_e( 'If you change any slug\'s you must reset your permalinks to prevent 404 errors.', 'ttbase-framework' ); ?></p>
				<table class="form-table">
					<tr valign="top">
						<th scope="row"><?php esc_html_e( 'Admin Icon', 'ttbase-framework' ); ?></th>
						<td>
							<?php
							// Dashicons select
							$dashicons = array('admin-appearance','admin-collapse','admin-comments','admin-generic','admin-home','admin-media','admin-network','admin-page','admin-plugins','admin-settings','admin-site','admin-tools','admin-users','align-center','align-left','align-none','align-right','analytics','arrow-down','arrow-down-alt','arrow-down-alt2','arrow-left','arrow-left-alt','arrow-left-alt2','arrow-right','arrow-right-alt','arrow-right-alt2','arrow-up','arrow-up-alt','arrow-up-alt2','art','awards','backup','book','book-alt','businessman','calendar','camera','cart','category','chart-area','chart-bar','chart-line','chart-pie','clock','cloud','dashboard','desktop','dismiss','download','edit','editor-aligncenter','editor-alignleft','editor-alignright','editor-bold','editor-customchar','editor-distractionfree','editor-help','editor-indent','editor-insertmore','editor-italic','editor-justify','editor-kitchensink','editor-ol','editor-outdent','editor-paste-text','editor-paste-word','editor-quote','editor-removeformatting','editor-rtl','editor-spellcheck','editor-strikethrough','editor-textcolor','editor-ul','editor-underline','editor-unlink','editor-video','email','email-alt','exerpt-view','facebook','facebook-alt','feedback','flag','format-aside','format-audio','format-chat','format-gallery','format-image','format-links','format-quote','format-standard','format-status','format-video','forms','googleplus','groups','hammer','id','id-alt','image-crop','image-flip-horizontal','image-flip-vertical','image-rotate-left','image-rotate-right','images-alt','images-alt2','info','leftright','lightbulb','list-view','location','location-alt','lock','marker','menu','migrate','minus','networking','no','no-alt','performance','plus','testimonials','post-status','pressthis','products','redo','rss','screenoptions','search','share','share-alt','share-alt2','share1','shield','shield-alt','slides','smartphone','smiley','sort','sos','star-empty','star-filled','star-half','tablet','tag','testimonial','translation','trash','twitter','undo','update','upload','vault','video-alt','video-alt2','video-alt3','visibility','welcome-add-page','welcome-comments','welcome-edit-page','welcome-learn-more','welcome-view-site','welcome-widgets-menus','wordpress','wordpress-alt','yes');
							$dashicons = array_combine( $dashicons, $dashicons ); ?>
							<select name="ttbase_framework_testimonial_branding[testimonial_admin_icon]">
								<option value="0"><?php esc_html_e( 'Select', 'ttbase-framework' ); ?></option>
								<?php foreach ( $dashicons as $dashicon ) { ?>
									<option value="<?php echo esc_attr($dashicon); ?>" <?php selected( get_theme_mod( 'testimonial_admin_icon' ), $dashicon, true ); ?>><?php echo esc_html($dashicon); ?></option>
								<?php } ?>
							</select>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php esc_html_e( 'Post Type: Name', 'ttbase-framework' ); ?></th>
						<td><input type="text" name="ttbase_framework_testimonial_branding[testimonial_labels]" value="<?php echo get_theme_mod( 'testimonial_labels' ); ?>" /></td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php esc_html_e( 'Post Type: Singular Name', 'ttbase-framework' ); ?></th>
						<td><input type="text" name="ttbase_framework_testimonial_branding[testimonial_singular_name]" value="<?php echo get_theme_mod( 'testimonial_singular_name' ); ?>" /></td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php esc_html_e( 'Post Type: Slug', 'ttbase-framework' ); ?></th>
						<td><input type="text" name="ttbase_framework_testimonial_branding[testimonial_slug]" value="<?php echo get_theme_mod( 'testimonial_slug' ); ?>" /></td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php esc_html_e( 'Categories: Label', 'ttbase-framework' ); ?></th>
						<td><input type="text" name="ttbase_framework_testimonial_branding[testimonial_cat_labels]" value="<?php echo get_theme_mod( 'testimonial_cat_labels' ); ?>" /></td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php esc_html_e( 'Categories: Slug', 'ttbase-framework' ); ?></th>
						<td><input type="text" name="ttbase_framework_testimonial_branding[testimonial_cat_slug]" value="<?php echo get_theme_mod( 'testimonial_cat_slug' ); ?>" /></td>
					</tr>
				</table>
				<?php submit_button(); ?>
			</form>
		</div>
	<?php }

}
$ttbase_framework_testimonial_config = new TTBase_Framework_Testimonial_Config;