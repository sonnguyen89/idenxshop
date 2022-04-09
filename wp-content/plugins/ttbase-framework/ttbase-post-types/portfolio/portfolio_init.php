<?php
/**
 * Portfolio Post Type Configuration file
 */

// Set global var
global $ttbase_framework_portfolio_config;

// The class
class TTBase_Framework_Portfolio_Config {
	private $label;

	public function __construct() {

		// Update vars
		$this->label = get_theme_mod( 'portfolio_labels' );
		$this->label = $this->label ? $this->label : esc_html_x( 'Portfolio', 'Portfolio Post Type Label', 'ttbase-framework' );


		// Adds the portfolio post type
		add_action( 'init', array( $this, 'ttbase_framework_register_post_type' ), 0 );

		// Adds the portfolio taxonomies
		if ( get_theme_mod( 'portfolio_tags', true ) ) {
			add_action( 'init', array( $this, 'ttbase_framework_register_tags' ), 0 );
		}
		if ( get_theme_mod( 'portfolio_categories', true ) ) {
			add_action( 'init', array( $this, 'ttbase_framework_register_categories' ), 0 );
		}

		// Adds columns in the admin view for taxonomies
		add_filter( 'manage_edit-portfolio_columns', array( $this, 'ttbase_framework_edit_columns' ) );
		add_action( 'manage_portfolio_posts_custom_column', array( $this, 'ttbase_framework_column_display' ), 10, 2 );

		// Allows filtering of posts by taxonomy in the admin view
		add_action( 'restrict_manage_posts', array( $this, 'ttbase_framework_tax_filters' ) );

		// Create Editor for altering the post type arguments
		add_action( 'admin_menu', array( $this, 'ttbase_framework_add_page' ) );
		add_action( 'admin_init', array( $this,'ttbase_framework_register_page_options' ) );
		add_action( 'admin_notices', array( $this, 'ttbase_framework_notices' ) );

		// Adds the portfolio custom sidebar
		add_filter( 'widgets_init', array( $this, 'ttbase_framework_register_sidebar' ) );
		add_filter( 'ttbase_get_sidebar', array( $this, 'ttbase_framework_display_sidebar' ) );
	}
	
	/**
	 * Register post type.
	 */
	public function ttbase_framework_register_post_type() {

		// Get values and sanitize
		$name             = $this->label;
		$singular_name    = get_theme_mod( 'portfolio_singular_name' );
		$singular_name    = $singular_name ? $singular_name : esc_html__( 'Portfolio Item', 'ttbase-framework' );
		$slug             = get_theme_mod( 'portfolio_slug' );
		$slug             = $slug ? $slug : 'portfolio-item';
		$menu_icon        = get_theme_mod( 'portfolio_admin_icon' );
		$menu_icon        = $menu_icon ? $menu_icon : 'portfolio';
		$portfolio_search = get_theme_mod( 'portfolio_search', true );
		$portfolio_search = ! $portfolio_search ? true : false;

		// Args
		$args = array(
			'labels' => array(
				'name' => $name,
				'singular_name' => $singular_name,
				'add_new' => esc_html__( 'Add New', 'ttbase-framework' ),
				'add_new_item' => esc_html__( 'Add New Item', 'ttbase-framework' ),
				'edit_item' => esc_html__( 'Edit Item', 'ttbase-framework' ),
				'new_item' => esc_html__( 'Add New Item', 'ttbase-framework' ),
				'view_item' => esc_html__( 'View Item', 'ttbase-framework' ),
				'search_items' => esc_html__( 'Search Items', 'ttbase-framework' ),
				'not_found' => esc_html__( 'No Items Found', 'ttbase-framework' ),
				'not_found_in_trash' => esc_html__( 'No Items Found In Trash', 'ttbase-framework' )
			),
			'public' => true,
			'capability_type' => 'post',
			'has_archive' => false,
			'menu_icon' => 'dashicons-'. $menu_icon,
			'menu_position' => 20,
			'exclude_from_search' => $portfolio_search,
			'rewrite' => array(
				'slug' => $slug,
			),
			'supports' => array(
				'title',
				'editor',
				'thumbnail',
				'comments',
				'post-formats',
			),
		);

		// Register the post type
		register_post_type( 'portfolio', apply_filters( 'ttbase_framework_portfolio_args', $args ) );
		
		// add filter to style single template
		add_filter( 'single_template', array( $this, 'ttbase_framework_register_portfolio_template' ), 15 );

	}

