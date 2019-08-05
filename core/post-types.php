<?php

add_action( 'init', 'modula_register_post_types' );
function modula_register_post_types() {

	$args = array(
		'label'                 => esc_html__( 'Knowledge Base', 'modula' ),
		'description'           => esc_html__( 'knowledge base articles', 'modula' ),
		'supports'              => array( 'title', 'editor', 'thumbnail', 'author' ),
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 25,
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => false,
		'can_export'            => true,
		'has_archive'           => true,
		'rewrite'               => array( 'slug' => 'knowledgebase', 'with_front' => true ),
		'show_in_rest'          => true,
	);

	register_post_type( 'knowledge-base', $args );
}