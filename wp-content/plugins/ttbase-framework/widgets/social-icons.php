<?php
/**
 * TTBase Social Icons Widget
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Start class
if ( ! class_exists( 'TTBase_Framework_Social_Icons_Widget' ) ) {
    class TTBase_Framework_Social_Icons_Widget extends WP_Widget {

        /**
         * Register widget with WordPress.
         *
         * @since 1.0.0
         */
        function __construct() {
            parent::__construct(FALSE, $name = esc_html__('TTBase Social Media Icons', 'ttbase-framework'), array(
                'description' => esc_html__('Add font awesome or streamline icons for your social media.', 'ttbase-framework')
            ));

            add_action( 'load-widgets.php', array( $this, 'scripts' ), 100 );
        }

        /**
         * Enqueue font awesome style
         */
        public function scripts() {
            wp_enqueue_style( 'wp-color-picker' );
            wp_enqueue_script( 'wp-color-picker' );
            wp_enqueue_script( 'underscore' );
        }

        /**
         * Front-end display of widget.
         *
         * @param array $args     Widget arguments.
         * @param array $instance Saved values from database.
         */
        function widget( $args, $instance ) {

            // Extract args
            extract( $args );

            // Get social services and return nothing if none are defined
            $social_services = isset( $instance['social_services'] ) ? $instance['social_services'] : '';
            if ( ! $social_services ) return;

            // Define vars
            $title              = isset( $instance['title'] ) ? $instance['title'] : '';
            $title              = apply_filters( 'widget_title', $title );
            $description        = isset( $instance['description'] ) ? $instance['description'] : '';
            $style              = isset( $instance['style'] ) ? $instance['style'] : '';
            $font               = isset( $instance['font'] ) ? $instance['font'] : '';
            $target             = isset( $instance['target'] ) ? $instance['target'] : '';
            $target             = ( 'blank' == $target ) ? ' target="_blank"' : '';
            $size               = isset( $instance['size'] ) ? intval( $instance['size'] ) : '';
            $size               = ( $size ) ? ttbase_framework_sanitize_data( $size, 'px' ) : '';
            $border_width       = isset( $instance['border_width'] ) ? intval( $instance['border_width'] ) : '';
            $border_width       = ( $border_width ) ? ttbase_framework_sanitize_data( $border_width, 'px' ) : '';
            $font_size          = isset( $instance['font_size'] ) ? intval( $instance['font_size'] ) : '';
            $font_size          = ( $font_size ) ? ttbase_framework_sanitize_data( $font_size, 'font_size' ) : '';
            $social_services    = isset( $instance['social_services'] ) ? $instance['social_services'] : '';


            // Before widget WP hook
            echo $before_widget;

            // Display widget title if defined
            if ( $title ) {
                echo $before_title . $title . $after_title;
            } ?>

            <div class="social-icon-widget clearfix">

                <?php
                // Inline style
                $add_style = '';
                $border_style = '';
                if ( '40' != $size && $size ) {
                    $add_style .= 'height:'. $size .';width:'. $size .';line-height:'. $size .';';
                }
                if ( '20' != $font_size && $font_size ) {
                    $add_style .= 'font-size:'. $font_size .';';
                }
                if ( '2' != $border_width && $border_width ) {
                    $border_style .= 'border-width:'. $border_width .';';
                }
                if ( $add_style ) {
                    $add_style = ' style="' . esc_attr( $add_style ) . '"';
                }
                if ( $border_style ) {
                    $border_style = ' style="' . esc_attr( $border_style ) . '"';
                }?>

                <?php
                // Description
                if ( $description ) : ?>

                    <div class="desc clearfix">
                        <?php echo esc_html($description); ?>
                    </div><!-- .desc -->

                <?php endif; ?>

                <ul class="<?php echo sanitize_html_class($style); ?>">

                    <?php
                    // Loop through each social service and display font icon
                    foreach( $social_services as $key => $service ) {
                        $link = ! empty( $service['url'] ) ? $service['url'] : null;
                        $name = $service['name'];
                        if ( $link ) {
                            if ($font == 'streamline') {
                                echo '<li class="social-widget-'. $key .'"' . $border_style . '><a href="'. esc_url( $link ) .'" title="'. esc_attr( $name ) .'"'. $add_style . $target .'><i class="sl sl-'. $key .'"></i></a></li>';
                            }
                            else {
                                if ( 'youtube' == $key ) {
                                    $key = 'youtube-play';
                                }
                                echo '<li class="social-widget-'. $key .'"><a href="'. esc_url( $link ) .'" title="'. esc_attr( $name ) .'"'. $add_style . $target .'><i class="fa fa-'. $key .'"></i></a></li>';
                            }

                        }
                    } ?>

                </ul>

            </div><!-- .fontawesome-social-widget -->

            <?php
            // After widget WP hook
            echo $after_widget; ?>

            <?php
        }

        /**
         * Sanitize widget form values as they are saved.
         *
         * @see WP_Widget::update()
         * @since 1.0.0
         *
         * @param array $new_instance Values just sent to be saved.
         * @param array $old_instance Previously saved values from database.
         *
         * @return array Updated safe values to be saved.
         */
        function update( $new, $old ) {
            $instance = $old;

            $instance['title']              = ! empty( $new['title'] ) ? strip_tags( $new['title'] ) : null;
            $instance['description']        = ! empty( $new['description'] ) ? $new['description'] : null;
            $instance['style']              = ! empty( $new['style'] ) ? strip_tags( $new['style'] ) : 'dark';
            $instance['target']             = ! empty( $new['target'] ) ? strip_tags( $new['target'] ) : 'blank';
            $instance['size']               = ! empty( $new['size'] ) ? strip_tags( $new['size'] ) : '40px';
            $instance['font_size']          = ! empty( $new['font_size'] ) ? strip_tags( $new['font_size'] ) : '20px';
            $instance['border_width']       = ! empty( $new['border_width'] ) ? strip_tags( $new['border_width'] ) : '2px';
            $instance['font']               = ! empty( $new['font'] ) ? strip_tags( $new['font'] ) : 'streamline';
            $instance['social_services']    = $new['social_services'];

            return $instance;
        }

        /**
         * Back-end widget form.
         *
         * @see WP_Widget::form()
         * @since 1.0.0
         *
         * @param array $instance Previously saved values from database.
         */
        function form( $instance ) {
            $defaults =  array(
                'title'             => esc_html__('Connect', 'ttbase-framework' ),
                'description'       => '',
                'style'             => 'dark',
                'font'              => 'streamline',
                'font_size'         => '20px',
                'border_width'      => '2px',
                'target'            => 'blank',
                'size'              => '40px',
                'social_services'   => array(
                    'twitter' => array(
                        'name' => 'Twitter',
                        'url' => ''
                    ),
                    'facebook' => array(
                        'name' => 'Facebook',
                        'url' => ''
                    ),
                    'instagram' => array(
                        'name' => 'Instagram',
                        'url' => ''
                    ),
                    'google-plus' => array(
                        'name' => 'GooglePlus',
                        'url' => ''
                    ),
                    'linkedin' => array(
                        'name' => 'LinkedIn',
                        'url' => ''
                    ),
                    'pinterest' => array(
                        'name' => 'Pinterest',
                        'url' => ''
                    ),
                    'dribbble' => array(
                        'name' => 'Dribbble',
                        'url' => ''
                    ),
                    'flickr' => array(
                        'name' => 'Flickr',
                        'url' => ''
                    ),
                    'vk' => array(
                        'name' => 'VK',
                        'url' => ''
                    ),
                    'tumblr' => array(
                        'name' => 'Tumblr',
                        'url' => ''
                    ),
                    'skype' => array(
                        'name' => 'Skype',
                        'url' => ''
                    ),
                    'xing' => array(
                        'name' => 'Xing',
                        'url' => ''
                    ),
                    'vimeo-square' => array(
                        'name' => 'Vimeo',
                        'url' => ''
                    ),
                    'youtube' => array(
                        'name' => 'Youtube',
                        'url' => ''
                    ),
                ),
            );

            $instance = wp_parse_args( ( array ) $instance, $defaults ); ?>

            <p>
                <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e( 'Title:', 'ttbase-framework' ); ?></label>
                <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($instance['title']); ?>" />
            </p>

            <p>
                <label for="<?php echo esc_attr($this->get_field_id('description')); ?>"><?php esc_html_e( 'Description:','ttbase-framework' ); ?></label>
                <textarea class="widefat" rows="5" cols="20" id="<?php echo esc_attr($this->get_field_id('description')); ?>" name="<?php echo esc_attr($this->get_field_name('description')); ?>"><?php echo esc_html($instance['description']); ?></textarea>
            </p>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('font')); ?>"><?php esc_html_e( 'Icon Font', 'ttbase-framework'); ?></label>
                <br />
                <select class='ttbase-widget-select' name="<?php echo esc_attr($this->get_field_name('font')); ?>" id="<?php echo esc_attr($this->get_field_id('font')); ?>">
                    <option value="streamline" <?php if ( $instance['font'] == 'streamline' ) { ?>selected="selected"<?php } ?>><?php esc_html_e( 'Streamline Icons', 'ttbase-framework' ); ?></option>
                    <option value="fontawesome" <?php if ( $instance['font'] == 'fontawesome' ) { ?>selected="selected"<?php } ?>><?php esc_html_e( 'Font Awesome Icons', 'ttbase-framework' ); ?></option>
                </select>
            </p>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('style')); ?>"><?php esc_html_e( 'Style', 'ttbase-framework'); ?></label>
                <br />
                <select class='ttbase-widget-select' name="<?php echo esc_attr($this->get_field_name('style')); ?>" id="<?php echo esc_attr($this->get_field_id('style')); ?>">
                    <option value="dark" <?php if ( $instance['style'] == 'dark' ) { ?>selected="selected"<?php } ?>><?php esc_html_e( 'Dark', 'ttbase-framework' ); ?></option>
                    <option value="color" <?php if ( $instance['style'] == 'color' ) { ?>selected="selected"<?php } ?>><?php esc_html_e( 'Color', 'ttbase-framework' ); ?></option>
                </select>
            </p>

            <p>
                <label for="<?php echo esc_attr($this->get_field_id('target')); ?>"><?php esc_html_e( 'Link Target:', 'ttbase-framework' ); ?></label>
                <br />
                <select class='ttbase-widget-select' name="<?php echo esc_attr($this->get_field_name('target')); ?>" id="<?php echo esc_attr($this->get_field_id('target')); ?>">
                    <option value="blank" <?php if ($instance['target'] == 'blank') { ?>selected="selected"<?php } ?>><?php esc_html_e( 'Blank', 'ttbase-framework' ); ?></option>
                    <option value="self" <?php if ($instance['target'] == 'self') { ?>selected="selected"<?php } ?>><?php esc_html_e( 'Self', 'ttbase-framework' ); ?></option>
                </select>
            </p>

            <p>
                <label for="<?php echo esc_attr($this->get_field_id('size')); ?>"><?php esc_html_e( 'Icon Size', 'ttbase-framework' ); ?></label>
                <input class="widefat" id="<?php echo esc_attr($this->get_field_id('size')); ?>" name="<?php echo esc_attr($this->get_field_name('size')); ?>" type="text" value="<?php echo esc_attr($instance['size']); ?>" />
                <small><?php esc_html_e( 'Enter size for the height/width of the icon.', 'ttbase-framework'); ?></small>
            </p>

            <p>
                <label for="<?php echo esc_attr($this->get_field_id('font_size')); ?>"><?php esc_html_e( 'Icon Font Size', 'ttbase-framework' ); ?></label>
                <input class="widefat" id="<?php echo esc_attr($this->get_field_id('font_size')); ?>" name="<?php echo esc_attr($this->get_field_name('font_size')); ?>" type="text" value="<?php echo esc_attr($instance['font_size']); ?>" />
                <small><?php esc_html_e( 'Enter a custom font size for the icons.', 'ttbase-framework'); ?></small>
            </p>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('border_width')); ?>"><?php esc_html_e( 'Icon Border Width', 'ttbase-framework' ); ?></label>
                <input class="widefat" id="<?php echo esc_attr($this->get_field_id('border_width')); ?>" name="<?php echo esc_attr($this->get_field_name('border_width')); ?>" type="text" value="<?php echo esc_attr($instance['border_width']); ?>" />
                <small><?php esc_html_e( 'Enter a custom border width for the icons.', 'ttbase-framework'); ?></small>
            </p>

            <?php
            $field_id_services   = $this->get_field_id( 'social_services' );
            $field_name_services = $this->get_field_name( 'social_services' ); ?>
            <h3 style="margin-top:20px;margin-bottom:0;"><?php esc_html_e( 'Social Links','ttbase-framework' ); ?></h3>
            <small style="display:block;margin-bottom:10px;"><?php esc_html_e( 'Enter the full URL to your social profile', 'ttbase-framework' ); ?></small>
            <ul id="<?php echo $field_id_services; ?>" class="wpex-services-list">
                <input type="hidden" id="<?php echo $field_name_services; ?>" value="<?php echo $field_name_services; ?>">
                <input type="hidden" id="<?php echo wp_create_nonce( 'ttbase_social_icons_widget_nonce' ); ?>">
                <?php
                $display_services = isset ( $instance['social_services'] ) ? $instance['social_services']: '';
                if ( ! empty( $display_services ) ) {
                    foreach( $display_services as $key => $service ) {
                        $url  = isset( $service['url'] ) ? $service['url'] : 0;
                        $name = isset( $service['name'] )  ? $service['name'] : ''; ?>
                        <li id="<?php echo $field_id_services; ?>_0<?php echo $key ?>">
                            <p>
                                <label for="<?php echo $field_id_services; ?>-<?php echo $key ?>-name"><?php echo $name; ?>:</label>
                                <input type="hidden" id="<?php echo $field_id_services; ?>-<?php echo $key ?>-url" name="<?php echo $field_name_services .'['.$key.'][name]'; ?>" value="<?php echo $name; ?>">
                                <input type="url" class="widefat" id="<?php echo $field_id_services; ?>-<?php echo $key ?>-url" name="<?php echo $field_name_services .'['.$key.'][url]'; ?>" value="<?php echo $url; ?>" />
                            </p>
                        </li>
                    <?php }
                } ?>
            </ul>
            <?php
        }
    }
}

