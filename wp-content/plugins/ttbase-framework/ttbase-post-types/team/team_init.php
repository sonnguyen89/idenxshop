<?php
/**
 * Team Post Type Configuration file
 */

// Set global var
global $ttbase_framework_team_config;

// The class
class TTBase_Framework_Team_Config {
	private $label;

	public function __construct() {

		// Update vars
		$this->label = get_theme_mod( 'team_labels' );
		$this->label = $this->label ? $this->label : esc_html_x( 'Team', 'Team Post Type Label', 'ttbase-framework' );


		// Adds the team post type
		add_action( 'init', array( $this, 'ttbase_framework_register_post_type' ), 0 );

		// Adds the team taxonomies
		add_action( 'init', array( $this, 'ttbase_framework_register_tags' ), 5 );
		add_action( 'init', array( $this, 'ttbase_framework_register_categories' ), 10 );

		// Adds columns in the admin view for taxonomies
		add_filter( 'manage_edit-team_columns', array( $this, 'ttbase_framework_edit_columns' ) );
		add_action( 'manage_team_posts_custom_column', array( $this, 'ttbase_framework_column_display' ), 10, 2 );

		// Allows filtering of posts by taxonomy in the admin view
		add_action( 'restrict_manage_posts', array( $this, 'ttbase_framework_tax_filters' ) );

		// Create Editor for altering the post type arguments
		add_action( 'admin_menu', array( $this, 'ttbase_framework_add_page' ) );
		add_action( 'admin_init', array( $this,'ttbase_framework_register_page_options' ) );
		add_action( 'admin_notices', array( $this, 'ttbase_framework_notices' ) );

		// Adds the team custom sidebar
		add_filter( 'widgets_init', array( $this, 'ttbase_framework_register_sidebar' ), 10 );
		add_filter( 'ttbase_framework_get_sidebar', array( $this, 'ttbase_framework_display_sidebar' ), 11 );

		// Create relations between users and team members
		if ( apply_filters( 'ttbase_framework_team_users_relations', true ) ) {
			add_action( 'personal_options_update', array( $this, 'ttbase_framework_save_custom_profile_fields' ) );
			add_action( 'edit_user_profile_update', array( $this, 'ttbase_framework_save_custom_profile_fields' ) );
			add_filter( 'personal_options', array( $this, 'ttbase_framework_personal_options' ) );
			add_filter( 'ttbase_framework_post_author_bio_data', array( $this, 'ttbase_framework_post_author_bio_data' ) );
		}
		
	}
	
	/**
	 * Register post type.
	 */
	public function ttbase_framework_register_post_type() {

		// Get values and sanitize
		$name           = $this->label;
		$singular_name  = get_theme_mod( 'team_singular_name' );
		$singular_name  = $singular_name ? $singular_name : esc_html__( 'Team Member Item', 'ttbase-framework' );
		$slug           = get_theme_mod( 'team_slug' );
		$slug           = $slug ? $slug : 'team-member';
		$menu_icon      = get_theme_mod( 'team_admin_icon' );
		$menu_icon      = $menu_icon ? $menu_icon : 'groups';
		$team_search   = get_theme_mod( 'team_search', true );
		$team_search   = ! $team_search ? true : false;

		// Labels
		$labels = array(
			'name' => $name,
			'singular_name' => $singular_name,
			'add_new' => esc_html__( 'Add New', 'ttbase-framework' ),
			'add_new_item' => esc_html__( 'Add New Item', 'ttbase-framework' ),
			'edit_item' => esc_html__( 'Edit Item', 'ttbase-framework' ),
			'new_item' => esc_html__( 'Add New Team Member Item', 'ttbase-framework' ),
			'view_item' => esc_html__( 'View Item', 'ttbase-framework' ),
			'search_items' => esc_html__( 'Search Items', 'ttbase-framework' ),
			'not_found' => esc_html__( 'No Items Found', 'ttbase-framework' ),
			'not_found_in_trash' => esc_html__( 'No Items Found In Trash', 'ttbase-framework' )
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
			'exclude_from_search' => $team_search,
		);

		// Apply filters
		$args = apply_filters( 'ttbase_framework_team_args', $args );

		// Register the post type
		register_post_type( 'team', $args );
		
		// add filter to style single template
		add_filter( 'single_template', array( $this, 'ttbase_framework_register_team_template' ), 15 );

	}

