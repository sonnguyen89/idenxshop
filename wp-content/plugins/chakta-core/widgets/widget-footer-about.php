<?php

class widget_footer_about extends WP_Widget { 
	
	// Widget Settings
	function __construct() {
		$widget_ops = array('description' => esc_html__('Only Detail Page: Footer About.','chakta-core') );
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'footer_about' );
		 parent::__construct( 'footer_about', esc_html__('Chakta Footer About','chakta-core'), $widget_ops, $control_ops );
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
		
		
		<div class="klb-about-widget about-widget">
			<?php if (get_theme_mod( 'chakta_footer_about_logo' )) { ?>
				<img src="<?php echo esc_url( wp_get_attachment_url(get_theme_mod( 'chakta_footer_about_logo' )) ); ?>" class="img-fluid" alt="<?php bloginfo("name"); ?>" width="192" height="40">
			<?php } ?>
			<p><?php echo chakta_sanitize_data(get_theme_mod('chakta_footer_about_text')); ?></p>
			<?php $socialfooter = get_theme_mod( 'chakta_footer_about_social' ); ?>
			<?php if(!empty($socialfooter)){ ?>
			<div class="social-box">
				<h5><?php echo esc_html(get_theme_mod('chakta_footer_about_social_title')); ?></h5>
				<ul class="social-link">
					<?php foreach($socialfooter as $s){ ?>
						<li><a  href="<?php echo esc_url($s['social_url']); ?>"><i class="fab fa-<?php echo esc_attr($s['social_icon']); ?>"></i></a></li>
					<?php } ?>
				</ul>
			</div>
			<?php } ?>
		</div>
	



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
		
		$defaults = array('title' => '');
		$instance = wp_parse_args((array) $instance, $defaults); ?>

		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php esc_html_e('Title:','chakta-core'); ?></label>
			<input class="widefat" style="width: 216px;" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" />
		</p>

		<p>
		  <?php esc_html_e('You can customize the about widget from Dashboard > Appearance > Customize > Chakta Widgets > Footer About','chakta-core'); ?>

		</p>
	<?php
	}
}

// Add Widget
function widget_footer_about_init() {
	register_widget('widget_footer_about');
}
add_action('widgets_init', 'widget_footer_about_init');

?>