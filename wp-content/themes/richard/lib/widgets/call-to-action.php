<?php
/**
 * Modification of the richard Featured Page Widget
 * to add customizable text area option.
 *
 */


add_action( 'widgets_init', create_function( '', "register_widget('WSM_CTA_Widget');" ) );


class WSM_CTA_Widget extends WP_Widget {

	/**
	 * Constructor. Set the default widget options and create widget.
	 */
	function __construct() {
		$widget_ops = array( 'classname' => 'wsm-cta-widget', 'description' => __('Displays icons and customizable headline and Link', 'richard') );
		$control_ops = array( 'width' => 200, 'height' => 250, 'id_base' => 'wsm-sidebar-cta-widget' );
		parent::__construct( 'wsm-sidebar-cta-widget', __('Web Savvy - CTA', 'richard'), $widget_ops, $control_ops );
	}

	/**
	 * Echo the widget content.
	 *
	 * @param array $args Display arguments including before_title, after_title, before_widget, and after_widget.
	 * @param array $instance The settings for the particular instance of the widget
	 */
	function widget($args, $instance) {

		extract($args);

		$instance = wp_parse_args( (array) $instance, array(
			'title' => '',
			'wsm-morelink' => '',
			'wsm-moretarget' => '',
			'wsm-cta-icon' => '',
			'wsm-cta-icon-html' => '',
			'wsm-cta-icon-url' => '',
		) );

		$before_title = $after_title = '';

		// WMPL
		/**
		 * Filter strings for WPML translation
     	 */
     	$instance['title'] = apply_filters( 'wpml_translate_single_string', $instance['title'], 'Widgets', 'Web Savvy - CTA - Title' );
     	$instance['wsm-morelink'] = apply_filters( 'wpml_translate_single_string', $instance['wsm-morelink'], 'Widgets', 'Web Savvy - CTA - Link' );
     	$instance['wsm-cta-icon'] = apply_filters( 'wpml_translate_single_string', $instance['wsm-cta-icon'], 'Widgets', 'Web Savvy - CTA - Included Icon' );
     	$instance['wsm-cta-icon-html'] = apply_filters( 'wpml_translate_single_string', $instance['wsm-cta-icon-html'], 'Widgets', 'Web Savvy - CTA - HTML Icon' );
     	$instance['wsm-cta-icon-url'] = apply_filters( 'wpml_translate_single_string', $instance['wsm-cta-icon-url'], 'Widgets', 'Web Savvy - CTA - Icon URL' );
     	// WPML

		echo $before_widget;

			// Set up the CTA's

			echo '<div class="cta-wrap">';

			// CTA 1

			//if (!empty( $instance['wsm-title'] ) ) {

			echo '<div class="cta-box cta-box">';

			if (!empty( $instance['wsm-morelink'] ) ) {	echo'<a href="'. esc_attr( $instance['wsm-morelink'] ) . '" target="'. $instance['wsm-moretarget'] .'">'; }

			else {	echo'<a href="#">'; }

					if (!empty( $instance['wsm-cta-icon'] ) ) {
						$icon1 = wp_kses_post($instance['wsm-cta-icon']);
								echo '<span class="' . $icon1 . ' cta-icon">Icon</span>';
					}

					elseif (!empty( $instance['wsm-cta-icon-html'] ) ) {
						$icon2 = wp_kses_post($instance['wsm-cta-icon-html']);
								echo $icon2;
					}

					elseif ( !empty( $instance['wsm-cta-icon-url'] ) ) {
						echo '<img class="cta-icon" height="52" width="64" src="'. esc_attr( $instance['wsm-cta-icon-url'] ) . '" alt="'. strip_tags( $instance['wsm-title'] ) . '"/>';
					}

					//$title1 = wp_kses_post($instance['wsm-title']);

						echo '<span class="cta-title">';
							//echo $title1 ;
							if ( ! empty( $instance['title'] ) )
			echo $before_title . apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base ) . $after_title;
						echo '</span>';

				echo'</a>';

				echo '</div>';

			//}

			echo '</div>';

			echo "\n\n";


		echo $after_widget;
		wp_reset_query();
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
		$new_instance['title']     = strip_tags( $new_instance['title'] );
		$new_instance['wsm-morelink'] = strip_tags( $new_instance['wsm-morelink'] );
		$new_instance['wsm-moretarget'] = strip_tags( $new_instance['wsm-moretarget'] );
		$new_instance['wsm-cta-icon'] = stripslashes( $new_instance['wsm-cta-icon'] );
		$new_instance['wsm-cta-icon-html'] = stripslashes( $new_instance['wsm-cta-icon-html'] );
		$new_instance['wsm-cta-icon-url'] = strip_tags( $new_instance['wsm-cta-icon-url'] );;

