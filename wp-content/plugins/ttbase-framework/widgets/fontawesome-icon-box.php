<?php
/**
 * TTBase Font Awesome Icon box widget
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'TTBase_Framework_Font_Awesome_Icon_Box_Widget' ) ) {
	class TTBase_Framework_Font_Awesome_Icon_Box_Widget extends WP_Widget {

		/**
		 * Register widget with WordPress.
		 *
		 */
		function __construct() {
			parent::__construct(FALSE, $name = esc_html__('TTBase Font Awesome Icon Box', 'ttbase-framework'), array(
				'description' => esc_html__('Icon Box widget for the header.', 'ttbase-framework')
			));
			
			add_action( 'admin_enqueue_scripts', array( $this, 'scripts' ), 100 );
		}
		
		/**
		 * Enqueue font awesome style
		 */
		public function scripts() {
			wp_enqueue_style( 'wp-color-picker' );
	        wp_enqueue_script( 'wp-color-picker' );
	        wp_enqueue_script( 'underscore' );
			wp_enqueue_style('ttbase-font-awesome', plugins_url( '../css/font-awesome.min.css' , __FILE__ ) );
		}

		/**
         * Front-end display of widget.
         *
         */
		public function widget( $args, $instance ) {
			echo $args['before_widget'];
			if ( ! empty ( $instance['btn_link'] ) ) :
			?>
			<a class="widget-icon-box" href="<?php echo esc_url($instance['btn_link']); ?>" <?php echo empty ( $instance['new_tab'] ) ? '' : 'target="_blank"'; ?>>
			<?php else : ?>
			<div class="widget-icon-box">
			<?php endif; ?>
				<div class="widget-icon-box-icon">
					<?php if ( ! empty ( $instance['icon_color'] ) ) :
					?>
					<i class="fa <?php echo esc_attr($instance['icon']); ?>" style="color:<?php echo esc_attr($instance['icon_color']); ?>"></i>
					<?php else : ?>
					<i class="fa <?php echo esc_attr($instance['icon']); ?>"></i>
					<?php endif; ?>
				</div>
				<div class="widget-icon-box-text">
					<?php if ( ! empty ( $instance['title_color'] ) ) :
					?>
					<h4 class="widget-icon-box-title" style="color:<?php echo esc_attr($instance['title_color']); ?>"><?php echo esc_html($instance['title']); ?></h4>
					<?php else : ?>
					<h4 class="widget-icon-box-title"><?php echo esc_html($instance['title']); ?></h4>
					<?php endif; ?>
					<?php if ( ! empty ( $instance['text_color'] ) ) :
					?>
					<span class="widget-icon-box-description" style="color:<?php echo esc_attr($instance['text_color']); ?>"><?php echo esc_html($instance['text']); ?></span>
					<?php else : ?>
					<span class="widget-icon-box-description"><?php echo esc_html($instance['text']); ?></span>
					<?php endif; ?>
				</div>
			</<?php echo empty ( $instance['btn_link'] ) ? 'div' : 'a'; ?>>
			<?php
			echo $args['after_widget'];
		}

		/**
         * Sanitize widget form values as they are saved.
         *
         */
		public function update( $new_instance, $old_instance ) {
			$instance = array();

			$instance['title']    = wp_kses_post( $new_instance['title'] );
			$instance['title_color'] = strip_tags( $new_instance['title_color'] );
			$instance['text']     = wp_kses_post( $new_instance['text'] );
			$instance['text_color'] = strip_tags( $new_instance['text_color'] );
			$instance['btn_link'] = esc_url_raw( $new_instance['btn_link'] );
			$instance['icon']     = sanitize_key( $new_instance['icon'] );
			$instance['icon_color'] = strip_tags( $new_instance['icon_color'] );
			$instance['new_tab']  = sanitize_key( $new_instance['new_tab'] );

			return $instance;
		}

		/**
         * Back-end widget form.
         *
         */
		public function form( $instance ) {
			$title    = empty( $instance['title'] ) ? '' : $instance['title'];
			$title_color    = empty( $instance['title_color'] ) ? '' : $instance['title_color'];
			$text     = empty( $instance['text'] ) ? '' : $instance['text'];
			$text_color    = empty( $instance['text_color'] ) ? '' : $instance['text_color'];
			$btn_link = empty( $instance['btn_link'] ) ? '' : $instance['btn_link'];
			$icon     = empty( $instance['icon'] ) ? '' : $instance['icon'];
			$icon_color    = empty( $instance['icon_color'] ) ? '' : $instance['icon_color'];
			$new_tab  = empty( $instance['new_tab'] ) ? '' : $instance['new_tab'];

			?>

			<p>
				<label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php esc_html_e( 'Title', 'backend', 'ttbase-framework'); ?>:</label>
				<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id( 'title_color' )); ?>"><?php esc_html_e( 'Title Color:', 'ttbase-framework' ); ?></label>
				<div>
					<input class="color-picker widefat" type="text" id="<?php echo esc_attr($this->get_field_id( 'title_color' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title_color' )); ?>" value="<?php echo esc_attr( $title_color ); ?>" />
				</div>
				
			</p>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id( 'text' )); ?>"><?php esc_html_e( 'Text', 'backend', 'ttbase-framework'); ?>:</label> <br />
				<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'text' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'text' )); ?>" type="text" value="<?php echo esc_attr($text); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id( 'text_color' )); ?>"><?php esc_html_e( 'Text Color:', 'ttbase-framework' ); ?></label>
				<div>
					<input class="color-picker widefat" type="text" id="<?php echo esc_attr($this->get_field_id( 'text_color' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'text_color' )); ?>" value="<?php echo esc_attr( $text_color ); ?>" />
				</div>
				
			</p>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id( 'btn_link' )); ?>"><?php esc_html_e( 'Link', 'backend', 'ttbase-framework'); ?>:</label> <br />
				<small><?php esc_html_e( 'URL to any page, optional.', 'backend', 'ttbase-framework' ); ?></small> <br>
				<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'btn_link' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'btn_link' )); ?>" type="text" value="<?php echo esc_attr($btn_link); ?>" />
			</p>

			<p>
				<input class="checkbox" type="checkbox" <?php checked( $new_tab, 'on' ); ?> id="<?php echo esc_attr($this->get_field_id( 'new_tab' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'new_tab' )); ?>" value="on" />
				<label for="<?php echo esc_attr($this->get_field_id( 'new_tab' )); ?>"><?php esc_html_e('Open link in new tab', 'backend', 'ttbase-framework'); ?></label>
			</p>

			<p>
				<label for="<?php echo esc_attr($this->get_field_id( 'icon' )); ?>"><?php esc_html_e( 'Icon', 'backend', 'ttbase-framework'); ?>:</label> <br />
				<small><?php printf( esc_html_x( 'Click on the icon below or manually select from the %s website', 'backend', 'ttbase-framework'), '<a href="http://fontawesome.io/icons/" target="_blank">FontAwesome</a>' ); ?>.</small>
				<input id="<?php echo esc_attr($this->get_field_id( 'icon' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'icon' )); ?>" type="text" value="<?php echo esc_attr($icon); ?>" class="widefat  js-icon-input" /> <br><br>
				<a class="js-selectable-icon icon-widget" href="#" data-iconname="fa-home"><i class="fa fa-lg fa-home"></i></a>
				<a class="js-selectable-icon icon-widget" href="#" data-iconname="fa-phone"><i class="fa fa-lg fa-phone"></i></a>
				<a class="js-selectable-icon icon-widget" href="#" data-iconname="fa-clock-o"><i class="fa fa-lg fa-clock-o"></i></a>
				<a class="js-selectable-icon icon-widget" href="#" data-iconname="fa-beer"><i class="fa fa-lg fa-beer"></i></a>
				<a class="js-selectable-icon icon-widget" href="#" data-iconname="fa-camera-retro"><i class="fa fa-lg fa-camera-retro"></i></a>
				<a class="js-selectable-icon icon-widget" href="#" data-iconname="fa-check-circle-o"><i class="fa fa-lg fa-check-circle-o"></i></a>
				<a class="js-selectable-icon icon-widget" href="#" data-iconname="fa-cog"><i class="fa fa-lg fa-cog"></i></a>
				<a class="js-selectable-icon icon-widget" href="#" data-iconname="fa-cogs"><i class="fa fa-lg fa-cogs"></i></a>
				<a class="js-selectable-icon icon-widget" href="#" data-iconname="fa-comments-o"><i class="fa fa-lg fa-comments-o"></i></a>
				<a class="js-selectable-icon icon-widget" href="#" data-iconname="fa-compass"><i class="fa fa-lg fa-compass"></i></a>
				<a class="js-selectable-icon icon-widget" href="#" data-iconname="fa-dashboard"><i class="fa fa-lg fa-dashboard"></i></a>
				<a class="js-selectable-icon icon-widget" href="#" data-iconname="fa-download"><i class="fa fa-lg fa-download"></i></a>
				<a class="js-selectable-icon icon-widget" href="#" data-iconname="fa-exclamation-circle"><i class="fa fa-lg fa-exclamation-circle"></i></a>
				<a class="js-selectable-icon icon-widget" href="#" data-iconname="fa-male"><i class="fa fa-lg fa-male"></i></a>
				<a class="js-selectable-icon icon-widget" href="#" data-iconname="fa-female"><i class="fa fa-lg fa-female"></i></a>
				<a class="js-selectable-icon icon-widget" href="#" data-iconname="fa-fire"><i class="fa fa-lg fa-fire"></i></a>
				<a class="js-selectable-icon icon-widget" href="#" data-iconname="fa-flag"><i class="fa fa-lg fa-flag"></i></a>
				<a class="js-selectable-icon icon-widget" href="#" data-iconname="fa-folder-open-o"><i class="fa fa-lg fa-folder-open-o"></i></a>
				<a class="js-selectable-icon icon-widget" href="#" data-iconname="fa-heart"><i class="fa fa-lg fa-heart"></i></a>
				<a class="js-selectable-icon icon-widget" href="#" data-iconname="fa-inbox"><i class="fa fa-lg fa-inbox"></i></a>
				<a class="js-selectable-icon icon-widget" href="#" data-iconname="fa-info-circle"><i class="fa fa-lg fa-info-circle"></i></a>
				<a class="js-selectable-icon icon-widget" href="#" data-iconname="fa-key"><i class="fa fa-lg fa-key"></i></a>
				<a class="js-selectable-icon icon-widget" href="#" data-iconname="fa-laptop"><i class="fa fa-lg fa-laptop"></i></a>
				<a class="js-selectable-icon icon-widget" href="#" data-iconname="fa-leaf"><i class="fa fa-lg fa-leaf"></i></a>
				<a class="js-selectable-icon icon-widget" href="#" data-iconname="fa-map-marker"><i class="fa fa-lg fa-map-marker"></i></a>
				<a class="js-selectable-icon icon-widget" href="#" data-iconname="fa-money"><i class="fa fa-lg fa-money"></i></a>
				<a class="js-selectable-icon icon-widget" href="#" data-iconname="fa-plus-circle"><i class="fa fa-lg fa-plus-circle"></i></a>
				<a class="js-selectable-icon icon-widget" href="#" data-iconname="fa-print"><i class="fa fa-lg fa-print"></i></a>
				<a class="js-selectable-icon icon-widget" href="#" data-iconname="fa-quote-right"><i class="fa fa-lg fa-quote-right"></i></a>
				<a class="js-selectable-icon icon-widget" href="#" data-iconname="fa-quote-left"><i class="fa fa-lg fa-quote-left"></i></a>
				<a class="js-selectable-icon icon-widget" href="#" data-iconname="fa-shopping-cart"><i class="fa fa-lg fa-shopping-cart"></i></a>
				<a class="js-selectable-icon icon-widget" href="#" data-iconname="fa-sitemap"><i class="fa fa-lg fa-sitemap"></i></a>
				<a class="js-selectable-icon icon-widget" href="#" data-iconname="fa-star-o"><i class="fa fa-lg fa-star-o"></i></a>
				<a class="js-selectable-icon icon-widget" href="#" data-iconname="fa-suitcase"><i class="fa fa-lg fa-suitcase"></i></a>
				<a class="js-selectable-icon icon-widget" href="#" data-iconname="fa-thumbs-up"><i class="fa fa-lg fa-thumbs-up"></i></a>
				<a class="js-selectable-icon icon-widget" href="#" data-iconname="fa-tint"><i class="fa fa-lg fa-tint"></i></a>
				<a class="js-selectable-icon icon-widget" href="#" data-iconname="fa-truck"><i class="fa fa-lg fa-truck"></i></a>
				<a class="js-selectable-icon icon-widget" href="#" data-iconname="fa-users"><i class="fa fa-lg fa-users"></i></a>
				<a class="js-selectable-icon icon-widget" href="#" data-iconname="fa-warning"><i class="fa fa-lg fa-warning"></i></a>
				<a class="js-selectable-icon icon-widget" href="#" data-iconname="fa-wrench"><i class="fa fa-lg fa-wrench"></i></a>
				<a class="js-selectable-icon icon-widget" href="#" data-iconname="fa-chevron-right"><i class="fa fa-lg fa-chevron-right"></i></a>
				<a class="js-selectable-icon icon-widget" href="#" data-iconname="fa-chevron-circle-right"><i class="fa fa-lg fa-chevron-circle-right"></i></a>
				<a class="js-selectable-icon icon-widget" href="#" data-iconname="fa-chevron-down"><i class="fa fa-lg fa-chevron-down"></i></a>
				<a class="js-selectable-icon icon-widget" href="#" data-iconname="fa-chevron-circle-down"><i class="fa fa-lg fa-chevron-circle-down"></i></a>
			</p>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id( 'icon_color' )); ?>"><?php esc_html_e( 'Icon Color:', 'ttbase-framework' ); ?></label>
				<div>
					<input class="color-picker widefat" type="text" id="<?php echo esc_attr($this->get_field_id( 'icon_color' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'icon_color' )); ?>" value="<?php echo esc_attr( $icon_color ); ?>" />
				</div>
				
			</p>
			<?php
		}

	}
}

