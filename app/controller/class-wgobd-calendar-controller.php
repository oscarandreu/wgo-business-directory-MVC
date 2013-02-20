<?php
//
//  class-wgobd-calendar-controller.php
//  all-in-one-event-calendar
//
//  Created by The Seed Studio on 2011-07-13.
//

/**
 * wgobd_Calendar_Controller class
 *
 * @package Controllers
 * @author The Seed Studio
 **/
class wgobd_Calendar_Controller {
	/**
	 * _instance class variable
	 *
	 * Class instance
	 *
	 * @var null | object
	 **/
	static $_instance = NULL;

	/**
	 * request class variable
	 *
	 * Stores a custom $_REQUEST array for all calendar requests
	 *
	 * @var array
	 **/
	private $request = array();

	/**
	 * __construct function
	 *
	 * Default constructor - calendar initialization
	 **/
	private function __construct() {
		// ===========
		// = ACTIONS =
		// ===========
		// Handle AJAX requests
		// Strange! Now regular WordPress requests will respond to the below AJAX
		// hooks! Thus we need to check to make sure we are being called by the
		// AJAX script before returning AJAX responses.
		if( basename( $_SERVER['SCRIPT_NAME'] ) == 'admin-ajax.php' )
		{
			add_action( 'wp_ajax_wgobd_month', array( &$this, 'ajax_month' ) );
			add_action( 'wp_ajax_wgobd_oneday', array( &$this, 'ajax_oneday' ) );
			add_action( 'wp_ajax_wgobd_week', array( &$this, 'ajax_week' ) );
			add_action( 'wp_ajax_wgobd_agenda', array( &$this, 'ajax_agenda' ) );
			add_action( 'wp_ajax_wgobd_term_filter', array( &$this, 'ajax_term_filter' ) );

			add_action( 'wp_ajax_nopriv_wgobd_month', array( &$this, 'ajax_month' ) );
			add_action( 'wp_ajax_nopriv_wgobd_oneday', array( &$this, 'ajax_oneday' ) );
			add_action( 'wp_ajax_nopriv_wgobd_week', array( &$this, 'ajax_week' ) );
			add_action( 'wp_ajax_nopriv_wgobd_agenda', array( &$this, 'ajax_agenda' ) );
			add_action( 'wp_ajax_nopriv_wgobd_term_filter', array( &$this, 'ajax_term_filter' ) );
		}
	}

