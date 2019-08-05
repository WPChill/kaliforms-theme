<section class="mt-5 mb-5">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-8 text-center">
				<h1 class="h2 mt-3 mb-3"><?php echo esc_html( get_the_title() ); ?></h1>
			</div>
		</div>
	</div>
</section>

<section class="main-section pb-5">
	<div class="container">
		<div class="row">
			<?php if ( have_posts() ) : ?>
				<?php while ( have_posts() ) : ?>
					<?php the_post(); ?>
					<div class="col-lg-8 mb-3 mb-lg-0">

						<?php if ( has_post_thumbnail() ): ?>
							<figure>
								<div class="title-single__thumbnail">
									<?php echo wp_get_attachment_image( get_post_thumbnail_id(), "full", false ); ?>
								</div>
							</figure>
						<?php endif; ?>

						<div class="post-wrap px-3 px-lg-4 pb-3 pb-lg-4">

							<div class="title-single__meta row mb-3">
								<div class="col-6 col-md-3 col-lg-6 col-xl-4 mb-2 mb-md-0 title-single__author">
									<div class="d-none d-xl-inline-block">
										<?php echo get_avatar( get_the_author_meta( 'ID' ), 80 ); ?>
									</div>
									by <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php echo get_the_author(); ?></a>
								</div>

								<div class="col-6 col-md-3 col-lg-6 col-xl-3 mb-2 mb-md-0 title-single__date">
									<?php echo get_the_date(); ?>
								</div>

								<?php if( get_comments_number() !== '0' ) : ?>
									<div class="col-6 col-md-3 col-lg-6 col-xl-3 mb-2 mb-md-0 title-single__comments">
										<a title="<?php echo esc_attr__( 'Comment on Post', 'modula' ); ?>" href="<?php echo esc_url( get_the_permalink( get_the_ID() ) ); ?>#comments">
											<?php esc_html( comments_number( __( 'no comments', 'modula' ), __( 'one comment', 'modula' ), __( '% comments', 'modula' ) ) ); ?>
										</a>
									</div>
								<?php endif; ?>

								<div class="col-6 col-md-3 col-lg-6 col-xl-2 mb-2 mb-md-0 title-single__read">
									<?php echo floor( st_reading_time( get_the_content() ) / 60 ) + 1; ?> min read
								</div>

							</div><!-- row -->


							<div class="post-content">
								<?php the_content(); ?>
							</div>
							<?php do_action( 'modula_after_single_content' );  ?>

						</div><!-- post-wrap -->

					</div>
					<div class="col-lg-4 sidebar">
						<?php echo do_shortcode( '[subscription-form]' ); ?>
						<?php dynamic_sidebar( 'blog-widgets' ); ?>
					</div><!-- col -->
				<?php endwhile; ?>
			<?php endif; ?>
		</div>
	</div>
</section>