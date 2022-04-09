<?php 
/**
 * Init theme options
 * Certain theme options need to be written to the database as soon as the theme is installed.
 * This is either for the enqueues in ttbase-framework, or to override the default image sizes in WooCommerce.
 * Either way this function is only called when the theme is first activated, de-activating and re-activating the theme will result in these options returning to defaults.
 * 
 */
if(!( function_exists('gymx_init_theme_options') )){
	/**
	 * Hook in on activation
	 */
	global $pagenow;
	
	/**
	 * Register included ttbase framework functions
	 */
	function gymx_init_theme_options() {
		//TTBase Framework
		$framework_args = array(
			'ttbase_shortcodes'     => '1',
        	'ttbase_widgets'        => '1',
        	'portfolio_post_type'   => '0',
        	'team_post_type'        => '0',
        	'client_post_type'      => '0',
        	'testimonial_post_type' => '1',
        	'service_post_type' 	=> '0',
        	'gymx_extension'		=> '1'
		);
		update_option('ttbase_framework_options', $framework_args);
	}
	
	/**
	 * Only call this action when we first activate the theme.
	 */
	if ( 
		is_admin() && isset( $_GET['activated'] ) && $pagenow == 'themes.php' ||
		is_admin() && isset( $_GET['theme'] ) && $pagenow == 'customize.php'
	){
		add_action( 'init', 'gymx_init_theme_options', 1 );
	}
}
if(!( function_exists('gymx_is_blog_page') )){
	function gymx_is_blog_page() {
	    global $post;
	    return ( ( is_home() || is_archive() || is_single() ) && ('post' == get_post_type($post)) ) ? true : false ;
	}
}

function gymx_get_the_post_id() {
  if (in_the_loop()) {
       $post_id = get_the_ID();
  }
  elseif ( is_home()
		|| is_category()
		|| is_tag()
		|| is_date()
		|| is_author() || is_search() ) {
  	   $post_id = get_option( 'page_for_posts' );
  }
  else {
       global $wp_query;
       $post_id = $wp_query->get_queried_object_id();
         }
  return $post_id;
}

function gymx_is_post_type($type){
    global $wp_query;
    if($type == get_post_type($wp_query->post->ID)) return true;
    return false;
}

/**
 * Echo escaped post title
 */
function gymx_esc_title() {
	echo gymx_get_esc_title();
}

function gymx_permalink( $post_id = '' ) {
	echo gymx_get_permalink( $post_id );
}

/**
 * Return the post URL
 *
 */
function gymx_get_permalink( $post_id = '' ) {

	// If post ID isn't defined lets get it
	$post_id = $post_id ? $post_id : get_the_ID();

	$permalink  = get_permalink( $post_id );

	// Sanitize & return
	return esc_url( $permalink );

}

/**
 * Return escaped post title
 */
function gymx_get_esc_title() {
	return esc_attr( the_title_attribute( 'echo=0' ) );
}

// retrieve all categories from each post type
if( !function_exists('gymx_get_page_title') ){
	function gymx_get_page_title( $page_id ){
		$title = get_post_meta( $page_id, 'gymx_post_page_title', true );
		$blog_title =  get_theme_mod('gymx_blog_title','Our Blog');
		$blog_title = gymx_translate_theme_mod('gymx_blog_title', $blog_title);
		
		if ( gymx_is_blog_page() && 'yes' == get_theme_mod('gymx_post_title','no') ) {
			return $blog_title;
		}
		
		if ( $title == '' ) {
			if (is_home()) {
				$title = $blog_title;
			}elseif( class_exists('Woocommerce') && is_woocommerce() ) { 
				$title = get_theme_mod('gymx_wc_title', 'Shop'); 
			}
			elseif (is_archive()) {
				$title = gymx_the_archive_title('','');
			}elseif (is_search()) {
				$title = sprintf( esc_html__( 'Search: %s', 'gymx' ),  get_search_query() );
			}elseif (is_404()) {
				$title = esc_html__('Page not found','gymx');
			}else {
				$title = get_the_title();
			}
		}
		return $title;
	}
}

