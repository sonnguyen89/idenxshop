<?php
/**
 * Theme Breadcrumbs
 * Echoes the current breadcrumbs. Supports EDD built in taxs.
 *
 * @return   string
 * @access   private
 * @since    1.0
*/

if ( ! function_exists( 'chakta_breadcrubms' ) ) {
    function chakta_breadcrubms() {
        global $wp_query, $post, $paged;

        $space      = '';
        $on_front   = get_option( 'show_on_front' );
        $blog_page  = get_option( 'page_for_posts' );
        $separator  = '';
        $link       = apply_filters( 'chakta_breadcrumb_link', '<li><a  href="%1$s" title="%2$s" rel="bookmark">%2$s</a> </li>  ' );
        $current    = apply_filters( 'chakta_breadcrumb_current', '<li><span>%s</span></li>' );

        if ( ( $on_front == 'page' && is_front_page() ) || ( $on_front == 'posts' && is_home() ) ) {
            return;
        }

        $out = '';

        if ( $on_front == "page" && is_home() ) {
            $blog_title = isset( $blog_page ) ? get_the_title( $blog_page ) : esc_html__( 'Our Blog', 'chakta-core' );
            $out .= sprintf( $link, home_url(), esc_html__( 'Home', 'chakta-core' ) ) . $separator . sprintf( $current, $blog_title );
        } else {
            $out .= sprintf( $link, home_url(), esc_html__( 'Home', 'chakta-core' ) );
        }

        if ( is_singular() ) {

            if ( is_singular( 'post' ) && $blog_page > 0 ) {
                $out .= $separator . sprintf( $link, get_permalink( $blog_page ), esc_attr( get_the_title( $blog_page ) ) );
            }

            if ( $post->post_parent > 0 ) {
                if ( isset( $post->ancestors ) ) {
                    if ( is_array( $post->ancestors ) )
                        $ancestors = array_values( $post->ancestors );
                    else
                        $ancestors = array( $post->ancestors );
                } else {
                    $ancestors = array( $post->post_parent );
                }
                foreach ( array_reverse( $ancestors ) as $key => $value ) {
                    $out .= $separator . sprintf( $link, get_permalink( $value ), esc_attr( get_the_title( $value ) ) );
                }
            }

            $post_type = get_post_type();
            if ( get_post_type_archive_link( $post_type ) ) {
                $post_type_obj = get_post_type_object( get_post_type($post) );
                $out .= $separator . sprintf( $link, get_post_type_archive_link( $post_type ), esc_attr( $post_type_obj->labels->menu_name ) );
            }

            $out .= $separator . sprintf( $current, get_the_title() );

        } else {
            if ( is_post_type_archive() ) {
                $post_type = get_post_type();
                $post_type_obj = get_post_type_object( get_post_type($post) );
                $out .= $separator . sprintf( $current, $post_type_obj->labels->menu_name );
            } else if ( is_tax() ) {
                if ( is_tax( 'download_tag' ) || is_tax( 'download_category' ) ) {
                    $post_type = get_post_type();
                    $post_type_obj = get_post_type_object( get_post_type($post) );
                    $out .= $separator . sprintf( $link, get_post_type_archive_link( $post_type ), esc_attr( $post_type_obj->labels->menu_name ) );
                }
                $out .= $separator . sprintf( $current, $wp_query->queried_object->name );
            } else if ( is_category() ) {
                $out .= $separator . esc_html__( 'Category : ', 'chakta-core' ) . sprintf( $current, $wp_query->queried_object->name );
            } else if ( is_tag() ) {
                $out .= $separator . esc_html__( 'Tag : ', 'chakta-core' ) . sprintf( $current, $wp_query->queried_object->name );
            } else if ( is_date() ) {
                $out .= $separator;
                if ( is_day() ) {
                    global $wp_locale;
                    $out .= sprintf( $link, get_month_link( get_query_var( 'year' ), get_query_var( 'monthnum' ) ), $wp_locale->get_month( get_query_var( 'monthnum' ) ).' '.get_query_var( 'year' ) );
                    $out .= $separator . sprintf( $current, get_the_date() );
                } else if ( is_month() ) {
                    $out .= sprintf( $current, single_month_title( ' ', false ) );
                } else if ( is_year() ) {
                    $out .= sprintf( $current, get_query_var( 'year' ) );
                }
            } else if ( is_404() ) {
                $out .= $separator . sprintf( $current, esc_html__( 'Error 404', 'chakta-core' ) );
            } else if ( is_search() ) {
                $out .= $separator . sprintf( $current, esc_html__( 'Search', 'chakta-core' ) );
            }

        }

        $out .= '';
        return  '<ul class="breadcrumb-menu">'.apply_filters( 'chakta_breadcrumbs_out', $out ).'</ul>';
    }
}
// Hooks into the chakta theme
add_action( 'chakta_before_template_header', 'chakta_breadcrubms' );