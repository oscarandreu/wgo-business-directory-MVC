<?php
/**
 * WgoBd_App_Controller class
 *
 * @package Controllers
 * @author  Oscar Andreu
 **/
class WgoBd_App_Controller extends WgoBd_ControllerBase{	

	/**
	 * get_instance function
	 *
	 * Return singleton instance
	 *
	 * @return object
	 **/
	static public function get_instance() {
		if( self::$_instance === NULL ) {
			self::$_instance = new self();
		}
	
		return self::$_instance;
	}
	
	/**
	 * Constructor
	 *
	 * Default constructor - application initialization
	 **/
	private function __construct()
 	{
		global $wpdb,
		       $wgobd_app_helper,
		       $wgobd_events_controller,
		       $wgobd_events_helper,
		       $wgobd_importer_controller,
		       $wgobd_settings_controller,
		       $wgobd_settings;

		// register_activation_hook
		register_activation_hook( WGOBD_PLUGIN_NAME . '/' . WGOBD_PLUGIN_NAME . '.php', array( &$this, 'activation_hook' ) );

		// Load plugin text domain
		$this->load_textdomain();

		// Install/update database schema as necessary
		$this->install_schema();

		// ===========
		// = ACTIONS =
		// ===========
		// Create custom post type
// 		add_action( 'init',			array( &$wgobd_app_helper, 'create_post_type' ) );
		

		// ===========
		// = FILTERS =
		// ===========
// 		add_filter( 'posts_orderby',array( &$wgobd_app_helper, 'orderby' ), 10, 2 );
		// add custom column names and change existing columns
		
		// ==============
		// = Shortcodes =
		// ==============
		add_shortcode( 'wgobd', array( &$wgobd_events_helper, 'shortcode' ) );
		
	}

	/**
	 * activation_hook function
	 *
	 * This function is called when activating the plugin
	 *
	 * @return void
	 **/
	function activation_hook() {

	  // load plugin text domain
	  $this->load_textdomain();

	  // flush rewrite rules
	  $this->rewrite_flush();
	}

	/**
	 * load_textdomain function
	 *
	 * Loads plugin text domain
	 *
	 * @return void
	 **/
	function load_textdomain() {
	  if( self::$_load_domain === FALSE ) {
	    load_plugin_textdomain( WGOBD_PLUGIN_NAME, false, WGOBD_LANGUAGE_PATH );
	    self::$_load_domain = TRUE;

	  }
	}

	/**
	 * rewrite_flush function
	 *
	 * Get permalinks to work when activating the plugin
	 *
	 * @return void
	 **/
	function rewrite_flush() {
		global $wgobd_app_helper;
		$wgobd_app_helper->create_post_type();
		flush_rewrite_rules( true );
	}

