<?php
/**
 * Header Transparent Boxed
 */
$id = gymx_get_the_post_id();
$page_show_header_border = get_post_meta($id, 'gymx_post_header_border_show', true );
if ( $page_show_header_border == '' ) {
	$page_show_header_border = get_theme_mod( 'gymx_header_border_show', 'no-border' );
}
$bottom_border_color = get_post_meta( $id, 'gymx_post_header_bottom_border_color', true );
?>
<header id="masthead" class="header transparent boxed <?php echo esc_attr($page_show_header_border); ?>">
    <nav class="navigation v-align" <?php if($bottom_border_color){?>style="border-bottom-color:<?php echo esc_attr($bottom_border_color); ?>;"<?php } ?>>
        <div class="container">
            <div class="row v-align">
                <?php get_template_part( 'includes/headers/header-logo' ); ?>
                <!-- Menu -->
                <div class="col-md-12">
                     <?php if( function_exists('icl_get_languages') && 'yes' == get_theme_mod('gymx_header_show_wpml','yes') ){ ?>
                       <div class="topbar-wpml pull-right">
					       <?php get_template_part('includes/headers/content-header', 'wpml'); ?>
					   </div>
					<?php } ?>
					
                    <?php if( class_exists('Woocommerce') && 'yes' == get_theme_mod('gymx_header_show_cart','yes') ){ ?>
                       <div class="topbar-cart pull-right">
					       <?php get_template_part('includes/headers/content-header', 'cart'); ?>
					   </div>
					<?php } ?>
					
                    <?php if ( get_theme_mod('gymx_header_show_search','no') == 'yes') { ?>
    				    <div class="topbar-search pull-right">
                            <?php get_template_part('includes/headers/content-header', 'search'); ?>
                        </div>
                   <?php } ?>
                  
                    <?php
                    $page_menu = rwmb_meta( 'gymx_post_header_menu', $id );
                    if ($page_menu != '') {
                        wp_nav_menu( array(
                            'theme_location' => 'main',
                            'menu'              => $page_menu,
                            'container'  => 'div',
                            'container_class' => 'nav-menu pull-right',
                            'fallback_cb'   => false,
                            'menu_class' => 'menu',
                            'menu_id' => 'main-nav',
                            'walker' => new gymx_header_walker_nav_menu()
                        ));
                    }
                    else {
                        wp_nav_menu( array(
                            'theme_location' => 'main',
                            'container'  => 'div',
                            'container_class' => 'nav-menu pull-right',
                            'fallback_cb'   => false,
                            'menu_class' => 'menu',
                            'menu_id' => 'main-nav',
                            'walker' => new gymx_header_walker_nav_menu()
                        ));
                    }
                    ?>
                </div>
            </div>
        </div>
    </nav>
</header>