// retrieve all categories from each post type
if( !function_exists('gymx_get_term_list') ){
	function gymx_get_term_list( $taxonomy, $parent='' ){
		$term_list = get_categories( array('taxonomy'=>$taxonomy, 'hide_empty'=>0, 'parent'=>$parent) );

		$ret = array();
		if( !empty($term_list) && empty($term_list['errors']) ){
			foreach( $term_list as $term ){
				if( !empty($term->slug) ){
					$ret[$term->slug] = $term->name;
				}
			}
		}
			
		return $ret;
	}
}

/**
 * Get breadcrumbs for page or post
 */
if(!( function_exists('gymx_breadcrumbs') )){
	function gymx_breadcrumbs() {
		if ( is_front_page() || is_search() || is_404() || get_post_meta( gymx_get_the_post_id(), 'gymx_post_breadcrumbs_hide', true) == true || get_theme_mod('gymx_show_breadcrumbs','yes') == 'no' ) {
			return;
		}
		
		$post_type = get_post_type();
		$ancestors = array_reverse( get_post_ancestors( gymx_get_the_post_id() ) );
		$breadcrumb_color = ( get_post_meta( gymx_get_the_post_id(), 'gymx_post_breadcrumb_color', true ) != '' ) ? 'style="color:' . get_post_meta( gymx_get_the_post_id(), 'gymx_post_breadcrumb_color', true ) . ';"' : '';
		$breadcrumb_active_color = ( get_post_meta( gymx_get_the_post_id(), 'gymx_post_breadcrumb_current_color', true ) != '' ) ? 'style="color:' . get_post_meta( gymx_get_the_post_id(), 'gymx_post_breadcrumb_current_color', true ) . ';"' : '';
		
		$blog_title =  get_theme_mod('gymx_blog_title','Our Blog');
		$blog_title = gymx_translate_theme_mod('gymx_blog_title', $blog_title);
		
		$before = '<ol class="breadcrumb">';
		$after = '</ol>';
		$home = '<li><a href="' . esc_url( home_url( "/" ) ) . '" class="home-link" rel="home" ' . $breadcrumb_color .'>' . esc_html__( 'Home', 'gymx' ) . '</a></li>';
		
		if( 'trainers' == $post_type ){
			$trainer_slug = get_theme_mod( 'trainers_slug' );
			$trainer_slug = $trainer_slug ? $trainer_slug : 'trainer';
			$trainer_name = get_theme_mod( 'trainers_labels' );
			$trainer_name = $trainer_name ? $trainer_name : esc_html__( 'Trainers', 'gymx' );
			$home .= '<li class="active" ' . $breadcrumb_active_color .'><a href="' . esc_url( home_url( "/". $trainer_slug ."/" ) ) . '">' . esc_html( $trainer_name ) . '</a></li>';
		}
		if( 'testimonial' == $post_type ){
			
			$testimonial_slug = get_theme_mod( 'testimonial_slug' );
			$testimonial_slug = $testimonial_slug ? $testimonial_slug : 'testimonial';
			$testimonial_name = get_theme_mod( 'testimonial_labels' );
			$testimonial_name = $testimonial_name ? $testimonial_name : esc_html__( 'Testimonials', 'gymx' );
			$home .= '<li class="active" ' . $breadcrumb_active_color .'><a href="' . esc_url( home_url( "/". $testimonial_slug ."/" ) ) . '">' . esc_html( $testimonial_name ) . '</a></li>';
		}
		
		if( 'classes' == $post_type ){
			$class_slug = get_theme_mod( 'class_slug' );
			$class_slug = $class_slug ? $class_slug : 'class';
			$class_name = get_theme_mod( 'class_labels' );
			$class_name = $class_name ? $class_name : esc_html__( 'Classes', 'gymx' );
			$home .= '<li class="active" ' . $breadcrumb_active_color .'><a href="' . esc_url( home_url( "/". $class_slug ."/" ) ) . '">' . esc_html( $class_name ) . '</a></li>';
		}
		
		if( 'product' == $post_type && !(is_archive()) ){
			$home .= '<li class="active" ' . $breadcrumb_active_color .'><a href="' . esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ) . '">' . esc_html__( 'Shop', 'gymx' ) . '</a></li>';
		} elseif( 'product' == $post_type && is_archive() ) {
			$home .= '<li class="active" ' . $breadcrumb_active_color .'>' . esc_html__( 'Shop', 'gymx' ) . '</li>';
		}
		
		$breadcrumb = '';
		if ( $ancestors ) {
			foreach ( $ancestors as $ancestor ) {
				$breadcrumb .= '<li><a href="' . esc_url( get_permalink( $ancestor ) ) . '" ' . $breadcrumb_color .'>' . esc_html( get_the_title( $ancestor ) ) . '</a></li>';
			}
		}
		
		if( gymx_is_blog_page() && is_single() ){
			$breadcrumb .= '<li><a href="' . esc_url( get_permalink( get_option( 'page_for_posts' ) ) ) . '" ' . $breadcrumb_color .'>' . esc_html( $blog_title ) . '</a></li><li class="active">' . esc_html( get_the_title( gymx_get_the_post_id() ) ) . '</li>';
		} elseif( gymx_is_blog_page() ){
			$breadcrumb .= '<li class="active" ' . $breadcrumb_active_color .'>' . esc_html( $blog_title ) . '</li>';
		} elseif( is_post_type_archive('product') || is_archive() ){
			//nothing
		} else {
			$breadcrumb .= '<li class="active" ' . $breadcrumb_active_color .'>' . esc_html( get_the_title( gymx_get_the_post_id() ) ) . '</li>';
		}
		
		if( 'trainers' == get_post_type() )
			rewind_posts();
		
		return $before . $home . $breadcrumb . $after;
	}
}

