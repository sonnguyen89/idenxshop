<?php
/**
 * TTBase Portfolio Widget
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Start class
class TTBase_Framework_Portfolio_Widget extends WP_Widget {
	private $defaults;
	
	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {

		parent::__construct(FALSE, $name = esc_html__('TTBase Portfolio', 'ttbase-framework'), array(
				'description' => esc_html__('Display your latest portfolio.', 'ttbase-framework')
			));

		$this->defaults = array(
			'title'      => esc_html__( 'Latest Projects', 'ttbase-framework' ),
			'number'     => '6',
			'post_type'  => 'portfolio',
			'taxonomy'   => '',
			'terms'      => '',
			'order'      => 'DESC',
			'orderby'    => 'date',
			'columns'    => '3'
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

		<ul class="recent-posts-grid-widget grid-row clearfix">

			<?php
			// Query args
			$query_args = array(
				'post_type'      => $post_type,
				'posts_per_page' => $number,
				'meta_key'       => '_thumbnail_id',
				'no_found_rows'  => true,
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
			$ttbase_query = new WP_Query( $query_args );

			// Set post counter variable
			$count=0;

			// Loop through posts
			while ( $ttbase_query->have_posts() ) : $ttbase_query->the_post();

				// Add to counter variable
				$count++; ?>
				<li class="<?php echo gymx_grid_class( $columns ); ?> nr-col col-<?php echo esc_attr($count); ?>">
					<a href="<?php gymx_permalink(); ?>" title="<?php gymx_esc_title(); ?>">
						<?php the_post_thumbnail( 'mini' ); ?>
						<div class="overlay">
							<i class="fa fa-link"></i>
						</div>
					</a>
				</li>
				
				<?php // Reset counter to clear floats
				if ( $count == $columns ) $count = '0';

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
		$instance['post_type']  = $new_instance['post_type'];
		$instance['taxonomy']   = $new_instance['taxonomy'];
		$instance['terms']      = strip_tags( $new_instance['terms'] );
		$instance['number']     = strip_tags( $new_instance['number'] );
		$instance['order']      = strip_tags( $new_instance['order'] );
		$instance['orderby']    = strip_tags( $new_instance['orderby'] );
		$instance['columns']    = strip_tags( $new_instance['columns'] );
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

		$title      = $instance['title'];
		$number     = $instance['number'];
		$post_type  = esc_attr( $instance['post_type'] );
		$taxonomy   = esc_attr( $instance['taxonomy'] );
		$terms      = $instance['terms'];
		$order      = esc_attr( $instance['order'] );
		$orderby    = esc_attr( $instance['orderby'] );
		$columns    = esc_attr( $instance['columns'] ); ?>

		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php esc_html_e( 'Title', 'ttbase-framework' ); ?></label>
			<input class="widefat" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
		</p>
		<p>
		<label for="<?php echo esc_attr($this->get_field_id( 'post_type' )); ?>"><?php esc_html_e( 'Post Type', 'ttbase-framework' ); ?></label>
		<br />
		<select class='ttbase-select' name="<?php echo esc_attr($this->get_field_name( 'post_type' )); ?>" style="width:100%;">
			<option value="post" <?php if ( $post_type == 'post' ) { ?>selected="selected"<?php } ?>><?php esc_html_e( 'Post', 'ttbase-framework' ); ?></option>
			<?php
			// Get Post Types
			$args = array(
				'public'                => true,
				'_builtin'              => false,
				'exclude_from_search'   => false
			);
			$output = 'names';
			$operator = 'and';
			$get_post_types = get_post_types( $args, $output, $operator );
			foreach ( $get_post_types as $get_post_type ) : ?>
				<?php if ( $get_post_type != 'post' ) { ?>
					<option value="<?php echo esc_attr($get_post_type); ?>" <?php if ( $post_type == $get_post_type ) { ?>selected="selected"<?php } ?>><?php echo ucfirst( $get_post_type ); ?></option>
				<?php } ?>
			<?php endforeach; ?>
		</select>
		</p>
		<p>
		<label for="<?php echo esc_attr($this->get_field_id( 'taxonomy' )); ?>"><?php esc_html_e( 'Query By Taxonomy', 'ttbase-framework' ); ?></label>
		<br />
		<select class='ttbase-select' name="<?php echo esc_attr($this->get_field_name( 'taxonomy' )); ?>" style="width:100%;">
			<option value="post" <?php if ( ! $taxonomy ) { ?>selected="selected"<?php } ?>><?php esc_html_e( 'No', 'ttbase-framework' ); ?></option>
			<?php
			// Get Taxonomies
			$get_taxonomies = get_taxonomies( array(
				'public' => true,
			), 'objects' ); ?>
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
				'modified'      => esc_html__( 'Modified', 'ttbase-framework' ),
				'author'        => esc_html__( 'Author', 'ttbase-framework' ),
				'rand'          => esc_html__( 'Random', 'ttbase-framework' ),
				'comment_count' => esc_html__( 'Comment Count', 'ttbase-framework' ),
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
		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'columns' )); ?>"><?php esc_html_e( 'Columns', 'ttbase-framework' ); ?></label>
			<br />
			<select class='ttbase-select' name="<?php echo esc_attr($this->get_field_name( 'columns' )); ?>">
				<option value="1" <?php if ( $columns == 1 ) { ?>selected="selected"<?php } ?>>1</option>
				<option value="2" <?php if ( $columns == 2 ) { ?>selected="selected"<?php } ?>>2</option>
				<option value="3" <?php if ( $columns == 3 ) { ?>selected="selected"<?php } ?>>3</option>
				<option value="4" <?php if ( $columns == 4 ) { ?>selected="selected"<?php } ?>>4</option>
				<option value="5" <?php if ( $columns == 5 ) { ?>selected="selected"<?php } ?>>5</option>
				<option value="6" <?php if ( $columns == 6 ) { ?>selected="selected"<?php } ?>>6</option>
			</select>
		</p>
		
	<?php
	}
}

// Register the recent posts grid widget
if ( ! function_exists( 'ttbase_framework_register_portfolio_widget' ) ) {
	function ttbase_framework_register_portfolio_widget() {
		register_widget( 'TTBase_Framework_Portfolio_Widget' );
	}
}
add_action( 'widgets_init', 'ttbase_framework_register_portfolio_widget' );