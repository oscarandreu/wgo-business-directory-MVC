<?php if( $hide_maps_until_clicked ) : ?>
  <div class="wgobd-gmap-placeholder"><strong><?php _e( 'Click to view map', wgobd_PLUGIN_NAME ) ?></strong></div>
<?php endif; ?>
<div class="wgobd-gmap-container<?php echo $hide_maps_until_clicked ? ' wgobd-gmap-container-hidden' : '' ?>">
	<div id="wgobd-gmap-canvas"></div>
	<input type="hidden" id="wgobd-gmap-address" value="<?php echo esc_attr( $address ) ?>" />
	<a class="wgobd-gmap-link wgobd-button"
		href="<?php echo $gmap_url_link ?>" target="_blank">
		<?php _e( 'View Full-Size Map »', wgobd_PLUGIN_NAME ) ?>
	</a>
</div>
