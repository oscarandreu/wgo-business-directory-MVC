<div class="wgobd-excerpt">
	<div class="wgobd-time"><label class="wgobd-label"><?php _e( 'When:', wgobd_PLUGIN_NAME ) ?></label> <?php echo $event->timespan_html ?></div>
	<?php if( $location ): ?>
		<div class="wgobd-location"><label class="wgobd-label"><?php _e( 'Where:', wgobd_PLUGIN_NAME ) ?></label> <?php echo $location ?></div>
	<?php endif ?>
</div>
