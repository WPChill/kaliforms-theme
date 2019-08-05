<?php

//Add default metaboxes to posts
add_action( 'add_meta_boxes', 'antreas_metaboxes' );
function antreas_metaboxes() {
	add_meta_box( ANTREAS_SLUG . '_post_metabox', __( 'Post Options', 'modula' ), 'antreas_display_post_metabox', 'post', 'side', 'high' );

	$post_types     = get_post_types( array( 'public' => true ), 'names' );
	foreach ( $post_types as $current_type ) {
		add_meta_box( ANTREAS_SLUG . '_layout_metabox', __( 'Layout Options', 'modula' ), 'antreas_display_layout_metabox', $current_type, 'side', 'high' );
	}

	add_meta_box( ANTREAS_SLUG . '_pricing_info_metabox', __( 'Pricing Info', 'modula' ), 'antreas_display_pricing_info_metabox', 'download', 'side', 'low' );
}

//Display and save post metaboxes
function antreas_display_post_metabox( $post ) {
	antreas_meta_fields( $post, antreas_metadata_post_options() );
}
function antreas_display_layout_metabox( $post ) {
	antreas_meta_fields( $post, antreas_metadata_layout_options() );
}
function antreas_display_pricing_info_metabox( $post ) {
	antreas_meta_fields( $post, antreas_metadata_download_pricing_info() );
}


add_action( 'edit_post', 'antreas_metaboxes_save' );
function antreas_metaboxes_save( $post ) {
	antreas_meta_save( antreas_metadata_post_options() );
	antreas_meta_save( antreas_metadata_layout_options() );
	antreas_meta_save( antreas_metadata_download_pricing_info() );
}


// Prints meta field HTML
function antreas_meta_fields( $post, $metadata = null ) {

	if ( $metadata == null || count( $metadata ) == 0 ) {
		return;
	}

	$output = '';

	wp_enqueue_style( ANTREAS_SLUG . '-admin' );
	wp_nonce_field( 'antreas_savemeta', 'antreas_nonce' );

	foreach ( $metadata as $meta ) {

		$meta_value = st_get_post_meta( $post->ID, $meta['name'] ) !== '' ? st_get_post_meta( $post->ID, $meta['name'] ) : $meta['default'];

		$output .= '<div class="mt-components-base-control components-base-control">';
			$output .= '<div class="components-base-control__field">';

			// Print metaboxes here. Develop different cases for each type of field.
			switch ( $meta['type'] ) :
				case 'select':
					$output .= antreas_form_select( $meta, $meta_value );
					break;
				case 'checkbox':
					$output .= antreas_form_checkbox( $meta, $meta_value );
					break;
				case 'text':
					$output .= antreas_form_text( $meta, $meta_value );
					break;
				case 'textarea':
					$output .= antreas_form_textarea( $meta, $meta_value );
					break;
			endswitch;

			$output .= '</div>';
		$output .= '</div>';
		//$output .= '<div class="desc">' . $field_desc . '</div></div>';
	}
	echo $output;
}


// Saves meta field data into database
function antreas_meta_save( $options ) {

	$post_id   = $_POST['post_ID'];

 	if ( ! isset( $_POST['post_ID'] ) || ! current_user_can( 'edit_posts' ) ) {
		return;
	}

 	if ( ! wp_verify_nonce( $_POST['antreas_nonce'], 'antreas_savemeta' ) ) {
		return;
	}

	//Check if we're editing a post
	if ( ! isset( $_POST['action'] ) || $_POST['action'] != 'editpost' ) {
		return;
	}

	//Check every option, and process the ones there's an update for.
	foreach ( $options as $option ) :

		$option_value = $_POST[ ANTREAS_SLUG . '_' . $option['name'] ];

		// do some modifications on some types.
		switch ( $option['type'] ) :
			case 'checkbox':
				$option_value = ( $option_value === '1' ) ? '1' : '0';
				break;
		endswitch;

		//If the field has an update, exit.
 		if ( ! isset( $option_value ) ) {
			return;
		}

		update_post_meta( $post_id, ANTREAS_SLUG . '_' . $option['name'], $option_value );

	endforeach;
}
