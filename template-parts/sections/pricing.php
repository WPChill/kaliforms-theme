<?php

//localhost
//$download1_id = 17;
//$download2_id = 17;
//$download3_id = 17;
//$download4_id = 17;

//kaliforms.com
$download1_id = 90;
$download2_id = 88;
$download3_id = 86;
$download4_id = 84;

wp_enqueue_script('waypoints');

$utm_medium = isset($_GET['utm_medium']) ? $_GET['utm_medium'] : '';
$upgrading  = false;

//Agency, Business, Trio, Basic
$download_ids = array($download1_id, $download2_id, $download3_id, $download4_id);

if (isset($_GET['discount'])) {

    $discount = new EDD_Discount($_GET['discount'], true);
    if ($discount->status === 'active') {
        EDD()->session->set('cart_discounts', $_GET['discount']);
    }
}
$cart_discounts = edd_get_cart_discounts();

if (isset($_GET['license'])) {
    $license_by_key = edd_software_licensing()->get_license($_GET['license'], true);

    if ($license_by_key) {
        $upgrading           = true;
        $download_by_license = $license_by_key->download;
        $upgrades            = edd_sl_get_license_upgrades($license_by_key->ID);
    }
}

$downloads = array();
foreach ($download_ids as $id) {
    $download = edd_get_download($id);

    if ($upgrading) {
        $download->upgrade_id = st_get_upgrade_id_by_download_id($upgrades, $download->ID);
        if ($download->upgrade_id) {
            $download->upgrade_cost = edd_sl_get_license_upgrade_cost($license_by_key->ID, $download->upgrade_id);
        }
        $download->higher_plan = array_search($download->id, $download_ids) >= array_search($download_by_license->id, $download_ids) ? false : true;
    }

    $downloads[] = $download;
}

?>