	/**
	 * install_schema function
	 *
	 * This function sets up the database, and upgrades it if it is out of date.
	 *
	 * @return void
	 **/
	function install_schema() {
		global $wpdb;

		// If existing DB version is not consistent with current plugin's version,
		// or does not exist, then create/update table structure using dbDelta().
		if( get_option( 'wgobd_db_version' ) != WGOBD_DB_VERSION )
		{
			// =======================
			// = Create table events =
			// =======================
			$table_name = $wpdb->prefix . 'wgobd_events';
			$sql = "
					CREATE TABLE IF NOT EXISTS ".$wpdb->prefix."wgo_categories (
					  id mediumint(9) NOT NULL AUTO_INCREMENT,
					  name varchar(55) NOT NULL,
					  description text NOT NULL,
					  icon text NOT NULL,
					  UNIQUE KEY id (id)
					) ENGINE=InnoDB DEFAULT CHARSET=utf8;
					
					
					CREATE TABLE IF NOT EXISTS ".$wpdb->prefix."wgo_cities (
					  id int(10) NOT NULL,
					  name varchar(100) NOT NULL,
					  coordinates varchar(30) NOT NULL,
					  zoom int(10) unsigned NOT NULL,
					  weather_code varchar(50) DEFAULT NULL,
					  weather_logo varchar(10000) DEFAULT NULL,
					  PRIMARY KEY (id)
					) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Municipios';
					
					
					CREATE TABLE IF NOT EXISTS ".$wpdb->prefix."wgo_images (
					  id mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
					  id_listing mediumint(8) unsigned NOT NULL,
					  path varchar(128) DEFAULT NULL,
					  alt_text varchar(128) DEFAULT NULL,
					  PRIMARY KEY (id)
					) ENGINE=InnoDB DEFAULT CHARSET=utf8;
					
					
					CREATE TABLE IF NOT EXISTS ".$wpdb->prefix."wgo_listings (
					  id mediumint(9) NOT NULL AUTO_INCREMENT,
					  name varchar(200) NOT NULL,
					  logo_url varchar(128) DEFAULT NULL,
					  description text,
					  address varchar(200) DEFAULT NULL,
					  zip varchar(5) DEFAULT NULL,
					  city_id smallint(32) DEFAULT NULL,
					  phone varchar(50) DEFAULT NULL,
					  fax varchar(50) DEFAULT NULL,
					  movil varchar(50) DEFAULT NULL,
					  email varchar(300) DEFAULT NULL,
					  url varchar(300) DEFAULT NULL,
					  state varchar(64) DEFAULT NULL,
					  cat_id mediumint(9) DEFAULT NULL,
					  pkg_id mediumint(9) DEFAULT NULL,
					  time_listed bigint(11) DEFAULT '0',
					  time_expired bigint(11) DEFAULT '0',
					  active tinyint(1) DEFAULT '0',
					  coordinates varchar(30) DEFAULT '0',
					  facebook_url varchar(128) DEFAULT NULL,
					  twitter_url varchar(128) DEFAULT NULL,
					  youtube_url varchar(128) DEFAULT NULL,
					  rss_url varchar(128) DEFAULT NULL,
					  PRIMARY KEY (id)
					) ENGINE=InnoDB DEFAULT CHARSET=utf8;
					
					
					CREATE TABLE IF NOT EXISTS ".$wpdb->prefix."wgo_packages (
					  id mediumint(9) NOT NULL AUTO_INCREMENT,
					  name varchar(55) NOT NULL,
					  description text NOT NULL,
					  cost decimal(6,2) NOT NULL,
					  duration int(3) NOT NULL,
					  UNIQUE KEY id (id)
					) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
			
			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
			dbDelta( $sql );

			update_option( 'wgobd_db_version', WGOBD_DB_VERSION );
		}
	}


	/**
	 * setup_menus function
	 * Adds the hook to admin_menu that is pointing to menu member function
	 *
	 * @return void
	 **/
	function setup_menus() {
		add_action( "wgobd_admin_menu", array( &$this, "menu" ) );
	}

	/**
	 * menu function
	 * Display the admin menu items using the add_menu_page WP function.
	 *
	 * @return void
	 **/
	function menu() {
		global $wgobd_settings_controller,
		       $wgobd_settings_helper,
		       $wgobd_settings;

		// =================
		// = Settings Page =
		// =================
// 		$wgobd_settings->settings_page = 
// 			add_submenu_page(
// 				'edit.php?post_type=' . WGOBD_POST_TYPE,
// 				__( 'Settings', WGOBD_PLUGIN_NAME ),
// 				__( 'Settings', WGOBD_PLUGIN_NAME ),
// 				'manage_options',
// 				WGOBD_PLUGIN_NAME . "-settings",
// 				array( &$wgobd_settings_controller, "view" )
// 			);
		
		add_menu_page('Directorio','Directorio','administrator','wgo_settings','wgo_settings_page',WGO_BD_IMAGES.'shopping Full.png');
		add_submenu_page('wgo_settings','Modalidades','Modalidades','administrator','wgo_settings_packages','wgo_packages_page');
		add_submenu_page('wgo_settings','Categorías','Categorías','administrator','wgo_settings_categories','wgo_categories_page');
		add_submenu_page('wgo_settings','Listado de anuncios','Listado de anuncios','administrator','wgo_settings_listings','wgo_listings_page');
		add_submenu_page('','Edit Listings','Edit Listings','administrator','wgo_settings_edit_listings','wgo_edit_listing_page');
		add_submenu_page('','Edit Images','Edit Images','administrator','wgo_settings_edit_images','wgo_edit_images_page');
		
		//call register settings function
		add_action('admin_init','register_wgo_settings');
	}

}
