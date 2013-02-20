<?php
//
//  class-wgobd-app-helper.php
//  all-in-one-event-calendar
//
//  Created by The Seed Studio on 2011-07-13.
//

/**
 * wgobd_App_Helper class
 *
 * @package Helpers
 * @author The Seed Studio
 **/
class wgobd_App_Helper {
	/**
	 * _instance class variable
	 *
	 * Class instance
	 *
	 * @var null | object
	 **/
	private static $_instance = NULL;

	/**
	 * Constructor
	 *
	 * Default constructor
	 **/
	private function __construct() { }

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
	 * map_meta_cap function
	 *
	 * Assigns proper capability
	 *
	 * @return void
	 **/
	function map_meta_cap( $caps, $cap, $user_id, $args ) {
		// If editing, deleting, or reading an event, get the post and post type object.
		if( 'edit_wgobd_event' == $cap || 'delete_wgobd_event' == $cap || 'read_wgobd_event' == $cap ) {
			$post = get_post( $args[0] );
			$post_type = get_post_type_object( $post->post_type );
			/* Set an empty array for the caps. */
			$caps = array();
		}

		/* If editing an event, assign the required capability. */
		if( 'edit_wgobd_event' == $cap ) {
			if( $user_id == $post->post_author )
				$caps[] = $post_type->cap->edit_posts;
			else
				$caps[] = $post_type->cap->edit_others_posts;
		}

		/* If deleting an event, assign the required capability. */
		else if( 'delete_wgobd_event' == $cap ) {
			if( $user_id == $post->post_author )
				$caps[] = $post_type->cap->delete_posts;
			else
				$caps[] = $post_type->cap->delete_others_posts;
		}

		/* If reading a private event, assign the required capability. */
		else if( 'read_wgobd_event' == $cap ) {
			if( 'private' != $post->post_status )
				$caps[] = 'read';
			elseif ( $user_id == $post->post_author )
				$caps[] = 'read';
			else
				$caps[] = $post_type->cap->read_private_posts;
		}

		/* Return the capabilities required by the user. */
		return $caps;
	}

