<?php
//
//  class-wgobd-events-controller.php
//  all-in-one-event-calendar
//
//  Created by The Seed Studio on 2011-07-13.
//

/**
 * wgobd_Events_Controller class
 *
 * @package Controllers
 * @author The Seed Studio
 **/
class wgobd_Events_Controller {
	/**
	 * _instance class variable
	 *
	 * Class instance
	 *
	 * @var null | object
	 **/
	private static $_instance = NULL;

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
	 * Constructor
	 *
	 **/
	private function __construct() { }

	/**
	 * delete_hook function
	 *
	 * If the deleted post is an event
	 * then all entries that match the post_id are
	 * removed from wgobd_events and wgobd_event_instances tables
	 *
	 * @param int $pid Post ID
	 *
	 * @return bool | int
	 **/
	function delete_post( $pid ) {
		global $wpdb;

		$sql = "SELECT
							ID
						FROM
							$wpdb->posts
						WHERE
							ID = %d AND
							post_type = '" . wgobd_POST_TYPE . "'";

		// is this post an event?
		if( $wpdb->get_var( $wpdb->prepare( $sql, $pid ) ) ) {
			$table_name = $wpdb->prefix . 'wgobd_events';
			$sql = "DELETE FROM
								$table_name
							WHERE
								post_id = %d";
			// delete from wgobd_events
			$wpdb->query( $wpdb->prepare( $sql, $pid ) );

			$table_name = $wpdb->prefix . 'wgobd_event_instances';
			$sql = "DELETE FROM
								$table_name
							WHERE
								post_id = %d";
			// delete from wgobd_event_instances
			return $wpdb->query( $wpdb->prepare( $sql, $pid ) );
		}
		return true;
	}

