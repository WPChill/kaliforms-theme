<?php
	$related = new WP_Query(
		array(
			'category__in'   => wp_get_post_categories( $post->ID ),
			'posts_per_page' => 3,
			'post__not_in'   => array( $post->ID )
		)
	);

	if ( $related->found_posts === 0 ) {
		return;
	}
?>

<section class="section related-posts-section">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-6 section__heading text-center">
				<h2 class="mb-0">Hand-picked related articles<span class="has-primary-color">.</span></h2>
			</div>
		</div>

		<div class="row row--medium-gutters justify-content-center">
			<?php while ( $related->have_posts() ) : ?>
      			<?php $related->the_post(); ?>
				<div class="col-md-6 col-xl-4">
					<?php get_template_part( 'template-parts/post-related' ); ?>
				</div>
			<?php endwhile; ?>
   			<?php wp_reset_postdata(); ?>
		</div><!-- row -->

	</div><!-- container -->

</section>