	/**
	 * create_post_type function
	 *
	 * Create event's custom post type
	 * and registers events_categories and events_tags under
	 * event's custom post type taxonomy
	 *
	 * @return void
	 **/
	function create_post_type() {
	  global $wgobd_settings;

    // if the event contributor role is not created, create it
		if( !get_role( 'wgobd_event_assistant' ) ) {

		  // creating event contributor role with the same capabilities
		  // as subscriber role, later in this file, event contributor role will be extended
		  // to include more capabilities
			$caps = get_role( 'subscriber' )->capabilities;
			add_role( 'wgobd_event_assistant', 'Event Contributor', $caps );

			// add event managing capability to administrator, editor, author
			foreach( array( 'administrator', 'editor', 'author' ) as $user ) {
			  $role = get_role( $user );
			  // read events
			  $role->add_cap( 'read_wgobd_event' );
			  // edit events
			  $role->add_cap( 'edit_wgobd_event' );
			  $role->add_cap( 'edit_wgobd_events' );
			  $role->add_cap( 'edit_others_wgobd_events' );
			  $role->add_cap( 'edit_private_wgobd_events' );
			  $role->add_cap( 'edit_published_wgobd_events' );
			  // delete events
			  $role->add_cap( 'delete_wgobd_event' );
			  $role->add_cap( 'delete_wgobd_events' );
			  $role->add_cap( 'delete_others_wgobd_events' );
			  $role->add_cap( 'delete_published_wgobd_events' );
			  $role->add_cap( 'delete_private_wgobd_events' );
			  // publish events
			  $role->add_cap( 'publish_wgobd_events' );
			  // read private events
			  $role->add_cap( 'read_private_wgobd_events' );
			}

			// add event managing capability to contributors
			$role = get_role( 'wgobd_event_assistant' );
			$role->add_cap( 'edit_wgobd_events' );
			$role->add_cap( 'delete_wgobd_event' );
			$role->add_cap( 'read' );
		}
		// ===============================
		// = labels for custom post type =
		// ===============================
		$labels = array(
			'name' 								=> _x( 'Events', 'Custom post type name', wgobd_PLUGIN_NAME ),
			'singular_name' 			=> _x( 'Event', 'Custom post type name (singular)', wgobd_PLUGIN_NAME ),
			'add_new'							=> __( 'Add New', wgobd_PLUGIN_NAME ),
			'add_new_item'				=> __( 'Add New Event', wgobd_PLUGIN_NAME ),
			'edit_item'						=> __( 'Edit Event', wgobd_PLUGIN_NAME ),
			'new_item'						=> __( 'New Event', wgobd_PLUGIN_NAME ),
			'view_item'						=> __( 'View Event', wgobd_PLUGIN_NAME ),
			'search_items'				=> __( 'Search Events', wgobd_PLUGIN_NAME ),
			'not_found'						=> __( 'No Events found', wgobd_PLUGIN_NAME ),
			'not_found_in_trash'	=> __( 'No Events found in Trash', wgobd_PLUGIN_NAME ),
			'parent_item_colon'		=> __( 'Parent Event', wgobd_PLUGIN_NAME ),
			'menu_name'						=> __( 'Events', wgobd_PLUGIN_NAME ),
			'all_items'						=> $this->get_all_items_name()
		);


		// ================================
		// = support for custom post type =
		// ================================
		$supports = array( 'title', 'editor', 'comments', 'custom-fields', 'thumbnail' );

		// =============================
		// = args for custom post type =
		// =============================
		$args = array(
			'labels'							=> $labels,
			'public' 							=> true,
	    'publicly_queryable' 	=> true,
	    'show_ui' 						=> true,
	    'show_in_menu' 				=> true,
	    'query_var' 					=> true,
	    'rewrite' 						=> true,
	    'capability_type'			=> array( 'wgobd_event', 'wgobd_events' ),
	    'capabilities'        => array(
	      'read_post'               => 'read_wgobd_event',
	      'edit_post'               => 'edit_wgobd_event',
        'edit_posts'              => 'edit_wgobd_events',
        'edit_others_posts'       => 'edit_others_wgobd_events',
        'edit_private_posts'      => 'edit_private_wgobd_events',
        'edit_published_posts'    => 'edit_published_wgobd_events',
        'delete_post'             => 'delete_wgobd_event',
        'delete_posts'            => 'delete_wgobd_events',
        'delete_others_posts'     => 'delete_others_wgobd_events',
        'delete_published_posts'  => 'delete_published_wgobd_events',
        'delete_private_posts'    => 'delete_private_wgobd_events',
        'publish_posts'           => 'publish_wgobd_events',
        'read_private_posts'      => 'read_private_wgobd_events' ),
	    'has_archive' 				=> true,
	    'hierarchical' 				=> false,
	    'menu_position' 			=> 5,
	    'supports'						=> $supports,
	    'exclude_from_search' => $wgobd_settings->exclude_from_search
		);

		// ========================================
		// = labels for event categories taxonomy =
		// ========================================
		$events_categories_labels = array(
			'name'					=> _x( 'Event Categories', 'Event categories taxonomy', wgobd_PLUGIN_NAME ),
			'singular_name'	=> _x( 'Event Category', 'Event categories taxonomy (singular)', wgobd_PLUGIN_NAME )
		);

		// ==================================
		// = labels for event tags taxonomy =
		// ==================================
		$events_tags_labels = array(
			'name'					=> _x( 'Event Tags', 'Event tags taxonomy', wgobd_PLUGIN_NAME ),
			'singular_name'	=> _x( 'Event Tag', 'Event tags taxonomy (singular)', wgobd_PLUGIN_NAME )
		);
		
		// ==================================
		// = labels for event feeds taxonomy =
		// ==================================
		$events_feeds_labels = array(
			'name'					=> _x( 'Event Feeds', 'Event feeds taxonomy', wgobd_PLUGIN_NAME ),
			'singular_name'	=> _x( 'Event Feed', 'Event feed taxonomy (singular)', wgobd_PLUGIN_NAME )
		);

		// ======================================
		// = args for event categories taxonomy =
		// ======================================
		$events_categories_args = array(
			'labels'				=> $events_categories_labels,
			'hierarchical'	=> true,
			'rewrite'				=> array( 'slug' => 'events_categories' ),
			'capabilities'	=> array(
				'manage_terms' => 'manage_categories',
    		'edit_terms'   => 'manage_categories',
    		'delete_terms' => 'manage_categories',
    		'assign_terms' => 'edit_wgobd_events'
			)
		);

		// ================================
		// = args for event tags taxonomy =
		// ================================
		$events_tags_args = array(
			'labels'				=> $events_tags_labels,
			'hierarchical'	=> false,
			'rewrite'				=> array( 'slug' => 'events_tags' ),
			'capabilities'	=> array(
				'manage_terms' => 'manage_categories',
    		'edit_terms'   => 'manage_categories',
    		'delete_terms' => 'manage_categories',
    		'assign_terms' => 'edit_wgobd_events'
			)
		);
		
		// ================================
		// = args for event feeds taxonomy =
		// ================================
		$events_feeds_args = array(
			'labels'				=> $events_feeds_labels,
			'hierarchical'	=> false,
			'rewrite'				=> array( 'slug' => 'events_feeds' ),
			'capabilities'	=> array(
				'manage_terms' => 'manage_categories',
    		'edit_terms'   => 'manage_categories',
    		'delete_terms' => 'manage_categories',
    		'assign_terms' => 'edit_wgobd_events'
			),
			'public'        => false // don't show taxonomy in admin UI
		);

		// ======================================
		// = register event categories taxonomy =
		// ======================================
		register_taxonomy( 'events_categories', array( wgobd_POST_TYPE ), $events_categories_args );

		// ================================
		// = register event tags taxonomy =
		// ================================
		register_taxonomy( 'events_tags', array( wgobd_POST_TYPE ), $events_tags_args );
		
		// ================================
		// = register event tags taxonomy =
		// ================================
		register_taxonomy( 'events_feeds', array( wgobd_POST_TYPE ), $events_feeds_args );

		// ========================================
		// = register custom post type for events =
		// ========================================
		register_post_type( wgobd_POST_TYPE, $args );
	}

