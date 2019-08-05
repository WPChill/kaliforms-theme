<?php

//Adds the admin custom pages for Theme Settings, SEO and Update
if ( ! function_exists( 'antreas_custom' ) ) {
	add_action( 'admin_menu', 'antreas_custom' );
	function antreas_custom() {
		//Get the image path for the core icon
		$core_path = get_template_directory_uri() . '/core/';
		if ( defined( 'ANTREAS_CORE' ) ) {
			$core_path = ANTREAS_CORE;
		}

		//Set up data to add admin menus
		//add_theme_page(__('Theme Options', 'antreas'), __('Theme Options', 'antreas'), 'edit_theme_options', 'cpotheme_settings', 'cpotheme_settings', $core_path.'images/icon_options.png', 50);
	}
}


//Display the options forms fields
if ( ! function_exists( 'antreas_custom_fields' ) ) {
	function antreas_custom_fields( $options, $list_name ) {
		$output      = '';
		$tab_count   = 0;
		$current_tab = '';
		if ( isset( $_GET['tab'] ) && $_GET['tab'] != '' ) {
			$current_tab = htmlentities( $_GET['tab'] );
		}
		$option_list = get_option( $list_name, false );

		foreach ( $options as $current_field_id => $current_field ) {

			//Set common attributes for each element
			$field_name  = isset( $current_field['id'] ) ? $current_field['id'] : '';
			$field_title = isset( $current_field['name'] ) ? $current_field['name'] : '';
			$field_desc  = isset( $current_field['desc'] ) ? $current_field['desc'] : '';
			$field_type  = isset( $current_field['type'] ) ? $current_field['type'] : 'separator';

			$field_value = '';
			//$field_value = get_option($field_name);
			if ( $option_list && isset( $option_list[ $field_name ] ) ) {
				$field_value = $option_list[ $field_name ];
			}

			//Is a field block separator. Print a separate container.
			if ( $field_type == 'separator' ) {
				if ( $tab_count > 0 ) :
					$output .= '<input class="cpothemes-submit button-primary" type="submit" name="cpotheme_settings_save" value="' . __( 'Save Settings', 'antreas' ) . '" />';
					$output .= '</div>';
				endif;
				$output .= '<div class="cpothemes-block" id="' . $field_name . '_block"';
				if ( ( $current_tab != '' && $current_tab != $field_name ) || ( $current_tab == '' && $tab_count > 0 ) ) {
					$output .= ' style="display:none;"';
				}
				$output .= '>';
				$output .= '<input class="cpothemes-submit button-primary" type="submit" name="cpotheme_settings_save" value="' . __( 'Save Settings', 'antreas' ) . '" />';
				$output .= '<div class="cpothemes-separator">';
				$output .= $field_title . '<br/><span class="separator-desc">' . $field_desc . '</span>';
				$output .= '</div>';
				$tab_count++;

				// Is a field divider
			} elseif ( $field_type == 'divider' ) {
				$output .= '<h3 class="cpothemes-divider">' . $field_title . '</h3>';

				//Is a normal field. Print field containers
			} else {
				$output .= '<div class="item';
				if ( $field_type == 'collection' || $field_type == 'code' ) {
					$output .= ' item-wide';
				}
				$output .= '">';
				$output .= '<label for="' . $field_name . '" class="field-title">' . $field_title . '</label>';
				$output .= '<div class="field-content">';
			}

			if ( $field_type == 'readonly' ) {
				$output .= antreas_form_readonly( $field_name, $field_value, $current_field );

			} elseif ( $field_type == 'text' ) {
				$output .= antreas_form_text( $field_name, $field_value, $current_field );

			} elseif ( $field_type == 'textarea' ) {
				$output .= antreas_form_textarea( $field_name, $field_value, $current_field );

			} elseif ( $field_type == 'code' ) {
				$output .= antreas_form_code( $field_name, $field_value, $current_field );

			} elseif ( $field_type == 'select' ) {
				$output .= antreas_form_select( $field_name, $field_value, $current_field['option'], $current_field );

			} elseif ( $field_type == 'collection' ) {
				$output .= antreas_form_collection( $field_name, $field_value, $current_field['option'], $current_field );

			} elseif ( $field_type == 'yesno' || $field_type == 'checkbox' ) {
				$output .= antreas_form_yesno( $field_name, $field_value, $current_field );

			} elseif ( $field_type == 'color' ) {
				$output .= antreas_form_color( $field_name, $field_value );

			} elseif ( $field_type == 'imagelist' ) {
				$output .= antreas_form_imagelist( $field_name, $field_value, $current_field['option'], $current_field );

			} elseif ( $field_type == 'iconlist' ) {
				$output .= antreas_form_iconlist( $field_name, $field_value, $current_field );

			} elseif ( $field_type == 'upload' ) {
				$output .= antreas_form_upload( $field_name, $field_value );

			} elseif ( $field_type == 'font' ) {
				$output .= antreas_form_font( $field_name, $field_value, $current_field['option'], $current_field );
			}

			//Separators
			if ( $field_type != 'separator' && $field_type != 'divider' ) {
				$output .= '</div>';
				$output .= '<div class="field-desc">' . $field_desc . '</div>';
				$output .= '</div>';
			}
			unset( $current_field );
		}
		$output .= '<input class="cpothemes-submit button-primary" type="submit" name="cpotheme_settings_save" value="' . __( 'Save Settings', 'antreas' ) . '" />';
		$output .= '</div>';
		echo $output;
	}
}

