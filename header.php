<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<?php wp_head(); ?>
	<meta name="theme-color" content="#3B88F7">
</head>

<body <?php body_class(); ?>>

	<?php do_action('before_header');  ?>

	<header class="<?php modula_header_class(); ?>">
		<div class="container">
			<div class="row">
				<div class="col header__content">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="logo-link" rel="home" itemprop="url"></a>

					<div class="menu-icon">
						<div class="menu-icon__navicon"></div>
					</div>

					<?php
					wp_nav_menu(
						array(
							'menu_id'        => 'main-menu',
							'menu_class'     => 'main-menu',
							'theme_location' => 'main_menu',
							'depth'          => '2',
							'container'      => false,
						)
					);
					?>

				</div>
			</div>
		</div>
	</header>