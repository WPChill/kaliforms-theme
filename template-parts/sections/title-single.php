<?php while ( have_posts() ) : ?>
	<?php the_post(); ?>
	<section class="title-single-section">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-6 text-center">
					<!-- <div class="title-single__cats">
						<?php echo wp_kses_post( get_the_category_list( ' ' ) ); ?>
					</div> -->
					<h1 class="h2 title-single__title mb-0"><?php echo esc_html( get_the_title() ); ?></h1>

					<?php if( has_post_thumbnail() ): ?>
						<figure class="wp-block-image alignwide mb-0 mt-0">
							<div class="title-single__thumbnail">
								<?php echo wp_get_attachment_image( get_post_thumbnail_id(), "full", false ); ?>
							</div>
						</figure>
					<?php endif; ?>


					<div class="title-single__meta mb-4">
						<span class="title-single__author">
							by <?php echo get_the_author(); ?>
						</span>

						<span class="title-single__date">
							<?php echo get_the_date(); ?>
						</span>

						<?php if( get_comments_number() !== '0' ) : ?>
							<span class="title-single__comments">
								<a title="<?php echo esc_attr__( 'Comment on Post', 'modula' ); ?>" href="<?php echo esc_url( get_the_permalink( get_the_ID() ) ); ?>#comments">
									<?php esc_html( comments_number( __( 'no comments', 'modula' ), __( 'one comment', 'modula' ), __( '% comments', 'modula' ) ) ); ?>
								</a>
							</span>
						<?php endif; ?>

						<span class="title-single__read">
							<?php echo floor( st_reading_time( get_the_content() ) / 60 ) + 1; ?> min read
						</span>

					</div><!-- title-single__meta -->

				</div><!-- col -->
			</div><!-- row -->
		</div><!-- container -->
	</section>
<?php endwhile; ?>