	/**
	 * taxonomy_filter_restrict_manage_posts function
	 *
	 * Adds filter dropdowns for event categories and event tags
	 *
	 * @return void
	 **/
	function taxonomy_filter_restrict_manage_posts() {
		global $typenow;

		// =============================================
		// = add the dropdowns only on the events page =
		// =============================================
		if( $typenow == wgobd_POST_TYPE ) {
			$filters = get_object_taxonomies( $typenow );
			foreach( $filters as $tax_slug ) {
				$tax_obj = get_taxonomy( $tax_slug );
				wp_dropdown_categories( array(
					'show_option_all'	=> __( 'Show All ', wgobd_PLUGIN_NAME ) . $tax_obj->label,
					'taxonomy'				=> $tax_slug,
          'name'						=> $tax_obj->name,
          'orderby'					=> 'name',
          'selected'				=> isset( $_GET[$tax_slug] ) ? $_GET[$tax_slug] : '',
          'hierarchical'		=> $tax_obj->hierarchical,
          'show_count'			=> true,
          'hide_if_empty'   => true
				));
			}
		}
	}

	/**
	 * get_all_items_name function
	 *
	 * If current user can publish events and there
	 * is at least 1 event pending, append the pending
	 * events number to the menu
	 *
	 * @return string
	 **/
	function get_all_items_name() {

	  // if current user can publish events
	  if( current_user_can( 'publish_wgobd_events' ) ) {
	    // get all pending events
	    $query = new WP_Query(  array ( 'post_type' => 'wgobd_event', 'post_status' => 'pending', 'posts_per_page' => -1,  ) );

	    // at least 1 pending event?
      if( $query->post_count > 0 ) {
        // append the pending events number to the menu
        return sprintf( __( 'All Events <span class="update-plugins count-%d" title="%d Pending Events"><span class="update-count">%d</span></span>', wgobd_PLUGIN_NAME ),
  	                    $query->post_count, $query->post_count, $query->post_count );
      }
    }

	  // no pending events, or the user doesn't have sufficient capabilities
	  return __( 'All Events', wgobd_PLUGIN_NAME );
	}

