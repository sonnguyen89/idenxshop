<?php
/*======
*
* Kirki Settings
*
======*/
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Kirki' ) ) {
	return;
}

Kirki::add_config(
	'chakta_customizer', array(
		'capability'  => 'edit_theme_options',
		'option_type' => 'theme_mod',
	)
);

/*======
*
* Sections
*
======*/
$sections = array(
	'shop_settings' => array (
		esc_attr__( 'Shop Settings', 'chakta-core' ),
		esc_attr__( 'You can customize the shop settings.', 'chakta-core' ),
	),
	
	'blog_settings' => array (
		esc_attr__( 'Blog Settings', 'chakta-core' ),
		esc_attr__( 'You can customize the blog settings.', 'chakta-core' ),
	),

	'header_settings' => array (
		esc_attr__( 'Header Settings', 'chakta-core' ),
		esc_attr__( 'You can customize the header settings.', 'chakta-core' ),
	),

	'main_color' => array (
		esc_attr__( 'Main Color', 'chakta-core' ),
		esc_attr__( 'You can customize the main color.', 'chakta-core' ),
	),
	
	'elementor_templates' => array (
		esc_attr__( 'Elementor Templates', 'chakta-core' ),
		esc_attr__( 'You can customize the elementor templates.', 'chakta-core' ),
	),
	
	'map_settings' => array (
		esc_attr__( 'Map Settings', 'chakta-core' ),
		esc_attr__( 'You can customize the map settings.', 'chakta-core' ),
	),

	'footer_settings' => array (
		esc_attr__( 'Footer Settings', 'chakta-core' ),
		esc_attr__( 'You can customize the footer settings.', 'chakta-core' ),
	),
	
	'chakta_widgets' => array (
		esc_attr__( 'Chakta Widgets', 'chakta-core' ),
		esc_attr__( 'You can customize the chakta widgets.', 'chakta-core' ),
	),
	
	'gdpr_settings' => array (
		esc_attr__( 'GDPR Settings', 'chakta-core' ),
		esc_attr__( 'You can customize the GDPR settings.', 'chakta-core' ),
	),

);

foreach ( $sections as $section_id => $section ) {
	$section_args = array(
		'title' => $section[0],
		'description' => $section[1],
	);

	if ( isset( $section[2] ) ) {
		$section_args['type'] = $section[2];
	}

	if( $section_id == "colors" ) {
		Kirki::add_section( str_replace( '-', '_', $section_id ), $section_args );
	} else {
		Kirki::add_section( 'chakta_' . str_replace( '-', '_', $section_id ) . '_section', $section_args );
	}
}


