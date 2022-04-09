<?php
/**
 * TTBase Streamline Icon box widget
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'TTBase_Framework_Streamline_Icon_Box_Widget' ) ) {
	class TTBase_Framework_Streamline_Icon_Box_Widget extends WP_Widget {

		/**
		 * Register widget with WordPress.
		 *
		 */
		function __construct() {
			parent::__construct(FALSE, $name = esc_html__('TTBase Streamline Icon Box', 'ttbase-framework'), array(
				'description' => esc_html__('Icon Box widget for the header.', 'ttbase-framework')
			));
			
			add_action( 'admin_enqueue_scripts', array( $this, 'scripts' ) );
		}
		
		/**
		 * Enqueue streamline style
		 */
		public function scripts() {
			wp_enqueue_style( 'wp-color-picker' );
	        wp_enqueue_script( 'wp-color-picker' );
	        wp_enqueue_script( 'underscore' );
			wp_enqueue_style('gymx-streamline', plugins_url( '../css/gymx-streamline.min.css' , __FILE__ ) );
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
					<i class="sl <?php echo esc_attr($instance['icon']); ?>" style="color:<?php echo esc_attr($instance['icon_color']); ?>"></i>
					<?php else : ?>
					<i class="sl <?php echo esc_attr($instance['icon']); ?>"></i>
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
				<small><?php esc_html_e( 'Click on the icon below', 'backend', 'ttbase-framework'); ?>.</small>
				<input id="<?php echo esc_attr($this->get_field_id( 'icon' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'icon' )); ?>" type="text" value="<?php echo esc_attr($icon); ?>" class="widefat  js-icon-input" /> <br><br>
				<a class="js-selectable-icon icon-widget" href="#" data-iconname="sl-bin-1"><i class="sl fa-lg sl-bin-1"></i></a>
				<a class="js-selectable-icon icon-widget" href="#" data-iconname="sl-flash-2"><i class="sl fa-lg sl-flash-2"></i></a>
				<a class="js-selectable-icon icon-widget" href="#" data-iconname="sl-paperclip-1"><i class="sl fa-lg sl-paperclip-1"></i></a>
				<a class="js-selectable-icon icon-widget" href="#" data-iconname="sl-email-2"><i class="sl fa-lg sl-email-2"></i></a>
				<a class="js-selectable-icon icon-widget" href="#" data-iconname="sl-email-compose"><i class="sl fa-lg sl-email-compose"></i></a>
				<a class="js-selectable-icon icon-widget" href="#" data-iconname="sl-reply-all"><i class="sl fa-lg sl-reply-all"></i></a>
				<a class="js-selectable-icon icon-widget" href="#" data-iconname="sl-reply"><i class="sl fa-lg sl-reply"></i></a>
				<a class="js-selectable-icon icon-widget" href="#" data-iconname="sl-account-group-5"><i class="sl fa-lg sl-account-group-5"></i></a>
				<a class="js-selectable-icon icon-widget" href="#" data-iconname="sl-bubble-chat-add-1"><i class="sl fa-lg sl-bubble-chat-add-1"></i></a>
				<a class="js-selectable-icon icon-widget" href="#" data-iconname="sl-bubble-chat-list-1"><i class="sl fa-lg sl-bubble-chat-list-1"></i></a>
				<a class="js-selectable-icon icon-widget" href="#" data-iconname="sl-phone-3"><i class="sl fa-lg sl-phone-3"></i></a>
				<a class="js-selectable-icon icon-widget" href="#" data-iconname="sl-phone-5"><i class="sl fa-lg sl-phone-5"></i></a>
				<a class="js-selectable-icon icon-widget" href="#" data-iconname="sl-phone-call-2"><i class="sl fa-lg sl-phone-call-2"></i></a>
				<a class="js-selectable-icon icon-widget" href="#" data-iconname="sl-phone-call-24-hours"><i class="sl fa-lg sl-phone-call-24-hours"></i></a>
				<a class="js-selectable-icon icon-widget" href="#" data-iconname="sl-mobile-phone-portrait"><i class="sl fa-lg sl-mobile-phone-portrait"></i></a>
				<a class="js-selectable-icon icon-widget" href="#" data-iconname="sl-navigation-drawer-2"><i class="sl fa-lg sl-navigation-drawer-2"></i></a>
				<a class="js-selectable-icon icon-widget" href="#" data-iconname="sl-new-document"><i class="sl fa-lg sl-new-document"></i></a>
				<a class="js-selectable-icon icon-widget" href="#" data-iconname="sl-lock-close-1"><i class="sl fa-lg sl-lock-close-1"></i></a>
				<a class="js-selectable-icon icon-widget" href="#" data-iconname="sl-lock-open-1"><i class="sl fa-lg sl-lock-open-1"></i></a>
				<a class="js-selectable-icon icon-widget" href="#" data-iconname="sl-megaphone-1"><i class="sl fa-lg sl-megaphone-1"></i></a>
				<a class="js-selectable-icon icon-widget" href="#" data-iconname="sl-report-problem-circle"><i class="sl fa-lg sl-report-problem-circle"></i></a>
				<a class="js-selectable-icon icon-widget" href="#" data-iconname="sl-camera-2"><i class="sl fa-lg sl-camera-2"></i></a>
				<a class="js-selectable-icon icon-widget" href="#" data-iconname="sl-video-camera-2"><i class="sl fa-lg sl-video-camera-2"></i></a>
				<a class="js-selectable-icon icon-widget" href="#" data-iconname="sl-cd"><i class="sl fa-lg sl-cd"></i></a>
				<a class="js-selectable-icon icon-widget" href="#" data-iconname="sl-basket-1"><i class="sl fa-lg sl-basket-1"></i></a>
				<a class="js-selectable-icon icon-widget" href="#" data-iconname="sl-shopping-cart-4"><i class="sl fa-lg sl-shopping-cart-4"></i></a>
				<a class="js-selectable-icon icon-widget" href="#" data-iconname="sl-window-1"><i class="sl fa-lg sl-window-1"></i></a>
				<a class="js-selectable-icon icon-widget" href="#" data-iconname="sl-globe-question"><i class="sl fa-lg sl-globe-question"></i></a>
				<a class="js-selectable-icon icon-widget" href="#" data-iconname="sl-location-pin-2"><i class="sl fa-lg sl-location-pin-2"></i></a>
				<a class="js-selectable-icon icon-widget" href="#" data-iconname="sl-map-pin-1"><i class="sl fa-lg sl-map-pin-1"></i></a>
				<a class="js-selectable-icon icon-widget" href="#" data-iconname="sl-building-9"><i class="sl fa-lg sl-building-9"></i></a>
				<a class="js-selectable-icon icon-widget" href="#" data-iconname="sl-bird-cage"><i class="sl fa-lg sl-bird-cage"></i></a>
				<a class="js-selectable-icon icon-widget" href="#" data-iconname="sl-pet-bone"><i class="sl fa-lg sl-pet-bone"></i></a>
				<a class="js-selectable-icon icon-widget" href="#" data-iconname="sl-pet-box"><i class="sl fa-lg sl-pet-box"></i></a>
				<a class="js-selectable-icon icon-widget" href="#" data-iconname="sl-pet-collar-2"><i class="sl fa-lg sl-pet-collar-2"></i></a>
				<a class="js-selectable-icon icon-widget" href="#" data-iconname="sl-pet-litter-scoop"><i class="sl fa-lg sl-pet-litter-scoop"></i></a>
				<a class="js-selectable-icon icon-widget" href="#" data-iconname="sl-pet-yarn-ball"><i class="sl fa-lg sl-pet-yarn-ball"></i></a>
				<a class="js-selectable-icon icon-widget" href="#" data-iconname="sl-heart-beat"><i class="sl fa-lg sl-heart-beat"></i></a>
				<a class="js-selectable-icon icon-widget" href="#" data-iconname="sl-medicine-capsule-1"><i class="sl fa-lg sl-medicine-capsule-1"></i></a>
				<a class="js-selectable-icon icon-widget" href="#" data-iconname="sl-file-add-2"><i class="sl fa-lg sl-file-add-2"></i></a>
				<a class="js-selectable-icon icon-widget" href="#" data-iconname="sl-file-block-2"><i class="sl fa-lg sl-file-block-2"></i></a>
				<a class="js-selectable-icon icon-widget" href="#" data-iconname="sl-file-edit-2"><i class="sl fa-lg sl-file-edit-2"></i></a>
				<a class="js-selectable-icon icon-widget" href="#" data-iconname="sl-file-favorite-heart-2"><i class="sl fa-lg sl-file-favorite-heart-2"></i></a>
				<a class="js-selectable-icon icon-widget" href="#" data-iconname="sl-folder-2"><i class="sl fa-lg sl-folder-2"></i></a>
				<a class="js-selectable-icon icon-widget" href="#" data-iconname="sl-folder-document"><i class="sl fa-lg sl-folder-document"></i></a>
				<a class="js-selectable-icon icon-widget" href="#" data-iconname="sl-arrow-box-down-3"><i class="sl fa-lg sl-arrow-box-down-3"></i></a>
				<a class="js-selectable-icon icon-widget" href="#" data-iconname="sl-arrow-box-left-3"><i class="sl fa-lg sl-arrow-box-left-3"></i></a>
				<a class="js-selectable-icon icon-widget" href="#" data-iconname="sl-arrow-box-right-3"><i class="sl fa-lg sl-arrow-box-right-3"></i></a>
				<a class="js-selectable-icon icon-widget" href="#" data-iconname="sl-arrow-box-up-3"><i class="sl fa-lg sl-arrow-box-up-3"></i></a>
				<a class="js-selectable-icon icon-widget" href="#" data-iconname="sl-arrow-left-7"><i class="sl fa-lg sl-arrow-left-7"></i></a>
				<a class="js-selectable-icon icon-widget" href="#" data-iconname="sl-arrow-left-12"><i class="sl fa-lg sl-arrow-left-12"></i></a>
				<a class="js-selectable-icon icon-widget" href="#" data-iconname="sl-arrow-right-7"><i class="sl fa-lg sl-arrow-right-7"></i></a>
				<a class="js-selectable-icon icon-widget" href="#" data-iconname="sl-arrow-right-12"><i class="sl fa-lg sl-arrow-right-12"></i></a>
				
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
if ( ! function_exists( 'ttbase_framework_register_sl_icon_box_widget' ) ) {
    function ttbase_framework_register_sl_icon_box_widget() {
        register_widget( 'TTBase_Framework_Streamline_Icon_Box_Widget' );
    }
}
add_action( 'widgets_init', 'ttbase_framework_register_sl_icon_box_widget' );

// Widget Styles
if ( ! function_exists( 'ttbase_framework_sl_icon_box_widget_style' ) ) {
    function ttbase_framework_sl_icon_box_widget_style() { ?>
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
function ttbase_framework_sl_icon_box_widget_scripts() {
    global $pagenow;
    if ( is_admin() && $pagenow == "widgets.php" ) {
        add_action('admin_head', 'ttbase_framework_sl_icon_box_widget_style');
        add_action('admin_footer', 'ttbase_framework_sl_icon_box_widget_admin_script');
        function ttbase_framework_sl_icon_box_widget_admin_script() { ?>
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
add_action('admin_init','ttbase_framework_sl_icon_box_widget_scripts');