//Save all settings upon submitting the settings form
if ( ! function_exists( 'antreas_custom_save' ) ) {
	function antreas_custom_save( $option_name, $option_fields ) {

		$lang_url    = antreas_wpml_option_url();
		$option_name = $option_name . antreas_wpml_option_suffix();
		if ( isset( $_POST['antreas_custom_tab'] ) && $_POST['antreas_custom_tab'] != '' ) {
			$current_tab = '&tab=' . htmlentities( $_POST['antreas_custom_tab'] );
		} else {
			$current_tab = '';
		}

		//Check if we're submitting a custom page
		if ( isset( $_POST['antreas_custom_action'] ) && $_POST['antreas_custom_action'] == $option_name ) {
			if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'antreas_nonce' ) ) {
				header( 'Location: admin.php?page=' . $_GET['page'] . $lang_url . '&error' );
			}

			//Get the option array, then update the array values
			$options_list = get_option( $option_name, false );
			foreach ( $option_fields as $current_option ) {
				$field_id = $current_option['id'];

				//If the field has an update, process it.
				if ( isset( $_POST[ $field_id ] ) ) {
					$field_value = '';
					$field_value = $_POST[ $field_id ];
					if ( ! is_array( $field_value ) ) {
						$field_value = esc_attr( trim( $field_value ) );
					}

					$current_value = '';
					if ( isset( $options_list[ $field_id ] ) ) {
						$current_value = $options_list[ $field_id ];
					}

					// Add option
					if ( $current_value == '' && $field_value != '' ) {
						$options_list[ $field_id ] = $field_value;
					} // Update option
					elseif ( $field_value != $current_value ) {
						$options_list[ $field_id ] = $field_value;
					} // Delete unused option
					elseif ( $field_value == '' ) {
						//TODO: Check default values
						$options_list[ $field_id ] = $field_value;
					}
				}
			}
			update_option( $option_name, $options_list );

			header( 'Location: admin.php?page=' . $_GET['page'] . $current_tab . $lang_url . '&ok' );
		}
	}
}


//Installs options with default values, without overriding existing ones
if ( ! function_exists( 'antreas_custom_install' ) ) {
	function antreas_custom_install( $option_name, $option_fields, $overwrite ) {

		$lang_url    = antreas_wpml_option_url();
		$option_name = $option_name . antreas_wpml_option_suffix();

		//Get the option array, then update the array values
		$options_list = get_option( $option_name, false );
		foreach ( $option_fields as $current_option ) {
			if ( isset( $current_option['id'] ) ) {
				$field_id = $current_option['id'];

				//Check if there's no value already set
				//If overwrite is set, replace values always
				if ( ! isset( $options_list[ $field_id ] ) || $overwrite ) {
					//If there's no default defined, set an empty string
					if ( isset( $current_option['std'] ) ) {
						$field_default = $current_option['std'];
					} else {
						$field_default = '';
					}

					$options_list[ $field_id ] = $field_default;
				}
			}
		}
		update_option( $option_name, $options_list );
	}
}

//Create navigation menu for settings page
if ( ! function_exists( 'antreas_wpml_nav' ) ) {
	function antreas_wpml_nav() {
		$output = '';
		if ( antreas_wpml_active() ) {
			$language_list = antreas_wpml_languages();

			//Get current language
			if ( isset( $_GET['lang'] ) ) {
				$active_language = trim( htmlentities( $_GET['lang'] ) );
			} else {
				$active_language = antreas_wpml_default_language();
			}

			$output     = '';
			$first_link = true;
			foreach ( $language_list as $current_language ) {
				$language_code   = $current_language['code'];
				$language_name   = $current_language['display_name'];
				$language_active = false;
				//Disable link for default language
				if ( $active_language == $language_code ) {
					$language_active = true;
				}

				if ( ! $first_link ) {
					$output .= ' | ';
				}

				if ( $language_active ) {
					$output .= '<span><b>';
				} else {
					$output .= '<a href="admin.php?page=' . $_GET['page'] . '&lang=' . $language_code . '">';
				}

				$output .= $language_name;
				if ( antreas_wpml_default_language() == $language_code ) {
					$output .= ' (' . __( 'default', 'antreas' ) . ')';
				}

				if ( $language_active ) {
					$output .= '</b></span>';
				} else {
					$output .= '</a>';
				}

				$first_link = false;
			}
			return $output;
		}
	}
}

//Check if WPML is present and append language code to option array
//The default language should not be appended
if ( ! function_exists( 'antreas_wpml_option_suffix' ) ) {
	function antreas_wpml_option_suffix() {
		$language_code = '';
		if ( antreas_wpml_active() ) {
			if ( isset( $_GET['lang'] ) && $_GET['lang'] != '' ) {
				$default_language = antreas_wpml_default_language();
				$active_language  = trim( htmlentities( $_GET['lang'] ) );
				if ( $active_language != $default_language ) {
					$language_code = '_' . $active_language;
				}
			}
		}
		return $language_code;
	}
}

//Return the language url for page redirections, empty if default language
if ( ! function_exists( 'antreas_wpml_option_url' ) ) {
	function antreas_wpml_option_url() {
		$lang_url = '';
		if ( antreas_wpml_active() ) {
			if ( isset( $_GET['lang'] ) && $_GET['lang'] != '' ) {
				$default_language = antreas_wpml_default_language();
				$active_language  = trim( htmlentities( $_GET['lang'] ) );
				if ( $active_language != $default_language ) {
					$lang_url = '&lang=' . $active_language;
				}
			}
		}
		return $lang_url;
	}
}