/*======
*
* Fields
*
======*/
function chakta_customizer_add_field ( $args ) {
	Kirki::add_field(
		'chakta_customizer',
		$args
	);
}

	/*====== Shop ======*/
		/*====== Shop Panels ======*/
		Kirki::add_panel (
			'chakta_shop_panel',
			array(
				'title' => esc_html__( 'Shop Settings', 'chakta-core' ),
				'description' => esc_html__( 'You can customize the shop from this panel.', 'chakta-core' ),
			)
		);

		$sections = array (
			'shop_general' => array(
				esc_attr__( 'General', 'chakta-core' ),
				esc_attr__( 'You can customize shop settings.', 'chakta-core' )
			),
			
			'shop_single' => array(
				esc_attr__( 'Product Detail', 'chakta-core' ),
				esc_attr__( 'You can customize the product single settings.', 'chakta-core' )
			),
			
			'shop_breadcrumb' => array(
				esc_attr__( 'Breadcrumb', 'chakta-core' ),
				esc_attr__( 'You can customize breadcrumb settings.', 'chakta-core' )
			),
			
			'shop_year' => array(
				esc_attr__( 'Year', 'chakta-core' ),
				esc_attr__( 'You can customize year settings.', 'chakta-core' )
			),
			
		);

		foreach ( $sections as $section_id => $section ) {
			$section_args = array(
				'title' => $section[0],
				'description' => $section[1],
				'panel' => 'chakta_shop_panel',
			);

			if ( isset( $section[2] ) ) {
				$section_args['type'] = $section[2];
			}

			Kirki::add_section( 'chakta_' . str_replace( '-', '_', $section_id ) . '_section', $section_args );
		}
		
		/*====== Shop Layouts ======*/
		chakta_customizer_add_field (
			array(
				'type' => 'radio-buttonset',
				'settings' => 'chakta_shop_layout',
				'label' => esc_attr__( 'Layout', 'chakta-core' ),
				'description' => esc_attr__( 'You can choose a layout for the shop.', 'chakta-core' ),
				'section' => 'chakta_shop_general_section',
				'default' => 'left-sidebar',
				'choices' => array(
					'left-sidebar' => esc_attr__( 'Left Sidebar', 'chakta-core' ),
					'full-width' => esc_attr__( 'Full Width', 'chakta-core' ),
					'right-sidebar' => esc_attr__( 'Right Sidebar', 'chakta-core' ),
				),
			)
		);

		/*====== Shop View Type ======*/
		chakta_customizer_add_field (
			array(
				'type' => 'radio-buttonset',
				'settings' => 'chakta_view_type',
				'label' => esc_attr__( 'Default View', 'chakta-core' ),
				'description' => esc_attr__( 'You can choose a view type for the shop page.', 'chakta-core' ),
				'section' => 'chakta_shop_general_section',
				'default' => 'grid-view',
				'choices' => array(
					'grid-view' => esc_attr__( 'Grid View', 'chakta-core' ),
					'list-view' => esc_attr__( 'List view', 'chakta-core' ),
				),
			)
		);
		
		/*====== Pagination ======*/
		chakta_customizer_add_field(
			array (
			'type'        => 'radio-buttonset',
			'settings'    => 'chakta_paginate_type',
			'label'       => esc_html__( 'Pagination Type', 'chakta' ),
			'section'     => 'chakta_shop_general_section',
			'default'     => 'default',
			'choices'     => array(
				'default' => esc_attr__( 'Default', 'chakta' ),
				'loadmore' => esc_attr__( 'Load More', 'chakta' ),
				'infinite' => esc_attr__( 'Infinite', 'chakta' ),
			),
			) 
		);
		
		/*====== Shop Mobile Column======*/
		chakta_customizer_add_field (
			array(
				'type' => 'radio-buttonset',
				'settings' => 'chakta_shop_mobile_column',
				'label' => esc_attr__( 'Shop Mobile Column', 'chakta-core' ),
				'description' => esc_attr__( 'Set column for the mobile column.', 'chakta-core' ),
				'section' => 'chakta_shop_general_section',
				'default' => '1column',
				'choices' => array(
					'1column' => esc_attr__( '1 column', 'chakta-core' ),
					'2columns' => esc_attr__( '2 columns', 'chakta-core' ),
					'3columns' => esc_attr__( '3 columns', 'chakta-core' ),
				),
			)
		);
		
		/*====== Grid-List Toggle ======*/
		chakta_customizer_add_field (
			array(
				'type' => 'toggle',
				'settings' => 'chakta_grid_list_view',
				'label' => esc_attr__( 'Grid List View', 'chakta-core' ),
				'description' => esc_attr__( 'Disable or Enable grid list view on shop page.', 'chakta-core' ),
				'section' => 'chakta_shop_general_section',
				'default' => '0',
			)
		);

		/*====== Quick View Toggle ======*/
		chakta_customizer_add_field (
			array(
				'type' => 'toggle',
				'settings' => 'chakta_quick_view_button',
				'label' => esc_attr__( 'Quick View Button', 'chakta-core' ),
				'description' => esc_attr__( 'You can choose status of the quick view button.', 'chakta-core' ),
				'section' => 'chakta_shop_general_section',
				'default' => '0',
			)
		);
		
		/*====== Wishlist Toggle ======*/
		chakta_customizer_add_field (
			array(
				'type' => 'toggle',
				'settings' => 'chakta_wishlist_button',
				'label' => esc_attr__( 'Custom Wishlist Button', 'chakta-core' ),
				'description' => esc_attr__( 'You can choose status of the wishlist button.', 'chakta-core' ),
				'section' => 'chakta_shop_general_section',
				'default' => '0',
			)
		);
		
		/*====== Product Min/Max Quantity ======*/
		chakta_customizer_add_field (
			array(
				'type' => 'toggle',
				'settings' => 'chakta_min_max_quantity',
				'label' => esc_attr__( 'Min/Max Quantity', 'chakta-core' ),
				'description' => esc_attr__( 'Enable the additional quantity setting fields in product detail page.', 'chakta-core' ),
				'section' => 'chakta_shop_general_section',
				'default' => '0',
			)
		);
		
		/*====== Recently Viewed Products ======*/
		chakta_customizer_add_field (
			array(
				'type' => 'toggle',
				'settings' => 'chakta_recently_viewed_products',
				'label' => esc_attr__( 'Recently Viewed Products', 'chakta-core' ),
				'description' => esc_attr__( 'Disable or Enable Recently Viewed Products.', 'chakta-core' ),
				'section' => 'chakta_shop_general_section',
				'default' => '0',
			)
		);
		
		/*====== Product Stock Quantity ======*/
		chakta_customizer_add_field (
			array(
				'type' => 'toggle',
				'settings' => 'chakta_stock_quantity',
				'label' => esc_attr__( 'Stock Quantity', 'chakta-core' ),
				'description' => esc_attr__( 'Show stock quantity on the label.', 'chakta-core' ),
				'section' => 'chakta_shop_general_section',
				'default' => '0',
			)
		);

		chakta_customizer_add_field (
			array(
				'type' => 'toggle',
				'settings' => 'chakta_mobile_bottom_menu',
				'label' => esc_attr__( 'Mobile Bottom Menu', 'chakta-core' ),
				'description' => esc_attr__( 'Disable or Enable the bottom menu on mobile.', 'chakta-core' ),
				'section' => 'chakta_shop_general_section',
				'default' => '0',
			)
		);

		/*====== Product Image Size ======*/
		chakta_customizer_add_field (
			array(
				'type' => 'dimensions',
				'settings' => 'chakta_product_image_size',
				'label' => esc_attr__( 'Product Image Size', 'chakta-core' ),
				'description' => esc_attr__( 'You can set size of the product image for the shop page.', 'chakta-core' ),
				'section' => 'chakta_shop_general_section',
				'default' => array(
					'width' => '',
					'height' => '',
				),
			)
		);
		
		/*====== Shop Single Image Column ======*/
		chakta_customizer_add_field (
			array(
				'type'        => 'slider',
				'settings'    => 'chakta_shop_single_image_column',
				'label'       => esc_html__( 'Image Column', 'chakta-core' ),
				'section'     => 'chakta_shop_single_section',
				'default'     => 6,
				'transport'   => 'auto',
				'choices'     => [
					'min'  => 3,
					'max'  => 12,
					'step' => 1,
				],
			)
		);
		
		/*====== Shop Single Ajax Add To Cart ======*/
		chakta_customizer_add_field (
			array(
				'type' => 'toggle',
				'settings' => 'chakta_shop_single_ajax_addtocart',
				'label' => esc_attr__( 'Ajax Add to Cart', 'chakta' ),
				'section' => 'chakta_shop_single_section',
				'default' => '0',
			)
		);
		
		/*====== Shop Products Navigation  ======*/
		chakta_customizer_add_field (
			array(
				'type' => 'toggle',
				'settings' => 'chakta_products_navigation',
				'label' => esc_attr__( 'Products Navigation', 'chakta-core' ),
				'section' => 'chakta_shop_single_section',
				'default' => '0',
			)
		);
		
		/*====== Mobile Sticky Single Cart ======*/
		chakta_customizer_add_field (
			array(
				'type' => 'toggle',
				'settings' => 'chakta_mobile_single_sticky_cart',
				'label' => esc_attr__( 'Mobile Sticky Add to Cart', 'chakta-core' ),
				'description' => esc_attr__( 'Disable or Enable sticky cart button on mobile.', 'chakta-core' ),
				'section' => 'chakta_shop_single_section',
				'default' => '0',
			)
		);
		
		/*====== Product360 View ======*/
		chakta_customizer_add_field (
			array(
				'type' => 'toggle',
				'settings' => 'chakta_shop_single_product360',
				'label' => esc_attr__( 'Product360 View', 'chakta' ),
				'section' => 'chakta_shop_single_section',
				'default' => '0',
			)
		);
		
		/*====== Shop Single Image Zoom  ======*/
		chakta_customizer_add_field (
			array(
				'type' => 'toggle',
				'settings' => 'chakta_single_image_zoom',
				'label' => esc_attr__( 'Image Zoom', 'chakta-core' ),
				'section' => 'chakta_shop_single_section',
				'default' => '0',
			)
		);
		
		/*====== Shop Single Social Share ======*/
		chakta_customizer_add_field (
			array(
				'type' => 'toggle',
				'settings' => 'chakta_shop_social_share',
				'label' => esc_attr__( 'Social Share (Product Detail)', 'chakta' ),
				'section' => 'chakta_shop_single_section',
				'default' => '0',
			)
		);
		
		/*====== Shop Single Social Share ======*/
		chakta_customizer_add_field (
			array(
				'type'        => 'multicheck',
				'settings'    => 'chakta_shop_single_share',
				'section'     => 'chakta_shop_single_section',
				'default'     => array('facebook','twitter', 'pinterest', 'linkedin', 'whatsapp' ),
				'priority'    => 10,
				'choices'     => [
					'facebook'  => esc_html__( 'Facebook', 	'chakta-core' ),
					'twitter' 	=> esc_html__( 'Twitter', 	'chakta-core' ),
					'pinterest' => esc_html__( 'Pinterest', 'chakta-core' ),
					'linkedin'  => esc_html__( 'Linkedin', 	'chakta-core' ),
					'whatsapp'  => esc_html__( 'Whatsapp', 	'chakta-core' ),
				],
				'required' => array(
					array(
					  'setting'  => 'chakta_shop_social_share',
					  'operator' => '==',
					  'value'    => '1',
					),
				),
			)
		);
		
		/*====== Product Related Post Column ======*/
		chakta_customizer_add_field (
			array(
				'type' => 'radio-buttonset',
				'settings' => 'chakta_shop_related_post_column',
				'label' => esc_attr__( 'Related Post Column', 'chakta-core' ),
				'description' => esc_attr__( 'You can control related post column with this option.', 'chakta-core' ),
				'section' => 'chakta_shop_single_section',
				'default' => '4',
				'choices' => array(
					'4' => esc_attr__( '4 Columns', 'chakta-core' ),
					'3' => esc_attr__( '3 Columns', 'chakta-core' ),
					'2' => esc_attr__( '2 Columns', 'chakta-core' ),
				),
			)
		);
		
		/*====== Re-Order Product Detail ======*/
		chakta_customizer_add_field (
			array(
				'type' => 'sortable',
				'settings' => 'chakta_shop_single_reorder',
				'label' => esc_attr__( 'Re-order Product Summary', 'chakta' ),
				'description' => esc_attr__( 'Please save the changes and refresh the page once. Live preview is not available for the option.', 'chakta' ),
				'section' => 'chakta_shop_single_section',
				'default'     => [
					'woocommerce_template_single_title',
					'woocommerce_template_single_rating',
					'woocommerce_template_single_price',
					'woocommerce_template_single_excerpt',
					'klb_vehicle_details',
					'woocommerce_template_single_add_to_cart',
					'woocommerce_template_single_meta',
					'chakta_social_share',
				],
				'choices'     => [
					'woocommerce_template_single_title' => esc_html__( 'Title', 'chakta' ),
					'woocommerce_template_single_rating' => esc_html__( 'Rating', 'chakta' ),
					'woocommerce_template_single_price' => esc_html__( 'Price', 'chakta' ),
					'woocommerce_template_single_excerpt' => esc_html__( 'Excerpt', 'chakta' ),
					'klb_vehicle_details' => esc_html__( 'Specifications', 'chakta' ),
					'woocommerce_template_single_add_to_cart' => esc_html__( 'Add to Cart', 'chakta' ),
					'woocommerce_template_single_meta' => esc_html__( 'Meta', 'chakta' ),
					'chakta_social_share' => esc_html__( 'Share', 'chakta' ),
				],
			)
		);
		
		/*====== Breadcrumb Toggle ======*/
		chakta_customizer_add_field (
			array(
				'type' => 'toggle',
				'settings' => 'chakta_shop_breadcrumb',
				'label' => esc_attr__( 'Breadcrumb', 'chakta-core' ),
				'description' => esc_attr__( 'Disable or Enable breadcrumb on shop pages.', 'chakta-core' ),
				'section' => 'chakta_shop_breadcrumb_section',
				'default' => '0',
			)
		);
		
		chakta_customizer_add_field (
			array(
				'type' => 'image',
				'settings' => 'chakta_shop_breadcrumb_bg',
				'label' => esc_attr__( 'Breadcrumb Background', 'chakta-core' ),
				'description' => esc_attr__( 'You can upload a background image for the breadcrumb.', 'chakta-core' ),
				'section' => 'chakta_shop_breadcrumb_section',
				'choices' => array(
					'save_as' => 'id',
				),
				'required' => array(
					array(
					  'setting'  => 'chakta_shop_breadcrumb',
					  'operator' => '==',
					  'value'    => '1',
					),
				),
			)
		);
		
		/*====== Breadcrumb Text ======*/
		chakta_customizer_add_field (
			array(
				'type' => 'text',
				'settings' => 'chakta_breadcrumb_title',
				'label' => esc_attr__( 'Breadcrumb Title', 'chakta-core' ),
				'description' => esc_attr__( 'You can set a title for the breadcrumb..', 'chakta-core' ),
				'section' => 'chakta_shop_breadcrumb_section',
				'default' => 'Products',
				'required' => array(
					array(
					  'setting'  => 'chakta_shop_breadcrumb',
					  'operator' => '==',
					  'value'    => '1',
					),
				),
			)
		);
		
		/*====== Shop Year Option ======*/
		chakta_customizer_add_field (
			array(
				'type' => 'repeater',
				'settings' => 'chakta_shop_year',
				'label' => esc_attr__( 'Years', 'chakta-core' ),
				'description' => esc_attr__( 'You can set years for the fields.', 'chakta-core' ),
				'section' => 'chakta_shop_year_section',
				'row_label' => array (
					'type' => 'field',
					'field' => 'link_text',
				),
				'fields' => array(
					'year_data' => array(
						'type' => 'text',
						'label' => esc_attr__( 'Year', 'chakta-core' ),
						'description' => esc_attr__( 'You can set a year', 'chakta-core' ),
					),
				),
			)
		);


	/*====== Blog Settings ======*/
		/*====== Layouts ======*/
		
		chakta_customizer_add_field (
			array(
				'type' => 'radio-buttonset',
				'settings' => 'chakta_blog_layout',
				'label' => esc_attr__( 'Layout', 'chakta-core' ),
				'description' => esc_attr__( 'You can choose a layout.', 'chakta-core' ),
				'section' => 'chakta_blog_settings_section',
				'default' => 'right-sidebar',
				'choices' => array(
					'left-sidebar' => esc_attr__( 'Left Sidebar', 'chakta-core' ),
					'full-width' => esc_attr__( 'Full Width', 'chakta-core' ),
					'right-sidebar' => esc_attr__( 'Right Sidebar', 'chakta-core' ),
				),
			)
		);
		
		/*====== Blog Breadcrumb Toggle ======*/
		chakta_customizer_add_field (
			array(
				'type' => 'toggle',
				'settings' => 'chakta_blog_breadcrumb',
				'label' => esc_attr__( 'Breadcrumb', 'chakta-core' ),
				'description' => esc_attr__( 'Disable or Enable breadcrumb on blog pages.', 'chakta-core' ),
				'section' => 'chakta_blog_settings_section',
				'default' => '1',
			)
		);
		
		chakta_customizer_add_field (
			array(
				'type' => 'image',
				'settings' => 'chakta_blog_breadcrumb_bg',
				'label' => esc_attr__( 'Breadcrumb Background', 'chakta-core' ),
				'description' => esc_attr__( 'You can upload a background image for the breadcrumb.', 'chakta-core' ),
				'section' => 'chakta_blog_settings_section',
				'choices' => array(
					'save_as' => 'id',
				),
				'required' => array(
					array(
					  'setting'  => 'chakta_blog_breadcrumb',
					  'operator' => '==',
					  'value'    => '1',
					),
				),
			)
		);
		
		/*====== Blog Breadcrumb Text ======*/
		chakta_customizer_add_field (
			array(
				'type' => 'text',
				'settings' => 'chakta_blog_breadcrumb_title',
				'label' => esc_attr__( 'Breadcrumb Title', 'chakta-core' ),
				'description' => esc_attr__( 'You can set a title for the breadcrumb..', 'chakta-core' ),
				'section' => 'chakta_blog_settings_section',
				'default' => 'Blog Posts',
				'required' => array(
					array(
					  'setting'  => 'chakta_blog_breadcrumb',
					  'operator' => '==',
					  'value'    => '1',
					),
				),
			)
		);
		
		/*====== Main color ======*/
		chakta_customizer_add_field (
			array(
				'type' => 'color',
				'default' => '#ff4545',
				'settings' => 'chakta_main_color',
				'label' => esc_attr__( 'Main Color', 'chakta-core' ),
				'description' => esc_attr__( 'You can customize the main color.', 'chakta-core' ),
				'section' => 'chakta_main_color_section',
			)
		);
		
		/*====== Elementor Templates =======================================================*/
		/*====== Before Shop Elementor Templates ======*/
		chakta_customizer_add_field (
			array(
				'type'        => 'select',
				'settings'    => 'chakta_before_main_shop_elementor_template',
				'label'       => esc_html__( 'Before Shop Elementor Template', 'chakta-core' ),
				'section'     => 'chakta_elementor_templates_section',
				'default'     => '',
				'placeholder' => esc_html__( 'Select a template from elementor templates ', 'chakta-core' ),
				'choices'     => chakta_get_elementorTemplates('section'),
				
			)
		);
		
		/*====== After Shop Elementor Templates ======*/
		chakta_customizer_add_field (
			array(
				'type'        => 'select',
				'settings'    => 'chakta_after_main_shop_elementor_template',
				'label'       => esc_html__( 'After Shop Elementor Template', 'chakta-core' ),
				'section'     => 'chakta_elementor_templates_section',
				'default'     => '',
				'placeholder' => esc_html__( 'Select a template from elementor templates ', 'chakta-core' ),
				'choices'     => chakta_get_elementorTemplates('section'),
				
			)
		);
		
		/*====== Before Header Elementor Templates ======*/
		chakta_customizer_add_field (
			array(
				'type'        => 'select',
				'settings'    => 'chakta_before_main_header_elementor_template',
				'label'       => esc_html__( 'Before Header Elementor Template', 'chakta-core' ),
				'section'     => 'chakta_elementor_templates_section',
				'default'     => '',
				'placeholder' => esc_html__( 'Select a template from elementor templates, If you want to show any content before products ', 'chakta-core' ),
				'choices'     => chakta_get_elementorTemplates('section'),
				
			)
		);
	
		/*====== After Header Elementor Templates ======*/
		chakta_customizer_add_field (
			array(
				'type'        => 'select',
				'settings'    => 'chakta_after_main_header_elementor_template',
				'label'       => esc_html__( 'After Header Elementor Template', 'chakta-core' ),
				'section'     => 'chakta_elementor_templates_section',
				'default'     => '',
				'placeholder' => esc_html__( 'Select a template from elementor templates ', 'chakta-core' ),
				'choices'     => chakta_get_elementorTemplates('section'),
				
			)
		);
		
		/*====== Before Footer Elementor Template ======*/
		chakta_customizer_add_field (
			array(
				'type'        => 'select',
				'settings'    => 'chakta_before_main_footer_elementor_template',
				'label'       => esc_html__( 'Before Footer Elementor Template', 'chakta-core' ),
				'section'     => 'chakta_elementor_templates_section',
				'default'     => '',
				'placeholder' => esc_html__( 'Select a template from elementor templates, If you want to show any content before products ', 'chakta-core' ),
				'choices'     => chakta_get_elementorTemplates('section'),
				
			)
		);
		
		/*====== After Footer Elementor  Template ======*/
		chakta_customizer_add_field (
			array(
				'type'        => 'select',
				'settings'    => 'chakta_after_main_footer_elementor_template',
				'label'       => esc_html__( 'After Footer Elementor Templates', 'chakta-core' ),
				'section'     => 'chakta_elementor_templates_section',
				'default'     => '',
				'placeholder' => esc_html__( 'Select a template from elementor templates, If you want to show any content before products ', 'chakta-core' ),
				'choices'     => chakta_get_elementorTemplates('section'),
				
			)
		);

		/*====== Templates Repeater For each category ======*/
		add_action( 'init', function() {
			chakta_customizer_add_field (
				array(
					'type' => 'repeater',
					'settings' => 'chakta_elementor_template_each_shop_category',
					'label' => esc_attr__( 'Template For Categories', 'chakta-core' ),
					'description' => esc_attr__( 'You can set template for each category.', 'chakta-core' ),
					'section' => 'chakta_elementor_templates_section',
					'fields' => array(
						
						'category_id' => array(
							'type'        => 'select',
							'label'       => esc_html__( 'Select Category', 'chakta-core' ),
							'description' => esc_html__( 'Set a category', 'chakta-core' ),
							'priority'    => 10,
							'default'     => '',
							'choices'     => Kirki_Helper::get_terms( array('taxonomy' => 'product_cat') )
						),
						
						'chakta_before_main_shop_elementor_template_category' => array(
							'type'        => 'select',
							'label'       => esc_html__( 'Before Shop Elementor Template', 'chakta-core' ),
							'choices'     => chakta_get_elementorTemplates('section'),
							'default'     => '',
							'placeholder' => esc_html__( 'Select a template from elementor templates, If you want to show any content before products ', 'chakta-core' ),
						),
						
						'chakta_after_main_shop_elementor_template_category' => array(
							'type'        => 'select',
							'label'       => esc_html__( 'After Shop Elementor Template', 'chakta-core' ),
							'choices'     => chakta_get_elementorTemplates('section'),
						),
						
						'chakta_before_main_header_elementor_template_category' => array(
							'type'        => 'select',
							'label'       => esc_html__( 'Before Header Elementor Template', 'chakta-core' ),
							'choices'     => chakta_get_elementorTemplates('section'),
						),
						
						'chakta_after_main_header_elementor_template_category' => array(
							'type'        => 'select',
							'label'       => esc_html__( 'After Header Elementor Template', 'chakta-core' ),
							'choices'     => chakta_get_elementorTemplates('section'),
						),
						
						'chakta_before_main_footer_elementor_template_category' => array(
							'type'        => 'select',
							'label'       => esc_html__( 'Before Footer Elementor Template', 'chakta-core' ),
							'choices'     => chakta_get_elementorTemplates('section'),
						),
						
						'chakta_after_main_footer_elementor_template_category' => array(
							'type'        => 'select',
							'label'       => esc_html__( 'After Footer Elementor Template', 'chakta-core' ),
							'choices'     => chakta_get_elementorTemplates('section'),
						),
						

					),
				)
			);
		} );

		/*====== Map Settings ======*/
		chakta_customizer_add_field (
			array(
				'type' => 'text',
				'settings' => 'chakta_mapapi',
				'label' => esc_attr__( 'Google Map Api key', 'chakta-core' ),
				'description' => esc_attr__( 'Add your google map api key', 'chakta-core' ),
				'section' => 'chakta_map_settings_section',
				'default' => '',
			)
		);
		
	/*====== Header ======*/
		/*====== Header Panels ======*/
		Kirki::add_panel (
			'chakta_header_panel',
			array(
				'title' => esc_html__( 'Header Settings', 'chakta-core' ),
				'description' => esc_html__( 'You can customize the header from this panel.', 'chakta-core' ),
			)
		);

		$sections = array (
			'header_logo' => array(
				esc_attr__( 'Logo', 'chakta-core' ),
				esc_attr__( 'You can customize the logo which is on header..', 'chakta-core' )
			),
		
			'header_general' => array(
				esc_attr__( 'Header General', 'chakta-core' ),
				esc_attr__( 'You can customize the header.', 'chakta-core' )
			),
			
			'header_sidebar_menu' => array(
				esc_attr__( 'Header Sidebar Menu Style', 'chakta-core' ),
				esc_attr__( 'You can customize the color for the sidebar menu.', 'chakta-core' )
			),

			'header_style' => array(
				esc_attr__( 'Header Style', 'chakta-core' ),
				esc_attr__( 'You can customize the color for the header.', 'chakta-core' )
			),
			
			'header_contact' => array(
				esc_attr__( 'Header Contact Detail', 'chakta-core' ),
				esc_attr__( 'You can customize the header contact detail for Header Type 1.', 'chakta-core' )
			),

			'header_preloader' => array(
				esc_attr__( 'Preloader', 'chakta-core' ),
				esc_attr__( 'You can customize the loader.', 'chakta-core' )
			),
			

		);

		foreach ( $sections as $section_id => $section ) {
			$section_args = array(
				'title' => $section[0],
				'description' => $section[1],
				'panel' => 'chakta_header_panel',
			);

			if ( isset( $section[2] ) ) {
				$section_args['type'] = $section[2];
			}

			Kirki::add_section( 'chakta_' . str_replace( '-', '_', $section_id ) . '_section', $section_args );
		}
		
		/*====== Logo ======*/
		chakta_customizer_add_field (
			array(
				'type' => 'image',
				'settings' => 'chakta_logo',
				'label' => esc_attr__( 'Logo', 'chakta-core' ),
				'description' => esc_attr__( 'You can upload a logo.', 'chakta-core' ),
				'section' => 'chakta_header_logo_section',
				'choices' => array(
					'save_as' => 'id',
				),
			)
		);
		
		/*====== Logo Text ======*/
		chakta_customizer_add_field (
			array(
				'type' => 'text',
				'settings' => 'chakta_logo_text',
				'label' => esc_attr__( 'Set Logo Text', 'chakta-core' ),
				'description' => esc_attr__( 'You can set logo as text.', 'chakta-core' ),
				'section' => 'chakta_header_logo_section',
				'default' => 'Chakta',
			)
		);
		
		/*====== Logo Size ======*/
		chakta_customizer_add_field (
			array(
				'type'        => 'slider',
				'settings'    => 'chakta_logo_size',
				'label'       => esc_html__( 'Logo Size', 'chakta-core' ),
				'description' => esc_attr__( 'You can set size of the logo.', 'chakta-core' ),
				'section'     => 'chakta_header_logo_section',
				'default'     => 192,
				'transport'   => 'auto',
				'choices'     => [
					'min'  => 20,
					'max'  => 400,
					'step' => 1,
				],
				'output' => [
				[
					'element' => '.brand-logo a img , .top-left a img',
					'property'    => 'width',
					'units' => 'px',
				], ],
			)
		);
		
		
		chakta_customizer_add_field(
			array (
			'type'        => 'select',
			'settings'    => 'chakta_header_type',
			'label'       => esc_html__( 'Header Type', 'chakta-core' ),
			'section'     => 'chakta_header_general_section',
			'default'     => 'type-1',
			'priority'    => 10,
			'choices'     => array(
				'type1' => esc_attr__( 'Type 1', 'chakta-core' ),
				'type2' => esc_attr__( 'Type 2', 'chakta-core' ),
				'type3' => esc_attr__( 'Type 3', 'chakta-core' ),
			),
			) 
		);
		
		/*====== Header Search Toggle ======*/
		chakta_customizer_add_field (
			array(
				'type' => 'toggle',
				'settings' => 'chakta_header_search',
				'label' => esc_attr__( 'Header Search', 'chakta-core' ),
				'description' => esc_attr__( 'You can choose status of the search on the header.', 'chakta-core' ),
				'section' => 'chakta_header_general_section',
				'default' => '0',
			)
		);
		
		/*====== Header Cart Toggle ======*/
		chakta_customizer_add_field (
			array(
				'type' => 'toggle',
				'settings' => 'chakta_header_cart',
				'label' => esc_attr__( 'Header Cart', 'chakta-core' ),
				'description' => esc_attr__( 'You can choose status of the mini cart on the header.', 'chakta-core' ),
				'section' => 'chakta_header_general_section',
				'default' => '0',
			)
		);
		
		/*====== Header Account Icon ======*/
		chakta_customizer_add_field (
			array(
				'type' => 'toggle',
				'settings' => 'chakta_header_account',
				'label' => esc_attr__( 'Account Icon', 'chakta-core' ),
				'description' => esc_attr__( 'Disable or Enable User Login icon for Header Type 1', 'chakta-core' ),
				'section' => 'chakta_header_general_section',
				'default' => '0',
			)
		);
		
		/*====== Header Sidebar ======*/
		chakta_customizer_add_field (
			array(
				'type' => 'toggle',
				'settings' => 'chakta_header_sidebar',
				'label' => esc_attr__( 'Sidebar Menu', 'chakta-core' ),
				'description' => esc_attr__( 'Disable or Enable Sidebar Menu', 'chakta-core' ),
				'section' => 'chakta_header_general_section',
				'default' => '0',
			)
		);
		
		/*====== Top Header Toggle ======*/
		chakta_customizer_add_field (
			array(
				'type' => 'toggle',
				'settings' => 'chakta_top_header',
				'label' => esc_attr__( 'Top Header', 'chakta-core' ),
				'description' => esc_attr__( 'Disable or Enable the top header for Header Type 2', 'chakta-core' ),
				'section' => 'chakta_header_general_section',
				'default' => '0',
			)
		);
		
		/*====== Top Header Text ======*/
		chakta_customizer_add_field (
			array(
				'type' => 'textarea',
				'settings' => 'chakta_top_header_text',
				'label' => esc_attr__( 'Header Top Label', 'chakta-core' ),
				'description' => esc_attr__( 'You can add a text for the Header Type 2', 'chakta-core' ),
				'section' => 'chakta_header_general_section',
				'default' => '15% every  product we have a great  offer for you <a href="#">shop now</a>',
				'required' => array(
					array(
					  'setting'  => 'chakta_top_header',
					  'operator' => '==',
					  'value'    => '1',
					),
				),
			)
		);
		
		/*====== Header Sidebar Menu Style ======*/
		chakta_customizer_add_field (
			array(
				'type'        => 'typography',
				'settings' => 'chakta_header_sidebar_menu_typography',
				'label'       => esc_attr__( 'Sidebar Menu Featured Typography', 'chakta' ),
				'section'     => 'chakta_header_sidebar_menu_section',
				'default'     => [
					'font-family'    => '',
					'variant'        => '',
					'font-size'      => '16px',
					'line-height'    => '',
					'letter-spacing' => '',
					'text-transform' => '',
				],
				'priority'    => 10,
				'transport'   => 'auto',
				'output'      => [
					[
						'element' => 'header.header-area.header-area-v1 .header-navigation .nav-container .main-menu ul li > a , 
						.header-navigation .nav-container.breakpoint-on .nav-menu .main-menu ul li a ',
					],
				],		
			)
		);
		
		/*====== Header Sidebar Menu Background Color ======*/
		chakta_customizer_add_field (
			array(
				'type' => 'color',
				'default' => '#fff',
				'settings' => 'chakta_header_sidebar_menu_bg',
				'label' => esc_attr__( 'Sidebar Menu Background', 'chakta-core' ),
				'description' => esc_attr__( 'You can set a background color.', 'chakta-core' ),
				'section' => 'chakta_header_sidebar_menu_section',
			)
		);
		
		/*====== Header Sidebar Font Menu Color ======*/
		chakta_customizer_add_field (
			array(
				'type' => 'color',
				'default' => '#1111111',
				'settings' => 'chakta_header_sidebar_menu_color',
				'label' => esc_attr__( 'Sidebar Menu Font Color', 'chakta-core' ),
				'description' => esc_attr__( 'You can set a color .', 'chakta-core' ),
				'section' => 'chakta_header_sidebar_menu_section',
			)
		);
		
		/*====== Header Sidebar Menu Font Hover Color ======*/
		chakta_customizer_add_field (
			array(
				'type' => 'color',
				'default' => '#111111',
				'settings' => 'chakta_header_sidebar_menu_hvrcolor',
				'label' => esc_attr__( 'Sidebar Menu Font Hover Color', 'chakta-core' ),
				'description' => esc_attr__( 'You can set a hover color.', 'chakta-core' ),
				'section' => 'chakta_header_sidebar_menu_section',
			)
		);

		/*====== Header1 Top BG color ======*/
		chakta_customizer_add_field (
			array(
				'type' => 'color',
				'default' => '#111111',
				'settings' => 'chakta_header1_top_bg',
				'label' => esc_attr__( 'Header1 Top Background', 'chakta-core' ),
				'description' => esc_attr__( 'You can set a color for top header background.', 'chakta-core' ),
				'section' => 'chakta_header_style_section',
			)
		);
		
		/*====== Header1 Top Font color ======*/
		chakta_customizer_add_field (
			array(
				'type' => 'color',
				'default' => '#bdbdbd',
				'settings' => 'chakta_header1_top_font_color',
				'label' => esc_attr__( 'Header1 Top Font Color', 'chakta-core' ),
				'description' => esc_attr__( 'You can set a color for top header font.', 'chakta-core' ),
				'section' => 'chakta_header_style_section',
			)
		);
		
		/*====== Header1 top Style ======*/
		chakta_customizer_add_field (
			array(
				'type'        => 'typography',
				'settings' => 'chakta_header1_font_typography',
				'label'       => esc_attr__( 'Header1 Featured Typography', 'chakta' ),
				'section'     => 'chakta_header_style_section',
				'default'     => [
					'font-family'    => '',
					'variant'        => '',
					'font-size'      => '16px',
					'line-height'    => '',
					'letter-spacing' => '',
					'text-transform' => '',
				],
				'priority'    => 10,
				'transport'   => 'auto',
				'output'      => [
					[
						'element' => 'header.header-area.header-area-v1 .header-navigation .nav-container .main-menu ul li > a , 
						header.header-area.header-area-v1 .header-navigation .nav-container .main-menu ul li ul.sub-menu li a:hover',
					],
				],		
			)
		);

		/*====== Header1 Bottom BG color ======*/
		chakta_customizer_add_field (
			array(
				'type' => 'color',
				'default' => '#fff',
				'settings' => 'chakta_header1_bottom_bg',
				'label' => esc_attr__( 'Header1 Bottom Background', 'chakta-core' ),
				'description' => esc_attr__( 'You can set a color for bottom header background.', 'chakta-core' ),
				'section' => 'chakta_header_style_section',
			)
		);
		
		/*====== Header1 Bottom Font color ======*/
		chakta_customizer_add_field (
			array(
				'type' => 'color',
				'default' => '#111111',
				'settings' => 'chakta_header1_bottom_font_color',
				'label' => esc_attr__( 'Header1 Bottom Font Color', 'chakta-core' ),
				'description' => esc_attr__( 'You can set a color for bottom header font.', 'chakta-core' ),
				'section' => 'chakta_header_style_section',
			)
		);
		
		/*====== Header1 Bottom Font Hover color ======*/
		chakta_customizer_add_field (
			array(
				'type' => 'color',
				'default' => '#ff4545',
				'settings' => 'chakta_header1_bottom_font_hvrcolor',
				'label' => esc_attr__( 'Header1 Bottom Font Hover Color', 'chakta-core' ),
				'description' => esc_attr__( 'You can set a color for bottom header font.', 'chakta-core' ),
				'section' => 'chakta_header_style_section',
			)
		);
		
		/*====== Header1 Icon color ======*/
		chakta_customizer_add_field (
			array(
				'type' => 'color',
				'default' => '#111111',
				'settings' => 'chakta_header1_icon_color',
				'label' => esc_attr__( 'Header1 Icon Color', 'chakta-core' ),
				'description' => esc_attr__( 'You can set a color for icon font.', 'chakta-core' ),
				'section' => 'chakta_header_style_section',
			)
		);
		
		/*====== Header2 Top BG color ======*/
		chakta_customizer_add_field (
			array(
				'type' => 'color',
				'default' => '#fff',
				'settings' => 'chakta_header2_top_bg',
				'label' => esc_attr__( 'Header2 Top Background', 'chakta-core' ),
				'description' => esc_attr__( 'You can set a color for top header background.', 'chakta-core' ),
				'section' => 'chakta_header_style_section',
			)
		);
		
		/*====== Header2 Top Title color ======*/
		chakta_customizer_add_field (
			array(
				'type' => 'color',
				'default' => '#111111',
				'settings' => 'chakta_header2_top_title_color',
				'label' => esc_attr__( 'Header2 Top Title Color', 'chakta-core' ),
				'description' => esc_attr__( 'You can set a color for top header title.', 'chakta-core' ),
				'section' => 'chakta_header_style_section',
			)
		);
		
		/*====== Header2 Top Subtitle color ======*/
		chakta_customizer_add_field (
			array(
				'type' => 'color',
				'default' => '#646a7c',
				'settings' => 'chakta_header2_top_subtitle_color',
				'label' => esc_attr__( 'Header2 Top Subtitle Color', 'chakta-core' ),
				'description' => esc_attr__( 'You can set a color for top header subtitle.', 'chakta-core' ),
				'section' => 'chakta_header_style_section',
			)
		);
		
		/*====== Header2 top Style ======*/
		chakta_customizer_add_field (
			array(
				'type'        => 'typography',
				'settings' => 'chakta_header2_font_typography',
				'label'       => esc_attr__( 'Header2 Featured Typography', 'chakta' ),
				'section'     => 'chakta_header_style_section',
				'default'     => [
					'font-family'    => '',
					'variant'        => '',
					'font-size'      => '16px',
					'line-height'    => '',
					'letter-spacing' => '',
					'text-transform' => '',
				],
				'priority'    => 10,
				'transport'   => 'auto',
				'output'      => [
					[
						'element' => '.header-area-v2 .header-navigation .nav-container .main-menu ul li > a ',
					],
				],		
			)
		);


		/*====== Header2 Bottom Background color ======*/
		chakta_customizer_add_field (
			array(
				'type' => 'color',
				'default' => '#ff4545',
				'settings' => 'chakta_header2_bottom_bg',
				'label' => esc_attr__( 'Header2 Bottom Background', 'chakta-core' ),
				'description' => esc_attr__( 'You can set a color for bottom header background.', 'chakta-core' ),
				'section' => 'chakta_header_style_section',
			)
		);
		
		/*====== Header2 Bottom Font color ======*/
		chakta_customizer_add_field (
			array(
				'type' => 'color',
				'default' => '#fff',
				'settings' => 'chakta_header2_bottom_font_color',
				'label' => esc_attr__( 'Header2 Bottom Font Color', 'chakta-core' ),
				'description' => esc_attr__( 'You can set a color for bottom header font.', 'chakta-core' ),
				'section' => 'chakta_header_style_section',
			)
		);
		
		/*====== Header2 Bottom Font Hover color ======*/
		chakta_customizer_add_field (
			array(
				'type' => 'color',
				'default' => '#fff',
				'settings' => 'chakta_header2_bottom_font_hvrcolor',
				'label' => esc_attr__( 'Header2 Bottom Font Hover Color', 'chakta-core' ),
				'description' => esc_attr__( 'You can set a color for bottom header font.', 'chakta-core' ),
				'section' => 'chakta_header_style_section',
			)
		);
		
		/*====== Header2 Icon color ======*/
		chakta_customizer_add_field (
			array(
				'type' => 'color',
				'default' => '#fff',
				'settings' => 'chakta_header2_bottom_icon_color',
				'label' => esc_attr__( 'Header2 Icon Color', 'chakta-core' ),
				'description' => esc_attr__( 'You can set a color for icon font.', 'chakta-core' ),
				'section' => 'chakta_header_style_section',
			)
		);
		
		/*====== Featured List Single ======*/
		chakta_customizer_add_field (
			array(
				'type' => 'repeater',
				'settings' => 'chakta_header_contact',
				'label' => esc_attr__( 'Contact Details', 'chakta-core' ),
				'description' => esc_attr__( 'You can create contact details.', 'chakta-core' ),
				'section' => 'chakta_header_contact_section',
				'row_label' => array (
					'type' => 'field',
					'field' => 'link_text',
				),
				'fields' => array(
					'contact_icon' => array(
						'type' => 'text',
						'label' => esc_attr__( 'Icon', 'chakta-core' ),
						'description' => esc_attr__( 'You can set an icon.For example; clock', 'chakta-core' ),
					),
				
					'contact_title' => array(
						'type' => 'text',
						'label' => esc_attr__( 'Title', 'chakta-core' ),
						'description' => esc_attr__( 'You can set a text for the title.', 'chakta-core' ),
					),
					
					'contact_subtitle' => array(
						'type' => 'text',
						'label' => esc_attr__( 'Subtitle', 'chakta-core' ),
						'description' => esc_attr__( 'You can set a text for the subtitle.', 'chakta-core' ),
					),
				),
			)
		);

		/*====== PreLoader Toggle ======*/
		chakta_customizer_add_field (
			array(
				'type' => 'toggle',
				'settings' => 'chakta_preloader',
				'label' => esc_attr__( 'Disable Loader', 'chakta-core' ),
				'description' => esc_attr__( 'Disable or Enable the loader.', 'chakta-core' ),
				'section' => 'chakta_header_preloader_section',
				'default' => '0',
			)
		);

		/*====== Loader Image ======*/
		chakta_customizer_add_field (
			array(
				'type' => 'image',
				'settings' => 'chakta_preloader_image',
				'label' => esc_attr__( 'Image', 'chakta-core' ),
				'description' => esc_attr__( 'You can upload an image.', 'chakta-core' ),
				'section' => 'chakta_header_preloader_section',
				'choices' => array(
					'save_as' => 'id',
				),
				'required' => array(
					array(
					  'setting'  => 'chakta_preloader',
					  'operator' => '==',
					  'value'    => '0',
					),
				),
			)
		);
		
	/*====== Chakta Widgets ======*/
		/*====== Widgets Panels ======*/
		Kirki::add_panel (
			'chakta_widgets_panel',
			array(
				'title' => esc_html__( 'Chakta Widgets', 'chakta-core' ),
				'description' => esc_html__( 'You can customize the chakta widgets.', 'chakta-core' ),
			)
		);

		$sections = array (
			
			'footer_about' => array(
				esc_attr__( 'Footer About', 'chakta-core' ),
				esc_attr__( 'You can customize the footer about widget.', 'chakta-core' )
			),

			'footer_contact' => array(
				esc_attr__( 'Footer Contact', 'chakta-core' ),
				esc_attr__( 'You can customize the footer contact widget.', 'chakta-core' )
			),
		);

		foreach ( $sections as $section_id => $section ) {
			$section_args = array(
				'title' => $section[0],
				'description' => $section[1],
				'panel' => 'chakta_widgets_panel',
			);

			if ( isset( $section[2] ) ) {
				$section_args['type'] = $section[2];
			}

			Kirki::add_section( 'chakta_' . str_replace( '-', '_', $section_id ) . '_section', $section_args );
		}
		
		
		/*====== Footer About Widget Logo ======*/
		chakta_customizer_add_field (
			array(
				'type' => 'image',
				'settings' => 'chakta_footer_about_logo',
				'label' => esc_attr__( 'Logo', 'chakta-core' ),
				'description' => esc_attr__( 'You can upload a logo.', 'chakta-core' ),
				'section' => 'chakta_footer_about_section',
				'choices' => array(
					'save_as' => 'id',
				),
			)
		);
		
		/*====== Footer About Widget Textarea ======*/
		chakta_customizer_add_field (
			array(
				'type' => 'textarea',
				'settings' => 'chakta_footer_about_text',
				'label' => esc_attr__( 'Content', 'chakta-core' ),
				'description' => esc_attr__( 'You can set text for the about widget.', 'chakta-core' ),
				'section' => 'chakta_footer_about_section',
				'default' => '',
			)
		);

		/*====== Footer About Widget Social Title ======*/
		chakta_customizer_add_field (
			array(
				'type' => 'text',
				'settings' => 'chakta_footer_about_social_title',
				'label' => esc_attr__( 'Social Title', 'chakta-core' ),
				'description' => esc_attr__( 'You can set text for the social title.', 'chakta-core' ),
				'section' => 'chakta_footer_about_section',
				'default' => '',
			)
		);
		
		/*====== Footer About Widget Social======*/
		chakta_customizer_add_field (
			array(
				'type' => 'repeater',
				'settings' => 'chakta_footer_about_social',
				'label' => esc_attr__( 'Footer About Social', 'chakta-core' ),
				'description' => esc_attr__( 'You can set the widget settings.', 'chakta-core' ),
				'section' => 'chakta_footer_about_section',
				'fields' => array(
					'social_icon' => array(
						'type' => 'text',
						'label' => esc_attr__( 'Icon', 'chakta-core' ),
						'description' => esc_attr__( 'You can set an icon from fontawesome.com for example; "facebook-f"', 'chakta-core' ),
					),

					'social_url' => array(
						'type' => 'text',
						'label' => esc_attr__( 'URL', 'chakta-core' ),
						'description' => esc_attr__( 'You can set url for the item.', 'chakta-core' ),
					),

				),
			)
		);

		/*====== Footer Contact Widget Repeater ======*/
		chakta_customizer_add_field (
			array(
				'type' => 'repeater',
				'settings' => 'chakta_footer_contact_widget',
				'label' => esc_attr__( 'Contact', 'chakta-core' ),
				'description' => esc_attr__( 'You can set contact details for Qualis Contact Widget.', 'chakta-core' ),
				'section' => 'chakta_footer_contact_section',
				'fields' => array(
				
					'contact_icon' => array(
						'type' => 'text',
						'label' => esc_attr__( 'Contact Icon', 'chakta-core' ),
						'description' => esc_attr__( 'set an icon.', 'chakta-core' ),
					),

					'contact_info' => array(
						'type' => 'textarea',
						'label' => esc_attr__( 'Contact Info', 'chakta-core' ),
						'description' => esc_attr__( 'Add contact details.', 'chakta-core' ),
					),
					
					
				),
			)
		);
		
		/*====== Footer Contact Widget Payment Image ======*/
		chakta_customizer_add_field (
			array(
				'type' => 'image',
				'settings' => 'chakta_footer_contact_image',
				'label' => esc_attr__( 'Image', 'chakta-core' ),
				'description' => esc_attr__( 'You can upload an image.', 'chakta-core' ),
				'section' => 'chakta_footer_contact_section',
				'choices' => array(
					'save_as' => 'id',
				),
			)
		);
		
	/*====== Footer ======*/
		/*====== Footer Panels ======*/
		Kirki::add_panel (
			'chakta_footer_panel',
			array(
				'title' => esc_html__( 'Footer Settings', 'chakta-core' ),
				'description' => esc_html__( 'You can customize the footer from this panel.', 'chakta-core' ),
			)
		);

		$sections = array (
			
			'footer_general' => array(
				esc_attr__( 'Footer General', 'chakta-core' ),
				esc_attr__( 'You can customize the footer settings.', 'chakta-core' )
			),
			
			'footer_style' => array(
				esc_attr__( 'Footer Style', 'chakta-core' ),
				esc_attr__( 'You can customize the footer style.', 'chakta-core' )
			),
		);
		
		

		foreach ( $sections as $section_id => $section ) {
			$section_args = array(
				'title' => $section[0],
				'description' => $section[1],
				'panel' => 'chakta_footer_panel',
			);

			if ( isset( $section[2] ) ) {
				$section_args['type'] = $section[2];
			}

			Kirki::add_section( 'chakta_' . str_replace( '-', '_', $section_id ) . '_section', $section_args );
		}
		
		/*====== Copyright ======*/
		chakta_customizer_add_field (
			array(
				'type' => 'text',
				'settings' => 'chakta_copyright',
				'label' => esc_attr__( 'Copyright', 'chakta-core' ),
				'description' => esc_attr__( 'You can set a copyright text for the footer.', 'chakta-core' ),
				'section' => 'chakta_footer_general_section',
				'default' => '',
			)
		);

		/*====== Footer Column ======*/
		chakta_customizer_add_field (
			array(
				'type' => 'radio-buttonset',
				'settings' => 'chakta_footer_column',
				'label' => esc_attr__( 'Footer Column', 'chakta-core' ),
				'description' => esc_attr__( 'You can set footer column.', 'chakta-core' ),
				'section' => 'chakta_footer_general_section',
				'default' => '4columns',
				'choices' => array(
					'3columns' => esc_attr__( '3 Columns', 'chakta-core' ),
					'4columns' => esc_attr__( '4 Columns', 'chakta-core' ),
					'5columns' => esc_attr__( '5 Columns', 'chakta-core' ),
				),
			)
		);
		
		/*====== Footer Background Color ======*/
		chakta_customizer_add_field (
			array(
				'type' => 'color',
				'default' => '#111111',
				'settings' => 'chakta_footer_bg_color',
				'label' => esc_attr__( 'Footer Background Color', 'chakta-core' ),
				'description' => esc_attr__( 'You can set a background.', 'chakta-core' ),
				'section' => 'chakta_footer_style_section',
			)
		);
		
		/*====== Footer Border Color ======*/
		chakta_customizer_add_field (
			array(
				'type' => 'color',
				'default' => '#252525',
				'settings' => 'chakta_footer_border_color',
				'label' => esc_attr__( 'Footer Border Color', 'chakta-core' ),
				'description' => esc_attr__( 'You can set a color.', 'chakta-core' ),
				'section' => 'chakta_footer_style_section',
			)
		);
		
		/*====== Footer Header Style ======*/
		chakta_customizer_add_field (
			array(
				'type'        => 'typography',
				'settings' => 'chakta_footer_header_size',
				'label'       => esc_attr__( 'Footer Header Featured Typography', 'chakta' ),
				'section'     => 'chakta_footer_style_section',
				'default'     => [
					'font-family'    => '',
					'variant'        => '',
					'font-size'      => '24px',
					'line-height'    => '',
					'letter-spacing' => '',
					'text-transform' => '',
					
				],
				'priority'    => 10,
				'transport'   => 'auto',
				'output'      => [
					[
						'element' => '.footer-area .footer_widget .widget h4.widget-title',
					],
				],
			)
		);
		
		/*====== Footer Header Color ======*/
		chakta_customizer_add_field (
			array(
				'type' => 'color',
				'default' => '#fff',
				'settings' => 'chakta_footer_header_color',
				'label' => esc_attr__( 'Footer Header Color', 'chakta-core' ),
				'description' => esc_attr__( 'You can set a color.', 'chakta-core' ),
				'section' => 'chakta_footer_style_section',
			)
		);
		
		/*====== Footer Header Hover Color ======*/
		chakta_customizer_add_field (
			array(
				'type' => 'color',
				'default' => '#fff',
				'settings' => 'chakta_footer_header_hvrcolor',
				'label' => esc_attr__( 'Footer Header Hover Color', 'chakta-core' ),
				'description' => esc_attr__( 'You can set a color.', 'chakta-core' ),
				'section' => 'chakta_footer_style_section',
			)
		);
		
		/*====== Footer Font Style ======*/
		chakta_customizer_add_field (
			array(
				'type'        => 'typography',
				'settings' => 'chakta_footer_size',
				'label'       => esc_attr__( 'Footer Font Featured Typography', 'chakta' ),
				'section'     => 'chakta_footer_style_section',
				'default'     => [
					'font-family'    => '',
					'variant'        => '',
					'font-size'      => '15px',
					'line-height'    => '',
					'letter-spacing' => '',
					'text-transform' => '',
					
				],
				'priority'    => 10,
				'transport'   => 'auto',
				'output'      => [
					[
						'element' => '.footer-area .footer_widget .klbfooterwidget ul li a',
					],
				],
			)
		);
		
		/*====== Footer Font Color ======*/
		chakta_customizer_add_field (
			array(
				'type' => 'color',
				'default' => '#fff',
				'settings' => 'chakta_footer_color',
				'label' => esc_attr__( 'Footer Font Color', 'chakta-core' ),
				'description' => esc_attr__( 'You can set a color.', 'chakta-core' ),
				'section' => 'chakta_footer_style_section',
			)
		);
		
		/*====== Footer Font Hover Color ======*/
		chakta_customizer_add_field (
			array(
				'type' => 'color',
				'default' => '#ff4545',
				'settings' => 'chakta_footer_hvrcolor',
				'label' => esc_attr__( 'Footer Font Hover Color', 'chakta-core' ),
				'description' => esc_attr__( 'You can set a color.', 'chakta-core' ),
				'section' => 'chakta_footer_style_section',
			)
		);
		
		/*====== Footer Copyright Style ======*/
		chakta_customizer_add_field (
			array(
				'type'        => 'typography',
				'settings' => 'chakta_footer_cpy_typography',
				'label'       => esc_attr__( 'Footer Copyright Featured Typography', 'chakta' ),
				'section'     => 'chakta_footer_style_section',
				'default'     => [
					'font-family'    => '',
					'variant'        => '',
					'font-size'      => '15px',
					'line-height'    => '',
					'letter-spacing' => '',
					'text-transform' => '',
				],
				'priority'    => 10,
				'transport'   => 'auto',
				'output'      => [
					[
						'element' => '.footer-area .copyright-area .copyright-text p',
					],
				],		
			)
		);
		
		/*====== Footer Copyright Color ======*/
		chakta_customizer_add_field (
			array(
				'type' => 'color',
				'default' => '#fff',
				'settings' => 'chakta_footer_cpy_color',
				'label' => esc_attr__( 'Footer Copyright Color', 'chakta-core' ),
				'description' => esc_attr__( 'You can set a color.', 'chakta-core' ),
				'section' => 'chakta_footer_style_section',
			)
		);
		
		/*====== Footer Copyright Hover Color ======*/
		chakta_customizer_add_field (
			array(
				'type' => 'color',
				'default' => '#fff',
				'settings' => 'chakta_footer_cpy_hvrcolor',
				'label' => esc_attr__( 'Footer Copyright Hover Color', 'chakta-core' ),
				'description' => esc_attr__( 'You can set a hover color.', 'chakta-core' ),
				'section' => 'chakta_footer_style_section',
			)
		);
		
		/*====== GDPR Toggle ======*/
		chakta_customizer_add_field (
			array(
				'type' => 'toggle',
				'settings' => 'chakta_gdpr_toggle',
				'label' => esc_attr__( 'Enable GDPR', 'chakta-core' ),
				'description' => esc_attr__( 'You can choose status of GDPR.', 'chakta-core' ),
				'section' => 'chakta_gdpr_settings_section',
				'default' => '0',
			)
		);
		
		/*====== GDPR Text ======*/
		chakta_customizer_add_field (
			array(
				'type' => 'textarea',
				'settings' => 'chakta_gdpr_text',
				'label' => esc_attr__( 'GDPR Text', 'chakta-core' ),
				'section' => 'chakta_gdpr_settings_section',
				'default' => 'The cookie settings on this website are set to allow all cookies to give you the very best experience. Please click Accept Cookies to continue to use the site',
				'required' => array(
					array(
					  'setting'  => 'chakta_gdpr_toggle',
					  'operator' => '==',
					  'value'    => '1',
					),
				),
			)
		);
		
		/*====== GDPR Expire Date ======*/
		chakta_customizer_add_field (
			array(
				'type' => 'text',
				'settings' => 'chakta_gdpr_expire_date',
				'label' => esc_attr__( 'GDPR Expire Date', 'chakta-core' ),
				'section' => 'chakta_gdpr_settings_section',
				'default' => '15',
				'required' => array(
					array(
					  'setting'  => 'chakta_gdpr_toggle',
					  'operator' => '==',
					  'value'    => '1',
					),
				),
			)
		);
		
		/*====== GDPR Button Text ======*/
		chakta_customizer_add_field (
			array(
				'type' => 'text',
				'settings' => 'chakta_gdpr_button_text',
				'label' => esc_attr__( 'GDPR Button Text', 'chakta-core' ),
				'section' => 'chakta_gdpr_settings_section',
				'default' => 'Accept Cookies',
				'required' => array(
					array(
					  'setting'  => 'chakta_gdpr_toggle',
					  'operator' => '==',
					  'value'    => '1',
					),
				),
			)
		);
		

