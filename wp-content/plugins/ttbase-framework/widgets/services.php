<?php
/**
 * TTBase Service List Widget
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Start class
class TTBase_Framework_Services_Widget extends WP_Widget {
	private $defaults;
	
	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {

		parent::__construct(FALSE, $name = esc_html__('TTBase Class List', 'ttbase-framework'), array(
				'description' => esc_html__('Display your classes.', 'ttbase-framework')
			));

		$this->defaults = array(
			'title'      => esc_html__( 'Classes', 'ttbase-framework' ),
			'number'     => '6',
			'post_type'  => 'classes',
			'taxonomy'   => '',
			'terms'      => '',
			'order'      => 'DESC',
			'orderby'    => 'title'
		);

	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {

		// Parse instance
		extract( wp_parse_args( $instance, $this->defaults ) );

		// Apply filters to the title
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

		// Before widget WP hook
		echo $args['before_widget'];

		// Display title if defined
		if ( $title ) {
			echo $args['before_title'] . $title . $args['after_title']; 
		} ?>

		<ul class="service-widget clearfix">

			<?php
			// Query args
			$query_args = array(
				'post_type'      => $post_type,
				'posts_per_page' => $number,
			);

			// Order params - needs FALLBACK don't ever edit!
			if ( ! empty( $orderby ) ) {
				$query_args['order']   = $order;
				$query_args['orderby'] = $orderby;
			} else {
				$query_args['orderby'] = $order; // THIS IS THE FALLBACK
			}

			// Taxonomy args
			if ( ! empty( $taxonomy ) && ! empty( $terms ) ) {

				// Sanitize terms and convert to array
				$terms = str_replace( ', ', ',', $terms );
				$terms = explode( ',', $terms );

				// Add to query arg
				$query_args['tax_query']  = array(
					array(
						'taxonomy' => $taxonomy,
						'field'    => 'slug',
						'terms'    => $terms,
					),
				);

			}

			// Exclude current post
			if ( is_singular() ) {
				$query_args['post__not_in'] = array( get_the_ID() );
			}

			// Query posts
			$query = new WP_Query( $query_args );

			// Set post counter variable
			$count=0;

			// Loop through posts
			while ( $query->have_posts() ) : $query->the_post(); ?>
				<li>
					<a href="<?php gymx_permalink(); ?>" title="<?php gymx_esc_title(); ?>">
				        <?php gymx_esc_title(); ?>
					</a>
				</li>
				
			<?php 
			// End loop
			endwhile;

			// Reset global query post data
			wp_reset_postdata(); ?>

		</ul>

		<?php
		// After widget WP hook
		echo $args['after_widget']; ?>
		
	<?php
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance               = $old_instance;
		$instance['title']      = strip_tags( $new_instance['title'] );
		$instance['taxonomy']   = $new_instance['taxonomy'];
		$instance['number']     = strip_tags( $new_instance['number'] );
		$instance['terms']      = strip_tags( $new_instance['terms'] );
		$instance['order']      = strip_tags( $new_instance['order'] );
		$instance['orderby']    = strip_tags( $new_instance['orderby'] );
		return $instance;
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {

		$instance = wp_parse_args( ( array ) $instance, $this->defaults );

		// Sanitize vars
		$title      = $instance['title'];
		$number     = $instance['number'];
		$post_type  = esc_attr( $instance['post_type'] );
		$taxonomy   = esc_attr( $instance['taxonomy'] );
		$terms      = $instance['terms'];
		$order      = esc_attr( $instance['order'] );
		$orderby    = esc_attr( $instance['orderby'] ); ?>

		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php esc_html_e( 'Title', 'ttbase-framework' ); ?></label>
			<input class="widefat" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
		</p>
		<p>
		<label for="<?php echo esc_attr($this->get_field_id( 'taxonomy' )); ?>"><?php esc_html_e( 'Query By Taxonomy', 'ttbase-framework' ); ?></label>
		<br />
		<select class='ttbase-select' name="<?php echo esc_attr($this->get_field_name( 'taxonomy' )); ?>" style="width:100%;">
			<option value="post" <?php if ( ! $taxonomy ) { ?>selected="selected"<?php } ?>><?php esc_html_e( 'No', 'ttbase-framework' ); ?></option>
			<?php
			// Get Taxonomies
			$get_taxonomies = get_object_taxonomies( 'classes', 'objects' );
			 ?>
			<?php foreach ( $get_taxonomies as $get_taxonomy ) : ?>
				<option value="<?php echo esc_attr($get_taxonomy->name); ?>" <?php if ( $get_taxonomy->name == $taxonomy ) { ?>selected="selected"<?php } ?>><?php echo ucfirst( $get_taxonomy->labels->singular_name ); ?></option>
			<?php endforeach; ?>
		</select>
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'terms' )); ?>"><?php esc_html_e( 'Terms', 'ttbase-framework' ); ?></label>
			<br />
			<input class="widefat" name="<?php echo esc_attr($this->get_field_name( 'terms' )); ?>" type="text" value="<?php echo esc_attr($terms); ?>" />
			<small><?php esc_html_e( 'Enter the term slugs to query by seperated by a "comma"', 'ttbase-framework' ); ?></small>
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'order' )); ?>"><?php esc_html_e( 'Order', 'ttbase-framework' ); ?></label>
			<br />
			<select class='ttbase-select' name="<?php echo esc_attr($this->get_field_name( 'order' )); ?>">
				<option value="DESC" <?php selected( $order, 'DESC', true ); ?>><?php esc_html_e( 'Descending', 'ttbase-framework' ); ?></option>
				<option value="ASC" <?php selected( $order, 'ASC', true ); ?>><?php esc_html_e( 'Ascending', 'ttbase-framework' ); ?></option>
			</select>
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'orderby' )); ?>"><?php esc_html_e( 'Order By', 'ttbase-framework' ); ?>:</label>
			<br />
			<select class='ttbase-select' name="<?php echo esc_attr($this->get_field_name( 'orderby' )); ?>" id="<?php echo esc_attr($this->get_field_id( 'orderby' )); ?>">
			<?php
			// Orderby options
			$orderby_array = array (
				'date'          => esc_html__( 'Date', 'ttbase-framework' ),
				'title'         => esc_html__( 'Title', 'ttbase-framework' ),
				'rand'          => esc_html__( 'Random', 'ttbase-framework' ),
			);
			foreach ( $orderby_array as $key => $value ) { ?>
				<option value="<?php echo esc_attr($key); ?>" <?php if( $orderby == $key ) { ?>selected="selected"<?php } ?>>
					<?php echo esc_html($value); ?>
				</option>
			<?php } ?>
			</select>
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'number' )); ?>"><?php esc_html_e( 'Number', 'ttbase-framework' ); ?></label>
			<input class="widefat" name="<?php echo esc_attr($this->get_field_name( 'number' )); ?>" type="text" value="<?php echo esc_attr($number); ?>" />
		</p>
	<?php
	}
}

// Register the recent posts grid widget
if ( ! function_exists( 'ttbase_framework_register_services_widget' ) ) {
	function ttbase_framework_register_services_widget() {
		register_widget( 'TTBase_Framework_Services_Widget' );
	}
}
add_action( 'widgets_init', 'ttbase_framework_register_services_widget' );