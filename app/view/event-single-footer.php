<div class="wgobd-event-footer">
	<?php if( $event->ical_feed_url ): ?>
		<p class="wgobd-source-link">
			<?php echo sprintf( __( 'This post was replicated from another site\'s <a class="wgobd-ics-icon" href="%s" title="iCalendar feed">calendar feed</a>.' ),
				esc_attr( str_replace( 'http://', 'webcal://', $event->ical_feed_url ) ) ) ?>
			<?php if( $event->ical_source_url ): ?>
				<a href="<?php echo esc_attr( $event->ical_source_url ) ?>" target="_blank">
					<?php _e( 'View original post »', wgobd_PLUGIN_NAME ) ?>
				</a>
			<?php endif ?>
		</p>
	<?php endif ?>
</div>
