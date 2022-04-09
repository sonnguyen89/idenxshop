<?php
/**
 * TTBase Mailchimp Newsletter Widget
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Start class
class TTBase_Framework_Newsletter_Widget extends WP_Widget {
	private $defaults;
	
	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {

		parent::__construct(FALSE, $name = esc_html__('TTBase Mailchimp Newsletter', 'ttbase-framework'), array(
				'description' => esc_html__('Let users subscribe to your newsletter.', 'ttbase-framework')
			));
			
			add_action( 'load-widgets.php', array( $this, 'scripts' ), 100 );
	}
	
	/**
		 * Enqueue font awesome style
		 */
		public function scripts() {
			wp_enqueue_style( 'wp-color-picker' );
	        wp_enqueue_script( 'wp-color-picker' );
	        wp_enqueue_script( 'underscore' );
		}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {

		// Extract args
		extract( $args );

		// Args
		$title            = isset( $instance['title'] ) ? $instance['title'] : '';
		$title            = apply_filters( 'widget_title', $title );
		$heading          = isset( $instance['heading'] ) ? $instance['heading'] : '';
		$email_holder_txt = ! empty( $instance['placeholder_text'] ) ? $instance['placeholder_text'] : '';
		$email_holder_txt = $email_holder_txt ? $email_holder_txt : esc_html__( 'Your email address', 'ttbase-framework' );
		$name_field       = ! empty( $instance['name_field'] ) ? true : false;
		$name_placeholder_txt  = ! empty( $instance['name_placeholder_text'] ) ? $instance['name_placeholder_text'] : '';
		$name_placeholder_txt  = $name_placeholder_txt ? $name_placeholder_txt : esc_html__( 'First name', 'ttbase-framework' );
		$button_text      = ! empty( $instance['button_text'] ) ? $instance['button_text'] : esc_html__( 'Subscribe', 'ttbase-framework' );
		$button_style     = isset( $instance['button_style'] ) ? $instance['button_style'] : '';
		$input_bg	  	  = isset( $instance['input_bg'] ) ? $instance['input_bg'] : '';
		$input_border	  = isset( $instance['input_border'] ) ? $instance['input_border'] : '';
		$input_text_color	  	  = isset( $instance['input_text_color'] ) ? $instance['input_text_color'] : '';
		$form_action      = isset( $instance['form_action'] ) ? $instance['form_action'] : '';
		$description      = isset( $instance['description'] ) ? $instance['description'] : '';

		// Before widget hook
		echo $before_widget;

		// Display widget title
		if ( $title ) {
			echo $before_title . $title . $after_title;
		}

		if ( $form_action ) { ?>

			<div class="ttbase-newsletter-widget clearfix">

				<?php
				// Display the heading
				if ( $heading ) { ?>

					<h4 class="ttbase-newsletter-widget-heading">
						<?php echo ttbase_framework_sanitize_data( $heading, 'html' ); ?>
					</h4>

				<?php } ?>

				<?php
				// Display the description
				if ( $description ) { ?>

					<div class="ttbase-newsletter-widget-description">
						<?php echo ttbase_framework_sanitize_data( $description, 'html' ); ?>
					</div>

				<?php } ?>

					<form action="<?php echo esc_url($form_action); ?>" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
						<?php $style = ''; ?>
						<?php if ($input_bg || $input_border || $input_text_color) {
							$style .= 'style="';
							
							$style .= ($input_bg) ? 'background-color:' . $input_bg . ';' : '';
							$style .= ($input_border) ? 'border-color:' . $input_border . ';' : '';
							$style .= ($input_text_color) ? 'color:' . $input_text_color . ';' : '';
							
							$style .= '"';
						} ?>
						
						<?php if ( $name_field ) : ?>
							<input type="text" class="ttbase-newsletter-widget-input" <?php echo $style; ?> value="<?php echo esc_attr($name_placeholder_txt); ?>" onfocus="if(this.value==this.defaultValue)this.value='';" onblur="if(this.value=='')this.value=this.defaultValue;" name="FNAME" id="mce-FNAME" autocomplete="off">
						<?php endif; ?>

						<input type="email" class="ttbase-newsletter-widget-input" <?php echo $style; ?> value="<?php echo esc_attr($email_holder_txt); ?>" onfocus="if(this.value==this.defaultValue)this.value='';" onblur="if(this.value=='')this.value=this.defaultValue;" name="EMAIL" id="mce-EMAIL" autocomplete="off">

						<?php echo apply_filters( 'ttbase_newsletter_widget_form_extras', null ); ?>

						<button class="btn btn-primary <?php echo sanitize_html_class($button_style); ?>" type="submit" value="" name="subscribe"><?php echo esc_attr($button_text); ?></button>
					</form>

			</div><!-- .mailchimp-widget -->

		<?php } else {

			 esc_html_e( 'Please enter your Mailchimp form action link.', 'ttbase-framework' );

		}

		// After widget hook
		echo $after_widget;
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance                     = $old_instance;
		$instance['title']            = strip_tags( $new_instance['title'] );
		$instance['heading']          = strip_tags( $new_instance['heading'] );
		$instance['description']      = $new_instance['description'];
		$instance['form_action']      = strip_tags( $new_instance['form_action'] );
		$instance['placeholder_text'] = strip_tags( $new_instance['placeholder_text'] );
		$instance['button_text']      = strip_tags( $new_instance['button_text'] );
		$instance['button_style']     = ! empty( $new_instance['button_style'] ) ? strip_tags( $new_instance['button_style'] ) : 'style-1';
		$instance['input_bg']      = strip_tags( $new_instance['input_bg'] );
		$instance['input_border']      = strip_tags( $new_instance['input_border'] );
		$instance['input_text_color']      = strip_tags( $new_instance['input_text_color'] );
		$instance['name_field']       = $new_instance['name_field'] ? 1 : 0;
		$instance['name_placeholder_text']  = strip_tags( $new_instance['name_placeholder_text'] );
		return $instance;
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {

		$instance = wp_parse_args( ( array ) $instance, array(
			'title'                 => '',
			'heading'               => esc_html__( 'Newsletter','ttbase-framework' ),
			'description'           => '',
			'form_action'           => '',
			'placeholder_text'      => esc_html__( 'Your email address', 'ttbase-framework' ),
			'button_text'           => esc_html__( 'Subscribe', 'ttbase-framework' ),
			'button_style'			=> 'style-1',
			'input_bg'				=> '',
			'input_border'			=> '',
			'input_text_color'		=> '',
			'name_placeholder_text' => esc_html__( 'First name', 'ttbase-framework' ),
			'name_field'            => 0

		) );
		$title                 = $instance['title'];
		$heading               = $instance['heading'];
		$description           = esc_attr( $instance['description'] );
		$form_action           = $instance['form_action'];
		$placeholder_text      = esc_attr( $instance['placeholder_text'] ); 
		$button_text           = esc_attr( $instance['button_text'] );
		$button_style          = esc_attr( $instance['button_style'] );
		$input_bg          	   = esc_attr( $instance['input_bg'] );
		$input_border          = esc_attr( $instance['input_border'] );
		$input_text_color      = esc_attr( $instance['input_text_color'] );
		$name_placeholder_text = esc_attr( $instance['name_placeholder_text'] );
		$name_field            = $instance['name_field']; ?>
		
		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php esc_html_e( 'Title', 'ttbase-framework' ); ?>:</label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title','ttbase-framework' )); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'heading' )); ?>"><?php esc_html_e( 'Heading', 'ttbase-framework' ); ?>:</label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'heading' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'heading','ttbase-framework' )); ?>" type="text" value="<?php echo esc_attr($heading); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'form_action' )); ?>"><?php esc_html_e( 'Form Action', 'ttbase-framework' ); ?>:</label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'form_action' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'form_action' )); ?>" type="text" value="<?php echo esc_attr($form_action); ?>" />
			<span style="display:block;padding:5px 0" class="description">
				<a href="http://docs.shopify.com/support/configuration/store-customization/where-do-i-get-my-mailchimp-form-action?ref=ttbaseplorer" target="_blank"><?php esc_html_e( 'Learn more', 'ttbase-framework' ); ?>&rarr;</a>
			</span>
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'description' )); ?>"><?php esc_html_e( 'Description:','ttbase-framework' ); ?></label>
			<textarea class="widefat" rows="5" cols="20" id="<?php echo esc_attr($this->get_field_id( 'description' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'description' )); ?>"><?php echo esc_html($instance['description']); ?></textarea>
		</p>
		<p>
			<input id="<?php echo esc_attr($this->get_field_id( 'name_field' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'name_field','ttbase-framework' )); ?>" <?php checked( $name_field, 1, true ); ?> type="checkbox" />
			<label for="<?php echo esc_attr($this->get_field_id( 'name_field' )); ?>"><?php esc_html_e( 'Display Name Field?', 'ttbase-framework' ); ?></label>
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'name_placeholder_text' )); ?>"><?php esc_html_e( 'Name Input Placeholder Text', 'ttbase-framework' ); ?>:</label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'name_placeholder_text' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'name_placeholder_text','ttbase-framework' )); ?>" type="text" value="<?php echo esc_attr($name_placeholder_text); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'placeholder_text' )); ?>"><?php esc_html_e( 'Email Input Placeholder Text', 'ttbase-framework' ); ?>:</label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'placeholder_text' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'placeholder_text','ttbase-framework' )); ?>" type="text" value="<?php echo esc_attr($placeholder_text); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'input_bg' )); ?>"><?php esc_html_e( 'Input Background Color:', 'ttbase-framework' ); ?></label>
			<div>
				<input class="color-picker widefat" type="text" id="<?php echo esc_attr($this->get_field_id( 'input_bg' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'input_bg' )); ?>" value="<?php echo esc_attr( $input_bg ); ?>" />
			</div>
			
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'input_border' )); ?>"><?php esc_html_e( 'Input Border Color:', 'ttbase-framework' ); ?></label>
			<div>
				<input class="color-picker widefat" type="text" id="<?php echo esc_attr($this->get_field_id( 'input_border' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'input_border' )); ?>" value="<?php echo esc_attr( $input_border ); ?>" />
			</div>
			
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'input_text_color' )); ?>"><?php esc_html_e( 'Input Text Color:', 'ttbase-framework' ); ?></label>
			<div>
				<input class="color-picker widefat" type="text" id="<?php echo esc_attr($this->get_field_id( 'input_text_color' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'input_text_color' )); ?>" value="<?php echo esc_attr( $input_text_color ); ?>" />
			</div>
			
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'button_text' )); ?>"><?php esc_html_e( 'Button Text', 'ttbase-framework' ); ?>:</label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'button_text' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'button_text','ttbase-framework' )); ?>" type="text" value="<?php echo esc_attr($button_text); ?>" />
		</p>
		<p>
            <label for="<?php echo esc_attr($this->get_field_id('button_style')); ?>"><?php esc_html_e( 'Button Style', 'ttbase-framework'); ?></label>
            <br />
            <select class='ttbase-widget-select' name="<?php echo esc_attr($this->get_field_name('button_style')); ?>" id="<?php echo esc_attr($this->get_field_id('button_style')); ?>">
                <option value="style-1" <?php if ( $instance['button_style'] == 'style-1' ) { ?>selected="selected"<?php } ?>><?php esc_html_e( 'Style 1', 'ttbase-framework' ); ?></option>
                <option value="style-2" <?php if ( $instance['button_style'] == 'style-2' ) { ?>selected="selected"<?php } ?>><?php esc_html_e( 'Style 2', 'ttbase-framework' ); ?></option>
            </select>
        </p>
		<?php
	}
}