	/**
	 * Register Single Portfolio Template.
	 */
	public function ttbase_framework_register_portfolio_template($single_template) {
		global $post;

		if ($post->post_type == 'portfolio') {
			$single_template = dirname( __FILE__ ) . '/single-portfolio.php';
		}
		return $single_template;	
	}
	
	/**
	 * Register Portfolio tags.
	 */
	public static function ttbase_framework_register_tags() {

		// Define and sanitize options
		$name = get_theme_mod( 'portfolio_tag_labels');
		$name = $name ? $name : esc_html__( 'Portfolio Tags', 'ttbase-framework' );
		$slug = get_theme_mod( 'portfolio_tag_slug' );
		$slug = $slug ? $slug : 'portfolio-tag';

		// Define portfolio tag arguments
		$args = array(
			'labels' => array(
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
			),
			'public' => true,
			'show_in_nav_menus' => true,
			'show_ui' => true,
			'show_tagcloud' => true,
			'hierarchical' => false,
			'rewrite' => array(
				'slug'  => $slug,
			),
			'query_var' => true,
		);

		// Apply filters
		$args = apply_filters( 'ttbase_framework_taxonomy_portfolio_tag_args', $args );

		// Register the portfolio tag taxonomy
		register_taxonomy( 'portfolio_tag', array( 'portfolio' ), $args );

	}

	/**
	 * Register Portfolio category.
	 */
	public static function ttbase_framework_register_categories() {

		// Define and sanitize options
		$name = get_theme_mod( 'portfolio_cat_labels');
		$name = $name ? $name : esc_html__( 'Portfolio Categories', 'ttbase-framework' );
		$slug = get_theme_mod( 'portfolio_cat_slug' );
		$slug = $slug ? $slug : 'portfolio-category';

		// Define portfolio category arguments
		$args = array(
			'labels' => array(
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
			),
			'public' => true,
			'show_in_nav_menus' => true,
			'show_ui' => true,
			'show_tagcloud' => true,
			'hierarchical' => true,
			'rewrite' => array( 'slug' => $slug ),
			'query_var' => true
		);

		// Apply filters
		$args = apply_filters( 'ttbase_framework_taxonomy_portfolio_category_args', $args );

		// Register the portfolio category taxonomy
		register_taxonomy( 'portfolio_category', array( 'portfolio' ), $args );

	}

	/**
	 * Adds columns to the WP dashboard edit screen.
	 */
	public static function ttbase_framework_edit_columns( $columns ) {
		if ( taxonomy_exists( 'portfolio_category' ) ) {
			$columns['portfolio_category'] = esc_html__( 'Category', 'ttbase-framework' );
		}
		if ( taxonomy_exists( 'portfolio_tag' ) ) {
			$columns['portfolio_tag']      = esc_html__( 'Tags', 'ttbase-framework' );
		}
		return $columns;
	}
	

	/**
	 * Adds columns to the WP dashboard edit screen.
	 */
	public static function ttbase_framework_column_display( $column, $post_id ) {

		switch ( $column ) :

			// Display the portfolio categories in the column view
			case 'portfolio_category':

				if ( $category_list = get_the_term_list( $post_id, 'portfolio_category', '', ', ', '' ) ) {
					echo $category_list;
				} else {
					echo '&mdash;';
				}

			break;

			// Display the portfolio tags in the column view
			case 'portfolio_tag':

				if ( $tag_list = get_the_term_list( $post_id, 'portfolio_tag', '', ', ', '' ) ) {
					echo $tag_list;
				} else {
					echo '&mdash;';
				}

			break;

		endswitch;

	}

