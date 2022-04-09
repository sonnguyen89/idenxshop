<?php

// Time ----------------------------------------------------------------------------- >	
function ttbase_framework_time_shortcode($atts, $content = NULL) {

		extract(shortcode_atts(array(
				'icon' => 'yes',
				'icon_color'       => '',
				'text_color' => '',
				'time_format' => 'h:i A'
			),
			$atts
		));
		?>
		<?php ob_start(); ?>
       		<?php if ($icon == 'yes') { ?>
            <div class="ttbase-time">
            	<span class="fa fa-clock-o" <?php if ($icon_color) { ?>style="color: <?php echo esc_attr($icon_color); ?>;"<?php } ?>></span>
                <span class="time" <?php if ($text_color) { ?> style="color: <?php echo esc_attr($text_color); ?>;"<?php } ?>>
           	<?php echo current_time( esc_attr($time_format) ); ?> 
           </span>
            </div>
		<?php } ?>
        <?php if ($icon == 'no') { ?>
			<span class="time" <?php if ($text_color) { ?>style="color: <?php echo esc_attr($text_color) ?>;"<?php } ?>>
           	<?php echo current_time( esc_attr($time_format) ); ?> 
           </span>
		<?php } ?>
		<?php
		$ttbase_framework_time_output = ob_get_contents();
		ob_end_clean();
		return $ttbase_framework_time_output;
		?>
	<?php
	}

	add_shortcode('ttbase_time', 'ttbase_framework_time_shortcode');

?>