	/**
	 * taxonomy_filter_post_type_request function
	 *
	 * Adds filtering of events list by event tags and event categories
	 *
	 * @return void
	 **/
	function taxonomy_filter_post_type_request( $query ) {
		global $pagenow, $typenow;
		if( 'edit.php' == $pagenow ) {
			$filters = get_object_taxonomies( $typenow );
			foreach( $filters as $tax_slug ) {
				$var = &$query->query_vars[$tax_slug];
				if( isset( $var ) ) {
				  $term = null;

				  if( is_numeric( $var ) )
					  $term = get_term_by( 'id', $var, $tax_slug );
					else
					  $term = get_term_by( 'slug', $var, $tax_slug );

					if( isset( $term->slug ) ) {
						$var = $term->slug;
					}
				}
			}
		}
		// ===========================
		// = Order by Event date ASC =
		// ===========================
		if( $typenow == 'wgobd_event' ) {
			if( ! array_key_exists( 'orderby', $query->query_vars ) ) {
				$query->query_vars["orderby"] = 'wgobd_event_date';
				$query->query_vars["order"] 	= 'desc';
			}
		}

	}

	/**
	 * orderby function
	 *
	 * Orders events by event date
	 *
	 * @param string $orderby Orderby sql
	 * @param object $wp_query
	 *
	 * @return void
	 **/
	function orderby( $orderby, $wp_query ) {
		global $typenow, $wpdb, $post;

		if( $typenow == 'wgobd_event' ) {
			$wp_query->query = wp_parse_args( $wp_query->query );
			$table_name = $wpdb->prefix . 'wgobd_events';
			if( 'wgobd_event_date' == @$wp_query->query['orderby'] ) {
				$orderby = "(SELECT start FROM {$table_name} WHERE post_id =  $wpdb->posts.ID) " . $wp_query->get('order');
			} else if( empty( $wp_query->query['orderby'] ) ) {
				$orderby = "(SELECT start FROM {$table_name} WHERE post_id =  $wpdb->posts.ID) " . 'desc';
			}
		}
		return $orderby;
	}

	/**
	 * add_meta_boxes function
	 *
	 * Display event meta_box when creating or editing an event
	 *
	 * @return void
	 **/
	function add_meta_boxes() {
		global $wgobd_events_controller;
		add_meta_box(
		        wgobd_POST_TYPE,
		        __( 'Event Details', wgobd_PLUGIN_NAME ),
		        array( &$wgobd_events_controller, 'meta_box_view' ),
		        wgobd_POST_TYPE
		    );
	}
	
	/**
	 * screen_layout_columns function
	 *
	 * Since WordPress 2.8 we have to tell, that we support 2 columns!
	 *
	 * @return void
	 **/
	function screen_layout_columns( $columns, $screen ) {
		global $wgobd_settings;
    
		if( isset( $wgobd_settings->settings_page ) && $screen == $wgobd_settings->settings_page )
			$columns[$wgobd_settings->settings_page] = 2;

		return $columns;
	}

	/**
	 * change_columns function
	 *
	 * Adds Event date/time column to our custom post type
	 * and renames Date column to Post Date
	 *
	 * @param array $columns Existing columns
	 *
	 * @return array Updated columns array
	 **/
	function change_columns( $columns ) {
		$columns["date"] 							= __( 'Post Date', 			 wgobd_PLUGIN_NAME );
		$columns["wgobd_event_date"] 	= __( 'Event date/time', wgobd_PLUGIN_NAME );
		return $columns;
	}

	/**
	 * custom_columns function
	 *
	 * Adds content for custom columns
	 *
	 * @return void
	 **/
	function custom_columns( $column, $post_id ) {
		global $wgobd_events_helper;
		switch( $column ) {
			case 'wgobd_event_date':
				try {
					$e = new wgobd_Event( $post_id );
					echo $e->short_start_date . ' ' . $e->short_start_time . " - " . $e->short_end_date . ' ' .$e->short_end_time;
				} catch( Exception $e ) {
					// event wasn't found, output empty string
					echo "";
				}
				break;
		}
	}

	/**
	 * sortable_columns function
	 *
	 * Enable sorting of columns
	 *
	 * @return void
	 **/
	function sortable_columns( $columns ) {
		$columns["wgobd_event_date"] = 'wgobd_event_date';
		return $columns;
	}

	/**
	 * get_param function
	 *
	 * Tries to return the parameter from POST and GET
	 * incase it is missing, default value is returned
	 *
	 * @param string $param Parameter to return
	 * @param mixed $default Default value
	 *
	 * @return mixed
	 **/
	function get_param( $param, $default='' ) {
	  if( isset( $_POST[$param] ) )
	    return $_POST[$param];
	  if( isset( $_GET[$param] ) )
	    return $_GET[$param];
	  return $default;
  }

