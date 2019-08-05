
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

<?php if ( has_post_thumbnail() ) : ?>
	<div class="post__thumbnail">
		<a href="<?php echo esc_url( get_the_permalink() ); ?>">
			<?php the_post_thumbnail( 'st_medium_cropped' ); ?>
		</a>
	</div>
<?php endif; ?>

<div class="post__content p-4">
	<h6 class="post__title mb-0">
		<a href="<?php echo esc_url( get_the_permalink() ); ?>"><?php echo esc_html( get_the_title() ); ?></a>
	</h6>
</div>

</article>

