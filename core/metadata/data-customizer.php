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
			'type'         => 'tinymce',
			'default'      => '',
		);

		$data['top_bar_include'] = array(
			'label'        => __( 'Display section', 'modula' ),
			'description'  => __( 'this section will be displayed on these pages. You can even type in post ids (e.g. #123)', 'modula' ),
			'section'      => 'modula_topbar_section',
			'type'         => 'selectize',
			'choices'      => 'all',
			'default'      => array(),
		);

		$data['top_bar_exclude'] = array(
			'label'        => __( 'Exclude from', 'modula' ),
			'description'  => __( 'this section will not be displayed on these pages. You can even type in post ids (e.g. #123)', 'modula' ),
			'section'      => 'modula_topbar_section',
			'type'         => 'selectize',
			'choices'      => 'all',
			'default'      => array(),
		);

		$data['top_bar_bg_color'] = array(
			'label'       => __( 'Background Color', 'modula' ),
			'section'     => 'modula_topbar_section',
			'type'        => 'color',
			'sanitize'    => 'sanitize_hex_color',
			'default'     => '',
		);

		$data['top_bar_btn_bg_color'] = array(
			'label'       => __( 'Button Background Color', 'modula' ),
			'section'     => 'modula_topbar_section',
			'type'        => 'color',
			'sanitize'    => 'sanitize_hex_color',
			'default'     => '#2ebf91',
		);

		//Colors
		$data['primary_color'] = array(
			'label'       => __( 'Primary Color', 'modula' ),
			'description' => __( 'Used in buttons, headings, and other prominent elements.', 'modula' ),
			'section'     => 'colors',
			'type'        => 'color',
			'sanitize'    => 'sanitize_hex_color',
			'default'     => '#8165ba',
		);

		$data['secondary_color'] = array(
			'label'       => __( 'Secondary Color', 'modula' ),
			'description' => __( 'Used in minor design elements and backgrounds.', 'modula' ),
			'section'     => 'colors',
			'type'        => 'color',
			'sanitize'    => 'sanitize_hex_color',
			'default'     => '#2ebf91',
		);

		return $data;
	}
}
