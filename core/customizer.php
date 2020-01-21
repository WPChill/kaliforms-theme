<?php

//Generate settings
add_action( 'customize_register', 'modula_customizer' );
function modula_customizer( $customize ) {

	//Add sections to the customizer
	$settings = modula_metadata_sections();
	foreach ( $settings as $setting_id => $setting_data ) {
		$customize->add_section( $setting_id, $setting_data );
	}

	//Add settings & controls
	$settings = modula_metadata_customizer();
	foreach ( $settings as $setting_id => $setting_data ) {

		$default      = isset( $setting_data['default'] ) ? $setting_data['default'] : '';

		$optionsets = array( 'default' => 'default' );

		$setting_args = array(
			'type'       => 'option',
			'default'    => $default,
			'capability' => 'edit_theme_options',
			'transport'  => 'refresh',
		);
		if ( isset( $setting_data['sanitize'] ) && $setting_data['sanitize'] != '' ) {
			$setting_args['sanitize_callback'] = $setting_data['sanitize'];
		}

		foreach ( $optionsets as $current_language => $current_language_name ) {

			$args         = $setting_data;
			$option_array = 'modula_settings';
			$control_id   = $setting_id;

			//Add setting to the customizer
			$customize->add_setting( $option_array . '[' . $setting_id . ']', $setting_args );

			//Define control metadata
			$args['settings'] = $option_array . '[' . $setting_id . ']';

			switch ( $args['type'] ) {
				case 'text':
				case 'textarea':
				case 'select':
					$customize->add_control( 'modula_' . $control_id, $args );
					break;
				case 'color':
					$customize->add_control( new WP_Customize_Color_Control( $customize, 'modula_' . $control_id, $args ) );
					break;
				case 'image':
					$customize->add_control( new WP_Customize_Image_Control( $customize, 'modula_' . $control_id, $args ) );
					break;
				case 'collection':
					$customize->add_control( new CPO_Customize_Collection_Control( $customize, 'modula_' . $control_id, $args ) );
					break;
				case 'checkbox':
					$args['type'] = 'epsilon-toggle';
					$customize->add_control( new Epsilon_Control_Toggle( $customize, 'modula_' . $control_id, $args ) );
					break;
				case 'dimensions':
					$args['type'] = 'modula-dimensions-control';
					$customize->add_control( new modula_Customize_Dimensions_Control( $customize, 'modula_' . $control_id, $args ) );
					break;
				case 'sortable':
					$customize->add_control( new modula_Customize_Sortable_Control( $customize, 'modula_' . $control_id, $args ) );
					break;
				case 'selectize':
					$args['type'] = 'mt-selectize-control';
					$customize->add_control( new MT_Customize_Selectize_Control( $customize, 'modula_' . $control_id, $args ) );
					break;
				case 'tinymce':
					$args['type'] = 'mt-tinymce-control';
					$customize->add_control( new MT_Customize_TinyMCE_Control( $customize, 'modula_' . $control_id, $args ) );
					break;
			}


		}
	}



}

