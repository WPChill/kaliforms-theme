<?php

$args         = array(
	'numberposts' => '1',
	'post_status' => 'publish',
);
$recent_posts = wp_get_recent_posts( $args );

if ( empty( $recent_posts ) ) {
	return;
}
$recent       = $recent_posts[0];

if( get_the_id() === $recent['ID'] ) {
	return;
}
?>

<section class="section latest-post-section py-4">
	<div class="container">
		<div class="row align-items-center">
			<div class="col-12 col-lg-4 col-xl-3 text-left">
				<p class="mb-lg-0"><i class="icon icon-pen mr-3"></i><strong class="mr-3">Read our latest blog post:</strong></p>
			</div>
			<div class="col-12 col-lg-8 col-xl-9 text-left">
				<p class="mb-0"><a href="<?php echo get_permalink( $recent['ID'] ); ?>"><?php echo get_the_title( $recent['ID'] ); ?></a></p>
			</div>
		</div>
	</div>
</section>
