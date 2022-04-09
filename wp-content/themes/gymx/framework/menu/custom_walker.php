<?php
/**
 *  /!\ This is a copy of Walker_Nav_Menu_Edit class in core
 * 
 * Create HTML list of nav menu input items.
 *
 * @package WordPress
 * @since 3.0.0
 * @uses Walker_Nav_Menu
 */
class GymX_Walker_Nav_Menu_Edit extends Walker_Nav_Menu  {
	/**
	 * @see Walker_Nav_Menu::start_lvl()
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference.
	 */
	function start_lvl( &$output, $depth = 0, $args = array() ) {	
	}
	
	/**
	 * @see Walker_Nav_Menu::end_lvl()
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference.
	 */
	function end_lvl( &$output, $depth = 0, $args = array() ) {
	}
	
	/**
	 * @see Walker::start_el()
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param object $item Menu item data object.
	 * @param int $depth Depth of menu item. Used for padding.
	 * @param object $args
	 */
	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
	    global $_wp_nav_menu_max_depth;
	   
	    $_wp_nav_menu_max_depth = $depth > $_wp_nav_menu_max_depth ? $depth : $_wp_nav_menu_max_depth;
	
	    $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
	
	    ob_start();
	    $item_id = esc_attr( $item->ID );
	    $removed_args = array(
	        'action',
	        'customlink-tab',
	        'edit-menu-item',
	        'menu-item',
	        'page-tab',
	        '_wpnonce',
	    );
	
	    $original_title = '';
	    if ( 'taxonomy' == $item->type ) {
	        $original_title = get_term_field( 'name', $item->object_id, $item->object, 'raw' );
	        if ( is_wp_error( $original_title ) )
	            $original_title = false;
	    } elseif ( 'post_type' == $item->type ) {
	        $original_object = get_post( $item->object_id );
	        $original_title = $original_object->post_title;
	    }
	
	    $classes = array(
	        'menu-item menu-item-depth-' . $depth,
	        'menu-item-' . esc_attr( $item->object ),
	        'menu-item-edit-' . ( ( isset( $_GET['edit-menu-item'] ) && $item_id == $_GET['edit-menu-item'] ) ? 'active' : 'inactive'),
	    );
	
	    $title = $item->title;
	
	    if ( ! empty( $item->_invalid ) ) {
	        $classes[] = 'menu-item-invalid';
	        /* translators: %s: title of menu item which is invalid */
	        $title = sprintf( esc_html__( '%s (Invalid)', 'gymx' ), $item->title );
	    } elseif ( isset( $item->post_status ) && 'draft' == $item->post_status ) {
	        $classes[] = 'pending';
	        /* translators: %s: title of menu item in draft status */
	        $title = sprintf( esc_html__('%s (Pending)', 'gymx'), $item->title );
	    }
	
	    $title = empty( $item->label ) ? $title : $item->label;
	
	    ?>
	    <li id="menu-item-<?php echo esc_attr($item_id); ?>" class="<?php echo implode(' ', $classes ); ?>">
	        <dl class="menu-item-bar">
	            <dt class="menu-item-handle">
	                <span class="item-title"><?php echo esc_html( $title ); ?></span>
	                <span class="item-controls">
	                    <span class="item-type"><?php echo esc_html( $item->type_label ); ?></span>
	                    <span class="item-order hide-if-js">
	                        <a href="<?php
	                            echo wp_nonce_url(
	                                add_query_arg(
	                                    array(
	                                        'action' => 'move-up-menu-item',
	                                        'menu-item' => $item_id,
	                                    ),
	                                    remove_query_arg($removed_args, admin_url( 'nav-menus.php' ) )
	                                ),
	                                'move-menu_item'
	                            );
	                        ?>" class="item-move-up"><abbr title="<?php esc_attr_e('Move up', 'gymx'); ?>">&#8593;</abbr></a>
	                        |
	                        <a href="<?php
	                            echo wp_nonce_url(
	                                add_query_arg(
	                                    array(
	                                        'action' => 'move-down-menu-item',
	                                        'menu-item' => $item_id,
	                                    ),
	                                    remove_query_arg($removed_args, admin_url( 'nav-menus.php' ) )
	                                ),
	                                'move-menu_item'
	                            );
	                        ?>" class="item-move-down"><abbr title="<?php esc_attr_e('Move down', 'gymx'); ?>">&#8595;</abbr></a>
	                    </span>
	                    <a class="item-edit" id="edit-<?php echo esc_attr($item_id); ?>" title="<?php esc_attr_e('Edit Menu Item', 'gymx'); ?>" href="<?php
	                        echo ( isset( $_GET['edit-menu-item'] ) && $item_id == $_GET['edit-menu-item'] ) ? admin_url( 'nav-menus.php' ) : add_query_arg( 'edit-menu-item', $item_id, remove_query_arg( $removed_args, admin_url( 'nav-menus.php#menu-item-settings-' . $item_id ) ) );
	                    ?>"><?php esc_html_e( 'Edit Menu Item', 'gymx' ); ?></a>
	                </span>
	            </dt>
	        </dl>
	
