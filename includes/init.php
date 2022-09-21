<?php
if ( ! defined( 'WPINC' ) ) {
    die();
}

/* *
 * Includes
 * */
require_once( RA_PLUGIN_DIR . '/includes/RASingleton.class.php' );
require_once( RA_PLUGIN_DIR . '/includes/RAShortcode.class.php' );
require_once( RA_PLUGIN_DIR . '/includes/RASettings.class.php' );

/* *
 * Admin
 * */
require_once( RA_PLUGIN_DIR . '/admin/RAAdmin.class.php' );
require_once( RA_PLUGIN_DIR . '/admin/lib/TableActivate.class.php' );

/* *
 * Public
 * */
require_once( RA_PLUGIN_DIR . '/public/shortcodes/RAFormShortcode.class.php' );
require_once( RA_PLUGIN_DIR . '/public/RAManagement.class.php' );
require_once( RA_PLUGIN_DIR . '/public/shortcodes/RAThankyouShortcode.class.php' );

$load_admin = false;
if( is_admin() ) {
    $load_admin = true;
}

register_activation_hook( RA_PLUGIN_FILE, array( 'RAManagement', 'activate' ) );
register_deactivation_hook( RA_PLUGIN_FILE, array( 'RAManagement', 'deactivate' ) );

/* *
 * Initialize Public Scripts
 * */
add_action( 'plugins_loaded', array( 'RAManagement', 'getInstance' ) );

/* *
 * Initialize Admin Scripts
 * */
if ( $load_admin ) {
    add_action( 'plugins_loaded', array( 'RAAdmin', 'getInstance' ) );
}
?>