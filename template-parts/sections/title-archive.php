<section class="section title-section">
	<div class="title-section__bg"></div>
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-8 text-center">
				<h1 class="h2">
					<?php if ( is_category() ) : ?>
						<?php printf( esc_html__( 'Category Archives', 'modula' ), single_cat_title( '', false ) ); ?>
					<?php elseif ( is_author() ) : ?>
						<?php printf( esc_html__( 'Articles by  %s', 'modula' ), get_the_author() ); ?>
					<?php elseif ( is_tag() ) : ?>
						<?php printf( esc_html__( 'Tag Archives', 'modula' ) ); ?>
					<?php else: ?>
						<?php echo esc_html__( 'Archives ', 'modula' ); ?>
					<?php endif; ?>
				</h1>
				<div class="title-section__excerpt">
					<?php if ( is_category() ) : ?>
						<?php printf( esc_html__( 'Posts in %s category.', 'modula' ), single_cat_title( '', false ) ); ?>
					<?php elseif ( is_author() ) : ?>
						<?php echo esc_html( the_author_meta( 'description' ) ); ?>
					<?php elseif ( is_tag() ) : ?>
						<?php printf( esc_html__( 'Posts with %s tag.', 'modula' ), single_tag_title( '',false ) ); ?>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</section>