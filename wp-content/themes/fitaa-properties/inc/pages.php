<?php
defined( 'ABSPATH' ) || exit;

/**
 * On activation create the core pages (if missing), assign their templates and
 * make the Fitaa House Southampton homepage the static front page.
 */
add_action( 'after_switch_theme', function () {
	$defs = array(
		'home'      => array( 'Fitaa House Southampton', 'home', '' ),
		'sa'        => array( 'SA Endeavours', 'sa-endeavours', 'page-sa-endeavours.php' ),
		'landlords' => array( 'Landlords', 'landlords', 'page-landlords.php' ),
		'stays'     => array( 'Stays & Rentals', 'stays', 'page-stays.php' ),
	);
	$ids = array();

	foreach ( $defs as $key => $def ) {
		$existing = get_page_by_path( $def[1] );
		if ( $existing ) {
			$ids[ $key ] = $existing->ID;
			continue;
		}
		$ids[ $key ] = wp_insert_post( array(
			'post_title'  => $def[0],
			'post_name'   => $def[1],
			'post_status' => 'publish',
			'post_type'   => 'page',
		) );
		if ( $def[2] && $ids[ $key ] && ! is_wp_error( $ids[ $key ] ) ) {
			update_post_meta( $ids[ $key ], '_wp_page_template', $def[2] );
		}
	}

	if ( ! empty( $ids['home'] ) && ! is_wp_error( $ids['home'] ) && 'posts' === get_option( 'show_on_front' ) ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $ids['home'] );
	}

	// Seed the primary menu once.
	if ( ! has_nav_menu( 'primary' ) && ! wp_get_nav_menu_object( 'Fitaa primary' ) ) {
		$menu_id = wp_create_nav_menu( 'Fitaa primary' );
		if ( ! is_wp_error( $menu_id ) ) {
			foreach ( array( 'home', 'sa', 'stays', 'landlords' ) as $key ) {
				if ( ! empty( $ids[ $key ] ) && ! is_wp_error( $ids[ $key ] ) ) {
					wp_update_nav_menu_item( $menu_id, 0, array(
						'menu-item-title'     => 'home' === $key ? 'Fitaa House' : get_the_title( $ids[ $key ] ),
						'menu-item-object'    => 'page',
						'menu-item-object-id' => $ids[ $key ],
						'menu-item-type'      => 'post_type',
						'menu-item-status'    => 'publish',
					) );
				}
			}
			$locations            = get_theme_mod( 'nav_menu_locations', array() );
			$locations['primary'] = $menu_id;
			set_theme_mod( 'nav_menu_locations', $locations );
		}
	}
} );
