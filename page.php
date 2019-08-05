<?php get_header(); ?>

<?php get_template_part( 'template-parts/sections/title' ); ?>

<section class="section main-section pt-0 pb-5">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-6">
				<?php if ( have_posts() ) : ?>
					<?php while ( have_posts() ) : ?>
						<?php the_post(); ?>
						<div class="post-content last-child-mb-0">
							<?php the_content(); ?>
						</div>
					<?php endwhile; ?>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>

<?php get_template_part( 'template-parts/sections/cta' ); ?>
<?php get_template_part( 'template-parts/sections/latest-post' ); ?>

<?php get_footer(); ?>
