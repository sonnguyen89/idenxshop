<?php

// add custom menu fields to menu
add_filter( 'wp_setup_nav_menu_item', 'gymx_add_custom_nav_fields' );

// save menu custom fields
add_action( 'wp_update_nav_menu_item', 'gymx_update_custom_nav_fields', 10, 3 );

// edit menu walker
add_filter( 'wp_edit_nav_menu_walker', 'gymx_edit_walker', 10, 2 );


function gymx_add_custom_nav_fields( $menu_item ) {
	$menu_item->icon = get_post_meta( $menu_item->ID, '_menu_item_icon', true );
	$menu_item->background = get_post_meta( $menu_item->ID, '_menu_item_background', true );
	$menu_item->bg_position = get_post_meta( $menu_item->ID, '_menu_item_bg_position', true );
	$menu_item->megamenu = get_post_meta( $menu_item->ID, '_menu_item_megamenu', true );
	$menu_item->menu_position = get_post_meta( $menu_item->ID, '_menu_item_menu_position', true );
	$menu_item->menutitle = get_post_meta( $menu_item->ID, '_menu_item_menutitle', true );
	$menu_item->cols_nums = get_post_meta( $menu_item->ID, '_menu_item_cols_nums', true );
	return $menu_item;
   
}

/**
 * Save menu custom fields
 *
*/
function gymx_update_custom_nav_fields( $menu_id, $menu_item_db_id, $args ) {
		
		$check = array('icon', 'background', 'bg_position', 'megamenu', 'menu_position', 'menutitle', 'cols_nums');
			
		foreach ( $check as $key )
		{
			if(!isset($_POST['menu-item-'.$key][$menu_item_db_id]))
			{
				$_POST['menu-item-'.$key][$menu_item_db_id] = "";
			}
			
			$value = $_POST['menu-item-'.$key][$menu_item_db_id];
			update_post_meta( $menu_item_db_id, '_menu_item_'.$key, $value );
		}
		

}

/**
 * Define new Walker edit
 *
*/
function gymx_edit_walker($walker,$menu_id) {

	return 'GymX_Walker_Nav_Menu_Edit';
		
}

include_once get_template_directory() . '/framework/menu/custom_walker.php';


/* Custom WP_NAV_MENU function for top navigation */

if (!class_exists('gymx_header_walker_nav_menu')) {
	class gymx_header_walker_nav_menu extends Walker_Nav_Menu {
		
	// add classes to ul sub-menus
		function display_element( $element, &$children_elements, $max_depth, $depth=0, $args, &$output )
			{
					$id_field = $this->db_fields['id'];
					if ( is_object( $args[0] ) ) {
							$args[0]->has_children = ! empty( $children_elements[$element->$id_field] );
					}
					return parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
			}

		function start_lvl( &$output, $depth = 0, $args = array() ) {
			
			$indent = str_repeat("\t", $depth);
			if($depth == 0){
				$out_div = '<div class="second-lvl">';
			}else{
				$out_div = '';
			}
			
			// build html
			$output .= "\n" . $indent . $out_div  .'<ul>' . "\n";
		}
		function end_lvl( &$output, $depth = 0, $args = array() ) {
			$indent = str_repeat("\t", $depth);
			
			if($depth == 0){
				$out_div_close = '</div>';
			}else{
				$out_div_close = '';
			}
			
			$output .= "$indent</ul>". $out_div_close ."\n";
		}

		// add main/sub classes to li's and links
		function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
			
			global $wp_query;
			$sub = "";
			$indent = ( $depth > 0 ? str_repeat( "\t", $depth ) : '' ); // code indent
			
			if($depth==1 && $args->has_children) : 
				$sub = 'sub';
			endif;
			
			if($item->icon != ''){
				$item_icon = '<i class="'.$item->icon.'"></i> ';
			}else{
				$item_icon = '';
			}
			
			if($item->background != ''){
				$background_image = 'data-background-image="'.$item->background.'"';
				$background_position = 'data-background-pos="'.$item->bg_position.'"';
			}else{
				$background_image = '';
				$background_position = '';
			}
			
			if($item->megamenu != ''){
				$check_mega_menu = ' mega-menu';
			}else{
				$check_mega_menu = ' no-mega-menu';
			}
			
			if($item->menu_position == 'left'){
				$menu_position = ' open-left';
			}else{
				$menu_position = '';
			}
			
			if($item->menutitle != ''){
				$check_menu_title = ' menu-title';
			}else{
				$check_menu_title = '';
			}

			$active = "";
			
			// depth dependent classes
			if ((($item->current && $depth == 0) ||  ($item->current_item_ancestor && $depth == 0))) { $active = 'active'; }
		
			// passed classes
			$classes = empty( $item->classes ) ? array() : (array) $item->classes;

			$class_names = esc_attr( implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) ) );
			// build html
			$menu_id = rand();
			$output .= $indent . '<li id="'. $menu_id .'-menu-item-'. $item->ID . '" class="' . $class_names . ' ' . $active . $sub . $check_mega_menu . $menu_position . $check_menu_title . ' ' . $item->cols_nums .'" '.$background_image . $background_position .'>';
			
			$current_a = "";
			
			// link attributes
			$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
			$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
			$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
			$attributes .= ' href="'   . esc_attr( $item->url        ) .'"';
			if (($item->current && $depth == 0) ||  ($item->current_item_ancestor && $depth == 0) ):
			$current_a .= 'current';
			endif;
			$attributes .= ' class="'. $current_a . '"';
			$item_output = '';
			if (isset($args->before)) {
				$item_output = $args->before;
			}
			if($item->hide == ""){
				$item_output .= '<a'. $attributes .'>';
				$item_output .= $item_icon;
				$item_output .= apply_filters( 'the_title', $item->title, $item->ID );
				$item_output .= '</a>';
			}
			
			if (isset($args->after)) {
				$item_output .= $args->after;
			}
			
			// build html
			$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
		}
	}
}