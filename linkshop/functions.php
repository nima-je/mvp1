<?php
/**
 * LinkShop theme functions
 */

if ( ! defined( 'LINKSHOP_VERSION' ) ) {
    define( 'LINKSHOP_VERSION', '1.0.0' );
}

require_once get_template_directory() . '/inc/setup.php';
require_once get_template_directory() . '/inc/customizer.php';
require_once get_template_directory() . '/inc/woocommerce.php';
require_once get_template_directory() . '/inc/sms.php';
require_once get_template_directory() . '/inc/license.php';
require_once get_template_directory() . '/inc/analytics.php';
require_once get_template_directory() . '/inc/invoices.php';
