<?php
/**
 * Trainer Post Type Configuration file
 */

// Set global var
global $gym_ext_trainer_config;

// The class
class GymX_Ext_Trainer_Config {
	private $label;

	public function __construct() {

		// Update vars
		$this->label = get_theme_mod( 'trainers_labels' );
		$this->label = $this->label ? $this->label : esc_html_x( 'Trainers', 'Trainers Post Type Label', 'ttbase-framework' );


		// Adds the trainers post type
		add_action( 'init', array( $this, 'gym_ext_register_post_type' ), 0 );

		// Adds the trainers taxonomies
		add_action( 'init', array( $this, 'gym_ext_register_tags' ), 5 );
		add_action( 'init', array( $this, 'gym_ext_register_categories' ), 10 );

		// Adds columns in the admin view for taxonomies
		add_filter( 'manage_edit-trainers_columns', array( $this, 'gym_ext_edit_columns' ) );
		add_action( 'manage_trainers_posts_custom_column', array( $this, 'gym_ext_column_display' ), 10, 2 );

		// Allows filtering of posts by taxonomy in the admin view
		add_action( 'restrict_manage_posts', array( $this, 'gym_ext_tax_filters' ) );

		// Create Editor for altering the post type arguments
		add_action( 'admin_menu', array( $this, 'gym_ext_add_page' ) );
		add_action( 'admin_init', array( $this,'gym_ext_register_page_options' ) );
		add_action( 'admin_notices', array( $this, 'gym_ext_notices' ) );
		
	}
	
	/**
	 * Register post type.
	 */
	public function gym_ext_register_post_type() {

		// Get values and sanitize
		$name           = $this->label;
		$singular_name  = get_theme_mod( 'trainers_singular_name' );
		$singular_name  = $singular_name ? $singular_name : esc_html__( 'Trainer', 'ttbase-framework' );
		$slug           = get_theme_mod( 'trainers_slug' );
		$slug           = $slug ? $slug : 'trainer';
		$menu_icon      = get_theme_mod( 'trainers_admin_icon' );
		$menu_icon      = $menu_icon ? $menu_icon : 'groups';
		$trainers_search   = get_theme_mod( 'trainers_search', true );
		$trainers_search   = ! $trainers_search ? true : false;

		// Labels
		$labels = array(
			'name' => $name,
			'singular_name' => $singular_name,
			'add_new' => esc_html__( 'Add New', 'ttbase-framework' ),
			'add_new_item' => esc_html__( 'Add New Trainer', 'ttbase-framework' ),
			'edit_item' => esc_html__( 'Edit Trainer', 'ttbase-framework' ),
			'new_item' => esc_html__( 'Add New Trainer', 'ttbase-framework' ),
			'view_item' => esc_html__( 'View Trainer', 'ttbase-framework' ),
			'search_items' => esc_html__( 'Search Trainers', 'ttbase-framework' ),
			'not_found' => esc_html__( 'No Trainers Found', 'ttbase-framework' ),
			'not_found_in_trash' => esc_html__( 'No Trainers Found In Trash', 'ttbase-framework' )
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
			'menu_position' => 35,
			'exclude_from_search' => $trainers_search,
		);

		// Apply filters
		$args = apply_filters( 'gym_ext_trainers_args', $args );

		// Register the post type
		register_post_type( 'trainers', $args );
		
		// add filter to style single template
		add_filter( 'single_template', array( $this, 'gym_ext_register_trainer_template' ), 15 );

	}

	/**
	 * Register Trainers tags.
	 */
	public function gym_ext_register_tags() {

		// Define and sanitize options
		$name = get_theme_mod( 'trainers_tag_labels');
		$name = $name ? $name : esc_html__( 'Trainers Tags', 'ttbase-framework' );
		$slug = get_theme_mod( 'trainers_tag_slug' );
		$slug = $slug ? $slug : 'trainers-tag';

		// Define Trainers tag labels
		$labels = array(
			'name' => $name,
			'singular_name' => $name,
			'menu_name' => $name,
			'search_items' => esc_html__( 'Search Trainers Tags', 'ttbase-framework' ),
			'popular_items' => esc_html__( 'Popular Trainers Tags', 'ttbase-framework' ),
			'all_items' => esc_html__( 'All Trainers Tags', 'ttbase-framework' ),
			'parent_item' => esc_html__( 'Parent Trainers Tag', 'ttbase-framework' ),
			'parent_item_colon' => esc_html__( 'Parent Trainers Tag:', 'ttbase-framework' ),
			'edit_item' => esc_html__( 'Edit Trainers Tag', 'ttbase-framework' ),
			'update_item' => esc_html__( 'Update Trainers Tag', 'ttbase-framework' ),
			'add_new_item' => esc_html__( 'Add New Trainers Tag', 'ttbase-framework' ),
			'new_item_name' => esc_html__( 'New Trainers Tag Name', 'ttbase-framework' ),
			'separate_items_with_commas' => esc_html__( 'Separate Trainers tags with commas', 'ttbase-framework' ),
			'add_or_remove_items' => esc_html__( 'Add or remove Trainers tags', 'ttbase-framework' ),
			'choose_from_most_used' => esc_html__( 'Choose from the most used Trainers tags', 'ttbase-framework' ),
		);

		// Define trainers tag arguments
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
		$args = apply_filters( 'gym_ext_taxonomy_trainers_tag_args', $args );

		// Register the trainers tag taxonomy
		register_taxonomy( 'trainers_tag', array( 'trainers' ), $args );

	}
	
