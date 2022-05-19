<?php
/**
 * functions.php
 * @package WordPress
 * @subpackage Chakta
 * @since Chakta 1.6.1
 * 
 */


/*************************************************
## Admin style and scripts  
*************************************************/ 

function chakta_admin_styles() {
	wp_enqueue_style('chakta-klbtheme',   get_template_directory_uri() .'/assets/css/admin/klbtheme.css');
	wp_enqueue_script('chakta-init', 	  get_template_directory_uri() .'/assets/js/init.js', array('jquery','media-upload','thickbox'));
    wp_enqueue_script('chakta-register',  get_template_directory_uri() . '/assets/js/admin/register.js', array('jquery'), '1.0', true);
}
add_action('admin_enqueue_scripts', 'chakta_admin_styles');

 /*************************************************
## Chakta Fonts
*************************************************/
function chakta_fonts_url_rubik() {
        $fonts_url = '';
	
		$rubik = _x( 'on', 'Rubik font: on or off', 'chakta' );		

		if ( 'off' !== $rubik ) {
		$font_families = array();

		if ( 'off' !== $rubik ) {
		$font_families[] = 'Rubik:100,300,400,500,700,900';
		}
		
		$query_args = array( 
		'family' => rawurldecode( implode( '|', $font_families ) ), 
		'subset' => rawurldecode( 'latin,latin-ext' ), 
		); 
		 
		$fonts_url = add_query_arg( $query_args, '//fonts.googleapis.com/css' );
		}
 
return esc_url_raw( $fonts_url );
}

function chakta_fonts_url_poppins() {
        $fonts_url = '';
	
		$poppins = _x( 'on', 'Poppins font: on or off', 'chakta' );	

		if ( 'off' !== $poppins ) {
		$font_families = array();

		if ( 'off' !== $poppins ) {
		$font_families[] = 'Poppins:200,300,400,500,600,700,800,900';
		}
		
		$query_args = array( 
		'family' => rawurldecode( implode( '|', $font_families ) ), 
		'subset' => rawurldecode( 'latin,latin-ext' ), 
		); 
		 
		$fonts_url = add_query_arg( $query_args, '//fonts.googleapis.com/css' );
		}
 
return esc_url_raw( $fonts_url );
}

/*************************************************
## Styles and Scripts
*************************************************/ 
define('CHAKTA_INDEX_CSS', 	  get_template_directory_uri()  . '/assets/css');
define('CHAKTA_INDEX_JS', 	  get_template_directory_uri()  . '/assets/js');
define('CHAKTA_INDEX_FONTS',  get_template_directory_uri()  . '/assets/fonts');