	/**
	 * Register Team tags.
	 */
	public function ttbase_framework_register_tags() {

		// Define and sanitize options
		$name = get_theme_mod( 'team_tag_labels');
		$name = $name ? $name : esc_html__( 'Team Tags', 'ttbase-framework' );
		$slug = get_theme_mod( 'team_tag_slug' );
		$slug = $slug ? $slug : 'team-tag';

		// Define team tag labels
		$labels = array(
			'name' => $name,
			'singular_name' => $name,
			'menu_name' => $name,
			'search_items' => esc_html__( 'Search Team Tags', 'ttbase-framework' ),
			'popular_items' => esc_html__( 'Popular Team Tags', 'ttbase-framework' ),
			'all_items' => esc_html__( 'All Team Tags', 'ttbase-framework' ),
			'parent_item' => esc_html__( 'Parent Team Tag', 'ttbase-framework' ),
			'parent_item_colon' => esc_html__( 'Parent Team Tag:', 'ttbase-framework' ),
			'edit_item' => esc_html__( 'Edit Team Tag', 'ttbase-framework' ),
			'update_item' => esc_html__( 'Update Team Tag', 'ttbase-framework' ),
			'add_new_item' => esc_html__( 'Add New Team Tag', 'ttbase-framework' ),
			'new_item_name' => esc_html__( 'New Team Tag Name', 'ttbase-framework' ),
			'separate_items_with_commas' => esc_html__( 'Separate team tags with commas', 'ttbase-framework' ),
			'add_or_remove_items' => esc_html__( 'Add or remove team tags', 'ttbase-framework' ),
			'choose_from_most_used' => esc_html__( 'Choose from the most used team tags', 'ttbase-framework' ),
		);

		// Define team tag arguments
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
		$args = apply_filters( 'ttbase_framework_taxonomy_team_tag_args', $args );

		// Register the team tag taxonomy
		register_taxonomy( 'team_tag', array( 'team' ), $args );

	}
	
	/**
	 * Register Single Team Template.
	 */
	public function ttbase_framework_register_team_template($single_template) {
		global $post;

		if ($post->post_type == 'team') {
			$single_template = dirname( __FILE__ ) . '/single-team.php';
		}
		return $single_template;	
	}
	
	/**
	 * Register Team category.
	 */
	public function ttbase_framework_register_categories() {

		// Define and sanitize options
		$name = get_theme_mod( 'team_cat_labels');
		$name = $name ? $name : esc_html__( 'Team Categories', 'ttbase-framework' );
		$slug = get_theme_mod( 'team_cat_slug' );
		$slug = $slug ? $slug : 'team-category';

		// Define team category labels
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

		// Define team category arguments
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
		$args = apply_filters( 'ttbase_framework_taxonomy_team_category_args', $args );

		// Register the team category taxonomy
		register_taxonomy( 'team_category', array( 'team' ), $args );

	}


	/**
	 * Adds columns to the WP dashboard edit screen.
	 */
	public static function ttbase_framework_edit_columns( $columns ) {
		$columns['team_category'] = esc_html__( 'Category', 'ttbase-framework' );
		$columns['team_tag']      = esc_html__( 'Tags', 'ttbase-framework' );
		return $columns;
	}
	

	/**
	 * Adds columns to the WP dashboard edit screen.
	 */
	public static function ttbase_framework_column_display( $column, $post_id ) {

		switch ( $column ) :

			// Display the team categories in the column view
			case 'team_category':

				if ( $category_list = get_the_term_list( $post_id, 'team_category', '', ', ', '' ) ) {
					echo $category_list;
				} else {
					echo '&mdash;';
				}

			break;

			// Display the team tags in the column view
			case 'team_tag':

				if ( $tag_list = get_the_term_list( $post_id, 'team_tag', '', ', ', '' ) ) {
					echo $tag_list;
				} else {
					echo '&mdash;';
				}

			break;

		endswitch;

	}