/**
 * Provides translation support for plugins such as WPML
 */
function gymx_translate_theme_mod( $id, $content ) {

	// Return false if no content is found
	if ( ! $content ) {
		return false;
	}

	// WPML translation
	if ( function_exists( 'icl_t' ) && $id ) {
		$content = icl_t( 'Theme Mod', $id, $content );
	}

	// Return the content
	return $content;

}

/**
 * Register theme mods for translations
 */
function gymx_register_theme_mod_strings() {
	return apply_filters( 'gymx_register_theme_mod_strings', array(
		'gymx_logo_img'                 => false,
		'gymx_logo_img_transparent'     => false,
		'gymx_logo2x_img'           	=> false,
		'gymx_logo2x_img_transparent'   => false,
		'gymx_logo_mobile'          	=> false,
		'gymx_logo2x_mobile'            => false,
		'gymx_logo_padding_top'         => false,
		'gymx_logo_padding_bottom'      => false,
		'gymx_blog_title'				=> esc_html__('Our Blog','gymx'),
		'gymx_blog_read_more'           => esc_html__('Read more','gymx'),
		'gymx_footer_text'          	=> esc_html__('Copyright 2018 by themetwins. GymX Theme crafted with love.','gymx')
	) );
}

/**
 * Returns the correct classname for any specific column grid
 *
 */
function gymx_grid_class( $col = '4' ) {
	return apply_filters( 'gymx_grid_class', 'span_1_of_'. $col );
}

// Replaces the excerpt "more" text by a link
function gymx_excerpt_more($more) {
   	global $post;
	//return '<div class="read-more-link-wrapper"><a class="read-more-link" href="'. get_permalink($post->ID) . '">' .esc_html__('Read more', 'gymx') . '<i class="icon-next"></i></a></div>';
	return '...';
}
add_filter('excerpt_more', 'gymx_excerpt_more');

/* Adds a custom read more link to all excerpts, manually or automatically generated */
function gymx_all_excerpts_get_more_link($post_excerpt) {
	$read_more_text = get_theme_mod('gymx_blog_read_more', 'Read more');
	$read_more_text = gymx_translate_theme_mod('gymx_blog_read_more', $read_more_text);
	
    return $post_excerpt . '<div class="read-more-link-wrapper text-center"><a class="read-more-link" href="'. get_permalink(get_the_ID()) . '"><i class="icon-next"></i>' . esc_html($read_more_text) . '</a></div>';
}
add_filter('wp_trim_excerpt', 'gymx_all_excerpts_get_more_link');

// Custom Excerpt Length
function gymx_custom_excerpt($limit=50) {
	$read_more_text = get_theme_mod('gymx_blog_read_more', 'Read more');
	$read_more_text = gymx_translate_theme_mod('gymx_blog_read_more', $read_more_text);
	
	return strip_shortcodes(wp_trim_words(get_the_content(), $limit, '... <div class="read-more-link-wrapper"><a class="read-more-link" href="'. get_permalink() .'"><i class="icon-next"></i>' . esc_html($read_more_text) . '</a></div>'));
}

