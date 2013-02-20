<?php
/**
 * WgoBd_App_Controller class
 *
 * @package Controllers
 * @author  Oscar Andreu
 **/
class WgoBd_Settings_Controller extends WgoBd_ControllerBase{

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
	 * Default constructor
	 **/
	private function __construct() {
	}

	/**
	 * view function
	 *
	 * Display this plugin's settings page in the admin.
	 *
	 * @return void
	 **/
	function view() {
		global $wgobd_view_helper,
		$wgobd_settings;

		if( isset( $_REQUEST['wgobd_save_settings'] ) ) {
			$this->save();
		}
		$args = array(
				'settings_page' => $wgobd_settings->settings_page
		);
		$wgobd_view_helper->display( 'settings.php', $args );
	}

	/**
	 * save function
	 *
	 * Save the submitted settings form.
	 *
	 * @return void
	 **/
	function save() {
		global $wgobd_settings,
		$wgobd_view_helper;

		$wgobd_settings->update( $_REQUEST );
		$wgobd_settings->save();

		$args = array(
				"msg" => __( "Settings Updated.", WGOBD_PLUGIN_NAME )
		);

		$wgobd_view_helper->display( "save_successful.php", $args );
	}

	/**
	 * admin_enqueue_scripts function
	 *
	 * Enqueue any scripts and styles in the admin side, depending on context.
	 *
	 * @return void
	 **/
	function admin_enqueue_scripts( $hook_suffix ) {
		global $wgobd_settings;

		wp_enqueue_style(  'wgobd-backend', WGOBD_CSS_URL . '/wgo-backend.css', array('thickbox'), WGOBD_VERSION );

		wp_enqueue_script("jquery");
		wp_enqueue_script("jquery-ui-core");
		wp_enqueue_script('media-upload');
		wp_enqueue_script('thickbox');
		wp_enqueue_script('my-upload');
	}

	/**
	 * plugin_action_links function
	 *
	 * Adds a link to Settings page in plugin list page
	 *
	 * @return array
	 **/
	function plugin_action_links( $links ) {
		$settings = sprintf( __( '<a href="%s">Settings</a>', WGOBD_PLUGIN_NAME ), admin_url( 'edit.php?post_type=' . WGOBD_POST_TYPE . '&page=' . WGOBD_PLUGIN_NAME . '-settings' ) );
		array_unshift( $links, $settings );
		return $links;
	}

	/**
	 * plugin_row_meta function
	 *
	 *
	 *
	 * @return void
	 **/
	function plugin_row_meta( $links, $file ) {
		if( $file == WGOBD_PLUGIN_BASENAME ) :
		$links[] = sprintf( __( '<a href="%s" target="_blank">Donate</a>', WGOBD_PLUGIN_NAME ), 'https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=9JJMUW48W2ED8' );
		$links[] = sprintf( __( '<a href="%s" target="_blank">Get Support</a>', WGOBD_PLUGIN_NAME ), 'http://theseednetwork.com/get-supported/' );
		endif;

		return $links;
	}
}