function chakta_scripts() {
	
	if ( is_admin_bar_showing() ) {
		wp_enqueue_style( 'chakta-klbtheme', CHAKTA_INDEX_CSS . '/admin/klbtheme.css', false, '1.0');    
	}	

	if ( is_singular() ) wp_enqueue_script( 'comment-reply' );

	wp_enqueue_style( 'bootstrap', 				CHAKTA_INDEX_CSS    . '/bootstrap.min.css', false, '1.0');	
	wp_enqueue_style( 'fontawesome-all',    	CHAKTA_INDEX_FONTS  . '/fontawesome/css/all.css', false, '1.0');
	wp_enqueue_style( 'magnific-popup',    		CHAKTA_INDEX_CSS  	. '/magnific-popup.css', false, '1.0');
	wp_style_add_data( 'magnific-popup', 'rtl', 'replace' );
	wp_enqueue_style( 'slick', 					CHAKTA_INDEX_CSS  	. '/slick.css', false, '1.0');
	wp_style_add_data( 'slick', 'rtl', 'replace' );	
	wp_enqueue_style( 'nice-select', 			CHAKTA_INDEX_CSS  	. '/nice-select.css', false, '1.0');
	wp_style_add_data( 'nice-select', 'rtl', 'replace' );
	wp_enqueue_style( 'chakta-default', 		CHAKTA_INDEX_CSS  	. '/default.css', false, '1.0');
	wp_enqueue_style( 'chakta-main', 			CHAKTA_INDEX_CSS  	. '/main.css', false, '1.0');
	wp_style_add_data( 'chakta-main', 'rtl', 'replace' );
	wp_enqueue_style( 'chakta-font-rubbik',  	chakta_fonts_url_rubik(), array(), null );
	wp_enqueue_style( 'chakta-font-poppins',  	chakta_fonts_url_poppins(), array(), null );
	wp_enqueue_style( 'chakta-style',           get_stylesheet_uri() );
	wp_style_add_data( 'chakta-style', 'rtl', 'replace' );

	$mapkey = get_theme_mod('chakta_mapapi');

	wp_enqueue_script( 'bootstrap',    	    		CHAKTA_INDEX_JS . '/bootstrap.min.js', array('jquery'), '1.0', true);
	wp_enqueue_script( 'popper',     	 			CHAKTA_INDEX_JS . '/popper.min.js', array('jquery'), '1.0', true);
	wp_enqueue_script( 'slick',    	    			CHAKTA_INDEX_JS . '/slick.min.js', array('jquery'), '1.0', true);
	wp_enqueue_script( 'jquery-magnific-popup',    	CHAKTA_INDEX_JS . '/jquery.magnific-popup.min.js', array('jquery'), '1.0', true);
	wp_enqueue_script( 'jquery-nice-select',    	CHAKTA_INDEX_JS . '/jquery.nice-select.min.js', array('jquery'), '1.0', true);
    wp_register_script( 'chakta-plus-minus',    	CHAKTA_INDEX_JS . '/custom/plus_minus.js', array('jquery'), '1.0', true);
    wp_register_script( 'chakta-blog-gallery',    	CHAKTA_INDEX_JS . '/custom/blog_gallery.js', array('jquery'), '1.0', true);
	wp_register_script( 'chakta-googlemap',      	'//maps.googleapis.com/maps/api/js?key='. $mapkey .'', array('jquery'), '1.0', true);
	wp_enqueue_script( 'chakta-main',     		CHAKTA_INDEX_JS . '/main.js', array('jquery'), '1.0', true);
}
add_action( 'wp_enqueue_scripts', 'chakta_scripts' );

/*************************************************
## Theme Setup
*************************************************/ 

if ( ! isset( $content_width ) ) $content_width = 960;

function chakta_theme_setup() {
	
	add_theme_support( 'title-tag' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'post-thumbnails' );
    add_theme_support( 'custom-background' );
	add_theme_support( 'post-formats', array('gallery', 'audio', 'video'));
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
	add_theme_support( 'woocommerce', array('gallery_thumbnail_image_width' => 99,'thumbnail_image_width' => 90,) );
	load_theme_textdomain( 'chakta', get_template_directory() . '/languages' );
	remove_theme_support( 'widgets-block-editor' );

}
add_action( 'after_setup_theme', 'chakta_theme_setup' );


/*************************************************
## Include the TGM_Plugin_Activation class.
*************************************************/ 

require_once get_template_directory() . '/includes/class-tgm-plugin-activation.php';

add_action( 'tgmpa_register', 'chakta_register_required_plugins' );

