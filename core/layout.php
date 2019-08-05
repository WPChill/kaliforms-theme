<?php
// Registers all widget areas
add_action( 'widgets_init', 'antreas_init_sidebar' );
function antreas_init_sidebar() {

	register_sidebar(
		array(
			'name'          => __( 'Default Widgets', 'antreas' ),
			'id'            => 'primary-widgets',
			'description'   => __( 'Sidebar shown in all standard pages by default.', 'antreas' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h6 class="widget-title">',
			'after_title'   => '</h6>',
		)
	);

	register_sidebar(
		array(
			'name'          => __( 'Secondary Widgets', 'antreas' ),
			'id'            => 'secondary-widgets',
			'description'   => __( 'Shown in pages with more than one sidebar.', 'antreas' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h6 class="widget-title">',
			'after_title'   => '</h6>',
		)
	);

	register_sidebar(
		array(
			'name'          => __( 'Blog Widgets', 'antreas' ),
			'id'            => 'blog-widgets',
			'description'   => __( 'Shown in the blog', 'antreas' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h6 class="widget-title">',
			'after_title'   => '</h6>',
		)
	);

	//$footer_columns = apply_filters( 'antreas_subfooter_columns', antreas_get_option( 'layout_subfooter_columns' ) );
	//if ( $footer_columns == '' ) {
		$footer_columns = 5;
	//}
	for ( $count = 1; $count <= $footer_columns; $count++ ) {
		register_sidebar(
			array(
				'id'            => 'footer-widgets-' . $count,
				'name'          => __( 'Footer Widgets', 'antreas' ) . ' ' . $count,
				'description'   => __( 'Shown in the footer area.', 'antreas' ),
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h6 class="widget-title">',
				'after_title'   => '</h6>',
			)
		);
	}
}


//Registers all menu areas
add_action( 'widgets_init', 'antreas_init_menu' );
function antreas_init_menu() {
	register_nav_menus( array( 'main_menu' => __( 'Main Menu', 'antreas' ) ) );
	register_nav_menus( array( 'footer_menu' => __( 'Footer Menu', 'antreas' ) ) );
}
