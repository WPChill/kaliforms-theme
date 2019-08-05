<?php

if ( isset($_COOKIE['st_top_bar_section_closed'])  ) {
	return;
}

?>


<section class="topbar-section">
	<div class="container">
		<div class="row">
			<div class="col-12 text-center">
				<?php echo wp_kses_post( modula_get_option( 'top_bar_content' ) ); ?>
			</div>
		</div>
	</div>
	<div class="topbar-section__close"></div>
</section>