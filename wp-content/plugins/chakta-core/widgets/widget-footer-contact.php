<?php

class widget_footer_contact extends WP_Widget { 
	
	// Widget Settings
	function __construct() {
		$widget_ops = array('description' => esc_html__('Only Detail Page: Footer Contact.','chakta-core') );
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'footer_contact' );
		 parent::__construct( 'footer_contact', esc_html__('Chakta Footer Contact','chakta-core'), $widget_ops, $control_ops );
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


			<ul class="contact-info">
				<?php $contact_detail = get_theme_mod( 'chakta_footer_contact_widget' ); ?>
				<?php if(!empty($contact_detail)){ ?>
				<?php foreach($contact_detail as $c){ ?>
					<li>
						<i class="fal fa-<?php echo esc_attr($c['contact_icon']); ?>"></i>
						<p><?php echo chakta_sanitize_data($c['contact_info']); ?></p>
					</li>
				<?php } ?>
				<?php } ?>
				<?php if (get_theme_mod( 'chakta_footer_contact_image' )) { ?>
					<li class="payment"><img src="<?php echo esc_url( wp_get_attachment_url(get_theme_mod( 'chakta_footer_contact_image' )) ); ?>" alt="<?php bloginfo("name"); ?>"></li>
				<?php } ?>
			</ul>

		
	


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
		
		$defaults = array('title' => 'Contact Us');
		$instance = wp_parse_args((array) $instance, $defaults); ?>

		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php esc_html_e('Title:','chakta-core'); ?></label>
			<input class="widefat" style="width: 216px;" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" />
		</p>

		<p>
		  <?php esc_html_e('You can customize the contact details from Dashboard > Appearance > Customize > Chakta Widgets > Footer Contact','chakta-core'); ?>

		</p>
	<?php
	}
}

// Add Widget
function widget_footer_contact_init() {
	register_widget('widget_footer_contact');
}
add_action('widgets_init', 'widget_footer_contact_init');

?>