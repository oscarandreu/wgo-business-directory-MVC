<label class="textinput" for="cron_freq">
  <?php _e( 'Auto-refresh', wgobd_PLUGIN_NAME ) ?>:
</label>
<?php echo $cron_freq ?>
<br class="clear" />

<div id="wgobd-feeds-after" class="wgobd-feed-container">
	<h4 class="wgobd_feed_h4"><?php _e( 'iCalendar/.ics Feed URL:', wgobd_PLUGIN_NAME ) ?></h4>
	<div class="wgobd-feed-url"><input type="text" name="wgobd_feed_url" id="wgobd_feed_url" /></div>
	<div class="wgobd-feed-category">
		<label for="wgobd_feed_category">
			<?php _e( 'Event category', wgobd_PLUGIN_NAME ); ?>:
		</label>
		<?php echo $event_categories; ?>
	</div>
	<div class="wgobd-feed-tags">
		<label for="wgobd_feed_tags">
			<?php _e( 'Tag with', wgobd_PLUGIN_NAME ); ?>:
		</label>
		<input type="text" name="wgobd_feed_tags" id="wgobd_feed_tags" />
	</div>
	<input type="button" id="wgobd_add_new_ics" class="button" value="<?php _e( '+ Add new subscription', wgobd_PLUGIN_NAME ) ?>" />
</div>

<?php echo $feed_rows; ?>
<br class="clear" />
