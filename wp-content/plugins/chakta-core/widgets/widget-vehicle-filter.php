<?php

class widget_vehicle_filter extends WP_Widget { 
	
	// Widget Settings
	function __construct() {
		$widget_ops = array('description' => esc_html__('Vehicle products filter.','chakta-core') );
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'vehicle_filter' );
		 parent::__construct( 'vehicle_filter', esc_html__('Chakta Vehicle Filter','chakta-core'), $widget_ops, $control_ops );
	}


	
	// Widget Output
	function widget($args, $instance) {

		extract($args);
		$title = apply_filters( 'widget_title', empty($instance['title']) ? '' : $instance['title'], $instance );
		
		echo $before_widget;

		if($title) {
			echo $before_title . $title . $after_title;
		}
		?>
	
		
			<form id="klb-vehicle-filter" class="vehicle-filter-widget" action="<?php echo esc_url( home_url( '/'  ) ); ?>" method="get">
					<div class="form_group select-make-wrap">
						<select id="make-select" name="make">
							<?php echo chakta_get_makes_output(); ?>
						</select>
					</div>
					
					<div class="form_group model-select select-model-wrap">
						<select id="model-select" name="model" disabled>
							<option value="0"><?php esc_html_e('Select Make First','chakta-core'); ?></option>
						</select>
					</div>
					
					<div class="form_group select-year">
						<select name="klb_year" id="klb_year" disabled>
						<option value=""><?php esc_html_e('Select Year','chakta-core'); ?></option>
						<option value="2015">2015</option>
						<option value="2016">2016</option>
						<option value="2017">2017</option>
						<option value="2018">2018</option>
						<option value="2019">2019</option>
						<option value="2020">2020</option>
						</select>
					</div>
				
					<input type="hidden" name="s" id="s">
					<div class="input-group-append">
						<button class="main-btn"><?php esc_html_e('Find Auto Parts','chakta-core'); ?></button>

						<input type="hidden" name="post_type" value="product" />
					</div>
				
			</form>

	


		<?php echo $after_widget;

	}
	
	// Update
	function update( $new_instance, $old_instance ) {  
		$instance = $old_instance;

		$instance['title'] = strip_tags($new_instance['title']);

		
		return $instance;
	}
	
	// Backend Form
	function form($instance) {
		
		$defaults = array('title' => 'Vehicle Filter');
		$instance = wp_parse_args((array) $instance, $defaults); ?>

		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php esc_html_e('Title:','chakta-core'); ?></label>
			<input class="widefat" style="width: 216px;" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" />
		</p>

	<?php
	}
}

// Add Widget
function widget_vehicle_filter_init() {
	register_widget('widget_vehicle_filter');
}
add_action('widgets_init', 'widget_vehicle_filter_init');

?>