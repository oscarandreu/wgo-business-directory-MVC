<div class="wgobd-feed-container">
	<h4 class="wgobd_feed_h4">
		<?php _e( 'iCalendar/.ics Feed URL:', wgobd_PLUGIN_NAME ); ?>
	</h4>
	<div class="wgobd-feed-url"><input type="text" class="wgobd-feed-url" readonly="readonly" value="<?php echo esc_attr( $feed_url ) ?>" /></div>
	<input type="hidden" name="feed_id" class="wgobd_feed_id" value="<?php echo $feed_id;?>" />
	<?php if( $event_category ): ?>
		<div class="wgobd-feed-category">
			<?php _e( 'Event category:', wgobd_PLUGIN_NAME ); ?>
			<strong><?php echo $event_category; ?></strong>
		</div>
	<?php endif ?>
	<?php if( $tags ): ?>
		<div class="wgobd-feed-tags">
			<?php _e( 'Tag with', wgobd_PLUGIN_NAME ); ?>:
			<strong><?php echo $tags; ?></strong>
		</div>
	<?php endif ?>
	<input type="button" class="button wgobd_delete_ics" value="<?php _e( '× Delete', wgobd_PLUGIN_NAME ); ?>" />
	<input type="button" class="button wgobd_update_ics" value="<?php _e( 'Update', wgobd_PLUGIN_NAME ); ?>" />
	<?php if( $events ): ?>
		<input type="button" class="button wgobd_flush_ics" value="<?php printf( _n( 'Flush 1 event', 'Flush %s events', $events, wgobd_PLUGIN_NAME ), $events ) ?>" />
	<?php endif ?>
	<img src="images/wpspin_light.gif" class="ajax-loading" alt="" />
</div>
