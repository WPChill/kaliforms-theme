<?php

function antreas_metadata_post_options() {

	$data = array();

	$data['layout'] = array(
		'name'   => 'layout',
		'label'  => __( 'Layout', 'modula' ),
		'type'   => 'select',
		'options' => array(
			'default' => __( 'default', 'modula' ),
			'no-sidebar' => __( 'no-sidebar', 'modula' ),
		),
		'default'    => 'default',
	);

	$data['display_authorbox'] = array(
		'name'   => 'display_authorbox',
		'label'  => __( 'Display Author Box', 'modula' ),
		'type'   => 'checkbox',
		'default'    => '1',
	);

	$data['display_newsletter'] = array(
		'name'   => 'display_newsletter',
		'label'  => __( 'Display Newsletter Signup', 'modula' ),
		'type'   => 'checkbox',
		'default'    => '1',
	);

	return apply_filters( 'antreas_metadata_layout', $data );

}


function antreas_metadata_layout_options() {

	$data = array();

	$data['footer_type'] = array(
		'name'   => 'footer_type',
		'label'  => __( 'Footer type', 'modula' ),
		'type'   => 'select',
		'options' => array(
			'default' => __( 'default', 'modula' ),
			'simple' => __( 'simple', 'modula' ),
		),
		'default'    => 'default',
	);

	return apply_filters( 'antreas_metadata_layout', $data );
}



function antreas_metadata_download_pricing_info() {

	$data = array();

	$data['pricing_title'] = array(
		'name'   => 'pricing_title',
		'label'  => __( 'Pricing Title', 'modula' ),
		'type'   => 'text',
		'default'    => '',
	);

	$data['tooltip'] = array(
		'name'   => 'tooltip',
		'label'  => __( 'Tooltip Text', 'modula' ),
		'type'   => 'textarea',
		'default'    => '',
	);

	return $data;
}