// Register the custom widget
if ( ! function_exists( 'ttbase_framework_register_fa_icon_box_widget' ) ) {
    function ttbase_framework_register_fa_icon_box_widget() {
        register_widget( 'TTBase_Framework_Font_Awesome_Icon_Box_Widget' );
    }
}
add_action( 'widgets_init', 'ttbase_framework_register_fa_icon_box_widget' );

// Widget Styles
if ( ! function_exists( 'ttbase_framework_fa_icon_box_widget_style' ) ) {
    function ttbase_framework_fa_icon_box_widget_style() { ?>
        <style> 
            /* icon box */
            .icon-widget {
            	font-size: 18px;
            	color: #999999;
            	margin:2px;
            	text-decoration:none;
            }
            
            .icon-widget:hover {
            	color: #454545;
            }
        </style>
    <?php
    }
}


// Widget AJAX functions
function ttbase_framework_fa_icon_box_widget_scripts() {
    global $pagenow;
    if ( is_admin() && $pagenow == "widgets.php" ) {
        add_action('admin_head', 'ttbase_framework_fa_icon_box_widget_style');
        add_action('admin_footer', 'ttbase_framework_fa_icon_box_widget_admin_script');
        function ttbase_framework_fa_icon_box_widget_admin_script() { ?>
            <script type="text/javascript" >
            	function initColorPicker( widget ) {
                        widget.find( '.color-picker' ).wpColorPicker( {
                                change: _.throttle( function() { // For Customizer
                                        jQuery(this).trigger( 'change' );
                                }, 3000 )
                        });
                }
	
                function onFormUpdate( event, widget ) {
                        initColorPicker( widget );
                }
                
                jQuery( document ).on( 'widget-added widget-updated', onFormUpdate );
                
                jQuery(document).ready(function($) {
                	$( '#widgets-right .widget:has(.color-picker)' ).each( function () {
                    	initColorPicker( $( this ) );
                    } );
                    	/**
                	 * Select Icon on Click
                	 */
                	$( 'body' ).on( 'click', '.js-selectable-icon', function ( ev ) {
                		ev.preventDefault();
                		var $this = $( this );
                		$this.siblings( '.js-icon-input' ).val( $this.data( 'iconname' ) ).change();
                	} );
                });
            </script>
        <?php
        }
    }
}
add_action('admin_init','ttbase_framework_fa_icon_box_widget_scripts');