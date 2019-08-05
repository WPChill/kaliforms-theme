<?php

//select list
if ( ! function_exists( 'antreas_form_select' ) ) {
	function antreas_form_select( $meta, $value ) {
		ob_start(); ?>

			<label class="components-base-control__label" for="<?php echo esc_attr( ANTREAS_SLUG . '_' . $meta['name'] ); ?>"><?php echo esc_html( $meta['label'] ); ?></label>
			<select class="components-select-control__input" name="<?php echo esc_attr( ANTREAS_SLUG . '_' . $meta['name'] ); ?>" id="<?php echo esc_attr( ANTREAS_SLUG . '_' . $meta['name'] ); ?>">
				<?php foreach ( $meta['options'] as $key => $label ) : ?>
					<option value="<?php echo esc_attr( $key );  ?>" <?php selected( $key, $value ); ?>><?php echo esc_html( $label );  ?></option>
				<?php endforeach; ?>
			</select>

		<?php
		return ob_get_clean();
	}
}

//Checkbox field
if ( ! function_exists( 'antreas_form_checkbox' ) ) {
	function antreas_form_checkbox( $meta, $value ) {
		ob_start(); ?>

			<input class="components-checkbox-control__input" id="<?php echo esc_attr( ANTREAS_SLUG . '_' . $meta['name'] ); ?>" name="<?php echo esc_attr( ANTREAS_SLUG . '_' . $meta['name'] ); ?>" type="checkbox" value="1" <?php checked( $value, '1' ); ?>>
			<label for="<?php echo esc_attr( ANTREAS_SLUG . '_' . $meta['name'] ); ?>"><?php echo esc_html( $meta['label'] ); ?></label>

		<?php
		return ob_get_clean();
	}
}

//Input.
if ( ! function_exists( 'antreas_form_text' ) ) {
	function antreas_form_text( $meta, $value ) {
		ob_start(); ?>

			<strong><label for="<?php echo esc_attr( ANTREAS_SLUG . '_' . $meta['name'] ); ?>"><?php echo esc_html( $meta['label'] ); ?></label></strong>
			<br/>
			<input class="components-checkbox-control__input" id="<?php echo esc_attr( ANTREAS_SLUG . '_' . $meta['name'] ); ?>" name="<?php echo esc_attr( ANTREAS_SLUG . '_' . $meta['name'] ); ?>" type="text" value="<?php echo $value; ?>">

		<?php
		return ob_get_clean();
	}
}

//Textarea
if ( ! function_exists( 'antreas_form_textarea' ) ) {
	function antreas_form_textarea( $meta, $value ) {
		ob_start(); ?>

			<strong><label for="<?php echo esc_attr( ANTREAS_SLUG . '_' . $meta['name'] ); ?>"><?php echo esc_html( $meta['label'] ); ?></label></strong>
			<br/>
			<textarea class="components-checkbox-control__textarea" id="<?php echo esc_attr( ANTREAS_SLUG . '_' . $meta['name'] ); ?>" name="<?php echo esc_attr( ANTREAS_SLUG . '_' . $meta['name'] ); ?>"><?php echo $value; ?></textarea>

		<?php
		return ob_get_clean();
	}
}