		//WMPL
		/**
		 * register strings for translation
     	 */
	 	do_action( 'wpml_register_single_string', 'Widgets', 'Web Savvy - CTA - Title', $new_instance['title'] );
	 	do_action( 'wpml_register_single_string', 'Widgets', 'Web Savvy - CTA - Link', $new_instance['wsm-morelink'] );
	 	do_action( 'wpml_register_single_string', 'Widgets', 'Web Savvy - CTA - Included Icon', $new_instance['wsm-cta-icon'] );
	 	do_action( 'wpml_register_single_string', 'Widgets', 'Web Savvy - CTA - HTML Icon', $new_instance['wsm-cta-icon-html'] );
	 	do_action( 'wpml_register_single_string', 'Widgets', 'Web Savvy - CTA - Icon URL', $new_instance['wsm-cta-icon-url'] );
	 	//WMPL

		return $new_instance;
	}

	/** Echo the settings update form.
	 *
	 * @param array $instance Current settings
	 */
	function form($instance) {

		$instance = wp_parse_args( (array)$instance, array(
			'title' => '',
			'wsm-morelink' => '',
			'wsm-moretarget' => '',
			'wsm-cta-icon' => '',
			'wsm-cta-icon-html' => '',
			'wsm-cta-icon-url' => '',
		) );


		$icon_html = esc_textarea($instance['wsm-cta-icon-html']);

?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', 'richard' ); ?></label>
			<input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" class="widefat" />
		</p>

		<p><label for="<?php echo $this->get_field_id('wsm-morelink'); ?>"><?php _e('Link', 'richard'); ?></label>
		<input type="text" id="<?php echo $this->get_field_id('wsm-morelink'); ?>" name="<?php echo $this->get_field_name('wsm-morelink'); ?>" value="<?php echo esc_attr( $instance['wsm-morelink'] ); ?>" class="widefat" /></p>

		<p><label for="<?php echo $this->get_field_id('wsm-moretarget'); ?>"><?php _e('Link Target', 'richard'); ?></label>
			<select id="<?php echo $this->get_field_id('wsm-moretarget'); ?>" name="<?php echo $this->get_field_name('wsm-moretarget'); ?>">
				<option value="_self" <?php selected('_self', $instance['wsm-moretarget']); ?>><?php _e('_self', 'richard'); ?></option>
				<option value="_blank" <?php selected('_blank', $instance['wsm-moretarget']); ?>><?php _e('_blank', 'richard'); ?></option>
			</select>
		</p>

		<hr style=" height: 2px; border-top: 1px solid #CCC; margin-bottom: 10px;">

		<p><?php _e( 'Use either an Included Icon, HTML Icon from Google Material Icons or Genericons, or your uploaded image Icon URL below', 'richard' ); ?></p>

		<p><label for="<?php echo $this->get_field_id('wsm-cta-icon'); ?>"><?php _e('Included Icon', 'richard'); ?></label>
			<select id="<?php echo $this->get_field_id('wsm-cta-icon'); ?>" name="<?php echo $this->get_field_name('wsm-cta-icon'); ?>">
				<option value="" <?php selected('none', $instance['wsm-cta-icon']); ?>><?php _e('none', 'richard'); ?></option>
				<option value="bankruptcy" <?php selected('bankruptcy', $instance['wsm-cta-icon']); ?>><?php _e('bankruptcy', 'richard'); ?></option>
				<option value="corporate-law" <?php selected('corporate-law', $instance['wsm-cta-icon']); ?>><?php _e('corporate-law', 'richard'); ?></option>
				<option value="employment-law" <?php selected('employment-law', $instance['wsm-cta-icon']); ?>><?php _e('employment-law', 'richard'); ?></option>
				<option value="estate-planning" <?php selected('estate-planning', $instance['wsm-cta-icon']); ?>><?php _e('estate-planning', 'richard'); ?></option>
				<option value="litagation" <?php selected('litagation', $instance['wsm-cta-icon']); ?>><?php _e('litagation', 'richard'); ?></option>
				<option value="realestate-law" <?php selected('realestate-law', $instance['wsm-cta-icon']); ?>><?php _e('realestate-law', 'richard'); ?></option>
				<option value="tax-law" <?php selected('tax-law', $instance['wsm-cta-icon']); ?>><?php _e('tax-law', 'richard'); ?></option>
			</select>
		</p>

		<p><label for="<?php echo $this->get_field_id( 'wsm-cta-icon-html' ); ?>"><?php _e( 'HTML Icon', 'richard' ); ?></label>
		<textarea class="widefat" rows="2" cols="10" id="<?php echo $this->get_field_id( 'wsm-cta-icon-html' ); ?>" name="<?php echo $this->get_field_name( 'wsm-cta-icon-html' ); ?>"><?php echo $icon_html; ?></textarea>
		</p>

		<p><label for="<?php echo $this->get_field_id('wsm-cta-icon-url'); ?>"><?php _e('Icon url ', 'richard'); ?></label>
		<input type="text" id="<?php echo $this->get_field_id('wsm-cta-icon-url'); ?>" name="<?php echo $this->get_field_name('wsm-cta-icon-url'); ?>" value="<?php echo esc_attr( $instance['wsm-cta-icon-url'] ); ?>" class="widefat" />
		<br /><small><em><?php _e( 'Recommended size: 64px by 64px.', 'richard' ); ?></em></small>
		</p>

	<?php
	}
}