<?php /* Template Name: Documentation */ ?>

<?php get_header(); ?>

<section class="section title-section">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-6">
				<h1 class="text-center h2">Looking for help<span class="has-primary-color">?</span></h1>
				<div class="doc-search">
					<input type="search" data-post-type="docs" data-nonce="<?php echo wp_create_nonce("search_articles_nonce"); ?>" placeholder="Search our Documentation"/>
					<div class="doc-search__results"></div>
				</div>
			</div>
		</div>
	</div>
</section>

<section class="section main-section pt-0">
	<div class="container">
		<?php if ( have_posts() ) : ?>
			<?php while ( have_posts() ) : ?>
				<?php the_post(); ?>
				<?php the_content(); ?>
			<?php endwhile; ?>
		<?php endif; ?>
	</div>
</section>

<?php //get_template_part( 'template-parts/sections/submit-ticket' ); ?>

<?php get_footer(); ?>
