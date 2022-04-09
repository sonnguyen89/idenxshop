<?php
/**
 * TTBase Flickr widget
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Start widget class
if ( ! class_exists( 'TTBase_Framework_Flickr_Widget' ) ) {
	class TTBase_Framework_Flickr_Widget extends WP_Widget {

		/**
		 * Register widget with WordPress.
		 *
		 */
		function __construct() {
			parent::__construct(FALSE, $name = esc_html__('TTBase Flickr Feed', 'ttbase-framework'), array(
				'description' => esc_html__('Show your flickr feed.', 'ttbase-framework')
			));
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
			$number = isset( $instance['number'] ) ? $instance['number'] : '';
			$id     = isset( $instance['id'] ) ? $instance['id'] : '';
			$orderby = isset( $instance['orderby'] )? $instance['orderby']: 'latest';

			// Before widget WP hook
			echo $before_widget;

			// Display the title
			if ( $title ) {
				echo $before_title . $title . $after_title;
			} 
			
			// Display flickr feed if ID is defined
			if ( $id ) : ?>
				<div class="flickr-widget">
					<script type="text/javascript" src="https://www.flickr.com/badge_code_v2.gne?count=<?php echo esc_attr($number); ?>&amp;display=<?php echo esc_attr($orderby); ?>&amp;size=s&amp;layout=x&amp;source=user&amp;user=<?php echo esc_attr($id); ?>"></script>
				</div>
			<?php endif; ?>

			<?php
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
			$instance['number'] = intval( strip_tags( $new_instance['number'] ) );
			$instance['id']     = strip_tags( $new_instance['id'] );
			$instance['orderby'] = ( empty( $new_instance['orderby'] ) )? '': strip_tags( $new_instance['orderby'] );
			return $instance;
		}
		
		/**
		 * Back-end widget form.
		 *
		 */
		function form( $instance ) {

			// combine provided fields with defaults
			$instance = wp_parse_args( ( array ) $instance, array(
				'title'     =>'Flickr Feed',
				'id'        => '',
				'number'    => 8,
				'orderby'	=> 'latest'
			) );
			$id     = strip_tags( $instance['id'] );
			$number = strip_tags( $instance['number'] );
			$title  = strip_tags( $instance['title'] );
			$orderby  = strip_tags( $instance['orderby'] );?>

			<p>
				<label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php esc_html_e( 'Title:', 'ttbase-framework' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo
				esc_attr($title); ?>" />
			</p>

			<p>
				<label for="<?php echo esc_attr($this->get_field_id( 'id' )); ?>"><?php echo sprintf( wp_kses( __( 'Flickr Account ID <code>e.g: 189993333@N02</code>', 'ttbase-framework' ), array(  'code' => array( ) ) ) ) ?>
				<p class="description">
				<?php echo sprintf( wp_kses( __( '<strong>Note!</strong> You can see the id when you go to your flickr photostream and take a look at the url. It is the id after photos/.', 'ttbase-framework' ), array(  'strong' => array( ) ) ) ) ?>
				</p></label> 
				<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'id' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'id' )); ?>" type="text" value="<?php echo esc_attr( $id ); ?>">
			</p>

			<p>
				<label for="<?php echo esc_attr($this->get_field_id( 'number' )); ?>">
				<?php esc_html_e( 'Number:', 'ttbase-framework' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'number' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'number' )); ?>" type="text" value="<?php echo
				esc_attr($number); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('orderby')); ?>">
				<?php esc_html_e('Order By :', 'ttbase-framework'); ?></label>		
				<select class="widefat" name="<?php echo esc_attr($this->get_field_name('orderby')); ?>" id="<?php echo esc_attr($this->get_field_id('orderby')); ?>">
					<option value="latest" <?php if(empty($orderby) || $orderby == 'latest') echo ' selected '; ?>><?php esc_html_e('Latest', 'ttbase-framework') ?></option>
					<option value="random" <?php if($orderby == 'random') echo ' selected '; ?>><?php esc_html_e('Random', 'ttbase-framework') ?></option>				
				</select> 
			</p>

		<?php
		}

	}
}

// Register the TTBase Flickr Widget
if ( ! function_exists( 'ttbase_framework_register_flickr_widget' ) ) {
	function ttbase_framework_register_flickr_widget() {
		register_widget( 'TTBase_Framework_Flickr_Widget' );
	}
}
add_action( 'widgets_init', 'ttbase_framework_register_flickr_widget' );