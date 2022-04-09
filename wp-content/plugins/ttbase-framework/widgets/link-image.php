<?php
/**
 * TTBase Image widget
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Start widget class
if ( ! class_exists( 'TTBase_Framework_Image_Widget' ) ) {
	class TTBase_Framework_Image_Widget extends WP_Widget {

		/**
		 * Register widget with WordPress.
		 *
		 */
		function __construct() {
			parent::__construct(FALSE, $name = esc_html__('TTBase Image', 'ttbase-framework'), array(
				'description' => esc_html__('Show image with optional border and link.', 'ttbase-framework')
			));
			
			add_action( 'load-widgets.php', array( $this, 'scripts' ), 100 );
		}
		
		/**
		 * Enqueue media scripts
		 */
		public function scripts() {
			wp_enqueue_style( 'wp-color-picker' );
	        wp_enqueue_script( 'wp-color-picker' );
	        wp_enqueue_script( 'underscore' );
			wp_enqueue_media();
		}
	
		/**
		 * Front-end display of widget.
		 *
		 */
		function widget( $args, $instance ) {

			// Extract widget arguments
			extract( $args );

			// Set variables for widget usage
			$title  = isset( $instance['title'] ) ? $instance['title'] : '';
			$title  = apply_filters( 'widget_title', $title );
			$image  = isset( $instance['image'] ) ? esc_url( $instance['image'] ) : '';
			$image2x  = isset( $instance['image2x'] ) ? esc_url( $instance['image2x'] ) : '';
			$border = isset( $instance['border'] ) ? $instance['border'] : '';
			$image_width       = isset( $instance['image_width'] ) ? intval( $instance['image_width'] ) : '';
            $image_width       = ( $image_width ) ? ttbase_framework_sanitize_data( $image_width, 'px' ) : '';
			$url    = isset( $instance['url'] ) ? esc_url($instance['url']) : '';
			$target   = isset( $instance['target'] ) ? $instance['target'] : '';

			// Before widget WP hook
			echo $before_widget;

			// Display the title
			if ( $title ) {
				echo $before_title . $title . $after_title;
			}
			
			// Display the image
			if ( $image || $image2x ) :
				
				// Inline style
                $image_style = '';
                if ( $image_width ) {
                    $image_style .= 'width:'. $image_width .';';
                }
                if ( $image_style ) {
                    $image_style = ' style="' . esc_attr( $image_style ) . '"';
                }
                ?>
				<div class="ttbase-image-widget" <?php if(!empty($border)){ ?> style="border:solid 2px <?php echo esc_attr($border) ?>;" <?php } ?>>
					<?php if (!empty($url)) { ?>
						<a href="<?php echo esc_url( $url ) ?>" title="<?php echo esc_attr( $title) ?>" <?php echo ($target=="_blank" ? " target='_blank'" : ""); ?>>
					<?php } ?>
					<img class="img-responsive"<?php echo $image_style ?> alt="<?php echo esc_attr( $title ); ?>" src="<?php echo esc_url($image); ?>" srcset="<?php echo esc_url($image); ?><?php echo empty ( $image2x ) ? '' : ', ' . esc_url($image2x) . ' 2x'; ?>"/>
					<?php if (!empty($url)) { ?>
						</a>
					<?php } ?>
				</div>

			<?php endif; 
			// After widget WP hook
			echo $after_widget;
		}
	
		/**
		 * Sanitize widget form values as they are saved.
		 *
		 */
		function update( $new_instance, $old_instance ) {
			$instance           = $old_instance;
			$instance['title']  = strip_tags( $new_instance['title'] );
			$instance['image']       = strip_tags( $new_instance['image'] );
			$instance['image2x']       = strip_tags( $new_instance['image2x'] );
			$instance['border'] = strip_tags( $new_instance['border'] );
			$instance['url']     = strip_tags( $new_instance['url'] );
			$instance['target']   = $new_instance['target'] == '_blank' ? $new_instance['target'] : '';
			$instance['image_width']       = ! empty( $new_instance['image_width'] ) ? strip_tags( $new_instance['image_width'] ) : '';
			return $instance;
		}
		
		/**
		 * Back-end widget form.
		 *
		 */
		function form( $instance ) {

			// combine provided fields with defaults
			$instance = wp_parse_args( ( array ) $instance, array(
				'title'     	=> '',
				'image'     	=> '',
				'image2x'   	=> '',
				'image_width'	=> '',
				'border'    	=> '',
				'url'       	=> '',
				'target'		=> '_self'
			) );
			$image  = $instance['image'];
			$image2x  = $instance['image2x'];
			$image_width = strip_tags( $instance['image_width'] );
			$url    = strip_tags( $instance['url'] );
			$border = strip_tags( $instance['border'] );
			$title  = strip_tags( $instance['title'] );
			$target   = esc_attr( $instance['target'] ); ?>

			<p>
				<label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php esc_html_e( 'Title:', 'ttbase-framework' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo
				esc_attr($title); ?>" />
			</p>
            <p>
				<label for="<?php echo esc_attr($this->get_field_id( 'image' )); ?>"><?php esc_html_e( 'Image URL', 'ttbase-framework' ); ?>:</label>
				<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'image' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'image' )); ?>" type="text" value="<?php echo esc_attr($image); ?>" style="margin-bottom:10px;" />
				<input class="widget-image-upload-button btn-primary" type="button" value="<?php esc_html_e( 'Upload Image', 'ttbase-framework' ); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id( 'image2x' )); ?>"><?php esc_html_e( 'Retina Image URL', 'ttbase-framework' ); ?>:</label>
				<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'image2x' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'image2x' )); ?>" type="text" value="<?php echo esc_attr($image2x); ?>" style="margin-bottom:10px;" />
				<input class="widget-image-upload-button btn-primary" type="button" value="<?php esc_html_e( 'Upload Image', 'ttbase-framework' ); ?>" />
			</p>
			<p>
                <label for="<?php echo esc_attr($this->get_field_id('image_width')); ?>"><?php esc_html_e( 'Image Width', 'ttbase-framework' ); ?></label>
                <input class="widefat" id="<?php echo esc_attr($this->get_field_id('image_width')); ?>" name="<?php echo esc_attr($this->get_field_name('image_width')); ?>" type="text" value="<?php echo esc_attr($image_width); ?>" />
                <small><?php esc_html_e( 'Enter a custom width for the image.', 'ttbase-framework'); ?></small>
            </p>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id( 'border' )); ?>"><?php esc_html_e( 'Border Color:', 'ttbase-framework' ); ?></label>
				<div>
					<input class="my-color-picker widefat" type="text" id="<?php echo esc_attr($this->get_field_id( 'border' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'border' )); ?>" value="<?php echo esc_attr( $border ); ?>" />
				</div>
				
			</p>

			<p>
				<label for="<?php echo esc_attr($this->get_field_id( 'url' )); ?>"><?php esc_html_e( 'Url:', 'ttbase-framework' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'url' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'url' )); ?>" type="text" value="<?php echo esc_attr($url); ?>" />
			</p>
			<p><label for="<?php echo esc_attr($this->get_field_id( 'target' )); ?>"><?php esc_html_e( 'Open links in', 'ttbase-framework' ); ?>:</label>
				<select id="<?php echo esc_attr($this->get_field_id( 'target' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'target' )); ?>" class="widefat">
					<option value="_self" <?php selected( '_self', $target ) ?>><?php esc_html_e( 'Current window', 'ttbase-framework' ); ?></option>
					<option value="_blank" <?php selected( '_blank', $target ) ?>><?php esc_html_e( 'New window', 'ttbase-framework' ); ?></option>
				</select>
			</p>
			
			<script type="text/javascript">
				(function($) {
					"use strict";
					function initColorPicker( widget ) {
			                widget.find( '.my-color-picker' ).wpColorPicker( {
			                        change: _.throttle( function() { // For Customizer
			                                $(this).trigger( 'change' );
			                        }, 3000 )
			                });
			        }
			            function onFormUpdate( event, widget ) {
			                initColorPicker( widget );
			        }
			        $( document ).on( 'widget-added widget-updated', onFormUpdate );
					$( document ).ready( function() {
						var _custom_media = true,
							_orig_send_attachment = wp.media.editor.send.attachment;
						$( '.widget-image-upload-button' ).click(function(e) {
							var send_attachment_bkp	= wp.media.editor.send.attachment,
								button = $(this),
								id = button.prev();
								_custom_media = true;
							wp.media.editor.send.attachment = function( props, attachment ) {
								if ( _custom_media ) {
									$( id ).val( attachment.url );
								} else {
									return _orig_send_attachment.apply( this, [props, attachment] );
								};
							}
							wp.media.editor.open( button );
							return false;
						} );
						$( '.add_media').on('click', function() {
							_custom_media = false;
						} );
						 $( '.widget:has(.my-color-picker)' ).each( function () {
                        	initColorPicker( $( this ) );                                                   
		                } );
					} );
				} ) ( jQuery );
			</script>
		<?php
		}

	}
}

// Register the TTBase Flickr Widget
if ( ! function_exists( 'ttbase_framework_register_image_widget' ) ) {
	function ttbase_framework_register_image_widget() {
		register_widget( 'TTBase_Framework_Image_Widget' );
	}
}
add_action( 'widgets_init', 'ttbase_framework_register_image_widget' );