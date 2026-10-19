<?php
defined( 'ABSPATH' ) || exit;

add_action( 'after_setup_theme', function () {
	load_theme_textdomain( 'fitaa', FITAA_DIR . '/languages' );

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support( 'custom-logo', array(
		'height'      => 80,
		'width'       => 240,
		'flex-height' => true,
		'flex-width'  => true,
	) );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'editor-styles' );

	register_nav_menus( array(
		'primary' => __( 'Primary menu', 'fitaa' ),
		'footer'  => __( 'Footer menu', 'fitaa' ),
	) );
} );

add_action( 'widgets_init', function () {
	register_sidebar( array(
		'name'          => __( 'Footer widgets', 'fitaa' ),
		'id'            => 'footer-1',
		'before_widget' => '<div class="footer-widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="footer-widget__title">',
		'after_title'   => '</h3>',
	) );
} );

/** Body classes so CSS/JS can key off the page type. */
add_filter( 'body_class', function ( $classes ) {
	$classes[] = 'fitaa-theme';
	// Pages that open on a full-bleed dark photo hero: the header starts in its dark variant.
	if ( is_front_page() || is_page_template( 'page-sa-endeavours.php' ) ) {
		$classes[] = 'fitaa-hero';
	}
	return $classes;
} );

/** Fall back to the Fitaa Homes mark as the favicon until a Site Icon is set in the Customizer. */
add_action( 'wp_head', function () {
	if ( has_site_icon() ) {
		return;
	}
	$base = FITAA_URI . '/assets/img/brand/';
	printf( '<link rel="icon" type="image/png" sizes="192x192" href="%s">' . "\n", esc_url( $base . 'fitaa-homes-mark-192.png' ) );
	printf( '<link rel="apple-touch-icon" href="%s">' . "\n", esc_url( $base . 'fitaa-homes-mark-192.png' ) );
}, 5 );
