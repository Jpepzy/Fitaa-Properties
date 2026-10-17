<?php
defined( 'ABSPATH' ) || exit;

add_action( 'wp_enqueue_scripts', function () {
	wp_enqueue_style(
		'fitaa-fonts',
		'https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,300;0,9..144,500;1,9..144,300&family=Manrope:wght@300;400;500;600;700&display=swap',
		array(),
		null
	);
	wp_enqueue_style( 'fitaa-main', FITAA_URI . '/assets/css/main.css', array( 'fitaa-fonts' ), FITAA_VERSION );

	if ( class_exists( 'WooCommerce' ) ) {
		wp_enqueue_style( 'fitaa-woo', FITAA_URI . '/assets/css/woocommerce.css', array( 'fitaa-main' ), FITAA_VERSION );
	}

	wp_enqueue_script( 'fitaa-gsap', FITAA_URI . '/assets/js/vendor/gsap.min.js', array(), '3.12.5', true );
	wp_enqueue_script( 'fitaa-scrolltrigger', FITAA_URI . '/assets/js/vendor/ScrollTrigger.min.js', array( 'fitaa-gsap' ), '3.12.5', true );
	wp_enqueue_script( 'fitaa-lenis', FITAA_URI . '/assets/js/vendor/lenis.min.js', array(), '1.1.20', true );
	wp_register_script( 'fitaa-booking', FITAA_URI . '/assets/js/booking.js', array(), FITAA_VERSION, true );
	wp_enqueue_script( 'fitaa-main', FITAA_URI . '/assets/js/main.js', array( 'fitaa-gsap', 'fitaa-scrolltrigger', 'fitaa-lenis' ), FITAA_VERSION, true );
} );

/** Preconnect for Google Fonts. */
add_filter( 'wp_resource_hints', function ( $urls, $relation ) {
	if ( 'preconnect' === $relation ) {
		$urls[] = 'https://fonts.googleapis.com';
		$urls[] = array( 'href' => 'https://fonts.gstatic.com', 'crossorigin' => 'anonymous' );
	}
	return $urls;
}, 10, 2 );