function chakta_register_required_plugins() {

	$url = 'http://klbtheme.com/chakta/plugins/';
	$mainurl = 'http://klbtheme.com/plugins/';

	$plugins = array(
		
        array(
            'name'                  => esc_html__('Meta Box','chakta'),
            'slug'                  => 'meta-box',
        ),

        array(
            'name'                  => esc_html__('Contact Form 7','chakta'),
            'slug'                  => 'contact-form-7',
        ),
		
		array(
            'name'                  => esc_html__('WooCommerce Wishlist','chakta'),
            'slug'                  => 'ti-woocommerce-wishlist',
        ),
		
        array(
            'name'                  => esc_html__('Kirki','chakta'),
            'slug'                  => 'kirki',
        ),
		
		array(
            'name'                  => esc_html__('MailChimp Subscribe','chakta'),
            'slug'                  => 'mailchimp-for-wp',
        ),
		
        array(
            'name'                  => esc_html__('Elementor','chakta'),
            'slug'                  => 'elementor',
        ),
		
        array(
            'name'                  => esc_html__('WooCommerce','chakta'),
            'slug'                  => 'woocommerce',
        ),

        array(
            'name'                  => esc_html__('Chakta Core','chakta'),
            'slug'                  => 'chakta-core',
            'source'                => $url . 'chakta-core.zip',
            'required'              => false,
            'version'               => '1.1.2',
            'force_activation'      => false,
            'force_deactivation'    => false,
            'external_url'          => '',
        ),

        array(
            'name'                  => esc_html__('Envato Market','chakta'),
            'slug'                  => 'envato-market',
            'source'                => $mainurl . 'envato-market.zip',
            'required'              => true,
            'version'               => '2.0.7',
            'force_activation'      => false,
            'force_deactivation'    => false,
            'external_url'          => '',
        ),


	);

	$config = array(
		'id'           => 'chakta',                 // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                      // Default absolute path to bundled plugins.
		'menu'         => 'tgmpa-install-plugins', // Menu slug.
		'parent_slug'  => 'themes.php',            // Parent menu slug.
		'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => false,                   // Automatically activate plugins after installation or not.
		'message'      => '',                      // Message to output right before the plugins table.
	);

	tgmpa( $plugins, $config );
}

/*************************************************
## Chakta Register Menu 
*************************************************/

function chakta_register_menus() {
	register_nav_menus( array( 'main-menu' 	   => esc_html__('Primary Navigation Menu','chakta')) );
	$topheader = get_theme_mod('chakta_top_header','0');

	if($topheader == '1'){
		register_nav_menus( array( 'top-right-menu' => esc_html__('Top Right Menu','chakta')) );
		register_nav_menus( array( 'top-left-menu' => esc_html__('Top Left Menu','chakta')) );
	}
}
add_action('init', 'chakta_register_menus');

/*************************************************
## Chakta Menu
*************************************************/ 
class chakta_description_walker extends Walker_Nav_Menu {
	function start_lvl( &$output, $depth = 0, $args = array() ) {
		// depth dependent classes
		$indent = ( $depth > 0  ? str_repeat( "\t", $depth ) : '' ); // code indent
		$display_depth = ( $depth + 1); // because it counts the first submenu as 0
		$classes = array(
			'',
			( $display_depth % 2  ? '' : '' ),
			( $display_depth >=2 ? '' : '' ),
			
			);
		$class_names = implode( ' ', $classes );
	  
		// build html
		$output .= "\n" . $indent . '<ul class="sub-menu">' . "\n";
	}

    function display_element( $element, &$children_elements, $max_depth, $depth=0, $args, &$output ){
        $id_field = $this->db_fields['id'];
        if ( is_object( $args[0] ) ) {
            $args[0]->has_children = ! empty( $children_elements[$element->$id_field] );
        }
        return parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
    }
      function start_el(&$output, $object, $depth = 0, $args = Array() , $current_object_id = 0) {
           
           global $wp_query;

           $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

           $class_names = $value = '';
		   
		   $classes = empty( $object->classes ) ? array() : (array) $object->classes;
           $icon_class = $classes[0];
		   $classes = array_slice($classes,1);
		   
		   $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $object ) );
		   
		   if ( $args->has_children ) {
		   $class_names = 'class="dropdown '.esc_attr($icon_class).' '. esc_attr( $class_names ) . '"';
		   } else {
		   $class_names = 'class="'.esc_attr($icon_class).' '. esc_attr( $class_names ) . '"';
		   }
			
			$output .= $indent . '<li ' . $value . $class_names .'>';

			$datahover = str_replace(' ','',$object->title);


			$attributes = ! empty( $object->url ) ? ' href="'   . esc_attr( $object->url ) .'"' : '';

				
			$object_output = $args->before;

			$object_output .= '<a'. $attributes .'  >';
			$object_output .= $args->link_before .  apply_filters( 'the_title', $object->title, $object->ID ) . '';
	        $object_output .= $args->link_after;
			$object_output .= '</a>';


			$object_output .= $args->after;

			$output .= apply_filters( 'walker_nav_menu_start_el', $object_output, $object, $depth, $args );            	              	
      }
}

