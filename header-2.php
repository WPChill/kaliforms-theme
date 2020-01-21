<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<?php wp_head(); ?>
	<meta name="theme-color" content="#3B88F7">
</head>

<body <?php body_class(); ?>>

	<header class="<?php modula_header_class(); ?>">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col header__content justify-content-center">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="logo-link" rel="home" itemprop="url"></a>
				</div>
			</div>
		</div>
	</header>