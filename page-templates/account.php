<?php /* Template Name: Account */ ?>

<?php get_header(); ?>

<?php get_template_part( 'template-parts/sections/title' ); ?>

<?php if( is_user_logged_in() ): ?>

	<section class="section main-section pt-0">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="rounded-box p-5 mb-4">
						<a class="anchor" name="purchase-history"></a>
						<h3 class="mb-3">Purchase History</h3>
						<?php if ( have_posts() ) : ?>
							<?php while ( have_posts() ) : ?>
								<?php the_post(); ?>
								<?php the_content(); ?>
							<?php endwhile; ?>
						<?php endif; ?>
					</div>
				</div>
				<div class="col-12">
					<div class="rounded-box p-5 mb-4">
						<a class="anchor" name="subscriptions"></a>
						<h3 class="mb-3">Subscriptions</h3>
						<?php echo do_shortcode('[edd_subscriptions]'); ?>
					</div>
				</div>
				<div class="col-12">
					<div class="rounded-box p-5 mb-4">
						<a class="anchor" name="account-information"></a>
						<h3 class="mb-3">Account Information</h3>
						<?php echo do_shortcode('[edd_profile_editor]'); ?>
					</div>
				</div>
				<div class="col-md-6">
					<div class="rounded-box p-5">
						<a class="anchor" name="download-history"></a>
						<h3 class="mb-3">Download History</h3>
						<?php echo do_shortcode('[download_history]'); ?>
					</div>
				</div>
				<div class="col-md-6">
					<div class="rounded-box p-5">
						<h3 class="mb-3">Login Status</h3>
						<?php $current_user = wp_get_current_user(); ?>
						<p>You are currently logged in as: <strong><?php echo $current_user->user_login; ?></strong></p>
						<a class="button button--small" href="<?php echo wp_logout_url( home_url() ); ?>">Log out?</a>
					</div>
				</div>
			</div>
		</div>
	</section>

<?php else: ?>

	<section class="section main-section pt-0">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-6">
					<div class="rounded-box p-5 mb-4">
						<?php echo do_shortcode('[edd_login]');?>
					</div>
				</div>
			</div>
		</div>
	</section>

<?php endif; ?>

<?php get_footer(); ?>

