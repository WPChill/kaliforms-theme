<?php

add_filter( 'wp_nav_menu_items', 'modula_main_menu_filter', 10, 2 );
function modula_main_menu_filter( $items, $args ) {

	if ( $args->theme_location == 'main_menu' ) {

		if ( is_page_template( 'page-templates/pricing.php' ) ) {
			$items = '';
		}

		if ( ! is_user_logged_in() ) {
			$items .= '<li class="menu-item"><a class="login-link" href="#" rel="nofollow">Log In</a></li>';
			$items .= '<li class="menu-item"><a class="get-started-link" href="' . get_permalink( get_page_by_path( 'pricing' ) ) . '">Buy Kali Forms</a></li>';
		} else {
			$items         .= '<li class="menu-item menu-item-has-children">';
				$items     .= '<a href="' . get_permalink( get_page_by_path( 'account' ) ) . '">My Account</a>';
				$items     .= '<ul class="sub-menu">';
					$items .= '<li class="menu-item"><a href="' . get_permalink( get_page_by_path( 'account' ) ) . '">Purchase History</a></li>';
					$items .= '<li class="menu-item"><a href="' . get_permalink( get_page_by_path( 'account' ) ) . '#subscriptions">Subscriptions</a></li>';
					$items .= '<li class="menu-item"><a href="' . get_permalink( get_page_by_path( 'account' ) ) . '#account-information">Account Information</a></li>';
					$items .= '<li class="menu-item"><a href="' . get_permalink( get_page_by_path( 'account' ) ) . '#download-history">Download History</a></li>';

			if ( function_exists( 'affwp_is_affiliate' ) && affwp_is_affiliate( get_current_user_id() ) ) :
				$items .= '<li class="menu-item"><a href="' . get_permalink( get_page_by_path( 'affiliate-area' ) ) . '">Affiliate Area</a></li>';
					endif;

					$items .= '<li class="menu-item"><a href="' . wp_logout_url( home_url() ) . '">Log Out</a></li>';
				$items     .= '</ul>';
			$items         .= '</li>';
		}



	}

	return $items;
}


add_filter( 'wp_nav_menu_items', 'modula_add_quick_access_links', 10, 2 );
function modula_add_quick_access_links( $items, $args ) {

	if ( $args->menu->slug === 'quick-access' ) {
		if ( ! is_user_logged_in() ) {
			$items .= '<li class="menu-item"><a class="login-link" href="#" rel="nofollow">Log In</a></li>';
		} else {
			$items .= '<li class="menu-item"><a href="' . get_permalink( get_page_by_path( 'account' ) ) . '">My Account</a></li>';
		}
	}

	return $items;
}



add_action( 'wp_ajax_modula_search_articles', 'modula_search_articles' );
add_action( 'wp_ajax_nopriv_modula_search_articles', 'modula_search_articles' );
function modula_search_articles() {

	if ( ! wp_verify_nonce( $_REQUEST['nonce'], 'search_articles_nonce' ) ) {
		exit( 'No naughty business please' );
	}

	$query = new WP_Query(
		array(
			'post_type' => $_REQUEST['post_type'],
			's'         => $_REQUEST['s'],
		)
	);

	if ( $query->have_posts() ) {
		echo '<p>' . $query->post_count . ' articles found for <strong>' . $_REQUEST['s'] . '</strong>:</p>';
		echo '<ul class="mb-0">';
		while ( $query->have_posts() ) {
			$query->the_post();
			echo '<li><a href="' . get_permalink() . '">' . get_the_title() . '</a></li>';
		}
		echo '</ul>';
	} else {
		echo '<p class="mb-0">no articles found with that keyword</p>';
	}

	die();
}


// Limits excerpt length to a certain size
add_filter( 'excerpt_length', 'st_excerpt_length' );
function st_excerpt_length( $length ) {
	return 30;
}

//Displays an ellipsis on automatic excerpts
add_filter( 'excerpt_more', 'st_excerpt_more' );
function st_excerpt_more( $more ) {
	$output = '&hellip;';
	return $output;
}


add_action( 'the_content', 'modula_the_content', 20 );
function modula_the_content( $content ) {
	return $content;
}

add_action( 'upload_mimes', 'st_add_file_types_to_uploads' );
function st_add_file_types_to_uploads( $file_types ){

	$new_filetypes = array();
	$new_filetypes['svg'] = 'image/svg+xml';
	$file_types = array_merge( $file_types, $new_filetypes );

	return $file_types;
}


remove_action( 'edd_before_purchase_form', 'edd_sl_renewal_form', -1 );
remove_action( 'edd_checkout_form_top', 'edd_discount_field', -1 );

// remove child licenses
add_filter( 'edd_sl_manage_template_payment_licenses', 'st_edd_sl_manage_template_payment_licenses', 10, 2 );
function st_edd_sl_manage_template_payment_licenses( $licenses, $payment_id ) {
	$new_licenses = array();
	foreach ( $licenses as $license ) :
		if ( 0 == $license->parent ) {
			$new_licenses[] = $license;
		}
	endforeach;
	return $new_licenses;
}

// remove child licenses
add_filter( 'edd_sl_licenses_of_purchase', 'st_edd_sl_licenses_of_purchase', 10, 3 );
function st_edd_sl_licenses_of_purchase( $licenses, $payment, $args ) {
	$new_licenses = array();
	foreach ( $licenses as $license ) :
		if ( 0 == $license->parent ) {
			$new_licenses[] = $license;
		}
	endforeach;
	return $new_licenses;
}

//Add theme-specific body classes
add_filter( 'body_class', 'st_body_class' );
function st_body_class( $class ) {

	if ( is_singular('post') ) {
		$class[] = 'post-layout-'. st_get_post_meta( get_the_id(), 'layout' );
	}

	return $class;
}

add_action( 'wp_head', 'st_track_post_views');
function st_track_post_views ( $post_id ) {
    if ( ! is_single() ) return;
    if ( empty ( $post_id) ) {
        global $post;
        $post_id = $post->ID;
	}
	st_set_post_views( $post_id );
}


add_filter( 'pre_get_posts', 'theme_pre_get_posts' );
function theme_pre_get_posts( $query ) {

	// Remove other custom post types from search results
	if ( $query->is_main_query() && is_search() ) {
		$query->set( 'post_type', 'post' );
	}
	return $query;
}
