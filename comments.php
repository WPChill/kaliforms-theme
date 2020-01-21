<?php
/**
 * The template for displaying comments.
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link    https://codex.wordpress.org/Template_Hierarchy
 *
 * @package modula
 */

/**
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
if ( ! comments_open() ) {
	return;
}
?>
<section class="section comments-section pt-0">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-6">
				<div id="comments" class="comments-area">
					<?php if ( have_comments() ) : ?>
						<h3 class="comments-title">
							<?php echo esc_html__( 'Comments', 'modula' ); ?>
							<span><?php echo get_comments_number(); ?></span>
						</h3>

						<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
							<nav id="comment-nav-above" class="navigation comment-navigation">
								<h2 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'modula' ); ?></h2>
								<div class="nav-links">

									<div class="nav-previous"><?php previous_comments_link( esc_html__( 'Older Comments', 'modula' ) ); ?></div>
									<div class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments', 'modula' ) ); ?></div>

								</div><!-- .nav-links -->
							</nav><!-- #comment-nav-above -->
						<?php endif; ?>

						<ol class="comment-list">
							<?php
							wp_list_comments(
								array(
									'style'       => 'ol',
									'short_ping'  => true,
									'avatar_size' => 60,
								)
							);
							?>
						</ol><!-- .comment-list -->

						<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
							<nav id="comment-nav-below" class="navigation comment-navigation" role="navigation">
								<h2 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'modula' ); ?></h2>
								<div class="nav-links">

									<div class="nav-previous"><?php previous_comments_link( esc_html__( 'Older Comments', 'modula' ) ); ?></div>
									<div class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments', 'modula' ) ); ?></div>

								</div><!-- .nav-links -->
							</nav><!-- #comment-nav-below -->
						<?php endif; ?>

					<?php endif; ?>

					<?php if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
						<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'modula' ); ?></p>
					<?php endif; ?>

					<?php comment_form(); ?>

				</div><!-- #comments -->
			</div>
		</div>
	</div>
</section>

