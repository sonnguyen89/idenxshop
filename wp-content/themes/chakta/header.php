<?php
/**
 * header.php
 * @package WordPress
 * @subpackage Chakta
 * @since Chakta 1.0
 * 
 */
 ?>
 
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( "charset" ); ?>">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

	<?php if (!get_theme_mod( 'chakta_preloader' )) { ?>
		<div class="preloader">
			<div class="lds-ellipsis">
				<span></span>
				<span></span>
				<span></span>
			</div>
		</div>
	<?php } ?>

	<?php chakta_do_action( 'chakta_before_main_header'); ?>

	<?php if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'header' ) ) { ?>
		<?php
        /**
        * Hook: chakta_main_header
        *
        * @hooked chakta_main_header_function - 10
        */
        do_action( 'chakta_main_header' );
	
		?>
	<?php } ?>

	<?php chakta_do_action( 'chakta_after_main_header'); ?>