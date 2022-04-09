<?php
/**
 * Header Sticky
 */
?>
<nav class="sticky-nav v-align">
    <div class="container">
        <div class="row v-align">
            <div class="col-xs-3 col-md-2">
                <?php get_template_part( 'includes/headers/header-small-logo' ); ?>
            </div>
            <!-- Menu -->
            <div class="col-xs-9 col-sm-10">
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
               <?php }

                    $page_menu = rwmb_meta( 'gymx_post_header_menu', $id );
                    if ($page_menu != '') {
                        wp_nav_menu( array(
                            'theme_location' => 'main',
                            'menu'              => $page_menu,
                            'container'  => 'div',
                            'container_class' => 'nav-menu pull-right',
                            'fallback_cb'   => false,
                            'menu_class' => 'menu',
                            'menu_id' => 'main-nav-sticky',
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
                            'menu_id' => 'main-nav-sticky',
                            'walker' => new gymx_header_walker_nav_menu()
                        ));
                    }
                ?>
            </div>
        </div>
    </div>
</nav>