	/**
	 * get_param_delimiter_char function
	 *
	 * Returns the delimiter character in a link
	 *
	 * @param string $link Link to parse
	 *
	 * @return string
	 **/
  function get_param_delimiter_char( $link ) {
    return strpos( $link, '?' ) === false ? '?' : '&';
	}

  /**
	 * inject_categories function
	 *
	 * Displays event categories whenever post categories are requested
	 *
	 * @param array $terms Terms to be returned by get_terms()
	 * @param array $taxonomies Taxonomies requested in get_terms()
	 * @param array $args Args passed to get_terms()
	 *
	 * @return string|array If "category" taxonomy was requested, then returns
	 *                      $terms with fake category pointing to calendar page
	 *                      with its children being the event categories
	 **/
	function inject_categories( $terms, $taxonomies, $args )
	{
		global $wgobd_settings;

    if( in_array( 'category', $taxonomies ) )
    {
    	// Create fake calendar page category
    	$count_args = $args;
    	$count_args['fields'] = 'count';
    	$count = get_terms( 'events_categories', $count_args );
    	$post = get_post( $wgobd_settings->calendar_page_id );
    	switch( $args['fields'] )
    	{
    		case 'all':
		    	$calendar = (object) array(
			    	'term_id'     => wgobd_FAKE_CATEGORY_ID,
			    	'name'		    => $post->post_title,
			    	'slug'		    => $post->post_name,
			    	'taxonomy'    => 'events_categories',
			    	'description' => '',
			    	'parent'      => 0,
			    	'count'       => $count,
		    	);
		    	break;
	    	case 'ids':
	    		$calendar = 'wgobd_calendar';
	    		break;
    		case 'names':
	    		$calendar = $post->post_title;
	    		break;
    	}
    	$terms[] = $calendar;

    	if( $args['hierarchical'] ) {
    		$children = get_terms( 'events_categories', $args );
	    	foreach( $children as &$child ) {
	    		if( is_object( $child ) && $child->parent == 0 )
	    			$child->parent = wgobd_FAKE_CATEGORY_ID;
	 				$terms[] = $child;
	    	}
	    }
    }

    return $terms;
  }

  /**
   * function calendar_term_link
   *
   * Corrects the URL for the calendar page when injected into the post
   * categories.
   *
   * @param string $link The normally generated link
   * @param object $term The term that we're getting the link for
   * @param string $taxonomy The name of the taxonomy of interest
   *
   * @return string The correct link to the calendar page
   */
  function calendar_term_link( $link, $term, $taxonomy )
  {
  	global $wgobd_calendar_helper;

  	if( $taxonomy == 'events_categories' ) {
	  	if( $term->term_id == wgobd_FAKE_CATEGORY_ID )
	  		$link = $wgobd_calendar_helper->get_calendar_url( null );
	  	else
	  		$link = $wgobd_calendar_helper->get_calendar_url( null,
		  		array( 'cat_ids' => array( $term->term_id ) )
		  	);
	  }

  	return $link;
  }

  /**
   * function selected_category_link
   *
   * Corrects the output of wp_list_categories so that the currently viewed
   * event category (in calendar view) has the "active" CSS class applied to it.
   *
   * @param string $output The normally generated output of wp_list_categories()
   * @param object $args The args passed to wp_list_categories()
   *
   * @return string The corrected output
   */
  function selected_category_link( $output, $args )
  {
  	global $wgobd_calendar_controller, $wgobd_settings;

  	// First check if current page is calendar
  	if( is_page( $wgobd_settings->calendar_page_id ) )
  	{
	  	$cat_ids = array_filter( explode( ',', $wgobd_calendar_controller->get_requested_categories() ), 'is_numeric' );
	  	if( $cat_ids ) {
	  		// Mark each filtered event category link as selected
		  	foreach( $cat_ids as $cat_id ) {
		  		$output = str_replace(
			  		'class="cat-item cat-item-' . $cat_id . '"',
			  		'class="cat-item cat-item-' . $cat_id . ' current-cat current_page_item"',
			  		$output );
		  	}
		  	// Mark calendar page link as selected parent
		  	$output = str_replace(
			  	'class="cat-item cat-item-' . wgobd_FAKE_CATEGORY_ID . '"',
			  	'class="cat-item cat-item-' . wgobd_FAKE_CATEGORY_ID . ' current-cat-parent"',
			  	$output );
		  } else {
		  	// No categories filtered, so mark calendar page link as selected
		  	$output = str_replace(
			  	'class="cat-item cat-item-' . wgobd_FAKE_CATEGORY_ID . '"',
			  	'class="cat-item cat-item-' . wgobd_FAKE_CATEGORY_ID . ' current-cat current_page_item"',
			  	$output );
	  	}
	  }

  	return $output;
  }

