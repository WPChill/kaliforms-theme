<?php get_header(); ?>

<?php
$layout = st_get_post_meta( $post->ID, 'layout' );

switch ( $layout ) :
	case 'no-sidebar':
		get_template_part( 'template-parts/layouts/single-no-sidebar' );
		break;
	default:
		get_template_part( 'template-parts/layouts/single-default' );
		break;
endswitch;
?>

<?php get_template_part( 'template-parts/sections/related-posts' ); ?>
<?php comments_template( '', true ); ?>
<?php get_template_part( 'template-parts/sections/latest-post' ); ?>
<?php get_footer(); ?>