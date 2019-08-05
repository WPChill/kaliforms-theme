<?php while ( have_posts() ) : ?>
	<?php the_post(); ?>
	<section class="section title-single-docs-section pb-4">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-6">
					<h1 class="h2"><?php echo esc_html( get_the_title() ); ?></h1>
				</div>
			</div><!-- row -->
			<div class="row justify-content-center">
				<div class="col-md-6 entry-meta">
					<?php modula_docs_breadcrumbs(); ?>
					<span class="visible-sm visible-md visible-lg">&middot;</span>
					<meta itemprop="datePublished" content="<?php echo get_the_time( 'c' ); ?>"/>
					<time itemprop="dateModified" datetime="<?php echo esc_attr( get_the_modified_date( 'c' ) ); ?>"><?php printf( __( 'Updated on %s', 'wedocs' ), get_the_modified_date() ); ?></time>
				</div>
			</div><!-- row -->
		</div><!-- container -->
	</section>
<?php endwhile; ?>