<section class="section pricing-section">

	<div class="container">

		<div class="section__heading row justify-content-center">
			<div class="col-lg-6 text-center">
				<h1 class="h2">The Ideal WordPress Form Builder<span class="has-primary-color">.</span></h1>
				<p>Choose the perfect plan for you, risk free with our 14 day money-back guarantee.</p>

				<div class="row checkout-badges align-items-center mt-3 mb-3">
					<div class="col-6 col-sm-3 text-center mb-3 mb-sm-0">
						<div title="SSL Encrypted Payment" class="checkout-badges__ssl">
							<?php echo file_get_contents(get_template_directory_uri() . '/assets/img/checkout-badges/ssl.svg'); ?>
						</div>
					</div>
					<div class="col-6 col-sm-4 text-center mb-3 mb-sm-0">
						<div class="checkout-badges__cc">
							<?php echo file_get_contents(get_template_directory_uri() . '/assets/img/checkout-badges/cc.svg'); ?>
						</div>
					</div>
					<div class="col-6 col-sm-2 text-center">
						<div title="Norton Secured Transaction" class="checkout-badges__norton">
							<?php echo file_get_contents(get_template_directory_uri() . '/assets/img/checkout-badges/norton-secured.svg'); ?>
						</div>
					</div>
					<div class="col-6 col-sm-3 text-center">
						<div title="McAfee Secured Transaction" class="checkout-badges__mcafee">
							<?php echo file_get_contents(get_template_directory_uri() . '/assets/img/checkout-badges/mcafee.svg'); ?>
						</div>
					</div>
				</div><!-- row -->

			</div>
		</div>

	</div><!-- container -->

	<a id="pricing" style="position: relative; top: -90px;"></a>

	<div class="container main-table">

		<div class="pricing-table pricing-table--header row">

			<div class="col">

				<div class="pricing-table__message visible-xs waypoint">
					<div class="row align-items-center">
						<div class="col-xs-10">
						swipe left to see the entire table
						</div>
						<div class="col-xs-2">
							<i class="icon-right-open-big"></i>
						</div>
					</div>
				</div><!-- pricing-table__message -->

			</div><!-- col -->

			<?php foreach ($downloads as $download): ?>

				<div class="col <?php echo isset($download->higher_plan) && $download->higher_plan === false ? 'pricing-table-inactive' : ''; ?>">

					<?php if ($download->post_title === 'Plus'): ?>
						<div class="pricing-table__label">Most Popular</div>
					<?php endif;?>

					<h3 class="pricing-table__title mb-3"><?php echo $download->post_title; ?><span class="has-primary-color">.</span></h3>

					<?php if ($upgrading && $download->higher_plan): ?>
						<div class="pricing-table__initial-price">
							$<?php echo floor(edd_get_download_price($download->ID)); ?>
						</div>
					<?php elseif (count($cart_discounts) > 0): ?>
						<div class="pricing-table__initial-price">
							$<?php echo floor(edd_get_download_price($download->ID)); ?>
						</div>
					<?php endif;?>

					<div class="pricing-table__price mb-3">
						<?php if ($upgrading && $download->higher_plan): ?>
							<sup>$</sup><?php echo $download->upgrade_cost; ?>
						<?php else: ?>
							<sup>$</sup><?php echo st_edd_get_download_price($download->ID); ?>
						<?php endif;?>
					</div>

					<p class="pricing-table__description mb-3">
						<?php echo $download->post_excerpt; ?>
					</p>

					<?php if ($upgrading && $download->higher_plan): ?>
						<div class="pricing-table__savings">
							<p class="wp-block-machothemes-highlight mb-2">
								<mark class="wp-block-machothemes-highlight__content">$<?php echo edd_get_download_price($download->ID) - $download->upgrade_cost; ?> savings</mark>
							</p>
						</div>
					<?php elseif (count($cart_discounts) > 0): ?>
						<div class="pricing-table__savings">
							<p class="wp-block-machothemes-highlight mb-2">
								<mark class="wp-block-machothemes-highlight__content">$<?php echo edd_get_download_price($download->ID) - st_edd_get_download_price($download->ID); ?> savings</mark>
							</p>
						</div>
					<?php endif;?>

					<?php if ($upgrading && $download->higher_plan): ?>
						<a class="button pricing-table__button" href="<?php echo esc_url(edd_sl_get_license_upgrade_url($license_by_key->ID, $download->upgrade_id)); ?>" title="Upgrade">Upgrade</a>
					<?php else: ?>
						<?php echo do_shortcode('[purchase_link price="0" class="button pricing-table__button" text="Buy Now" id="' . $download->ID . '" direct="true"]') ?>
					<?php endif;?>

				</div><!-- col -->

			<?php endforeach;?>

		</div>

		<div class="pricing-table row">
			<div class="col">
				Supported Sites
				<span class="tooltip">
					<i class="icon-question-circle"></i>
					<span class="tooltip__text">The number of sites on which you can use Kali Forms.</span>
				</span>
			</div>

			<?php foreach ($downloads as $download): ?>
				<div class="col">
					<?php echo st_nr_of_sites($download->ID); ?>
				</div>
			<?php endforeach;?>

		</div><!-- row -->

		<div class="pricing-table row">
			<div class="col">
				Number of Forms
				<span class="tooltip">
					<i class="icon-question-circle"></i>
					<span class="tooltip__text">The number of forms you can create on your website.</span>
				</span>
			</div>
			<div class="col">
				<strong>Unlimited Forms</strong>
			</div>
			<div class="col">
				<strong>Unlimited Forms</strong>
			</div>
			<div class="col">
				<strong>Unlimited Forms</strong>
			</div>
			<div class="col">
				<strong>Unlimited Forms</strong>
			</div>
		</div><!-- row -->

		<div class="pricing-table row">
			<div class="col">
				1 Year of Free Updates
				<span class="tooltip">
					<i class="icon-question-circle"></i>
					<span class="tooltip__text">You’ll have access to free updates for 1 year or until you cancel your yearly subscription.</span>
				</span>
			</div>
			<div class="col">
				<i class="icon-ok"></i>
			</div>
			<div class="col">
				<i class="icon-ok"></i>
			</div>
			<div class="col">
				<i class="icon-ok"></i>
			</div>
			<div class="col">
				<i class="icon-ok"></i>
			</div>
		</div><!-- row -->

		<div class="pricing-table row">
			<div class="col">
				1 Year of Support
				<span class="tooltip">
					<i class="icon-question-circle"></i>
					<span class="tooltip__text">In case you ever run into issues with our plugin (unlikely), feel free to reach out to our support at any time.</span>
				</span>
			</div>
			<div class="col">
				<i class="icon-ok"></i>
			</div>
			<div class="col">
				<i class="icon-ok"></i>
			</div>
			<div class="col">
				<i class="icon-ok"></i>
			</div>
			<div class="col">
				<i class="icon-ok"></i>
			</div>
		</div><!-- row -->

		<div class="pricing-table row">
			<div class="col">
				Advanced Fields
				<span class="tooltip">
					<i class="icon-question-circle"></i>
					<span class="tooltip__text">Easily collect information from users through a greater number of field types.</span>
				</span>
			</div>
			<div class="col">
				<i class="icon-ok"></i>
			</div>
			<div class="col">
				<i class="icon-ok"></i>
			</div>
			<div class="col">
				<i class="icon-ok"></i>
			</div>
			<div class="col">
				<i class="icon-ok"></i>
			</div>
		</div><!-- row -->

		<div class="pricing-table row">
			<div class="col">
				Conditional Logic
				<span class="tooltip">
					<i class="icon-question-circle"></i>
					<span class="tooltip__text">Hide and show fields in your forms based on the user selections.</span>
				</span>
			</div>
			<div class="col">
				<i class="icon-ok"></i>
			</div>
			<div class="col">
				<i class="icon-ok"></i>
			</div>
			<div class="col">
				<i class="icon-ok"></i>
			</div>
			<div class="col">
				<i class="icon-ok"></i>
			</div>
		</div><!-- row -->

		<div class="pricing-table row">
			<div class="col">
				Multi-Page Forms
				<span class="tooltip">
					<i class="icon-question-circle"></i>
					<span class="tooltip__text">Group your form fields on different pages for a better submission process.</span>
				</span>
			</div>
			<div class="col">
				<i class="icon-ok"></i>
			</div>
			<div class="col">
				<i class="icon-ok"></i>
			</div>
			<div class="col">
				<i class="icon-ok"></i>
			</div>
			<div class="col">
				<i class="icon-ok"></i>
			</div>
		</div><!-- row -->

		<div class="pricing-table row">
			<div class="col">
				Submissions Handling
				<span class="tooltip">
					<i class="icon-question-circle"></i>
					<span class="tooltip__text">Store the submission data in your database for future reference.</span>
				</span>
			</div>
			<div class="col">
				<i class="icon-ok"></i>
			</div>
			<div class="col">
				<i class="icon-ok"></i>
			</div>
			<div class="col">
				<i class="icon-ok"></i>
			</div>
			<div class="col">
				<i class="icon-ok"></i>
			</div>
		</div><!-- row -->

		<div class="pricing-table row">
			<div class="col">
				Form Notifications
				<span class="tooltip">
					<i class="icon-question-circle"></i>
					<span class="tooltip__text">Trigger one or multiple email notifications on each form submission.</span>
				</span>
			</div>
			<div class="col">
				<i class="icon-ok"></i>
			</div>
			<div class="col">
				<i class="icon-ok"></i>
			</div>
			<div class="col">
				<i class="icon-ok"></i>
			</div>
			<div class="col">
				<i class="icon-ok"></i>
			</div>
		</div><!-- row -->

		<div class="pricing-table row">
			<div class="col">
				reCAPTCHA Integration
				<span class="tooltip">
					<i class="icon-question-circle"></i>
					<span class="tooltip__text">Prevent spam submissions through the Google reCAPTCHA service.</span>
				</span>
			</div>
			<div class="col">
				<i class="icon-ok"></i>
			</div>
			<div class="col">
				<i class="icon-ok"></i>
			</div>
			<div class="col">
				<i class="icon-ok"></i>
			</div>
			<div class="col">
				<i class="icon-ok"></i>
			</div>
		</div><!-- row -->

		<div class="pricing-table row">
			<div class="col">
				Akismet Integration
				<span class="tooltip">
					<i class="icon-question-circle"></i>
					<span class="tooltip__text">Prevent spam submissions through the Akismet service.</span>
				</span>
			</div>
			<div class="col">
				<i class="icon-ok"></i>
			</div>
			<div class="col">
				<i class="icon-ok"></i>
			</div>
			<div class="col">
				<i class="icon-ok"></i>
			</div>
			<div class="col">
				<i class="icon-ok"></i>
			</div>
		</div><!-- row -->

		<div class="pricing-table row">
			<div class="col">
				Form Templates
				<span class="tooltip">
					<i class="icon-question-circle"></i>
					<span class="tooltip__text">A number of predefined templates that can be added to your form in several mouse clicks.</span>
				</span>
			</div>
			<div class="col">
				<i class="icon-ok"></i>
			</div>
			<div class="col">
				<i class="icon-ok"></i>
			</div>
			<div class="col">
				<i class="icon-ok"></i>
			</div>
			<div class="col">
				<i class="icon-ok"></i>
			</div>
		</div><!-- row -->

		<div class="pricing-table row">
			<div class="col">
				Form Calculator
				<span class="tooltip">
					<i class="icon-question-circle"></i>
					<span class="tooltip__text">Perform simple or complex calculations through your form fields.</span>
				</span>
			</div>
			<div class="col">
				<i class="icon-ok"></i>
			</div>
			<div class="col">
				<i class="icon-ok"></i>
			</div>
			<div class="col">
				<i class="icon-ok"></i>
			</div>
			<div class="col">
				<i class="icon-ok"></i>
			</div>
		</div><!-- row -->

		<div class="pricing-table row">
			<div class="col">
				PayPal integration
				<span class="tooltip">
					<i class="icon-question-circle"></i>
					<span class="tooltip__text">Allow payments through the PayPal payment gateway.</span>
				</span>
			</div>
			<div class="col">
				<i class="icon-ok"></i>
			</div>
			<div class="col">
				<i class="icon-ok"></i>
			</div>
			<div class="col">
				<i class="icon-ok"></i>
			</div>
			<div class="col">
				<i class="icon-ok"></i>
			</div>
		</div><!-- row -->
		<div class="pricing-table row">
			<div class="col">
				Slack
				<span class="tooltip">
					<i class="icon-question-circle"></i>
					<span class="tooltip__text">Send Slack Notifications</span>
				</span>
			</div>
			<div class="col">
				<i class="icon-ok"></i>
			</div>
			<div class="col">
				<i class="icon-ok"></i>
			</div>
			<div class="col">
				<i class="icon-ok"></i>
			</div>
			<div class="col">
				<i class="icon-ok"></i>
			</div>
		</div><!-- row -->
		<div class="pricing-table row">
			<div class="col">
				MailChimp
				<span class="tooltip">
					<i class="icon-question-circle"></i>
					<span class="tooltip__text">Add users to your MailChimp newsletter</span>
				</span>
			</div>
			<div class="col">
				<i class="icon-ok"></i>
			</div>
			<div class="col">
				<i class="icon-ok"></i>
			</div>
			<div class="col">
				<i class="icon-ok"></i>
			</div>
			<div class="col">
				<i class="icon-ok"></i>
			</div>
		</div><!-- row -->
		<div class="pricing-table row">
			<div class="col">
				MailerLite
				<span class="tooltip">
					<i class="icon-question-circle"></i>
					<span class="tooltip__text">Add users to your MailerLite newsletter</span>
				</span>
			</div>
			<div class="col">
				<i class="icon-ok"></i>
			</div>
			<div class="col">
				<i class="icon-ok"></i>
			</div>
			<div class="col">
				<i class="icon-ok"></i>
			</div>
			<div class="col">
				<i class="icon-ok"></i>
			</div>
		</div><!-- row -->
		<div class="pricing-table row">
			<div class="col">
				ConvertKit
				<span class="tooltip">
					<i class="icon-question-circle"></i>
					<span class="tooltip__text">Add users to your ConvertKit newsletter</span>
				</span>
			</div>
			<div class="col">
				<i class="icon-ok"></i>
			</div>
			<div class="col">
				<i class="icon-ok"></i>
			</div>
			<div class="col">
				<i class="icon-ok"></i>
			</div>
			<div class="col">
				<i class="icon-ok"></i>
			</div>
		</div><!-- row -->
		<div class="pricing-table row">
			<div class="col">
				ActiveCampaign
				<span class="tooltip">
					<i class="icon-question-circle"></i>
					<span class="tooltip__text">Add users to your ActiveCampaign newsletter</span>
				</span>
			</div>
			<div class="col">
				<i class="icon-ok"></i>
			</div>
			<div class="col">
				<i class="icon-ok"></i>
			</div>
			<div class="col">
				<i class="icon-ok"></i>
			</div>
			<div class="col">
				<i class="icon-ok"></i>
			</div>
		</div><!-- row -->
		<div class="pricing-table row">
			<div class="col">
				HubSpot
				<span class="tooltip">
					<i class="icon-question-circle"></i>
					<span class="tooltip__text">HubSpot integration</span>
				</span>
			</div>
			<div class="col">
				<i class="icon-ok"></i>
			</div>
			<div class="col">
				<i class="icon-ok"></i>
			</div>
			<div class="col">
				<i class="icon-ok"></i>
			</div>
			<div class="col">
				<i class="icon-cancel"></i>
			</div>
		</div><!-- row -->
		<div class="pricing-table row">
			<div class="col">
				Google Analytics
				<span class="tooltip">
					<i class="icon-question-circle"></i>
					<span class="tooltip__text">Track user behaviour on your forms</span>
				</span>
			</div>
			<div class="col">
				<i class="icon-ok"></i>
			</div>
			<div class="col">
				<i class="icon-ok"></i>
			</div>
			<div class="col">
				<i class="icon-ok"></i>
			</div>
			<div class="col">
				<i class="icon-cancel"></i>
			</div>
		</div><!-- row -->
		<div class="pricing-table row">
			<div class="col">
				Stripe integration
				<span class="tooltip">
					<i class="icon-question-circle"></i>
					<span class="tooltip__text">Accept payments through stripe</span>
				</span>
			</div>
			<div class="col">
				<i class="icon-ok"></i>
			</div>
			<div class="col">
				<i class="icon-ok"></i>
			</div>
			<div class="col">
				<i class="icon-cancel"></i>
			</div>
			<div class="col">
				<i class="icon-cancel"></i>
			</div>
		</div><!-- row -->
		<div class="pricing-table row">
			<div class="col">
				Enhanced e-commerce
				<span class="tooltip">
					<i class="icon-question-circle"></i>
					<span class="tooltip__text">
					Increased e-commerce flexbility by adding multiple product fields, total field, wire transfer and payment log
					</span>
				</span>
			</div>
			<div class="col">
				<i class="icon-ok"></i>
			</div>
			<div class="col">
				<i class="icon-ok"></i>
			</div>
			<div class="col">
				<i class="icon-cancel"></i>
			</div>
			<div class="col">
				<i class="icon-cancel"></i>
			</div>
		</div><!-- row -->
		<div class="pricing-table row">
			<div class="col">
				SMS Notifications
				<span class="tooltip">
					<i class="icon-question-circle"></i>
					<span class="tooltip__text">Send SMS Notifications on form submit</span>
				</span>
			</div>
			<div class="col">
				<i class="icon-ok"></i>
			</div>
			<div class="col">
				<i class="icon-ok"></i>
			</div>
			<div class="col">
				<i class="icon-cancel"></i>
			</div>
			<div class="col">
				<i class="icon-cancel"></i>
			</div>
		</div><!-- row -->
		<div class="pricing-table row">
			<div class="col">
				User Registration
				<span class="tooltip">
					<i class="icon-question-circle"></i>
					<span class="tooltip__text">Create, login and edit users</span>
				</span>
			</div>
			<div class="col">
				<i class="icon-ok"></i>
			</div>
			<div class="col">
				<i class="icon-ok"></i>
			</div>
			<div class="col">
				<i class="icon-cancel"></i>
			</div>
			<div class="col">
				<i class="icon-cancel"></i>
			</div>
		</div><!-- row -->
		<div class="pricing-table row">
			<div class="col">
				Digital Signature
				<span class="tooltip">
					<i class="icon-question-circle"></i>
					<span class="tooltip__text">Add digital signatures to your form</span>
				</span>
			</div>
			<div class="col">
				<i class="icon-ok"></i>
			</div>
			<div class="col">
				<i class="icon-ok"></i>
			</div>
			<div class="col">
				<i class="icon-cancel"></i>
			</div>
			<div class="col">
				<i class="icon-cancel"></i>
			</div>
		</div><!-- row -->
		<div class="pricing-table pricing-table--last row">
			<div class="col text-left">
				<span class="mb-0"><small>Prices are listed in USD<br/> and don't include VAT</small></span>
			</div>

			<?php foreach ($downloads as $download): ?>

				<div class="col <?php echo isset($download->higher_plan) && $download->higher_plan === false ? 'pricing-table-inactive' : ''; ?>">

					<?php if ($upgrading && $download->higher_plan): ?>
						<a class="button pricing-table__button" href="<?php echo esc_url(edd_sl_get_license_upgrade_url($license_by_key->ID, $download->upgrade_id)); ?>" title="Upgrade">Upgrade</a>
					<?php else: ?>
						<?php echo do_shortcode('[purchase_link price="0" class="button pricing-table__button" text="Buy Now" id="' . $download->ID . '" direct="true"]') ?>
					<?php endif;?>

				</div><!-- col -->

			<?php endforeach;?>

		</div><!-- row -->

		<div class="row mt-5 mb-5">
			<div class="col">
				<div class="pricing-message p-5 p-lg-4 p-xl-5">
					<div class="row align-items-center">
						<div class="col-md-2 text-center">
							<img class="mb-2 mb-md-0" src="<?php echo get_template_directory_uri(); ?>/assets/img/illustration-8.svg" width="100"/>
						</div>
						<div class="col-md-10">
							<h4>100% No-Risk Money Back Guarantee <span class="has-primary-color">!</span></h4>
							<p class="mb-0">You are fully protected by our 100% No-Risk-Double-Guarantee.  If you don’t like Kali Forms over the next 14 days, then we will happily refund 100% of your money. No questions asked.</p>
						</div>
					</div><!-- row -->
				</div>
			</div>
		</div><!-- row -->

	</div><!-- container -->

</section>
