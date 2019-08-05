<?php get_header(); ?>

<?php $page_for_posts = get_option( 'page_for_posts' ); ?>

<section class="section title-section">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-6 text-center last-child-mb-0">
				<h1>
				<?php if ( 'posts' === get_option( 'show_on_front' ) ) : ?>
					<?php echo esc_html( 'Blog', 'modula' ); ?>
				<?php else : ?>
					<?php echo esc_html( get_the_title( $page_for_posts ) ); ?>
				<?php endif; ?>
				</h1>
				<?php if ( has_excerpt( $page_for_posts ) ) : ?>
					<div class="title-section__excerpt">
						<?php echo wp_kses_post( get_the_excerpt( $page_for_posts ) ); ?>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>

<section class="section main-section pt-0">
	<div class="container">
		<div class="row row--medium-gutters justify-content-center">
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

<?php get_footer(); ?>
