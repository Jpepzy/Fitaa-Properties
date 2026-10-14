<?php
/**
 * Fitaa Properties theme bootstrap.
 *
 * @package fitaa
 */

defined( 'ABSPATH' ) || exit;

define( 'FITAA_VERSION', '1.0.0' );
define( 'FITAA_DIR', get_template_directory() );
define( 'FITAA_URI', get_template_directory_uri() );

require_once FITAA_DIR . '/inc/setup.php';
require_once FITAA_DIR . '/inc/enqueue.php';
require_once FITAA_DIR . '/inc/customizer.php';
require_once FITAA_DIR . '/inc/helpers.php';
require_once FITAA_DIR . '/inc/landlord-form.php';
require_once FITAA_DIR . '/inc/pages.php';
require_once FITAA_DIR . '/inc/woocommerce.php';
