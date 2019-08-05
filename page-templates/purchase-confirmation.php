<?php /* Template Name: Purchase Confirmation */ ?>

<?php get_header('2'); ?>

<?php if ( isset( $_GET['payment_key'] ) ): ?>

	<?php

	global $edd_receipt_args;

	$session = edd_get_purchase_session();
	if ( isset( $_GET['payment_key'] ) ) {
		$payment_key = urldecode( $_GET['payment_key'] );
	} else if ( $session ) {
		$payment_key = $session['purchase_key'];
	} elseif ( $edd_receipt_args['payment_key'] ) {
		$payment_key = $edd_receipt_args['payment_key'];
	}

	// No key found
	if ( ! isset( $payment_key ) ) {
		return '<p class="edd-alert edd-alert-error">' . $edd_receipt_args['error'] . '</p>';
	}

	$payment_id    = edd_get_purchase_id_by_key( $payment_key );
	$user_can_view = edd_can_view_receipt( $payment_key );

	// Key was provided, but user is logged out. Offer them the ability to login and view the receipt
	if ( ! $user_can_view && ! empty( $payment_key ) && ! is_user_logged_in() && ! edd_is_guest_payment( $payment_id ) ) {
		global $edd_login_redirect;
		$edd_login_redirect = edd_get_current_page_url();

		ob_start();

		echo '<p class="edd-alert edd-alert-warn">' . __( 'You must be logged in to view this payment receipt.', 'easy-digital-downloads' ) . '</p>';
		edd_get_template_part( 'shortcode', 'login' );

		$login_form = ob_get_clean();

		return $login_form;
	}

	$user_can_view = apply_filters( 'edd_user_can_view_receipt', $user_can_view, $edd_receipt_args );

	// If this was a guest checkout and the purchase session is empty, output a relevant error message
	if ( empty( $session ) && ! is_user_logged_in() && ! $user_can_view ) {
		return '<p class="edd-alert edd-alert-error">' . apply_filters( 'edd_receipt_guest_error_message', __( 'Receipt could not be retrieved, your purchase session has expired.', 'easy-digital-downloads' ) ) . '</p>';
	}

	/*
	* Check if the user has permission to view the receipt
	*
	* If user is logged in, user ID is compared to user ID of ID stored in payment meta
	*
	* Or if user is logged out and purchase was made as a guest, the purchase session is checked for
	*
	* Or if user is logged in and the user can view sensitive shop data
	*
	*/


	if ( ! $user_can_view ) {
		return '<p class="edd-alert edd-alert-error">' . $edd_receipt_args['error'] . '</p>';
	}

	$payment   = get_post( $edd_receipt_args['id'] );
	$meta      = edd_get_payment_meta( $payment->ID );
	$cart      = edd_get_payment_meta_cart_details( $payment->ID, true );
	$user      = edd_get_payment_meta_user_info( $payment->ID );
	$email     = edd_get_payment_user_email( $payment->ID );
	$status    = edd_get_payment_status( $payment, true );


	?>

<?php endif; ?>