	        <div class="menu-item-settings" id="menu-item-settings-<?php echo esc_attr($item_id); ?>">
				
	            <?php if( 'custom' == $item->type ) : ?>
	                <p class="field-url description description-wide">
	                    <label for="edit-menu-item-url-<?php echo esc_attr($item_id); ?>">
	                        <?php esc_html_e( 'URL', 'gymx' ); ?><br />
	                        <input type="text" id="edit-menu-item-url-<?php echo esc_attr($item_id); ?>" class="widefat code edit-menu-item-url" name="menu-item-url[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->url ); ?>" />
	                    </label>
	                </p>
	            <?php endif; ?>
				
	            <p class="description description-thin">
	                <label for="edit-menu-item-title-<?php echo esc_attr($item_id); ?>">
	                    <?php esc_html_e( 'Navigation Label', 'gymx' ); ?><br />
	                    <input type="text" id="edit-menu-item-title-<?php echo esc_attr($item_id); ?>" class="widefat edit-menu-item-title" name="menu-item-title[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->title ); ?>" />
	                </label>
	            </p>
				
	            <p class="description description-thin">
	                <label for="edit-menu-item-attr-title-<?php echo esc_attr($item_id); ?>">
	                    <?php esc_html_e( 'Title Attribute', 'gymx' ); ?><br />
	                    <input type="text" id="edit-menu-item-attr-title-<?php echo esc_attr($item_id); ?>" class="widefat edit-menu-item-attr-title" name="menu-item-attr-title[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->post_excerpt ); ?>" />
	                </label>
	            </p>
				<p class="field-link-target description">
					<label for="edit-menu-item-target-<?php echo esc_attr($item_id); ?>">
						<input type="checkbox" id="edit-menu-item-target-<?php echo esc_attr($item_id); ?>" value="_blank" name="menu-item-target[<?php echo esc_attr($item_id); ?>]"<?php checked( $item->target, '_blank' ); ?> />
						<?php esc_html_e( 'Open link in a new tab', 'gymx' ); ?>
					</label>
				</p>
	            <p class="field-css-classes description description-thin">
	                <label for="edit-menu-item-classes-<?php echo esc_attr($item_id); ?>">
	                    <?php esc_html_e( 'CSS Classes (optional)', 'gymx' ); ?><br />
	                    <input type="text" id="edit-menu-item-classes-<?php echo esc_attr($item_id); ?>" class="widefat code edit-menu-item-classes" name="menu-item-classes[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( implode(' ', $item->classes ) ); ?>" />
	                </label>
	            </p>
				
	            <p class="field-xfn description description-thin">
	                <label for="edit-menu-item-xfn-<?php echo esc_attr($item_id); ?>">
	                    <?php esc_html_e( 'Link Relationship (XFN)', 'gymx' ); ?><br />
	                    <input type="text" id="edit-menu-item-xfn-<?php echo esc_attr($item_id); ?>" class="widefat code edit-menu-item-xfn" name="menu-item-xfn[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->xfn ); ?>" />
	                </label>
	            </p>
				
	            <p class="field-description description description-wide">
	                <label for="edit-menu-item-description-<?php echo esc_attr($item_id); ?>">
	                    <?php esc_html_e( 'Description', 'gymx' ); ?><br />
	                    <textarea id="edit-menu-item-description-<?php echo esc_attr($item_id); ?>" class="widefat edit-menu-item-description" rows="3" cols="20" name="menu-item-description[<?php echo esc_attr($item_id); ?>]"><?php echo esc_html( $item->description ); // textarea_escaped ?></textarea>
	                    <span class="description"><?php esc_html_e('The description will be displayed in the menu if the current theme supports it.', 'gymx'); ?></span>
	                </label>
	            </p>
				
				<p class="field-css-classes description description-wide"></p>
				
				<p class="field-custom description description-thin" style="margin:10px 0 12px 0;">
	                <label for="edit-menu-item-icon-<?php echo esc_attr($item_id); ?>">
	                    <?php esc_html_e( 'Add Icon', 'gymx' ); ?><br />
	                    <input type="text" id="edit-menu-item-icon-<?php echo esc_attr($item_id); ?>" class="widefat code edit-menu-item-custom" name="menu-item-icon[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->icon ); ?>" />
	                </label>
	            </p>
				