	/**
	 * init function
	 *
	 * This function is executed when admin_head hook is called.
	 * Adds CSS and JS files.
	 *
	 * @return void
	 **/
	function init()
	{
		global $wgobd_events_helper, $wgobd_settings, $wp_locale;

		// Initialize dashboard view
		if( is_admin() ) {
			// ======
			// = JS =
			// ======
			// Include timespan helper functions
			wp_enqueue_script( 'jquery.calendrical', 			wgobd_JS_URL . '/jquery.calendrical.js', array( 'jquery' ), wgobd_VERSION );
			// Include timespan plugin
			wp_enqueue_script( 'jquery.timespan', 				wgobd_JS_URL . '/jquery.timespan.js', array( 'jquery', 'jquery.calendrical' ), wgobd_VERSION );
			// Include timespan plugin
			wp_enqueue_script( 'jquery.inputdate', 				wgobd_JS_URL . '/jquery.inputdate.js', array( 'jquery', 'jquery.calendrical' ), wgobd_VERSION );
			// Include Google Maps API
			wp_enqueue_script( 'gmap_api', 								'http://maps.google.com/maps/api/js?sensor=false&language=' . $wgobd_events_helper->get_lang() );
			// Include autocomplete_geomod plugin
			wp_enqueue_script( 'autocomplete_geomod', 		wgobd_JS_URL . '/jquery.autocomplete_geomod.js', array( 'jquery' ), wgobd_VERSION );
			// Include geo_autocomplete plugin
			wp_enqueue_script( 'geo_autocomplete', 				wgobd_JS_URL . '/geo_autocomplete.js', array( 'jquery', 'autocomplete_geomod' ), wgobd_VERSION );
			// Include element selector function
			wp_enqueue_script( 'wgobd-element-selector', 	wgobd_JS_URL . '/element-selector.js', array( 'jquery' ), wgobd_VERSION );
			// Include jQuery Tools form elements
			wp_enqueue_script( 'jquery.tools-form',       wgobd_JS_URL . '/jquery-tools-1.2.5.min.js', array( 'jquery' ), wgobd_VERSION );
			// Include add new event script
			wp_enqueue_script( 'wgobd-blockui', 		      wgobd_JS_URL . '/jquery.blockUI.js', array( 'jquery' ), wgobd_VERSION );
			// Include date picker plugin
			wp_enqueue_script( 'wgobd-datepicker', 		    wgobd_JS_URL . '/datepicker.js', array( 'jquery' ), wgobd_VERSION );
			
			wp_enqueue_script( 'wgobd-add_new_event', 		wgobd_JS_URL . '/add_new_event.js', array( 'jquery', 
			                                                                                         'jquery.timespan', 
			                                                                                         'wgobd-element-selector', 
			                                                                                         'jquery.tools-form', 
			                                                                                         'wgobd-blockui',
			                                                                                         'wgobd-datepicker' ), wgobd_VERSION );

			wp_enqueue_script( 'wgobd-color-picker', 	    wgobd_JS_URL . '/colorpicker.js', array( 'jquery' ), wgobd_VERSION );

			// Supply custom value to JavaScript from PHP
			wp_localize_script( 'wgobd-add_new_event', 'wgobd_add_new_event', array(
				// Current time, used for date/time pickers
				'now'                    => $wgobd_events_helper->gmt_to_local( time() ),
				// Date format for date pickers
				'date_format'            => $wgobd_settings->input_date_format,
				// Names for months in date picker header (escaping is done in wp_localize_script)
				'month_names'            => implode( ',', $wp_locale->month ),
				// Names for days in date picker header (escaping is done in wp_localize_script)
				'day_names'              => implode( ',', $wp_locale->weekday_initial ),
				// Start the week on this day in the date picker
				'week_start_day'         => $wgobd_settings->week_start_day,
				// 24h time format for time pickers
				'twentyfour_hour'        => $wgobd_settings->input_24h_time,
				// Set region biasing for geo_autocomplete plugin
				'region'                 => ( $wgobd_settings->geo_region_biasing ) ? $wgobd_events_helper->get_region() : '',
				// ICS feed error messages
				'duplicate_feed_message' => esc_html__( 'This feed is already being imported.', wgobd_PLUGIN_NAME ),
				'invalid_url_message'    => esc_html__( 'Please enter a valid iCalendar URL.', wgobd_PLUGIN_NAME ),
			) );

			// =======
			// = CSS =
			// =======
			// include autocomplete style
			wp_enqueue_style( 'autocomplete',         wgobd_CSS_URL . '/jquery.autocomplete.css', array(), wgobd_VERSION );
			// include colorpicker style
			wp_enqueue_style( 'colorpicker',          wgobd_CSS_URL . '/colorpicker.css', array(), wgobd_VERSION );
			// include add new event style
			wp_enqueue_style( 'wgobd_add_new_event',  wgobd_CSS_URL . '/add_new_event.css', array(), wgobd_VERSION );
			// include datepicker style
			wp_enqueue_style( 'wgobd_datepicker',  wgobd_CSS_URL . '/datepicker.css', array(), wgobd_VERSION );
		}
		// Initialize front-end view
		else
		{
			// ======
			// = JS =
			// ======
			wp_enqueue_script( 'wgobd-event', wgobd_JS_URL . '/event.js', array( 'jquery' ), wgobd_VERSION );
			// Supply custom value to JavaScript from PHP
			wp_localize_script( 'wgobd-event', 'wgobd_event', array(
				// Language for Google Map
				'language' => $wgobd_events_helper->get_lang()
			) );

			// =======
			// = CSS =
			// =======
			wp_enqueue_style( 'wgobd-general', wgobd_CSS_URL . '/general.css', array(), wgobd_VERSION );
			wp_enqueue_style( 'wgobd-event', wgobd_CSS_URL . '/event.css', array(), wgobd_VERSION );
		}
	}

