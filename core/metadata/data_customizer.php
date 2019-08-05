<?php

//Define customizer sections
if ( ! function_exists( 'modula_metadata_sections' ) ) {
	function modula_metadata_sections() {
		$data = array();

		$data['modula_topbar_section'] = array(
			'title'       => __( 'Top Bar', 'modula' ),
			'description' => '',
			'capability'  => 'edit_theme_options',
			'priority'    => 45,
		);

		return $data;
	}
}


if ( ! function_exists( 'modula_metadata_customizer' ) ) {
	function modula_metadata_customizer( $std = null ) {
		$data = array();

		$data['top_bar_content'] = array(
			'label'    => __( 'Top Bar content', 'modula' ),
			'section'  => 'modula_topbar_section',
			'type'     => 'textarea',
			//'sanitize' => 'esc_html',
			'default'  => '',
		);

		return $data;
	}
}
