<?php
defined( 'ABSPATH' ) || exit;

add_action( 'after_setup_theme', function () {
	add_theme_support( 'woocommerce', array(
		'thumbnail_image_width' => 600,
		'single_image_width'    => 1000,
		'product_grid'          => array(
			'default_rows'    => 3,
			'min_rows'        => 1,
			'default_columns' => 3,
			'min_columns'     => 1,
			'max_columns'     => 4,
		),
	) );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
} );

if ( ! class_exists( 'WooCommerce' ) ) {
	return;
}

/** Replace WooCommerce's default content wrappers with theme markup. */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );

add_action( 'woocommerce_before_main_content', function () {
	echo '<main id="main" class="site-main shop"><div class="shop__inner container">';
} );
add_action( 'woocommerce_after_main_content', function () {
	echo '</div></main>';
} );

add_filter( 'loop_shop_columns', function () {
	return 3;
} );

/** Live cart count in the header (AJAX fragment). */
add_filter( 'woocommerce_add_to_cart_fragments', function ( $fragments ) {
	ob_start();
	fitaa_cart_link();
	$fragments['a.cart-link'] = ob_get_clean();
	return $fragments;
} );

function fitaa_cart_link() {
	$count = WC()->cart ? WC()->cart->get_cart_contents_count() : 0;
	printf(
		'<a class="cart-link" href="%s" aria-label="%s"><span class="cart-link__icon" aria-hidden="true"></span><span class="cart-link__count">%d</span></a>',
		esc_url( wc_get_cart_url() ),
		esc_attr__( 'Basket', 'fitaa' ),
		(int) $count
	);
}
