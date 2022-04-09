<?php
/**
 * Class for the revslider importer used in the One Click Demo Import plugin.
 *
 * @package ocdi
 */

class OCDI_Revslider_Importer {

	/**
	 * Imports Revolution slider
	 */
	public static function import_revslider( $import_file_path ) {
        if ( class_exists( 'RevSlider' ) ) {
			$slider = new RevSlider();
			$slider->importSliderFromPost( true, true, $import_file_path );
		}
	}

}
