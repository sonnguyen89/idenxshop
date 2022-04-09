<?php
/**
 * TTBase Opening Hours Widget
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'TTBase_Framework_Opening_Hours_Widget' ) ) {
	class TTBase_Framework_Opening_Hours_Widget extends WP_Widget {

		// Set variable so we only need to declare the $weekdays in the __construct
		private $weekdays;

		/**
		 * Register widget with WordPress.
		 */
		public function __construct() {
			parent::__construct(
				false,
				esc_html__( "TTBase Opening Hours" , 'ttbase-framework' ),
				array(
					'description' => esc_html__( 'Opening Hours Widget', 'ttbase-framework' ),
					'classname' => 'widget-opening-hours'
				)
			);

			// Define all weekdays
			$this->weekdays = array(
				'Monday'	=> esc_html__( 'Monday', 'ttbase-framework' ),
				'Tuesday'	=> esc_html__( 'Tuesday', 'ttbase-framework' ),
				'Wednesday'	=> esc_html__( 'Wednesday', 'ttbase-framework' ),
				'Thursday'	=> esc_html__( 'Thursday', 'ttbase-framework' ),
				'Friday'	=> esc_html__( 'Friday', 'ttbase-framework' ),
				'Saturday'	=> esc_html__( 'Saturday', 'ttbase-framework' ),
				'Sunday'	=> esc_html__( 'Sunday', 'ttbase-framework' ),
			);
		}

		/**
         * Front-end display of widget.
         *
         */
		public function widget( $args, $instance ) {
			extract( $args );
			echo $before_widget;

			// Show widget title if isset
			$instance['title'] = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );
			if( !empty( $instance['title'] ) ) :
				echo $before_title . $instance['title'] . $after_title;
			endif;

			$return = '';
			$return .= '<div class="opening-hours">';
			$return .= '<ul>';

			// Get the current time
			$get_the_time = current_time( 'timestamp', 1 ) + get_option('gmt_offset') * 3600;
				
			foreach( $this->weekdays as $key => $day ) {
				
				// If day is today, add today class
				$return .= '<li class="weekday'. esc_attr( date( 'l', $get_the_time ) == $key ? ' today' : '' ) .'">';
				$return .= esc_attr( $day );

				if( ! empty( $instance[ $key . '_from' ] ) && ! empty( $instance[ $key . '_to' ] ) ) {
					
					// Display opening time from, time seperator, to
					$return .= '<span class="right">';
					$return .= esc_attr( $instance[$key . '_from'] . $instance['separator'] . $instance[$key . '_to'] );
				} else {

					// If highlight is checked display the label
					$class = empty( $instance['highlight'] ) ? '' : ' label';
					$return .= '<span class="right'. $class .'">';
					// Display closed text
					$return .= esc_attr( $instance['closed'] );
				}

				$return .= '</span>';
				$return .= '</li>';
			}

			$return .= '</ul>';
			$return .= '</div>';

			echo wp_kses_post( $return );
			echo $after_widget;
		}

		/**
         * Sanitize widget form values as they are saved.
         *
         */
		public function update( $new_instance, $old_instance ) {
			$instance = array();

			$instance['title'] = wp_kses_post( $new_instance['title'] );

			foreach( $this->weekdays as $key => $day ) {
				$instance[$key . '_from'] = sanitize_text_field( $new_instance[$key . '_from'] );
				$instance[$key . '_to']   = sanitize_text_field( $new_instance[$key . '_to'] );
			}

			$instance['separator'] = sanitize_text_field( $new_instance['separator'] );
			$instance['closed']	   = sanitize_text_field( $new_instance['closed'] );
			$instance['highlight'] = sanitize_key( $new_instance['highlight'] );

			return $instance;
		}

		/**
         * Back-end widget form.
         *
         */
		public function form( $instance ) {
			
			$title = isset( $instance['title'] ) ?  $instance['title'] : esc_html__( 'Opening Hours', 'ttbase-framework' );

			foreach ( $this->weekdays as $key => $day ) {
				$from[$key] = isset( $instance[$key . '_from'] ) ? $instance[$key . '_from'] : '07:00';
				$to[$key]   = isset( $instance[$key . '_to'] ) ? $instance[$key . '_to'] : '17:00';
			}

			$separator = isset( $instance['separator'] ) ?  $instance['separator'] : '-';
			$closed    = isset( $instance['closed'] ) ?  $instance['closed'] : esc_html__( 'We are closed', 'ttbase-framework' );
			$highlight = empty( $instance['highlight'] ) ? '' : $instance['highlight'];
			?>

			<p>
				<strong><?php esc_html_e( "Leave both fields empty to display the closed message", 'ttbase-framework' ); ?></strong>
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Widget Title', 'ttbase-framework' ); ?>:</label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
			</p>

			<?php foreach ( $this->weekdays as $key => $day ) : ?>
				<p>
					<label for="<?php echo esc_attr( $this->get_field_id( $key . '_opened' ) ); ?>"><?php echo esc_html( $day ); ?></label><br>
					<label for="<?php echo esc_attr( $this->get_field_id( $key . '_from' ) ); ?>"><?php esc_html_e( 'From', 'ttbase-framework' ); ?>:</label>
					<input type="text" id="<?php echo esc_attr( $this->get_field_id( $key . '_from' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( $key . '_from' ) ); ?>" value="<?php echo esc_attr( $from[$key] ); ?>" size="15" />
					<label for="<?php echo esc_attr( $this->get_field_id( $key . '_to' ) ); ?>"><?php esc_html_e( 'To', 'ttbase-framework' ); ?>:</label>
					<input type="text" id="<?php echo esc_attr( $this->get_field_id( $key . '_to' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( $key . '_to' ) ); ?>" value="<?php echo esc_attr( $to[$key] ) ?>" size="15" />
				</p>
			<?php endforeach; ?>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'separator' ) ); ?>"><?php esc_html_e( 'Separator between opening hours', 'ttbase-framework' ); ?>:</label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'separator' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'separator' ) ); ?>" type="text" value="<?php echo esc_attr( $separator ); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'closed' ) ); ?>"><?php esc_html_e( 'Display text on closed days', 'ttbase-framework' ); ?>:</label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'closed' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'closed' ) ); ?>" type="text" value="<?php echo esc_attr( $closed ); ?>" />
			</p>
			<p>
				<input class="checkbox" type="checkbox" <?php checked( $highlight, 'on'); ?> id="<?php echo esc_attr( $this->get_field_id( 'highlight' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'highlight' ) ); ?>" value="on" />
				<label for="<?php echo esc_attr( $this->get_field_id( 'highlight' ) ); ?>"><?php esc_html_e( 'Highlight closed text?', 'ttbase-framework' ); ?></label>
			</p>
			<?php
		}
	}
}

// Register the custom widget
if ( ! function_exists( 'ttbase_framework_register_opening_hours_widget' ) ) {
    function ttbase_framework_register_opening_hours_widget() {
        register_widget( 'TTBase_Framework_Opening_Hours_Widget' );
    }
}
add_action( 'widgets_init', 'ttbase_framework_register_opening_hours_widget' );