	/**
	 * meta_box_view function
	 *
	 * Add Events Calculator box to the Add New Event page
	 *
	 * @return void
	 **/
	function meta_box_view() {
		global $wgobd_view_helper,
					 $wgobd_events_helper,
					 $post,
					 $wpdb,
					 $wgobd_settings;

		// ==================
		// = Default values =
		// ==================
		$all_day_event    = '';
		$start_timestamp  = '';
		$end_timestamp    = '';
		$show_map         = false;
		$google_map       = '';
		$venue            = '';
		$country          = '';
		$address          = '';
		$city             = '';
		$province         = '';
		$postal_code      = '';
		$contact_name     = '';
		$contact_phone    = '';
		$contact_email    = '';
		$cost             = '';
		$rrule            = '';
		$rrule_text       = '';
		$repeating_event  = false;
		$exrule           = '';
		$exrule_text      = '';
		$exclude_event    = false;
		$exdate           = '';

		try
	 	{
			$event = new wgobd_Event( $post->ID );

			// Existing event was found. Initialize form values with values from
			// event object.

			$all_day_event    = $event->allday ? 'checked="checked"' : '';

			$start_timestamp  = $wgobd_events_helper->gmt_to_local( $event->start );
			$end_timestamp 	  = $wgobd_events_helper->gmt_to_local( $event->end );

			$show_map         = $event->show_map;
			$google_map       = $show_map ? 'checked="checked"' : '';

			$venue            = $event->venue;
			$country          = $event->country;
			$address          = $event->address;
			$city             = $event->city;
			$province         = $event->province;
			$postal_code      = $event->postal_code;
			$contact_name     = $event->contact_name;
			$contact_phone    = $event->contact_phone;
			$contact_email    = $event->contact_email;
			$cost             = $event->cost;
			$rrule            = empty( $event->recurrence_rules ) ? '' : $wgobd_events_helper->ics_rule_to_local( $event->recurrence_rules );
			$exrule           = empty( $event->exception_rules )  ? '' : $wgobd_events_helper->ics_rule_to_local( $event->exception_rules );
			$exdate           = empty( $event->exception_dates )  ? '' : $wgobd_events_helper->exception_dates_to_local( $event->exception_dates );
			$repeating_event  = empty( $rrule )  ? false : true;
			$exclude_event    = empty( $exrule ) ? false : true;

			if( $repeating_event )
				$rrule_text = $wgobd_events_helper->rrule_to_text( $rrule );

			if( $exclude_event )
				$exrule_text = $wgobd_events_helper->rrule_to_text( $exrule );
		}
		catch( wgobd_Event_Not_Found $e ) {
			// Event does not exist.
			// Leave form fields undefined (= zero-length strings)
			$event = null;
		}

		// Time zone
		$timezone = get_option( 'gmt_offset' );
		$timezone = sprintf( '(GMT%+d:%02d)', intval( $timezone ), ( abs( $timezone ) * 60 ) % 60 );

		// ===============================
		// = Display event time and date =
		// ===============================
		$args = array(
			'all_day_event'   => $all_day_event,
			'start_timestamp' => $start_timestamp,
			'end_timestamp'   => $end_timestamp,
			'repeating_event' => $repeating_event,
			'rrule'           => $rrule,
			'rrule_text'      => $rrule_text,
			'exclude_event'   => $exclude_event,
			'exrule'          => $exrule,
			'exrule_text'     => $exrule_text,
			'timezone'        => $timezone,
			'exdate'          => $exdate
		);
		$wgobd_view_helper->display( 'box_time_and_date.php', $args );

		// =================================================
		// = Display event location details and Google map =
		// =================================================
		$args = array(
			'venue'						=> $venue,
			'country' 				=> $country,
			'address'					=> $address,
			'city'						=> $city,
			'province' 				=> $province,
			'postal_code' 		=> $postal_code,
			'google_map' 			=> $google_map,
			'show_map'        => $show_map,
		);
		$wgobd_view_helper->display( 'box_event_location.php', $args );

		// ======================
		// = Display event cost =
		// ======================
		$args = array(
			'cost' => $cost
		);
		$wgobd_view_helper->display( 'box_event_cost.php', $args );

		// =========================================
		// = Display organizer contact information =
		// =========================================
		$args = array(
			'contact_name'    => $contact_name,
			'contact_phone'   => $contact_phone,
			'contact_email'   => $contact_email,
		);
		$wgobd_view_helper->display( 'box_event_contact.php', $args );

		if( $wgobd_settings->show_publish_button ) {
			$args = array();
			$post_type = $post->post_type;
			$post_type_object = get_post_type_object( $post_type );
			if( current_user_can( $post_type_object->cap->publish_posts ) )
				$args["button_value"] = is_null( $event ) ? __( 'Publish', wgobd_PLUGIN_NAME ) : __( 'Update', wgobd_PLUGIN_NAME );
			else
				$args["button_value"] = __( 'Submit for Review', wgobd_PLUGIN_NAME );

			$wgobd_view_helper->display( 'box_publish_button.php', $args );
		}

		/*
			TODO Display Eventbrite ticketing
			$wgobd_view_helper->display( 'box_eventbrite.php' );
		*/
	}

