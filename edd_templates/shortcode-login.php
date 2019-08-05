<?php
/**
 * This template is used to display the login form with [edd_login]
 */
global $edd_login_redirect;
if ( ! is_user_logged_in() ) : ?>

	<form id="edd_login_form" class="edd_form" action="" method="post">
		<fieldset class="mb-0">
			<h3 class="mb-3"><?php _e( 'Log into Your Account', 'easy-digital-downloads' ); ?></h3>
			<?php edd_print_errors(); ?>
			<?php do_action( 'edd_login_fields_before' ); ?>
			<p class="edd-login-username">
				<input name="edd_user_login" id="edd_user_login" placeholder="<?php _e( 'Username or Email', 'easy-digital-downloads' ); ?>" class="edd-required edd-input" type="text"/>
			</p>
			<p class="edd-login-password mb-3">
				<input name="edd_user_pass" id="edd_user_pass" placeholder="<?php _e( 'Password', 'easy-digital-downloads' ); ?>" class="edd-password edd-required edd-input" type="password"/>
			</p>
			<p class="edd-login-remember float-left">
				<input name="rememberme" id="rememberme" type="checkbox" value="forever"/>
   				<label for="rememberme"><?php _e( 'Remember Me', 'easy-digital-downloads' ); ?></label>
			</p>
			<p class="edd-lost-password float-right">
				<a href="<?php echo wp_lostpassword_url(); ?>">
					<?php _e( 'Lost Password?', 'easy-digital-downloads' ); ?>
				</a>
			</p>
			<p class="edd-login-submit mb-0" style="clear:both;">
				<input type="hidden" name="edd_redirect" value="<?php echo esc_url( $edd_login_redirect ); ?>"/>
				<input type="hidden" name="edd_login_nonce" value="<?php echo wp_create_nonce( 'edd-login-nonce' ); ?>"/>
				<input type="hidden" name="edd_action" value="user_login"/>
				<input id="edd_login_submit" type="submit" class="edd-submit mb-0" value="<?php _e( 'Log In', 'easy-digital-downloads' ); ?>"/>
			</p>

			<?php do_action( 'edd_login_fields_after' ); ?>
		</fieldset>
	</form>


<?php else : ?>

	<?php do_action( 'edd_login_form_logged_in' ); ?>

<?php endif; ?>
