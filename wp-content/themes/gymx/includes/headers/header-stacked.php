<?php
/**
 * Header Stacked
 */
$topbar_right_content = get_theme_mod( 'gymx_topbar_right_content', 'text' );
$nav_text_align = get_theme_mod( 'gymx_nav_text_align', 'text-left' );
?>
<header id="masthead" class="header">
    <nav class="navigation">
        <div class="topbar v-align">
            <div class="container">
                <div class="row v-align">
                    <?php get_template_part( 'includes/headers/header-logo' ); ?>
                    <!-- Menu -->
                    <div class="col-md-12">
                        <div class="topbar-right-content pull-right" >
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
                        </div>
                        <div class="header-widgets pull-right">
                            <?php dynamic_sidebar( 'header-widgets' ); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="menubar">
            <div class="container">
                <div class="row bottom-row v-align">
                    <div class="col-xs-12 <?php echo esc_attr($nav_text_align); ?>">
                        <?php
                        $page_menu = get_post_meta( $id, 'gymx_post_header_menu', true );
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
        </div>
    </nav>
</header>
