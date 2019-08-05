<?php

function modula_header_class() {

	$class = 'header';

	echo esc_attr( $class );
}

//Returns the current language's code in the event that WPML is active
if ( ! function_exists( 'antreas_wpml_current_language' ) ) {
	function antreas_wpml_current_language() {
		$language_code = '';
		if ( antreas_wpml_active() ) {
			$default_language = antreas_wpml_default_language();
			$active_language  = ICL_LANGUAGE_CODE;
			if ( $active_language != $default_language ) {
				$language_code = '_' . $active_language;
			}
		} elseif ( function_exists( 'pll_current_language' ) && function_exists( 'pll_default_language' ) ) {
			$default_language = pll_default_language();
			$active_language  = pll_current_language();
			if ( $active_language != $default_language ) {
				$language_code = '_' . $active_language;
			}
		}
		return $language_code;
	}
}

//Check if WPML is active
if ( ! function_exists( 'antreas_wpml_active' ) ) {
	function antreas_wpml_active() {
		if ( defined( 'ICL_LANGUAGE_CODE' ) && defined( 'ICL_SITEPRESS_VERSION' ) ) {
			return true;
		} else {
			return false;
		}
	}
}

//Retrieve languages from WPML
if ( ! function_exists( 'antreas_wpml_languages' ) ) {
	function antreas_wpml_languages() {
		if ( antreas_wpml_active() ) {
			global $sitepress;
			return $sitepress->get_active_languages();
		}
	}
}

//Retrieve default WPML language
if ( ! function_exists( 'antreas_wpml_default_language' ) ) {
	function antreas_wpml_default_language() {
		if ( antreas_wpml_active() ) {
			global $sitepress;
			return $sitepress->get_default_language();
		}
	}
}


//Searches for a link inside a string. Used for post formats
if ( ! function_exists( 'antreas_find_link' ) ) {
	function antreas_find_link( $content, $fallback ) {

		$link_url     = '';
		$link_pattern = '/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/';
		$post_content = $content;
		if ( preg_match( $link_pattern, $post_content, $link_url ) ) {
			return $link_url[0];
		} else {
			return $fallback;
		}
	}
}


//Retrieve page number for the current post or page
if ( ! function_exists( 'antreas_current_page' ) ) {
	function antreas_current_page() {
		$current_page = 1;
		if ( is_front_page() ) {
			if ( get_query_var( 'page' ) ) {
				$current_page = get_query_var( 'page' );
			} else {
				$current_page = 1;
			}
		} else {
			if ( get_query_var( 'paged' ) ) {
				$current_page = get_query_var( 'paged' );
			} else {
				$current_page = 1;
			}
		}
		return $current_page;
	}
}


//Retrieve current post or taxonomy id
if ( ! function_exists( 'antreas_current_id' ) ) {
	function antreas_current_id() {
		$current_id = false;
		if ( is_tax() || is_category() || is_tag() ) {
			$current_id = get_queried_object()->term_id;
		} else {
			global $post;
			if ( isset( $post->ID ) ) {
				$current_id = $post->ID;
			} else {
				$current_id = false;
			}
		}
		return $current_id;
	}
}


//Return true if posts should be displayed on homepage
function antreas_show_posts() {
	$display = false;
	if ( ! is_front_page() || antreas_get_option( 'home_posts' ) === true ) {
		$display = true;
	}
	return $display;
}


//Return true if page title should be displayed
function antreas_show_title() {
	$display = false;
	if ( ! is_front_page() ) {
		$display = true;
	}

	if ( get_post_meta( get_the_ID(), 'page_title', true ) === 'none' ) {
		$display = false;
	}

	return $display;
}


//Add shortcode functionality to text widgets
add_filter( 'widget_text', 'do_shortcode' );