	/**
	 * process_request function
	 *
	 * Initialize/validate custom request array, based on contents of $_REQUEST,
	 * to keep track of this component's request variables.
	 *
	 * @return void
	 **/
	function process_request()
	{
		global $wgobd_settings;

		// Find out which view of the calendar page was requested, then validate
		// request parameters accordingly and save them to our custom request
		// object
		$this->request['action'] = isset( $_REQUEST['action'] ) ? $_REQUEST['action'] : '';
		if( ! in_array( $this->request['action'],
			      array( 'wgobd_month', 'wgobd_oneday', 'wgobd_week', 'wgobd_agenda', 'wgobd_term_filter' ) ) )
			$this->request['action'] = 'wgobd_' . $wgobd_settings->default_calendar_view;

		switch( $this->request['action'] )
		{
			case 'wgobd_month':
				$this->request['wgobd_month_offset'] =
					isset( $_REQUEST['wgobd_month_offset'] ) ? intval( $_REQUEST['wgobd_month_offset'] ) : 0;
				// Parse active event parameter as an integer ID
				$this->request['wgobd_active_event'] = isset( $_REQUEST['wgobd_active_event'] ) ? intval( $_REQUEST['wgobd_active_event'] ) : null;
				// Category/tag filter parameters
				$this->request['wgobd_cat_ids'] = isset( $_REQUEST['wgobd_cat_ids'] ) ? $_REQUEST['wgobd_cat_ids'] : null;
				$this->request['wgobd_tag_ids'] = isset( $_REQUEST['wgobd_tag_ids'] ) ? $_REQUEST['wgobd_tag_ids'] : null;
				$this->request['wgobd_post_ids'] = isset( $_REQUEST['wgobd_post_ids'] ) ? $_REQUEST['wgobd_post_ids'] : null;
				break;

			case 'wgobd_oneday':
				$this->request['wgobd_oneday_offset'] =
					isset( $_REQUEST['wgobd_oneday_offset'] ) ? intval( $_REQUEST['wgobd_oneday_offset'] ) : 0;
				// Parse active event parameter as an integer ID
				$this->request['wgobd_active_event'] = isset( $_REQUEST['wgobd_active_event'] ) ? intval( $_REQUEST['wgobd_active_event'] ) : null;
				// Category/tag filter parameters
				$this->request['wgobd_cat_ids'] = isset( $_REQUEST['wgobd_cat_ids'] ) ? $_REQUEST['wgobd_cat_ids'] : null;
				$this->request['wgobd_tag_ids'] = isset( $_REQUEST['wgobd_tag_ids'] ) ? $_REQUEST['wgobd_tag_ids'] : null;
				$this->request['wgobd_post_ids'] = isset( $_REQUEST['wgobd_post_ids'] ) ? $_REQUEST['wgobd_post_ids'] : null;
				break;

			case 'wgobd_week':
				$this->request['wgobd_week_offset'] =
					isset( $_REQUEST['wgobd_week_offset'] ) ? intval( $_REQUEST['wgobd_week_offset'] ) : 0;
				// Parse active event parameter as an integer ID
				$this->request['wgobd_active_event'] = isset( $_REQUEST['wgobd_active_event'] ) ? intval( $_REQUEST['wgobd_active_event'] ) : null;
				// Category/tag filter parameters
				$this->request['wgobd_cat_ids'] = isset( $_REQUEST['wgobd_cat_ids'] ) ? $_REQUEST['wgobd_cat_ids'] : null;
				$this->request['wgobd_tag_ids'] = isset( $_REQUEST['wgobd_tag_ids'] ) ? $_REQUEST['wgobd_tag_ids'] : null;
				$this->request['wgobd_post_ids'] = isset( $_REQUEST['wgobd_post_ids'] ) ? $_REQUEST['wgobd_post_ids'] : null;
				break;

			case 'wgobd_agenda':
				$this->request['wgobd_page_offset'] =
					isset( $_REQUEST['wgobd_page_offset'] ) ? intval( $_REQUEST['wgobd_page_offset'] ) : 0;
				// Parse active event parameter as an integer ID
				$this->request['wgobd_active_event'] = isset( $_REQUEST['wgobd_active_event'] ) ? intval( $_REQUEST['wgobd_active_event'] ) : null;
				// Category/tag filter parameters
				$this->request['wgobd_cat_ids'] = isset( $_REQUEST['wgobd_cat_ids'] ) ? $_REQUEST['wgobd_cat_ids'] : null;
				$this->request['wgobd_tag_ids'] = isset( $_REQUEST['wgobd_tag_ids'] ) ? $_REQUEST['wgobd_tag_ids'] : null;
				$this->request['wgobd_post_ids'] = isset( $_REQUEST['wgobd_post_ids'] ) ? $_REQUEST['wgobd_post_ids'] : null;
				break;

			case 'wgobd_term_filter':
				$this->request['wgobd_post_ids'] = isset( $_REQUEST['wgobd_post_ids'] ) ? $_REQUEST['wgobd_post_ids'] : null;
				$this->request['wgobd_term_ids'] = isset( $_REQUEST['wgobd_term_ids'] ) ? $_REQUEST['wgobd_term_ids'] : null;
				break;
		}
	}