<section class="section main-section">
	<div class="container">

		<div class="row align-items-center">
			<div class="col-lg-6 order-lg-1">
				<div class="illustration float-left mb-3 mb-lg-0">
					<img src="<?php echo get_template_directory_uri(); ?>/assets/img/illustration--yay.svg"/>
				</div><!-- illustration -->
			</div>

			<div class="col-lg-6 px-5 order-lg-0">
				<h1 class="h3">Thank You For Your Purchase<span class="has-primary-color">.</span></h1>

				<?php if ( isset( $_GET['payment_key'] ) ): ?>
					<p>Below are the download links and instructions to install and activate your plugin. You will receive an e-mail with this information as well (check the spam folder).<br/>If you don't receive the e-mail within a few minutes, please <a href="<?php echo esc_url( get_permalink( get_page_by_path( 'contact-us' ) ) ); ?>">contact us</a>.</p>
				<?php else:  ?>
					<p>You will receive an e-mail with the Download links (also be sure to check the spam folder). <br/>If you don't receive the e-mail within a few minutes, please <a href="<?php echo esc_url( get_permalink( get_page_by_path( 'contact-us' ) ) ); ?>">contact us</a>.<br>Below are the instructions to install and activate your plugin. </p>
				<?php endif;  ?>

			</div>
		</div>

		<div class="row">
			<div class="col px-5">
				<?php if ( isset( $_GET['payment_key'] ) ): ?>

					<h3>Download links</h3>

					<?php if ( $cart ): ?>

						<?php foreach ( $cart as $key => $item ) : ?>

							<?php if( ! apply_filters( 'edd_user_can_view_receipt_item', true, $item ) ) : ?>
								<?php continue; // Skip this item if can't view it ?>
							<?php endif; ?>

							<?php if( empty( $item['in_bundle'] ) ) : ?>

								<?php
								$price_id       = edd_get_cart_item_price_id( $item );
								$download_files = edd_get_download_files( $item['id'], $price_id );
								?>

								<p>
									<strong>
									<?php echo esc_html( $item['name'] ); ?>
									<?php if ( edd_has_variable_prices( $item['id'] ) && ! is_null( $price_id ) ) : ?>
										<span class="edd_purchase_receipt_price_name">&nbsp;&ndash;&nbsp;<?php echo esc_html( edd_get_price_option_name( $item['id'], $price_id, $payment->ID ) ); ?></span>
									<?php endif; ?>
									</strong>
								</p>

								<?php if( edd_is_payment_complete( $payment->ID ) && edd_receipt_show_download_files( $item['id'], $edd_receipt_args, $item ) ) : ?>

										<?php
										if ( ! empty( $download_files ) && is_array( $download_files ) ) :
											foreach ( $download_files as $filekey => $file ) :
												?>
													<a class="button button--download-icon mb-3" href="<?php echo esc_url( edd_get_download_file_url( $meta['key'], $email, $filekey, $item['id'], $price_id ) ); ?>" class="edd_download_file_link"><?php echo ucwords( str_replace('-', ' ', $file['name'] ) ); ?></a>
												<?php
												do_action( 'edd_receipt_files', $filekey, $file, $item['id'], $payment->ID, $meta );
											endforeach;
										elseif ( edd_is_bundled_product( $item['id'] ) ) :
											$price_id         = edd_get_cart_item_price_id( $item );
											$bundled_products = edd_get_bundled_products( $item['id'], $price_id );
											?>

											<div class="row">

											<?php foreach ( $bundled_products as $bundle_item ) : ?>
												<div class="edd_bundled_product col-12 col-md-6 col-xl-3 d-flex flex-column mb-5">
													<p class="edd_bundled_product_name"><?php echo edd_get_bundle_item_title( $bundle_item ); ?></p>

														<?php
														$download_files = edd_get_download_files( edd_get_bundle_item_id( $bundle_item ), edd_get_bundle_item_price_id( $bundle_item ) );

														if ( $download_files && is_array( $download_files ) ) :
															foreach ( $download_files as $filekey => $file ) :
																?>
																	<a class="button button--small button--download-icon" style="margin-top: auto;" href="<?php echo esc_url( edd_get_download_file_url( $meta['key'], $email, $filekey, $bundle_item, $price_id ) ); ?>" class="edd_download_file_link">Download</a>
																<?php
																do_action( 'edd_receipt_bundle_files', $filekey, $file, $item['id'], $bundle_item, $payment->ID, $meta );
															endforeach;
														else :
															echo '<p>' . __( 'No downloadable files found for this bundled item.', 'easy-digital-downloads' ) . '</p>';
														endif;
														?>

												</div>
											<?php endforeach; ?>

											</div><!-- row -->
											<?php

										else :
											echo '<li>' . apply_filters( 'edd_receipt_no_files_found_text', __( 'No downloadable files found.', 'easy-digital-downloads' ), $item['id'] ) . '</li>';
										endif; ?>

								<?php endif; ?>


							<?php endif; ?>

						<?php endforeach; ?>

					<?php endif; ?>

				<?php endif; ?>
			</div>
		</div>

		<div class="row align-items-center mt-5">
			<div class="col-lg-6">
				<div class="illustration mb-3 mb-lg-0 float-right">
					<img src="<?php echo get_template_directory_uri(); ?>/assets/img/illustration--instructions.svg"/>
				</div><!-- illustration -->
			</div>
			<div class="col-lg-6 px-5">



				<h3 class="mt-3">Installation Instructions<span class="has-primary-color">.</span></h3>

				<ul class="list--checkmark">
					<li>Login to your website and go to the <strong>Plugins</strong> section of your admin panel.</li>
					<li>Click the <strong>Add New</strong> button.</li>
					<li>Under <strong>Install Plugins</strong>, click the <strong>Upload</strong> link.</li>
					<li>Select the plugin zip file from your computer then click the <strong>Install Now</strong> button.</li>
					<li>You should see a message stating that the plugin was installed successfully.</li>
					<li>Click the <strong>Activate Plugin</strong> link.</li>
				</ul>

			</div>
		</div>

		<?php if ( isset( $_GET['payment_key'] ) ): ?>

			<div class="row justify-content-center mt-5 mb-5">

				<div class="col-lg-6">
					<div class="rounded-box p-5">
						<h3>Your Receipt<span class="has-primary-color">.</span></h3>
						<?php echo do_shortcode('[edd_receipt]'); ?>
					</div>
				</div>
			</div>

		<?php endif; ?>

	</div>
</section>

<?php get_footer(); ?>