	/**
	 * Register Single Trainer Template.
	 */
	public function gym_ext_register_trainer_template($single_template) {
		global $post;

		if ($post->post_type == 'trainers') {
			$single_template = dirname( __FILE__ ) . '/single-trainer.php';
		}
		return $single_template;	
	}
	
	/**
	 * Register Trainers category.
	 */
	public function gym_ext_register_categories() {

		// Define and sanitize options
		$name = get_theme_mod( 'trainers_cat_labels');
		$name = $name ? $name : esc_html__( 'Trainers Categories', 'ttbase-framework' );
		$slug = get_theme_mod( 'trainers_cat_slug' );
		$slug = $slug ? $slug : 'trainers-category';

		// Define trainers category labels
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

		// Define trainers category arguments
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
		$args = apply_filters( 'gym_ext_taxonomy_trainers_category_args', $args );

		// Register the trainers category taxonomy
		register_taxonomy( 'trainers_category', array( 'trainers' ), $args );

	}


	/**
	 * Adds columns to the WP dashboard edit screen.
	 */
	public static function gym_ext_edit_columns( $columns ) {
		$columns['trainers_category'] = esc_html__( 'Category', 'ttbase-framework' );
		$columns['trainers_tag']      = esc_html__( 'Tags', 'ttbase-framework' );
		return $columns;
	}
	

	/**
	 * Adds columns to the WP dashboard edit screen.
	 */
	public static function gym_ext_column_display( $column, $post_id ) {

		switch ( $column ) :

			// Display the trainers categories in the column view
			case 'trainers_category':

				if ( $category_list = get_the_term_list( $post_id, 'trainers_category', '', ', ', '' ) ) {
					echo $category_list;
				} else {
					echo '&mdash;';
				}

			break;

			// Display the trainers tags in the column view
			case 'trainers_tag':

				if ( $tag_list = get_the_term_list( $post_id, 'trainers_tag', '', ', ', '' ) ) {
					echo $tag_list;
				} else {
					echo '&mdash;';
				}

			break;

		endswitch;

	}

