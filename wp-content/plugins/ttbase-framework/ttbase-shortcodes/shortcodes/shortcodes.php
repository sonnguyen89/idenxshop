<?php
/**
 * Register all shortcodes
 */

// Widget Support -------------------------------------------------------------------------- >
add_filter( 'widget_text', 'do_shortcode' );

// "Fix" Shortcodes -------------------------------------------------------------------------- >
function ttbase_framework_fix_shortcodes($content){   
	$array = array (
		'<p>['    => '[', 
		']</p>'   => ']', 
		']<br />' => ']'
	);
	$content = strtr($content, $array);
	return $content;
}
add_filter( 'the_content', 'ttbase_framework_fix_shortcodes' );

function ttbase_framework_remove_crappy_markup( $string )
{
    $patterns = array(
        '#^s*#',
        '#s*$#'
    );

    return preg_replace($patterns, '', $string);
}

// Include all shortcode parts
require_once( TTBASE_FRAMEWORK_PATH . 'ttbase-shortcodes/shortcodes/parts/blog.php' );
require_once( TTBASE_FRAMEWORK_PATH . 'ttbase-shortcodes/shortcodes/parts/button.php' );
require_once( TTBASE_FRAMEWORK_PATH . 'ttbase-shortcodes/shortcodes/parts/callout.php' );
require_once( TTBASE_FRAMEWORK_PATH . 'ttbase-shortcodes/shortcodes/parts/content-image.php' );
require_once( TTBASE_FRAMEWORK_PATH . 'ttbase-shortcodes/shortcodes/parts/counter.php' );
require_once( TTBASE_FRAMEWORK_PATH . 'ttbase-shortcodes/shortcodes/parts/google-map.php' );
require_once( TTBASE_FRAMEWORK_PATH . 'ttbase-shortcodes/shortcodes/parts/half-carousel.php' );
require_once( TTBASE_FRAMEWORK_PATH . 'ttbase-shortcodes/shortcodes/parts/heading.php' );
require_once( TTBASE_FRAMEWORK_PATH . 'ttbase-shortcodes/shortcodes/parts/highlight.php' );
require_once( TTBASE_FRAMEWORK_PATH . 'ttbase-shortcodes/shortcodes/parts/ft-image-carousel.php' );
require_once( TTBASE_FRAMEWORK_PATH . 'ttbase-shortcodes/shortcodes/parts/icon.php' );
require_once( TTBASE_FRAMEWORK_PATH . 'ttbase-shortcodes/shortcodes/parts/icon-box.php' );
require_once( TTBASE_FRAMEWORK_PATH . 'ttbase-shortcodes/shortcodes/parts/items-list.php' );
require_once( TTBASE_FRAMEWORK_PATH . 'ttbase-shortcodes/shortcodes/parts/image-box.php' );
require_once( TTBASE_FRAMEWORK_PATH . 'ttbase-shortcodes/shortcodes/parts/image-carousel.php' );
require_once( TTBASE_FRAMEWORK_PATH . 'ttbase-shortcodes/shortcodes/parts/image-gallery.php' );
require_once( TTBASE_FRAMEWORK_PATH . 'ttbase-shortcodes/shortcodes/parts/modal.php' );
require_once( TTBASE_FRAMEWORK_PATH . 'ttbase-shortcodes/shortcodes/parts/newsletter.php' );
require_once( TTBASE_FRAMEWORK_PATH . 'ttbase-shortcodes/shortcodes/parts/post-carousel.php' );
require_once( TTBASE_FRAMEWORK_PATH . 'ttbase-shortcodes/shortcodes/parts/post-grid.php' );
require_once( TTBASE_FRAMEWORK_PATH . 'ttbase-shortcodes/shortcodes/parts/pricing.php' );
require_once( TTBASE_FRAMEWORK_PATH . 'ttbase-shortcodes/shortcodes/parts/progressbar.php' );
require_once( TTBASE_FRAMEWORK_PATH . 'ttbase-shortcodes/shortcodes/parts/spacer.php' );
require_once( TTBASE_FRAMEWORK_PATH . 'ttbase-shortcodes/shortcodes/parts/table.php' );
require_once( TTBASE_FRAMEWORK_PATH . 'ttbase-shortcodes/shortcodes/parts/tabs.php' );
require_once( TTBASE_FRAMEWORK_PATH . 'ttbase-shortcodes/shortcodes/parts/testimonial-carousel.php' );
require_once( TTBASE_FRAMEWORK_PATH . 'ttbase-shortcodes/shortcodes/parts/testimonial-grid.php' );
require_once( TTBASE_FRAMEWORK_PATH . 'ttbase-shortcodes/shortcodes/parts/text-intro.php' );
require_once( TTBASE_FRAMEWORK_PATH . 'ttbase-shortcodes/shortcodes/parts/wpml.php' );


