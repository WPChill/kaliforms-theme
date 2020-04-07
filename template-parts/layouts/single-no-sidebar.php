<?php wp_enqueue_script( 'waypoints' ); ?>

<?php get_template_part( 'template-parts/sections/title-single' ); ?>

<section class="main-section pb-5">
	<div class="container">
		<div class="row">
			<?php if ( have_posts() ) : ?>
				<?php while ( have_posts() ) : ?>
					<?php the_post(); ?>
					<div class="col-lg-2">

						<div class="post-sidebar">
							<?php if ('1' == get_post_meta( get_the_id(), '_ez-toc-insert', true ) ): ?>
								<?php echo do_shortcode( '[toc]' ); ?>
							<?php endif; ?>
						</div><!-- post-sidebar -->

					</div>
					<div class="post-content col-lg-8">
						<?php the_content(); ?>
						<?php do_action( 'modula_after_single_content' );  ?>
					</div>
				<?php endwhile; ?>
			<?php endif; ?>
		</div>
	</div>
</section>