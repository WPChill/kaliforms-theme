<?php


//Theme options setup
if ( ! function_exists( 'antreas_setup' ) ) {
	add_action( 'after_setup_theme', 'antreas_setup' );
	function antreas_setup() {

		//Initialize supported theme features
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'custom-background', apply_filters( 'antreas_background_args', array() ) );
		add_theme_support( 'automatic-feed-links' );
		//add_theme_support( 'wp-block-styles' );
		add_post_type_support( 'page', 'excerpt' );
		add_post_type_support( 'docs', 'excerpt' );
		add_theme_support( 'customize-selective-refresh-widgets' );
		add_theme_support( 'align-wide' );

		add_image_size( 'st_medium_cropped', 768, 768 * 0.6, true );
	}
}


if ( ! function_exists( 'antreas_add_scripts' ) ) {
	add_action( 'wp_enqueue_scripts', 'antreas_add_scripts' );
	function antreas_add_scripts() {
		wp_register_script( 'waypoints', ANTREAS_ASSETS_VENDORS . '/waypoints/jquery.waypoints.js', array(), ANTREAS_VERSION, true );
		wp_register_script( 'odometer', ANTREAS_ASSETS_VENDORS . '/odometer/odometer.min.js', array(), ANTREAS_VERSION, true );
	}
}


if ( ! function_exists( 'antreas_scripts_front' ) ) {
	add_action( 'wp_footer', 'antreas_scripts_footer' );
	function antreas_scripts_footer() {
		global $post;

		// enqueue jquery in the footer
		wp_deregister_script( 'jquery' );
		wp_register_script( 'jquery', includes_url( '/js/jquery/jquery.js' ), false, ANTREAS_VERSION, true );

		// Enqueue necessary scripts already in the WordPress core.
		if ( is_singular() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}

		wp_enqueue_script( 'modula-index', ANTREAS_ASSETS_JS . 'index.js', array( 'jquery' ), ANTREAS_VERSION, true );
		wp_localize_script( 'modula-index', 'modula', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );

	}
}


if ( ! function_exists( 'antreas_scripts_back' ) ) {
	add_action( 'admin_enqueue_scripts', 'antreas_scripts_back' );
	function antreas_scripts_back() {
		wp_register_style( ANTREAS_SLUG . '-admin', ANTREAS_ASSETS_CSS . 'admin.css', array(), ANTREAS_VERSION );
		wp_register_style( ANTREAS_SLUG . '-selectize-style', ANTREAS_ASSETS_VENDORS . '/selectize/selectize.css', array(), ANTREAS_VERSION );

		wp_register_script( ANTREAS_SLUG . '-selectize-script', ANTREAS_ASSETS_VENDORS . '/selectize/selectize.min.js', array( 'jquery' ), ANTREAS_VERSION );
	}
}


if ( ! function_exists( 'antreas_scripts_customizer' ) ) {
	add_action( 'customize_controls_enqueue_scripts', 'antreas_scripts_customizer' );
	function antreas_scripts_customizer() {
	}
}


if ( ! function_exists( 'antreas_scripts_customizer_preview' ) ) {
	//add_action( 'customize_preview_init', 'antreas_scripts_customizer_preview' );
	function antreas_scripts_customizer_preview() {
		wp_enqueue_script( 'antreas_customizer-preview', ANTREAS_ASSETS_JS . 'customizer-preview.js', array( 'customize-preview' ), ANTREAS_VERSION, true );
	}
}


if ( ! function_exists( 'antreas_styles_customizer_preview' ) ) {
	//add_action( 'customize_preview_init', 'antreas_styles_customizer_preview' );
	function antreas_styles_customizer_preview() {
		wp_enqueue_style( 'antreas-customizer-preview', ANTREAS_ASSETS_CSS . 'customizer-preview.css', array(), ANTREAS_VERSION );
	}
}


//Add public stylesheets
if ( ! function_exists( 'antreas_add_styles' ) ) {
	add_action( 'wp_enqueue_scripts', 'antreas_add_styles' );
	function antreas_add_styles() {
		wp_enqueue_style( ANTREAS_SLUG . '-main', ANTREAS_ASSETS_CSS . 'style.css', array(), ANTREAS_VERSION );
		wp_add_inline_style( ANTREAS_SLUG . '-main', antreas_generate_custom_css() );

		if ( is_singular( 'docs' ) ) {
			wp_enqueue_style( 'font-awesome', ANTREAS_ASSETS_VENDORS . '/font-awesome/css/font-awesome.min.css', array(), ANTREAS_VERSION );
		}

		wp_register_style( 'odometer', ANTREAS_ASSETS_VENDORS . '/odometer/odometer-theme-default.css', array(), ANTREAS_VERSION );
	}
}


// Main Components.
require_once ANTREAS_CORE . '/classes/class-mt-customizer-selectize-control.php';
require_once ANTREAS_CORE . '/classes/class-mt-customizer-tinymce-control.php';

require_once ANTREAS_CORE . '/metadata/data-customizer.php';
require_once ANTREAS_CORE . '/metadata/data-metaboxes.php';

// Shortcodes
require_once ANTREAS_SHORTCODES . 'subscription-form.php';

// Widgets
require_once ANTREAS_CORE . '/widgets/popular.php';

require_once ANTREAS_CORE . 'functions.php';
require_once ANTREAS_CORE . 'markup.php';
require_once ANTREAS_CORE . 'filters.php';
require_once ANTREAS_CORE . 'custom.php';
require_once ANTREAS_CORE . 'layout.php';
require_once ANTREAS_CORE . 'metaboxes.php';
require_once ANTREAS_CORE . 'forms.php';
require_once ANTREAS_CORE . 'customizer.php';
require_once ANTREAS_CORE . 'post-types.php';



