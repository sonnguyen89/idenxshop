<?php
/**
 * footer.php
 * @package WordPress
 * @subpackage Chakta
 * @since Chakta 1.0
 * 
 */
 ?>
 
	<?php do_action('chakta_top_footer');?>
	
	<?php chakta_do_action( 'chakta_before_main_footer'); ?>

	<?php if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'footer' ) ) { ?>
		<?php
        /**
        * Hook: chakta_main_footer
        *
        * @hooked chakta_main_footer_function - 10
        */
        do_action( 'chakta_main_footer' );
	
		?>
	<?php } ?>

	<?php chakta_do_action( 'chakta_after_main_footer'); ?>        

        <?php wp_footer(); ?>
    </body>
</html>