//Custom function to do some cleanup on nested shortcodes
//Used for columns and layout-related shortcodes
if ( ! function_exists( 'antreas_do_shortcode' ) ) {
	function antreas_do_shortcode( $content ) {
		$content = do_shortcode( shortcode_unautop( $content ) );
		$content = preg_replace( '#^<\/p>|^<br\s?\/?>|<p>$|<p>\s*(&nbsp;)?\s*<\/p>#', '', $content );
		return $content;
	}
}



//Sanitize boolean values
function antreas_sanitize_bool( $data ) {
	if ( $data === true ) {
		return true;
	}
	return false;
}


// Sanitize logo dimensions
function antreas_sanitize_logo_dimensions( $dimensions ) {
	$new_dimensions = array();

	if ( isset( $dimensions['width'] ) ) {
		$new_dimensions['width'] = abs( floatval( $dimensions['width'] ) );
	}

	if ( isset( $dimensions['height'] ) ) {
		$new_dimensions['height'] = abs( floatval( $dimensions['height'] ) );
	}

	return $new_dimensions;
}

//Return the URL to the premium theme page
function antreas_upgrade_link( $medium = 'customizer' ) {
	$url = esc_url_raw( ANTREAS_PREMIUM_URL . '?utm_source=antreas&utm_medium=' . $medium . '&utm_campaign=upsell' );
	return $url;
}


// Gets attachment url by slug from media library.
function antreas_get_attachment_url_by_slug( $slug ) {
	$args    = array(
		'post_type'      => 'attachment',
		'name'           => sanitize_title( $slug ),
		'posts_per_page' => 1,
		'post_status'    => 'inherit',
	);
	$_header = get_posts( $args );
	$header  = $_header ? array_pop( $_header ) : null;
	return $header ? wp_get_attachment_url( $header->ID ) : '';
}


function modula_docs_breadcrumbs() {
	global $post;

	$html = '';
	$args = apply_filters(
		'wedocs_breadcrumbs',
		array(
			'delimiter' => '<li class="delimiter"><i class="wedocs-icon wedocs-icon-angle-right"></i></li>',
			'home'      => __( 'Home', 'wedocs' ),
			'before'    => '<li><span class="current">',
			'after'     => '</span></li>',
		)
	);

	$breadcrumb_position = 1;

	$html .= '<ul class="wedocs-breadcrumb mb-sm-0" itemscope itemtype="http://schema.org/BreadcrumbList">';
	//$html .= '<li><i class="wedocs-icon wedocs-icon-home"></i></li>';
	//$html .= wedocs_get_breadcrumb_item( $args['home'], home_url( '/' ), $breadcrumb_position );
	//$html .= $args['delimiter'];

	$docs_home = wedocs_get_option( 'docs_home', 'wedocs_settings' );

	if ( $docs_home ) {
		$breadcrumb_position++;

		$html .= wedocs_get_breadcrumb_item( __( 'Docs', 'wedocs' ), get_permalink( $docs_home ), $breadcrumb_position );
		$html .= $args['delimiter'];
	}

	if ( $post->post_type == 'docs' && $post->post_parent ) {
		$parent_id   = $post->post_parent;
		$breadcrumbs = array();

		while ( $parent_id ) {
			$breadcrumb_position++;

			$page          = get_post( $parent_id );
			$breadcrumbs[] = wedocs_get_breadcrumb_item( get_the_title( $page->ID ), get_permalink( $page->ID ), $breadcrumb_position );
			$parent_id     = $page->post_parent;
		}

		$breadcrumbs = array_reverse( $breadcrumbs );
		for ( $i = 0; $i < count( $breadcrumbs ); $i++ ) {
			$html .= $breadcrumbs[ $i ];
			$html .= ' ' . $args['delimiter'] . ' ';
		}
	}

	$html .= '</ul>';

	echo apply_filters( 'wedocs_breadcrumbs_html', $html, $args );
}

add_action( 'before_header', 'modula_before_header', 10, 2 );
function modula_before_header() {

	global $post;

/* 	if ( 'pricing' == $post->post_name ) {
		get_template_part( 'template-parts/sections/promotion' );
	} */

	if ( '' !== modula_get_option( 'top_bar_content' ) && modula_show_section( modula_get_option( 'top_bar_include' ), modula_get_option( 'top_bar_exclude' ) ) ) {
		get_template_part( 'template-parts/sections/topbar' );
	}
}

