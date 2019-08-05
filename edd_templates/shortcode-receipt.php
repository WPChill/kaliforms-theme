<?php
/**
 * This template is used to display the purchase summary with [edd_receipt]
 */
global $edd_receipt_args;

$payment   = get_post( $edd_receipt_args['id'] );

if( empty( $payment ) ) : ?>

	<div class="edd_errors edd-alert edd-alert-error">
		<?php _e( 'The specified receipt ID appears to be invalid', 'easy-digital-downloads' ); ?>
	</div>

<?php
return;
endif;

$meta      = edd_get_payment_meta( $payment->ID );
$cart      = edd_get_payment_meta_cart_details( $payment->ID, true );
$user      = edd_get_payment_meta_user_info( $payment->ID );
$email     = edd_get_payment_user_email( $payment->ID );
$status    = edd_get_payment_status( $payment, true );
?>


<table id="edd_purchase_receipt" class="edd-table">
	<thead>
		<?php do_action( 'edd_payment_receipt_before', $payment, $edd_receipt_args ); ?>

		<?php if ( filter_var( $edd_receipt_args['payment_id'], FILTER_VALIDATE_BOOLEAN ) ) : ?>
		<tr>
			<th><strong><?php _e( 'Payment', 'easy-digital-downloads' ); ?>:</strong></th>
			<th><?php echo edd_get_payment_number( $payment->ID ); ?></th>
		</tr>
		<?php endif; ?>
	</thead>

	<tbody>

		<tr>
			<td class="edd_receipt_payment_status"><strong><?php _e( 'Payment Status', 'easy-digital-downloads' ); ?>:</strong></td>
			<td class="edd_receipt_payment_status <?php echo strtolower( $status ); ?>"><?php echo $status; ?></td>
		</tr>

		<?php if ( filter_var( $edd_receipt_args['payment_key'], FILTER_VALIDATE_BOOLEAN ) ) : ?>
			<tr>
				<td><strong><?php _e( 'Payment Key', 'easy-digital-downloads' ); ?>:</strong></td>
				<td><?php echo edd_get_payment_meta( $payment->ID, '_edd_payment_purchase_key', true ); ?></td>
			</tr>
		<?php endif; ?>

		<?php if ( filter_var( $edd_receipt_args['payment_method'], FILTER_VALIDATE_BOOLEAN ) ) : ?>
			<tr>
				<td><strong><?php _e( 'Payment Method', 'easy-digital-downloads' ); ?>:</strong></td>
				<td><?php echo edd_get_gateway_checkout_label( edd_get_payment_gateway( $payment->ID ) ); ?></td>
			</tr>
		<?php endif; ?>
		<?php if ( filter_var( $edd_receipt_args['date'], FILTER_VALIDATE_BOOLEAN ) ) : ?>
		<tr>
			<td><strong><?php _e( 'Date', 'easy-digital-downloads' ); ?>:</strong></td>
			<td><?php echo date_i18n( get_option( 'date_format' ), strtotime( $meta['date'] ) ); ?></td>
		</tr>
		<?php endif; ?>

		<?php if ( ( $fees = edd_get_payment_fees( $payment->ID, 'fee' ) ) ) : ?>
		<tr>
			<td><strong><?php _e( 'Fees', 'easy-digital-downloads' ); ?>:</strong></td>
			<td>
				<ul class="edd_receipt_fees">
				<?php foreach( $fees as $fee ) : ?>
					<li>
						<span class="edd_fee_label"><?php echo esc_html( $fee['label'] ); ?></span>
						<span class="edd_fee_sep">&nbsp;&ndash;&nbsp;</span>
						<span class="edd_fee_amount"><?php echo edd_currency_filter( edd_format_amount( $fee['amount'] ) ); ?></span>
					</li>
				<?php endforeach; ?>
				</ul>
			</td>
		</tr>
		<?php endif; ?>

		<?php if ( filter_var( $edd_receipt_args['discount'], FILTER_VALIDATE_BOOLEAN ) && isset( $user['discount'] ) && $user['discount'] != 'none' ) : ?>
			<tr>
				<td><strong><?php _e( 'Discount(s)', 'easy-digital-downloads' ); ?>:</strong></td>
				<td><?php echo $user['discount']; ?></td>
			</tr>
		<?php endif; ?>

		<?php if( edd_use_taxes() ) : ?>
			<tr>
				<td><strong><?php _e( 'Tax', 'easy-digital-downloads' ); ?>:</strong></td>
				<td><?php echo edd_payment_tax( $payment->ID ); ?></td>
			</tr>
		<?php endif; ?>

		<?php if ( filter_var( $edd_receipt_args['price'], FILTER_VALIDATE_BOOLEAN ) ) : ?>

			<tr>
				<td><strong><?php _e( 'Subtotal', 'easy-digital-downloads' ); ?>:</strong></td>
				<td>
					<?php echo edd_payment_subtotal( $payment->ID ); ?>
				</td>
			</tr>

			<tr>
				<td><strong><?php _e( 'Total Price', 'easy-digital-downloads' ); ?>:</strong></td>
				<td><?php echo edd_payment_amount( $payment->ID ); ?></td>
			</tr>

		<?php endif; ?>

		<?php do_action( 'edd_payment_receipt_after', $payment, $edd_receipt_args ); ?>
	</tbody>
</table>

<?php do_action( 'edd_payment_receipt_after_table', $payment, $edd_receipt_args ); ?>