	/**
	 * Adds taxonomy filters to the portfolio admin page.
	 */
	public static function ttbase_framework_tax_filters() {
		global $typenow;
		$taxonomies = array( 'portfolio_category', 'portfolio_tag' );
		if ( 'portfolio' == $typenow ) {
			foreach ( $taxonomies as $tax_slug ) {
				if ( ! taxonomy_exists( $tax_slug ) ) {
					continue;
				}
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
	 * Add sub menu page for the Portfolio Editor.
	 *
	 */
	public function ttbase_framework_add_page() {
		add_submenu_page(
			'edit.php?post_type=portfolio',
			esc_html__( 'Post Type Editor', 'ttbase-framework' ),
			esc_html__( 'Post Type Editor', 'ttbase-framework' ),
			'administrator',
			'ttbase-portfolio-editor',
			array( $this, 'ttbase_framework_create_admin_page' )
		);
	}

	/**
	 * Function that will register the portfolio editor admin page.
	 */
	public function ttbase_framework_register_page_options() {
		register_setting( 'ttbase_framework_portfolio_options', 'ttbase_framework_portfolio_branding', array( $this, 'ttbase_framework_sanitize' ) );
	}

	/**
	 * Displays saved message after settings are successfully saved
	 */
	public static function ttbase_framework_notices() {
		settings_errors( 'ttbase_framework_portfolio_editor_page_notices' );
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
			'ttbase_framework_portfolio_editor_page_notices',
			esc_attr( 'settings_updated' ),
			esc_html__( 'Settings saved.', 'ttbase-framework' ),
			'updated'
		);

		// Lets delete the options as we are saving them into theme mods
		$options = '';
		return $options;
	}

	/**
	 * Output for the actual Portfolio Editor admin page.
	 */
	public static function ttbase_framework_create_admin_page() { ?>
		<div class="wrap">
			<h2><?php esc_html_e( 'Post Type Editor', 'ttbase-framework' ); ?></h2>
			<form method="post" action="options.php">
				<?php settings_fields( 'ttbase_framework_portfolio_options' ); ?>
				<p><?php esc_html_e( 'If you change any slug\'s you must reset your permalinks to prevent 404 errors.', 'ttbase-framework' ); ?></p>
				<table class="form-table">
					<tr valign="top">
						<th scope="row"><?php esc_html_e( 'Admin Icon', 'ttbase-framework' ); ?></th>
						<td>
							<?php
							// Dashicons select
							$dashicons = array('admin-appearance','admin-collapse','admin-comments','admin-generic','admin-home','admin-media','admin-network','admin-page','admin-plugins','admin-settings','admin-site','admin-tools','admin-users','align-center','align-left','align-none','align-right','analytics','arrow-down','arrow-down-alt','arrow-down-alt2','arrow-left','arrow-left-alt','arrow-left-alt2','arrow-right','arrow-right-alt','arrow-right-alt2','arrow-up','arrow-up-alt','arrow-up-alt2','art','awards','backup','book','book-alt','businessman','calendar','camera','cart','category','chart-area','chart-bar','chart-line','chart-pie','clock','cloud','dashboard','desktop','dismiss','download','edit','editor-aligncenter','editor-alignleft','editor-alignright','editor-bold','editor-customchar','editor-distractionfree','editor-help','editor-indent','editor-insertmore','editor-italic','editor-justify','editor-kitchensink','editor-ol','editor-outdent','editor-paste-text','editor-paste-word','editor-quote','editor-removeformatting','editor-rtl','editor-spellcheck','editor-strikethrough','editor-textcolor','editor-ul','editor-underline','editor-unlink','editor-video','email','email-alt','exerpt-view','facebook','facebook-alt','feedback','flag','format-aside','format-audio','format-chat','format-gallery','format-image','format-links','format-quote','format-standard','format-status','format-video','forms','googleplus','groups','hammer','id','id-alt','image-crop','image-flip-horizontal','image-flip-vertical','image-rotate-left','image-rotate-right','images-alt','images-alt2','info','leftright','lightbulb','list-view','location','location-alt','lock','marker','menu','migrate','minus','networking','no','no-alt','performance','plus','portfolio','post-status','pressthis','products','redo','rss','screenoptions','search','share','share-alt','share-alt2','share1','shield','shield-alt','slides','smartphone','smiley','sort','sos','star-empty','star-filled','star-half','tablet','tag','testimonial','translation','trash','twitter','undo','update','upload','vault','video-alt','video-alt2','video-alt3','visibility','welcome-add-page','welcome-comments','welcome-edit-page','welcome-learn-more','welcome-view-site','welcome-widgets-menus','wordpress','wordpress-alt','yes');
							$dashicons = array_combine( $dashicons, $dashicons ); ?>
							<select name="ttbase_framework_portfolio_branding[portfolio_admin_icon]">
								<option value=""><?php esc_html_e( 'Default', 'ttbase-framework' ); ?></option>
								<?php foreach ( $dashicons as $dashicon ) { ?>
									<option value="<?php echo esc_attr($dashicon); ?>" <?php selected( get_theme_mod( 'portfolio_admin_icon' ), $dashicon, true ); ?>><?php echo esc_html($dashicon); ?></option>
								<?php } ?>
							</select>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php esc_html_e( 'Post Type: Name', 'ttbase-framework' ); ?></th>
						<td><input type="text" name="ttbase_framework_portfolio_branding[portfolio_labels]" value="<?php echo get_theme_mod( 'portfolio_labels' ); ?>" /></td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php esc_html_e( 'Post Type: Singular Name', 'ttbase-framework' ); ?></th>
						<td><input type="text" name="ttbase_framework_portfolio_branding[portfolio_singular_name]" value="<?php echo get_theme_mod( 'portfolio_singular_name' ); ?>" /></td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php esc_html_e( 'Post Type: Slug', 'ttbase-framework' ); ?></th>
						<td><input type="text" name="ttbase_framework_portfolio_branding[portfolio_slug]" value="<?php echo get_theme_mod( 'portfolio_slug' ); ?>" /></td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php esc_html_e( 'Tags: Label', 'ttbase-framework' ); ?></th>
						<td><input type="text" name="ttbase_framework_portfolio_branding[portfolio_tag_labels]" value="<?php echo get_theme_mod( 'portfolio_tag_labels' ); ?>" /></td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php esc_html_e( 'Tags: Slug', 'ttbase-framework' ); ?></th>
						<td><input type="text" name="ttbase_framework_portfolio_branding[portfolio_tag_slug]" value="<?php echo get_theme_mod( 'portfolio_tag_slug' ); ?>" /></td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php esc_html_e( 'Categories: Label', 'ttbase-framework' ); ?></th>
						<td><input type="text" name="ttbase_framework_portfolio_branding[portfolio_cat_labels]" value="<?php echo get_theme_mod( 'portfolio_cat_labels' ); ?>" /></td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php esc_html_e( 'Categories: Slug', 'ttbase-framework' ); ?></th>
						<td><input type="text" name="ttbase_framework_portfolio_branding[portfolio_cat_slug]" value="<?php echo get_theme_mod( 'portfolio_cat_slug' ); ?>" /></td>
					</tr>
				</table>
				<?php submit_button(); ?>
			</form>
		</div>
	<?php }

	/**
	 * Registers a new custom portfolio sidebar.
	 */
	public static function ttbase_framework_register_sidebar() {

		// Return if custom sidebar is disabled
		if ( ! get_theme_mod( 'portfolio_custom_sidebar', true ) ) {
			return;
		}

		// Get heading tag
		$heading_tag = get_theme_mod( 'sidebar_headings', 'div' );
		$heading_tag = $heading_tag ? $heading_tag : 'div';

		// Get post type object to name sidebar correctly
		$obj            = get_post_type_object( 'portfolio' );
		$post_type_name = $obj->labels->name;

		// Register custom sidebar
		register_sidebar( array (
			'name'          => $post_type_name .' '. esc_html__( 'Sidebar', 'ttbase-framework' ),
			'id'            => 'portfolio_sidebar',
			'before_widget' => '<div class="sidebar-box %2$s clr">',
			'after_widget'  => '</div>',
			'before_title'  => '<'. $heading_tag .' class="widget-title">',
			'after_title'   => '</'. $heading_tag .'>',
		) );
	}

	/**
	 * Alter main sidebar to display portfolio sidebar.
	 */
	public static function ttbase_framework_display_sidebar( $sidebar ) {

		// Display portfolio_sidebar where necessary
		if ( get_theme_mod( 'portfolio_custom_sidebar', true ) && ( is_singular( 'portfolio' ) || ttbase_framework_is_portfolio_tax() ) ) {
			$sidebar = 'portfolio_sidebar';
		}

		// Return correct sidebar to display
		return $sidebar;

	}

}
$ttbase_framework_portfolio_config = new TTBase_Framework_Portfolio_Config;