// Register the recent posts grid widget
if ( ! function_exists( 'ttbase_framework_register_newsletter_widget' ) ) {
	function ttbase_framework_register_newsletter_widget() {
		register_widget( 'TTBase_Framework_Newsletter_Widget' );
	}
}
add_action( 'widgets_init', 'ttbase_framework_register_newsletter_widget' );

// Widget AJAX functions
function ttbase_framework_newsletter_widget_scripts() {
    global $pagenow;
    if ( is_admin() && $pagenow == "widgets.php" ) {
        add_action('admin_footer', 'ttbase_framework_newsletter_widget_admin_script');
        function ttbase_framework_newsletter_widget_admin_script() { ?>
            <script type="text/javascript" >
            	function initColorPicker( widget ) {
                        widget.find( '.color-picker' ).wpColorPicker( {
                                change: _.throttle( function() { // For Customizer
                                        jQuery(this).trigger( 'change' );
                                }, 3000 )
                        });
                }
	
                function onFormUpdate( event, widget ) {
                        initColorPicker( widget );
                }
                
                jQuery( document ).on( 'widget-added widget-updated', onFormUpdate );
                
                jQuery(document).ready(function($) {
                	$( '#widgets-right .widget:has(.color-picker)' ).each( function () {
                    	initColorPicker( $( this ) );
                    } );
                });
            </script>
        <?php
        }
    }
}
add_action('admin_init','ttbase_framework_newsletter_widget_scripts');