<?php /* Template Name: Invoice */ ?>

<?php get_header(); ?>

<?php get_template_part( 'template-parts/sections/title' ); ?>

<section class="section main-section pt-0">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-7">
				<div class="rounded-box p-5">
					<?php echo do_shortcode('[edd_invoices]'); ?>
				</div>
			</div>
		</div>
	</div>
</section>

<?php get_template_part( 'template-parts/sections/cta' ); ?>
<?php get_template_part( 'template-parts/sections/latest-post' ); ?>

<?php get_footer(); ?>

