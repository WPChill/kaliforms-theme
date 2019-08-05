<div class="modal modal--login <?php echo $_POST['edd_action'] ? 'modal--open': ''; ?>">
	<div class="modal__overlay"></div>
	<div class="modal__content p-3 p-md-5">
		<div class="modal__close"></div>
		<?php echo do_shortcode('[edd_login]');?>
	</div>
</div>