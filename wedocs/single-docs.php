<?php get_header(); ?>

<?php wp_enqueue_script( 'waypoints' ); ?>

<?php get_template_part( 'template-parts/sections/title-single-docs' ); ?>

<?php
	/**
	 * @since 1.4
	 *
	 * @hooked wedocs_template_wrapper_start - 10
	 */
	do_action( 'wedocs_before_main_content' );
?>

<section class="section main-section pt-4">
	<div class="container">
		<div class="row">

			<div class="col-lg-3">

				<div class="post-sidebar">

					<div class="doc-search mb-4">
						<input type="search" data-post-type="docs" data-nonce="<?php echo wp_create_nonce("search_articles_nonce"); ?>" placeholder="Search"/>
						<div class="doc-search__results"></div>
					</div>

					<?php if('1' == get_post_meta( get_the_id(), '_ez-toc-insert', true )): ?>
						<?php echo do_shortcode('[toc]');  ?>
					<?php endif; ?>

				</div>

			</div>

			<?php if ( have_posts() ) : ?>
				<?php while ( have_posts() ) : ?>
					<?php the_post(); ?>
					<div class="post-content col-lg-6">
						<?php
							the_content( sprintf(
								/* translators: %s: Name of current post. */
								wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'wedocs' ), array( 'span' => array( 'class' => array() ) ) ),
								the_title( '<span class="screen-reader-text">"', '"</span>', false )
							) );

							wp_link_pages( array(
								'before' => '<div class="page-links">' . esc_html__( 'Docs:', 'wedocs' ),
								'after'  => '</div>',
							) );

							$children = wp_list_pages("title_li=&order=menu_order&child_of=". $post->ID ."&echo=0&post_type=" . $post->post_type);

							if ( $children ) {
								echo '<div class="article-child well mt-3">';
									echo '<h3>' . __( 'Articles', 'wedocs' ) . '</h3>';
									echo '<ul>';
										echo $children;
									echo '</ul>';
								echo '</div>';
							}

							$tags_list = wedocs_get_the_doc_tags( $post->ID, '', ', ' );

							if ( $tags_list ) {
								printf( '<span class="tags-links"><span class="screen-reader-text">%1$s </span>%2$s</span>',
									_x( 'Tags', 'Used before tag names.', 'wedocs' ),
									$tags_list
								);
							}
						?>

						<footer class="entry-footer wedocs-entry-footer">
							<div class="wedocs-article-author" itemprop="author" itemscope itemtype="https://schema.org/Person">
								<meta itemprop="name" content="<?php echo get_the_author(); ?>" />
								<meta itemprop="url" content="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>" />
							</div>
						</footer>

						<?php if ( wedocs_get_option( 'helpful', 'wedocs_settings', 'on' ) == 'on' ): ?>
							<?php wedocs_get_template_part( 'content', 'feedback' ); ?>
						<?php endif; ?>

					</div><!-- post-content -->

				<?php endwhile; ?>
			<?php endif; ?>
		</div>
	</div>
</section>

<?php //wedocs_get_template_part( 'docs', 'sidebar' ); ?>

<?php
	/**
	 * @since 1.4
	 *
	 * @hooked wedocs_template_wrapper_end - 10
	 */
	do_action( 'wedocs_after_main_content' );
?>

<?php get_template_part( 'template-parts/sections/submit-ticket' ); ?>

<?php get_footer(); ?>