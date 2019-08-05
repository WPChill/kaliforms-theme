<?php

$theme = wp_get_theme();
define( 'ANTREAS_SLUG', 'antreas' );
define( 'ANTREAS_PRO_SLUG', 'antreas-pro' );
define( 'ANTREAS_PREFIX', 'antreas_pro' );
define( 'ANTREAS_NAME', $theme['Name'] );
define( 'ANTREAS_VERSION', $theme['Version'] );
define( 'ANTREAS_ASSETS_CSS', get_template_directory_uri() . '/assets/css/' );
define( 'ANTREAS_ASSETS_JS', get_template_directory_uri() . '/assets/js/' );
define( 'ANTREAS_ASSETS_IMG', get_template_directory_uri() . '/assets/img/' );
define( 'ANTREAS_ASSETS_VENDORS', get_template_directory_uri() . '/assets/vendors/' );
define( 'ANTREAS_CORE', get_template_directory() . '/core/' );
define( 'ANTREAS_SHORTCODES', get_template_directory() . '/shortcodes/' );
define( 'ANTREAS_PREMIUM_NAME', 'Antreas Pro' );
define( 'ANTREAS_PREMIUM_URL', 'www.machothemes.com/theme/antreas/' );

require_once ANTREAS_CORE . 'init.php';

/**
 * Removes the billing details section on the checkout screen.
 */
/*
function jp_disable_billing_details() {
	remove_action( 'edd_after_cc_fields', 'edd_default_cc_address_fields' );
}
add_action( 'init', 'jp_disable_billing_details' );
*/

add_filter( 'edd-vat-use-checkout-billing-template', '__return_false' ); 
add_filter( 'edd_require_billing_address', '__return_false' ); 