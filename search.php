<?php get_header(); ?>

<section class="section title-section py-5">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-6 col-lg-8 text-center text-md-left">
				<h1 class="h2 mb-md-0"><?php echo $wp_query->found_posts; ?> articles found<span class="has-primary-color">.</span></h1>
			</div>

			<div class="col-md-6 col-lg-4">
				<?php the_widget( 'WP_Widget_Search' ); ?>
			</div>
		</div>
	</div>
</section>

<section class="section main-section pt-0">
	<div class="container">
		<div class="row row--medium-gutters">
			<?php if ( have_posts() ) : ?>
				<?php while ( have_posts() ) : ?>
					<?php the_post(); ?>
					<div class="col-md-6 col-xl-4">
						<?php get_template_part( 'template-parts/post' ); ?>
					</div>
				<?php endwhile; ?>
			<?php else : ?>
				<?php //get_template_part( 'template-parts/content/content', 'none' ); ?>
			<?php endif; ?>
		</div><!-- row -->

		<div class="row">
			<div class="col-12 text-center">
				<?php the_posts_pagination( array( 'prev_text' => '', 'next_text' => '' ) ); ?>
			</div>
		</div><!-- row -->
	</div>
</section>

<?php get_template_part( 'template-parts/sections/cta' ); ?>
<?php get_template_part( 'template-parts/sections/latest-post' ); ?>
<?php get_footer(); ?>
