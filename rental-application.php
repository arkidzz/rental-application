<?php
/**
* @package   Rental Management
* @author    Brookfield
* @license   GPL-2.0+
* @link      http://brookfield.com
* @copyright IOfortech
*
* Plugin Name: Rental Application Management
* Plugin URI: https://www.rentalapplication.com/
* Description: Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut rutrum, lectus id porta dictum, lacus velit convallis libero.
* Version: 1.0.0
* Author: BrookField
* Author URI: https://uri.com/
* License: GPLv2 or Later
*/
if ( ! defined( 'WPINC' ) ) {
    die;
}

define("RA_PLUGIN_DIR", addslashes( dirname(__FILE__) ) );
$pinfo = pathinfo(RA_PLUGIN_DIR);
define("RA_PLUGIN_FILE", addslashes(__FILE__));
define("RA_PLUGIN_URL",plugins_url().'/'.$pinfo['basename'].'/');

define("RA_PLUGIN_NAME",'Rental App');
define("RA_PLUGIN_SLUG",'ra-app');
define("RA_PLUGIN_TEXT_DOMAIN",'ra-app-locale');

require_once RA_PLUGIN_DIR . '/includes/init.php';