				<p class="field-custom description description-wide" style="margin:0 0 5px 0;">
	                <label for="edit-menu-item-background-<?php echo esc_attr($item_id); ?>">
	                    <?php esc_html_e( 'Background Image URL', 'gymx' ); ?><br />
	                    <input type="text" id="edit-menu-item-background-<?php echo esc_attr($item_id); ?>" class="widefat code edit-menu-item-custom" name="menu-item-background[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->background ); ?>" />
	                </label>
	            </p>
				
				<p class="field-custom description description-thin description-thin" style="margin:0 0 5px 0;">
					<label for="edit-menu-item-bg-position-<?php echo esc_attr($item_id); ?>">
						<?php esc_html_e( 'Background Position', 'gymx' ); ?><br />
						<select id="edit-menu-item-bg-position<?php echo esc_attr($item_id); ?>" name="menu-item-bg_position[<?php echo esc_attr($item_id); ?>]">
							<option value="" <?php if(esc_attr($item->bg_position) == ""){echo 'selected="selected"';} ?>></option>
							<option value="center top" <?php if(esc_attr($item->bg_position) == "center top"){echo 'selected="selected"';} ?>><?php esc_html_e('Center Top', 'gymx') ?></option>
							<option value="center center" <?php if(esc_attr($item->bg_position) == "center center"){echo 'selected="selected"';} ?>><?php esc_html_e('Center Center', 'gymx') ?></option>
							<option value="center bottom" <?php if(esc_attr($item->bg_position) == "center bottom"){echo 'selected="selected"';} ?>><?php esc_html_e('Center Bottom', 'gymx') ?></option>
							<option value="left top" <?php if(esc_attr($item->bg_position) == "left top"){echo 'selected="selected"';} ?>><?php esc_html_e('Left Top', 'gymx') ?></option>
							<option value="left center" <?php if(esc_attr($item->bg_position) == "left center"){echo 'selected="selected"';} ?>><?php esc_html_e('Left Center', 'gymx') ?></option>
							<option value="left bottom" <?php if(esc_attr($item->bg_position) == "left bottom"){echo 'selected="selected"';} ?>><?php esc_html_e('Left Bottom', 'gymx') ?></option>
							<option value="right top" <?php if(esc_attr($item->bg_position) == "right top"){echo 'selected="selected"';} ?>><?php esc_html_e('Right Top', 'gymx') ?></option>
							<option value="right center" <?php if(esc_attr($item->bg_position) == "right center"){echo 'selected="selected"';} ?>><?php esc_html_e('Right Center', 'gymx') ?></option>
							<option value="right bottom" <?php if(esc_attr($item->bg_position) == "right bottom"){echo 'selected="selected"';} ?>><?php esc_html_e('Right Bottom', 'gymx') ?></option>
						</select>
					</label>
				</p>
				
				<p class="field-custom description description-thin description-thin" style="margin:0 0 5px 0;">
					<label for="edit-menu-item-bg-position-<?php echo esc_attr($item_id); ?>">
						<?php esc_html_e( 'Menu Opening (Right or Left)', 'gymx' ); ?><br />
						<select id="edit-menu-item-menu-position<?php echo esc_attr($item_id); ?>" name="menu-item-menu_position[<?php echo esc_attr($item_id); ?>]">
							<option value="" <?php if(esc_attr($item->menu_position) == ""){echo 'selected="selected"';} ?>></option>
							<option value="left" <?php if(esc_attr($item->menu_position) == "left"){echo 'selected="selected"';} ?>><?php esc_html_e('Left', 'gymx') ?></option>
							<option value="right" <?php if(esc_attr($item->menu_position) == "right"){echo 'selected="selected"';} ?>><?php esc_html_e('Right', 'gymx') ?></option>
						</select>
					</label>
				</p>
				
				<p class="field-custom description description-wide" style="margin:20px 0 9px 0; padding-top:15px; border-top:1px solid #eee;">
					<?php
						$value = $item->megamenu;
						if($value != "") $value = "checked='checked'";
					?>
					<label for="edit-menu-item-megamenu-<?php echo esc_attr($item_id); ?>">
						<input type="checkbox" id="edit-menu-item-megamenu-<?php echo esc_attr($item_id); ?>" class="code edit-menu-item-custom" name="menu-item-megamenu[<?php echo esc_attr($item_id); ?>]" value="megamenu" <?php echo esc_attr($value); ?> />
						<?php esc_html_e( "Mega Menu?", 'gymx' ); ?>
					</label>
				</p>
				
