<?php
/**
 * TTBase Contact Info Widget
 *
 */

// Prevent direct file access
if ( ! defined ( 'ABSPATH' ) ) {
	exit;
}

// Start widget class
if ( ! class_exists( 'TTBase_Framework_Contact_Widget' ) ) {

	class TTBase_Framework_Contact_Widget extends WP_Widget {
		
		/**
		 * Register widget with WordPress.
		 *
		 */
		function __construct() {
			parent::__construct(FALSE, $name = esc_html__('TTBase Contact Info', 'ttbase-framework'), array(
				'description' => esc_html__('Add your contact information.', 'ttbase-framework')
			));
			add_action( 'admin_enqueue_scripts', array( $this, 'scripts' ) );
		}

		/**
		 * Enqueue media scripts
		 */
		public function scripts() {
			wp_enqueue_style('thickbox');
			wp_enqueue_script('media-upload');
			wp_enqueue_script('thickbox');
			wp_enqueue_script('ttbase-media-upload', TTBASE_FRAMEWORK_URL . 'widgets/js/ttbase-media-upload.js', array('jquery'));
		}

		/**
		 * Front-end display of widget.
		 *
		 */
		public function widget( $args, $instance ) {

			// Extract args
			extract( $args );

			// Args
			$title = apply_filters( 'widget_title', empty($instance['title']) ? '' : $instance['title'], $instance );
			$image       = isset( $instance['image'] ) ? esc_url( $instance['image'] ) : '';
			$image2x     = isset( $instance['image2x'] ) ? esc_url( $instance['image2x'] ) : '';
			$description = apply_filters( 'widget_text', empty($instance['description']) ? '' : $instance['description'], $instance );
			$address      = isset( $instance['address'] ) ? $instance['address'] : '';
			$phone_number = isset( $instance['phone_number'] ) ? $instance['phone_number'] : '';
			$fax_number   = isset( $instance['fax_number'] ) ? $instance['fax_number'] : '';
			$email        = isset( $instance['email'] ) ? $instance['email'] : '';
			$show_contact_button       = ! empty( $instance['show_contact_button'] ) ? true : false;
			$button_style       = isset( $instance['button_style'] ) ? $instance['button_style'] : 'style-1';
			$button_title       = apply_filters( 'button_title', empty($instance['button_title']) ? '' : $instance['button_title'], $instance );
			$url    = isset( $instance['url'] ) ? esc_url($instance['url']) : '';
			$target   = isset( $instance['target'] ) ? $instance['target'] : '';
			
			// Before widget hook
			echo $before_widget; ?>

				<?php
				$ex_class = 'no-title';
				// Display widget title
				if ( $title ) {
					echo $before_title . $title . $after_title;
					$ex_class = '';
				} ?>

				<div class="contact-widget <?php echo sanitize_html_class($ex_class); ?> clearfix">

					<?php
					// Display the image
					if ( $image || $image2x ) : ?>

						<div class="contact-widget-image">
							<img class="img-responsive" alt="<?php echo esc_attr_e( 'Contact Logo', 'ttbase-framework' ); ?>" src="<?php echo esc_url($image); ?>" srcset="<?php echo esc_url($image); ?><?php echo empty ( $image2x ) ? '' : ', ' . esc_url($image2x) . ' 2x'; ?>"/>
						</div>

					<?php endif; ?>
					
					
					<?php
					// Display the description
					if ( $description ) : ?>

						<div class="contact-widget-description clearfix">
							<?php echo esc_html($description); ?>
						</div>

					<?php endif; ?>
					
					<?php if ( $address ) : ?>

						<div class="contact-widget-address clearfix">
							<span class="fa fa-map-marker"></span>
							<?php echo wpautop( $address ); ?>
						</div>
		
					<?php endif; ?>
		
					<?php if ( $phone_number ) : ?>
		
						<div class="contact-widget-phone clearfix">
							<span class="fa fa-phone"></span>
							<?php echo esc_html($phone_number); ?>
						</div>
		
					<?php endif; ?>
		
					<?php if ( $fax_number ) : ?>
		
						<div class="contact-widget-fax clearfix">
							<span class="fa fa-fax"></span>
							<?php echo esc_html($fax_number); ?>
						</div>
		
					<?php endif; ?>
		
					<div class="contact-widget-email">
						<span class="fa fa-envelope"></span>
						<?php if ( is_email( $email ) ) : ?>
							<span>
								<?php echo esc_html($email); ?>
							</span>
							
						<?php endif; ?>
						<?php if ($show_contact_button) { ?>
							<div>
								<a class="btn btn-primary <?php echo sanitize_html_class($button_style); ?>" href="<?php echo esc_url($url); ?>" <?php echo ($target=="_blank" ? " target='_blank'" : ""); ?> title="<?php esc_html_e($button_title); ?>"><?php esc_html_e($button_title); ?></a>
							</div>
						<?php } ?>
					</div>
					
				</div>

			<?php
			// After widget hook
			echo $after_widget;
		}

		/**
		 * Sanitize widget form values as they are saved.
		 *
		 */
		public function update( $new_instance, $old_instance ) {
			$instance                = $old_instance;
			$instance['title']       = strip_tags( $new_instance['title'] );
			$instance['image']       = strip_tags( $new_instance['image'] );
			$instance['image2x']       = strip_tags( $new_instance['image2x'] );
			$instance['description'] = wp_kses( strip_tags( $new_instance['description'] ), array(
				'a'         => array(
					'href'  => array(),
					'title' => array()
				),
				'br'        => array(),
				'em'        => array(),
				'strong'    => array(),
			) );
			$instance['address']      = ( ! empty( $new_instance['address'] ) ) ? $new_instance['address'] : '';
			$instance['phone_number'] = ( ! empty( $new_instance['phone_number'] ) ) ? $new_instance['phone_number'] : '';
			$instance['fax_number']   = ( ! empty( $new_instance['fax_number'] ) ) ? $new_instance['fax_number'] : '';
			$instance['email']        = ( ! empty( $new_instance['email'] ) ) ? $new_instance['email'] : '';
			$instance['show_contact_button']       = $new_instance['show_contact_button'] ? 1 : 0;
			$instance['button_title']        = ( ! empty( $new_instance['button_title'] ) ) ? $new_instance['button_title'] : '';
			$instance['url']     = strip_tags( $new_instance['url'] );
			$instance['target']   = $new_instance['target'] == '_blank' ? $new_instance['target'] : '';
			$instance['button_style'] = ( ! empty( $new_instance['button_style'] ) ) ? $new_instance['button_style'] : 'style-1';
			return $instance;
		}

		/**
		 * Back-end widget form.
		 *
		 */
		public function form( $instance ) {
			$instance = wp_parse_args( ( array ) $instance, array(
				'title'       => '',
				'image'       => '',
				'image2x'       => '',
				'description' => '',
				'address'      => '',
				'phone_number' => '',
				'fax_number'   => '',
				'email'        => '',
				'show_contact_button' => 0,
				'button_title' => '',
				'url'       => '',
				'target'   => '_self',
				'button_style' => 'style-1'

			) );
			$title      			= esc_attr( $instance['title'] );
			$image      			= esc_attr( $instance['image'] );
			$image2x    			= $instance['image2x'];
			$description			= esc_attr( $instance['description'] );
			$address				= esc_attr( $instance['address'] );
			$phone_number			= esc_attr( $instance['phone_number'] );
			$fax_number 			= esc_attr( $instance['fax_number'] );
			$email					= esc_attr( $instance['email'] );
			$show_contact_button    = esc_attr( $instance['show_contact_button'] );
			$button_title			= esc_attr( $instance['button_title'] );
			$url    				= strip_tags( $instance['url'] );
			$target 				= esc_attr( $instance['target'] );
			$button_style			= esc_attr( $instance['button_style'] );
			 ?>
			
			<p>
				<label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php esc_html_e( 'Title', 'ttbase-framework' ); ?>:</label>
				<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id( 'image' )); ?>"><?php esc_html_e( 'Image URL', 'ttbase-framework' ); ?>:</label>
				<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'image' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'image' )); ?>" type="text" value="<?php echo esc_attr($image); ?>" style="margin-bottom:10px;" />
				<input class="widget-image-upload-button button button-secondary" type="button" value="<?php esc_html_e( 'Upload Image', 'ttbase-framework' ); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id( 'image2x' )); ?>"><?php esc_html_e( 'Retina Image URL', 'ttbase-framework' ); ?>:</label> 
				<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'image2x' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'image2x')); ?>" type="text" value="<?php echo esc_attr($image2x); ?>" style="margin-bottom:10px;" />
				<input class="widget-image-upload-button button button-secondary" type="button" value="<?php esc_html_e( 'Upload Image', 'ttbase-framework' ); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id( 'description' )); ?>"><?php esc_html_e( 'Description:','ttbase-framework' ); ?></label>
				<textarea class="widefat" rows="5" cols="20" id="<?php echo esc_attr($this->get_field_id( 'description' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'description' )); ?>"><?php echo esc_attr($instance['description']); ?></textarea>
			</p>
			<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'address' )); ?>">
				<?php esc_html_e( 'Address', 'ttbase-framework' ); ?></label>
				<textarea rows="5" class="widefat" name="<?php echo esc_attr($this->get_field_name( 'address' )); ?>" type="text"><?php echo stripslashes( $instance['address'] ); ?></textarea>
			</p>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id( 'phone_number' )); ?>"><?php esc_html_e( 'Phone Number', 'ttbase-framework' ); ?></label>
				<input class="widefat" name="<?php echo esc_attr($this->get_field_name( 'phone_number' )); ?>" type="text" value="<?php echo esc_attr($phone_number); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id( 'fax_number' )); ?>"><?php esc_html_e( 'Fax Number', 'ttbase-framework' ); ?></label>
				<input class="widefat" name="<?php echo esc_attr($this->get_field_name( 'fax_number' )); ?>" type="text" value="<?php echo esc_attr($fax_number); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id( 'email' )); ?>"><?php esc_html_e( 'Email', 'ttbase-framework' ); ?></label>
				<input class="widefat" name="<?php echo esc_attr($this->get_field_name( 'email' )); ?>" type="text" value="<?php echo esc_attr($email); ?>" />
			</p>
			<p>
				<input id="<?php echo esc_attr($this->get_field_id( 'show_contact_button' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'show_contact_button' )); ?>" <?php checked( $show_contact_button, 1, true ); ?> type="checkbox" />
				<label for="<?php echo esc_attr($this->get_field_id( 'show_contact_button' )); ?>"><?php esc_html_e( 'Show Contact Button?', 'ttbase-framework' ); ?></label>
			</p>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id( 'button_title' )); ?>"><?php esc_html_e( 'Button Text', 'ttbase-framework' ); ?></label>
				<input class="widefat" name="<?php echo esc_attr($this->get_field_name( 'button_title' )); ?>" type="text" value="<?php echo esc_attr($button_title); ?>" />
			</p>
			<p><label for="<?php echo esc_attr($this->get_field_id( 'button_style' )); ?>"><?php esc_html_e( 'Contact Button Style', 'ttbase-framework' ); ?>:</label>
				<select id="<?php echo esc_attr($this->get_field_id( 'button_style' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'button_style' )); ?>" class="widefat">
					<option value="style-1" <?php selected( 'style-1', $button_style ) ?>><?php esc_html_e( 'Style 1', 'ttbase-framework' ); ?></option>
					<option value="style-2" <?php selected( 'style-2', $button_style ) ?>><?php esc_html_e( 'Style 2', 'ttbase-framework' ); ?></option>
				</select>
			</p>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id( 'url' )); ?>"><?php esc_html_e( 'Button Url:', 'ttbase-framework' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'url' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'url' )); ?>" type="text" value="<?php echo esc_attr($url); ?>" />
			</p>
			<p><label for="<?php echo esc_attr($this->get_field_id( 'target' )); ?>"><?php esc_html_e( 'Open links in', 'ttbase-framework' ); ?>:</label>
				<select id="<?php echo esc_attr($this->get_field_id( 'target' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'target' )); ?>" class="widefat">
					<option value="_self" <?php selected( '_self', $target ) ?>><?php esc_html_e( 'Current window', 'ttbase-framework' ); ?></option>
					<option value="_blank" <?php selected( '_blank', $target ) ?>><?php esc_html_e( 'New window', 'ttbase-framework' ); ?></option>
				</select>
			</p>
			<?php
		}
	}
}

// Register Widget
if ( ! function_exists( 'ttbase_framework_register_contact_widget' ) ) {
	function ttbase_framework_register_contact_widget() {
		register_widget( 'TTBase_Framework_Contact_Widget' );
	}
}
add_action( 'widgets_init', 'ttbase_framework_register_contact_widget' );