add_action( 'modula_after_single_content', 'modula_after_single_content', 10, 2 );
function modula_after_single_content() {

	global $post;

/* 	if ( st_get_post_meta( $post->ID, 'display_newsletter' ) !== '0' ) {
		echo do_shortcode( '[subscription-form]' );
	} */

/* 	if ( st_get_post_meta( $post->ID, 'display_authorbox' ) !== '0' ) {
		get_template_part( 'template-parts/misc/author-bio' );
	} */

}

add_action( 'modula_footer', 'modula_footer', 10, 2 );
function modula_footer() {

	global $post;

	if ( ! isset($post) ) {
		get_template_part( 'template-parts/sections/footer' );
		return;
	}

	if ( st_get_post_meta( $post->ID, 'footer_type' ) === 'simple' ) {
		get_template_part( 'template-parts/sections/footer-simple' );
		return;
	}

	get_template_part( 'template-parts/sections/footer' );

}


//Abstracted function for retrieving specific options inside option arrays
if ( ! function_exists( 'modula_get_option' ) ) {
	function modula_get_option( $option_name = '', $option_array = 'modula_settings' ) {

		$option_value = null;
		$options      = modula_metadata_customizer();

		//If options exists and is not empty, get value
		$option_list = get_option( $option_array, false );
		if ( $option_list && isset( $option_list[ $option_name ] ) && ( is_bool( $option_list[ $option_name ] ) === true || $option_list[ $option_name ] !== '' ) ) {
			$option_value = $option_list[ $option_name ];
		}

		//If option is empty, check whether it needs a default value
		if ( $option_value === null || ! isset( $option_list[ $option_name ] ) ) {
			if ( isset( $options[ $option_name ]['default'] ) ) {
				$option_value = $options[ $option_name ]['default'];
			}
		}

		return $option_value;
	}
}


if ( ! function_exists( 'st_get_post_meta' ) ) {
	function st_get_post_meta( $post_id, $name ) {
		$value = get_post_meta( $post_id, ANTREAS_SLUG . '_' . $name, true );
		return $value;
	}
}


// Generate custom CSS.
function antreas_generate_custom_css() {

	ob_start();
	?>

	<?php
	return preg_replace( '/\s+/', ' ', ob_get_clean() );
}



if ( ! function_exists( 'modula_show_section' ) ) {
	function modula_show_section( $section_include, $section_exclude ) {
		$show_section = false;

		if ( in_array( 'all', $section_include ) ) {
			$show_section = true;
		}
		if ( is_front_page() && in_array( 'homepage', $section_include ) ) {
			$show_section = true;
		}
		if ( is_singular( 'post' ) && in_array( 'all_posts', $section_include ) ) {
			$show_section = true;
		}
		if ( is_singular( 'page' ) && in_array( 'all_pages', $section_include ) ) {
			$show_section = true;
		}
		if ( is_404() && in_array( '404_page', $section_include ) ) {
			$show_section = true;
		}
		if ( is_archive() && in_array( 'archive', $section_include ) ) {
			$show_section = true;
		}
		if ( is_search() && in_array( 'search', $section_include ) ) {
			$show_section = true;
		}
		if ( in_array( get_the_ID(), $section_include ) ) {
			$show_section = true;
		}

		// now exclude.
		if ( in_array( 'all', $section_exclude ) ) {
			$show_section = false;
		}
		if ( is_front_page() && in_array( 'homepage', $section_exclude ) ) {
			$show_section = false;
		}
		if ( is_singular( 'post' ) && in_array( 'all_posts', $section_exclude ) ) {
			$show_section = false;
		}
		if ( is_singular( 'page' ) && in_array( 'all_pages', $section_exclude ) ) {
			$show_section = false;
		}
		if ( is_404() && in_array( '404_page', $section_exclude ) ) {
			$show_section = false;
		}
		if ( is_archive() && in_array( 'archive', $section_exclude ) ) {
			$show_section = false;
		}
		if ( is_search() && in_array( 'search', $section_exclude ) ) {
			$show_section = false;
		}
		if ( in_array( get_the_ID(), $section_exclude ) ) {
			$show_section = false;
		}

		return $show_section;
	}
}

