<?php
/**
 * Modification of the richard Featured Page Widget
 * to add customizable text area option.
 *
 */


add_action( 'widgets_init', create_function( '', "register_widget('WSM_Title_Widget');" ) );


class WSM_Title_Widget extends WP_Widget {

	/**
	 * Constructor. Set the default widget options and create widget.
	 */
	function __construct() {
		$widget_ops = array( 'classname' => 'wsm-title-widget', 'description' => __('Displays Title text in choice of heading tag', 'richard') );
		$control_ops = array( 'width' => 200, 'height' => 250, 'id_base' => 'wsm-title-widget' );
		parent::__construct( 'wsm-title-widget', __('Web Savvy - Title', 'richard'), $widget_ops, $control_ops );
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
		) );

		$before_title = '<' . $instance['heading-tag'] . ' class="widgettitle widget-title">';
		$after_title = '</' . $instance['heading-tag'] . '>';

		// WMPL
		/**
		 * Filter strings for WPML translation
     	 */
     	$instance['title'] = apply_filters( 'wpml_translate_single_string', $instance['title'], 'Widgets', 'Web Savvy - Title - Title' );
     	// WPML

		echo $before_widget;

		if ( ! empty( $instance['title'] ) )
			echo $before_title . apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base ) . $after_title;

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
		$new_instance['heading-tag'] = stripslashes( $new_instance['heading-tag'] );

		//WMPL
		/**
		 * register strings for translation
     	 */
	 	do_action( 'wpml_register_single_string', 'Widgets', 'Web Savvy - Title - Title', $new_instance['title'] );
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
			'heading-tag' => '',
		) );

?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', 'richard' ); ?></label>
			<input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" class="widefat" />
		</p>

		<p><label for="<?php echo $this->get_field_id('heading-tag'); ?>"><?php _e('Heading Tag', 'richard'); ?></label>
			<select id="<?php echo $this->get_field_id('heading-tag'); ?>" name="<?php echo $this->get_field_name('heading-tag'); ?>">
				<option value="h3" <?php selected('h3', $instance['heading-tag']); ?>><?php _e('H3', 'richard'); ?></option>
				<option value="h2" <?php selected('h2', $instance['heading-tag']); ?>><?php _e('H2', 'richard'); ?></option>
				<option value="h1" <?php selected('h1', $instance['heading-tag']); ?>><?php _e('H1', 'richard'); ?></option>
				<option value="h4" <?php selected('h4', $instance['heading-tag']); ?>><?php _e('H4', 'richard'); ?></option>
				<option value="h5" <?php selected('h5', $instance['heading-tag']); ?>><?php _e('H5', 'richard'); ?></option>
				<option value="h6" <?php selected('h6', $instance['heading-tag']); ?>><?php _e('H6', 'richard'); ?></option>
			</select>
		</p>

	<?php
	}
}