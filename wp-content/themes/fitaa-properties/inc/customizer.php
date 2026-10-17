<?php
defined( 'ABSPATH' ) || exit;

/** Contact details live in the Customizer so no personal data is hard-coded in the theme. */
add_action( 'customize_register', function ( WP_Customize_Manager $wp_customize ) {
	$wp_customize->add_section( 'fitaa_contact', array(
		'title'    => __( 'Fitaa contact & social', 'fitaa' ),
		'priority' => 30,
	) );

	$fields = array(
		'fitaa_email'     => array( __( 'Public email', 'fitaa' ), 'sanitize_email' ),
		'fitaa_phone'     => array( __( 'Phone number', 'fitaa' ), 'sanitize_text_field' ),
		'fitaa_whatsapp'  => array( __( 'WhatsApp number (digits, with country code)', 'fitaa' ), 'sanitize_text_field' ),
		'fitaa_instagram' => array( __( 'Instagram URL', 'fitaa' ), 'esc_url_raw' ),
		'fitaa_lead_to'   => array( __( 'Landlord enquiries go to (email)', 'fitaa' ), 'sanitize_email' ),
	);

	foreach ( $fields as $id => $field ) {
		$wp_customize->add_setting( $id, array( 'default' => '', 'sanitize_callback' => $field[1] ) );
		$wp_customize->add_control( $id, array(
			'label'   => $field[0],
			'section' => 'fitaa_contact',
			'type'    => 'text',
		) );
	}
} );
