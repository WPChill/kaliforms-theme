<?php

add_shortcode( 'subscription-form', 'st_add_subscription_form' );
function st_add_subscription_form ( $atts, $content, $tag ) {

	ob_start();
	get_template_part( 'template-parts/misc/subscribe-form' );
	return ob_get_clean();

};
