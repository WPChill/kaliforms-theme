<?php /* Template Name: Become an Affiliate */ ?>

<?php get_header(); ?>

<?php get_template_part( 'template-parts/sections/title' ); ?>

<section class="section main-section pt-0">
	<div class="container">

		<div class="row align-items-center">
			<div class="col-lg-6">
				<div class="illustration float-right mb-3 mb-lg-0">
					<?php echo file_get_contents( get_template_directory_uri() . '/assets/img/illustration-12.svg' ); ?>
				</div><!-- illustration -->
			</div>
			<div class="col-lg-6 px-lg-5 mb-3 mb-lg-0">
				<h2>Learn more about our Affiliate Program<span class="has-primary-color">!</span></h2>
				<p>First things first, affiliates are a very important part of our growth strategy. </p>
				<p>We have many successful affiliate partners who profit from our program because of our continued commitment to creating opportunities for our affiliates to earn commissions.</p>
				<p>As an affiliate, you’ll earn a <?php echo affiliate_wp()->settings->get( 'referral_rate', 20 ); ?>% commission from everyone you refer.</p>
			</div>
		</div>



			<div class="row align-items-center">
				<div class="col-lg-6 order-lg-1">
					<div class="illustration mb-3 mb-lg-0">
						<?php echo file_get_contents( get_template_directory_uri() . '/assets/img/illustration-14.svg' ); ?>
					</div><!-- illustration -->
				</div>
				<div class="col-lg-6 px-lg-5 order-lg-0 mb-3 mb-lg-0">
					<h2>Join now<span class="has-primary-color">.</span></h2>
                    <a class="button button--xl mb-0" target="_blank" rel="nofollow noopener noreferrer" href="https://account.shareasale.com/shareasale.cfm?merchantID=98922&storeID=2&source=affiliateSignupPage">Join our affiliate program</a>
				</div>
			</div>

			<div class="row align-items-center">
				<div class="col-lg-6">
					<div class="illustration float-right mb-3 mb-lg-0">
						<?php echo file_get_contents( get_template_directory_uri() . '/assets/img/illustration-10.svg' ); ?>
					</div><!-- illustration -->
				</div>
				<div class="col-lg-6 px-lg-5 mb-3 mb-lg-0">
					<h2>The Process<span class="has-primary-color">.</span></h2>
					<p>Joining the Affiliate Program is pretty simple. Use the form above to create an affiliate account. We’ll then auto-generate a password and email it to you. You’ll be given share links instantly if you want to start sharing Kali Forms immediately. Check your email for the affiliate dashboard link and your password. Once you sign in you can see all your stats, enter your PayPal payment information, and download any logos or assets you need.</p>
					<p>Start promoting! You’ll see any clicks or activity reflected in your account.</p>
					<p>It’s good to have you on board!</p>
					<p>Have questions related to the affiliate program? Click here to <a href="/contact-us">get in touch</a>.</p>
				</div>
			</div>


		<div class="row align-items-center">
			<div class="col-lg-6 order-lg-1">
				<div class="illustration mb-3 mb-lg-1">
					<?php echo file_get_contents( get_template_directory_uri() . '/assets/img/illustration-13.svg' ); ?>
				</div><!-- illustration -->
			</div>
			<div class="col-lg-6 px-lg-5 order-lg-0 mb-3 mb-lg-0">
				<h2>Promotion Ideas<span class="has-primary-color">.</span></h2>
				<ul class="list--checkmark">
					<li>Write a Kali Forms vs. _________ (whatever forms plugin you are most familiar with or personally switched from) post and publish that on your blog and send it out to your email list.</li>
					<li>Add details about Kali Forms, along with your affiliate link, to any pages or posts you have related to WordPress and web development.</li>
					<li>Share how you use Kali Forms and what you were able to create with it and link to kaliforms.com using your affiliate link.</li>
					<li>Add Kali Forms to your Resources page on your blog as one of your recommended WordPress plugins.</li>
					<li>And, of course, anything else you can think of!</li>
				</ul>
			</div>
		</div>



	</div>
</section>

<?php get_footer(); ?>
