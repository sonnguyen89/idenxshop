<?php
/**
 * Customizer controls
 */

/**
 * Alpha Color Picker Customizer Control
 *
 * This control adds a second slider for opacity to the stock WordPress color picker,
 * and it includes logic to seamlessly convert between RGBa and Hex color values as
 * opacity is added to or removed from a color.
 */
class GymX_Customize_Alpha_Color_Control extends WP_Customize_Control {
	/**
	 * Official control name.
	 */
	public $type = 'alpha-color';
	/**
	 * Add support for palettes to be passed in.
	 *
	 * Supported palette values are true, false, or an array of RGBa and Hex colors.
	 */
	public $palette;
	/**
	 * Add support for showing the opacity value on the slider handle.
	 */
	public $show_opacity;
	/**
	 * Enqueue scripts and styles.
	 *
	 * Ideally these would get registered and given proper paths before this control object
	 * gets initialized, then we could simply enqueue them here, but for completeness as a
	 * stand alone class we'll register and enqueue them here.
	 */
	public function enqueue() {
		wp_enqueue_script(
				'alpha-color-picker',
				get_template_directory_uri() . '/framework/customizer/assets/alpha-color-picker.js',
				array( 'jquery', 'wp-color-picker' ),
				'1.0.0',
				true
		);
		wp_enqueue_style(
				'alpha-color-picker',
				get_template_directory_uri() . '/framework/customizer/assets/alpha-color-picker.css',
				array( 'wp-color-picker' ),
				'1.0.0'
		);
	}
	/**
	 * Render the control.
	 */
	public function render_content() {
		// Process the palette
		if ( is_array( $this->palette ) ) {
			$palette = implode( '|', $this->palette );
		} else {
			// Default to true.
			$palette = ( false === $this->palette || 'false' === $this->palette ) ? 'false' : 'true';
		}
		// Support passing show_opacity as string or boolean. Default to true.
		$show_opacity = ( false === $this->show_opacity || 'false' === $this->show_opacity ) ? 'false' : 'true';
		// Begin the output. ?>
		<?php // Output the label and description if they were passed in.
		if ( isset( $this->label ) && '' !== $this->label ) {
			echo '<span class="customize-control-title">' . sanitize_text_field( $this->label ) . '</span>';
		}
		if ( isset( $this->description ) && '' !== $this->description ) {
			echo '<span class="description customize-control-description">' . sanitize_text_field( $this->description ) . '</span>';
		} ?>
		<input class="alpha-color-control" type="text" data-show-opacity="<?php echo esc_attr($show_opacity); ?>" data-palette="<?php echo esc_attr( $palette ); ?>" data-default-color="<?php echo esc_attr( $this->settings['default']->default ); ?>" <?php $this->link(); ?>  />
		<?php
	}
}

/**
 * Adds textarea support to the theme customizer
 */
class GymX_Customize_Textarea_Control extends WP_Customize_Control {
	public $type = 'textarea';

	public function render_content() {
		?>
		<label>
			<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<textarea rows="5" style="width:100%;" <?php $this->link(); ?>><?php echo esc_textarea( $this->value() ); ?></textarea>
		</label>
		<?php
	}
}

/**
 * Google Fonts Control
 *
 */