	/**
	 * Adds taxonomy filters to the team admin page.
	 */
	public static function ttbase_framework_tax_filters() {
		global $typenow;

		// An array of all the taxonomyies you want to display. Use the taxonomy name or slug
		$taxonomies = array( 'team_category', 'team_tag' );

		// must set this to the post type you want the filter(s) displayed on
		if ( 'team' == $typenow ) {

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
	public function ttbase_framework_add_page() {
		add_submenu_page(
			'edit.php?post_type=team',
			esc_html__( 'Post Type Editor', 'ttbase-framework' ),
			esc_html__( 'Post Type Editor', 'ttbase-framework' ),
			'administrator',
			'ttbase-team-editor',
			array( $this, 'ttbase_framework_create_admin_page' )
		);
	}

	/**
	 * Function that will register the team editor admin page.
	 */
	public function ttbase_framework_register_page_options() {
		register_setting( 'ttbase_framework_team_options', 'ttbase_framework_team_branding', array( $this, 'sanitize' ) );
	}

	/**
	 * Displays saved message after settings are successfully saved.
	 */
	public static function ttbase_framework_notices() {
		settings_errors( 'ttbase_framework_team_editor_page_notices' );
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
			'ttbase_framework_team_editor_page_notices',
			esc_attr( 'settings_updated' ),
			esc_html__( 'Settings saved.', 'ttbase-framework' ),
			'updated'
		);

		// Lets delete the options as we are saving them into theme mods
		$options = '';
		return $options;
	}

	/**
	 * Output for the actual Team Editor admin page.
	 */
	public function ttbase_framework_create_admin_page() { ?>
		<div class="wrap">
			<h2><?php esc_html_e( 'Post Type Editor', 'ttbase-framework' ); ?></h2>
			<form method="post" action="options.php">
				<?php settings_fields( 'ttbase_framework_team_options' ); ?>
				<p><?php esc_html_e( 'If you change any slug\'s you must reset your permalinks to prevent 404 errors.', 'ttbase-framework' ); ?></p>
				<table class="form-table">
					<tr valign="top">
						<th scope="row"><?php esc_html_e( 'Admin Icon', 'ttbase-framework' ); ?></th>
						<td>
							<?php
							// Dashicons select
							$dashicons = array('admin-appearance','admin-collapse','admin-comments','admin-generic','admin-home','admin-media','admin-network','admin-page','admin-plugins','admin-settings','admin-site','admin-tools','admin-users','align-center','align-left','align-none','align-right','analytics','arrow-down','arrow-down-alt','arrow-down-alt2','arrow-left','arrow-left-alt','arrow-left-alt2','arrow-right','arrow-right-alt','arrow-right-alt2','arrow-up','arrow-up-alt','arrow-up-alt2','art','awards','backup','book','book-alt','businessman','calendar','camera','cart','category','chart-area','chart-bar','chart-line','chart-pie','clock','cloud','dashboard','desktop','dismiss','download','edit','editor-aligncenter','editor-alignleft','editor-alignright','editor-bold','editor-customchar','editor-distractionfree','editor-help','editor-indent','editor-insertmore','editor-italic','editor-justify','editor-kitchensink','editor-ol','editor-outdent','editor-paste-text','editor-paste-word','editor-quote','editor-removeformatting','editor-rtl','editor-spellcheck','editor-strikethrough','editor-textcolor','editor-ul','editor-underline','editor-unlink','editor-video','email','email-alt','exerpt-view','facebook','facebook-alt','feedback','flag','format-aside','format-audio','format-chat','format-gallery','format-image','format-links','format-quote','format-standard','format-status','format-video','forms','googleplus','groups','hammer','id','id-alt','image-crop','image-flip-horizontal','image-flip-vertical','image-rotate-left','image-rotate-right','images-alt','images-alt2','info','leftright','lightbulb','list-view','location','location-alt','lock','marker','menu','migrate','minus','networking','no','no-alt','performance','plus','team','post-status','pressthis','products','redo','rss','screenoptions','search','share','share-alt','share-alt2','share1','shield','shield-alt','slides','smartphone','smiley','sort','sos','star-empty','star-filled','star-half','tablet','tag','testimonial','translation','trash','twitter','undo','update','upload','vault','video-alt','video-alt2','video-alt3','visibility','welcome-add-page','welcome-comments','welcome-edit-page','welcome-learn-more','welcome-view-site','welcome-widgets-menus','wordpress','wordpress-alt','yes');
							$dashicons = array_combine( $dashicons, $dashicons ); ?>
							<select name="ttbase_framework_team_branding[team_admin_icon]">
								<option value=""><?php esc_html_e( 'Default', 'ttbase-framework' ); ?></option>
								<?php foreach ( $dashicons as $dashicon ) { ?>
									<option value="<?php echo esc_attr($dashicon); ?>" <?php selected( get_theme_mod( 'team_admin_icon' ), $dashicon, true ); ?>><?php echo esc_html($dashicon); ?></option>
								<?php } ?>
							</select>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php esc_html_e( 'Post Type: Name', 'ttbase-framework' ); ?></th>
						<td><input type="text" name="ttbase_framework_team_branding[team_labels]" value="<?php echo get_theme_mod( 'team_labels' ); ?>" /></td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php esc_html_e( 'Post Type: Singular Name', 'ttbase-framework' ); ?></th>
						<td><input type="text" name="ttbase_framework_team_branding[team_singular_name]" value="<?php echo get_theme_mod( 'team_singular_name' ); ?>" /></td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php esc_html_e( 'Post Type: Slug', 'ttbase-framework' ); ?></th>
						<td><input type="text" name="ttbase_framework_team_branding[team_slug]" value="<?php echo get_theme_mod( 'team_slug' ); ?>" /></td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php esc_html_e( 'Tags: Label', 'ttbase-framework' ); ?></th>
						<td><input type="text" name="ttbase_framework_team_branding[team_tag_labels]" value="<?php echo get_theme_mod( 'team_tag_labels' ); ?>" /></td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php esc_html_e( 'Tags: Slug', 'ttbase-framework' ); ?></th>
						<td><input type="text" name="ttbase_framework_team_branding[team_tag_slug]" value="<?php echo get_theme_mod( 'team_tag_slug' ); ?>" /></td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php esc_html_e( 'Categories: Label', 'ttbase-framework' ); ?></th>
						<td><input type="text" name="ttbase_framework_team_branding[team_cat_labels]" value="<?php echo get_theme_mod( 'team_cat_labels' ); ?>" /></td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php esc_html_e( 'Categories: Slug', 'ttbase-framework' ); ?></th>
						<td><input type="text" name="ttbase_framework_team_branding[team_cat_slug]" value="<?php echo get_theme_mod( 'team_cat_slug' ); ?>" /></td>
					</tr>
				</table>
				<?php submit_button(); ?>
			</form>
		</div>
	<?php }

	/**
	 * Registers a new custom team sidebar.
	 */
	public static function ttbase_framework_register_sidebar() {


		// Return if custom sidebar is disabled
		if ( ! get_theme_mod( 'team_custom_sidebar', true ) ) {
			return;
		}

		// Get post type object to name sidebar correctly
		$obj            = get_post_type_object( 'team' );
		$post_type_name = $obj->labels->name;

		// Register team_sidebar
		register_sidebar( array (
			'name'          => $post_type_name .' '. esc_html__( 'Sidebar', 'ttbase-framework' ),
			'id'            => 'sidebar-team',
			'before_widget' => '<aside id="%1$s" class="sidebar team widget %2$s">',
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
		if ( get_theme_mod( 'team_custom_sidebar', true ) && ( is_singular( 'team' ) || ttbase_framework_is_team_tax() ) ) {
			$sidebar = 'team_sidebar';
		}
		return $sidebar;
	}


	/**
	 * Adds field to user dashboard to connect to team member
	 */
	public static function ttbase_framework_personal_options( $user ) {

		// Get team members
		$team_posts = get_posts( array(
			'post_type' => 'team',
			'posts_per_page' => -1,
			'fields' => 'ids',
		) );

		// Return if no team
		if ( ! $team_posts ) return;

		// Get team meta
		$meta_value = get_user_meta( $user->ID, 'ttbase_framework_team_member_id', true ); ?>

	    	<tr>
	    		<th scope="row"><?php esc_html_e( 'Connect to Team Member', 'ttbase-framework' ); ?></th>
				<td>
					<fieldset>
						<select type="text" id="ttbase_framework_team_member_id" name="ttbase_framework_team_member_id">
							<option value="" <?php selected( $meta_value, '' ); ?>>&mdash;</option>
							<?php foreach ( $team_posts as $id ) { ?>
								<option value="<?php echo esc_attr($id); ?>" <?php selected( $meta_value, $id ); ?>><?php echo esc_attr( get_the_title( $id ) ); ?></option>
							<?php } ?>
						</select>
					</fieldset>
				</td>
			</tr>

	    <?php

	}

	/**
	 * Saves user profile fields
	 */
	public static function ttbase_framework_save_custom_profile_fields( $user_id ) {

		// Get meta
		$meta_value = isset( $_POST['ttbase_framework_team_member_id'] ) ? $_POST['ttbase_framework_team_member_id'] : '';

		// Get options
		$relations = get_option( 'ttbase_framework_team_users_relations', array() );

		// Prevent team ID's from being used more then 1x
		if ( is_array( $relations ) && array_search( $meta_value, $relations ) ) {
			return;
		}

		// Update option
		else {
			$relations[$user_id] = $meta_value;
			update_option( 'ttbase_framework_team_users_relations', $relations );
		}

		// Update meta
		update_user_meta( $user_id, 'ttbase_framework_team_member_id', $meta_value, get_user_meta( $user_id, 'update_user_meta', true ) );
		
	}

	/**
	 * Alters post author bio data based on team item relations
	 */
	public static function ttbase_framework_post_author_bio_data( $data ) {
		$relations       = get_option( 'ttbase_framework_team_users_relations' );
		$team_member_id = isset( $relations[$data['post_author']] ) ? $relations[$data['post_author']] : '';
		if ( $team_member_id ) {
			$data['author_name'] = get_the_title( $team_member_id );
			$data['posts_url'] = get_the_permalink( $team_member_id );
			$featured_image = ttbase_framework_get_post_thumbnail( array(
				'attachment' => get_post_thumbnail_id( $team_member_id ),
				'size'       => 'ttbase_framework_custom',
				'width'      => $data['avatar_size'],
				'height'     => $data['avatar_size'],
				'alt'        => $data['author_name'],
			) );
			if ( $featured_image ) {
				$data['avatar'] = $featured_image;
			}
		}
		return $data;
	}

}
$ttbase_framework_team_config = new TTBase_Framework_Team_Config;