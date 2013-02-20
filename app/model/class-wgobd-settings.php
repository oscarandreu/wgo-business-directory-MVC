<?php
/**
 * wgobd_Settings class
 *
 * @package Models
 * @author Oscar Andreu
 **/
 
class WgoBd_Settings {
	
	/**
	 * _instance class variable
	 *
	 * Class instance
	 *
	 * @var null | object
	 **/
	private static $_instance = NULL;
	
	/**
	 * hide_maps_until_clicked class variable
	 *
	 * When this setting is on, instead of showing the Google Map,
	 * show a dotted-line box containing the text "Click to view map",
	 * and when clicked, this box is replaced by the Google Map.
	 *
	 * @var bool
	 **/
	var $hide_maps_until_clicked;
	
	/**
	 * __construct function
	 *
	 * Default constructor
	 **/
	private function __construct() {
		$this->set_defaults(); // set default settings
 	}

	/**
	 * get_instance function
	 *
	 * Return singleton instance
	 *
	 * @return object
	 **/
	static function get_instance()
 	{
		if( self::$_instance === NULL ) {
			// get the settings from the database
			self::$_instance = get_option( 'wgobd_settings' );

			// if there are no settings in the database
			// save default values for the settings
			if( ! self::$_instance ) {
				self::$_instance = new self();
				delete_option( 'wgobd_settings' );
				add_option( 'wgobd_settings', self::$_instance );
			} else {
				self::$_instance->set_defaults(); // set default settings
			}
		}

		return self::$_instance;
	}

	/**
	 * save function
	 *
	 * Save settings to the database.
	 *
	 * @return void
	 **/
	function save() {
		update_option( 'wgobd_settings', $this );
	}

	/**
	 * set_defaults function
	 *
	 * Set default values for settings.
	 *
	 * @return void
	 **/
	function set_defaults() {
		$defaults = array(
			'hide_maps_until_clicked'       => true
		);

		foreach( $defaults as $key => $default ) {
			if( ! isset( $this->$key ) )
				$this->$key = $default;
		}
	}

	/**
	 * update function
	 *
	 * Updates field values with corresponding values found in $params
	 * associative array.
	 *
	 * @param array $params
	 *
	 * @return void
	 **/
	function update( $params ) {		
		$this->hide_maps_until_clicked       = ( isset( $params['hide_maps_until_clicked'] ) )       ? true : false;
	}

	/**
	 * auto_add_page function
	 *
	 * Auto-create a WordPress page with given name for use by this plugin.
	 *
	 * @param string page_name
	 *
	 * @return int the new page's ID.
	 **/
	function auto_add_page( $page_name ) {
		return wp_insert_post(
			array(
				'post_title' 			=> $page_name,
				'post_type' 			=> 'page',
				'post_status' 		=> 'publish',
				'comment_status' 	=> 'closed'
			)
		);
	}

}