	/**
	 * Adds taxonomy filters to the trainers admin page.
	 */
	public static function gym_ext_tax_filters() {
		global $typenow;

		// An array of all the taxonomyies you want to display. Use the taxonomy name or slug
		$taxonomies = array( 'trainers_category', 'trainers_tag' );

		// must set this to the post type you want the filter(s) displayed on
		if ( 'trainers' == $typenow ) {

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
	 * Add sub menu page for the Team Editor.
	 */
	public function gym_ext_add_page() {
		add_submenu_page(
			'edit.php?post_type=trainers',
			esc_html__( 'Post Type Editor', 'ttbase-framework' ),
			esc_html__( 'Post Type Editor', 'ttbase-framework' ),
			'administrator',
			'ttbase-trainers-editor',
			array( $this, 'gym_ext_create_admin_page' )
		);
	}

	/**
	 * Function that will register the trainers editor admin page.
	 */
	public function gym_ext_register_page_options() {
		register_setting( 'gym_ext_trainers_options', 'gym_ext_trainers_branding', array( $this, 'gym_ext_sanitize' ) );
	}

	/**
	 * Displays saved message after settings are successfully saved.
	 */
	public static function gym_ext_notices() {
		settings_errors( 'gym_ext_trainers_editor_page_notices' );
	}

	/**
	 * Sanitizes input and saves theme_mods.
	 */
	public static function gym_ext_sanitize( $options ) {

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
			'gym_ext_trainers_editor_page_notices',
			esc_attr( 'settings_updated' ),
			esc_html__( 'Settings saved.', 'ttbase-framework' ),
			'updated'
		);

		// Lets delete the options as we are saving them into theme mods
		$options = '';
		return $options;
	}

	/**
	 * Output for the actual Trainers Editor admin page.
	 */
	public function gym_ext_create_admin_page() { ?>
		<div class="wrap">
			<h2><?php esc_html_e( 'Post Type Editor', 'ttbase-framework' ); ?></h2>
			<form method="post" action="options.php">
				<?php settings_fields( 'gym_ext_trainers_options' ); ?>
				<p><?php esc_html_e( 'If you change any slug\'s you must reset your permalinks to prevent 404 errors.', 'ttbase-framework' ); ?></p>
				<table class="form-table">
					<tr valign="top">
						<th scope="row"><?php esc_html_e( 'Admin Icon', 'ttbase-framework' ); ?></th>
						<td>
							<?php
							// Dashicons select
							$dashicons = array('admin-appearance','admin-collapse','admin-comments','admin-generic','admin-home','admin-media','admin-network','admin-page','admin-plugins','admin-settings','admin-site','admin-tools','admin-users','align-center','align-left','align-none','align-right','analytics','arrow-down','arrow-down-alt','arrow-down-alt2','arrow-left','arrow-left-alt','arrow-left-alt2','arrow-right','arrow-right-alt','arrow-right-alt2','arrow-up','arrow-up-alt','arrow-up-alt2','art','awards','backup','book','book-alt','businessman','calendar','camera','cart','category','chart-area','chart-bar','chart-line','chart-pie','clock','cloud','dashboard','desktop','dismiss','download','edit','editor-aligncenter','editor-alignleft','editor-alignright','editor-bold','editor-customchar','editor-distractionfree','editor-help','editor-indent','editor-insertmore','editor-italic','editor-justify','editor-kitchensink','editor-ol','editor-outdent','editor-paste-text','editor-paste-word','editor-quote','editor-removeformatting','editor-rtl','editor-spellcheck','editor-strikethrough','editor-textcolor','editor-ul','editor-underline','editor-unlink','editor-video','email','email-alt','exerpt-view','facebook','facebook-alt','feedback','flag','format-aside','format-audio','format-chat','format-gallery','format-image','format-links','format-quote','format-standard','format-status','format-video','forms','googleplus','groups','hammer','id','id-alt','image-crop','image-flip-horizontal','image-flip-vertical','image-rotate-left','image-rotate-right','images-alt','images-alt2','info','leftright','lightbulb','list-view','location','location-alt','lock','marker','menu','migrate','minus','networking','no','no-alt','performance','plus','trainers','post-status','pressthis','products','redo','rss','screenoptions','search','share','share-alt','share-alt2','share1','shield','shield-alt','slides','smartphone','smiley','sort','sos','star-empty','star-filled','star-half','tablet','tag','testimonial','translation','trash','twitter','undo','update','upload','vault','video-alt','video-alt2','video-alt3','visibility','welcome-add-page','welcome-comments','welcome-edit-page','welcome-learn-more','welcome-view-site','welcome-widgets-menus','wordpress','wordpress-alt','yes');
							$dashicons = array_combine( $dashicons, $dashicons ); ?>
							<select name="gym_ext_trainers_branding[trainers_admin_icon]">
								<option value=""><?php esc_html_e( 'Default', 'ttbase-framework' ); ?></option>
								<?php foreach ( $dashicons as $dashicon ) { ?>
									<option value="<?php echo esc_attr($dashicon); ?>" <?php selected( get_theme_mod( 'trainers_admin_icon' ), $dashicon, true ); ?>><?php echo esc_html($dashicon); ?></option>
								<?php } ?>
							</select>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php esc_html_e( 'Post Type: Name', 'ttbase-framework' ); ?></th>
						<td><input type="text" name="gym_ext_trainers_branding[trainers_labels]" value="<?php echo get_theme_mod( 'trainers_labels' ); ?>" /></td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php esc_html_e( 'Post Type: Singular Name', 'ttbase-framework' ); ?></th>
						<td><input type="text" name="gym_ext_trainers_branding[trainers_singular_name]" value="<?php echo get_theme_mod( 'trainers_singular_name' ); ?>" /></td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php esc_html_e( 'Post Type: Slug', 'ttbase-framework' ); ?></th>
						<td><input type="text" name="gym_ext_trainers_branding[trainers_slug]" value="<?php echo get_theme_mod( 'trainers_slug' ); ?>" /></td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php esc_html_e( 'Tags: Label', 'ttbase-framework' ); ?></th>
						<td><input type="text" name="gym_ext_trainers_branding[trainers_tag_labels]" value="<?php echo get_theme_mod( 'trainers_tag_labels' ); ?>" /></td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php esc_html_e( 'Tags: Slug', 'ttbase-framework' ); ?></th>
						<td><input type="text" name="gym_ext_trainers_branding[trainers_tag_slug]" value="<?php echo get_theme_mod( 'trainers_tag_slug' ); ?>" /></td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php esc_html_e( 'Categories: Label', 'ttbase-framework' ); ?></th>
						<td><input type="text" name="gym_ext_trainers_branding[trainers_cat_labels]" value="<?php echo get_theme_mod( 'trainers_cat_labels' ); ?>" /></td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php esc_html_e( 'Categories: Slug', 'ttbase-framework' ); ?></th>
						<td><input type="text" name="gym_ext_trainers_branding[trainers_cat_slug]" value="<?php echo get_theme_mod( 'trainers_cat_slug' ); ?>" /></td>
					</tr>
				</table>
				<?php submit_button(); ?>
			</form>
		</div>
	<?php }

}
$gym_ext_trainer_config = new GymX_Ext_Trainer_Config;