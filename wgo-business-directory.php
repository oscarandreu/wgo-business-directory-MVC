<?php
/*
Plugin Name: WGO Bussines directory MVC
Plugin URI: http://www.whatsgoingon.es/wgo-bussines-directory
Description: WGO Business Directory Plugin for WordPress, is designed to be used for managing a WordPress business directory listing service on your website.
Author: Oscar Andreu
Version: 1.0.0 Alpha
Author URI: http://www.whatsgoingon.es
*/
/*  Copyright 2012 Oscar Andreu (oscarandreu@whatsgoingon.es)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
*/

// ===================
// = Plugin Basename =
// ===================
define( 'WGOBD_PLUGIN_BASENAME',  plugin_basename( __FILE__ ) );

// ==================
// = Plugin Version =
// ==================
define( 'WGOBD_VERSION', '0.8' );

// ====================
// = Database Version =
// ====================
define( 'WGOBD_DB_VERSION', 2 );

// ===============
// = Plugin Path =
// ===============
define( 'WGOBD_PATH',             dirname( __FILE__ ) );

// ===============
// = Images Path =
// ===============
define( 'WGOBD_IMAGE_PATH',       WGOBD_PATH . '/img' );

// ============
// = CSS Path =
// ============
define( 'WGOBD_CSS_PATH',         WGOBD_PATH . '/css' );

// ===========
// = JS Path =
// ===========
define( 'WGOBD_JS_PATH',          WGOBD_PATH . '/js' );

// ============
// = Lib Path =
// ============
define( 'WGOBD_LIB_PATH',         WGOBD_PATH . '/lib' );

// =================
// = Language Path =
// =================
define( 'WGOBD_LANGUAGE_PATH',    WGOBD_PLUGIN_NAME . '/language' );

// ============
// = App Path =
// ============
define( 'WGOBD_APP_PATH',         WGOBD_PATH . '/app' );

// ===================
// = Controller Path =
// ===================
define( 'WGOBD_CONTROLLER_PATH',  WGOBD_APP_PATH . '/controller' );

// ==============
// = Model Path =
// ==============
define( 'WGOBD_MODEL_PATH',       WGOBD_APP_PATH . '/model' );

// =============
// = View Path =
// =============
define( 'WGOBD_VIEW_PATH',        WGOBD_APP_PATH . '/view' );

// ===============
// = Helper Path =
// ===============
define( 'WGOBD_HELPER_PATH',      WGOBD_APP_PATH . '/helper' );

// ==================
// = Exception Path =
// ==================
define( 'WGOBD_EXCEPTION_PATH',   WGOBD_APP_PATH . '/exception' );

// ==============
// = Plugin Url =
// ==============
define( 'WGOBD_URL',              plugins_url( '', __FILE__ ) );

// ==============
// = Images URL =
// ==============
define( 'WGOBD_IMAGE_URL',        WGOBD_URL . '/img' );

// ===========
// = CSS URL =
// ===========
define( 'WGOBD_CSS_URL',          WGOBD_URL . '/css' );

// ==========
// = JS URL =
// ==========
define( 'WGOBD_JS_URL',           WGOBD_URL . '/js' );


// ===============================
// = The autoload function =
// ===============================
function wgobd_autoload( $class_name )
{
	// Convert class name to filename format.
	$class_name = strtr( strtolower( $class_name ), '_', '-' );
	$paths = array(
			WGOBD_CONTROLLER_PATH,
			WGOBD_MODEL_PATH,
			WGOBD_HELPER_PATH,
			WGOBD_EXCEPTION_PATH,
			WGOBD_LIB_PATH,
			WGOBD_VIEW_PATH,
	);

	// Search each path for the class.
	foreach( $paths as $path ) {
		if( file_exists( "$path/class-$class_name.php" ) )
			require_once( "$path/class-$class_name.php" );
	}
}

spl_autoload_register( 'wgobd_autoload' );

// ===============================
// = Initialize and setup MODELS =
// ===============================
global $wgobd_settings;

$wgobd_settings		= WgoBd_Settings::get_instance();

// ================================
// = Initialize and setup HELPERS =
// ================================
global $wgobd_view_helper;

$wgobd_view_helper     = WgoBd_View_Helper::get_instance();


// ====================================
// = Initialize and setup CONTROLLERS =
// ====================================
global $wgobd_app_controller,$wgobd_settings_controller;

$wgobd_app_controller      = WgoBd_App_Controller::get_instance();
$wgobd_settings_controller = WgoBd_Settings_Controller::get_instance();

// ===================
// = Call admin menu =
// ===================
$wgobd_app_controller->setup_menus();

?>