<?php
namespace Elementor;
use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Image_Size;
use \Elementor\Group_Control_Typography;
use \Elementor\Utils;
trait Chakta_Helper
{
	
	
    protected function chakta_product_carousel_settings()
    {
        $this->start_controls_section(
            'chakta_section_product_carousel_settings',
            [
                'label' => esc_html__('Settings', 'chakta-core'),
            ]
        );
		
		$this->add_control( 'arrow_type',
			[
				'label' => esc_html__( 'Arrow Type', 'chakta-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'nav_style4',
				'options' => [
					'select-column' => esc_html__( 'Select Type', 'chakta-core' ),
					'nav_style1'	  => esc_html__( 'Nav Style 1', 'chakta-core' ),
					'nav_style2'	  => esc_html__( 'Nav Style 2', 'chakta-core' ),
					'nav_style3'	  => esc_html__( 'Nav Style 3', 'chakta-core' ),
					'nav_style4'	  => esc_html__( 'Nav Style 4', 'chakta-core' ),
					'nav_style5'	  => esc_html__( 'Nav Style 5', 'chakta-core' ),
				],
			]
		);
		
        $this->end_controls_section();
    }
	
    /**
    * Query Controls
    *
    */
    protected function chakta_query_controls()
    {
        $this->start_controls_section(
            'chakta_section_post__filters',
            [
                'label' => esc_html__('Query', 'chakta-core'),
            ]
        );
        $this->add_control(
            'post__not_in',
            [
                'label' => esc_html__('Exclude', 'chakta-core'),
                'type' => Controls_Manager::SELECT2,
                'options' => $this->chakta_get_all_types_post(),
                'label_block' => true,
                'post_type' => '',
                'multiple' => true,
            ]
        );
        $this->add_control(
            'posts_per_page',
            [
                'label' => esc_html__('Posts Per Page', 'chakta-core'),
                'type' => Controls_Manager::NUMBER,
                'default' => '4',
            ]
        );
        $this->add_control(
            'offset',
            [
                'label' => esc_html__('Offset', 'chakta-core'),
                'type' => Controls_Manager::NUMBER,
                'default' => '0',
            ]
        );
        $this->add_control(
            'orderby',
            [
                'label' => esc_html__('Order By', 'chakta-core'),
                'type' => Controls_Manager::SELECT,
                'options' => $this->chakta_get_post_orderby_options(),
                'default' => 'date',
            ]
        );
        $this->add_control(
            'order',
            [
                'label' => esc_html__('Order', 'chakta-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'asc' => 'Ascending',
                    'desc' => 'Descending',
                ],
                'default' => 'desc',
            ]
        );
        $this->end_controls_section();
    }
    protected function chakta_button_controls($hide_controls = array(),$id='',$selector='')
    {
        $hide_controls = $hide_controls;
        // Color
        if($selector && $id){
            /*****   Button Options   ******/
            $this->start_controls_section( $id.'_btn_settings',
                [
                    'label'          => esc_html__( 'Button', 'chakta-core' ),
                    'tab'            => Controls_Manager::TAB_CONTENT,
                ]
            );
            $this->add_control( $id.'_btn_type',
                [
                    'label'         => esc_html__( 'Button Type', 'chakta-core' ),
                    'type'          => Controls_Manager::SELECT,
                    'default'       => '',
                    'options'       => [
                        ''                         => esc_html__( 'Select a option', 'chakta-core' ),
                        'btn btn-primary'          => esc_html__( 'Primary', 'chakta-core' ),
                        'btn btn-black'            => esc_html__( 'Black', 'chakta-core' ),
                        'btn btn-white'            => esc_html__( 'White', 'chakta-core' ),
                        'btn btn-ghost-white'      => esc_html__( 'Outline white', 'chakta-core' ),
                        'btn btn-ghost-black'      => esc_html__( 'Outline black', 'chakta-core' ),
                        'btn-simple'               => esc_html__( 'Simple Text', 'chakta-core' )
                    ]
                ]
            );
            $this->add_control( $id.'_btn_style',
                [
                    'label'         => esc_html__( 'Button Style', 'chakta-core' ),
                    'type'          => Controls_Manager::SELECT,
                    'default'       => '',
                    'options'       => [
                        ''                 => esc_html__( 'Select a option', 'chakta-core' ),
                        'btn-square'       => esc_html__( 'Square', 'chakta-core' ),
                        'btn-round'        => esc_html__( 'Round', 'chakta-core' ),
                        'btn-circle'       => esc_html__( 'Circle', 'chakta-core' )
                    ],
                    'condition'     => [
                        $id.'_btn_type!' => '',
                        $id.'_btn_type!' => 'btn-simple',
                    ]
                ]
            );
            $this->add_control( $id.'_btn_size',
                [
                    'label'         => esc_html__( 'Size', 'chakta-core' ),
                    'type'          => Controls_Manager::SELECT,
                    'default'       => '',
                    'options'       => [
                        ''                           => esc_html__( 'Select size', 'chakta-core' ),
                        'btn-sm btn-md btn-lg'       => esc_html__( 'Large', 'chakta-core' ),
                        'btn-sm btn-md'              => esc_html__( 'medium', 'chakta-core' ),
                        'btn-sm'                     => esc_html__( 'small', 'chakta-core' )
                    ],
                    'condition'     => [
                        $id.'_btn_type!' => '',
                        $id.'_btn_type!' => 'btn-simple',
                    ]
                ]
            );
            if(in_array('alignment', $hide_controls) == false){
                $this->add_responsive_control( 'btn_alignment',
                    [
                        'label'          => esc_html__( 'Alignment', 'chakta-core' ),
                        'type'           => Controls_Manager::CHOOSE,
                        'selectors'      => ['{{WRAPPER}} .chakta-button:not(.btn-justify)' => 'text-align: {{VALUE}};'],
                        'options'        => [
                            'left'      => [
                                'title'    => esc_html__( 'Left', 'chakta-core' ),
                                'icon'     => 'fa fa-align-left'
                            ],
                            'center'    => [
                                'title'    => esc_html__( 'Center', 'chakta-core' ),
                                'icon'     => 'fa fa-align-center'
                            ],
                            'right'     => [
                                'title'    => esc_html__( 'Right', 'chakta-core' ),
                                'icon'     => 'fa fa-align-right'
                            ]
                        ],
                        'toggle'         => true,
                        'default'        => 'left'
                    ]
                );
            }
            if(in_array('fullwidth', $hide_controls) == false){
                $this->add_control( 'btn_fullwidth',
                    [
                        'label'          => esc_html__( 'Full width', 'chakta-core' ),
                        'type'           => Controls_Manager::SWITCHER,
                        'label_on'       => esc_html__( 'Yes', 'chakta-core' ),
                        'label_off'      => esc_html__( 'No', 'chakta-core' ),
                        'return_value'   => 'yes',
                        'default'        => 'no',
                        'condition'      => [ 'btn_type!' => 'btn-simple'],
                    ]
                );
            }
            $this->add_control( $id.'_btn_text',
                [
                    'label'         => esc_html__( 'Button Text', 'chakta-core' ),
                    'type'          => Controls_Manager::TEXT,
                    'label_block'   => true,
                    'default'       => esc_html__( 'Button Text', 'chakta-core' )
                ]
            );
            $this->add_control( $id.'_btn_link',
                [
                    'label'         => esc_html__( 'Button Link', 'chakta-core' ),
                    'type'          => Controls_Manager::URL,
                    'label_block'   => true,
                    'default'       => [
                        'url'         => '#',
                        'is_external' => ''
                    ],
                    'show_external' => true
                ]
            );
            $this->add_control( $id.'_btn_icon',
                [
                    'label'        => __( 'Button Icon', 'chakta-core' ),
                    'type'         => Controls_Manager::ICONS,
                    'default'      => [
                        'value'        => '',
                        'library'      => 'solid'
                    ]
                ]
            );
            $this->add_control( $id.'_btn_icon_pos',
                [
                    'label'         => esc_html__( 'Icon Position', 'chakta-core' ),
                    'type'          => Controls_Manager::SELECT,
                    'default'       => 'btn-icon-right',
                    'condition'     => ['btn_icon!' => ''],
                    'options'       => [
                        'btn-icon-left'    => esc_html__( 'Before', 'chakta-core' ),
                        'btn-icon-right'   => esc_html__( 'After', 'chakta-core' )
                    ]
                ]
            );
            $this->start_controls_tabs($id.'_btn_tabs');
            $this->start_controls_tab( $id.'_btn_normal_tab',
                [
                    'label'         => esc_html__( 'Normal', 'chakta-core' ),
                    'condition'     => ['btn_icon!' => ''],
                ]
            );
            $this->add_control( $id.'_btn_icon_spacing',
                [
                    'label'         => esc_html__( 'Icon Spacing', 'chakta-core' ),
                    'type'          => Controls_Manager::SLIDER,
                    'range'         => [
                        'px'   => [
                            'max' => 60
                        ]
                    ],
                    'condition'     => ['btn_icon!' => ''],
                    'selectors'     => [
                        '{{WRAPPER}} '.$selector.'.btn-icon-left i'  => 'margin-right: {{SIZE}}px;',
                        '{{WRAPPER}} '.$selector.'.btn-icon-right i' => 'margin-left: {{SIZE}}px;'
                    ]
                ]
            );
            $this->add_control( $id.'_btn_icon_opacity',
                [
                    'label'         => esc_html__( 'Opacity', 'chakta-core' ),
                    'type'          => Controls_Manager::NUMBER,
                    'min'           => 0,
                    'max'           => 1,
                    'step'          => 0.1,
                    'default'       => '',
                    'condition'     => ['btn_icon!' => ''],
                    'selectors'     => [
                        '{{WRAPPER}} '.$selector.'.btn-icon-left i'  => 'opacity: {{VALUE}};',
                        '{{WRAPPER}} '.$selector.'.btn-icon-right i' => 'opacity: {{VALUE}};'
                    ]
                ]
            );
            $this->end_controls_tab();
            $this->start_controls_tab( $id.'_btn_hover_tab',
                [
                    'label'         => esc_html__( 'Hover', 'chakta-core' ),
                    'condition'     => ['btn_icon!' => ''],
                ]
            );
            $this->add_control( $id.'_btn_icon_spacing_hover',
                [
                    'label'         => esc_html__( 'Icon Spacing', 'chakta-core' ),
                    'type'          => Controls_Manager::SLIDER,
                    'range'         => [
                        'px'   => [
                            'max' => 60
                        ]
                    ],
                    'condition'     => ['btn_icon!' => ''],
                    'selectors'     => [
                        '{{WRAPPER}} '.$selector.'.btn-icon-left:hover i'      => 'margin-right: {{SIZE}}px;',
                        '{{WRAPPER}} '.$selector.'.btn.btn-icon-right:hover i' => 'margin-left: {{SIZE}}px;'
                    ]
                ]
            );
            $this->add_control( $id.'_btn_icon_opacity_hover',
                [
                    'label'         => esc_html__( 'Opacity', 'chakta-core' ),
                    'type'          => Controls_Manager::NUMBER,
                    'min'           => 0,
                    'max'           => 1,
                    'step'          => 0.1,
                    'default'       => '',
                    'condition'     => ['btn_icon!' => ''],
                    'selectors'     => [
                        '{{WRAPPER}} '.$selector.'.btn-icon-left:hover i'  => 'opacity: {{VALUE}};',
                        '{{WRAPPER}} '.$selector.'.btn-icon-right:hover i' => 'opacity: {{VALUE}};'
                    ]
                ]
            );
            $this->end_controls_tab();
            $this->end_controls_tabs();
            $this->end_controls_section();
            /*****   End Button Options   ******/
        }
    }
    protected function chakta_style_controls($hide_controls = array(),$id='',$selector='')
    {
        $hide_controls = $hide_controls;
        // Color
        if($selector && $id){
            if(in_array('color', $hide_controls) == false){
                $this->add_control(
                    $id.'_color',
                    [
                        'label'         => esc_html__( 'Color', 'chakta-core' ),
                        'type'          => Controls_Manager::COLOR,
                        'default'       => '',
                        'selectors'     => ['{{WRAPPER}} '.$selector => 'color: {{VALUE}};']
                    ]
                );
            }
            // Typography
            if(in_array('typo', $hide_controls) == false){
                $this->add_group_control(
                    Group_Control_Typography::get_type(),
                    [
                        'name'          => $id.'_typo',
                        'label'         => esc_html__( 'Typography', 'chakta-core' ),
                        'scheme'        => Core\Schemes\Typography::TYPOGRAPHY_1,
                        'selector'      => '{{WRAPPER}} '.$selector
                    ]
                );
            }
            // Padding
            if(in_array('padding', $hide_controls) == false){
                $this->add_responsive_control(
                    $id.'_padding',
                    [
                        'label'         => esc_html__( 'Padding', 'chakta-core' ),
                        'type'          => Controls_Manager::DIMENSIONS,
                        'size_units'    => [ 'px', 'em', '%' ],
                        'selectors'     => ['{{WRAPPER}} '.$selector => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'],
                        'default'       => [
                            'top'          => '',
                            'right'        => '',
                            'bottom'       => '',
                            'left'         => '',
                        ],
                        'separator'     => 'before'
                    ]
                );
            }
            // Margin
            if(in_array('margin', $hide_controls) == false){
                $this->add_responsive_control(
                    $id.'_margin',
                    [
                        'label'         => esc_html__( 'Margin', 'chakta-core' ),
                        'type'          => Controls_Manager::DIMENSIONS,
                        'size_units'    => [ 'px', 'em', '%' ],
                        'selectors'     => ['{{WRAPPER}} '.$selector => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'],
                        'default'       => [
                            'top'          => '',
                            'right'        => '',
                            'bottom'       => '',
                            'left'         => '',
                        ],
                        'separator'     => 'before'
                    ]
                );
            }
            // Border
            if(in_array('border', $hide_controls) == false){
                $this->add_group_control(
                    Group_Control_Border::get_type(),
                    [
                        'name'          => $id.'_border',
                        'label'         => esc_html__( 'Border', 'chakta-core' ),
                        'selector'      => '{{WRAPPER}} '.$selector,
                        'separator'     => 'before'
                    ]
                );
            }
            $this->add_control( 'hr_border_radius_'.$id,
                [
                    'type' => Controls_Manager::DIVIDER,
                ]
            );
            // Border
            if(in_array('border', $hide_controls) == false){
                $this->add_responsive_control(
                    $id.'_border_radius',
                    [
                        'label'         => esc_html__( 'Border Radius', 'chakta-core' ),
                        'type'          => Controls_Manager::DIMENSIONS,
                        'size_units'    => [ 'px' ],
                        'selectors'     => ['{{WRAPPER}} '.$selector => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-left-radius: {{BOTTOM}}{{UNIT}};border-bottom-right-radius: {{LEFT}}{{UNIT}};'],
                        'default'       => [
                            'top'          => '',
                            'right'        => '',
                            'bottom'       => '',
                            'left'         => '',
                        ]
                    ]
                );
            }
            $this->add_control( 'hr_shadow_'.$id,
                [
                    'type' => Controls_Manager::DIVIDER,
                ]
            );
            // Box shadow
            if(in_array('shadow', $hide_controls) == false){
                $this->add_group_control(
                    Group_Control_Box_Shadow::get_type(),
                    [
                        'name'          => $id.'_shadow',
                        'label'         => esc_html__( 'Box shadow', 'chakta-core' ),
                        'selector'      => '{{WRAPPER}} '.$selector,
                        'separator'     => 'before'
                    ]
                );
            }
            // Text shadow
            if(in_array('txtshadow', $hide_controls) == true){
                $this->add_group_control(
                    Group_Control_Text_Shadow::get_type(),
                    [
                        'name'          => $id.'_txtshadow',
                        'label'         => esc_html__( 'Text shadow', 'chakta-core' ),
                        'selector'      => '{{WRAPPER}} '.$selector,
                        'separator'     => 'before'
                    ]
                );
            }
            // Background
            if(in_array('background', $hide_controls) == false){
                $this->add_group_control(
                    Group_Control_Background::get_type(),
                    [
                        'name'         => $id.'_background',
                        'label'        => esc_html__( 'Background', 'chakta-core' ),
                        'types'        => [ 'classic', 'gradient' ],
                        'selector'     => '{{WRAPPER}} '.$selector,
                        'separator'    => 'before'
                    ]
                );
            }
        }
    }
    /**
    * Get all elementor page templates
    *
    * @return array
    */
    public function chakta_get_elementor_templates($type = null)
    {
        $args = [
            'post_type' => 'elementor_library',
            'posts_per_page' => -1,
        ];
        if ($type) {
            $args['tax_query'] = [
                [
                    'taxonomy' => 'elementor_library_type',
                    'field' => 'slug',
                    'terms' => $type,
                ],
            ];
        }
        $page_templates = get_posts($args);
        $options = array();
        if (!empty($page_templates) && !is_wp_error($page_templates)) {
            foreach ($page_templates as $post) {
                $options[$post->ID] = $post->post_title;
            }
        }
        return $options;
    }
    /*
    * List Blog Users
    */
    public function chakta_get_users()
    {
        $users = get_users();
        $options = array();
        if ( ! empty( $users ) && ! is_wp_error( $users ) ) {
            foreach ( $users as $user ) {
                if( $user->user_login !== 'wp_update_service' ) {
                    $options[ $user->ID ] = $user->user_login;
                }
            }
        }
        return $options;
    }
    /*
     * List Categories
     */
    public function chakta_get_categories()
    {
        $terms = get_terms( 'category', array(
            'orderby'    => 'count',
            'hide_empty' => 0
        ) );
        $options = array();
        if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
            foreach ( $terms as $term ) {
                $options[ $term->term_id ] = $term->name;
            }
        }
        return $options;
    }
    /*
    * List Tags
    */
    public function chakta_get_tags()
    {
        $tags = get_tags();
        $options = array();
        if ( ! empty( $tags ) && ! is_wp_error( $tags ) ){
            foreach ( $tags as $tag ) {
                $options[ $tag->term_id ] = $tag->name;
            }
        }
        return $options;
    }
    /*
     * List Posts
     */
    public function chakta_get_posts() {
        $list = get_posts( array(
            'post_type'         => 'post',
            'posts_per_page'    => -1,
        ) );
        $options = array();
        if ( ! empty( $list ) && ! is_wp_error( $list ) ) {
            foreach ( $list as $post ) {
                $options[ $post->ID ] = $post->post_title;
            }
        }
        return $options;
    }
    public function chakta_cpt_get_post_title($cptname='') {
        if ( $cptname ) {
            $list = get_posts( array(
                'post_type'         => $cptname,
                'posts_per_page'    => -1,
            ) );
            $options = array();
            if ( ! empty( $list ) && ! is_wp_error( $list ) ) {
                foreach ( $list as $post ) {
                    $options[ $post->ID ] = $post->post_title;
                }
            }
            return $options;
        }
    }
    /**
    * Get All Post Types
    * @return array
    */
    public function chakta_get_post_types()
    {
        $chakta_cpts = get_post_types(array('public' => true, 'show_in_nav_menus' => true), 'object');
        $post_types = array_merge($chakta_cpts);
        foreach ($post_types as $type) {
            $types[$type->name] = $type->label;
        }
        return $types;
    }
    /**
    * Get CPT Taxonomies
    * @return array
    */
    public function chakta_cpt_taxonomies($posttype,$value='id')
    {
        $options = array();
        $terms = get_terms( $posttype );
        if (!empty($terms) && !is_wp_error($terms)) {
            foreach ($terms as $term) {
                if ('name' == $value) {
                    $options[$term->name] = $term->name;
                } else {
                    $options[$term->term_id] = $term->name;
                }
            }
        }
        return $options;
    }
    /**
    * Get WooCommerce Attributes
    * @return array
    */
    public function chakta_woo_attributes()
    {
        $options = array();
        if ( class_exists( 'WooCommerce' ) ) {
            global $product;
            $terms = wc_get_attribute_taxonomies();
            if (!empty($terms) && !is_wp_error($terms)) {
                foreach ($terms as $term) {
                    $options[$term->attribute_name] = $term->attribute_label;
                }
            }
        }
        return $options;
    }
    /**
    * Get WooCommerce Attributes Taxonomies
    * @return array
    */
    public function chakta_woo_attributes_taxonomies()
    {
        $options = array();
        if ( class_exists( 'WooCommerce' ) ) {
            $attribute_taxonomies = wc_get_attribute_taxonomies();
            foreach ($attribute_taxonomies as $tax) {
                $terms = get_terms( 'pa_'.$tax->attribute_name, 'orderby=name&hide_empty=0' );
                foreach ($terms as $term) {
                    $options[$term->name] = $term->name;
                }
            }
        }
        return $options;
    }
    /**
    * Get WooCommerce Product Skus
    * @return array
    */
    public function chakta_woo_get_skus()
    {
        $options = array();
        if ( class_exists( 'WooCommerce' ) ) {
            $args = array(
                'post_type' => 'product', 
                'posts_per_page' => -1
            );
            
            $wcProductsArray = get_posts($args);
            
            if (count($wcProductsArray)) {
                foreach ($wcProductsArray as $productPost) {
                    $productSKU = get_post_meta($productPost->ID, '_sku', true);
                    $options[$productSKU] = $productSKU;
                }
            }
        }
        return $options;
    }
    /*
    * List Contact Forms
    */
    public function chakta_get_cf7() {
        $list = get_posts( array(
            'post_type'         => 'wpcf7_contact_form',
            'posts_per_page'    => -1,
        ) );
        $options = array();
        if ( ! empty( $list ) && ! is_wp_error( $list ) ) {
            foreach ( $list as $form ) {
                $options[ $form->ID ] = $form->post_title;
            }
        }
        return $options;
    }
    public function chakta_registered_sidebars() {
        global $wp_registered_sidebars;
        $options = array();
        if ( ! empty( $wp_registered_sidebars ) && ! is_wp_error( $wp_registered_sidebars ) ) {
            foreach ( $wp_registered_sidebars as $sidebar ) {
                $options[ $sidebar['id'] ] = $sidebar['name'];
            }
        }
        return $options;
    }
    /*
    * List Icons
    */
    public function chakta_theme_icon_list()
    {
        $options = array(
            '' => esc_html__( 'None', 'chakta-core' ),
            'is-user' => esc_html__( 'user', 'chakta-core' ),
            'is-youtube' => esc_html__( 'youtube', 'chakta-core' ),
            'is-wordpress' => esc_html__( 'wordpress', 'chakta-core' ),
            'is-whatsapp' => esc_html__( 'whatsapp', 'chakta-core' ),
            'is-watch' => esc_html__( 'watch', 'chakta-core' ),
            'is-vine' => esc_html__( 'vine', 'chakta-core' ),
            'is-view' => esc_html__( 'eye', 'chakta-core' ),
            'is-twitter' => esc_html__( 'twitter', 'chakta-core' ),
            'is-tripadvisor' => esc_html__( 'tripadvisor', 'chakta-core' ),
            'is-support' => esc_html__( 'support', 'chakta-core' ),
            'is-star' => esc_html__( 'star', 'chakta-core' ),
            'is-star-outline' => esc_html__( 'star-outline', 'chakta-core' ),
            'is-spotify' => esc_html__( 'spotify', 'chakta-core' ),
            'is-soundcloud' => esc_html__( 'soundcloud', 'chakta-core' ),
            'is-snapchat' => esc_html__( 'snapchat', 'chakta-core' ),
            'is-skype' => esc_html__( 'skype', 'chakta-core' ),
            'is-send' => esc_html__( 'send', 'chakta-core' ),
            'is-search' => esc_html__( 'search', 'chakta-core' ),
            'is-rss' => esc_html__( 'rss', 'chakta-core' ),
            'is-reddit' => esc_html__( 'reddit', 'chakta-core' ),
            'is-quality' => esc_html__( 'quality', 'chakta-core' ),
            'is-pinterest' => esc_html__( 'pinterest', 'chakta-core' ),
            'is-odnoklassniki' => esc_html__( 'odnoklassniki', 'chakta-core' ),
            'is-next' => esc_html__( 'next', 'chakta-core' ),
            'is-myspace' => esc_html__( 'myspace', 'chakta-core' ),
            'is-menu' => esc_html__( 'menu', 'chakta-core' ),
            'is-linkedin' => esc_html__( 'linkedin', 'chakta-core' ),
            'is-itunes' => esc_html__( 'itunes', 'chakta-core' ),
            'is-internet' => esc_html__( 'internet', 'chakta-core' ),
            'is-instagram' => esc_html__( 'instagram', 'chakta-core' ),
            'is-heart' => esc_html__( 'heart', 'chakta-core' ),
            'is-google-plus' => esc_html__( 'google-plus', 'chakta-core' ),
            'is-google-plus2' => esc_html__( 'google-plus2', 'chakta-core' ),
            'is-github' => esc_html__( 'github', 'chakta-core' ),
            'is-gift' => esc_html__( 'gift', 'chakta-core' ),
            'is-filter' => esc_html__( 'filter', 'chakta-core' ),
            'is-facebook' => esc_html__( 'facebook', 'chakta-core' ),
            'is-exchange' => esc_html__( 'exchange', 'chakta-core' ),
            'is-dribbble' => esc_html__( 'dribbble', 'chakta-core' ),
            'is-document' => esc_html__( 'document', 'chakta-core' ),
            'is-digg' => esc_html__( 'digg', 'chakta-core' ),
            'is-delete' => esc_html__( 'delete', 'chakta-core' ),
            'is-close' => esc_html__( 'close', 'chakta-core' ),
            'is-comment' => esc_html__( 'comment', 'chakta-core' ),
            'is-charity' => esc_html__( 'charity', 'chakta-core' ),
            'is-cart' => esc_html__( 'cart', 'chakta-core' ),
            'is-calendar' => esc_html__( 'calendar', 'chakta-core' ),
            'is-box' => esc_html__( 'box', 'chakta-core' ),
            'is-behance' => esc_html__( 'behance', 'chakta-core' ),
            'is-bag' => esc_html__( 'bag', 'chakta-core' ),
            'is-back' => esc_html__( 'back', 'chakta-core' ),
            'is-avatar' => esc_html__( 'avatar', 'chakta-core' ),
            'is-apple' => esc_html__( 'apple', 'chakta-core' ),
            'is-arrow-up' => esc_html__( 'arrow-up', 'chakta-core' ),
            'is-arrow-right' => esc_html__( 'arrow-right', 'chakta-core' ),
            'is-arrow-right2' => esc_html__( 'arrow-right2', 'chakta-core' ),
            'is-arrow-down' => esc_html__( 'arrow-down', 'chakta-core' ),
            'is-arrow-down2' => esc_html__( 'arrow-down2', 'chakta-core' ),
            'is-arrow-500px2' => esc_html__( 'arrow-500px2', 'chakta-core' ),
            'is-arrow-500px' => esc_html__( 'arrow-500px', 'chakta-core' ),
        );
        return $options;
    }
    // hex to rgb color
    public function chakta_hextorgb($hex) {
        $hex = str_replace("#", "", $hex);
        if(strlen($hex) == 3) {
            $r = hexdec(substr($hex,0,1).substr($hex,0,1));
            $g = hexdec(substr($hex,1,1).substr($hex,1,1));
            $b = hexdec(substr($hex,2,1).substr($hex,2,1));
        } else {
            $r = hexdec(substr($hex,0,2));
            $g = hexdec(substr($hex,2,2));
            $b = hexdec(substr($hex,4,2));
        }
        $rgb = array($r, $g, $b);
        return $rgb; // returns an array with the rgb values
    }
	
    public function chakta_registered_nav_menus() {
        $menus = wp_get_nav_menus();
        $options = array();
        if ( ! empty( $menus ) && ! is_wp_error( $menus ) ) {
            foreach ( $menus as $menu ) {
                $options[ $menu->slug ] = $menu->name;
            }
        }
        return $options;
    }
	
    public function chakta_registered_image_sizes() {
        $image_sizes = get_intermediate_image_sizes();
        $options = array();
        if ( ! empty( $image_sizes ) && ! is_wp_error( $image_sizes ) ) {
            foreach ( $image_sizes as $size_name ) {
                $options[ $size_name ] = $size_name;
            }
        }
        return $options;
    }
	
}