// Register the WPEX_Tabs_Widget custom widget
if ( ! function_exists( 'framework_register_social_icons_widget' ) ) {
    function framework_register_social_icons_widget() {
        register_widget( 'TTBase_Framework_Social_Icons_Widget' );
    }
}
add_action( 'widgets_init', 'framework_register_social_icons_widget' );

// Widget Styles
if ( ! function_exists( 'ttbase_framework_social_icons_widget_style' ) ) {
    function ttbase_framework_social_icons_widget_style() { ?>
        <style>
            .ttbase-services-list li {
                cursor: move;
                background: #fafafa;
                padding: 10px;
                border: 1px solid #e5e5e5;
                margin-bottom: 10px;
            }
            .ttbase-services-list li p {
                margin: 0;
            }
            .ttbase-services-list li label {
                margin-bottom: 3px;
                display: block;
                color: #222;
            }
            .ttbase-services-list .placeholder {
                border: 1px dashed #e3e3e3;
            }
        </style>
        <?php
    }
}

// Widget AJAX functions
function ttbase_framework_load_social_icons_widget_scripts() {
    if ( !  is_admin() ) {
        return;
    }
    global $pagenow;
    if ( is_admin() && $pagenow == "widgets.php" ) {
        add_action('admin_head', 'ttbase_framework_social_icons_widget_style');
        add_action('admin_footer', 'ttbase_framework_add_social_icons_ajax_trigger');
        function ttbase_framework_add_social_icons_ajax_trigger() { ?>
            <script type="text/javascript" >
                jQuery(document).ready(function($) {
                    jQuery(document).ajaxSuccess(function(e, xhr, settings) {
                        var widget_id_base = 'ttbase_social_icons_widget';
                        if (settings.data.search('action=save-widget') != -1 && settings.data.search('id_base=' + widget_id_base) != -1) {
                            ttbaseSortServices();
                        }
                    });
                    function ttbaseSortServices() {
                        jQuery('.ttbase-services-list').each( function() {
                            var id = jQuery(this).attr('id');
                            $('#'+ id).sortable({
                                placeholder: "placeholder",
                                opacity: 0.6
                            });
                        });
                    }
                    ttbaseSortServices();
                });
            </script>
            <?php
        }
    }
}
add_action( 'admin_init', 'ttbase_framework_load_social_icons_widget_scripts' );