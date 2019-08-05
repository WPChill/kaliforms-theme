<?php if ( $docs ) : ?>

<div class="docs row">

	<?php foreach ($docs as $main_doc) : ?>
		<div class="col-md-6 col-xl-4 mb-4">

			<div class="docs-single">
				<div class="docs-single__header text-center">
					<h6 class="mb-0"><?php echo $main_doc['doc']->post_title; ?></h6>
					<?php if ( has_excerpt( $main_doc['doc']->ID ) ): ?>
						<p class="mb-0"><?php echo wp_kses_post( get_the_excerpt( $main_doc['doc']->ID ) ); ?></p>
					<?php endif; ?>
				</div>

				<div class="docs-single__content">

					<?php if ( $main_doc['sections'] ) : ?>
						<div class="inside">
							<ul class="wedocs-doc-sections">
								<?php $index = 0; ?>
								<?php foreach ($main_doc['sections'] as $section) : ?>
									<?php if(++$index > 4) break; ?>
									<li><a href="<?php echo get_permalink( $section->ID ); ?>"><?php echo $section->post_title; ?></a></li>
								<?php endforeach; ?>
							</ul>
						</div>

					<?php endif; ?>

				</div>

				<div class="docs-single__footer text-center">
					<a class="button button--small" href="<?php echo get_permalink( $main_doc['doc']->ID ); ?>">Browse All Articles</a>
				</div>


			</div>
		</div>
	<?php endforeach; ?>

</div>

<?php endif;