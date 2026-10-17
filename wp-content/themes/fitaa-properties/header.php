<?php defined( 'ABSPATH' ) || exit; ?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="theme-color" content="#08050d">
	<script>document.documentElement.classList.add('js');</script>
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link" href="#main"><?php esc_html_e( 'Skip to content', 'fitaa' ); ?></a>

<header class="site-header" data-header>
	<div class="site-header__inner">
		<a class="brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php esc_attr_e( 'Fitaa Properties home', 'fitaa' ); ?>">
			<?php if ( has_custom_logo() ) : ?>
				<?php the_custom_logo(); ?>
			<?php else : ?>
				<span class="brand__mark" aria-hidden="true">F</span>
				<span class="brand__text">Fitaa <em>Properties</em></span>
			<?php endif; ?>
		</a>

		<nav class="site-nav" id="site-nav" aria-label="<?php esc_attr_e( 'Primary', 'fitaa' ); ?>">
			<?php
			if ( has_nav_menu( 'primary' ) ) {
				wp_nav_menu( array(
					'theme_location' => 'primary',
					'container'      => false,
					'menu_class'     => 'site-nav__list',
					'depth'          => 1,
				) );
			} else {
				?>
				<ul class="site-nav__list">
					<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Fitaa House', 'fitaa' ); ?></a></li>
					<li><a href="<?php echo esc_url( fitaa_sa_url() ); ?>"><?php esc_html_e( 'SA Endeavours', 'fitaa' ); ?></a></li>
					<li><a href="<?php echo esc_url( fitaa_stays_url() ); ?>"><?php esc_html_e( 'Stays & Rentals', 'fitaa' ); ?></a></li>
					<li><a href="<?php echo esc_url( fitaa_landlords_url() ); ?>"><?php esc_html_e( 'Landlords', 'fitaa' ); ?></a></li>
				</ul>
			<?php } ?>
			<a class="btn btn--small btn--solid site-nav__cta" href="<?php echo esc_url( fitaa_booking_url() ); ?>"><?php esc_html_e( 'Book a stay', 'fitaa' ); ?></a>
		</nav>

		<div class="site-header__tools">
			<?php if ( function_exists( 'fitaa_cart_link' ) && class_exists( 'WooCommerce' ) ) { fitaa_cart_link(); } ?>
			<button class="nav-toggle" type="button" aria-controls="site-nav" aria-expanded="false" data-nav-toggle>
				<span class="screen-reader-text"><?php esc_html_e( 'Menu', 'fitaa' ); ?></span>
				<span class="nav-toggle__bars" aria-hidden="true"></span>
			</button>
		</div>
	</div>
	<div class="scroll-progress" aria-hidden="true"><span data-progress></span></div>
</header>