if(!function_exists('gymx_contact_form_7_installed')) {
	/**
	 * Function that checks if contact form 7 installed
	 * @return bool
	 */
	function gymx_contact_form_7_installed() {
		//is Contact Form 7 installed?
		if(defined('WPCF7_VERSION')) {
			return true;
		}

		return false;
	}
}

/* ------------------------------------------------------------------------ */
/* Helper - hex2rgba
/* By: http://mekshq.com/how-to-convert-hexadecimal-color-code-to-rgb-or-rgba-using-php/
/* ------------------------------------------------------------------------ */
function gymx_hex2rgba($color, $opacity = false) {
	$default = 'rgb(0,0,0)';
	if(empty($color)){
		return $default; 
	}
	
    // 3 or 6 hex digits, or the empty string.
    if ( !preg_match('|^#([A-Fa-f0-9]{3}){1,2}$|', $color ) ) {
    	return $default;
    }

    if ($color[0] == '#' ) {
    	$color = substr( $color, 1 );
    }

    if (strlen($color) == 6) {
            $hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
    } elseif ( strlen( $color ) == 3 ) {
            $hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
    } else {
            return $default;
    }

    $rgb =  array_map('hexdec', $hex);

    if($opacity){
    	if(abs($opacity) > 1)
    		$opacity = 1.0;
    	$output = 'rgba('.implode(",",$rgb).','.$opacity.')';
    } else {
    	$output = 'rgb('.implode(",",$rgb).')';
    }

    return $output;
}
/* ------------------------------------------------------------------------ */
/* Helper - expand allowed tags()
/* Source: https://gist.github.com/adamsilverstein/10783774
/* ------------------------------------------------------------------------ */
function gymx_allowed_tags() {
	$my_allowed = wp_kses_allowed_html( 'post' );
	// iframe
	$my_allowed['iframe'] = array(
		'src'             => array(),
		'height'          => array(),
		'width'           => array(),
		'frameborder'     => array(),
		'allowfullscreen' => array(),
	); 
	return $my_allowed;
}

/**
 * Custom output for the Comments template
 */

function gymx_custom_comments( $comment, $args, $depth ) {
    $GLOBALS['comment'] = $comment;
    switch( $comment->comment_type ) :
        case 'pingback' :
        case 'trackback' : ?>
            <li <?php comment_class(); ?> id="comment<?php comment_ID(); ?>">
            <div class="back-link"><?php comment_author_link(); ?></div>
        <?php break;
        default : ?>
            <li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
            <div class="comment-article pdb50">
 			<div class="row">
            	<div class="col-sm-2">
                	<?php echo get_avatar( $comment, 100 ); ?>
                </div>
                <div class="col-sm-10">
                	<div class="comment-body">
                    	<div class="comment-author">
                        	<span class="author-name"><?php comment_author(); ?></span>
                            <time datetime="<?php comment_time( 'c' ); ?>" class="comment-time">
                                <span class="date">
                                <?php comment_date('d. M y'); ?>
                                </span>
                                <span class="time">
                                <?php comment_time(); ?>
                                </span>
                            </time>
                            <span class="reply pull-right">
								<?php 
                                    comment_reply_link( array_merge( $args, array( 
                                    'reply_text' => esc_html__('Reply', 'gymx'),
									'before' => '<i class="icon-reply"></i>',
                                    'depth' => $depth,
                                    'max_depth' => $args['max_depth'] 
                                    ) ) ); 
                                ?>
							</span><!-- .reply -->
                        </div>
                        <div class="comment-text pdt35">
                        	<?php comment_text(); ?>
                        </div>
                    </div>
                </div>
            </div>
            </div><!-- #comment-<?php comment_ID(); ?> -->
        <?php // End the default styling of comment
        break;
    endswitch;
}

/**
 * Check if Gutenberg is active
 */
function gymx_is_gutenberg_active() {
	global $wp_version;

	if ( version_compare( $wp_version, '5', '>=' ) ) {
		return true;
	}

	if ( function_exists( 'the_gutenberg_project' ) ) {
		return true;
	}

	return false;
}