add_filter('nav_menu_css_class' , 'chakta_nav_class' , 10 , 2);
function chakta_nav_class($classes, $item){
     if( in_array('current-menu-item', $classes) ){
             $classes[] = 'active';
     }
     return $classes;
}

/*************************************************
## Excerpt More
*************************************************/ 

function chakta_excerpt_more($more) {
  global $post;
  return '<div class="klb-readmore"><a class="main-btn" href="'. esc_url(get_permalink($post->ID)) . '">' . esc_html__('Read More', 'chakta') . '</a></div>';
  }
 add_filter('excerpt_more', 'chakta_excerpt_more');
 
/*************************************************
## Word Limiter
*************************************************/ 
function chakta_limit_words($string, $limit) {
	$words = explode(' ', $string);
	return implode(' ', array_slice($words, 0, $limit));
}

/*************************************************
## Widgets
*************************************************/ 

function chakta_widgets_init() {
	register_sidebar( array(
	  'name' => esc_html__( 'Blog Sidebar', 'chakta' ),
	  'id' => 'blog-sidebar',
	  'description'   => esc_html__( 'These are widgets for the Blog page.','chakta' ),
	  'before_widget' => '<div class="widget %2$s mb-30">',
	  'after_widget'  => '</div>',
	  'before_title'  => '<h4 class="widget-title">',
	  'after_title'   => '</h4>'
	) );

	register_sidebar( array(
	  'name' => esc_html__( 'Shop Sidebar', 'chakta' ),
	  'id' => 'shop-sidebar',
	  'description'   => esc_html__( 'These are widgets for the Shop.','chakta' ),
	  'before_widget' => '<div class="widget mb-30 %2$s">',
	  'after_widget'  => '</div>',
	  'before_title'  => '<h4 class="widget-title">',
	  'after_title'   => '</h4>'
	) );

	register_sidebar( array(
	  'name' => esc_html__( 'Footer First Column', 'chakta' ),
	  'id' => 'footer-1',
	  'description'   => esc_html__( 'These are widgets for the Footer.','chakta' ),
	  'before_widget' => '<div class="klbfooterwidget widget %2$s">',
	  'after_widget'  => '</div>',
	  'before_title'  => '<h4 class="widget-title">',
	  'after_title'   => '</h4>'
	) );

	register_sidebar( array(
	  'name' => esc_html__( 'Footer Second Column', 'chakta' ),
	  'id' => 'footer-2',
	  'description'   => esc_html__( 'These are widgets for the Footer.','chakta' ),
	  'before_widget' => '<div class="klbfooterwidget widget %2$s">',
	  'after_widget'  => '</div>',
	  'before_title'  => '<h4 class="widget-title">',
	  'after_title'   => '</h4>'
	) );

	register_sidebar( array(
	  'name' => esc_html__( 'Footer Third Column', 'chakta' ),
	  'id' => 'footer-3',
	  'description'   => esc_html__( 'These are widgets for the Footer.','chakta' ),
	  'before_widget' => '<div class="klbfooterwidget widget %2$s">',
	  'after_widget'  => '</div>',
	  'before_title'  => '<h4 class="widget-title">',
	  'after_title'   => '</h4>'
	) );

	register_sidebar( array(
	  'name' => esc_html__( 'Footer Fourth Column', 'chakta' ),
	  'id' => 'footer-4',
	  'description'   => esc_html__( 'These are widgets for the Footer.','chakta' ),
	  'before_widget' => '<div class="klbfooterwidget widget %2$s">',
	  'after_widget'  => '</div>',
	  'before_title'  => '<h4 class="widget-title">',
	  'after_title'   => '</h4>'
	) );
	
	register_sidebar( array(
	  'name' => esc_html__( 'Footer Fifth Column', 'chakta' ),
	  'id' => 'footer-5',
	  'description'   => esc_html__( 'These are widgets for the Footer.','chakta' ),
	  'before_widget' => '<div class="klbfooterwidget widget %2$s">',
	  'after_widget'  => '</div>',
	  'before_title'  => '<h4 class="widget-title">',
	  'after_title'   => '</h4>'
	) );


}
add_action( 'widgets_init', 'chakta_widgets_init' );
 