				<p class="field-custom description description-wide">
					<?php
						$value = $item->menutitle;
						if($value != "") $value = "checked='checked'";
					?>
					<label for="edit-menu-item-menutitle-<?php echo esc_attr($item_id); ?>">
						<input type="checkbox" id="edit-menu-item-menutitle-<?php echo esc_attr($item_id); ?>" class="code edit-menu-item-custom" name="menu-item-menutitle[<?php echo esc_attr($item_id); ?>]" value="title" <?php echo esc_attr($value); ?> />
						<?php esc_html_e( "Menu Title ?", 'gymx' ); ?>
					</label>
				</p>
				
				<p class="field-custom description description-thin description-thin">
					<label for="edit-menu-item-cols-nums-<?php echo esc_attr($item_id); ?>">
						<?php esc_html_e( 'Number of Columns', 'gymx' ); ?><br />
						<select id="edit-menu-item-cols-nums<?php echo esc_attr($item_id); ?>" name="menu-item-cols_nums[<?php echo esc_attr($item_id); ?>]">
							<option value="" <?php if(esc_attr($item->cols_nums) == ""){echo 'selected="selected"';} ?>></option>
							<option value="two-columns" <?php if(esc_attr($item->cols_nums) == "two-columns"){echo 'selected="selected"';} ?>><?php esc_html_e('2 columns', 'gymx') ?></option>
							<option value="three-columns" <?php if(esc_attr($item->cols_nums) == "three-columns"){echo 'selected="selected"';} ?>><?php esc_html_e('3 columns', 'gymx') ?></option>
							<option value="three-columns-wide" <?php if(esc_attr($item->cols_nums) == "three-columns-wide"){echo 'selected="selected"';} ?>><?php esc_html_e('3 columns - Wide', 'gymx') ?></option>
							<option value="four-columns-wide" <?php if(esc_attr($item->cols_nums) == "four-columns-wide"){echo 'selected="selected"';} ?>><?php esc_html_e('4 columns - Wide', 'gymx') ?></option>
							<option value="five-columns-wide" <?php if(esc_attr($item->cols_nums) == "five-columns-wide"){echo 'selected="selected"';} ?>><?php esc_html_e('5 columns - Wide', 'gymx') ?></option>
						</select>
					</label>
				</p>
				
	            <div class="menu-item-actions description-wide submitbox">
	                <?php if( 'custom' != $item->type && $original_title !== false ) : ?>
	                    <p class="link-to-original">
	                        <?php printf( wp_kses(__('Original: %s', 'gymx'), array(  'a' => array( 'href' => array() ) ) ), '<a href="' . esc_attr( $item->url ) . '">' . esc_html( $original_title ) . '</a>' ); ?>
	                    </p>
	                <?php endif; ?>
	                <a class="item-delete submitdelete deletion" id="delete-<?php echo esc_attr($item_id); ?>" href="<?php
	                echo wp_nonce_url(
	                    add_query_arg(
	                        array(
	                            'action' => 'delete-menu-item',
	                            'menu-item' => $item_id,
	                        ),
	                        remove_query_arg($removed_args, admin_url( 'nav-menus.php' ) )
	                    ),
	                    'delete-menu_item_' . $item_id
	                ); ?>"><?php esc_html_e('Remove', 'gymx'); ?></a> <span class="meta-sep"> | </span> <a class="item-cancel submitcancel" id="cancel-<?php echo esc_attr($item_id); ?>" href="<?php echo esc_url( add_query_arg( array('edit-menu-item' => $item_id, 'cancel' => time()), remove_query_arg( $removed_args, admin_url( 'nav-menus.php' ) ) ) );
	                    ?>#menu-item-settings-<?php echo esc_attr($item_id); ?>"><?php esc_html_e('Cancel', 'gymx'); ?></a>
	            </div>
				<div style="clear:both;"></div>
	            <input class="menu-item-data-db-id" type="hidden" name="menu-item-db-id[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr($item_id); ?>" />
	            <input class="menu-item-data-object-id" type="hidden" name="menu-item-object-id[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->object_id ); ?>" />
	            <input class="menu-item-data-object" type="hidden" name="menu-item-object[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->object ); ?>" />
	            <input class="menu-item-data-parent-id" type="hidden" name="menu-item-parent-id[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->menu_item_parent ); ?>" />
	            <input class="menu-item-data-position" type="hidden" name="menu-item-position[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->menu_order ); ?>" />
	            <input class="menu-item-data-type" type="hidden" name="menu-item-type[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->type ); ?>" />
	        </div><!-- .menu-item-settings-->
	        <ul class="menu-item-transport"></ul>
	    <?php
	    
	    $output .= ob_get_clean();

	    }
}
