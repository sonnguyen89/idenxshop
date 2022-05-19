<?php
/**
 * woocommerce.php
 * @package WordPress
 * @subpackage Chakta
 * @since Chakta 1.0
 * 
 */
 ?>

<?php if ( class_exists( 'woocommerce' ) ) { ?>
	<?php get_header(); ?>
	
	<?php
	if (is_product()) {
		get_template_part( 'woocommerce', 'single' );
	} elseif(is_tax( 'store' ) ){
		get_template_part( 'archive', 'store' );
	} else {
		get_template_part( 'woocommerce', 'page' );
	}
	?>
	
	<?php get_footer(); ?>
<?php } ?>