class GymX_Fonts_Dropdown_Custom_Control extends WP_Customize_Control {
	public function render_content() {
		$this_val = $this->value(); ?>
	<label>
		<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<select <?php $this->link(); ?>>
			<option value="" <?php if( ! $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Default', 'gymx' ); ?></option>

			<option value="Arial, Helvetica, sans-serif" <?php if( "Arial, Helvetica, sans-serif" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Arial, Helvetica, sans-serif', 'gymx' ); ?></option>
			<option value="Arial Black, Gadget, sans-serif" <?php if( "Arial Black, Gadget, sans-serif" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Arial Black, Gadget, sans-seri', 'gymx' ); ?>f</option>
			<option value="Bookman Old Style, serif" <?php if( "Bookman Old Style, serif" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Bookman Old Style, serif', 'gymx' ); ?></option>
			<option value="Comic Sans MS, cursive" <?php if( "Comic Sans MS, cursive" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Comic Sans MS, cursive', 'gymx' ); ?></option>
			<option value="Courier, monospace" <?php if( "Courier, monospace" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Courier, monospace', 'gymx' ); ?></option>
			<option value="Garamond, serif" <?php if( "Garamond, serif" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Garamond, serif', 'gymx' ); ?></option>
			<option value="Georgia, serif" <?php if( "Georgia, serif" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Georgia, serif', 'gymx' ); ?></option>
			<option value="Impact, Charcoal, sans-serif" <?php if( "Impact, Charcoal, sans-serif" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Impact, Charcoal, sans-serif', 'gymx' ); ?></option>
			<option value="Lucida Console, Monaco, monospace" <?php if( "Lucida Console, Monaco, monospace" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Lucida Console, Monaco, monospace', 'gymx' ); ?></option>
			<option value="Lucida Sans Unicode, Lucida Grande, sans-serif" <?php if( "Lucida Sans Unicode, Lucida Grande, sans-serif" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Lucida Sans Unicode, Lucida Grande, sans-serif', 'gymx' ); ?></option>
			<option value="MS Sans Serif, Geneva, sans-serif" <?php if( "MS Sans Serif, Geneva, sans-serif" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'MS Sans Serif, Geneva, sans-serif', 'gymx' ); ?></option>
			<option value="MS Serif, New York, sans-serif" <?php if( "MS Serif, New York, sans-serif" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'MS Serif, New York, sans-serif', 'gymx' ); ?></option>
			<option value="Palatino Linotype, 'Book Antiqua, Palatino, serif" <?php if( "Palatino Linotype, 'Book Antiqua, Palatino, serif" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Palatino Linotype, Book Antiqua, Palatino, serif', 'gymx' ); ?></option>
			<option value="Tahoma, Geneva, sans-serif" <?php if( "Tahoma, Geneva, sans-serif" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Tahoma, Geneva, sans-serif', 'gymx' ); ?></option>
			<option value="Times New Roman, Times, serif" <?php if( "Times New Roman, Times, serif" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Times New Roman, Times, serif', 'gymx' ); ?></option>
			<option value="Trebuchet MS, Helvetica, sans-serif" <?php if( "Trebuchet MS, Helvetica, sans-serif" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Trebuchet MS, Helvetica, sans-serif', 'gymx' ); ?></option>
			<option value="Verdana, Geneva, sans-serif" <?php if( "Verdana, Geneva, sans-serif" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Verdana, Geneva, sans-serif', 'gymx' ); ?></option>
			<option value="ABeeZee" <?php if( "ABeeZee" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'ABeeZee', 'gymx' ); ?></option>
			<option value="Abel" <?php if( "Abel" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Courier, monospace', 'gymx' ); ?>Abel</option>
			<option value="Abril Fatface" <?php if( "Abril Fatface" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Abril Fatface', 'gymx' ); ?></option>
			<option value="Aclonica" <?php if( "Aclonica" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Aclonica', 'gymx' ); ?></option>
			<option value="Acme" <?php if( "Acme" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Acmee', 'gymx' ); ?></option>
			<option value="Actor" <?php if( "Actor" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Actor', 'gymx' ); ?>Actor</option>
			<option value="Adamina" <?php if( "Adamina" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Adamina', 'gymx' ); ?></option>
			<option value="Advent Pro" <?php if( "Advent Pro" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Advent Pro', 'gymx' ); ?></option>
			<option value="Aguafina Script" <?php if( "Aguafina Script" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Aguafina Script', 'gymx' ); ?></option>
			<option value="Akronim" <?php if( "Akronim" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Akronim', 'gymx' ); ?></option>
			<option value="Aladin" <?php if( "Aladin" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Aladin', 'gymx' ); ?></option>
			<option value="Aldrich" <?php if( "Aldrich" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Aldrich', 'gymx' ); ?></option>
			<option value="Alef" <?php if( "Alef" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Alef', 'gymx' ); ?></option>
			<option value="Alegreya" <?php if( "Alegreya" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Alegreya', 'gymx' ); ?></option>
			<option value="Alegreya SC" <?php if( "Alegreya SC" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Alegreya SC', 'gymx' ); ?></option>
			<option value="Alegreya Sans" <?php if( "Alegreya Sans" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Alegreya Sans', 'gymx' ); ?></option>
			<option value="Alegreya Sans SC" <?php if( "Alegreya Sans SC" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Alegreya Sans SC', 'gymx' ); ?></option>
			<option value="Alex Brush" <?php if( "Alex Brush" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Alex Brush', 'gymx' ); ?></option>
			<option value="Alfa Slab One" <?php if( "Alfa Slab One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Alfa Slab One', 'gymx' ); ?></option>
			<option value="Alice" <?php if( "Alice" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Alice', 'gymx' ); ?></option>
			<option value="Alike" <?php if( "Alike" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Alike', 'gymx' ); ?></option>
			<option value="Alike Angular" <?php if( "Alike Angular" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Alike Angular', 'gymx' ); ?></option>
			<option value="Allan" <?php if( "Allan" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Allan', 'gymx' ); ?></option>
			<option value="Allerta" <?php if( "Allerta" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Allerta', 'gymx' ); ?></option>
			<option value="Allerta Stencil" <?php if( "Allerta Stencil" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Allerta Stencil', 'gymx' ); ?></option>
			<option value="Allura" <?php if( "Allura" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Allura', 'gymx' ); ?></option>
			<option value="Almendra" <?php if( "Almendra" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Almendra', 'gymx' ); ?></option>
			<option value="Almendra Display" <?php if( "Almendra Display" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Almendra Display', 'gymx' ); ?></option>
			<option value="Almendra SC" <?php if( "Almendra SC" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Almendra SC', 'gymx' ); ?></option>
			<option value="Amarante" <?php if( "Amarante" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Amarante', 'gymx' ); ?></option>
			<option value="Amaranth" <?php if( "Amaranth" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Amaranth', 'gymx' ); ?></option>
			<option value="Amatic SC" <?php if( "Amatic SC" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Amatic SC', 'gymx' ); ?></option>
			<option value="Amethysta" <?php if( "Amethysta" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Amethysta', 'gymx' ); ?></option>
			<option value="Anaheim" <?php if( "Anaheim" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Anaheim', 'gymx' ); ?></option>
			<option value="Andada" <?php if( "Andada" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Andada', 'gymx' ); ?></option>
			<option value="Andika" <?php if( "Andika" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Andika', 'gymx' ); ?></option>
			<option value="Angkor" <?php if( "Angkor" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Angkor', 'gymx' ); ?></option>
			<option value="Annie Use Your Telescope" <?php if( "Annie Use Your Telescope" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Annie Use Your Telescope', 'gymx' ); ?></option>
			<option value="Anonymous Pro" <?php if( "Anonymous Pro" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Anonymous Pro', 'gymx' ); ?></option>
			<option value="Antic" <?php if( "Antic" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Antic', 'gymx' ); ?></option>
			<option value="Antic Didone" <?php if( "Antic Didone" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Antic Didone', 'gymx' ); ?></option>
			<option value="Antic Slab" <?php if( "Antic Slab" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Antic Slab', 'gymx' ); ?></option>
			<option value="Anton" <?php if( "Anton" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Anton', 'gymx' ); ?></option>
			<option value="Arapey" <?php if( "Arapey" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Arapey', 'gymx' ); ?></option>
			<option value="Arbutus" <?php if( "Arbutus" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Arbutus', 'gymx' ); ?></option>
			<option value="Arbutus Slab" <?php if( "Arbutus Slab" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Arbutus Slab', 'gymx' ); ?></option>
			<option value="Architects Daughter" <?php if( "Architects Daughter" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Architects Daughter', 'gymx' ); ?></option>
			<option value="Archivo Black" <?php if( "Archivo Black" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Archivo Black', 'gymx' ); ?></option>
			<option value="Archivo Narrow" <?php if( "Archivo Narrow" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Archivo Narrow', 'gymx' ); ?></option>
			<option value="Arimo" <?php if( "Arimo" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Arimo', 'gymx' ); ?></option>
			<option value="Arizonia" <?php if( "Arizonia" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Arizonia', 'gymx' ); ?></option>
			<option value="Armata" <?php if( "Armata" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Armata', 'gymx' ); ?></option>
			<option value="Artifika" <?php if( "Artifika" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Artifika', 'gymx' ); ?></option>
			<option value="Arvo" <?php if( "Arvo" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Arvo', 'gymx' ); ?></option>
			<option value="Asap" <?php if( "Asap" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Asap', 'gymx' ); ?></option>
			<option value="Asset" <?php if( "Asset" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Asset', 'gymx' ); ?></option>
			<option value="Astloch" <?php if( "Astloch" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Astloch', 'gymx' ); ?></option>
			<option value="Asul" <?php if( "Asul" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Asul', 'gymx' ); ?></option>
			<option value="Atomic Age" <?php if( "Atomic Age" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Atomic Age', 'gymx' ); ?></option>
			<option value="Aubrey" <?php if( "Aubrey" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Aubrey', 'gymx' ); ?></option>
			<option value="Audiowide" <?php if( "Audiowide" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Audiowide', 'gymx' ); ?></option>
			<option value="Autour One" <?php if( "Autour One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Autour One', 'gymx' ); ?></option>
			<option value="Average" <?php if( "Average" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Average', 'gymx' ); ?></option>
			<option value="Average Sans" <?php if( "Average Sans" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Average Sans', 'gymx' ); ?></option>
			<option value="Averia Gruesa Libre" <?php if( "Averia Gruesa Libre" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Averia Gruesa Libre', 'gymx' ); ?></option>
			<option value="Averia Libre" <?php if( "Averia Libre" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Averia Libre', 'gymx' ); ?></option>
			<option value="Averia Sans Libre" <?php if( "Averia Sans Libre" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Averia Sans Libre', 'gymx' ); ?></option>
			<option value="Averia Serif Libre" <?php if( "Averia Serif Libre" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Averia Serif Libre', 'gymx' ); ?></option>
			<option value="Bad Script" <?php if( "Bad Script" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Bad Script', 'gymx' ); ?></option>
			<option value="Balthazar" <?php if( "Balthazar" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Balthazar', 'gymx' ); ?></option>
			<option value="Bangers" <?php if( "Bangers" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Bangers', 'gymx' ); ?></option>
			<option value="Basic" <?php if( "Basic" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Basic', 'gymx' ); ?></option>
			<option value="Battambang" <?php if( "Battambang" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Battambang', 'gymx' ); ?></option>
			<option value="Baumans" <?php if( "Baumans" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Baumans', 'gymx' ); ?></option>
			<option value="Bayon" <?php if( "Bayon" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Bayon', 'gymx' ); ?></option>
			<option value="Belgrano" <?php if( "Belgrano" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Belgrano', 'gymx' ); ?></option>
			<option value="Belleza" <?php if( "Belleza" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Belleza', 'gymx' ); ?></option>
			<option value="BenchNine" <?php if( "BenchNine" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'BenchNine', 'gymx' ); ?></option>
			<option value="Bentham" <?php if( "Bentham" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Bentham', 'gymx' ); ?></option>
			<option value="Berkshire Swash" <?php if( "Berkshire Swash" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Berkshire Swash', 'gymx' ); ?></option>
			<option value="Bevan" <?php if( "Bevan" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Bevan', 'gymx' ); ?></option>
			<option value="Bigelow Rules" <?php if( "Bigelow Rules" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Bigelow Rules', 'gymx' ); ?></option>
			<option value="Bigshot One" <?php if( "Bigshot One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Bigshot One', 'gymx' ); ?></option>
			<option value="Bilbo" <?php if( "Bilbo" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Bilbo', 'gymx' ); ?></option>
			<option value="Bilbo Swash Caps" <?php if( "Bilbo Swash Caps" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Bilbo Swash Caps', 'gymx' ); ?></option>
			<option value="Bitter" <?php if( "Bitter" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Bitter', 'gymx' ); ?></option>
			<option value="Black Ops One" <?php if( "Black Ops One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Black Ops One', 'gymx' ); ?></option>
			<option value="Bokor" <?php if( "Bokor" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Bokor', 'gymx' ); ?></option>
			<option value="Bonbon" <?php if( "Bonbon" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Bonbon', 'gymx' ); ?></option>
			<option value="Boogaloo" <?php if( "Boogaloo" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Boogaloo', 'gymx' ); ?></option>
			<option value="Bowlby One" <?php if( "Bowlby One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Bowlby One', 'gymx' ); ?></option>
			<option value="Bowlby One SC" <?php if( "Bowlby One SC" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Bowlby One SC', 'gymx' ); ?></option>
			<option value="Brawler" <?php if( "Brawler" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Brawler', 'gymx' ); ?></option>
			<option value="Bree Serif" <?php if( "Bree Serif" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Bree Serif', 'gymx' ); ?></option>
			<option value="Bubblegum Sans" <?php if( "Bubblegum Sans" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Bubblegum Sans', 'gymx' ); ?></option>
			<option value="Bubbler One" <?php if( "Bubbler One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Bubbler One', 'gymx' ); ?></option>
			<option value="Buda" <?php if( "Buda" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Buda', 'gymx' ); ?></option>
			<option value="Buenard" <?php if( "Buenard" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Buenard', 'gymx' ); ?></option>
			<option value="Butcherman" <?php if( "Butcherman" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Butcherman', 'gymx' ); ?></option>
			<option value="Butterfly Kids" <?php if( "Butterfly Kids" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Butterfly Kids', 'gymx' ); ?></option>
			<option value="Cabin" <?php if( "Cabin" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Cabin', 'gymx' ); ?></option>
			<option value="Cabin Condensed" <?php if( "Cabin Condensed" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Cabin Condensed', 'gymx' ); ?></option>
			<option value="Cabin Sketch" <?php if( "Cabin Sketch" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Cabin Sketch', 'gymx' ); ?></option>
			<option value="Caesar Dressing" <?php if( "Caesar Dressing" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Caesar Dressing', 'gymx' ); ?></option>
			<option value="Cagliostro" <?php if( "Cagliostro" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Cagliostro', 'gymx' ); ?></option>
			<option value="Calligraffitti" <?php if( "Calligraffitti" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Calligraffitti', 'gymx' ); ?></option>
			<option value="Cambo" <?php if( "Cambo" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Cambo', 'gymx' ); ?></option>
			<option value="Candal" <?php if( "Candal" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Candal', 'gymx' ); ?></option>
			<option value="Cantarell" <?php if( "Cantarell" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Cantarell', 'gymx' ); ?></option>
			<option value="Cantata One" <?php if( "Cantata One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Cantata One', 'gymx' ); ?></option>
			<option value="Cantora One" <?php if( "Cantora One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Cantora One', 'gymx' ); ?></option>
			<option value="Capriola" <?php if( "Capriola" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Capriola', 'gymx' ); ?></option>
			<option value="Cardo" <?php if( "Cardo" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Cardo', 'gymx' ); ?></option>
			<option value="Carme" <?php if( "Carme" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Carme', 'gymx' ); ?></option>
			<option value="Carrois Gothic" <?php if( "Carrois Gothic" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Carrois Gothic', 'gymx' ); ?></option>
			<option value="Carrois Gothic SC" <?php if( "Carrois Gothic SC" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Carrois Gothic SC', 'gymx' ); ?></option>
			<option value="Carter One" <?php if( "Carter One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Carter One', 'gymx' ); ?></option>
			<option value="Caudex" <?php if( "Caudex" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Caudex', 'gymx' ); ?></option>
			<option value="Cedarville Cursive" <?php if( "Cedarville Cursive" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Cedarville Cursive', 'gymx' ); ?></option>
			<option value="Ceviche One" <?php if( "Ceviche One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Ceviche One', 'gymx' ); ?></option>
			<option value="Changa One" <?php if( "Changa One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Changa One', 'gymx' ); ?></option>
			<option value="Chango" <?php if( "Chango" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Chango', 'gymx' ); ?></option>
			<option value="Chau Philomene One" <?php if( "Chau Philomene One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Chau Philomene One', 'gymx' ); ?></option>
			<option value="Chela One" <?php if( "Chela One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Chela One', 'gymx' ); ?></option>
			<option value="Chelsea Market" <?php if( "Chelsea Market" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Chelsea Market', 'gymx' ); ?></option>
			<option value="Chenla" <?php if( "Chenla" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Chenla', 'gymx' ); ?></option>
			<option value="Cherry Cream Soda" <?php if( "Cherry Cream Soda" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Cherry Cream Soda', 'gymx' ); ?></option>
			<option value="Cherry Swash" <?php if( "Cherry Swash" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Cherry Swash', 'gymx' ); ?></option>
			<option value="Chewy" <?php if( "Chewy" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Chewy', 'gymx' ); ?></option>
			<option value="Chicle" <?php if( "Chicle" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Chicle', 'gymx' ); ?></option>
			<option value="Chivo" <?php if( "Chivo" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Chivo', 'gymx' ); ?></option>
			<option value="Cinzel" <?php if( "Cinzel" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Cinzel', 'gymx' ); ?></option>
			<option value="Cinzel Decorative" <?php if( "Cinzel Decorative" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Cinzel Decorative', 'gymx' ); ?></option>
			<option value="Clicker Script" <?php if( "Clicker Script" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Clicker Script', 'gymx' ); ?></option>
			<option value="Coda" <?php if( "Coda" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Coda', 'gymx' ); ?></option>
			<option value="Coda Caption" <?php if( "Coda Caption" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Coda Caption', 'gymx' ); ?></option>
			<option value="Codystar" <?php if( "Codystar" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Codystar', 'gymx' ); ?></option>
			<option value="Combo" <?php if( "Combo" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Combo', 'gymx' ); ?></option>
			<option value="Comfortaa" <?php if( "Comfortaa" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Comfortaa', 'gymx' ); ?></option>
			<option value="Coming Soon" <?php if( "Coming Soon" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Coming Soon', 'gymx' ); ?></option>
			<option value="Concert One" <?php if( "Concert One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Concert One', 'gymx' ); ?></option>
			<option value="Condiment" <?php if( "Condiment" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Condiment', 'gymx' ); ?></option>
			<option value="Content" <?php if( "Content" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Content', 'gymx' ); ?></option>
			<option value="Contrail One" <?php if( "Contrail One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Contrail One', 'gymx' ); ?></option>
			<option value="Convergence" <?php if( "Convergence" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Convergence', 'gymx' ); ?></option>
			<option value="Cookie" <?php if( "Cookie" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Cookie', 'gymx' ); ?></option>
			<option value="Copse" <?php if( "Copse" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Copse', 'gymx' ); ?></option>
			<option value="Corben" <?php if( "Corben" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Corben', 'gymx' ); ?></option>
			<option value="Courgette" <?php if( "Courgette" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Courgette', 'gymx' ); ?></option>
			<option value="Cousine" <?php if( "Cousine" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Cousine', 'gymx' ); ?></option>
			<option value="Coustard" <?php if( "Coustard" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Coustard', 'gymx' ); ?></option>
			<option value="Covered By Your Grace" <?php if( "Covered By Your Grace" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Covered By Your Grace', 'gymx' ); ?></option>
			<option value="Crafty Girls" <?php if( "Crafty Girls" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Crafty Girls', 'gymx' ); ?></option>
			<option value="Creepster" <?php if( "Creepster" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Creepster', 'gymx' ); ?></option>
			<option value="Crete Round" <?php if( "Crete Round" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Crete Round', 'gymx' ); ?></option>
			<option value="Crimson Text" <?php if( "Crimson Text" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Crimson Text', 'gymx' ); ?></option>
			<option value="Croissant One" <?php if( "Croissant One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Croissant One', 'gymx' ); ?></option>
			<option value="Crushed" <?php if( "Crushed" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Crushed', 'gymx' ); ?></option>
			<option value="Cuprum" <?php if( "Cuprum" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Cuprum', 'gymx' ); ?></option>
			<option value="Cutive" <?php if( "Cutive" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Cutive', 'gymx' ); ?></option>
			<option value="Cutive Mono" <?php if( "Cutive Mono" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Cutive Mono', 'gymx' ); ?></option>
			<option value="Damion" <?php if( "Damion" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Damion', 'gymx' ); ?></option>
			<option value="Dancing Script" <?php if( "Dancing Script" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Dancing Script', 'gymx' ); ?></option>
			<option value="Dangrek" <?php if( "Dangrek" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Dangrek', 'gymx' ); ?></option>
			<option value="Dawning of a New Day" <?php if( "Dawning of a New Day" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Dawning of a New Day', 'gymx' ); ?></option>
			<option value="Days One" <?php if( "Days One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Days One', 'gymx' ); ?></option>
			<option value="Delius" <?php if( "Delius" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Delius', 'gymx' ); ?></option>
			<option value="Delius Swash Caps" <?php if( "Delius Swash Caps" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Delius Swash Caps', 'gymx' ); ?></option>
			<option value="Delius Unicase" <?php if( "Delius Unicase" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Delius Unicase', 'gymx' ); ?></option>
			<option value="Della Respira" <?php if( "Della Respira" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Della Respira', 'gymx' ); ?></option>
			<option value="Denk One" <?php if( "Denk One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Denk One', 'gymx' ); ?></option>
			<option value="Devonshire" <?php if( "Devonshire" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Devonshire', 'gymx' ); ?></option>
			<option value="Didact Gothic" <?php if( "Didact Gothic" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Didact Gothic', 'gymx' ); ?></option>
			<option value="Diplomata" <?php if( "Diplomata" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Diplomata', 'gymx' ); ?></option>
			<option value="Diplomata SC" <?php if( "Diplomata SC" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Diplomata SC', 'gymx' ); ?></option>
			<option value="Domine" <?php if( "Domine" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Domine', 'gymx' ); ?></option>
			<option value="Donegal One" <?php if( "Donegal One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Donegal One', 'gymx' ); ?></option>
			<option value="Doppio One" <?php if( "Doppio One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Doppio One', 'gymx' ); ?></option>
			<option value="Dorsa" <?php if( "Dorsa" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Dorsa', 'gymx' ); ?></option>
			<option value="Dosis" <?php if( "Dosis" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Dosis', 'gymx' ); ?></option>
			<option value="Dr Sugiyama" <?php if( "Dr Sugiyama" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Dr Sugiyama', 'gymx' ); ?></option>
			<option value="Droid Sans" <?php if( "Droid Sans" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Droid Sans', 'gymx' ); ?></option>
			<option value="Droid Sans Mono" <?php if( "Droid Sans Mono" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Droid Sans Mono', 'gymx' ); ?></option>
			<option value="Droid Serif" <?php if( "Droid Serif" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Droid Serif', 'gymx' ); ?></option>
			<option value="Duru Sans" <?php if( "Duru Sans" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Duru Sans', 'gymx' ); ?></option>
			<option value="Dynalight" <?php if( "Dynalight" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Dynalight', 'gymx' ); ?></option>
			<option value="EB Garamond" <?php if( "EB Garamond" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'EB Garamond', 'gymx' ); ?></option>
			<option value="Eagle Lake" <?php if( "Eagle Lake" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Eagle Lake', 'gymx' ); ?></option>
			<option value="Eater" <?php if( "Eater" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Eater', 'gymx' ); ?></option>
			<option value="Economica" <?php if( "Economica" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Economica', 'gymx' ); ?></option>
			<option value="Ek Mukta" <?php if( "Ek Mukta" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Ek Mukta', 'gymx' ); ?></option>
			<option value="Electrolize" <?php if( "Electrolize" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Electrolize', 'gymx' ); ?></option>
			<option value="Elsie" <?php if( "Elsie" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Elsie', 'gymx' ); ?></option>
			<option value="Elsie Swash Caps" <?php if( "Elsie Swash Caps" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Elsie Swash Caps', 'gymx' ); ?></option>
			<option value="Emblema One" <?php if( "Emblema One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Emblema One', 'gymx' ); ?></option>
			<option value="Emilys Candy" <?php if( "Emilys Candy" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Emilys Candy', 'gymx' ); ?></option>
			<option value="Engagement" <?php if( "Engagement" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Engagement', 'gymx' ); ?></option>
			<option value="Englebert" <?php if( "Englebert" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Englebert', 'gymx' ); ?></option>
			<option value="Enriqueta" <?php if( "Enriqueta" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Enriqueta', 'gymx' ); ?></option>
			<option value="Erica One" <?php if( "Erica One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Erica One', 'gymx' ); ?></option>
			<option value="Esteban" <?php if( "Esteban" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Esteban', 'gymx' ); ?></option>
			<option value="Euphoria Script" <?php if( "Euphoria Script" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Euphoria Script', 'gymx' ); ?></option>
			<option value="Ewert" <?php if( "Ewert" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Ewert', 'gymx' ); ?></option>
			<option value="Exo" <?php if( "Exo" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Exo', 'gymx' ); ?></option>
			<option value="Exo 2" <?php if( "Exo 2" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Exo 2', 'gymx' ); ?></option>
			<option value="Expletus Sans" <?php if( "Expletus Sans" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Expletus Sans', 'gymx' ); ?></option>
			<option value="Fanwood Text" <?php if( "Fanwood Text" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Fanwood Text', 'gymx' ); ?></option>
			<option value="Fascinate" <?php if( "Fascinate" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Fascinate', 'gymx' ); ?></option>
			<option value="Fascinate Inline" <?php if( "Fascinate Inline" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Fascinate Inline', 'gymx' ); ?></option>
			<option value="Faster One" <?php if( "Faster One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Faster One', 'gymx' ); ?></option>
			<option value="Fasthand" <?php if( "Fasthand" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Fasthand', 'gymx' ); ?></option>
			<option value="Fauna One" <?php if( "Fauna One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Fauna One', 'gymx' ); ?></option>
			<option value="Federant" <?php if( "Federant" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Federant', 'gymx' ); ?></option>
			<option value="Federo" <?php if( "Federo" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Federo', 'gymx' ); ?></option>
			<option value="Felipa" <?php if( "Felipa" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Felipa', 'gymx' ); ?></option>
			<option value="Fenix" <?php if( "Fenix" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Fenix', 'gymx' ); ?></option>
			<option value="Finger Paint" <?php if( "Finger Paint" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Finger Paint', 'gymx' ); ?></option>
			<option value="Fira Mono" <?php if( "Fira Mono" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Fira Mono', 'gymx' ); ?></option>
			<option value="Fira Sans" <?php if( "Fira Sans" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Fira Sans', 'gymx' ); ?></option>
			<option value="Fjalla One" <?php if( "Fjalla One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Fjalla One', 'gymx' ); ?></option>
			<option value="Fjord One" <?php if( "Fjord One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Fjord One', 'gymx' ); ?></option>
			<option value="Flamenco" <?php if( "Flamenco" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Flamenco', 'gymx' ); ?></option>
			<option value="Flavors" <?php if( "Flavors" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Flavors', 'gymx' ); ?></option>
			<option value="Fondamento" <?php if( "Fondamento" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Fondamento', 'gymx' ); ?></option>
			<option value="Fontdiner Swanky" <?php if( "Fontdiner Swanky" == $this_val ) echo 'selected="selected"'; ?>>Fontdiner Swanky</option>
			<option value="Forum" <?php if( "Forum" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Forum', 'gymx' ); ?></option>
			<option value="Francois One" <?php if( "Francois One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Francois One', 'gymx' ); ?></option>
			<option value="Freckle Face" <?php if( "Freckle Face" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Freckle Face', 'gymx' ); ?></option>
			<option value="Fredericka the Great" <?php if( "Fredericka the Great" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Fredericka the Great', 'gymx' ); ?></option>
			<option value="Fredoka One" <?php if( "Fredoka One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Fredoka One', 'gymx' ); ?></option>
			<option value="Freehand" <?php if( "Freehand" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Freehand', 'gymx' ); ?></option>
			<option value="Fresca" <?php if( "Fresca" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Fresca', 'gymx' ); ?></option>
			<option value="Frijole" <?php if( "Frijole" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Frijole', 'gymx' ); ?></option>
			<option value="Fruktur" <?php if( "Fruktur" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Fruktur', 'gymx' ); ?></option>
			<option value="Fugaz One" <?php if( "Fugaz One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Fugaz One', 'gymx' ); ?></option>
			<option value="GFS Didot" <?php if( "GFS Didot" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'GFS Didot', 'gymx' ); ?></option>
			<option value="GFS Neohellenic" <?php if( "GFS Neohellenic" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'GFS Neohellenic', 'gymx' ); ?></option>
			<option value="Gabriela" <?php if( "Gabriela" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Gabriela', 'gymx' ); ?></option>
			<option value="Gafata" <?php if( "Gafata" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Gafata', 'gymx' ); ?></option>
			<option value="Galdeano" <?php if( "Galdeano" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Galdeano', 'gymx' ); ?></option>
			<option value="Galindo" <?php if( "Galindo" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Galindo', 'gymx' ); ?></option>
			<option value="Gentium Basic" <?php if( "Gentium Basic" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Gentium Basic', 'gymx' ); ?></option>
			<option value="Gentium Book Basic" <?php if( "Gentium Book Basic" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Gentium Book Basic', 'gymx' ); ?></option>
			<option value="Geo" <?php if( "Geo" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Geo', 'gymx' ); ?></option>
			<option value="Geostar" <?php if( "Geostar" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Geostar', 'gymx' ); ?></option>
			<option value="Geostar Fill" <?php if( "Geostar Fill" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Geostar Fill', 'gymx' ); ?></option>
			<option value="Germania One" <?php if( "Germania One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Germania One', 'gymx' ); ?></option>
			<option value="Gilda Display" <?php if( "Gilda Display" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Gilda Display', 'gymx' ); ?></option>
			<option value="Give You Glory" <?php if( "Give You Glory" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Give You Glory', 'gymx' ); ?></option>
			<option value="Glass Antiqua" <?php if( "Glass Antiqua" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Glass Antiqua', 'gymx' ); ?></option>
			<option value="Glegoo" <?php if( "Glegoo" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Glegoo', 'gymx' ); ?></option>
			<option value="Gloria Hallelujah" <?php if( "Gloria Hallelujah" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Gloria Hallelujah', 'gymx' ); ?></option>
			<option value="Goblin One" <?php if( "Goblin One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Goblin One', 'gymx' ); ?></option>
			<option value="Gochi Hand" <?php if( "Gochi Hand" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Gochi Hand', 'gymx' ); ?></option>
			<option value="Gorditas" <?php if( "Gorditas" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Gorditas', 'gymx' ); ?></option>
			<option value="Goudy Bookletter 1911" <?php if( "Goudy Bookletter 1911" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Goudy Bookletter 1911', 'gymx' ); ?></option>
			<option value="Graduate" <?php if( "Graduate" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Graduate', 'gymx' ); ?></option>
			<option value="Grand Hotel" <?php if( "Grand Hotel" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Grand Hotel', 'gymx' ); ?></option>
			<option value="Gravitas One" <?php if( "Gravitas One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Gravitas One', 'gymx' ); ?></option>
			<option value="Great Vibes" <?php if( "Great Vibes" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Great Vibes', 'gymx' ); ?></option>
			<option value="Griffy" <?php if( "Griffy" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Griffy', 'gymx' ); ?></option>
			<option value="Gruppo" <?php if( "Gruppo" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Gruppo', 'gymx' ); ?></option>
			<option value="Gudea" <?php if( "Gudea" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Gudea', 'gymx' ); ?></option>
			<option value="Habibi" <?php if( "Habibi" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Habibi', 'gymx' ); ?></option>
			<option value="Halant" <?php if( "Halant" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Halant', 'gymx' ); ?></option>
			<option value="Hammersmith One" <?php if( "Hammersmith One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Hammersmith One', 'gymx' ); ?></option>
			<option value="Hanalei" <?php if( "Hanalei" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Hanalei', 'gymx' ); ?></option>
			<option value="Hanalei Fill" <?php if( "Hanalei Fill" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Hanalei Fill', 'gymx' ); ?></option>
			<option value="Handlee" <?php if( "Handlee" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Handlee', 'gymx' ); ?></option>
			<option value="Hanuman" <?php if( "Hanuman" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Hanuman', 'gymx' ); ?></option>
			<option value="Happy Monkey" <?php if( "Happy Monkey" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Happy Monkey', 'gymx' ); ?></option>
			<option value="Headland One" <?php if( "Headland One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Headland One', 'gymx' ); ?></option>
			<option value="Henny Penny" <?php if( "Henny Penny" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Henny Penny', 'gymx' ); ?></option>
			<option value="Herr Von Muellerhoff" <?php if( "Herr Von Muellerhoff" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Herr Von Muellerhoff', 'gymx' ); ?></option>
			<option value="Hind" <?php if( "Hind" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Hind', 'gymx' ); ?></option>
			<option value="Holtwood One SC" <?php if( "Holtwood One SC" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Holtwood One SC', 'gymx' ); ?></option>
			<option value="Homemade Apple" <?php if( "Homemade Apple" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Homemade Apple', 'gymx' ); ?></option>
			<option value="Homenaje" <?php if( "Homenaje" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Homenaje', 'gymx' ); ?></option>
			<option value="IM Fell DW Pica" <?php if( "IM Fell DW Pica" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'IM Fell DW Pica', 'gymx' ); ?></option>
			<option value="IM Fell DW Pica SC" <?php if( "IM Fell DW Pica SC" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'IM Fell DW Pica SC', 'gymx' ); ?></option>
			<option value="IM Fell Double Pica" <?php if( "IM Fell Double Pica" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'IM Fell Double Pica', 'gymx' ); ?></option>
			<option value="IM Fell Double Pica SC" <?php if( "IM Fell Double Pica SC" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'IM Fell Double Pica SC', 'gymx' ); ?></option>
			<option value="IM Fell English" <?php if( "IM Fell English" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'IM Fell English', 'gymx' ); ?></option>
			<option value="IM Fell English SC" <?php if( "IM Fell English SC" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'IM Fell English SC', 'gymx' ); ?></option>
			<option value="IM Fell French Canon" <?php if( "IM Fell French Canon" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'IM Fell French Canon', 'gymx' ); ?></option>
			<option value="IM Fell French Canon SC" <?php if( "IM Fell French Canon SC" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'IM Fell French Canon SC', 'gymx' ); ?></option>
			<option value="IM Fell Great Primer" <?php if( "IM Fell Great Primer" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'IM Fell Great Primer', 'gymx' ); ?></option>
			<option value="IM Fell Great Primer SC" <?php if( "IM Fell Great Primer SC" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'IM Fell Great Primer SC', 'gymx' ); ?></option>
			<option value="Iceberg" <?php if( "Iceberg" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Iceberg', 'gymx' ); ?></option>
			<option value="Iceland" <?php if( "Iceland" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Iceland', 'gymx' ); ?></option>
			<option value="Imprima" <?php if( "Imprima" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Imprima', 'gymx' ); ?></option>
			<option value="Inconsolata" <?php if( "Inconsolata" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Inconsolata', 'gymx' ); ?></option>
			<option value="Inder" <?php if( "Inder" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Inder', 'gymx' ); ?></option>
			<option value="Indie Flower" <?php if( "Indie Flower" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Indie Flower', 'gymx' ); ?></option>
			<option value="Inika" <?php if( "Inika" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Inika', 'gymx' ); ?></option>
			<option value="Irish Grover" <?php if( "Irish Grover" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Irish Grover', 'gymx' ); ?></option>
			<option value="Istok Web" <?php if( "Istok Web" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Istok Web', 'gymx' ); ?></option>
			<option value="Italiana" <?php if( "Italiana" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Italiana', 'gymx' ); ?></option>
			<option value="Italianno" <?php if( "Italianno" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Italianno', 'gymx' ); ?></option>
			<option value="Jacques Francois" <?php if( "Jacques Francois" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Jacques Francois', 'gymx' ); ?></option>
			<option value="Jacques Francois Shadow" <?php if( "Jacques Francois Shadow" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Jacques Francois Shadow', 'gymx' ); ?></option>
			<option value="Jim Nightshade" <?php if( "Jim Nightshade" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Jim Nightshade', 'gymx' ); ?></option>
			<option value="Jockey One" <?php if( "Jockey One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( '>Jockey One', 'gymx' ); ?></option>
			<option value="Jolly Lodger" <?php if( "Jolly Lodger" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( '>Jolly Lodger', 'gymx' ); ?></option>
			<option value="Josefin Sans" <?php if( "Josefin Sans" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( '>Josefin Sans', 'gymx' ); ?></option>
			<option value="Josefin Slab" <?php if( "Josefin Slab" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Josefin Slab', 'gymx' ); ?></option>
			<option value="Joti One" <?php if( "Joti One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Joti One', 'gymx' ); ?></option>
			<option value="Judson" <?php if( "Judson" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Judson', 'gymx' ); ?></option>
			<option value="Julee" <?php if( "Julee" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Julee', 'gymx' ); ?></option>
			<option value="Julius Sans One" <?php if( "Julius Sans One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Julius Sans One', 'gymx' ); ?></option>
			<option value="Junge" <?php if( "Junge" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Junge', 'gymx' ); ?></option>
			<option value="Jura" <?php if( "Jura" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Jura', 'gymx' ); ?></option>
			<option value="Just Another Hand" <?php if( "Just Another Hand" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Just Another Hand', 'gymx' ); ?></option>
			<option value="Just Me Again Down Here" <?php if( "Just Me Again Down Here" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Just Me Again Down Here', 'gymx' ); ?></option>
			<option value="Kalam" <?php if( "Kalam" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Kalam', 'gymx' ); ?></option>
			<option value="Kameron" <?php if( "Kameron" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Kameron', 'gymx' ); ?></option>
			<option value="Kantumruy" <?php if( "Kantumruy" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Kantumruy', 'gymx' ); ?></option>
			<option value="Karla" <?php if( "Karla" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Karla', 'gymx' ); ?></option>
			<option value="Karma" <?php if( "Karma" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Karma', 'gymx' ); ?></option>
			<option value="Kaushan Script" <?php if( "Kaushan Script" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Kaushan Script', 'gymx' ); ?></option>
			<option value="Kavoon" <?php if( "Kavoon" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Kavoon', 'gymx' ); ?></option>
			<option value="Kdam Thmor" <?php if( "Kdam Thmor" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Kdam Thmor', 'gymx' ); ?></option>
			<option value="Keania One" <?php if( "Keania One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Keania One', 'gymx' ); ?></option>
			<option value="Kelly Slab" <?php if( "Kelly Slab" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Kelly Slab', 'gymx' ); ?></option>
			<option value="Kenia" <?php if( "Kenia" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Kenia', 'gymx' ); ?></option>
			<option value="Khand" <?php if( "Khand" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Khand', 'gymx' ); ?></option>
			<option value="Khmer" <?php if( "Khmer" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Khmer', 'gymx' ); ?></option>
			<option value="Kite One" <?php if( "Kite One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Kite One', 'gymx' ); ?></option>
			<option value="Knewave" <?php if( "Knewave" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Knewave', 'gymx' ); ?></option>
			<option value="Kotta One" <?php if( "Kotta One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Kotta One', 'gymx' ); ?></option>
			<option value="Koulen" <?php if( "Koulen" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Koulen', 'gymx' ); ?></option>
			<option value="Kranky" <?php if( "Kranky" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Kranky', 'gymx' ); ?></option>
			<option value="Kreon" <?php if( "Kreon" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Kreon', 'gymx' ); ?></option>
			<option value="Kristi" <?php if( "Kristi" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Kristi', 'gymx' ); ?></option>
			<option value="Krona One" <?php if( "Krona One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Krona One', 'gymx' ); ?></option>
			<option value="La Belle Aurore" <?php if( "La Belle Aurore" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'La Belle Aurore', 'gymx' ); ?></option>
			<option value="Laila" <?php if( "Laila" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Laila', 'gymx' ); ?></option>
			<option value="Lancelot" <?php if( "Lancelot" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Lancelot', 'gymx' ); ?></option>
			<option value="Lato" <?php if( "Lato" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Lato', 'gymx' ); ?></option>
			<option value="League Script" <?php if( "League Script" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'League Script', 'gymx' ); ?></option>
			<option value="Leckerli One" <?php if( "Leckerli One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Leckerli One', 'gymx' ); ?></option>
			<option value="Ledger" <?php if( "Ledger" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Ledger', 'gymx' ); ?></option>
			<option value="Lekton" <?php if( "Lekton" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Lekton', 'gymx' ); ?></option>
			<option value="Lemon" <?php if( "Lemon" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Lemon', 'gymx' ); ?></option>
			<option value="Libre Baskerville" <?php if( "Libre Baskerville" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Libre Baskerville', 'gymx' ); ?></option>
			<option value="Life Savers" <?php if( "Life Savers" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Life Savers', 'gymx' ); ?></option>
			<option value="Lilita One" <?php if( "Lilita One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Lilita One', 'gymx' ); ?></option>
			<option value="Lily Script One" <?php if( "Lily Script One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Lily Script One', 'gymx' ); ?></option>
			<option value="Limelight" <?php if( "Limelight" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Limelight', 'gymx' ); ?></option>
			<option value="Linden Hill" <?php if( "Linden Hill" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Linden Hill', 'gymx' ); ?></option>
			<option value="Lobster" <?php if( "Lobster" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Lobster', 'gymx' ); ?></option>
			<option value="Lobster Two" <?php if( "Lobster Two" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Lobster Two', 'gymx' ); ?></option>
			<option value="Londrina Outline" <?php if( "Londrina Outline" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Londrina Outline', 'gymx' ); ?></option>
			<option value="Londrina Shadow" <?php if( "Londrina Shadow" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Londrina Shadow', 'gymx' ); ?></option>
			<option value="Londrina Sketch" <?php if( "Londrina Sketch" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Londrina Sketch', 'gymx' ); ?></option>
			<option value="Londrina Solid" <?php if( "Londrina Solid" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Londrina Solid', 'gymx' ); ?></option>
			<option value="Lora" <?php if( "Lora" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Lora', 'gymx' ); ?></option>
			<option value="Love Ya Like A Sister" <?php if( "Love Ya Like A Sister" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Love Ya Like A Sister', 'gymx' ); ?></option>
			<option value="Loved by the King" <?php if( "Loved by the King" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Loved by the King', 'gymx' ); ?></option>
			<option value="Lovers Quarrel" <?php if( "Lovers Quarrel" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Lovers Quarrel', 'gymx' ); ?></option>
			<option value="Luckiest Guy" <?php if( "Luckiest Guy" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Luckiest Guy', 'gymx' ); ?></option>
			<option value="Lusitana" <?php if( "Lusitana" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Lusitana', 'gymx' ); ?></option>
			<option value="Lustria" <?php if( "Lustria" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Lustria', 'gymx' ); ?></option>
			<option value="Macondo" <?php if( "Macondo" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Macondo', 'gymx' ); ?></option>
			<option value="Macondo Swash Caps" <?php if( "Macondo Swash Caps" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Macondo Swash Caps', 'gymx' ); ?></option>
			<option value="Magra" <?php if( "Magra" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Magra', 'gymx' ); ?></option>
			<option value="Maiden Orange" <?php if( "Maiden Orange" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Maiden Orange', 'gymx' ); ?></option>
			<option value="Mako" <?php if( "Mako" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Mako', 'gymx' ); ?></option>
			<option value="Marcellus" <?php if( "Marcellus" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Marcellus', 'gymx' ); ?></option>
			<option value="Marcellus SC" <?php if( "Marcellus SC" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Marcellus SC', 'gymx' ); ?></option>
			<option value="Marck Script" <?php if( "Marck Script" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Marck Script', 'gymx' ); ?></option>
			<option value="Margarine" <?php if( "Margarine" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Margarine', 'gymx' ); ?></option>
			<option value="Marko One" <?php if( "Marko One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Marko One', 'gymx' ); ?></option>
			<option value="Marmelad" <?php if( "Marmelad" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Marmelad', 'gymx' ); ?></option>
			<option value="Marvel" <?php if( "Marvel" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Marvel', 'gymx' ); ?></option>
			<option value="Mate" <?php if( "Mate" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Mate', 'gymx' ); ?></option>
			<option value="Mate SC" <?php if( "Mate SC" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Mate SC', 'gymx' ); ?></option>
			<option value="Maven Pro" <?php if( "Maven Pro" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Maven Pro', 'gymx' ); ?></option>
			<option value="McLaren" <?php if( "McLaren" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'McLaren', 'gymx' ); ?></option>
			<option value="Meddon" <?php if( "Meddon" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Meddon', 'gymx' ); ?></option>
			<option value="MedievalSharp" <?php if( "MedievalSharp" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'MedievalSharp', 'gymx' ); ?></option>
			<option value="Medula One" <?php if( "Medula One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Medula One', 'gymx' ); ?></option>
			<option value="Megrim" <?php if( "Megrim" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Megrim', 'gymx' ); ?></option>
			<option value="Meie Script" <?php if( "Meie Script" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Meie Script', 'gymx' ); ?></option>
			<option value="Merienda" <?php if( "Merienda" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Merienda', 'gymx' ); ?></option>
			<option value="Merienda One" <?php if( "Merienda One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Merienda One', 'gymx' ); ?></option>
			<option value="Merriweather" <?php if( "Merriweather" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Merriweather', 'gymx' ); ?></option>
			<option value="Merriweather Sans" <?php if( "Merriweather Sans" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Merriweather Sans', 'gymx' ); ?></option>
			<option value="Metal" <?php if( "Metal" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Metal', 'gymx' ); ?></option>
			<option value="Metal Mania" <?php if( "Metal Mania" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Metal Mania', 'gymx' ); ?></option>
			<option value="Metamorphous" <?php if( "Metamorphous" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Metamorphous', 'gymx' ); ?></option>
			<option value="Metrophobic" <?php if( "Metrophobic" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Metrophobic', 'gymx' ); ?></option>
			<option value="Michroma" <?php if( "Michroma" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Michroma', 'gymx' ); ?></option>
			<option value="Milonga" <?php if( "Milonga" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Milonga', 'gymx' ); ?></option>
			<option value="Miltonian" <?php if( "Miltonian" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Miltonian', 'gymx' ); ?></option>
			<option value="Miltonian Tattoo" <?php if( "Miltonian Tattoo" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Miltonian Tattoo', 'gymx' ); ?></option>
			<option value="Miniver" <?php if( "Miniver" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Miniver', 'gymx' ); ?></option>
			<option value="Miss Fajardose" <?php if( "Miss Fajardose" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Miss Fajardose', 'gymx' ); ?></option>
			<option value="Modern Antiqua" <?php if( "Modern Antiqua" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Modern Antiqua', 'gymx' ); ?></option>
			<option value="Molengo" <?php if( "Molengo" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Molengo', 'gymx' ); ?></option>
			<option value="Molle" <?php if( "Molle" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Molle', 'gymx' ); ?></option>
			<option value="Monda" <?php if( "Monda" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Monda', 'gymx' ); ?></option>
			<option value="Monofett" <?php if( "Monofett" == $this_val ) echo 'selected="selected"'; ?>>Monofett</option>
			<option value="Monoton" <?php if( "Monoton" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Monoton', 'gymx' ); ?></option>
			<option value="Monsieur La Doulaise" <?php if( "Monsieur La Doulaise" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Monsieur La Doulaise', 'gymx' ); ?></option>
			<option value="Montaga" <?php if( "Montaga" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Montaga', 'gymx' ); ?></option>
			<option value="Montez" <?php if( "Montez" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Montez', 'gymx' ); ?></option>
			<option value="Montserrat" <?php if( "Montserrat" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Montserrat', 'gymx' ); ?></option>
			<option value="Montserrat Alternates" <?php if( "Montserrat Alternates" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Montserrat Alternates', 'gymx' ); ?></option>
			<option value="Montserrat Subrayada" <?php if( "Montserrat Subrayada" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Montserrat Subrayada', 'gymx' ); ?></option>
			<option value="Moul" <?php if( "Moul" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Moul', 'gymx' ); ?></option>
			<option value="Moulpali" <?php if( "Moulpali" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Moulpali', 'gymx' ); ?></option>
			<option value="Mountains of Christmas" <?php if( "Mountains of Christmas" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Mountains of Christmas', 'gymx' ); ?></option>
			<option value="Mouse Memoirs" <?php if( "Mouse Memoirs" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Mouse Memoirs', 'gymx' ); ?></option>
			<option value="Mr Bedfort" <?php if( "Mr Bedfort" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Mr Bedfort', 'gymx' ); ?></option>
			<option value="Mr Dafoe" <?php if( "Mr Dafoe" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Mr Dafoe', 'gymx' ); ?></option>
			<option value="Mr De Haviland" <?php if( "Mr De Haviland" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Mr De Haviland', 'gymx' ); ?></option>
			<option value="Mrs Saint Delafield" <?php if( "Mrs Saint Delafield" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Mrs Saint Delafield', 'gymx' ); ?></option>
			<option value="Mrs Sheppards" <?php if( "Mrs Sheppards" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Mrs Sheppards', 'gymx' ); ?></option>
			<option value="Muli" <?php if( "Muli" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Muli', 'gymx' ); ?></option>
			<option value="Mystery Quest" <?php if( "Mystery Quest" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Mystery Quest', 'gymx' ); ?></option>
			<option value="Neucha" <?php if( "Neucha" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Neucha', 'gymx' ); ?></option>
			<option value="Neuton" <?php if( "Neuton" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Neuton', 'gymx' ); ?></option>
			<option value="New Rocker" <?php if( "New Rocker" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'New Rocker', 'gymx' ); ?></option>
			<option value="News Cycle" <?php if( "News Cycle" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'News Cycle', 'gymx' ); ?></option>
			<option value="Niconne" <?php if( "Niconne" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Niconne', 'gymx' ); ?></option>
			<option value="Nixie One" <?php if( "Nixie One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Nixie One', 'gymx' ); ?></option>
			<option value="Nobile" <?php if( "Nobile" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Nobile', 'gymx' ); ?></option>
			<option value="Nokora" <?php if( "Nokora" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Nokora', 'gymx' ); ?></option>
			<option value="Norican" <?php if( "Norican" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Norican', 'gymx' ); ?></option>
			<option value="Nosifer" <?php if( "Nosifer" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Nosifer', 'gymx' ); ?></option>
			<option value="Nothing You Could Do" <?php if( "Nothing You Could Do" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Nothing You Could Do', 'gymx' ); ?></option>
			<option value="Noticia Text" <?php if( "Noticia Text" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Noticia Text', 'gymx' ); ?></option>
			<option value="Noto Sans" <?php if( "Noto Sans" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Noto Sans', 'gymx' ); ?></option>
			<option value="Noto Serif" <?php if( "Noto Serif" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( '>Noto Serif', 'gymx' ); ?></option>
			<option value="Nova Cut" <?php if( "Nova Cut" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Nova Cut', 'gymx' ); ?></option>
			<option value="Nova Flat" <?php if( "Nova Flat" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Nova Flat', 'gymx' ); ?></option>
			<option value="Nova Mono" <?php if( "Nova Mono" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Nova Mono', 'gymx' ); ?></option>
			<option value="Nova Oval" <?php if( "Nova Oval" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Nova Oval', 'gymx' ); ?></option>
			<option value="Nova Round" <?php if( "Nova Round" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Nova Round', 'gymx' ); ?></option>
			<option value="Nova Script" <?php if( "Nova Script" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Nova Script', 'gymx' ); ?></option>
			<option value="Nova Slim" <?php if( "Nova Slim" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Nova Slim', 'gymx' ); ?></option>
			<option value="Nova Square" <?php if( "Nova Square" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Nova Square', 'gymx' ); ?></option>
			<option value="Numans" <?php if( "Numans" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Numans', 'gymx' ); ?></option>
			<option value="Nunito" <?php if( "Nunito" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Nunito', 'gymx' ); ?></option>
			<option value="Odor Mean Chey" <?php if( "Odor Mean Chey" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Odor Mean Chey', 'gymx' ); ?></option>
			<option value="Offside" <?php if( "Offside" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Offside', 'gymx' ); ?></option>
			<option value="Old Standard TT" <?php if( "Old Standard TT" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Old Standard TT', 'gymx' ); ?></option>
			<option value="Oldenburg" <?php if( "Oldenburg" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Oldenburg', 'gymx' ); ?></option>
			<option value="Oleo Script" <?php if( "Oleo Script" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Oleo Script', 'gymx' ); ?></option>
			<option value="Oleo Script Swash Caps" <?php if( "Oleo Script Swash Caps" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Oleo Script Swash Caps', 'gymx' ); ?></option>
			<option value="Open Sans" <?php if( "Open Sans" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Open Sans', 'gymx' ); ?></option>
			<option value="Open Sans Condensed" <?php if( "Open Sans Condensed" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Open Sans Condensed', 'gymx' ); ?></option>
			<option value="Oranienbaum" <?php if( "Oranienbaum" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Oranienbaum', 'gymx' ); ?></option>
			<option value="Orbitron" <?php if( "Orbitron" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Orbitron', 'gymx' ); ?></option>
			<option value="Oregano" <?php if( "Oregano" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Oregano', 'gymx' ); ?></option>
			<option value="Orienta" <?php if( "Orienta" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Orienta', 'gymx' ); ?></option>
			<option value="Original Surfer" <?php if( "Original Surfer" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Original Surfer', 'gymx' ); ?></option>
			<option value="Oswald" <?php if( "Oswald" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Oswald', 'gymx' ); ?></option>
			<option value="Over the Rainbow" <?php if( "Over the Rainbow" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Over the Rainbow', 'gymx' ); ?></option>
			<option value="Overlock" <?php if( "Overlock" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Overlock', 'gymx' ); ?></option>
			<option value="Overlock SC" <?php if( "Overlock SC" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Overlock SC', 'gymx' ); ?></option>
			<option value="Ovo" <?php if( "Ovo" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Ovo', 'gymx' ); ?></option>
			<option value="Oxygen" <?php if( "Oxygen" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Oxygen', 'gymx' ); ?></option>
			<option value="Oxygen Mono" <?php if( "Oxygen Mono" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Oxygen Mono', 'gymx' ); ?></option>
			<option value="PT Mono" <?php if( "PT Mono" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'PT Mono', 'gymx' ); ?></option>
			<option value="PT Sans" <?php if( "PT Sans" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'PT Sans', 'gymx' ); ?></option>
			<option value="PT Sans Caption" <?php if( "PT Sans Caption" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'PT Sans Caption', 'gymx' ); ?></option>
			<option value="PT Sans Narrow" <?php if( "PT Sans Narrow" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'PT Sans Narrow', 'gymx' ); ?></option>
			<option value="PT Serif" <?php if( "PT Serif" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'PT Serif', 'gymx' ); ?></option>
			<option value="PT Serif Caption" <?php if( "PT Serif Caption" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'PT Serif Caption', 'gymx' ); ?></option>
			<option value="Pacifico" <?php if( "Pacifico" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Pacifico', 'gymx' ); ?></option>
			<option value="Paprika" <?php if( "Paprika" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Paprika', 'gymx' ); ?></option>
			<option value="Parisienne" <?php if( "Parisienne" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Parisienne', 'gymx' ); ?></option>
			<option value="Passero One" <?php if( "Passero One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Passero One', 'gymx' ); ?></option>
			<option value="Passion One" <?php if( "Passion One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Passion One', 'gymx' ); ?></option>
			<option value="Pathway Gothic One" <?php if( "Pathway Gothic One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Pathway Gothic One', 'gymx' ); ?></option>
			<option value="Patrick Hand" <?php if( "Patrick Hand" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Patrick Hand', 'gymx' ); ?></option>
			<option value="Patrick Hand SC" <?php if( "Patrick Hand SC" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Patrick Hand SC', 'gymx' ); ?></option>
			<option value="Patua One" <?php if( "Patua One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Patua One', 'gymx' ); ?></option>
			<option value="Paytone One" <?php if( "Paytone One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Paytone One', 'gymx' ); ?></option>
			<option value="Peralta" <?php if( "Peralta" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Peralta', 'gymx' ); ?></option>
			<option value="Permanent Marker" <?php if( "Permanent Marker" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Permanent Marker', 'gymx' ); ?></option>
			<option value="Petit Formal Script" <?php if( "Petit Formal Script" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Petit Formal Script', 'gymx' ); ?></option>
			<option value="Petrona" <?php if( "Petrona" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Petrona', 'gymx' ); ?></option>
			<option value="Philosopher" <?php if( "Philosopher" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Philosopher', 'gymx' ); ?></option>
			<option value="Piedra" <?php if( "Piedra" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Piedra', 'gymx' ); ?></option>
			<option value="Pinyon Script" <?php if( "Pinyon Script" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Pinyon Script', 'gymx' ); ?></option>
			<option value="Pirata One" <?php if( "Pirata One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Pirata One', 'gymx' ); ?></option>
			<option value="Plaster" <?php if( "Plaster" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Plaster', 'gymx' ); ?></option>
			<option value="Play" <?php if( "Play" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Play', 'gymx' ); ?></option>
			<option value="Playball" <?php if( "Playball" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Playball', 'gymx' ); ?></option>
			<option value="Playfair Display" <?php if( "Playfair Display" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Playfair Display', 'gymx' ); ?></option>
			<option value="Playfair Display SC" <?php if( "Playfair Display SC" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Playfair Display SC', 'gymx' ); ?></option>
			<option value="Podkova" <?php if( "Podkova" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Podkova', 'gymx' ); ?></option>
			<option value="Poiret One" <?php if( "Poiret One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Poiret One', 'gymx' ); ?></option>
			<option value="Poller One" <?php if( "Poller One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Poller One', 'gymx' ); ?></option>
			<option value="Poly" <?php if( "Poly" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Poly', 'gymx' ); ?></option>
			<option value="Pompiere" <?php if( "Pompiere" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Pompiere', 'gymx' ); ?></option>
			<option value="Pontano Sans" <?php if( "Pontano Sans" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Pontano Sans', 'gymx' ); ?></option>
			<option value="Port Lligat Sans" <?php if( "Port Lligat Sans" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Port Lligat Sans', 'gymx' ); ?></option>
			<option value="Port Lligat Slab" <?php if( "Port Lligat Slab" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Port Lligat Slab', 'gymx' ); ?></option>
			<option value="Prata" <?php if( "Prata" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Prata', 'gymx' ); ?></option>
			<option value="Preahvihear" <?php if( "Preahvihear" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Preahvihear', 'gymx' ); ?></option>
			<option value="Press Start 2P" <?php if( "Press Start 2P" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Press Start 2P', 'gymx' ); ?></option>
			<option value="Princess Sofia" <?php if( "Princess Sofia" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Princess Sofia', 'gymx' ); ?></option>
			<option value="Prociono" <?php if( "Prociono" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Prociono', 'gymx' ); ?></option>
			<option value="Prosto One" <?php if( "Prosto One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Prosto One', 'gymx' ); ?></option>
			<option value="Puritan" <?php if( "Puritan" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Puritan', 'gymx' ); ?></option>
			<option value="Purple Purse" <?php if( "Purple Purse" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Purple Purse', 'gymx' ); ?></option>
			<option value="Quando" <?php if( "Quando" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Quando', 'gymx' ); ?></option>
			<option value="Quantico" <?php if( "Quantico" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Quantico', 'gymx' ); ?></option>
			<option value="Quattrocento" <?php if( "Quattrocento" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Quattrocento', 'gymx' ); ?></option>
			<option value="Quattrocento Sans" <?php if( "Quattrocento Sans" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Quattrocento Sans', 'gymx' ); ?></option>
			<option value="Questrial" <?php if( "Questrial" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Questrial', 'gymx' ); ?></option>
			<option value="Quicksand" <?php if( "Quicksand" == $this_val ) echo 'selected="selected"'; ?>>Quicksand</option>
			<option value="Quintessential" <?php if( "Quintessential" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Quintessential', 'gymx' ); ?></option>
			<option value="Qwigley" <?php if( "Qwigley" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Qwigley', 'gymx' ); ?></option>
			<option value="Racing Sans One" <?php if( "Racing Sans One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Racing Sans One', 'gymx' ); ?></option>
			<option value="Radley" <?php if( "Radley" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Radley', 'gymx' ); ?></option>
			<option value="Rajdhani" <?php if( "Rajdhani" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Rajdhani', 'gymx' ); ?></option>
			<option value="Raleway" <?php if( "Raleway" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Raleway', 'gymx' ); ?></option>
			<option value="Raleway Dots" <?php if( "Raleway Dots" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Raleway Dots', 'gymx' ); ?></option>
			<option value="Rambla" <?php if( "Rambla" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Rambla', 'gymx' ); ?></option>
			<option value="Rammetto One" <?php if( "Rammetto One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Rammetto One', 'gymx' ); ?></option>
			<option value="Ranchers" <?php if( "Ranchers" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Ranchers', 'gymx' ); ?></option>
			<option value="Rancho" <?php if( "Rancho" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Rancho', 'gymx' ); ?></option>
			<option value="Rationale" <?php if( "Rationale" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Rationale', 'gymx' ); ?></option>
			<option value="Redressed" <?php if( "Redressed" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Redressed', 'gymx' ); ?></option>
			<option value="Reenie Beanie" <?php if( "Reenie Beanie" == $this_val ) echo 'selected="selected"'; ?>>Reenie Beanie</option>
			<option value="Revalia" <?php if( "Revalia" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Revalia', 'gymx' ); ?></option>
			<option value="Ribeye" <?php if( "Ribeye" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Ribeye', 'gymx' ); ?></option>
			<option value="Ribeye Marrow" <?php if( "Ribeye Marrow" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Ribeye Marrow', 'gymx' ); ?></option>
			<option value="Righteous" <?php if( "Righteous" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Righteous', 'gymx' ); ?></option>
			<option value="Risque" <?php if( "Risque" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Risque', 'gymx' ); ?></option>
			<option value="Roboto" <?php if( "Roboto" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Roboto', 'gymx' ); ?></option>
			<option value="Roboto Condensed" <?php if( "Roboto Condensed" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Roboto Condensed', 'gymx' ); ?></option>
			<option value="Roboto Slab" <?php if( "Roboto Slab" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Roboto Slab', 'gymx' ); ?></option>
			<option value="Rochester" <?php if( "Rochester" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Rochester', 'gymx' ); ?></option>
			<option value="Rock Salt" <?php if( "Rock Salt" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Rock Salt', 'gymx' ); ?></option>
			<option value="Rokkitt" <?php if( "Rokkitt" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Rokkitt', 'gymx' ); ?></option>
			<option value="Romanesco" <?php if( "Romanesco" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Romanesco', 'gymx' ); ?></option>
			<option value="Ropa Sans" <?php if( "Ropa Sans" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Ropa Sans', 'gymx' ); ?></option>
			<option value="Rosario" <?php if( "Rosario" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Rosario', 'gymx' ); ?></option>
			<option value="Rosarivo" <?php if( "Rosarivo" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Rosarivo', 'gymx' ); ?></option>
			<option value="Rouge Script" <?php if( "Rouge Script" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Rouge Script', 'gymx' ); ?></option>
			<option value="Rozha One" <?php if( "Rozha One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Rozha One', 'gymx' ); ?></option>
			<option value="Rubik Mono One" <?php if( "Rubik Mono One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Rubik Mono One', 'gymx' ); ?></option>
			<option value="Rubik One" <?php if( "Rubik One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Rubik One', 'gymx' ); ?></option>
			<option value="Ruda" <?php if( "Ruda" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Ruda', 'gymx' ); ?></option>
			<option value="Rufina" <?php if( "Rufina" == $this_val ) echo 'selected="selected"'; ?>>Rufina</option>
			<option value="Ruge Boogie" <?php if( "Ruge Boogie" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Ruge Boogie', 'gymx' ); ?></option>
			<option value="Ruluko" <?php if( "Ruluko" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Ruluko', 'gymx' ); ?></option>
			<option value="Rum Raisin" <?php if( "Rum Raisin" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Rum Raisin', 'gymx' ); ?></option>
			<option value="Ruslan Display" <?php if( "Ruslan Display" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Ruslan Display', 'gymx' ); ?></option>
			<option value="Russo One" <?php if( "Russo One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Russo One', 'gymx' ); ?></option>
			<option value="Ruthie" <?php if( "Ruthie" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Ruthie', 'gymx' ); ?></option>
			<option value="Rye" <?php if( "Rye" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Rye', 'gymx' ); ?></option>
			<option value="Sacramento" <?php if( "Sacramento" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Sacramento', 'gymx' ); ?></option>
			<option value="Sail" <?php if( "Sail" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Sail', 'gymx' ); ?></option>
			<option value="Salsa" <?php if( "Salsa" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Salsa', 'gymx' ); ?></option>
			<option value="Sanchez" <?php if( "Sanchez" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Sanchez', 'gymx' ); ?></option>
			<option value="Sancreek" <?php if( "Sancreek" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Sancreek', 'gymx' ); ?></option>
			<option value="Sansita One" <?php if( "Sansita One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Sansita One', 'gymx' ); ?></option>
			<option value="Sarina" <?php if( "Sarina" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Sarina', 'gymx' ); ?></option>
			<option value="Sarpanch" <?php if( "Sarpanch" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Sarpanch', 'gymx' ); ?></option>
			<option value="Satisfy" <?php if( "Satisfy" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Satisfy', 'gymx' ); ?></option>
			<option value="Scada" <?php if( "Scada" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Scada', 'gymx' ); ?></option>
			<option value="Schoolbell" <?php if( "Schoolbell" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Schoolbell', 'gymx' ); ?></option>
			<option value="Seaweed Script" <?php if( "Seaweed Script" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Seaweed Script', 'gymx' ); ?></option>
			<option value="Sevillana" <?php if( "Sevillana" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Sevillana', 'gymx' ); ?></option>
			<option value="Seymour One" <?php if( "Seymour One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Seymour One', 'gymx' ); ?></option>
			<option value="Shadows Into Light" <?php if( "Shadows Into Light" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Shadows Into Light', 'gymx' ); ?></option>
			<option value="Shadows Into Light Two" <?php if( "Shadows Into Light Two" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Shadows Into Light Two', 'gymx' ); ?></option>
			<option value="Shanti" <?php if( "Shanti" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Shanti', 'gymx' ); ?></option>
			<option value="Share" <?php if( "Share" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Share', 'gymx' ); ?></option>
			<option value="Share Tech" <?php if( "Share Tech" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Share Tech', 'gymx' ); ?></option>
			<option value="Share Tech Mono" <?php if( "Share Tech Mono" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Share Tech Mono', 'gymx' ); ?></option>
			<option value="Shojumaru" <?php if( "Shojumaru" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Shojumaru', 'gymx' ); ?></option>
			<option value="Short Stack" <?php if( "Short Stack" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Short Stack', 'gymx' ); ?></option>
			<option value="Siemreap" <?php if( "Siemreap" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Siemreap', 'gymx' ); ?></option>
			<option value="Sigmar One" <?php if( "Sigmar One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Sigmar One', 'gymx' ); ?></option>
			<option value="Signika" <?php if( "Signika" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Signika', 'gymx' ); ?></option>
			<option value="Signika Negative" <?php if( "Signika Negative" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Signika Negative', 'gymx' ); ?></option>
			<option value="Simonetta" <?php if( "Simonetta" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Simonetta', 'gymx' ); ?></option>
			<option value="Sintony" <?php if( "Sintony" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Sintony', 'gymx' ); ?></option>
			<option value="Sirin Stencil" <?php if( "Sirin Stencil" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Sirin Stencil', 'gymx' ); ?></option>
			<option value="Six Caps" <?php if( "Six Caps" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Six Caps', 'gymx' ); ?></option>
			<option value="Skranji" <?php if( "Skranji" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Skranji', 'gymx' ); ?></option>
			<option value="Slabo 13px" <?php if( "Slabo 13px" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Slabo 13px', 'gymx' ); ?></option>
			<option value="Slabo 27px" <?php if( "Slabo 27px" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Slabo 27px', 'gymx' ); ?></option>
			<option value="Slackey" <?php if( "Slackey" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Slackey', 'gymx' ); ?></option>
			<option value="Smokum" <?php if( "Smokum" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Smokum', 'gymx' ); ?></option>
			<option value="Smythe" <?php if( "Smythe" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Smythe', 'gymx' ); ?></option>
			<option value="Sniglet" <?php if( "Sniglet" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Sniglet', 'gymx' ); ?></option>
			<option value="Snippet" <?php if( "Snippet" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Snippet', 'gymx' ); ?></option>
			<option value="Snowburst One" <?php if( "Snowburst One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Snowburst One', 'gymx' ); ?></option>
			<option value="Sofadi One" <?php if( "Sofadi One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Sofadi One', 'gymx' ); ?></option>
			<option value="Sofia" <?php if( "Sofia" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Sofia', 'gymx' ); ?></option>
			<option value="Sonsie One" <?php if( "Sonsie One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Sonsie One', 'gymx' ); ?></option>
			<option value="Sorts Mill Goudy" <?php if( "Sorts Mill Goudy" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Sorts Mill Goudy', 'gymx' ); ?></option>
			<option value="Source Code Pro" <?php if( "Source Code Pro" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Source Code Pro', 'gymx' ); ?></option>
			<option value="Source Sans Pro" <?php if( "Source Sans Pro" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Source Sans Pro', 'gymx' ); ?></option>
			<option value="Source Serif Pro" <?php if( "Source Serif Pro" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Source Serif Pro', 'gymx' ); ?></option>
			<option value="Special Elite" <?php if( "Special Elite" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Special Elite', 'gymx' ); ?></option>
			<option value="Spicy Rice" <?php if( "Spicy Rice" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Spicy Rice', 'gymx' ); ?></option>
			<option value="Spinnaker" <?php if( "Spinnaker" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Spinnaker', 'gymx' ); ?></option>
			<option value="Spirax" <?php if( "Spirax" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Spirax', 'gymx' ); ?></option>
			<option value="Squada One" <?php if( "Squada One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Squada One', 'gymx' ); ?></option>
			<option value="Stalemate" <?php if( "Stalemate" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Stalemate', 'gymx' ); ?></option>
			<option value="Stalinist One" <?php if( "Stalinist One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Stalinist One', 'gymx' ); ?></option>
			<option value="Stardos Stencil" <?php if( "Stardos Stencil" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Stardos Stencil', 'gymx' ); ?></option>
			<option value="Stint Ultra Condensed" <?php if( "Stint Ultra Condensed" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Stint Ultra Condensed', 'gymx' ); ?></option>
			<option value="Stint Ultra Expanded" <?php if( "Stint Ultra Expanded" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Stint Ultra Expanded', 'gymx' ); ?></option>
			<option value="Stoke" <?php if( "Stoke" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Stoke', 'gymx' ); ?></option>
			<option value="Strait" <?php if( "Strait" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Strait', 'gymx' ); ?></option>
			<option value="Sue Ellen Francisco" <?php if( "Sue Ellen Francisco" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Sue Ellen Francisco', 'gymx' ); ?></option>
			<option value="Sunshiney" <?php if( "Sunshiney" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Sunshiney', 'gymx' ); ?></option>
			<option value="Supermercado One" <?php if( "Supermercado One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Supermercado One', 'gymx' ); ?></option>
			<option value="Suwannaphum" <?php if( "Suwannaphum" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Suwannaphum', 'gymx' ); ?></option>
			<option value="Swanky and Moo Moo" <?php if( "Swanky and Moo Moo" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Swanky and Moo Moo', 'gymx' ); ?></option>
			<option value="Syncopate" <?php if( "Syncopate" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Syncopate', 'gymx' ); ?></option>
			<option value="Tangerine" <?php if( "Tangerine" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Tangerine', 'gymx' ); ?></option>
			<option value="Taprom" <?php if( "Taprom" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Taprom', 'gymx' ); ?></option>
			<option value="Tauri" <?php if( "Tauri" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Tauri', 'gymx' ); ?></option>
			<option value="Teko" <?php if( "Teko" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Teko', 'gymx' ); ?></option>
			<option value="Telex" <?php if( "Telex" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Telex', 'gymx' ); ?></option>
			<option value="Tenor Sans" <?php if( "Tenor Sans" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Tenor Sans', 'gymx' ); ?></option>
			<option value="Text Me One" <?php if( "Text Me One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Text Me One', 'gymx' ); ?></option>
			<option value="The Girl Next Door" <?php if( "The Girl Next Door" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'The Girl Next Door', 'gymx' ); ?></option>
			<option value="Tienne" <?php if( "Tienne" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Tienne', 'gymx' ); ?></option>
			<option value="Tinos" <?php if( "Tinos" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Tinos', 'gymx' ); ?></option>
			<option value="Titan One" <?php if( "Titan One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Titan One', 'gymx' ); ?></option>
			<option value="Titillium Web" <?php if( "Titillium Web" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Titillium Web', 'gymx' ); ?></option>
			<option value="Trade Winds" <?php if( "Trade Winds" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Trade Winds', 'gymx' ); ?></option>
			<option value="Trocchi" <?php if( "Trocchi" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Trocchi', 'gymx' ); ?></option>
			<option value="Trochut" <?php if( "Trochut" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Trochut', 'gymx' ); ?></option>
			<option value="Trykker" <?php if( "Trykker" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Trykker', 'gymx' ); ?></option>
			<option value="Tulpen One" <?php if( "Tulpen One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Tulpen One', 'gymx' ); ?></option>
			<option value="Ubuntu" <?php if( "Ubuntu" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Ubuntu', 'gymx' ); ?></option>
			<option value="Ubuntu Condensed" <?php if( "Ubuntu Condensed" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Ubuntu Condensed', 'gymx' ); ?></option>
			<option value="Ubuntu Mono" <?php if( "Ubuntu Mono" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Ubuntu Mono', 'gymx' ); ?></option>
			<option value="Ultra" <?php if( "Ultra" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Ultra', 'gymx' ); ?></option>
			<option value="Uncial Antiqua" <?php if( "Uncial Antiqua" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Uncial Antiqua', 'gymx' ); ?></option>
			<option value="Underdog" <?php if( "Underdog" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Underdog', 'gymx' ); ?></option>
			<option value="Unica One" <?php if( "Unica One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Unica One', 'gymx' ); ?></option>
			<option value="UnifrakturCook" <?php if( "UnifrakturCook" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'UnifrakturCook', 'gymx' ); ?></option>
			<option value="UnifrakturMaguntia" <?php if( "UnifrakturMaguntia" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'UnifrakturMaguntia', 'gymx' ); ?></option>
			<option value="Unkempt" <?php if( "Unkempt" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Unkempt', 'gymx' ); ?></option>
			<option value="Unlock" <?php if( "Unlock" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Unlock', 'gymx' ); ?></option>
			<option value="Unna" <?php if( "Unna" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Unna', 'gymx' ); ?></option>
			<option value="VT323" <?php if( "VT323" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'VT323', 'gymx' ); ?></option>
			<option value="Vampiro One" <?php if( "Vampiro One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Vampiro One', 'gymx' ); ?></option>
			<option value="Varela" <?php if( "Varela" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Varela', 'gymx' ); ?></option>
			<option value="Varela Round" <?php if( "Varela Round" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Varela Round', 'gymx' ); ?></option>
			<option value="Vast Shadow" <?php if( "Vast Shadow" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Vast Shadow', 'gymx' ); ?></option>
			<option value="Vesper Libre" <?php if( "Vesper Libre" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Vesper Libre', 'gymx' ); ?></option>
			<option value="Vibur" <?php if( "Vibur" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Vibur', 'gymx' ); ?></option>
			<option value="Vidaloka" <?php if( "Vidaloka" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Vidaloka', 'gymx' ); ?></option>
			<option value="Viga" <?php if( "Viga" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Viga', 'gymx' ); ?></option>
			<option value="Voces" <?php if( "Voces" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Voces', 'gymx' ); ?></option>
			<option value="Volkhov" <?php if( "Volkhov" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Volkhov', 'gymx' ); ?></option>
			<option value="Vollkorn" <?php if( "Vollkorn" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Vollkorn', 'gymx' ); ?></option>
			<option value="Voltaire" <?php if( "Voltaire" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Voltaire', 'gymx' ); ?></option>
			<option value="Waiting for the Sunrise" <?php if( "Waiting for the Sunrise" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Waiting for the Sunrise', 'gymx' ); ?></option>
			<option value="Wallpoet" <?php if( "Wallpoet" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Wallpoet', 'gymx' ); ?></option>
			<option value="Walter Turncoat" <?php if( "Walter Turncoat" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Walter Turncoat', 'gymx' ); ?></option>
			<option value="Warnes" <?php if( "Warnes" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Warnes', 'gymx' ); ?></option>
			<option value="Wellfleet" <?php if( "Wellfleet" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Wellfleet', 'gymx' ); ?></option>
			<option value="Wendy One" <?php if( "Wendy One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Wendy One', 'gymx' ); ?></option>
			<option value="Wire One" <?php if( "Wire One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Wire One', 'gymx' ); ?></option>
			<option value="Yanone Kaffeesatz" <?php if( "Yanone Kaffeesatz" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Yanone Kaffeesatz', 'gymx' ); ?></option>
			<option value="Yellowtail" <?php if( "Yellowtail" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Yellowtail', 'gymx' ); ?></option>
			<option value="Yeseva One" <?php if( "Yeseva One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Yeseva One', 'gymx' ); ?></option>
			<option value="Yesteryear" <?php if( "Yesteryear" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Yesteryear', 'gymx' ); ?></option>
			<option value="Zeyada" <?php if( "Zeyada" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Zeyada', 'gymx' ); ?></option>
		</select>
	</label>
	<?php }
}