function st_reading_time( $content ) {
	// Predefined words-per-minute rate.
	$words_per_minute = 225;
	$words_per_second = $words_per_minute / 60;
	// Count the words in the content.
	$word_count = str_word_count( strip_tags( $content ) );
	// [UNUSED] How many minutes?
	$minutes = floor( $word_count / $words_per_minute );
	// [UNUSED] How many seconds (remainder)?
	$seconds_remainder = floor( $word_count % $words_per_minute / $words_per_second );
	// How many seconds (total)?
	$seconds_total = floor( $word_count / $words_per_second );
	return $seconds_total;
}



function st_nr_of_sites( $download_id ) {

	$limit = get_post_meta( $download_id, '_edd_sl_limit', true );

	if( $limit == 0 ) {
		return '<strong>Unlimited Sites</strong>';
	}

	if( $limit == 1 ) {
		return '1 Site';
	}

	return $limit . ' Sites';
}


function st_set_post_views( $post_id ) {
    $count_key = 'st_post_views_count';
    $count = get_post_meta( $post_id, $count_key, true );
    if( $count == '' ) {
        $count = 0;
        delete_post_meta( $post_id, $count_key );
        add_post_meta( $post_id, $count_key, '0' );
    } else {
        $count++;
        update_post_meta( $post_id, $count_key, $count );
    }
}
//To keep the count accurate, lets get rid of prefetching
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);

function st_edd_get_download_price( $download_id ) {

	$initial_price = floor( edd_get_download_price( $download_id ) );
	$price = $initial_price;

	$discounts = edd_get_cart_discounts();
	foreach ( $discounts as $discount ) {
		$difference = $initial_price - edd_get_discounted_amount( $discount, $initial_price );
		$price -= $difference;
	}

	return floor( $price );
}

function st_get_upgrade_id_by_download_id( $upgrades, $download_id ) {

	foreach ( $upgrades as $id => $upgrade ) {
		if( $upgrade['download_id'] === $download_id  ) {
			return $id;
		}
	}

	return 0;
}

add_action( 'template_redirect', 'st_checkout_redirect' );
function st_checkout_redirect() {

	if (
		is_page_template( 'page-templates/checkout.php' ) &&
		function_exists( 'edd_get_cart_contents' ) &&
		! edd_get_cart_contents()
	) {
		wp_redirect( home_url( '/', 'https' ) . '/pricing', 301 );
    	exit();
	}

}


function st_get_all_extensions( $plans = array() ) {

	$args = array(
		'post_type'      => 'download',
		'post_status'    => array( 'publish' ),
		'posts_per_page' => -1,
		'order' => 'ASC',
		'orderby' => 'date',
		'tax_query'      => array(
			array(
				'taxonomy' => 'download_category',
				'field'    => 'slug',
				'terms'    => 'addons',
			),
		),
	);
	// this will show hidden extensions as well
	remove_action( 'pre_get_posts', array( EDD_Hide_Download::get_instance(), 'pre_get_posts' ), 9999 );
	$addons = new WP_Query( $args );

	//sort addons based on the number of plans they are included
	if( $plans ) {
		foreach( $addons->posts as $addon ) {
			$addon->nr_of_plans = 0;
			foreach( $plans as $plan ) {
				if ( false !== array_search( $addon->ID, $plan->get_bundled_downloads() ) ) {
					$addon->nr_of_plans++;
				}
			}
		}

		function extension_compare($ext1, $ext2) {
			return $ext1->nr_of_plans < $ext2->nr_of_plans;
		}
		usort( $addons->posts, "extension_compare" );
	}

	return $addons;
}