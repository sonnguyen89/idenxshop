<?php

get_header();
?>

<div class="wrapper pd75" id="page-wrapper">
    <div class="container">
        <div class="row">
        	<?php
        	// Single Products Page
        	if(is_product()){
        		// Get WooCommerce Single Product Layout from Theme Options
        		$sidebar = get_theme_mod('gymx_wc_single_layout', 'no-sidebar');
        		if($sidebar == 'left-sidebar' || $sidebar == 'right-sidebar')  {
        			$wooclass_single = 'col-md-8';
        		}
        		else{
        			$wooclass_single = 'col-md-12';
        		}
        	?>
        	    <?php if($sidebar == 'left-sidebar' && is_woocommerce()) { ?>
        		<div class="sidebar-left">
        			<?php 
        			    /* WooCommerce Sidebar */
        				get_sidebar('shop'); ?>
        		</div>
        		<?php } ?>
        		<div id="primary" class="<?php echo esc_attr($wooclass_single); ?> product-page">
        			<?php woocommerce_content(); ?>
        		</div> <!-- end content -->
                
                <?php if($sidebar == 'right-sidebar' && is_woocommerce()) { 
                        /* WooCommerce Sidebar */
        				get_sidebar('shop');
        			} ?>
        
        	<?php
        	// Main Shop Layout
        	} else{
                $main_sidebar = get_theme_mod('gymx_wc_main_layout', 'left-sidebar');
        		// Get WooCommerce Layout from Theme Options
        		if( $main_sidebar == 'no-sidebar')  {
        			$wooclass = 'col-md-12';
        		}
        		else{
        			$wooclass = 'col-md-8';
        		}
        	?>
        	
        	    <?php if($main_sidebar == 'left-sidebar' && is_woocommerce()) { ?>
            		<div class="sidebar-left">
            			<?php 
            			    /* WooCommerce Sidebar */
            				get_sidebar('shop'); ?>
            		</div>
        		<?php } ?>
        		
        		<div id="primary" class="<?php echo esc_attr($wooclass); ?> <?php if(!is_product()){ echo esc_attr(get_theme_mod('gymx_wc_columns', 'columns-3')); } ?>">
        			<?php woocommerce_content(); ?>
        		</div> <!-- end content -->
        
        		<?php if($main_sidebar == 'right-sidebar' && is_woocommerce()) { 
                    /* WooCommerce Sidebar */
    				get_sidebar('shop');
    			} ?>
        
        	<?php } // end-if main shop layout ?>
    	</div>
	</div>
	
</div> <!-- end page-wrap -->
	
<?php get_footer(); ?>