  /**
   * admin_notices function
   *
   * Notify the user about anything special.
   *
   * @return void
   **/
  function admin_notices() {
    global $wgobd_view_helper,
           $wgobd_settings,
           $plugin_page;

		if( $wgobd_settings->show_data_notification ) {
			$args = array(
				'label'  => 'All-in-One Event Calendar Notice<br />',
				'msg'    => sprintf( 'We collect some basic information about how your calendar works in order to deliver a better ' .
				           'and faster calendar system and one that will help you promote your events even more.<br />' .
                   'You can find more detailed information by <a href="%s" target="_blank">clicking here &raquo;</a><br />' .
                   'You may opt-out from sending data to us by unchecking &quot;Allow The Seed to collect statistics&quot; checkbox located on plugin\'s <a href="%s">Settings page</a>',
									 'http://theseednetwork.com/all-in-one-event-calendar-privacy-policy/',
                   admin_url( 'edit.php?post_type=' . wgobd_POST_TYPE . '&page=' . wgobd_PLUGIN_NAME . '-settings' ) ),
				'button' => (object) array( 'class' => 'wgobd-dismiss-notification', 'value' => 'Dismiss' )
			);
			$wgobd_view_helper->display( 'admin_notices.php', $args );
		}

    // If calendar page ID has not been set, and we're not updating the settings
    // page, the calendar is not properly set up yet
    if( ! $wgobd_settings->calendar_page_id || ! get_option( 'timezone_string' ) && ! isset( $_REQUEST['wgobd_save_settings'] ) )
    {
    	$args = array();

    	// Display messages for blog admin
    	if( current_user_can( 'manage_options' ) ) {
	    	// If not on the settings page already, direct user there with a message
	    	if( $plugin_page == wgobd_PLUGIN_NAME . "-settings" ) {
	    	  if( ! $wgobd_settings->calendar_page_id && ! get_option( 'timezone_string' ) )
					  $args['msg'] = sprintf( __( '%sTo set up the plugin: %s 1. Select an option in the <strong>Calendar page</strong> dropdown list. %s 2. Select an option in the <strong>Timezone</strong> dropdown list. %s 3. Click <strong>Update Settings</strong>. %s', wgobd_PLUGIN_NAME ), '<br /><br />', '<ul><ol>', '</ol><ol>', '</ol><ol>', '</ol><ul>' );
					else if( ! $wgobd_settings->calendar_page_id )
					  $args['msg'] = __( 'To set up the plugin: Select an option in the <strong>Calendar page</strong> dropdown list, the click <strong>Update Settings</strong>.', wgobd_PLUGIN_NAME );
					else
					  $args['msg'] = __( 'To set up the plugin: Select an option in the <strong>Timezone</strong> dropdown list, the click <strong>Update Settings</strong>.', wgobd_PLUGIN_NAME );
				// Else instruct user as to what to do on the settings page
				} else {
		      $args['msg'] = sprintf(
			        __( 'The plugin is installed, but has not been configured. <a href="%s">Click here to set it up now &raquo;</a>', wgobd_PLUGIN_NAME ),
							admin_url( 'edit.php?post_type=' . wgobd_POST_TYPE . '&page=' . wgobd_PLUGIN_NAME . '-settings' )
						);
				}
			// Else display messages for other blog users
			} else {
				$args['msg'] = __( 'The plugin is installed, but has not been configured. Please log in as a WordPress Administrator to set it up.', wgobd_PLUGIN_NAME );
			}
			$args['label'] = __( 'All-in-One Event Calendar Notice:', wgobd_PLUGIN_NAME );
      $wgobd_view_helper->display( 'admin_notices.php', $args );
    }
	}
}
// END class
