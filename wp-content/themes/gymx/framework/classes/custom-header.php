<?php
/**
 * Sample implementation of the Custom Header feature
 * http://codex.wordpress.org/Custom_Headers
 *
 *
 */

/**
 * Set up the WordPress core custom header feature.
 *
 * @uses gymx_header_style()
 * @uses gymx_admin_header_style()
 * @uses gymx_admin_header_image()
 */
function gymx_custom_header_setup() {
	add_theme_support( 'custom-header', apply_filters( 'gymx_custom_header_args', array(
		'default-image'          => '',
		'default-text-color'     => '000000',
		'width'                  => 1000,
		'height'                 => 250,
		'flex-height'            => true,
		'wp-head-callback'       => 'gymx_header_style',
		'admin-head-callback'    => 'gymx_admin_header_style',
		'admin-preview-callback' => 'gymx_admin_header_image',
	) ) );
}
add_action( 'after_setup_theme', 'gymx_custom_header_setup' );

if ( ! function_exists( 'gymx_header_style' ) ) :
/**
 * Styles the header image and text displayed on the blog
 *
 * @see gymx_custom_header_setup().
 */
function gymx_header_style() {
	$header_text_color = get_header_textcolor();

	if ( get_theme_support( 'custom-header', 'default-text-color' ) === $header_text_color ) {
		return;
	}

	// If we get this far, we have custom styles. Let's do this.
	?>
	<style type="text/css">
	<?php
		// Has the text been hidden?
		if ( 'blank' == $header_text_color ) :
	?>
		.site-title,
		.site-description {
			position: absolute;
			clip: rect(1px, 1px, 1px, 1px);
		}
	<?php
		// If the user has set a custom color for the text use that
		else :
	?>
		.site-title a,
		.site-description {
			color: #<?php echo esc_attr( $header_text_color ); ?>;
		}
	<?php endif; ?>
	</style>
	<?php
}
endif; // gymx_header_style

if ( ! function_exists( 'gymx_admin_header_style' ) ) :
/**
 * Styles the header image displayed on the Appearance > Header admin panel.
 *
 * @see gymx_custom_header_setup().
 */
function gymx_admin_header_style() {
?>
	<style type="text/css">
		.appearance_page_custom-header #headimg {
			border: none;
		}
		#headimg h1,
		#desc {
		}
		#headimg h1 {
		}
		#headimg h1 a {
		}
		#desc {
		}
		#headimg img {
		}
	</style>
<?php
}
endif; // gymx_admin_header_style

if ( ! function_exists( 'gymx_admin_header_image' ) ) :
/**
 * Custom header image markup displayed on the Appearance > Header admin panel.
 *
 * @see gymx_custom_header_setup().
 */
function gymx_admin_header_image() { ?>
	<div id="headimg">
		<h1 class="displaying-header-text"><a id="name"<?php echo sprintf( ' style="color:#%s;"', get_header_textcolor() ); ?> onclick="return false;" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a></h1>
		<div class="displaying-header-text" id="desc"<?php echo sprintf( ' style="color:#%s;"', get_header_textcolor() ); ?>><?php bloginfo( 'description' ); ?></div>
		<?php if ( get_header_image() ) : ?>
		<img src="<?php header_image(); ?>" alt="<?php esc_html__( 'Admin Header Image', 'gymx' ); ?>">
		<?php endif; ?>
	</div>
<?php
}
endif; // gymx_admin_header_image