	/**
	 * save_post function
	 *
	 * Saves meta post data
	 *
	 * @param int $post_id Post ID
	 *
	 * @return void
	 **/
	function save_post( $post_id, $post ) {
		global $wpdb, $wgobd_events_helper;

		// verify this came from the our screen and with proper authorization,
		// because save_post can be triggered at other times
		if( isset( $_POST[wgobd_POST_TYPE] ) && ! wp_verify_nonce( $_POST[wgobd_POST_TYPE], 'wgobd' ) ) {
			return;
		} else if( ! isset( $_POST[wgobd_POST_TYPE] ) ) {
			return;
		}

		if( isset( $post->post_status ) && $post->post_status == 'auto-draft' )
		return;

		// verify if this is not inline-editing
		if( isset( $_REQUEST['action'] ) && $_REQUEST['action'] == 'inline-save' ) {
			return;
		}

		// verify that the post_type is that of an event
		if( isset( $_POST['post_type'] ) && $_POST['post_type'] != wgobd_POST_TYPE ) {
			return;
		}

		$all_day          = isset( $_POST['wgobd_all_day_event'] )    ? 1                                             : 0;
		$start_time       = isset( $_POST['wgobd_start_time'] )       ? $_POST['wgobd_start_time']                    : '';
		$end_time         = isset( $_POST['wgobd_end_time'] )         ? $_POST['wgobd_end_time']                      : '';
		$venue            = isset( $_POST['wgobd_venue'] )            ? stripslashes( $_POST['wgobd_venue'] )         : '';
		$address          = isset( $_POST['wgobd_address'] )          ? stripslashes( $_POST['wgobd_address'] )       : '';
		$city             = isset( $_POST['wgobd_city'] )             ? stripslashes( $_POST['wgobd_city'] )          : '';
		$province         = isset( $_POST['wgobd_province'] )         ? stripslashes( $_POST['wgobd_province'] )      : '';
		$postal_code      = isset( $_POST['wgobd_postal_code'] )      ? stripslashes( $_POST['wgobd_postal_code'] )   : '';
		$country          = isset( $_POST['wgobd_country'] )          ? stripslashes( $_POST['wgobd_country'] )       : '';
		$google_map       = isset( $_POST['wgobd_google_map'] )       ? 1                                             : 0;
		$cost             = isset( $_POST['wgobd_cost'] )             ? stripslashes( $_POST['wgobd_cost'] )          : '';
		$contact_name     = isset( $_POST['wgobd_contact_name'] )     ? stripslashes( $_POST['wgobd_contact_name'] )  : '';
		$contact_phone    = isset( $_POST['wgobd_contact_phone'] )    ? stripslashes( $_POST['wgobd_contact_phone'] ) : '';
		$contact_email    = isset( $_POST['wgobd_contact_email'] )    ? stripslashes( $_POST['wgobd_contact_email'] ) : '';

		$rrule  = null;
		$exrule = null;
		$exdate = null;

		// if rrule is set, convert it from local to UTC time
		if( isset( $_POST['wgobd_repeat'] ) && ! empty( $_POST['wgobd_repeat'] ) )
			$rrule = $wgobd_events_helper->ics_rule_to_gmt( $_POST['wgobd_rrule'] );

		// if exrule is set, convert it from local to UTC time
		if( isset( $_POST['wgobd_exclude'] ) && ! empty( $_POST['wgobd_exclude'] ) )
			$exrule = $wgobd_events_helper->ics_rule_to_gmt( $_POST['wgobd_exrule'] );

		// if exdate is set, convert it from local to UTC time
		if( isset( $_POST['wgobd_exdate'] ) && ! empty( $_POST['wgobd_exdate'] ) )
			$exdate = $wgobd_events_helper->exception_dates_to_gmt( $_POST['wgobd_exdate'] );

		$is_new = false;
		$event 	= null;
		try {
			$event = new wgobd_Event( $post_id ? $post_id : null );
		} catch( wgobd_Event_Not_Found $e ) {
			// Post exists, but event data hasn't been saved yet. Create new event
			// object.
			$is_new = true;
			$event = new wgobd_Event();
			$event->post_id = $post_id;
		}

		$event->start               = $wgobd_events_helper->local_to_gmt( $start_time );
		$event->end                 = $wgobd_events_helper->local_to_gmt( $end_time );
		$event->allday              = $all_day;
		$event->venue               = $venue;
		$event->address             = $address;
		$event->city                = $city;
		$event->province            = $province;
		$event->postal_code         = $postal_code;
		$event->country             = $country;
		$event->show_map            = $google_map;
		$event->cost                = $cost;
		$event->contact_name        = $contact_name;
		$event->contact_phone       = $contact_phone;
		$event->contact_email       = $contact_email;
		$event->recurrence_rules    = $rrule;
		$event->exception_rules     = $exrule;
		$event->exception_dates     = $exdate;
		$event->save( ! $is_new );

		$wgobd_events_helper->delete_event_cache( $post_id );
		$wgobd_events_helper->cache_event( $event );
		return;
	}

