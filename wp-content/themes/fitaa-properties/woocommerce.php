<?php
/** Single template WooCommerce uses for shop, product, cart, checkout and account pages. */
get_header();
if ( function_exists( 'woocommerce_content' ) ) {
	woocommerce_content();
}
get_footer();
