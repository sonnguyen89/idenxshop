<?php

namespace Elementor;

class Chakta_Stores_Grid_Widget extends Widget_Base {

    public function get_name() {
        return 'chakta-stores-grid';
    }
    public function get_title() {
        return 'Stores Grid (K)';
    }
    public function get_icon() {
        return 'eicon-slider-push';
    }
    public function get_categories() {
        return [ 'chakta' ];
    }

	protected function register_controls() {

		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Content', 'plugin-name' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
		
        $this->add_control( 'display_items',
            [
                'label' => esc_html__( 'Display Item count', 'chakta-core' ),
                'type' => Controls_Manager::TEXT,
                'default' => '6',
                'description'=> 'Display items.',
				'label_block' => true,
            ]
        );
		
		$this->end_controls_section();

	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		$output = '';
		

		$vendors = get_wcmp_vendors();
		
		$i = 1;
		if ($vendors && is_array($vendors)) {
			echo '<div class="stores-grid">';
			echo '<div class="row">';
			foreach ($vendors as $vendor_id) {
				
				$vendor = get_wcmp_vendor($vendor_id->id);
				$imagem = wp_get_attachment_url( $vendor->image );
				
				if($i <= $settings['display_items'] && !get_user_meta($vendor->id, '_vendor_turn_off', true)){
					echo '<div class="col-sm-6 col-md-6 col-lg-6 wow fadeInUp">';
					echo '<div class="item">';
					echo '<div class="row">';
					if($imagem){
					echo '<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 logo-img">';
					echo '<a href="'.esc_url($vendor->permalink).'"><img class="img-responsive" src="'.esc_url($imagem).'" alt="'.esc_attr($vendor_id->user_data->display_name).'"></a>';
					echo '</div>';
					}
					echo '<div class="col-lg-9 col-md-9 col-sm-6 col-xs-12">';
					echo '<h3><a href="'.esc_url($vendor->permalink).'">'.esc_html($vendor_id->user_data->display_name).'</a></h3>';
					echo '<p>'.chakta_sanitize_data($vendor->description).'</p>';
					echo '</div>';
					echo '</div>';
					echo '</div>';
					echo '</div>';
				}
				$i++;
			}
			echo '</div>';
			echo '</div>';
		}
	


	}

}