	/**
	 * post_updated_messages function
	 *
	 * Filter success messages returned by WordPress when an event post is
	 * updated/saved.
	 */
	function post_updated_messages( $messages )
	{
		global $post, $post_ID;

		$messages[wgobd_POST_TYPE] = array(
			0 => '', // Unused. Messages start at index 1.
			1 => sprintf( __( 'Event updated. <a href="%s">View event</a>', wgobd_PLUGIN_NAME ), esc_url( get_permalink( $post_ID ) ) ),
			2 => __( 'Custom field updated.', wgobd_PLUGIN_NAME ),
			3 => __( 'Custom field deleted.', wgobd_PLUGIN_NAME ),
			4 => __( 'Event updated.', wgobd_PLUGIN_NAME ),
			/* translators: %s: date and time of the revision */
			5 => isset( $_GET['revision'] ) ? sprintf( __( 'Event restored to revision from %s', wgobd_PLUGIN_NAME ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
			6 => sprintf( __( 'Event published. <a href="%s">View event</a>', wgobd_PLUGIN_NAME ), esc_url( get_permalink($post_ID) ) ),
			7 => __( 'Event saved.' ),
			8 => sprintf( __( 'Event submitted. <a target="_blank" href="%s">Preview event</a>', wgobd_PLUGIN_NAME ), esc_url( add_query_arg( 'preview', 'true', get_permalink( $post_ID ) ) ) ),
			9 => sprintf( __( 'Event scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview event</a>', wgobd_PLUGIN_NAME ),
				// translators: Publish box date format, see http://php.net/date
				date_i18n( __( 'M j, Y @ G:i', wgobd_PLUGIN_NAME ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
			10 => sprintf( __( 'Event draft updated. <a target="_blank" href="%s">Preview event</a>', wgobd_PLUGIN_NAME ), esc_url( add_query_arg( 'preview', 'true', get_permalink( $post_ID ) ) ) ),
		);

		return $messages;
	}

	/**
	 * event_content function
	 *
	 * Filter event post content by inserting relevant details of the event
	 * alongside the regular post content.
	 *
	 * @param string $content Post/Page content
	 *
	 * @return string         Post/Page content
	 **/
	function event_content( $content )
	{
		global $wgobd_events_helper;

		if( get_post_type() == wgobd_POST_TYPE ) {
			$event = $wgobd_events_helper->get_event( get_the_ID() );
			$content = $this->get_view( $event, $content );
		}
		return $content;
	}

	/**
	 * event_excerpt function
	 *
	 * Overrides what wp_trim_excerpt() returned if the post is an event,
	 * and outputs better rich-text (but not too rich) excerpt instead.
	 *
	 * @return void
	 **/
	function event_excerpt( $text )
 	{
		global $wgobd_view_helper,
		       $wgobd_events_helper;

		if( get_post_type() != wgobd_POST_TYPE )
			return $text;

		$event = new wgobd_Event( get_the_ID() );

		ob_start();

		$this->excerpt_view( $event );

		// Re-apply any filters to the post content that normally would have been
		// applied if it weren't for our interference (below).
		echo
		 	shortcode_unautop( wpautop(
				$wgobd_events_helper->trim_excerpt( $event->post->post_content )
			) );

		$page_content = ob_get_contents();
		ob_end_clean();

		return $page_content;
	}

	/**
	 * event_excerpt_noautop function
	 *
	 * Conditionally apply wpautop() filter to content, only if it is not an
	 * event.
	 *
	 * @return void
	 **/
	function event_excerpt_noautop( $content )
	{
		if( get_post_type() != wgobd_POST_TYPE )
			return wpautop( $content );
		return $content;
	}

	/**
	 * get_view function
	 *
	 * Returns the appropriate output to prepend to an event post, depending on
	 * WP loop context.
	 *
	 * @param wgobd_Event $event  The event post being displayed
	 * @param string $content     The post's original content
	 *
	 * @return string             The event data markup to prepend to the post content
	 **/
	function get_view( &$event, &$content )
	{
		global $wgobd_view_helper;

		ob_start();

		if( is_single() ) {
			$this->single_view( $event );
		} else {
			$this->multi_view( $event );
		}

		echo $content;

		if( is_single() )
			$this->single_event_footer( $event );

		$page_content = ob_get_contents();
		ob_end_clean();

		return $page_content;
	}

	/**
	 * single_view function
	 *
	 * Outputs event-specific details as HTML to be prepended to post content
	 * when displayed as a single page.
	 *
	 * @param wgobd_Event $event  The event being displayed
	 *
	 * @return void
	 **/
	function single_view( &$event )
	{
		global $wgobd_view_helper,
		       $wgobd_calendar_helper,
		       $wgobd_settings;

		$subscribe_url = wgobd_EXPORT_URL . "&wgobd_post_ids=$event->post_id";
		$subscribe_url = str_replace( 'webcal://', 'http://', $subscribe_url );

		$args = array(
			'event'                   => &$event,
			'recurrence'              => $event->recurrence_html,
			'exclude'                 => $event->exclude_html,
			'categories'              => $event->categories_html,
			'tags'                    => $event->tags_html,
			'location'                => nl2br( $event->location ),
			'map'                     => $this->get_map_view( $event ),
			'contact'                 => $event->contact_html,
			'calendar_url'            => $wgobd_calendar_helper->get_calendar_url( $event ),
			'subscribe_url'           => $subscribe_url,
			'google_url'              => 'http://www.google.com/calendar/render?cid=' . urlencode( $subscribe_url ),
			'show_subscribe_buttons'  => ! $wgobd_settings->turn_off_subscription_buttons
		);
		$wgobd_view_helper->display( 'event-single.php', $args );
	}

	/**
	 * multi_view function
	 *
	 * Outputs event-specific details as HTML to be prepended to post content
	 * when displayed in a loop alongside other posts.
	 *
	 * @param wgobd_Event $event  The event being displayed
	 *
	 * @return void
	 **/
	function multi_view( &$event )
	{
		global $wgobd_view_helper,
		       $wgobd_calendar_helper;

		$location = str_replace( "\n", ', ', rtrim( $event->location ) );

		$args = array(
			'event' => &$event,
			'recurrence' => $event->recurrence_html,
			'categories' => $event->categories_html,
			'tags' => $event->tags_html,
			'location' => $location,
			'contact' => $event->contact_html,
			'calendar_url' => $wgobd_calendar_helper->get_calendar_url( $event ),
		);
		$wgobd_view_helper->display( 'event-multi.php', $args );
	}

	/**
	 * excerpt_view function
	 *
	 * Outputs event-specific details as HTML to be prepended to post content
	 * when displayed in an excerpt format.
	 *
	 * @param wgobd_Event $event  The event being displayed
	 *
	 * @return void
	 **/
	function excerpt_view( &$event )
	{
		global $wgobd_view_helper,
		       $wgobd_calendar_helper;

		$location = str_replace( "\n", ', ', rtrim( $event->location ) );

		$args = array(
			'event' => &$event,
			'location' => $location,
		);
		$wgobd_view_helper->display( 'event-excerpt.php', $args );
	}

	/**
	 * get_map_view function
	 *
	 * Returns HTML markup displaying a Google map of the given event, if the event
	 * has show_map set to true. Returns a zero-length string otherwise.
	 *
	 * @return void
	 **/
	function get_map_view( &$event )
	{
		global $wgobd_view_helper, $wgobd_events_helper, $wgobd_settings;

		if( ! $event->show_map )
			return '';

		$args = array(
			'address' => $event->address,
			'gmap_url_link' => $wgobd_events_helper->get_gmap_url( $event, false ),
			'hide_maps_until_clicked' => $wgobd_settings->hide_maps_until_clicked
		);
		return $wgobd_view_helper->get_view( 'event-map.php', $args );
	}

	/**
	 * single_event_footer function
	 *
	 * Outputs any markup that should appear below the post's content on the
	 * single post page for this event.
	 *
	 * @return void
	 **/
	function single_event_footer( &$event )
	{
		global $wgobd_view_helper;

		$args = array(
			'event' => &$event,
		);
		return $wgobd_view_helper->display( 'event-single-footer.php', $args );
	}

	/**
	 * events_categories_add_form_fields function
	 *
	 *
	 *
	 * @return void
	 **/
	 function events_categories_add_form_fields() {
		global $wgobd_view_helper;

		$args = array( 'edit' => false );
		$wgobd_view_helper->display( 'event_categories-color_picker.php', $args );
	 }

	 /**
 	 * events_categories_edit_form_fields function
 	 *
 	 *
 	 *
 	 * @return void
 	 **/
 	 function events_categories_edit_form_fields( $term ) {
		global $wgobd_view_helper, $wpdb;

		$table_name = $wpdb->prefix . 'wgobd_event_category_colors';
		$color      = $wpdb->get_var( $wpdb->prepare( "SELECT term_color FROM {$table_name} WHERE term_id = %d ", $term->term_id ) );

		$style = '';
		$clr   = '';

		if( ! is_null( $color ) && ! empty( $color ) ) {
			$style = 'style="background-color: ' . $color . '"';
			$clr = $color;
		}
		$args = array(
			'style' => $style,
			'color' => $clr,
			'edit'  => true,
		);
		$wgobd_view_helper->display( 'event_categories-color_picker.php', $args );
	}

	 /**
	  * edited_events_categories function
	  *
	  *
	  *
	  * @return void
	  **/
	function created_events_categories( $term_id ) {
	  global $wpdb;
	  $tag_color_value = '';
	  if( isset( $_POST["tag-color-value"] ) && ! empty( $_POST["tag-color-value"] ) ) {
	    $tag_color_value = $_POST["tag-color-value"];
	  }

	  $table_name = $wpdb->prefix . 'wgobd_event_category_colors';
	  $wpdb->insert( $table_name, array( 'term_id' => $term_id, 'term_color' => $tag_color_value ), array( '%d', '%s' ) );
	}

	function edited_events_categories( $term_id ) {
	  global $wpdb;
	  $tag_color_value = '';
	  if( isset( $_POST["tag-color-value"] ) && ! empty( $_POST["tag-color-value"] ) ) {
	    $tag_color_value = $_POST["tag-color-value"];
	  }

	  $table_name = $wpdb->prefix . 'wgobd_event_category_colors';
	  $term = $wpdb->get_var( $wpdb->prepare( "SELECT term_id FROM {$table_name} WHERE term_id = %d", $term_id ) );

	  if( is_null( $term ) ) {
	    // term doesn't exist, create it
	    $wpdb->insert( $table_name, array( 'term_id' => $term_id, 'term_color' => $tag_color_value ), array( '%d', '%s' ) );
	  } else {
	    // term exist, update it
	    $wpdb->update( $table_name, array( 'term_color' => $tag_color_value ), array( 'term_id' => $term_id ), array( '%s' ), array( '%d' ) );
	  }


	}
}
// END class
