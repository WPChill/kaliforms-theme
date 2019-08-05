
<?php

////
$query = new WP_Query( array(
	'post_type' => 'docs',
	'posts_per_page' => -1,
	'post_parent' => 0
));

if ( $query->have_posts() ) {
	echo '<h6>Documentation Categories:</h6>';
	echo '<ul class="list--docs mb-0">';
	while ( $query->have_posts() ) {
		$query->the_post();
		echo '<li><a href="'. get_permalink() . '">' . get_the_title() . '</a></li>';
	}
	echo '</ul>';
}



