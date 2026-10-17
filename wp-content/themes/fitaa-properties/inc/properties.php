<?php
/**
 * Property registry: one entry per bookable property, with its tour rooms and detail shots.
 * Photos live in assets/img/<folder>/ and are referenced by file slug.
 */
defined( 'ABSPATH' ) || exit;

/** Webp slug => path helper for any property folder. */
function fitaa_prop_img( $folder, $slug ) {
	return esc_url( FITAA_URI . '/assets/img/' . $folder . '/' . $slug . '.webp' );
}

function fitaa_properties() {
	return array(
		'fitaa-house-southampton' => array(
			'name'   => 'Fitaa House Southampton',
			'folder' => 'southampton',
			'rooms'  => array(
				array( 'title' => 'Your front door', 'text' => 'A private entrance off a quiet communal hallway. Self-contained, and yours for the length of your stay.',
					'img' => 'flat-front-door', 'alt' => 'The front door of Flat 1', 'img2' => 'communal-hallway-flat-door', 'alt2' => 'The communal hallway leading to the flat door' ),
				array( 'title' => 'Living room', 'text' => 'Deep blue velvet, a wall-mounted TV and warm lamp light. The sofa opens into an extra bed when you need one.',
					'img' => 'living-room-velvet-sofa', 'alt' => 'Living room with a blue velvet sofa, rug and wall-mounted TV', 'img2' => 'living-room-sofa-bed', 'alt2' => 'The velvet sofa opened out as a sofa bed' ),
				array( 'title' => 'Full kitchen', 'text' => 'Oven, hob, extractor, microwave, air fryer, fridge-freezer and washing machine. Cook properly, not just reheat.',
					'img' => 'kitchen-full-view', 'alt' => 'Fully equipped white kitchen with black handles and slate floor', 'img2' => 'breakfast-bar-windows', 'alt2' => 'Breakfast bar for two by the front windows' ),
				array( 'title' => 'Bedroom', 'text' => 'Navy linen, bedside lamps and a dressing table. The bed is zip-and-link: two singles, or one large double.',
					'img' => 'bedroom-as-double', 'alt' => 'Bedroom with a navy double bed, towels and pendant light', 'img2' => 'bedroom-dressing-table', 'alt2' => 'Dressing table with round mirror in the bedroom' ),
				array( 'title' => 'Bathroom', 'text' => 'A bath with rainfall shower and screen, heated towel rail, and shampoo, conditioner, body wash and hand soap provided.',
					'img' => 'bathroom-rainfall-shower', 'alt' => 'Bathroom with a rainfall shower over the bath', 'img2' => 'bathroom-sink-mirror', 'alt2' => 'Bathroom sink and mirror' ),
				array( 'title' => 'The little extras', 'text' => 'A welcome snack and hot-drinks basket on arrival, plus a utility cupboard with iron, ironing board, airer and hangers.',
					'img' => 'welcome-snack-basket', 'alt' => 'Welcome snack and hot drinks basket', 'img2' => 'utility-cupboard-iron-board', 'alt2' => 'Utility cupboard with iron, ironing board and airer' ),
			),
			'details' => array(
				array( 'kitchen-fridge-freezer', 'Fridge-freezer and kitchen shelving' ),
				array( 'living-room-artwork-lamp', 'Living room artwork and lamp' ),
				array( 'breakfast-bar-kettle', 'Kettle at the breakfast bar' ),
				array( 'bathroom-toilet-towel-rail', 'Heated towel rail' ),
				array( 'bedroom-towels-detail', 'Fresh towels folded on the bed' ),
				array( 'kitchen-cupboard-crockery-pans', 'Crockery and pans in the kitchen cupboard' ),
				array( 'entrance-intercom-thermostat', 'Entrance intercom and thermostat' ),
				array( 'bathroom-wall-sign', 'Bathroom wall sign' ),
			),
		),
		'sa-endeavours' => array(
			'name'   => 'SA Endeavours',
			'folder' => 'sa-endeavours',
			'rooms'  => array(
				array( 'title' => 'Living room', 'text' => 'A warm, layered living space with a taupe sofa, a blue sofa, a diamond-pattern rug and a wall-mounted TV.',
					'img' => 'living-room-sofas', 'alt' => 'Living room with a taupe sofa, blue sofa and dining table beyond', 'img2' => 'living-room-wide', 'alt2' => 'Wide view of the living room with TV and rug' ),
				array( 'title' => 'Kitchen', 'text' => 'Gas hob, oven, extractor, microwave, kettle, toaster and a washing machine, with glasses and crockery already stocked.',
					'img' => 'kitchen-wide', 'alt' => 'Bright white kitchen with a window over the sink', 'img2' => 'kitchen-corner-hob', 'alt2' => 'Kitchen corner with gas hob and extractor' ),
				array( 'title' => 'The green bedroom', 'text' => 'Soft green and white linen with folded towels, a bedside table and a framed print above the bed.',
					'img' => 'bedroom-green-wide', 'alt' => 'Bedroom with a green throw, white linen and framed botanical prints', 'img2' => 'bedroom-green-towel-detail', 'alt2' => 'Folded towel on the green throw' ),
				array( 'title' => 'The orange bedroom', 'text' => 'A single bed in burnt-orange linen, with a bedside chest, a lamp and floral prints on the wall.',
					'img' => 'bedroom-single-orange', 'alt' => 'Bedroom with a single bed in orange linen and floral prints', 'img2' => 'bedroom-orange-single', 'alt2' => 'The single bed with a folded towel' ),
				array( 'title' => 'Dining area', 'text' => 'A wooden dining table with chairs around it, so meals do not have to happen on the sofa.',
					'img' => 'dining-table', 'alt' => 'Wooden dining table with place mats and framed animal prints', 'img2' => 'living-room-sofa', 'alt2' => 'Sofa beside the dining table' ),
				array( 'title' => 'Bathroom', 'text' => 'White marble-effect tiles, a walk-in shower with rainfall head, a heated towel rail and toiletries on hand.',
					'img' => 'bathroom-wide', 'alt' => 'Marble-tiled bathroom with heated towel rail and basin', 'img2' => 'bathroom-shower-detail', 'alt2' => 'Walk-in shower with rainfall head and tiled shelf' ),
			),
			'details' => array(
				array( 'kitchen-cupboard-glasses', 'Glasses and crockery in the kitchen cupboard' ),
				array( 'kitchen-cutlery-drawer', 'Cutlery drawer with utensils' ),
				array( 'kitchen-washer-drawers', 'Washing machine and kitchen drawers' ),
				array( 'bathroom-towel-rail', 'Heated towel rail and window' ),
				array( 'kitchen-microwave-kettle', 'Microwave and kettle on the worktop' ),
				array( 'bedroom-orange-towel-detail', 'Towel on the orange bedding' ),
				array( 'kitchen-sink-cupboard', 'Kitchen sink with cupboard below' ),
				array( 'kitchen-hob-extractor', 'Gas hob and cooker hood' ),
			),
		),
	);
}

function fitaa_property( $slug ) {
	$all = fitaa_properties();
	return isset( $all[ $slug ] ) ? $all[ $slug ] : null;
}

/** <img> for a property photo. */
function fitaa_prop_photo( $folder, $slug, $alt, $class = '', $loading = 'lazy' ) {
	printf(
		'<img src="%s" alt="%s" class="%s" loading="%s" decoding="async">',
		fitaa_prop_img( $folder, $slug ),
		esc_attr( $alt ),
		esc_attr( $class ),
		esc_attr( $loading )
	);
}

function fitaa_sa_url() {
	return fitaa_page_url( 'page-sa-endeavours.php', 'sa-endeavours' );
}

function fitaa_property_url( $slug ) {
	return 'sa-endeavours' === $slug ? fitaa_sa_url() : home_url( '/' );
}
