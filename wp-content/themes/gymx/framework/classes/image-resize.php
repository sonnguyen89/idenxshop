<?php
/**
 * Function used to resize and crop images
 *
 * Inspired by Aqua Resizer: https://github.com/syamilmj/Aqua-Resizer
 * 
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Start Class
if ( ! class_exists( 'GymX_Image_Resize' ) ) {

    class GymX_Image_Resize {

        /**
         * No initialization allowed
         * Constructor defines variables only
         *
         * @since   1.0.0
         * @return  void
         */
        public function __construct() {
            $this->gymx_retina_enabled = get_theme_mod( 'gymx_retina', false );
            $this->gymx_retina_enabled = apply_filters( 'gymx_image_resize_retina', $this->gymx_retina_enabled );
        }

        /**
         * Run image resizing function
         *
         * @since   1.0.0
         * @return  string or array
         */
        public function gymx_process( $args ) {


            // Args must be an array
            if ( ! is_array( $args ) ) {
                print_r( esc_attr__('Fatal Error: Image resize args are not an array, you must update your template files.', 'gymx' ));
                return false;
            }

            // Default args
            $defaults = array(
                'image'     => null,
                'width'     => '9999',
                'height'    => '9999',
                'crop'      => 'center-center',
                'retina'    => false,
                'return'    => 'array',
            );

            // Parse args
            $args = wp_parse_args( $args, $defaults );

            // Extract args
            extract( $args );

            // If URL isn't defined return
            if ( ! $image ) {
                return;
            }

            // Sanitize inputs
            $width  = intval( $width );
            $height = intval( $height );

            // Set width and height to '9999' if empty
            $width  = $width ? $width : '9999';
            $height = $height ? $height : '9999';

            // Set crop to center-center if empty
            $crop = $crop ? $crop : 'center-center';

            // Sanitize crop and add crop suffix
            $crop_suffix    = '';
            $crop           = ( $height >= '9999' ) ? false : $crop;

            // Define upload path & dir
            $upload_info    = wp_upload_dir();
            $upload_dir     = $upload_info[ 'basedir' ];
            $upload_url     = $upload_info[ 'baseurl' ];

            // Define path of image
            $rel_path = str_replace( $upload_url, '', $image );
            $img_path = $upload_dir . $rel_path;

            // Add crop_suffix if $crop isn't false or empty and image resizing is enabled
            if ( $crop && get_theme_mod( 'gymx_image_resizing', true ) ) {
                if ( is_array( $crop ) ) {
                    $crop_suffix = array_combine( $crop, $crop );
                    $crop_suffix = implode( '-', $crop_suffix );
                } elseif ( 'center-center' != $crop ) {
                    $crop_suffix = $crop;
                    $crop = explode( '-', $crop );
                }
            }

            // If image width and height are both 9999 and size is empty return full image
            if ( '9999' == $width && '9999' == $height ) {

                // Return for retina images
                if ( $retina ) {
                    return;
                }

                // Set main image to the full URL
                $img_url = $image;

                // Get width and height
                $info                       = pathinfo( $img_path );
                $ext                        = $info['extension'];
                list( $orig_w, $orig_h )    = getimagesize( $img_path );

            }

            // Image width and height are defined so lets try and crop it
            else {

                // Set resize dimensions
                $resize_width   = $width;
                $resize_height  = $height;
                
                // If $img_url isn't local return full image
                if ( strpos( $image, $upload_url ) === false ) {
                    $img_url = $image;
                }

                // Image is local, so lets try and crop it
                else {
                    
                    // Check if img path exists, and is an image indeed if not return full img
                    if ( ! file_exists( $img_path ) OR ! getimagesize( $img_path ) ) {

                        $img_url = $image;

                    }

                    // Lets try and crop things
                    else {
                    
                        // Get image info
                        $info                       = pathinfo( $img_path );
                        $ext                        = $info['extension'];
                        list( $orig_w, $orig_h )    = getimagesize( $img_path );
                                
                        // Get image size after cropping
                        $dims   = image_resize_dimensions( $orig_w, $orig_h, $resize_width, $resize_height, $crop );
                        $dst_w  = $dims[4];
                        $dst_h  = $dims[5];
                        
                        // Can't resize, so return original url
                        if ( ! $dims ) {

                            // Set values equal to original image
                            $img_url    = $image;
                            $dst_w      = $orig_w;
                            $dst_h      = $orig_h;

                            // Return false for retina
                            if ( $retina ) {
                                return false;
                            }

                        }
                        
                        // Image can be resized so lets do that
                        else {

                            // Define image saving destination
                            $dst_rel_path = str_replace( '.'. $ext, '', $rel_path );

                            // Suffix
                            $suffix = $dst_w .'x'. $dst_h;

                            // Sanitize suffix
                            $suffix = $crop_suffix ? $crop_suffix .'-'. $suffix : $suffix;

                            // Check original image destination
                            $destfilename = $upload_dir . $dst_rel_path .'-'. $suffix .'.'. $ext;

                            // Set dimensions for retina images
                            if ( $retina ) {

                                // Check if we should actually create a retina version
                                if ( $dims && file_exists( $destfilename ) && getimagesize( $destfilename ) ) {

                                    // Return if the destination width or height aren't at least 2x as big
                                    if ( ( $orig_w < $dst_w * 2 ) || ( $orig_h < $dst_h * 2 ) ) {
                                        return false;
                                    }

                                    // Set retina version to @2x the output of the default cropped image
                                    $dims   = image_resize_dimensions( $orig_w, $orig_h, $dst_w * 2, $dst_h * 2, $crop );
                                    $dst_w  = $dims[4];
                                    $dst_h  = $dims[5];

                                    // Return if retina version can't be created
                                    if ( ! $dims ) {
                                        return false;
                                    }

                                    // Set correct resize dims for retina images
                                    $resize_width   = $resize_width * 2;
                                    $resize_height  = $resize_height * 2;

                                    // Tweak suffix
                                    $suffix .= '@2x';
                                    $suffix = $crop_suffix ? $crop_suffix .'-'. $suffix : $suffix;

                                } else {
                                    return false;
                                }

                            }

                            // The full destination filename for the cropped image
                            $destfilename = $upload_dir . $dst_rel_path .'-'. $suffix .'.'. $ext;

                            //  Check if cache exists
                            if ( file_exists( $destfilename ) && getimagesize( $destfilename ) ) {

                                // Set image url
                                $img_url = $upload_url . $dst_rel_path .'-'. $suffix .'.'. $ext;
                        
                            }

                            // Cached image doesn't exist so resize the image and return the new resized image url
                            else {
                                
                                $editor = wp_get_image_editor( $img_path );
                                
                                // Return full image if there is an error
                                if ( is_wp_error( $editor ) || is_wp_error( $editor->resize( $resize_width, $resize_height, $crop ) ) ) {
                                    $img_url = $image;
                                }

                                // No error so lets go ahead and save it
                                else {

                                    // Get resized file
                                    $filename   = $editor->generate_filename( $suffix );
                                    $editor     = $editor->save( $filename );

                                    // Return the resized image URL
                                    if ( ! is_wp_error( $editor ) ) {

                                        $path       = str_replace( $upload_dir, '', $editor['path'] );
                                        $img_url    = $upload_url . $path;

                                    }

                                    // Return full image if there is an error
                                    else {

                                        $img_url = $image;

                                    }

                                }

                            } // End cache check

                        } // End $dims check
                            
                    } // End file exists check

                } // End local image check

            } // End image dims check
            
            // Validate url
            $img_url = ! empty( $img_url ) ? $img_url : $image;

            // Validate width
            if ( ! empty( $dst_w ) ) {
                $dst_w = $dst_w;
            } elseif( $orig_w ) {
                $dst_w = $orig_w;
            } else {
                $dst_w = '';
            }

            // Validate height
            if ( ! empty( $dst_h ) ) {
                $dst_h = $dst_h;
            } elseif( $orig_h ) {
                $dst_h = $orig_h;
            } else {
                $dst_h = '';
            }

            // Return Image data
            if ( 'array' == $return ) {
                return array(
                    'url'       => $img_url,
                    'width'     => $dst_w,
                    'height'    => $dst_h
                );
            } else {
                return $img_url;
            }

        }

    }
    
}

// Helper function for resizing images using the GymX_Image_Resize class
if ( ! function_exists( 'gymx_image_resize' ) ) {
    function gymx_image_resize( $args ) {
        $class = new GymX_Image_Resize;
        return $class->gymx_process( $args );
    }
}