<section class="section title-section">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-6 text-center last-child-mb-0">
				<h1 class="h2"><?php echo esc_html( get_the_title() ); ?></h1>
				<?php if ( has_excerpt() ) : ?>
					<div class="title-section__excerpt">
						<?php echo wp_kses_post( get_the_excerpt() ); ?>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>