	/**
	 * get_instance function
	 *
	 * Return singleton instance
	 *
	 * @return object
	 **/
	static function get_instance() {
		if( self::$_instance === NULL ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	/**
	 * view function
	 *
	 * Display requested calendar page.
	 *
	 * @return void
	 **/
	function view()
 	{
		global $wgobd_view_helper,
		       $wgobd_settings,
		       $wgobd_events_helper;

		$this->process_request();

		// Set body class
		add_filter( 'body_class', array( &$this, 'body_class' ) );
		// Queue any styles, scripts
		$this->load_css();
		$this->load_js();

	  $post_ids = array_filter( explode( ',', $this->request['wgobd_post_ids'] ), 'is_numeric' );
		// Define arguments for specific calendar sub-view (month, agenda, etc.)
		$args = array(
			'active_event' => $this->request['wgobd_active_event'],
		  'post_ids'     => $post_ids,
		);

		// Find out which view of the calendar page was requested
		switch( $this->request['action'] )
		{
			case 'wgobd_month':
				$args['month_offset'] = $this->request['wgobd_month_offset'];
				$view = $this->get_month_view( $args );
				break;

			case 'wgobd_oneday':
				$args['oneday_offset'] = $this->request['wgobd_oneday_offset'];
				$view = $this->get_oneday_view( $args );
				break;

			case 'wgobd_week':
				$args['week_offset'] = $this->request['wgobd_week_offset'];
				$view = $this->get_week_view( $args );
				break;

			case 'wgobd_agenda':
				$args['page_offset'] = $this->request['wgobd_page_offset'];
				$view = $this->get_agenda_view( $args );
				break;
		}

	  if( $wgobd_settings->show_create_event_button && current_user_can( 'edit_wgobd_events' ) )
	  	$create_event_url = admin_url( 'post-new.php?post_type=' . wgobd_POST_TYPE );
	  else
	  	$create_event_url = false;

	  // Validate preselected category/tag/post IDs
	  $cat_ids  = join( ',', array_filter( explode( ',', $this->request['wgobd_cat_ids'] ), 'is_numeric' ) );
	  $tag_ids  = join( ',', array_filter( explode( ',', $this->request['wgobd_tag_ids'] ), 'is_numeric' ) );
	  $post_ids = join( ',', $post_ids );

	  $categories = get_terms( 'events_categories', array( 'orderby' => 'name' ) );
    foreach( $categories as &$cat ) {
      $cat->color = $wgobd_events_helper->get_category_color_square( $cat->term_id );
    }
		// Define new arguments for overall calendar view
		$args = array(
			'view'                    => $view,
			'create_event_url'        => $create_event_url,
			'categories'              => $categories,
			'tags'                    => get_terms( 'events_tags', array( 'orderby' => 'name' ) ),
			'selected_cat_ids'        => $cat_ids,
			'selected_tag_ids'        => $tag_ids,
			'selected_post_ids'       => $post_ids,
			'show_subscribe_buttons'  => ! $wgobd_settings->turn_off_subscription_buttons
		);

		// Feed month view into generic calendar view
		echo apply_filters( 'wgobd_view', $wgobd_view_helper->get_view( 'calendar.php', $args ), $args );
	}

	/**
	 * get_month_view function
	 *
	 * Return the embedded month view of the calendar, optionally filtered by
	 * event categories and tags.
	 *
	 * @param array $args     associative array with any of these elements:
	 *   int month_offset  => specifies which month to display relative to the
	 *                        current month
	 *   int active_event  => specifies which event to make visible when
	 *                        page is loaded
	 *   array categories  => restrict events returned to the given set of
	 *                        event category slugs
	 *   array tags        => restrict events returned to the given set of
	 *                        event tag names
	 *   array post_ids    => restrict events returned to the given set of
	 *                        post IDs
	 *
	 * @return string	        returns string of view output
	 **/
	function get_month_view( $args )
 	{
		global $wgobd_view_helper,
		       $wgobd_events_helper,
		       $wgobd_calendar_helper;

    $defaults = array(
      'month_offset'  => 0,
      'active_event'  => null,
      'categories'    => array(),
      'tags'          => array(),
      'post_ids'      => array(),
    );
    $args = wp_parse_args( $args, $defaults );

		extract( $args );

		// Get components of localized time
		$bits = $wgobd_events_helper->gmgetdate( $wgobd_events_helper->gmt_to_local( time() ) );
		// Use first day of the month as reference timestamp, and apply month offset
		$timestamp = gmmktime( 0, 0, 0, $bits['mon'] + $month_offset, 1, $bits['year'] );

		$days_events = $wgobd_calendar_helper->get_events_for_month( $timestamp,
			array( 'cat_ids' => $categories, 'cat_ids' => $tags, 'post_ids' => $post_ids ) );
		$cell_array = $wgobd_calendar_helper->get_month_cell_array( $timestamp, $days_events );
		$pagination_links = $wgobd_calendar_helper->get_month_pagination_links( $month_offset );

		$view_args = array(
			'title'            => date_i18n( 'F Y', $timestamp, true ),
			'weekdays'         => $wgobd_calendar_helper->get_weekdays(),
			'cell_array'       => $cell_array,
			'pagination_links' => $pagination_links,
			'active_event'     => $active_event,
			'post_ids'         => join( ',', $post_ids ),
		);
		return apply_filters( 'wgobd_get_month_view', $wgobd_view_helper->get_view( 'month.php', $view_args ), $view_args );
	}

	/**
	 * get_oneday_view function
	 *
	 * Return the embedded dayh view of the calendar, optionally filtered by
	 * event categories and tags.
	 *
	 * @param array $args     associative array with any of these elements:
	 *   int oneday_offset  => specifies which day to display relative to the
	 *                        current day
	 *   int active_event  => specifies which event to make visible when
	 *                        page is loaded
	 *   array categories  => restrict events returned to the given set of
	 *                        event category slugs
	 *   array tags        => restrict events returned to the given set of
	 *                        event tag names
	 *   array post_ids    => restrict events returned to the given set of
	 *                        post IDs
	 *
	 * @return string	        returns string of view output
	 **/
	function get_oneday_view( $args )
 	{
		global $wgobd_view_helper,
		       $wgobd_events_helper,
		       $wgobd_calendar_helper;

		$defaults = array(  
			'oneday_offset'  => 0, 
			'active_event'  => null,
			'categories'    => array(),
			'tags'          => array(),
			'post_ids'      => array(),
		);
		$args = wp_parse_args( $args, $defaults );

		extract( $args );
		// Get components of localized time
		$bits = $wgobd_events_helper->gmgetdate( $wgobd_events_helper->gmt_to_local( time() ) );
		// Use actually day of the month as reference timestamp, and apply day offset
		$timestamp = gmmktime( 0, 0, 0, $bits['mon'], $bits['mday'], $bits['year'] );
		$day_shift = 0;
		// Then apply one-day offset
		$day_shift += $args['oneday_offset'];
		$timestamp = gmmktime( 0, 0, 0, $bits['mon'], $bits['mday'] + $day_shift, $bits['year'] );

		$cell_array = $wgobd_calendar_helper->get_oneday_cell_array( $timestamp, array( 'cat_ids' => $categories, 'cat_ids' => $tags, 'post_ids' => $post_ids ) );
		$pagination_links = $wgobd_calendar_helper->get_oneday_pagination_links( $oneday_offset );

		$view_args = array(
			'title'            => date_i18n( 'j F Y', $timestamp, true ),
			'cell_array'       => $cell_array,
			'now_top'           => $bits['hours'] * 60 + $bits['minutes'],
			'pagination_links' => $pagination_links,
			'active_event'     => $active_event,
			'post_ids'         => join( ',', $post_ids ),
			'time_format'       => get_option( 'time_format', 'g a' ),
			'done_allday_label' => false,
			'done_grid'         => false
		);
		return apply_filters( 'wgobd_get_oneday_view', $wgobd_view_helper->get_view( 'oneday.php', $view_args ), $view_args );
	}

	/**
	 * get_week_view function
	 *
	 * Return the embedded week view of the calendar, optionally filtered by
	 * event categories and tags.
	 *
	 * @param array $args     associative array with any of these elements:
	 *   int week_offset   => specifies which week to display relative to the
	 *                        current week
	 *   int active_event  => specifies which event to make visible when
	 *                        page is loaded
	 *   array categories  => restrict events returned to the given set of
	 *                        event category slugs
	 *   array tags        => restrict events returned to the given set of
	 *                        event tag names
	 *   array post_ids    => restrict events returned to the given set of
	 *                        post IDs
	 *
	 * @return string	        returns string of view output
	 */
	function get_week_view( $args )
 	{
		global $wgobd_view_helper,
		       $wgobd_events_helper,
		       $wgobd_calendar_helper;

		$defaults = array(
			'week_offset'   => 0,
			'active_event'  => null,
			'categories'    => array(),
			'tags'          => array(),
			'post_ids'      => array(),
		);
		$args = wp_parse_args( $args, $defaults );

		extract( $args );

		// Get components of localized time
		$bits = $wgobd_events_helper->gmgetdate( $wgobd_events_helper->gmt_to_local( time() ) );
		// Day shift is initially the first day of the week according to settings
		$day_shift = $wgobd_events_helper->get_week_start_day_offset( $bits['wday'] );
		// Then apply week offset
		$day_shift += $args['week_offset'] * 7;

		// Now apply to reference timestamp
		$timestamp = gmmktime( 0, 0, 0, $bits['mon'], $bits['mday'] + $day_shift, $bits['year'] );

		$cell_array = $wgobd_calendar_helper->get_week_cell_array( $timestamp,
			array( 'cat_ids' => $categories, 'cat_ids' => $tags, 'post_ids' => $post_ids ) );
		$pagination_links = $wgobd_calendar_helper->get_week_pagination_links( $week_offset );

		/* translators: "%s" represents the week's starting date */
		$view_args = array(
			'title'             => sprintf( __( 'Week of %s', wgobd_PLUGIN_NAME ), date_i18n( __( 'F j', wgobd_PLUGIN_NAME ), $timestamp, true ) ),
			'cell_array'        => $cell_array,
			'now_top'           => $bits['hours'] * 60 + $bits['minutes'],
			'pagination_links'  => $pagination_links,
			'active_event'      => $active_event,
			'post_ids'          => join( ',', $post_ids ),
			'time_format'       => get_option( 'time_format', 'g a' ),
			'done_allday_label' => false,
			'done_grid'         => false
		);
		return apply_filters( 'wgobd_get_week_view', $wgobd_view_helper->get_view( 'week.php', $view_args ), $view_args );
	}

	/**
	 * get_agenda_view function
	 *
	 * Return the embedded agenda view of the calendar, optionally filtered by
	 * event categories and tags.
	 *
	 * @param array $args     associative array with any of these elements:
	 *   int page_offset   => specifies which page to display relative to today's page
	 *   int active_event  => specifies which event to make visible when
	 *                        page is loaded
	 *   array categories  => restrict events returned to the given set of
	 *                        event category slugs
	 *   array tags        => restrict events returned to the given set of
	 *                        event tag names
	 *
	 * @return string	        returns string of view output
	 **/
	function get_agenda_view( $args )
 	{
		global $wgobd_view_helper,
		       $wgobd_events_helper,
		       $wgobd_calendar_helper,
		       $wgobd_settings;

		extract( $args );

		// Get localized time
		$timestamp = $wgobd_events_helper->gmt_to_local( time() );

		// Get events, then classify into date array
		$event_results = $wgobd_calendar_helper->get_events_relative_to(
			$timestamp,
			$wgobd_settings->agenda_events_per_page,
			$page_offset,
			array( 'post_ids' => $post_ids )
		);
		$dates = $wgobd_calendar_helper->get_agenda_date_array( $event_results['events'] );

		$pagination_links =
			$wgobd_calendar_helper->get_agenda_pagination_links(
			 	$page_offset, $event_results['prev'], $event_results['next'] );

		// Incorporate offset into date
		$args = array(
			'title'             => __( 'Agenda', wgobd_PLUGIN_NAME ),
			'dates'             => $dates,
			'page_offset'       => $page_offset,
			'pagination_links'  => $pagination_links,
			'active_event'      => $active_event,
			'expanded'          => $wgobd_settings->agenda_events_expanded,
			'post_ids'          => join( ',', $post_ids ),
		);
		return apply_filters( 'wgobd_get_agenda_view', $wgobd_view_helper->get_view( 'agenda.php', $args ), $args );
	}

	/**
	 * ajax_month function
	 *
	 * AJAX request handler for month view.
	 *
	 * @return void
	 */
	function ajax_month() {
		global $wgobd_view_helper;

		$this->process_request();

		// View arguments
		$args = array(
			'month_offset' => $this->request['wgobd_month_offset'],
			'active_event' => $this->request['wgobd_active_event'],
		  'post_ids'     => array_filter( explode( ',', $this->request['wgobd_post_ids'] ), 'is_numeric' ),
		);

		// Return this data structure to the client
		$data = array(
			'body_class' => join( ' ', $this->body_class() ),
			'html' => $this->get_month_view( $args ),
		);
		$wgobd_view_helper->json_response( $data );
	}

	/**
	 * ajax_oneday function
	 *
	 * AJAX request handler for day view.
	 *
	 * @return void
	 */
	function ajax_oneday() {
		global $wgobd_view_helper;

		$this->process_request();

		// View arguments
		$args = array(
			'oneday_offset' => $this->request['wgobd_oneday_offset'],
			'active_event' => $this->request['wgobd_active_event'],
			'post_ids'     => array_filter( explode( ',', $this->request['wgobd_post_ids'] ), 'is_numeric' ),
		);

		// Return this data structure to the client
		$data = array(
			'body_class' => join( ' ', $this->body_class() ),
			'html' => $this->get_oneday_view( $args ),
		);
		$wgobd_view_helper->json_response( $data );
	}

	/**
	 * ajax_week function
	 *
	 * AJAX request handler for week view.
	 *
	 * @return void
	 */
	function ajax_week() {
		global $wgobd_view_helper;

		$this->process_request();

		// View arguments
		$args = array(
			'week_offset' => $this->request['wgobd_week_offset'],
			'active_event' => $this->request['wgobd_active_event'],
		  'post_ids'     => array_filter( explode( ',', $this->request['wgobd_post_ids'] ), 'is_numeric' ),
		);

		// Return this data structure to the client
		$data = array(
			'body_class' => join( ' ', $this->body_class() ),
			'html' => $this->get_week_view( $args ),
		);
		$wgobd_view_helper->json_response( $data );
	}

	/**
	 * ajax_agenda function
	 *
	 * AJAX request handler for agenda view.
	 *
	 * @return void
	 **/
	function ajax_agenda() {
		global $wgobd_view_helper;

		$this->process_request();

		// View arguments
		$args = array(
			'page_offset'  => $this->request['wgobd_page_offset'],
			'active_event' => $this->request['wgobd_active_event'],
			'post_ids'     => array_filter( explode( ',', $this->request['wgobd_post_ids'] ), 'is_numeric' ),
		);

		// Return this data structure to the client
		$data = array(
			'body_class' => join( ' ', $this->body_class() ),
			'html' => $this->get_agenda_view( $args ),
		);
		$wgobd_view_helper->json_response( $data );
	}

	/**
	 * ajax_term_filter function
	 *
	 * AJAX request handler that takes a comma-separated list of event IDs and
	 * comma-separated list of term IDs and returns those event IDs within the
	 * set that have any of the term IDs.
	 *
	 * @return void
	 **/
	function ajax_term_filter() {
		global $wgobd_view_helper, $wgobd_events_helper;

		$this->process_request();

		$post_ids = array_unique( explode( ',', $this->request['wgobd_post_ids'] ) );

		if( $this->request['wgobd_term_ids'] ) {
			$term_ids = explode( ',', $this->request['wgobd_term_ids'] );
			$matching_ids = $wgobd_events_helper->filter_by_terms( $post_ids, $term_ids );
		} else {
			// If no term IDs were provided for filtering, then return all posts
			$matching_ids = $post_ids;
		}

		$unmatching_ids = array_diff( $post_ids, $matching_ids );

		$data = array(
			'matching_ids' => $matching_ids,
			'unmatching_ids' => $unmatching_ids,
	 	);
		$wgobd_view_helper->json_response( $data );
	}

	/**
	 * body_class function
	 *
	 * Append custom classes to body element.
	 *
	 * @return void
	 **/
	function body_class( $classes = array() ) {
		$classes[] = 'wgobd-calendar';

		// Reformat action for body class
		$action = $this->request['action'];
		$action = strtr( $action, '_', '-' );
		$action = preg_replace( '/^wgobd-/', '', $action );

		$classes[] = "wgobd-action-$action";
		if( isset( $this->request['wgobd_month_offset'] ) && ! $this->request['wgobd_month_offset'] &&
				isset( $this->request['wgobd_page_offset'] ) && ! $this->request['wgobd_page_offset'] ) {
			$classes[] = 'wgobd-today';
		}
		return $classes;
	}

	/**
	 * load_css function
	 *
	 * Enqueue any CSS files required by the calendar views, as well as embeds any
	 * CSS rules necessary for calendar container replacement.
	 *
	 * @return void
	 **/
	function load_css()
	{
		global $wgobd_settings;

		wp_enqueue_style( 'wgobd-general', wgobd_CSS_URL . '/general.css', array(), wgobd_VERSION );
		wp_enqueue_style( 'wgobd-calendar', wgobd_CSS_URL . '/calendar.css', array(), wgobd_VERSION );

		if( $wgobd_settings->calendar_css_selector )
			add_action( 'wp_head', array( &$this, 'selector_css' ) );
	}

	/**
	 * selector_css function
	 *
	 * Inserts dynamic CSS rules into <head> section of page to replace
	 * desired CSS selector with calendar.
	 */
	function selector_css() {
		global $wgobd_view_helper, $wgobd_settings;

		$wgobd_view_helper->display_css(
			'selector.css',
			array( 'selector' => $wgobd_settings->calendar_css_selector )
		);
	}

	/**
	 * load_js function
	 *
	 * Enqueue any JavaScript files required by the calendar views.
	 *
	 * @return void
	 **/
	function load_js()
 	{
 		global $wgobd_settings;

		// Include dependent scripts (jQuery plugins, modernizr)
		wp_enqueue_script( 'jquery.scrollTo', wgobd_JS_URL . '/jquery.scrollTo-min.js', array( 'jquery' ), wgobd_VERSION );
		wp_enqueue_script( 'jquery.tableScroll', wgobd_JS_URL . '/jquery.tablescroll.js', array( 'jquery' ), wgobd_VERSION );
		wp_enqueue_script( 'modernizr.custom.78720', wgobd_JS_URL . '/modernizr.custom.78720.js', array(), wgobd_VERSION );
		// Include element selector function
		wp_enqueue_script( 'wgobd-element-selector', wgobd_JS_URL . '/element-selector.js', array( 'jquery', 'jquery.scrollTo' ), wgobd_VERSION );
		// Include custom script
		wp_enqueue_script( 'wgobd-calendar', wgobd_JS_URL . '/calendar.js',
			array( 'jquery', 'jquery.scrollTo', 'jquery.tableScroll', 'modernizr.custom.78720' ), wgobd_VERSION );

		$data = array(
			// Point script to AJAX URL - use relative to plugin URL to fix domain mapping issues
			'ajaxurl'       => site_url( 'wp-admin/admin-ajax.php' ),
			// What this view defaults to, in case there is no #hash appended
			'default_hash'  => '#' . http_build_query( $this->request ),
			'export_url'    => wgobd_EXPORT_URL,
			// Body classes if need to be set manually
			'body_class'    => join( ' ', $this->body_class() ),
		);
		// Replace desired CSS selector with calendar, if selector has been set
		if( $wgobd_settings->calendar_css_selector )
		{
			$page = get_post( $wgobd_settings->calendar_post_id );
			$data['selector'] = $wgobd_settings->calendar_css_selector;
			$data['title']    = $page->post_title;
		}

		wp_localize_script( 'wgobd-calendar', 'wgobd_calendar', $data );
	}

	/**
	 * function is_category_requested
	 *
	 * Returns the comma-separated list of category IDs that the calendar page
	 * was requested to be prefiltered by.
	 *
	 * @return string
	 */
	function get_requested_categories() {
		return $this->request['wgobd_cat_ids'];
	}
}
// END class
