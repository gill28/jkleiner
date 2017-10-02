<?php
/**
 * Adds the Call to Action widget.
 *
 */

add_action( 'widgets_init', create_function( '', "register_widget('WSM_Call_to_Action_Bar');" ) );

class WSM_Call_to_Action_Bar extends WP_Widget {

	/**
	 * Constructor. Set the default widget options and create widget.
	 */
	function __construct() {
		$widget_ops = array( 'classname' => 'call-to-action-bar', 'description' => __('Displays call to action links', 'richard') );
		parent::__construct( 'call-to-action_bar', __('Web Savvy - CTA Bar', 'richard'), $widget_ops );
	}

	/**
	 * Echo the widget content.
	 *
	 * @param array $args Display arguments including before_title, after_title, before_widget, and after_widget.
	 * @param array $instance The settings for the particular instance of the widget
	 */
	function widget($args, $instance) {
		extract($args);

		$instance = wp_parse_args( (array)$instance, array(
			'cta-text' => '',
			'cta-button-text' => '',
			'cta-url' => '',
			'cta-target' => '',
		) );

		// WMPL
		/**
		 * Filter strings for WPML translation
     	 */
     	$instance['cta-text'] = apply_filters( 'wpml_translate_single_string', $instance['cta-text'], 'Widgets', 'Web Savvy - CTA Bar - Text Content' );
     	$instance['cta-button-text'] = apply_filters( 'wpml_translate_single_string', $instance['cta-button-text'], 'Widgets', 'Web Savvy - CTA Bar - Call To Action Button' );
     	$instance['cta-url'] = apply_filters( 'wpml_translate_single_string', $instance['cta-url'], 'Widgets', 'Web Savvy - CTA Bar - Call To Action URL' );
     	// WPML

		echo $before_widget;

			if( !empty($instance['cta-text'])) {
			$text = wp_kses_post($instance['cta-text']);
				echo '<h2 class="cta">'. $text .'</h2>';
			}

			$link_target = '';
			if ($instance['cta-target']) $link_target = 'target="_blank"';

			if( !empty($instance['cta-button-text']) && !empty($instance['cta-url']) ) {
			 echo '<div class="more-link"><a href="'. esc_url( $instance['cta-url'] ) .'" title="'. strip_tags( $instance['cta-text'] ) .'" '. $link_target .'>'. strip_tags( $instance['cta-button-text'] ) .'</a></div>';
			}

		echo $after_widget;
	}

	/** Update a particular instance.
	 *
	 * This function should check that $new_instance is set correctly.
	 * The newly calculated value of $instance should be returned.
	 * If "false" is returned, the instance won't be saved/updated.
	 *
	 * @param array $new_instance New settings for this instance as input by the user via form()
	 * @param array $old_instance Old settings for this instance
	 * @return array Settings to save or bool false to cancel saving
	 */
	function update($new_instance, $old_instance) {
		$new_instance['cta-text'] = stripslashes( wp_filter_post_kses( addslashes($new_instance['cta-text']) ) );
		$new_instance['cta-button-text'] = strip_tags( $new_instance['cta-button-text'] );
		$new_instance['cta-url'] = esc_url( $new_instance['cta-url'] );
		$new_instance['cta-target'] = strip_tags( $new_instance['cta-target'] );

		//WMPL
		/**
		 * register strings for translation
     	 */
	 	do_action( 'wpml_register_single_string', 'Widgets', 'Web Savvy - CTA Bar - Text Content', $new_instance['cta-text'] );
	 	do_action( 'wpml_register_single_string', 'Widgets', 'Web Savvy - CTA Bar - Call to Action Button', $new_instance['cta-button-text'] );
	 	do_action( 'wpml_register_single_string', 'Widgets', 'Web Savvy - CTA Bar - Call To Action URL', $new_instance['cta-url'] );
	 	//WMPL

		return $new_instance;
	}

	/** Echo the settings update form.
	 *
	 * @param array $instance Current settings
	 */
	function form($instance) {

		$instance = wp_parse_args( (array)$instance, array(
			'cta-text' => '',
			'cta-button-text' => '',
			'cta-url' => '',
			'cta-target' => '',
		) );

		$text = esc_attr($instance['cta-text']);

?>


		<p><label for="<?php echo $this->get_field_id( 'cta-text' ); ?>"><?php _e( 'Text Content', 'richard' ); ?></label>
		<textarea class="widefat" rows="2" cols="10" id="<?php echo $this->get_field_id( 'cta-text' ); ?>" name="<?php echo $this->get_field_name( 'cta-text' ); ?>"><?php echo $text; ?></textarea>

		<p>
		<label for="<?php echo $this->get_field_id( 'cta-button-text' ); ?>"><?php _e('Call To Action Button', 'richard' ); ?></label><br />
		<input type="text" id="<?php echo $this->get_field_id( 'cta-button-text' ); ?>" name="<?php echo $this->get_field_name( 'cta-button-text' ); ?>" value="<?php echo esc_attr( $instance['cta-button-text'] ); ?>" class="widefat" />
		</p>

		<p>
		<label for="<?php echo $this->get_field_id( 'cta-url' ); ?>"><?php _e( 'Call To Action URL', 'richard' ); ?></label><br />
		<input type="text" id="<?php echo $this->get_field_id( 'cta-url' ); ?>" name="<?php echo $this->get_field_name( 'cta-url' ); ?>" value="<?php echo esc_url( $instance['cta-url'] ); ?>" class="widefat" />
		</p>

		<p>
		<input id="<?php echo $this->get_field_id( 'cta-target' ); ?>" type="checkbox" name="<?php echo $this->get_field_name( 'cta-target' ); ?>" value="1" <?php checked( $instance['cta-target'] ); ?>/>
		<label for="<?php echo $this->get_field_id( 'cta-target' ); ?>"><?php _e( '	Open link in a new window/tab?', 'richard' ); ?></label>
		</p>

	<?php
	}
}