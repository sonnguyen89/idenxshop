<?php

class widget_single_banner extends WP_Widget { 
	
	// Widget Settings
	function __construct() {
		$widget_ops = array('description' => esc_html__('For Mega Menu: Single Banner.','chakta-core') );
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'single_banner' );
		 parent::__construct( 'single_banner', esc_html__('Chakta Single Banner','chakta-core'), $widget_ops, $control_ops );
	}


	
	// Widget Output
	function widget($args, $instance) {

		extract($args);
		$title = apply_filters( 'widget_title', empty($instance['title']) ? '' : $instance['title'], $instance );
		
		$bannertitle = $instance['bannertitle'];	
		$subtitle = $instance['subtitle'];	
		$buttontext = $instance['buttontext'];	
		$buttonurl = $instance['buttonurl'];	


		echo $before_widget;

		if($title) {
			echo $before_title . $title . $after_title;
		}
		?>
		
		<?php if(isset($instance['imageid'])){ ?>
		<div class="shop-wrapper bg_cover" style="background-image: url(<?php echo esc_url(wp_get_attachment_url($instance['imageid'])); ?>);">
			<div class="shop-content">
				<h2><span><?php echo esc_html($bannertitle); ?></span> <?php echo esc_html($subtitle); ?></h2>
				<a href="<?php echo esc_url($buttonurl); ?>" class="main-btn"><?php echo esc_html($buttontext); ?></a>
			</div>
		</div>
		<?php } ?>


		<?php echo $after_widget;

	}
	
	// Update
	function update( $new_instance, $old_instance ) {  
		$instance = $old_instance;

		$instance['title'] = strip_tags($new_instance['title']);
		$instance['bannertitle'] = $new_instance['bannertitle'];
		$instance['subtitle'] = $new_instance['subtitle'];
		$instance['buttontext'] = $new_instance['buttontext'];
		$instance['buttonurl'] = $new_instance['buttonurl'];
		$instance['imageid'] = $new_instance['imageid'];
		
		return $instance;
	}
	
	// Backend Form
	function form($instance) {
		
		$defaults = array('title' => '', 'bannertitle'=> 'Need Any', 'subtitle' => 'Auto Services','buttontext' => 'shop now', 'buttonurl' => '#', 'imageid' => '#');
		$instance = wp_parse_args((array) $instance, $defaults); ?>

		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>">
				<?php esc_html_e('Title:','chakta-core'); ?>
				<input type="text" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" />
			</label>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('bannertitle'); ?>"><?php esc_html_e('Banner Title:','chakta-core'); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('bannertitle'); ?>" name="<?php echo $this->get_field_name('bannertitle'); ?>" value="<?php echo $instance['bannertitle']; ?>" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('subtitle'); ?>"><?php esc_html_e('Subtitle:','chakta-core'); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('subtitle'); ?>" name="<?php echo $this->get_field_name('subtitle'); ?>" value="<?php echo $instance['subtitle']; ?>" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('buttontext'); ?>"><?php esc_html_e('Button Text:','chakta-core'); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('buttontext'); ?>" name="<?php echo $this->get_field_name('buttontext'); ?>" value="<?php echo $instance['buttontext']; ?>" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('buttonurl'); ?>"><?php esc_html_e('Button URL:','chakta-core'); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('buttonurl'); ?>" name="<?php echo $this->get_field_name('buttonurl'); ?>" value="<?php echo $instance['buttonurl']; ?>" />
		</p>
		
		<p>
		  <label for="<?php echo $this->get_field_id('imageid'); ?>"><?php esc_html_e('Image:','chakta-core'); ?></label>
		  <input type="text" class="img" name="<?php echo $this->get_field_name('imageid'); ?>" id="<?php echo $this->get_field_id('imageid'); ?>" value="<?php echo $instance['imageid']; ?>" />
		  <input type="button" class="set_custom_images button button-primary" value="<?php esc_attr_e('Select Image','chakta-core'); ?>" />
		</p>
	<?php
	}
}

// Add Widget
function widget_single_banner_init() {
	register_widget('widget_single_banner');
}
add_action('widgets_init', 'widget_single_banner_init');


function klbimageupload_enqueue() {
	if (is_admin ()){
		wp_enqueue_media ();
	}
	
	wp_enqueue_script( 'widget-image', plugins_url( 'js/widget-image.js', __DIR__ ));
}
add_action('admin_enqueue_scripts', 'klbimageupload_enqueue');

?>