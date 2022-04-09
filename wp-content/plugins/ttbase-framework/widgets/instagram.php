<?php
/**
 * TTBase Instagram Grid Widget
 */

// Prevent direct file access
if ( ! defined ( 'ABSPATH' ) ) {
	exit;
}

// Start widget class
if ( ! class_exists( 'TTBase_Framework_Instagram_Widget' ) ) {
	class TTBase_Framework_Instagram_Widget extends WP_Widget {
		
		/**
		 * Register widget with WordPress.
		 *
		 */
		function __construct() {
			parent::__construct(FALSE, $name = esc_html__('TTBase Instagram Grid', 'ttbase-framework'), array(
				'description' => esc_html__('Add your instagram feed in a grid style.', 'ttbase-framework')
			));
		}

		/**
		 * Front-end display of widget.
		 *
		 */
		public function widget( $args, $instance ) {

			// Extract args
			extract( $args );

			// Args
			$title    = empty( $instance['title'] ) ? '' : apply_filters( 'widget_title', $instance['title'] );
			$username = empty( $instance['username'] ) ? '' : $instance['username'];
			$number   = empty( $instance['number'] ) ? 9 : $instance['number'];
			$columns  = empty( $instance['columns'] ) ? '3' : $instance['columns'];
			$target   = isset( $instance['target'] ) ? $instance['target'] : '';

			// Before widget hook
			echo $before_widget;

			// Display widget title
			if ( $title ) {
				echo $before_title . $title . $after_title;
			}

			// Display notice for username not added
			if ( ! $username ) {

				echo '<p>'. esc_html__( 'Please enter your instagram username.', 'ttbase-framework' ) .'</p>';

			} else {

				// Get instagram images
				$media_array = $this->scrape_instagram( $username, $number );

				// Display error message
				if ( is_wp_error( $media_array ) ) {

					echo $media_array->get_error_message();

				}

				// Display instagram grid
				elseif ( is_array( $media_array ) ) { ?>

					<div class="instagram-grid-widget clearfix">

						<ul class="clearfix grid-row gap-10">

						<?php
						$count = 0;
						foreach ( $media_array as $item ) {
							$image = ! empty( $item['thumbnail_src'] ) ? $item['thumbnail_src'] : $item['display_src'];
							if ( $image ) {
								$count++;
								$target = ($target == '_blank') ? " target='_blank'" : "";
								echo '<li class="col clearfix span_1_of_'. $columns .' count-'. $count .'">
										<a href="'. esc_url( $item['link'] ) .'" title="'. esc_attr( $item['description'] ) .'"'. $target .'>
											<img class="img-responsive" src="'. esc_url( $image ) .'"  alt="'. esc_attr( $item['description'] ) .'" />
											<div class="overlay">
												<i class="fa fa-instagram"></i>
											</div>
										</a>
									</li>';
								if ( $columns == $count ) {
									$count = 0;
								}
							}
						} ?>

						</ul>
						
					</div>

			<?php }

			}

			// After widget hook
			echo $after_widget;
		}

		/**
		 * Sanitize widget form values as they are saved.
		 *
		 */
		public function update( $new_instance, $old_instance ) {

			// Get instance
			$instance             = $old_instance;
			$instance['title']    = strip_tags( $new_instance['title'] );
			$instance['username'] = trim( strip_tags( $new_instance['username'] ) );
			$instance['number']   = ! absint( $new_instance['number'] ) ? 9 : $new_instance['number'];
			$instance['target']   = $new_instance['target'] == '_blank' ? $new_instance['target'] : '';
			$instance['columns']   = $new_instance['columns'];

			// Delete transient
			if ( $instance['username'] ) {
				delete_transient( 'ttbase-instagram-widget-new-'. sanitize_title_with_dashes( $instance['username'] ) );
			}

			// Return instance
			return $instance;

		}

		/**
		 * Back-end widget form.
		 *
		 */
		public function form( $instance ) {

			$instance = wp_parse_args( ( array ) $instance, array(
				'title'    => esc_html__( 'Instagram', 'ttbase-framework' ),
				'username' => '',
				'number'   => '9',
				'columns'  => '3',
				'target'   => '_self'
			) );
			$title    = $instance['title'];
			$username = $instance['username'];
			$number   = $instance['number'];
			$columns  = absint( $instance['columns'] );
			$target   = esc_attr( $instance['target'] ); ?>
			
			<p><label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php esc_html_e( 'Title', 'ttbase-framework' ); ?>: <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>

			<p><label for="<?php echo esc_attr($this->get_field_id( 'username' )); ?>"><?php esc_html_e( 'Username', 'ttbase-framework' ); ?>: <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'username' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'username' )); ?>" type="text" value="<?php echo esc_attr($username); ?>" /></label></p>

			<p><label for="<?php echo esc_attr($this->get_field_id( 'columns' )); ?>"><?php esc_html_e( 'Columns', 'ttbase-framework' ); ?>:</label>
				<select id="<?php echo esc_attr($this->get_field_id( 'columns' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'columns' )); ?>" class="widefat">
					<option value="1" <?php selected( '1', $columns ) ?>>1</option>
					<option value="2" <?php selected( '2', $columns ) ?>>2</option>
					<option value="3" <?php selected( '3', $columns ) ?>>3</option>
					<option value="4" <?php selected( '4', $columns ) ?>>4</option>
					<option value="5" <?php selected( '5', $columns ) ?>>5</option>
				</select>
			</p>

			<p><label for="<?php echo esc_attr($this->get_field_id( 'number' )); ?>"><?php esc_html_e( 'Number of photos', 'ttbase-framework' ); ?>: <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'number' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'number' )); ?>" type="text" value="<?php echo absint($number); ?>" /></label></p>

			<p><label for="<?php echo esc_attr($this->get_field_id( 'target' )); ?>"><?php esc_html_e( 'Open links in', 'ttbase-framework' ); ?>:</label>
				<select id="<?php echo esc_attr($this->get_field_id( 'target' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'target' )); ?>" class="widefat">
					<option value="_self" <?php selected( '_self', $target ) ?>><?php esc_html_e( 'Current window', 'ttbase-framework' ); ?></option>
					<option value="_blank" <?php selected( '_blank', $target ) ?>><?php esc_html_e( 'New window', 'ttbase-framework' ); ?></option>
				</select>
			</p>

			<p>
				<strong><?php esc_html_e( 'Cache Notice', 'ttbase-framework' ); ?></strong>:<?php esc_html_e( 'The instagram feed refreshes every 2 hours. With a click on the save button you can refresh it immediately.', 'ttbase-framework' ); ?>
			</p>

			<?php
		}

		/**
		 * Get instagram items
		 *
		 * @link  https://gist.github.com/cosmocatalano/4544576
		 */
		function scrape_instagram( $username, $slice = 4 ) {

			$username           = strtolower( $username );
			$sanitized_username = sanitize_title_with_dashes( $username );
			$transient_name     = 'ttbase-instagram-widget-new-'. $sanitized_username;
			$instagram          = get_transient( $transient_name );

			if ( ! empty( $_GET['theme_clear_transients'] ) ) {
				$instagram = delete_transient( $transient_name );
			}

			if ( ! $instagram ) {

				$remote = wp_remote_get( 'https://instagram.com/'. trim( $username ) );

				if ( is_wp_error( $remote ) ) {
					return new WP_Error( 'site_down', esc_html__( 'Unable to communicate with Instagram.', 'ttbase-framework' ) );
				}

				if ( 200 != wp_remote_retrieve_response_code( $remote ) ) {
					return new WP_Error( 'invalid_response', esc_html__( 'Instagram did not return a 200.', 'ttbase-framework' ) );
				}

				$shards      = explode( 'window._sharedData = ', $remote['body'] );
				$insta_json  = explode( ';</script>', $shards[1] );
				$insta_array = json_decode( $insta_json[0], TRUE );

				if ( ! $insta_array ) {
					return new WP_Error( 'bad_json', esc_html__( 'Instagram has returned invalid data.', 'ttbase-framework' ) );
				}

				// Old style
				if ( isset( $insta_array['entry_data']['UserProfile'][0]['userMedia'] ) ) {
					$images = $insta_array['entry_data']['UserProfile'][0]['userMedia'];
					$type = 'old';

				}

				// New style
				elseif ( isset( $insta_array['entry_data']['ProfilePage'][0]['graphql']['user']['edge_owner_to_timeline_media']['edges'] ) ) {
					$images = $insta_array['entry_data']['ProfilePage'][0]['graphql']['user']['edge_owner_to_timeline_media']['edges'];
					$type = 'new';
				}

				// Invalid json data
				else {
					return new WP_Error( 'bad_json_2', esc_html__( 'Instagram has returned invalid data.', 'ttbase-framework' ) );
				}

				// Invalid data
				if ( ! is_array( $images ) ) {
					return new WP_Error( 'bad_array', esc_html__( 'Instagram has returned invalid data.', 'ttbase-framework' ) );
				}

				$instagram = array();

				switch ( $type ) {

					case 'old':

						foreach ( $images as $image ) {
							if ( $image['user']['username'] == $username ) {
								$image['link']						    = preg_replace( "/^http:/i", "", $image['link'] );
								$image['images']['thumbnail']		    = preg_replace( "/^http:/i", "", $image['images']['thumbnail'] );
								$image['images']['standard_resolution'] = preg_replace( "/^http:/i", "", $image['images']['standard_resolution'] );
								$image['images']['low_resolution']	    = preg_replace( "/^http:/i", "", $image['images']['low_resolution'] );
								$instagram[] = array(
									'description' => $image['caption']['text'],
									'link'        => $image['link'],
									'time'        => $image['created_time'],
									'comments'    => $image['comments']['count'],
									'likes'       => $image['likes']['count'],
									'thumbnail'   => $image['images']['thumbnail'],
									'large'       => $image['images']['standard_resolution'],
									'small'       => $image['images']['low_resolution'],
									'type'        => $image['type'],
								);
							}
						}

					break;

					default:

						foreach ( $images as $image_data ) {
							$image = $image_data['node'];
							
							$image['display_url'] = preg_replace( "/^http:/i", "", $image['display_url'] );

							if ( $image['is_video']  == true ) {
								$type = 'video';
							} else {
								$type = 'image';
							}

							$instagram[] = array(
								'description'   => esc_html__( 'Instagram Image', 'ttbase-framework' ),
								'link'		    => '//instagram.com/p/' . $image['shortcode'],
								'time'		    => $image['taken_at_timestamp'],
								'comments'	    => $image['edge_media_to_comment']['count'],
								'likes'		    => $image['edge_media_preview_like']['count'],
								'thumbnail_src' => isset( $image['thumbnail_src'] ) ? $image['thumbnail_src'] : '',
								'display_src'   => $image['display_url'],
								'type'		    => $type,
								'media_preview' => $image['media_preview']
							);

						}

					break;

				}

				// Set transient if not empty
				if ( ! empty( $instagram ) ) {
					$instagram = base64_encode( serialize( $instagram ) );
					set_transient(
						$transient_name,
						$instagram,
						apply_filters( 'ttbase_instagram_widget_cache_time', HOUR_IN_SECONDS*2 )
					);
				}

			}

			// Return array
			if ( ! empty( $instagram )  ) {
				$instagram = unserialize( base64_decode( $instagram ) );
				return array_slice( $instagram, 0, $slice );
			}

			// No images returned
			else {

				return new WP_Error( 'no_images', esc_html__( 'Instagram did not return any images.', 'ttbase-framework' ) );

			}

		}


	}
}

// Register the Instagram widget
if ( ! function_exists( 'ttbase_framework_register_instagram_widget' ) ) {
	function ttbase_framework_register_instagram_widget() {
		register_widget( 'TTBase_Framework_Instagram_Widget' );
	}
}
add_action( 'widgets_init', 'ttbase_framework_register_instagram_widget' );