/*************************************************
## Chakta Comment
*************************************************/

if ( ! function_exists( 'chakta_comment' ) ) :
 function chakta_comment( $comment, $args, $depth ) {
  $GLOBALS['comment'] = $comment;
  switch ( $comment->comment_type ) :
   case 'pingback' :
   case 'trackback' :
  ?>

   <article class="post pingback">
   <p><?php esc_html_e( 'Pingback:', 'chakta' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( esc_html__( '(Edit)', 'chakta' ), ' ' ); ?></p>
  <?php
    break;
   default :
  ?>
  
  
	<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
		<div id="div-comment-<?php comment_ID(); ?>" class="comment-body">
			<div class="comments-box">
				<div class="comment-avatar">
					<img  src="<?php echo get_avatar_url( $comment, 90 ); ?>" alt="<?php comment_author(); ?>">
				</div>
				<div class="comment-wrap">
					<div class="comment-author-content">
						<span class="author-name"><?php comment_author(); ?></span>
						<span class="date"><?php comment_date(); ?></span>
						<div class="klb-post">
							<?php comment_text(); ?> 
							<?php if ( $comment->comment_approved == '0' ) : ?>
							<em><?php esc_html_e( 'Your comment is awaiting moderation.', 'chakta' ); ?></em>
							<?php endif; ?>
						</div>
						<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
					</div>
				</div>
			</div>
		</div>
	</li>


  <?php
    break;
  endswitch;
 }
endif;

/*************************************************
## Chakta Comment Placeholder
 *************************************************/

add_filter( 'comment_form_default_fields', 'chakta_comment_placeholders' );
function chakta_comment_placeholders( $fields ){
    $fields['author'] = str_replace(
        '<input',
        '<input placeholder="'.esc_attr__('Name * ','chakta').'"',
        $fields['author']
    );
    $fields['email'] = str_replace(
        '<input',
        '<input placeholder="'.esc_attr__('Email *','chakta').'"',
        $fields['email']
    );
    $fields['url'] = str_replace(
        '<input',
        '<input placeholder="'.esc_attr__('Website','chakta').'"',
        $fields['url']
    );
    return $fields;
}

add_filter( 'comment_form_defaults', 'chakta_textarea_placeholder' );
function chakta_textarea_placeholder( $fields ){

    $fields['comment_field'] = str_replace(
        '<textarea',
        '<textarea placeholder="'.esc_attr__('Comment','chakta').'"',
        $fields['comment_field']
    );
    return $fields;
}


/*************************************************
## Chakta Widget Count Filter
 *************************************************/

function chakta_cat_count_span($links) {
  $links = str_replace('</a> (', '</a> <span class="catcount">(', $links);
  $links = str_replace(')', ')</span>', $links);
  return chakta_sanitize_data($links);
}
add_filter('wp_list_categories', 'chakta_cat_count_span');
 
function chakta_archive_count_span( $links ) {
	$links = str_replace( '</a>&nbsp;(', '</a><span class="catcount">(', $links );
	$links = str_replace( ')', ')</span>', $links );
	return chakta_sanitize_data($links);
}
add_filter( 'get_archives_link', 'chakta_archive_count_span' );


/*************************************************
## Pingback url auto-discovery header for single posts, pages, or attachments
 *************************************************/
function chakta_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}
add_action( 'wp_head', 'chakta_pingback_header' );

/************************************************************
## DATA CONTROL FROM PAGE METABOX OR ELEMENTOR PAGE SETTINGS
*************************************************************/
function chakta_page_settings( $opt_id){
	
	if ( class_exists( '\Elementor\Core\Settings\Manager' ) ) {
		// Get the current post id
		$post_id = get_the_ID();

		// Get the page settings manager
		$page_settings_manager = \Elementor\Core\Settings\Manager::get_settings_managers( 'page' );

		// Get the settings model for current post
		$page_settings_model = $page_settings_manager->get_model( $post_id );

		// Retrieve the color we added before
		$output = $page_settings_model->get_settings( 'chakta_elementor_'.$opt_id );
		
		return $output;
	}
}

/************************************************************
## Elementor Get Templates
*************************************************************/
function chakta_get_elementor_template($template_id){
	if($template_id){
	    $frontend = new \Elementor\Frontend;
	    printf( '<div class="chakta-elementor-template template-'.esc_attr($template_id).'">%1$s</div>', $frontend->get_builder_content_for_display( $template_id, true ) );

	    if ( class_exists( '\Elementor\Plugin' ) ) {
	        $elementor = \Elementor\Plugin::instance();
	        $elementor->frontend->enqueue_styles();
			$elementor->frontend->enqueue_scripts();
	    }
	
	    if ( class_exists( '\ElementorPro\Plugin' ) ) {
	        $elementor_pro = \ElementorPro\Plugin::instance();
	        $elementor_pro->enqueue_styles();
	        $elementor_pro->enqueue_scripts();
	    }

	}

}
add_action( 'chakta_before_main_shop', 'chakta_get_elementor_template', 10);
add_action( 'chakta_after_main_shop', 'chakta_get_elementor_template', 10);
add_action( 'chakta_before_main_footer', 'chakta_get_elementor_template', 10);
add_action( 'chakta_after_main_footer', 'chakta_get_elementor_template', 10);
add_action( 'chakta_before_main_header', 'chakta_get_elementor_template', 10);
add_action( 'chakta_after_main_header', 'chakta_get_elementor_template', 10);

/************************************************************
## Do Action for Templates and Product Categories
*************************************************************/
function chakta_do_action($hook){
	
	if ( !class_exists( 'woocommerce' ) ) {
		return;
	}

	$categorytemplate = get_theme_mod('chakta_elementor_template_each_shop_category');
	if(is_product_category()){
		if($categorytemplate && array_search(get_queried_object()->term_id, array_column($categorytemplate, 'category_id')) !== false){
			foreach($categorytemplate as $c){
				if($c['category_id'] == get_queried_object()->term_id){
					do_action( $hook, $c[$hook.'_elementor_template_category']);
				}
			}
		} else {
			do_action( $hook, get_theme_mod($hook.'_elementor_template'));
		}
	} else {
		do_action( $hook, get_theme_mod($hook.'_elementor_template'));
	}
	
}

/*************************************************
## Chakta Get options
*************************************************/
function chakta_get_option(){	
	$getopt  = isset( $_GET['opt'] ) ? $_GET['opt'] : '';

	return esc_html($getopt);
}

/*************************************************
## Chakta Theme options
*************************************************/

	require_once get_template_directory() . '/includes/metaboxes.php';
	require_once get_template_directory() . '/includes/woocommerce.php';
	require_once get_template_directory() . '/includes/woocommerce-filter.php';
	require_once get_template_directory() . '/includes/sanitize.php';
	require_once get_template_directory() . '/includes/merlin/theme-register.php';
	require_once get_template_directory() . '/includes/merlin/setup-wizard.php';
	require_once get_template_directory() . '/includes/header/main-header.php';
	require_once get_template_directory() . '/includes/footer/main-footer.php';	